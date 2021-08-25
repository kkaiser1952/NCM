
<?php
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "getRealIpAddr.php";
    
    $recordID = intval($_POST["q"]); 
    
    if($recordID) {
        $sql = ("
            SELECT id, netID, callsign, active
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
		    $val   = $result[active];
		    
		    $to     = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
		    $newopen = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
		    
		    // This is a switch, if the current value is out the new value will be in and v.v.
		        IF ($val == "OUT" | $val == "Out") {
    		        $value = "In";
    		            $sql = ("
                    		UPDATE NetLog SET active = '$value'
                    		    ,timeout = NULL
                                ,logdate ='$newopen'
                                ,status = 0
                                ,logdate = CASE
                                                WHEN pb = 1 AND logdate = 0 THEN '$to'
                                                ELSE logdate  /* back to the original time */
                                                END
                    		 WHERE recordID = $recordID
                    	");
    		    } // end if 
		        ELSE /*IF ($val == 'In' | $val == 'IN' */ {
    		        $value = "OUT";
                        $sql = ("
                    		UPDATE NetLog SET active = '$value'
                    		    ,timeout 	 = '$to' 
                                ,timeonduty = (timestampdiff(SECOND, logdate, '$to') + timeonduty)
                                ,status	 = 1
                    		 WHERE recordID = $recordID 
                    	");
                } // end ELSE
	
	
            $db_found->exec($sql);
            
            // Then we insert the new update into the TimeLog table
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$id', '$netID', '$cs1', 'Status change: $value', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
	};
	
?>