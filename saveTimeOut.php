<?php
	//date_default_timezone_set("America/Chicago");
	 require_once "dbConnectDtls.php";
 
//$open  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);  

// End of time stuff
 
		$rawdata = file_get_contents('php://input');
		//echo("$rawdata");  //Value=Hello+World&Id=Fname%3A2751Array ( ) Hello World
		$part = (explode("&",$rawdata));
		$part2 	= explode("=",$part[1]); //echo("part2= $part2");  //ArrayArray ( [0] => Value ) Bill Brown

		$part30	= $part2[0];  // = id  the word 
		$part31 = $part2[1];  // = Fname%3A203  the word with a tacked on 203 (recordID)

		$part4	= explode("%3A",$part31); // = Array
		$recordID = $part4[1]; 
		
		$column = $part4[0]; //echo "column= $column";
		
		$value 	= explode("=",$part[0]); //echo("val= $value");  //ArrayArray ( [0] => Value ) Hello World
		$value  = trim($value[1],"+"); //echo("$value"); // Array ( [0] => Value ) Bill Brown
		
		$value  = str_replace("+"," ",$value);
		$value  = rawurldecode($value);  //echo("$value");  //Bill Smith Array ( [0] => Value ) Bill Smith	W
		
		// Edit to fix the timeout value and the timeonduty values 
		if ($column == "timeout") {
			
			
			$value = date_create_from_format(Y-m-d H:i:s, $value);
			//2016-11-29 21:46:01
			// We need to know the year and time of the new time out value so we'll use the logdate values		 
		}
		
		// =============================================================================================
		// Update the timeout value when the active setting is changed
		// Adding the subtraction of timeonduty to the timeonduty value in the SQL below accompanied NOT resetting the timeonduty to zero after someone checks back into the net after being checked out. This allows us to add the previous TOD to the current TOD repetedly, making it much more accurate.
		if ($column == "active" AND ($value == "Out" OR $value == "BRB")) {
			$to  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT); 
			$sql = "UPDATE NetLog set timeout 	 = '$to' 
									 ,timeonduty = (timestampdiff(SECOND, logdate, '$to')) - timeonduty
									 ,status	 = 1
				    WHERE recordID = $recordID  ";
		
				$stmt = $db_found->prepare($sql);
				$stmt->execute();
		} else if ($column == "active" AND ($value == "In" OR $value == "In-EOC" OR $value == "In-EOC")) {
			$to  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT); 
			$sql = "UPDATE NetLog set timeout = NULL 
				    WHERE recordID = $recordID  ";
		
				$stmt = $db_found->prepare($sql);
				$stmt->execute();
		}
		
		// If name conained two names Keith Kaiser for example, this splits off last name and updates Lname in DB
		if ($column == 'Fname' and str_word_count("$value") >= 2) { 
			//print_r(str_word_count("$value",1)); // Array ( [0] => Bill [1] => Brown ) Bill Brown
			$Fname = str_word_count("$value",1)[0]; //echo("fname= $Fname");
			$Lname = str_word_count("$value",1)[1]; //echo("Lname= $Lname recordid= $recordID");
				$sql = "UPDATE NetLog set Lname = '$Lname' where recordID = $recordID ";
				$db_found->exec($sql);
			$value = "$Fname";

		}
		
		elseif ($column == 'netcontrol' AND $value != '') {
			$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
			
			// Then we insert the new update into the TimeLog table
			
			//$value = mysql_real_escape_string($db_found, $value);
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp) 
					VALUES ('$recordID', '$ID', '$netID', '$cs1', 'Role changed to: $value', '$open')";
		
			$db_found->exec($sql);
		}
		
		elseif ($column == 'active' AND $value != '') {
			$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
			
			// Then we insert the new update into the TimeLog table
			
			//$value = mysql_real_escape_string($db_found, $value);
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp) VALUES ('$recordID', '$ID', '$netID', '$cs1', 'Status Changed To: $value', '$open')";
		
			$db_found->exec($sql);
		}
		
		elseif ($column == 'Mode' AND $value != '') {
			$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
			
			// Then we insert the new update into the TimeLog table
			
			//$value = mysql_real_escape_string($db_found, $value);
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp) VALUES ('$recordID', '$ID', '$netID', '$cs1', 'Mode set to: $value', '$open')";
		
			$db_found->exec($sql);
		}
				
		// Update the TimeLog if comments were added
		elseif ($column == 'comments' AND $value != '') {
			
			// First we have to go get some more information about who updated the comment
			$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
			
			// Then we insert the new update into the TimeLog table
			
			//$value = mysql_real_escape_string($db_found, $value);
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp) VALUES ('$recordID', '$ID', '$netID', '$cs1', '$value', '$open')";
		
			$db_found->exec($sql);
		}
		
		
		echo str_replace("+"," ","$value");
		
		// Update the NetLog with the new information
		$sql = "UPDATE NetLog SET $column = :val WHERE recordID = :rec_id";
		
		$stmt = $db_found->prepare($sql);
		$stmt->bindParam(':val', $value, PDO::PARAM_STR);
		$stmt->bindParam(':rec_id', $recordID, PDO::PARAM_STR);
		$stmt->execute();
		
?>