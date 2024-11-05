<?php
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
	
	require_once "dbConnectDtls.php";  // Access to MySQL
	require_once "geocode.php";     
	require_once "GridSquare.php";
	
function fcc_lookup($cs1) {
	//echo "cs1 at top= $cs1";

	// This SQL gets the information from the FCC database
$sql = ("SELECT * from fcc_amateur.en where callsign = 'WA0TJT'");
/*
$sql = ("SELECT
			  last
			 ,first
			 ,state
			 ,CONCAT_WS(' ', address1, city, state, zip)
		 FROM 'fcc_amateur.en'
		WHERE callsign = '$cs1' 
		ORDER BY fccid DESC 
		LIMIT 0,1 "); */
		
	$stmt = $db_found->prepare($sql);
		
	//	$stmt = $db_found->prepare($sql);
	  
	//	$stmt -> execute();
	//	$address = $stmt->fetchColumn(0);
		
		echo "<br>$sql";
		
}
	fcc_lookup('w0abc'); 
	

?>
