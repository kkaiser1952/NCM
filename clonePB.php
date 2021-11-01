<?php
	//Written: 2018-12-24
	// This PHP copyies pertenant rows from one net to another so that pre-built nets can be built
	
	// If this FAILS check the DB for the ncm.temp_NetLog 

require_once "dbConnectDtls.php";

// Clean up the incoming data which should look like this  :439:aa0ax:::0:TE0ST
// passing data: {oldPB:oldPB, newPB:netID, newKind:newKind},
$oldPB = strip_tags($_POST["oldPB"]); // The one being copied
$netID = strip_tags($_POST["newPB"]); // The one we are coping rows to
$newKind = strip_tags($_POST["newKind"]); // The name of this new event
$oldCall = strip_tags($_POST["oldCall"]); // Prevents duplication of start-up call sign

//$oldPB = 1000;
//$netID = 1011;
//$newKind = 'Summertime Fun Fest';

$sqlS1 = ("
/*	DROP TABLE ncm.temp_NetLog; */

	CREATE TABLE ncm.temp_NetLog
	SELECT *
	  FROM NetLog
	 WHERE pb = 1
	   AND netID = $oldPB
	   AND callsign <> '$oldCall' /* this should but is it preventing duplicates of who started the net */
	 GROUP BY callsign;    /* This prevents all the dupes except whoever created the new PB net */

	UPDATE ncm.temp_NetLog 
	   SET netID = $netID, recordID = '', active = 'Out', status = 0, timeout = 0, 
		   firstLogin = 0, logdate = 0, comments = '', timeonduty = 0, logclosedtime = 0, 
		   dttm = NOW(), activity = '$newKind';

	INSERT INTO NetLog
	SELECT *
	  FROM ncm.temp_NetLog;

	DROP TABLE ncm.temp_NetLog; 
 
");

//echo("$sqlS1");
$db_found->exec($sqlS1);
?>