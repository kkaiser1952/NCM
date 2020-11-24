<?php
//date_default_timezone_set("America/Chicago");
require_once "dbConnectDtls.php";

	
	$term = $_GET['term']; //$term = 'WA0';
	
    $myHints = array();
	
$sql = "SELECT DISTINCT 
			callsign, CONCAT(Fname,' ',Lname) as name
  		  FROM NetLog 
  		  	INNER JOIN ( 
			    SELECT max(recordID) as recordID
			      FROM NetLog 
			     WHERE (callsign LIKE  '%$term%' OR Fname LIKE '%$term%' OR Lname LIKE '%$term%')
				   AND callsign NOT IN (' ','W0KCN','WA0QFJ','T0EST','K0ERC','NR0AD','TE0ST','CLAYCO','JACKSONARES', 'CREW2273', 'KC', 'FSQCALL', 'OTHER', 'MESN', 'CARROLL', 'PEDAL', 'PLATTE', 'JAXCOARES')
				   AND Fname    not like '%)%'
				   AND callsign not like '%)%'
				   AND callsign not like '%DMR%'
				   AND callsign not like '%POI%'
				   AND callsign not like '%Church%'
				   AND callsign not like '%STL%'
				   AND callsign not like '%TE0ST%'
				   AND callsign not like '%TEC%'
				   AND callsign not like '%BSA%'
			     GROUP BY callsign
  		  	) t1 on t1.recordID = NetLog.recordID";
  		  	
  		  	$results = array();
  		  	foreach($db_found->query($sql) as $row) {
  		  		array_push($results, array(
  		  				'label' => $row['callsign'], 
  		  				'desc' => $row['name'],
  		  				'value'  => $row['callsign']) );
			}
				echo json_encode($results);	  	
?>