<!doctype html>

<!-- From getVTimeLogTest2  on 2019-12-13 21:05 -->

<?php
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
    
	require_once "dbConnectDtls.php";	    
	
	//$q = intval($_GET['q']); 
	$q = 1720;
	
    
    $sql = "SELECT min(timestamp) AS start 
                  ,max(timestamp) AS end
                  ,count(DISTINCT callsign) AS rowcount  /* count of callsigns in this net */
                  
              FROM TimeLog 
             WHERE netID = $q
           ";
         
    $stmt = $db_found->prepare($sql);
    
    // Work with start time
    $stmt->execute();
    $start = $stmt->fetchColumn(0);
        $date = new \DateTime($start);
         $shr  = $date->format('H');
         $smin = $date->format('H:i');
         $ssec = strtotime($start); //echo "ssec: $ssec<br>";
	    
    // Work with end time
    $stmt->execute();
    $end   = $stmt->fetchColumn(1);
        $date = new \DateTime($end);
         $ehr  = $date->format('H');
         $emin = $date->format('H:i');
         $esec = strtotime($end);
         
    // Count the number of stations
    $stmt->execute();
	    $rowcount   = $stmt->fetchColumn(2);
	    
    // Calculate total time in minutes spent on net
    $totime = (strtotime($end) - strtotime($start))/60;
    
    echo "Net: $q <br>
          Start: $start <br>
          End: $end <br>
          <br><br>
         ";
    
    $sql = "SELECT id,
                    (CASE 
                        WHEN callsign = ' ' THEN 'GENCOMM'
                        ELSE callsign
                     END) AS callsign,
                    (CASE 
                        WHEN callsign = ' ' THEN 0
                        WHEN callsign = 'GENCOMM' THEN 1
                        ELSE 2
                     END) AS sortorder,
                   COUNT(timestamp) AS COUNT_OF_TIMESTAMP,
	               GROUP_CONCAT(timestamp SEPARATOR '~') AS times,
                   GROUP_CONCAT(CONCAT(SECOND(timestamp),':',comment) SEPARATOR '~') AS `comments`
              FROM TimeLog
             WHERE netID = $q
             GROUP BY callsign
             ORDER BY timestamp, callsign
           "; 
                          
           $tdclass = ''; // class values

           
           // The first row is the time line, container & content div's help with scrolling
           $dyn_table = '<div id="container">   
                            <div id="content">
                                <table border = "1" cellpadding="5">
                                    <tr><th></th>'; // required 
           
                $xy = 0; // A temp column counter, also used to create class variables for the header
           
           // Add a row with each minute of the log as a column heading
           for ($t=$ssec; $t<=$esec; $t+=60){  // every 1 minutes 
               // The sprintf prepends a zero if minutes are single digit 0, 1, 2, etc
                $e = $xy.' / '. idate("H",$t).":".sprintf("%02d",idate("i",$t));
                $dyn_table .= '<th class="h'.$xy.'">'.$e.'</th>'; // e is the formatted value of hour:minute
                $xy = $xy+1; // This is the counter in front of the time on the header
           }
                $dyn_table .= '</tr>';              // End the row of hour:minute
           // End of adding the times to the first row
                 
        // Add a column titled for each minute cell needed by the net          
        foreach($db_found->query($sql) as $row) {
            $id       = $row[id];  // not used at this time 
            $callsign = $row[callsign];              
            $times    = $row[times];
                $tt = explode('~',$times);          
            $count    = substr_count($times,'~');   // tildie as seperator, less issues than comma
            $comment  = $row[comments];
                $cc = explode('~',$comment);       // echo "$callsign === $tt[0], $cc[0] /// $tt[1], $cc[1]<br>";            
                    
            // This continues the table building
            $dyn_table .= '<tr><td style="font-weight: bold" class="headcol">'.$callsign.'</td>';
                        
            // This finds $kk, the specific column a comment belongs to, 75 means 75 minutes into the net
            for ($k = 0; $k <= $count; $k++) {
                 $kk = round($totime-(strtotime($end) - strtotime($tt[$k]))/60); // which cell, kk = 4
                 
          //       echo "$count $callsign $kk <br>";
                 
          /*       $rr = round($totime-strtotime($end));
                 $ss = strtotime($tt[$k])/60;
                 
                 echo ($callsign."<br> rr: ". $rr. "<br>totime: ".$totime);
                 echo ("<br>ss: ". $ss. "<br>");
                 echo ("KK: ". $kk. "<br><br>");
           */      
                 // find the cell for specail css
                 $IL = stripos($cc[$k], 'Initial log In');
                 $ON = stripos($cc[$k], 'Opened the net from');
                 $LRO = stripos($cc[$k], 'The log was re-opened');
                 $LC = stripos($cc[$k], 'The log was closed');
                 $RC = stripos($cc[$k], 'Role Changed to');
                 $MS = stripos($cc[$k], 'Mode set to');
                 $SC1 = stripos($cc[$k], 'Status change: In');
                 $SC2 = stripos($cc[$k], 'Status change: Out');
                 $SC3 = stripos($cc[$k], 'Status change: In-Out');
                 $SC4 = stripos($cc[$k], 'Status change: BRB');
                 $SC5 = stripos($cc[$k], 'Status change: Assigned');
                 $SC6 = stripos($cc[$k], 'Status change: MISSING');
                 $SC7 = stripos($cc[$k], 'Status change: Enroute');
                 $TS1 = stripos($cc[$k], 'Traffic set to: Routine');
                 $FLI = stripos($cc[$k], 'First Log In');
                 $NFC = stripos($cc[$k], 'No FCC Record');
                      
                // For each Callsign this attempts to fill the individual cells with the appropriate comment
                for ($c=0; $c<=$kk; $c++) {
                    if ($c == $kk) { // The test, they must be equal to output dyn_table
                        
                        // This routine sets the background colors
                        if ($kk = $IL | $kk = $ON | $kk = $LRO) {$tdclass = "green";}
                        if ($kk = $LC) {$tdclass = "black";} 
                            
                        if ($kk = $SC1) {$tdclass = "green";}
                        if ($kk = $SC2) {$tdclass = "cacaca";} // light grey 
                        if ($kk = $SC3) {$tdclass = "cacaca";}
                        if ($kk = $SC4) {$tdclass = "cacaca";}
                        if ($kk = $SC5) {$tdclass = "yellow";}
                        if ($kk = $SC6) {$tdclass = "red";}
                        if ($kk = $SC7) {$tdclass = "yellow";}
                            
                        if ($kk = $RC) {$tdclass = "blue";}
                        if ($kk = $MS) {$tdclass = "befdfc";}
                        if ($kk = $NFC) {$tdclass = "pink";}
                        
                                           // the seconds in front of the comment is added in the MySQL
                        $dyn_table .= '<td class='.$tdclass.'>'.$cc[$k].' c/k:'.$c.'<br>';
                          
                        $tdclass = ""; // Reset the class of this cell
                        
                    } else {
                        $dyn_table .= '<td class="white">'; // Begins an empty cell 
                    }    
                }  // End the second for loop   
                 
                 $dyn_table .= '</td>'; // Close the cell/column
                 
            } // End the first for loop 
        
        } // Close the foreach
        $dyn_table .= '</tr></table></div></div>'; // Close the row and the table
