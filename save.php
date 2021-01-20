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
	 require_once "GridSquare.php";
 
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
		
		//echo("col= $column val= $value recID= $recordID<br>");  // col= w3w val= home recID= 49315 
		
		// Edit to fix the timeout value and the timeonduty values 
		$moretogo = 0;
		
		// ALLOW UPDATE TO THESE FIELDS BUT TEST tactical for DELETE don't update for that 
		if ($column == "county" | $column == "state" | $column == "grid" | 
		    $column == "tactical" AND $value <> "DELETE" | 
		    $column == "cat" | $column == "section" ) {
    		
    		if ($column == "cat") { 
        		$column = "TRFK-FOR"; 
        		$value = strtoupper($value);
            } // change name of column for report
    		
    		$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
			
    		$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$ID', '$netID', '$cs1', '$column Change: $value', '$open', '$ipaddress')";
		
			$db_found->exec($sql); 
			
			if ($column == "TRFK-FOR") {$column = "cat";} // change name back to cat for the rest
		}
    		
				
		if ($column == "active" ) {
    //    if (strpos($column, 'active')) {
			$sql = "SELECT ID, netID, callsign from NetLog 
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
		
		
		// Update the timeout value when the active(status) setting is changed
		// Adding the subtraction of timeonduty to the timeonduty value in the SQL below accompanied NOT resetting the timeonduty to zero after someone checks back into the net after being checked out. This allows us to add the previous TOD to the current TOD repetedly, making it much more accurate.
		if ($column == "active" AND ($value == "Out" OR $value == "BRB" OR $value == "QSY" OR $value == "In-Out")) {
			$to  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT); 
				if ($value == "In-Out") {
					//$to ->modify("+01 minutes");
				}
			$sql = "UPDATE NetLog 
					   SET timeout 	 = '$to' 
					  ,timeonduty = (timestampdiff(SECOND, logdate, '$to') + timeonduty)
					  ,status	 = 1
				    WHERE recordID = $recordID  ";
		
				$stmt = $db_found->prepare($sql);
				$stmt->execute();
		} else if ($column == "active" AND ($value == "In")) {
			$to  = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT); 
			// newopen replaces logdate when a station logs out and then back in again
			$newopen = now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);
			$sql = "UPDATE NetLog 
					   SET timeout = NULL,
					       logdate ='$newopen',
					   	   status = 0,
					       logdate = CASE
					       	WHEN pb = 1 AND logdate = 0 THEN '$to'
					       	ELSE logdate  /* back to the original time */
					       END
				     WHERE recordID = $recordID 
				    ";
		
				$stmt = $db_found->prepare($sql);
				$stmt->execute();
		} // Endof else if column == active
		
						
		// ================================= //
		// If name conained two names Keith Kaiser for example, this splits off last name and updates Lname in DB
		elseif ($column == 'Fname' and str_word_count("$value") >= 2) { 
			//print_r(str_word_count("$value",1)); // Array ( [0] => Bill [1] => Brown ) Bill Brown
		}
		
		// On screen this is Role
		elseif ($column == 'netcontrol' ) {
			$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			}
			
			// Then we insert the new update into the TimeLog table
			
			//$value = mysql_real_escape_string($db_found, $value);
			
			if ($value <> "") {
				$Rollcomment = "Role Changed to: $value";
			} else  { // this is not working yet because of checking for != '' in elseif above
				$Rollcomment = "Role Removed";
			}
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$ID', '$netID', '$cs1', '$Rollcomment', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
		} // end elseif column = netcontrol (role)
		
		elseif ($column == 'Mode' ) {
			$sql = "SELECT ID, netID, callsign, recordID, tt
					FROM NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
				$recordID = $row[recordID];
				$tt		  = $row[tt];
			} // end elseif column = mode
			
			// Then we insert the new update into the TimeLog table
			
			//$value = mysql_real_escape_string($db_found, $value);
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					            VALUES ('$recordID', '$ID', '$netID', '$cs1', 'Mode set to: $value', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
		} // End of Mode elseif
		
		elseif ($column == 'traffic' ) {
			$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			} // end elseif column = traffic
			
			// Then we insert the new update into the TimeLog table
			
			//$value = mysql_real_escape_string($db_found, $value);
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$ID', '$netID', '$cs1', 'Traffic set to: $value', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
		} // End of traffic elseif
		
		elseif ($column == 'band' ) {
			$sql = "SELECT ID, netID, callsign from NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
			} // end elseif column = traffic
			
			// Then we insert the new update into the TimeLog table	
			//$value = mysql_real_escape_string($db_found, $value);
			 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$ID', '$netID', '$cs1', 'Band set to: $value', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
		} // End of Band elseif
				
		// Update the TimeLog if comments were added
		elseif ($column == 'comments' AND $value != '') {
			
			// The code here fixes the issue of losing any comment with a tick (') in it, but the display in the
			// Time Line Comments field still shows the backslash (\) used to escape the tick. YIKES!
			$value = str_replace("'", "\'", $value);

			
			// First we have to go get some more information about who updated the comment
			$sql = "SELECT ID, netID, callsign, home
			          FROM NetLog 
					WHERE recordID = '$recordID'";

			foreach($db_found->query($sql) as $row) {
				$netID = $row[netID];
				$ID	   = $row[ID];
				$cs1   = $row[callsign];
				$home  = $row[home];
			}
			
			// If its to reset the home coordinates then do this
			    $Varray = array("@home", "@ home", "@  home", "at home", "gone home,", "headed home", "going home", "home");
            if (in_array(strtolower("$value"), $Varray)) {
    			$latitude = explode(',', $home)[0]; 
    			$longitude = explode(',', $home)[1];
    			$grid = explode(',', $home)[2];
    			$county = explode(',', $home)[3];
    			$state = explode(',', $home)[4];
    			$value2 = "@home, reset to home coordinates ($home)";
				
				//echo ("in Varray");
    			
    		$sql = "UPDATE NetLog 
                       SET latitude = $latitude, longitude = $longitude, 
                           grid ='$grid', county = '$county', state = '$state', w3w = ''
    			         WHERE recordID = $recordID";
		
        		$stmt = $db_found->prepare($sql);
				$stmt->execute(); 
        		
			} else { $value2 = $value; }  // End of in_array 
			
			// Then we insert the new update into the TimeLog table 
			$sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
					VALUES ('$recordID', '$ID', '$netID', '$cs1', '$value2', '$open', '$ipaddress')";
		
			$db_found->exec($sql);
		} // End comments
		
		
		// This routine is to delete the row if the tactical was changed to DELETE we do this because
		// sometimes deleting with the X at the end of each row doesn't want to work on small screens.
		if ($column == "tactical" AND ($value == "DELETE") ) {
			//$value = "$value$recordID";
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
	$TSsql = "INSERT INTO TimeLog (recordID,  timestamp,  ID,    netID,    callsign, comment, ipaddress)
			  VALUES ( $recordID, '$dltdTS' ,'$id' ,'$netID' ,'GENCOMM' ,'The call $cs1 with this ID was deleted', '$ipaddress')";
		
			$db_found->exec($TSsql);
			
	}
	catch(PDOException $e) {
		echo $TSsql . "<br>" . $e->getMessage();
	}

	try {

		// This SQL does the actual delete from NetLog
		$sql = "DELETE FROM NetLog WHERE recordID =  $recordID " ;
		
	$stmt = $db_found->prepare($sql);
	$stmt->execute();
	
	echo  " DELETED successfully";
		$value = '';
	} // end of try
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}  // END of delete the row within the save function

		}

        if ($column == 'tactical' and str_word_count("$value") >= 2) { 
    			$value = preg_replace('/  /','<br>',$value);
		}
		
		if ($column == 'creds' and str_word_count("$value") >= 2 ) {
			$value = preg_replace('/  /','<br>',$value);  // this function is at the top of this program
		}
		
		
		echo str_replace("+"," ","$value");
		
		// Update the NetLog with the new information
		$sql = "UPDATE NetLog SET $column = :val WHERE recordID = :rec_id";
		
		$stmt = $db_found->prepare($sql);
		$stmt->bindParam(':val', 	$value, PDO::PARAM_STR);
		$stmt->bindParam(':rec_id', $recordID, PDO::PARAM_STR);
		$stmt->execute();
		
?>