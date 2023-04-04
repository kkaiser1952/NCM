<?php

require_once "dbConnectDtls.php";

    // the term and netcall come from NetManager-p2.js @ gethint.php    
	
	$term = $_GET['term'];
	$netc = $_GET['nc'];
	
	$term = 'tjt';
	$netc = 'mytesting';
	
	//$nc = explode(' ', trim($netc));
	//$netcall = $nc[0];
	
	$term = str_replace(' ','', $term); 
	
	echo ("term: $term <br> netc: $netc <br><br> ");
	
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
