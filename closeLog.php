<?php
	date_default_timezone_set("America/Chicago");
	require_once "dbConnectDtls.php";
	require_once "WXdisplay.php";
	
	//$q = intval($_GET['q']); 
	$q = strip_tags(substr($_POST["q"],0, 100));
	//$q = $_POST["q"];
	//	echo("$q");
	
	$parts		= explode(",",$q);
	$netcall 	= strtoupper($parts[0]);  // The netID number
	$cs1		= strtoupper($parts[1]);  // Call sign of the station that closed the net
	$ipaddress = getRealIpAddr(); 

	$close  	= now(CONST_USER_TIMEZONE,CONST_SERVER_TIMEZONE,CONST_SERVER_DATEFORMAT);  
	
	/* This puts the log closing time into the TimeLog table */
	
	//$cs1 = "GENCOMM"; 
	$comment = "The log was closed, ICS-214 Created";
	$sql1 = "INSERT INTO TimeLog (netID,  		callsign, comment,    timestamp, ipaddress) 
						 VALUES ('$netcall',   '$cs1',   '$comment', '$close', '$ipaddress')";
				$db_found->exec($sql1);
     //   echo "$sql1";
	
	// A status of 1 means the log is closed, 0 or NULL means its open
	try {
    	// seperate update needed to force logclosedtime for all stations
    	$sql = "UPDATE NetLog
    	           SET logclosedtime = '$close'
    	         WHERE netID = '$q'
    	       ";
            $stmt = $db_found->prepare($sql);
            $stmt->execute();
            
        /* RE timeonduty calculation: The IF tests the status (first argument), if not 0, or Null it returns the second argument, otherwise it returns the third argument timeonduty if it had a value 
            IF(expression ,expr_true, expr_false);
        */
		$sql = "UPDATE NetLog 
			      set timeout 	  	 = '$close' , 
			          status 	  	 = '1', 
				      ipaddress      = '$ipaddress',
				      
				      timeonduty     = (timestampdiff(SECOND, logdate, '$close') + timeonduty)			      
				WHERE netID = '$q' 
			      AND timeout is NULL /* leave any previous OUT, QSY or BRB in place */
			      AND (status = 0 or status is NULL) /* Must still be checked into the net */
			   ";
	// A status of 1 means the log is closed, 0 or NULL means its open
		
	$stmt = $db_found->prepare($sql);
	$stmt->execute();
		
		/* Calculate the total man hours for this net */
		$sql2 = "select sec_to_time(sum(timeonduty)) as tottime from NetLog where netID = '$q' group by netID";
		$stmt2 = $db_found->prepare($sql2);
		$stmt2 -> execute();
	
		$tottime = $stmt2->fetchColumn(0); //echo "tottime = $tottime";
	
	// Do i need this stuff? What does it do?;
	if (($q) <> '0') {
		$wherestuff = "WHERE netID = '".$q."'
  			order by case 
  				when netcontrol in('PRM','CMD','TL') then 0 
  				when netcontrol in('2nd','3rd','LSN','Log','PIO','EM') then 1
  				when active = 'Out' then 4000
  				else 2
  				end, 
  			logdate DESC;";
  				  
			$g_query = "SELECT  recordID, netID, subNetOfID, id,  callsign, tactical,  Fname, grid, traffic, latitude, longitude, netcontrol, activity, Lname, email, active, comments, frequency, creds, DATE_FORMAT(logdate, '%H:%i') as logdate, DATE_FORMAT(timeout, '%H:%i') as timeout, sec_to_time(timeonduty) as time,
			netcall, status, Mode
		FROM  NetLog
			$wherestuff";
		  
	} else if ($q == '0') {
		  $wherestuff = "group by (id) order by ID;";
		  		
		  	  $g_query = "SELECT recordID, netID, subNetOfID, id,  callsign, tactical,  Fname, grid, latitude, longitude, activity,Lname, email,  creds, sec_to_time(timeonduty) as time
		  		FROM  NetLog
		  			$wherestuff";
	}
		  	
		echo ("	<table class=\"sortable\" id=\"thisNet\">
		  <thead id=\"thead\" style=\"text-align: center\">			
            <tr>            	
	            <th>Role</th>
	            <th>Mode</th>
	            <th>Status</th>  <!-- active -->
	            <th>Traffic<br>YN</th>
	            
	            <th width=\"5%\">tt#</th>
	            <th>Callsign</th>
                <th>First Name</th>
                
                <th class=\"toggleLN\">Last Name</th>
	            <th>Tactical</th>
	            <th class=\"toggleG\">Grid</th>
	            
	            <th class=\"toggleLAT\">Latitude</th>
	            <th class=\"toggleLON\">Longitude</th>                    
                <th class=\"toggleE\">eMail</th>     
                   
                <th>Time In</th>
                <th>Time Out</th> 
                <th>Time Line<br>Comments</th>
                
                <th>Credentials</th>
                <th class=\"toggleTOD\">Time On Duty</th>
            </tr>
		  </thead>
		  
		  <tbody id=\"netBody\"> ");  //ends the echo of the thead creation
		  
		  $num_rows = 0;   // Counter to color row backgrounds in loop below
	                                	              
			 foreach($db_found->query($g_query) as $row) {
				 
				 ++$num_rows; // Increment row counter for coloring background of rows

				 $bgcol = "                 ";
				 				 
				//if ($row[netcall] == "") {$netcall = "All";}
				
				if (!isset($row['netcall']) || $row['netcall'] == "") {
                  $netcall = "All";
                } else {
                  $netcall = $row['netcall'];
                }

				
				// Set background row color based on some parameters
					
				$os = array("PRM", "2nd", "LSN", "Log", "PIO", "EM", "CMD", "TL", "======", 'Capt'); // removed STB and EOC
				
				// #1 Important, traffic turns it red
				if ($row[traffic] == "Yes" ) {$bgcol = 'bgcolor="#ff9cc2"';}
				// #2 If netcontrol is in the above array turn it blue
				else if (in_array($row[netcontrol], $os)) {$bgcol = 'bgcolor="#bae5fc"';}
				// #3 If its digital station turn it salmon
				else if ($row[Mode] == "Dig") {$bgcol = 'bgcolor="#fbc1ab"';}
				// Turn the rest either green or white 
				else if($row[netcontrol] == NULL and $row[traffic] <> "Yes" and $num_rows % 2 == 0) {
					$bgcol = 'bgcolor="#EAF2D3"'; }
				// If the station has logged out of the net turn it grey
				if ($row[active] == "Out") {$bgcol = 'bgcolor="grey"';}
				
				  
				 $id = str_pad($row[id],2,'0', STR_PAD_LEFT);
				 
				 if ($row[recordID] % 2 == 0) { // Even
					echo ("<tr $bgcol id=\"$row[recordID]\">");			
				}else{  // Odd
					echo ("<tr $bgcol id=\"$row[recordID]\">");
				};
			
	if (($q) <> '0') {		 
	    echo ("<td class=\"editable_selectNC cent\" id=\"netcontrol:$row[recordID]\">$row[netcontrol] </td>"); 	 
	    echo ("<td class=\"editable_selectMode cent \" id=\"Mode:$row[recordID]\">      $row[Mode]       </td>");   
	    echo ("<td class=\"editable_selectYNO cent\" id=\"active:$row[recordID]\">$row[active] </td>");	    
	    echo ("<td class=\"editable_selectTFC\" id=\"traffic:$row[recordID]\">$row[traffic] </td>");  
	    
	    echo ("<td class=\"cent\">$row[tt]</td>");  // Callsign ID, not the recordID, not editable	
        echo ("<td class=\"editCS1\" id=\"callsign:$row[recordID]\" style=\'text-transform:uppercase\'> $row[callsign] </td>");
        	
        echo ("<td class=\"editFnm\" id=\"Fname:$row[recordID]\"> $row[Fname] </td>");
        echo ("<td class=\"editLnm toggleLN\" id=\"Lname:$row[recordID]\" style=\'text-transform:capitalize\'> $row[Lname] </td>");

        echo ("<td class=\"editTAC cent\" id=\"tactical:$row[recordID]\" style=\'text-transform:uppercase\'> $row[tactical] </td>");
        	
        echo ("<td class=\"editGRID toggleG \" id=\"grid:$row[recordID]\"> $row[grid] </td>"); 
        echo ("<td class=\"editLAT toggleLAT \" id=\"latitude:$row[recordID]\"> $row[latitude] </td>");
        echo ("<td class=\"editLON toggleLON \" id=\"longitude:$row[recordID]\"> $row[longitude] </td>");
                            	
        echo ("<td class=\"editEMAIL toggleE \" id=\"email:$row[recordID]\"> $row[email] </td>");      	
        echo ("<td class=\"cent\" id=\"logdate:$row[recordID]\"> $row[logdate] </td>");
        echo ("<td class=\"cent\" id=\"timeout:$row[recordID]\"> $row[timeout] </td>");
        	
        echo ("<td class=\"editC\" id=\"comments:$row[recordID]\" onClick=\"empty('comments:$row[recordID]');\" > $row[comments] </td>");
        	
        echo ("<td class=\"editCREDS\" id=\"creds:$row[recordID]\"> $row[creds] </td>");
        echo ("<td class=\"toggleTOD cent \" id=\"timeonduty:$row[recordID]\">$row[time] </td>");
        echo ("<td id=\"delete:$row[recordID]\"> <a href=\"#\" class=\"delete cent\" ><img alt=\"x\" border=\"0\" src=\"images/delete.png\" /></a></td>");
        
        
    } else if ($q == '0') {
	        
	    echo ("<td>$row[tt]</td>");  // Callsign ID, not the recordID, not editable
	        
	    echo ("<td class=\"editCS1\" id=\"callsign:$row[recordID]\" style=\'text-transform:uppercase\'> $row[callsign] </td>");
        	
        echo ("<td class=\"editFnm\" id=\"Fname:$row[recordID]\"> $row[Fname] </td>");
        echo ("<td class=\"editLnm\" id=\"Lname:$row[recordID]\" style=\'text-transform:capitalize\'> $row[Lname] </td>");
        echo ("<td class=\"editTAC cent\" id=\"tactical:$row[recordID]\" style=\'text-transform:uppercase\'> $row[tactical] </td>");
        	
        echo ("<td class=\"editGRID\" id=\"grid:$row[recordID]\"> $row[grid] </td>");
        echo ("<td class=\"editLAT\" id=\"latitude:$row[recordID]\"> $row[latitude] </td>");
        echo ("<td class=\"editLON\" id=\"longitude:$row[recordID]\"> $row[longitude] </td>");
        echo ("<td class=\"editEMAIL\" id=\"email:$row[recordID]\"> $row[email] </td>");
        echo ("<td class=\"editCREDS\" id=\"creds:$row[recordID]\"> $row[creds] </td>");
        echo ("<td class=\"editTOD cent \" id=\"timeonduty:$row[recordID]\"> $row[time] </td>");
	    
	}
			 } // End the foreach
			 			 
			echo ("</tr></tbody><tfoot><tr><td colspan='12' align='right'>Total Man Hours = $tottime</td></tr></tfoot>" );
			echo ("</table>"); //End of tbody and the table
	
			echo ("<div hidden id='freq2'>$row[frequency]</div>");
			echo ("<div hidden id='freq'></div");
			echo ("<div hidden id='type'>Type of Net:       $row[activity]</div>");
			echo ("<div hidden id='idofnet'>Net ID: 		$row[netID]</div>");
			echo ("<div hidden id='activity'>$row[activity]</div>");
	}
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
?>