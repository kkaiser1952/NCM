<?php
//date_default_timezone_set("America/Chicago");
	require_once "dbConnectDtls.php";
	
	function getRealIpAddr() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}
	
	$ipaddress = getRealIpAddr();
	
	$recordID = $_POST['id'];
	//echo("in delete-row.php id=  $id \n");

	// The following code gets some info from NetLog about the recordID that is being deleted.
	// It uses that info to write the delete to the TimeLog.
	// Then it deletes that recordID from NetLog

	// Set the deleted datetime for the TimeLog
	$dltdTS  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT); 
	
	try {
		
	// This SQL uses the maximum logdate and the recordID to gather its info

	$CurrentSQL = "SELECT netID, ID, callsign
					 FROM NetLog 
					WHERE recordID = $recordID 
				  ";
	foreach($db_found->query($CurrentSQL) as $row) {
				$netID 	  = $row[netID];
				$id	   	  = $row[ID];
				$cs1   	  = $row[callsign];
			}
			
	// This SQL puts the info from NetLog into the TimeLog table
	$TSsql = "INSERT INTO TimeLog (recordID,  timestamp,  id,    netID,    callsign, comment, ipaddress)
			  VALUES ( $recordID, '$dltdTS' ,'$id' ,'$netID' ,'GENCOMM' ,'The call $cs1 with this ID was deleted', '$ipaddress')";
		
			$db_found->exec($TSsql);
			
	}
	catch(PDOException $e) {
		echo $TSsql . "<br>" . $e->getMessage();
	}

	try {

		// This SQL does the actual delete from NetLog
		$sql = "DELETE FROM NetLog 
				 WHERE recordID =  $recordID
				   
			   " ;
		
	$stmt = $db_found->prepare($sql);
	$stmt->execute();
	
	echo  "Record " . $stmt->rowCount() . " DELETED successfully";
	}
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}

?>