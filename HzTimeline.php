<!doctype html>

<!-- READ ME: 
        If you get an error running part of this, first look to see if the temp_hmn table already exists. 
        You have to delete it, see the DELETE IF EXISTS stuff below the SQL.
        
     BASED ON:
        https://codepen.io/xichen/pen/pwYvgP
-->


<html lang="en">
<head>
    <meta charset = "UTF-8" />
    
    <title>Amateur Radio Net Control Manager</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" > 

    <meta name="description" content="Amateur Radio Net Control Manager" >
    <meta name="author" content="Keith Kaiser, WA0TJT" >
    
    <meta name="Rating" content="General" >
    <meta name="Revisit" content="1 month" >
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager" >
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
    <!-- =============== All above this should not be editied ====================== -->
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 -->
	
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 -->
	<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1/jquery-ui.min.css" >	
    
    <!-- ============ Time Line Project =========== -->
 <!--   <link rel="stylesheet" href="js/jquery-2.timeline-master/dist/jquery.timeline.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/HzTimeline.css">
      
<style>
    .title {
        position: absolute;
        top: 35px;
        left: 50px;
        font-size: 20pt;
        color: red;
    }

    .container {
    /*    width: 100%;
        overflow-x: auto;
        white-space: nowrap; 
        */
    }
    
</style>

<script>
  window.console = window.console || function(t) {};

  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>

<?php
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
     $netID = intval( $_GET["NetID"] );   //$q = 2916;
     //$netID = 10032;
    
// Get some net info
$sql = ("
    SELECT activity, frequency, netcall, DATE(logdate)
      FROM NetLog
     WHERE netID = :netId
     LIMIT 0,1 
");    

    // prepared statments
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':netId', $netID, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the results as an associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
    	$$activity = $row['activity'];
        $frequency = $row['frequency'];
        $netcall = $row['netcall'];
        $dateofit = $row['DATE(logdate)'];
        
        //echo 'act: ' . $activity . ' frq: ' . $frequency . ' net: ' . $netcall . ' dat: ' . $dateofit;
} else {
    echo "No rows found.";
}

    //echo "before $netID";
// Count how many unique minute by grouped minutes
$sql = (" 
    
    DROP TABLE IF EXISTS ncm.temp_hrmn;
    
    CREATE TABLE ncm.temp_hrmn    

    SELECT  CONCAT(date_format(timestamp,'%m/%d/%y')) AS ymdx,
    
            CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
                FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0)) AS hrmn,
                    
            COUNT(CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
                FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0))) AS hrmncount,
           
            timestamp
           
      FROM TimeLog
     WHERE netID = $netID AND callsign NOT LIKE '%genc%' AND callsign NOT LIKE '%weather%'
     GROUP BY CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
                FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0)) 
             
");
    //$stmt = $db_found->prepare($sql);
    //$stmt->bindParam(':netId', $q, PDO::PARAM_INT);
    //$stmt->execute();
    
    // Fetch the results as an associative array
    //$row = $stmt->fetch(PDO::FETCH_ASSOC);

$db_found->exec($sql);


/* Get the number of 5 minute intervals from the temp table above */
$sql = $db_found->prepare(" SELECT COUNT(*) as cntr FROM ncm.temp_hrmn ");
   $sql->execute();
   $result = $sql->fetch();
    
        $rowcount = $result[0];  
            if ($rowcount <= 4 ) {$mfactor = 135; }
              //  else if ($rowcount == 5 || $rowcount == 6 ) {mfactor = 100;}
                else if ($rowcount <= 5 ) {$mfactor = 100; }
                else if ($rowcount = 6  ) {$mfactor = 65; }
                else if ($rowcount = 7  ) {$mfactor = 46; }
                else if ($rowcount = 8  ) {$mfactor = 30; }
                else if ($rowcount = 9  ) {$mfactor = 20; }
                else if ($rowcount >9   ) {$mfactor = 10; }
        $callwidth = ($rowcount * $mfactor)."px";
            //echo "::  $rowcount $mfactor  $callwidth";