?>

<html lang="en">
    
<head>
<title>Amateur Radio Net Control Manager Net Visual Time Line</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0" > 

<meta name="description" content="Amateur Radio Net Control Manager" >
<meta name="author" content="Keith Kaiser, WA0TJT" >

<meta name="Rating" content="General" >
<meta name="Revisit" content="1 month" >
<meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager, Time Line" >


<style>
    
.h0 {
    color:blue;
}
    
table {
  border-collapse: separate;
  border-spacing: 0;
  border-top: 1px solid grey;
}

th{
  margin: 0;
  border: 1px solid grey;
  white-space: nowrap; 
  border-top-width: 0px;
}

td, th {
    max-width: 125px;
    overflow: hidden;  /* Prevents bleed through to the next <td> */
}

td:hover {
    max-width: 100%;
    
  /*  display:block;  don't use this it causes issues */ 
}

.headcol {
  position: absolute; 
  width: 5em; 
  left: 0;
  top: auto;
  border-top-width: 1px;
  margin-top: -1px;
}

.white {
    background-color: white;
    color:black;
}
.green {
    background-color: green;
    color:white;
    font-weight: bold;
}
.red {
    background-color: red;
    color:white;
}
.blue {
    background-color: blue;
    color:white;
}

.black {
    background-color: black;
    color:white;
}

.yellow {
    background-color: yellow;
    color:black;
}

.cacaca {
    background-color: #cacaca;
}

.befdfc {
    background-color: #befdfc;
}


.pink {
    background-color: pink;
}

#container {
    border: 1px solid #ccc; 
    overflow: scroll; 
    width: 100%;
    margin-left: 6em;
    overflow-y: visible;
    padding: 0;
}
#content { 
    width: 1500%;
    white-space: nowrap;
}

#left {
    width:60px;
    overflow:hidden;
    display:block;
    background:rgba(204, 204, 204, 0.5); 
    height:200px;
    float:left; 
    clear:none; 
    position:fixed; 
    z-index:2;}

#right {
    width:60px;
    overflow:hidden;
    display:block;
    background:rgba(204, 204, 204, 0.5); 
    height:200px;
 
    clear:none;
    right: 0;
    position:fixed;
    z-index:2;}
    

</style>


</head>

<body>

    <?php echo $dyn_table; ?>

<!--
    <button id="left" type="button">left</button>
    <button id="right" type="button">right</button>  -->
    <button id="slideBack" type="button">Prev</button>
    <button id="slide" type="button">Next</button>
    

<!-- slide back and forth http://jsfiddle.net/onejdc/swQ7J/4/ -->

<!-- jquery updated from 3.3.1 to 3.4.1 on 2019-11-14 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    $( "th" ).last().css({backgroundColor:"red", color:"white"});
   // $( "td" ).last().css({border-left: "1px solid red"});
    
    var button = document.getElementById('slide');
        button.onclick = function () {
            var container = document.getElementById('container');
            sideScroll(container,'right',25,100,10);
        };

    var back = document.getElementById('slideBack');
    back.onclick = function () {
        var container = document.getElementById('container');
        sideScroll(container,'left',25,100,10);
    };

    function sideScroll(element,direction,speed,distance,step){
        scrollAmount = 0;
        var slideTimer = setInterval(function(){
            if(direction == 'left'){
                element.scrollLeft -= step;
            } else {
                element.scrollLeft += step;
            }
            scrollAmount += step;
            if(scrollAmount >= distance){
                window.clearInterval(slideTimer);
            }
        }, speed);
    }
      
</script>

</body>
</html>