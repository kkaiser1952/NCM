<?php

require_once "dbConnectDtls.php";

    // the term and netcall come from NetManager-p2.js @ gethint.php    
	
	$term = $_GET['term'];
	$netc = $_GET['nc'];
	
	//$term = 'dlk';
	//$netc = 'te0st';
	
	//$nc = explode(' ', trim($netc));
	//$netcall = $nc[0];
	
	$term = str_replace(' ','', $term); 
	
	//echo ("term: $term <br> netc: $netc <br> netcall: $netcall");
	
	 		  	/* added district: 2022-10-17 */
$sql = "SELECT a.callsign, CONCAT(a.Fname,' ',a.Lname,' --> ',a.state,' ',a.county,'  ',a.district) as name
          FROM stations a
              ,NetLog   b
         WHERE a.active_call = 'y' 
           AND a.callsign = b.callsign
           AND b.netcall LIKE '%$netc%'
           AND b.logdate < b.logdate <= NOW() - INTERVAL 60 DAY
           
           AND (a.callsign LIKE '%$term%' OR a.Fname LIKE '%$term%' OR a.Lname LIKE '%$term%' )
    
         GROUP BY b.callsign
       
       "; 
  		  	
  		  	$results = array(); // setup the array
  		  	
  		  	foreach($db_found->query($sql) as $row) {
      		  	// get rid of null values, in second thought don't, it might be correct
      		  //	if ($row['name'] <> '') {
      		  		array_push($results, array(
      		  				'label' => $row['callsign'], 
      		  				'desc' => $row['name'],
      		  				'value'  => $row['callsign']
      		  				));
  		  	//	} // end null test
			} // end foreach loop	
			   			
			    // write the results array to the hints
				echo json_encode($results);	  	
?>
