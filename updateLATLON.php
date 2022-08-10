<?php
	// this program calculates a new gridsquare anytime the latitude or longitude values are changed. It runs from the editLAT and editLON in CallEditFunction.js
	// Written 2019-03-29
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "getLatLonFromGrid.php";
    
    $recordID   = $_GET['recordID']; 
   // $recordID = 22300;
    

$sql = "SELECT grid
		  FROM NetLog
		 WHERE recordID =  $recordID
	   ";
    $stmt = $db_found->prepare($sql);
	$stmt->execute();
    		$grid = $stmt->fetchColumn(0);
			
			$lat = number_format((float)get_grid_square($grid)[0],5,'.','');
			$lon = number_format((float)get_grid_square($grid)[1],5,'.','');
	 
	 	   
$sql2 = "UPDATE NetLog 
		   SET latitude = $lat, longitude = $lon, delta = 'Y'
		 WHERE recordID = $recordID";
		 
		 //echo $sql2;
	
	$stmt2 = $db_found->prepare($sql2);
	$stmt2 -> execute();
			
?>