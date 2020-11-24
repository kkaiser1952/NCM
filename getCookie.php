<?php
// This query gets the default columns to display from the NetKind table in the DB
// Its called by and used by cookieManagement.js when the user has not cookie for this group
require_once "dbConnectDtls.php";

	$q = $_GET['q'];
	//echo $q;
	//$q = 'TE0ST';  
	    
	$sql = "SELECT columnViews 
			  FROM NetKind
			 WHERE `call` = '$q'
		   ";
	
	$stmt = $db_found->prepare($sql);
	$stmt->execute();
	
	  	$cv = $stmt->fetchColumn(0);
	  		echo "$cv";
?>