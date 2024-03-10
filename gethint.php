<?php
//date_default_timezone_set("America/Chicago");
require_once "dbConnectDtls.php";

	
	$term = $_GET['term'];
	//$term = 'keit';
	
	$term = str_replace(' ','', $term); 
	 		  	// ,' --> ',state,'--',county,'--',district
$sql = "SELECT callsign, CONCAT(Fname,' ',Lname,' --> ',state,'--',county) as name
          FROM stations 
         WHERE active_call = 'y' 
           AND (callsign LIKE '%$term%' OR Fname LIKE '%$term%' OR Lname LIKE '%$term%' )
            OR (CONCAT(Fname,Lname) LIKE '%$term%')
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