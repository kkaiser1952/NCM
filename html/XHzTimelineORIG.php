<!doctype html>
<!— Look in downloads for: jquery-2.timeline-master  a newer version —> 


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
    
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
    <!-- =============== All above this should not be editied ====================== -->
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 -->
	
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 -->
	<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1/jquery-ui.min.css" >	
    
    <!-- ============ Time Line Project =========== -->
    <link rel="stylesheet" href="js/jquery-2.timeline-master/dist/jquery.timeline.min.css">
    <link rel="stylesheet" type="text/css" href="css/HzTimeline.css">
      
<style>

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


$sql = ("
    SELECT 
        callsign, 
        date_format(timestamp,'%i') as mn,
        CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
            FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0)) AS hrmn,
    
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
         END as com
                    
           
      FROM TimeLog
     WHERE netID = 3646
       AND callsign <> 'WEATHER'
       AND callsign <> 'GENCOMM'
     GROUP BY timestamp
     ORDER BY hrmn ASC ");
     
     
     $listparts ='';
     $listparts2 ='';
     $dupmns = array();
     foreach($db_found->query($sql) as $row) {
         if(!in_array("$row[hrmn]", $dupmns)) { $dupmns[] .= "$row[hrmn]"; } 
            $hrmnlong = count($dupmns); //echo "hrmnlong= $hrmnlong<br>";
         
         $listparts1 .= '<li><span class="hrmn" >'.$row[hrmn].'</span><ul class="content">';
                
        for ( $i = $hrmnlong; $i < $hrmnlong; ++$i ) {
            $listparts2 .= '<li>'.$row[mn].':'.$row[callsign].' > '.$row[com].'</li>';
        }
      
            $listparts2 .= "</ul></li>";
            $listparts3 = "$listparts1 $listparts2"; 
     } // end foreach
     
   echo "$listparts3";
     
     // echo "final: $row[callsign] $row[hrmn] >> ".count($dupmns)."<br>";
 //print_r($dupmns); //Array ( [0] => 00:50 [1] => 01:00 [2] => 01:05 [3] => 01:10 [4] => 01:15 [5] => 01:20 [6] => 01:25 [7] => 01:30 [8] => 01:35 )
    
?>

</head>

<body translate="no" >

  <div class="container">
      <ul class="timeline">
          <?php echo "$listparts3" ?>
      </ul>
 
 <!--         
     
<li><span class="hrmn" >00:50</span>
<ul class="content"> 
<li>50:K0KEX > OPENED</li> 
</ul>
</li>

<li><span class="hrmn" >01:00</span>
<ul class="content"> 
<li>50:K0KEX > OPENED</li>
<li>02:N0BKE > ILI</li>
<li>02:N0BKE > ILI</li>
</ul>
</li>    
        
        <li><span class="hrmn">1905</span>
          <ul class="content">
            <li>START OF NET</li>
            <li>WA0TJT</li>
            <li>W0DLK</li>
            <li>K0KEX</li>
            <li>WA0JSB</li>
            <li>W0GPS</li>
            <li>K0KEX</li>
            <li>WA0TJT</li>
            <li>W0DLK</li>
            <li>K0KEX</li>
          </ul>
        </li>
        <li><span class="hrmn">1905</span>
          <ul class="content">
            <li>2009-1</li>
            <li>2009-2</li>
            <li>2009-3</li>
          </ul>
        </li>
        <li><span class="hrmn">1910</span>
          <ul class="content">
            <li>2010-1</li>
            <li>2010-2</li>
            <li>2010-3</li>
          </ul>
        </li>
        <li><span class="hrmn">1915</span>
          <ul class="content">
            <li>2011-1</li>
            <li>2011-2</li>
            <li>2011-3</li>
            <li>officia aliquid minima enim eaque quam!</li>
          </ul>
        </li>
        <li><span class="hrmn">1920</span>
          <ul class="content">
            <li>2012-1</li>
            <li>2012-2</li>
            <li>2012-3</li>
          </ul>
        </li>
        <li><span class="hrmn">2013</span>
          <ul class="content">
            <li>2013-1</li>
            <li>2013-2</li>
            <li>2013-3</li>
          </ul>
        </li>
        <li><span class="hrmn">2014</span>
          <ul class="content">
            <li>2014-1</li>
            <li>2014-2</li>
            <li>2014-3</li>
          </ul>
        </li>
        <li><span class="hrmn">2015</span>
          <ul class="content">
            <li>2015-1</li>
            <li>2015-2</li>
            <li>2015-3</li>
          </ul>
        </li>
        <li><span class="hrmn">2016</span>
          <ul class="content">
            
            <li>WA0TJT</li>
            <li>W0DLK</li>
            <li>K0KEX</li>
            <li>WA0JSB</li>
            <li>W0GPS</li>
            <li>K0KEX</li>
            <li>WA0TJT</li>
            <li>W0DLK</li>
            <li>K0KEX</li>
            <li>END OF NET</li>
          </ul>
        </li>
        -->
    <!--    <li><span class="hrmn new">Sustained Growth</span></li> -->
      
</div>
   
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  
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