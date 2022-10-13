<?php

require_once "dbConnectDtls.php";

    // the term and netcall come from NetManager=p2.js @ gethint.php    
	
	$term = $_GET['term'];
	$netc = $_GET['nc'];
	
	//$term = '0tjt';
	//$netc = 'mesn';
	
	$nc = explode(' ', trim($netc));
	$netcall = $nc[0];
	
	$term = str_replace(' ','', $term); 
	 		  	/* added district: 2022-10-17 */
$sql = "SELECT a.callsign, CONCAT(a.Fname,' ',a.Lname,' --> ',a.state,'--',a.county,'  ',a.district) as name
          FROM stations a
              ,NetLog   b
         WHERE a.active_call = 'y' 
           AND a.callsign = b.callsign
           AND b.netcall LIKE '%$netcall%'
           AND b.logdate < b.logdate <= NOW() - INTERVAL 90 DAY
           AND (a.callsign LIKE '%$term%' OR a.Fname LIKE '%$term%' OR a.Lname LIKE '%$term%' )
            OR (CONCAT(a.Fname,a.Lname) LIKE '%$term%')
         GROUP BY b.callsign
         limit 10
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
