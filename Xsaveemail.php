 <?php
     // Get the IP address of the person making the changes.
    require_once "getRealIpAddr.php";
	
	function str_replace_first($search, $replace, $subject) {
		$pos = strpos($subject, $search);
			if ($pos !== false) {
				return substr_replace($subject, $replace, $pos, strlen($search));
			}
			return $subject;
	}
	
	// credentials and grid calculator
	 require_once "dbConnectDtls.php";
	// require_once "GridSquare.php";
 
		$rawdata = file_get_contents('php://input');
	//	echo("$rawdata");  
	// value=Platte&id=county%3A27449Platte	
	
		$part = (explode("&",$rawdata));
		$part2 	= explode("=",$part[1]); //echo("part2= $part2");  //ArrayArray ( [0] => Value ) Bill Brown

		$part30	= $part2[0];  //echo("$part30"); // = id  the word 
		$part31 = $part2[1];  // = Fname%3A203  the word with a tacked on 203 (recordID)

		$part4	= explode("%3A",$part31); // = Array
		$recordID = $part4[1]; 
		
		$column = $part4[0]; //echo("$column"); // county
		
		$value 	= explode("=",$part[0]); //echo("val= $value");  //ArrayArray ( [0] => Value ) Hello World
		$value  = trim($value[1],"+");  //echo("$value"); // Array ( [0] => Value ) Bill Brown
		
		$value  = str_replace("+"," ",$value);
		$value  = rawurldecode($value);  //echo("value= $value<br>");  //Bill Smith Array ( [0] => Value ) Bill Smith	W
		$value  = trim($value," ");
		
		//echo("$column  $value<br>");  // w3w headed home
		
		$ipaddress = getRealIpAddr();
		
		echo("col= $column val= $value recID= $recordID<br>");  // col= w3w val= home recID= 49315 
		

		  /*  		
				
		if ($column == "email" ) {
			$sql = "SELECT ID, netID, callsign 
			          FROM NetLog 
					 WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
			
			// Then we insert the new update into the TimeLog table
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$ID', '$netID', '$cs1', 'Status change: $value', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
		} // end elseif column = active
				
		
		echo str_replace("+"," ","$value");
		
		// Update the stations table for this station 
		
		// Update the NetLog with the new information
		$sql = "UPDATE NetLog SET $column = :val WHERE recordID = :rec_id";
		
		$stmt = $db_found->prepare($sql);
		$stmt->bindParam(':val', 	$value, PDO::PARAM_STR);
		$stmt->bindParam(':rec_id', $recordID, PDO::PARAM_STR);
		$stmt->execute();
		*/
		
?>