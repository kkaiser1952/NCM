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
	} // end function
	 
	    $q = $_POST["q"];     
	    //$q = '39.20283, -94.60267,  71892, 4598';
	    
	    
	   // take apart the string q from NetManager-p2.js the getFindu function 
	    $delta      = 'LOC&#916;';
	    $parts	    = explode(",",$q);
		$lat 	    = $parts[0];  
		$lon 	    = $parts[1];  
		$recID      = $parts[2];
		$nID        = $parts[3];
		$ts         = $parts[4];
		$objname    = $parts[5];
		$ipaddress  = getRealIpAddr();
		$gridd 	    = gridsquare($lat, $lon);
        $grid       = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";      
        $crossRoads = getCrossRoads($lat, $lon);
        
        $w3w = $api->convertTo3wa($lat, $lon)[words];
			
			    
	    $sql = "SELECT ID, netID, callsign 
	              FROM NetLog 
					WHERE recordID = $recID";

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
             WHERE recordID = $recID  ";	

				$stmt = $db_found->prepare($sql);
				$stmt->execute();
          		
        // The TS is the last update time from Findu it will differ from current timestamp
        $comment = "$delta:APRS:OBJ: @:$ts ($lat,$lon)  ///$w3w   Cross Roads: $crossRoads Object: $objname";
        
        $sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, latlng, timestamp, ipaddress) 
					VALUES ('$recID', '$ID', '$nID', '$cs1', '$comment', GeomFromText(CONCAT('POINT (', $lat, ' ', $lon, ')')), '$open', '$ipaddress')";
						
			$db_found->exec($sql);
	
?>