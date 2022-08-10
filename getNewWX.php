<?php
    // This program is part of the weather information program. Its job is to
    // get the lat and lon of a station requested by clicking on the NWS logo
    // on the main NCM page.
    // It then uses wxLL2.php to get the weather report at a much closer location
    // than is possible using just the I.P. address.
    // Written: 2022-05-15 by WA0TJT
	
//	ini_set('display_errors',1); 
//	error_reporting (E_ALL ^ E_NOTICE);
	
    require_once "dbConnectDtls.php";
    require_once "wxLL2.php";
    
    // this is the incoming variable from the question asked if you click the NWS logo.
    $cs = $_GET["str"];
    //$cs = 'kc0rrs';
    
    if ($cs <> '') {
    	$sql = "SELECT latitude, longitude
              	FROM stations    		      
    		 	WHERE callsign = '$cs'
    		 	LIMIT 1
    	   	";
    	   	
    	//echo "$sql \n\n";
    } // End if stoken

	$stmt= $db_found->prepare($sql);
	$stmt->execute();
	
	$result = $stmt->fetch();
		$lat	= $result[0];
		$lon    = $result[1];
		
		//echo "\n@37 in getNewWX.php $lat $lon\n";
		
		//echo currentLLWX( $lat, $lon );
		echo getOpenLLWX($lat, $lon); 
?>
