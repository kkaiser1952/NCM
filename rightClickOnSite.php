
<?php
    /* // A right click on the on site field changes it to 'No' or blank to 'Yes' */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "getRealIpAddr.php";
    
    $recordID = intval($_POST["q"]); 
    //$recordID = 93882;
    
    if($recordID) {
        $sql = ("
            SELECT a.id, a.netID, a.callsign, a.onsite,
                   b.Home,
                   c.latitude, c.longitude
              FROM  NetLog   a
                   ,stations b 
                   ,facility c
             WHERE a.recordID = $recordID
               AND a.callsign = b.callsign
               AND a.facility = c.facility
             LIMIT 0,1
        ");
            
        $stmt = $db_found->prepare($sql);
        $stmt->execute(); 
        $result = $stmt->fetch();	
		    $id    = $result[id];
		    $netID = $result[netID];
		    $cs1   = $result[callsign];
		    $val   = trim($result[onsite]);
		    $home  = $result[Home];
		    $latitude = $result[latitude];
		    $longitude = $result[longitude];
		    
		    $to     = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
		    $newopen = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
		   
		   if ($val == "Yes" or $val == "YES" ) { 
    		   $value = "No";
    		   
    		   $parts = explode(",",$home);
    		        
		        $latitude = $parts[0]; 
		        $longitude = $parts[1];
		        $grid = $parts[2]; 
		        $county = $parts[3]; 
		        $state = $parts[4];
           } 
           else if ($val == "No" or $val == "NO" or $val == null ) {
               $value = "Yes";
           } 
                
                // Push the data to the NetLog
                $sql = "
            		UPDATE NetLog SET 
            		     onsite     = '$value'
            		    ,latitude   = '$latitude'
            		    ,longitude  = '$longitude'
            		    ,grid       = '$grid'
            		    ,county     = '$county'
            		    ,state      = '$state' 
            		 WHERE recordID = $recordID 
            	";
	
            $db_found->exec($sql);
            
            // Then we insert the new update into the TimeLog table
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$id', '$netID', '$cs1', 'OnSite & locations changed to: $value', '$open', '$ipaddress')";

			$db_found->exec($sql);
	};
	
?>