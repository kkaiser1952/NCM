<?php
	// this program calculates a new gridsquare anytime the latitude or longitude values are changed. It runs from the editLAT and editLON in CallEditFunction.js
	// Written 2019-03-29
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "GridSquare.php";
    
    $recordID   = $_GET['recordID']; 
 //   $recordID = 22301;
    

$sql = "SELECT latitude, longitude
		  FROM NetLog
		 WHERE recordID =  $recordID
	   ";
    $stmt = $db_found->prepare($sql);
	$stmt->execute();
    		$lat = $stmt->fetchColumn(0);
    	$stmt->execute();
		$lon = $stmt->fetchColumn(1); 
			
			$grid = gridsquare($lat, $lon);	   
			//echo "$lat $lon $grid";
	 
	 	   
$sql2 = "UPDATE NetLog 
		   SET grid = '$grid', delta = 'Y'
		 WHERE recordID = $recordID";
	
	$stmt2 = $db_found->prepare($sql2);
	$stmt2 -> execute();
			
?>