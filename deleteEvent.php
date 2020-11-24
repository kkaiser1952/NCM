<?php
	// This code sets a dttm for the datetime this event record was taken out of service and the 
	// callsign of the person who did it.
	// Written: 2018-01-03
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
   
   
    $str = $_POST["str"];  
    	//$str = "276;wa0tjt";
	    $parts		= explode(";",$str);
	    $id			= intval($parts[0]);
		$deletedBy 	= strtoupper($parts[1]);

	// Set the deleted datetime for the table
		$deletedOn  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT); 
	
	$sql  = "UPDATE events
				SET deletedBy = '$deletedBy'
				   ,deletedOn = '$deletedOn'
			  WHERE id = $id ";

	    $stmt = $db_found->prepare($sql);
	    $stmt -> execute();

?>