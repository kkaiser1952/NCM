
<?php
    /* // A right click on this field looks up the district from the NCM.HPD table */
      
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "getRealIpAddr.php";
    
    //$str = strip_tags(($_POST["str"]));
     //   echo "$str";
  
    $st       = trim(strip_tags($_POST["st"])); // state
    $co       = trim(strip_tags($_POST["co"])); // county
    $recordID = intval($_POST["q"]);            // recordID
    
    echo "@20   st: $st  co: $co  recordID: $recordID";  // this is put in the Network tab in Inspect Element information
    
    // Get some default information from the NetLog Table
    if ($recordID) {
    $sql = ("
            SELECT id, netID, callsign
              FROM `NetLog` 
             WHERE recordID = $recordID
             LIMIT 0,1
        ");
//echo "\n 0 $sql";
        $stmt = $db_found->prepare($sql);
        $stmt->execute(); 
        $result  = $stmt->fetch();	
	    $id      = $result[id];
	    $netID   = $result[netID];
	    $cs1     = $result[callsign];
	    
	    $to      = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
	    $newopen = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
   
  
        // Get the information from the HPD table
        $sql = ("
            SELECT District 
              FROM `HPD` 
             WHERE state = trim('$st') and county = trim('$co')
             LIMIT 0,1
        ");
//echo "\n 1 $sql";
            $stmt   = $db_found->prepare($sql);
            $stmt->execute(); 
            
            $result = $stmt->fetch();	
		    $value  = $result[District];
		        if ($value == '' ){$value = 'UNK';}

                
            // Push the data to the NetLog
            $sql = ("
        		UPDATE NetLog SET 
        		       District = '$value'
        		 WHERE recordID = $recordID 
        	");
//echo "\n 2 $sql";	
                $db_found->exec($sql);
            
            // Then we insert the new update into the TimeLog table
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$id', '$netID', '$cs1', 'District change to: $value via R-Click', '$open', '$ipaddress')";
//echo "\n 3 $sql";		
                $db_found->exec($sql);
                
                
            $sql = "UPDATE stations SET district = '$value' WHERE callsign = '$cs1'";
            
                $db_found->exec($sql);
	};
	
?>