$sql = "
    SELECT 
        callsign,
     
        CONCAT(date_format(a.timestamp,'%H'),':',LPAD(MINUTE(
        FROM_UNIXTIME(FLOOR(UNIX_timestamp(a.timestamp)/300)*300)),2,0)) AS a_hrmn,
        
        b.hrmn as b_hrmn,
     
        CONCAT('<li style=\" width: $callwidth\" >',date_format(a.timestamp,'%i'), ':', callsign,' > ',
         CASE 
			WHEN comment = 'Initial Log In' THEN 'Log In'
            WHEN comment = 'First Log In'   THEN 'First Log'
            WHEN comment = 'No FCC Record'  THEN 'No FCC'
            WHEN comment LIKE '%Role Changed%' THEN CONCAT('Roll:',
                                                           SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%Status Change%' THEN CONCAT('Status:',SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%County Change%' THEN CONCAT( 'County:',
                                                            SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%Traffic set%' THEN CONCAT( 'Traffic:',
                                                            SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%The Call%'  THEN 'Deleted'
            WHEN comment LIKE '%Opened the net%' THEN 'OPENED'
            WHEN comment LIKE '%The log was closed%' THEN 'CLOSED'
            ELSE comment
         END, '</li>') as combo,
         
         /* this code replaces the ul.timeline > li in the CSS */
        CONCAT('<li style=\" width: calc( 100% /  $rowcount );\"><span class=\"hrmn\">',
            CONCAT(date_format(a.timestamp,\"%H\"),':',LPAD(MINUTE(
            FROM_UNIXTIME(FLOOR(UNIX_timestamp(a.timestamp)/300)*300)),2,0)),
            '</span><ul class=\"content\">') as firstlist,
            
        b.timestamp as starttime

      FROM TimeLog a
          ,temp_hrmn b
     WHERE netID = $netID 
       AND callsign NOT LIKE '%genc%' 
       AND callsign NOT LIKE '%weather%'
       AND b.hrmn = CONCAT(date_format(a.timestamp,'%H'),':',LPAD(MINUTE(
        FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(a.timestamp)/300)*300)),2,0))
     
     GROUP BY combo
     ORDER BY a.uniqueID  ";
     
     $tmpArray = array();
     $rowno = 0;
?>

</head>

<body translate="no" >
    
    <div class="title" style="color:blue;"> 
        <?php echo "$netcall $dateofit: $activity net #$netID on:   $frequency" ?> 
        <br><h4>You may have to scroll down to see the results.</h4>
    </div>

  <div class="container">
      <ul class="timeline">  
               
          <?php foreach($db_found->query($sql) as $row) {
                    $rowno = $rowno + 1;
                    if (!in_array ("$row[b_hrmn]",$tmpArray))  {
                        $tmpArray[] .= "$row[b_hrmn]";
                        if ($rowno <> 1 ) {
                            echo "</ul></li>$row[firstlist]";   
                        } else {echo "$row[firstlist]";}           
                    } 
                        echo "$row[combo]";
                        
                }; // end foreach 
                
                //echo "<li><span class='hrmn'>END</span></li>";
                
                 $sql = ("DROP TEMPORARY TABLE IF EXISTS ncm.temp_hrmn");
                 $db_found->exec($sql);
                 
          ?>
       
      </ul>
      
  </div>
  
  <p>HzTimeline.php</p>
  

<script>

    window.onload = function() {
        var stuff = ('.hrmn').css('background');
        //alert("stuff= " stuff);
        alert("in the function");
    };

</script>
  
<script id="rendered-js" >
    (function() {
        $(window).on('load resize', function() {
            if ($(this).width() < 767) {  
                return $('.timeline > li').css('margin-top', '');
            } else {
                return $('.timeline > li').css('margin-top', $('.timeline > li').height());
            }
    });

}).call(this);

</script>
  

</body>
</html>