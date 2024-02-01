
<?php
    /* // A right click on this field changes it to 'STANDBY' or 'STANDBY' gets changed to 'Resolved' */
    
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "getRealIpAddr.php";
    
    $recordID = intval($_POST["q"]); 
    
   // $recordID = 78016;
    
    if($recordID) {
        $sql = ("
            SELECT id, netID, callsign, traffic
              FROM `NetLog` 
             WHERE recordID = $recordID
             LIMIT 0,1
        ");
        $stmt = $db_found->prepare($sql);
        $stmt->execute(); 
        $result = $stmt->fetch();	
		    $id    = $result[id];
		    $netID = $result[netID];
		    $cs1   = $result[callsign];
		    $val   = $result[traffic];
		    
		    $to     = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
		    $newopen = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
		    
		    // This is a switch, each possible value gets changed to something new
		    
                IF (in_array($val, array('STANDBY','Question'))) {
    		        $value = "Resolved";

    		    } ELSE IF (in_array($val, array('Traffic','Routine','Priority','Welfare','Emergency','Announcement','Bulletin','Comment','Image'))) {
    		        $value = "Sent";

                } ELSE IF (in_array($val, array('Resolved','Sent',''))) {
                    $value = "STANDBY";
                } // end ELSE
                
                // Push the data to the NetLog
                        $sql = ("
                    		UPDATE NetLog SET 
                    		     traffic = '$value'
                    		 WHERE recordID = $recordID 
                    	");
	
            $db_found->exec($sql);
            
            // Then we insert the new update into the TimeLog table
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$id', '$netID', '$cs1', 'Traffic change: $value', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
	};
	
?>