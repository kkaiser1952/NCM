<?php
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $recordID   = $_GET['recordID']; 
    
   //$call = 'wa0tjt';
    
// Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

// sets the time on duty value and sets status to 1 which is closed.
$sql = "UPDATE NetLog 
		   SET timeonduty = (timestampdiff(SECOND, logdate, timeout)),
		   	   status = 1
		 WHERE recordID = $recordID";
	
	$stmt = $db_found->prepare($sql);
		$stmt -> execute();
?>