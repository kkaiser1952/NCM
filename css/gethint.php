<?php
//date_default_timezone_set("America/Chicago");
require_once "dbConnectDtls.php";

	
	$term = $_GET['term']; //$term = 'WA0';
	
    $myHints = array();
/*
$sql = "SELECT  
			callsign, CONCAT(Fname,' ',Lname) as name
  		  FROM NetLog 
  		  	INNER JOIN ( 
			    SELECT max(recordID) as recordID 
			      FROM NetLog 
			     WHERE (callsign LIKE  '%%SXY%' OR Fname LIKE '%%SXY%' OR Lname LIKE '%%SXY%')
			       AND netID <> 0
				   AND callsign NOT IN (' ','W0KCN','WA0QFJ','T0EST','K0ERC','NR0AD','TE0ST','CLAYCO','JACKSONARES', 'CREW2273', 'KC', 'FSQCALL', 'OTHER', 'MESN', 'CARROLL', 'PEDAL', 'PLATTE', 'JAXCOARES')
				   AND Fname    not like '%)%'
				   AND callsign not like '%)%'
		
				   AND callsign not like '%TE0ST%'
		
			     GROUP BY callsign
  		  	) t1 on t1.recordID = NetLog.recordID"; 
 */ 		  	
$sql = "SELECT callsign, CONCAT(Fname,' ',Lname) as name
          FROM stations 
         WHERE (callsign LIKE '%$term%' OR Fname LIKE '%$term%' OR Lname LIKE '%$term%')
           AND active_call = 'y'
         GROUP BY callsign
       "; 
  		  	
  		  	$results = array();
  		  	foreach($db_found->query($sql) as $row) {
  		  		array_push($results, array(
  		  				'label' => $row['callsign'], 
  		  				'desc' => $row['name'],
  		  				'value'  => $row['callsign']) );
			}
				echo json_encode($results);	  	
?>