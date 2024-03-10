 <?php
     // This program only runs when the aprs_call is right clicked. 
     
    require_once "dbConnectDtls.php";
     // Get the IP address of the person making the changes.
    require_once "getRealIpAddr.php";
    require_once "GridSquare.php";
    require_once "getCrossRoads.php";
    
    // https://developer.what3words.com/public-api/docs#convert-to-3wa
    require_once "Geocoder.php";
            use What3words\Geocoder\Geocoder;
            use What3words\Geocoder\AutoSuggestOption;          
            $api = new Geocoder("5WHIM4GD");
	
	function str_replace_first($search, $replace, $subject) {
		$pos = strpos($subject, $search);
			if ($pos !== false) {
				return substr_replace($subject, $replace, $pos, strlen($search));
			}
			return $subject;
	} // end str_replace_first function
	 
	    //$q = $_POST["q"];     
	    
	    $q = strip_tags(substr($_POST["q"],0, 100));
	    
	    
	   // take apart the string q from NetManager-p2.js the getFindu function 
	    $delta      = 'LOC&#916;';
	    $parts	    = explode(",",$q);
		$lat 	    = $parts[0];  
		$lon 	    = $parts[1]; 
		$recID      = $parts[2];
		$nID        = $parts[3];
		$ts         = $parts[4];
		$objname    = $parts[5];
		
		// calculated values
		$ipaddress  = getRealIpAddr();
		$gridd 	    = gridsquare($lat, $lon);
        $grid       = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";      
      //  $crossRoads = getCrossRoads($lat, $lon);
        $crossRoads = "";
        $w3w        = $api->convertTo3wa($lat, $lon)[words];

        
      
      // This grabs the most recent APRS Objects timestamp post from the timeLog
      // We will compare it to the just right clicked returned timestamp, if they
      // match then do NOT update the table, instead tell the logger        
        $sql = $db_found->prepare("SELECT MAX(SUBSTRING(comment, 23, 14))
                  FROM `TimeLog` 
                 WHERE recordID = $recID
                   AND comment LIKE '%APRS:OBJ%'
                   AND netID = $nID
                 LIMIT 1
               ");
               
        $sql->execute();
    	$PreviousTS = $sql->fetchColumn(); // from TimeLog table
    	
    	// this is the step that sends us back to the main page without updating the TimeLog
    	// Add or if $ts < NOW()-1hour
    	if ($ts == $PreviousTS) {
        	exit("The beacon failed, have the station try again.");
    	} 
    	
    	//echo "@54 MaxTS= $PreviousTS newTS= $ts";
			
        // Pick up some helpful data    
	    $sql = "SELECT ID, netID, callsign
	              FROM NetLog 
					WHERE recordID = $recID
				    LIMIT 1
				";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
    		
    		
    // Update NetLog with new information
    $sql = "UPDATE NetLog 
               SET latitude     = $lat
                  ,longitude    = $lon
                  ,ipaddress    = '$ipaddress'
                  ,grid         = '$grid'
                  ,w3w          = '$w3w $crossRoads'
             WHERE recordID = $recID  ";	

				$stmt = $db_found->prepare($sql);
				$stmt->execute();
          		
        // The TS is the last update time from Findu it will differ from current timestamp
        // Removed latlng on 2023-12-22
        $comment = "$delta:APRS:OBJ: @:$ts ($lat,$lon)  ///$w3w   Cross Roads: $crossRoads Object: $objname";
        
        $sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recID', '$ID', '$nID', '$cs1', '$comment', '$open', '$ipaddress')";
						
			$db_found->exec($sql);
	
?>