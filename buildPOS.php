<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = $_GET["NetID"];  
    $q = 2797;
    
    // The below SQL is used to report the parent and child nets
    $sql = "SELECT subNetOfID, 
			       GROUP_CONCAT(DISTINCT netID SEPARATOR ', ')
			  FROM NetLog
			 WHERE subNetOfID = $q
			 ORDER BY netID";
			 
	$stmt = $db_found->prepare($sql);
	
	//	$stmt -> execute();
	//		$parent = $stmt->fetchColumn(0);
		$stmt -> execute();
			$children = $stmt->fetchColumn(1); 
		
	//	echo "p= $parent<br>";
	//	echo "c= $children<br>";
	
	$sql1 = ("
		SELECT netID, tt, callsign, grid, tactical, latitude, longitude, email, phone, fname, lname, activity
		  FROM NetLog
		 WHERE netID = $q 
	");
	
	 echo "
    	* POS file based on NCM net # $row[$activity] <br>";
	
			
    foreach($db_found->query($sql1) as $row) {
	    
	    $fname  = $row[fname];  $lname    = $row[lname]; 	$activity = $row[activity];
	    $tt 	= $row[tt]; 	$callsign = $row[callsign];	$grid 	  = $row[grid];
	    $lat 	= $row[latitude]; $lon    = $row[longitude]; $email	  = $row[email];
	    $phone  = $row[phone];	$tactical = $row[tactical];
    
    echo "
    	;$tactical-$tt*111111z$lat.'N'$lon.'W''<br>'
    ";
    }
?>