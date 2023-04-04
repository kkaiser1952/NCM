<?php

require_once "dbConnectDtls.php";

    // the term and netcall come from NetManager-p2.js @ gethint.php    
	
	$term = $_GET['term'];
	$netc = $_GET['nc'];
	
	$term = 'tjt';
	$netc = 'TE0ST';
	
	//$nc = explode(' ', trim($netc));
	//$netcall = $nc[0];
	
	$term = str_replace(' ','', $term); 
	
	echo ("term: $term <br> netc: $netc <br><br> ");
	
	 		  	/* added district: 2022-10-17 */
/*
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
*/     
  $sql = "SELECT callsign, name 
            FROM $netc
           WHERE callsign LIKE '%$term%' 
              OR Fname LIKE '%$term%' 
              OR Lname LIKE '%$term%'
           GROUP BY callsign
           limit 0,6;
       "; 
  		  //	die('after sql build <br>'.$sql);
  		  	$results = array(); // setup the array
            //die('<br>after array build<br>');
  		  	foreach($db_found->query($sql) as $row) {
          		  //die('<br>inside foreach');
  		  		array_push($results, array(
  		  				'label' => $row['callsign'], 
  		  				'desc' => $row['name'],
  		  				'value'  => $row['callsign']
  		  				));
			} // end foreach loop	
			//die('after foreach Debug message');
			
			if (count($results)==0){echo "not in this view";}
            else {
			    // write the results array to the hints
			    header('Content-Type: application/json');
				echo json_encode($results);	  
            }
?>
