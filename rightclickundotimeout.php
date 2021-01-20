<?php

require_once "dbConnectDtls.php";

$netid = $_POST['netid'];
$cs1   = $_POST['opensign'];

	$reopen  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT); 
    /* timeout       = NULL */
								/*  ,timeonduty    = '0' */
	if($netid) {
		$sql = ("update NetLog set 
								   logclosedtime = NULL
								  ,status		 = '0'
		where netID = '$netid' 
		  and status = 1 
		  AND active NOT IN ('In-Out','OUT','Out','BRB','QSY')
		  ");
		
		$db_found->exec($sql);

	/* This puts the log closing time into the TimeLog table */	
	//$cs1 = "GENCOMM"; 
	$comment = "The log was re-opened";
	$sql1 = "INSERT INTO TimeLog (netID,     callsign, comment,    timestamp) 
						 VALUES ('$netid', '$cs1',   '$comment', '$reopen')";
						 
						 echo("$sql1");
		
		$db_found->exec($sql1);

	}
?>