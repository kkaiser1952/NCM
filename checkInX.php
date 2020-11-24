<?php
	//$date = new DateTime('2000-01-01', new DateTimeZone('America/Chicago'));
	//echo $date->format('Y-m-d H:i:sP') . "\n";
//date_default_timezone_set("America/Chicago");
// Fix times in the dbConnectDtls.php program 

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

// Clean up the incoming data which should look like this  :439:aa0ax:::0:TE0ST

$q = strip_tags(substr($_POST["q"],0, 100));

//echo "$q"; // this works. :730:W0DLK:Deb::0:TE0ST.  :TE0ST:WA0TJT:Keith::0:TE0ST <-- missing the netID

// Pull the incoming string apart for its various parts
$parts	= explode(":",$q);
$id 	= $parts[0];  // The users ID (13 = WA0TJT)
$netID 	= $parts[1];  //echo("netid= $netID");   // The net ID we are working with
$cs1 	= strtoupper($parts[2]);  // The call sign of who is checking in
$Tname 	= ucfirst($parts[3]);  // the first or both names of this person depending how it was entered
	if (str_word_count("$Tname") >= 2){
		$Fname = str_word_count("$Tname",1)[0]; 
		//$Fname2 = ucfirst($parts[3]);  // 2018-02-07
		$Fname2 = $Fname;
		$Lname2 = ucfirst(str_word_count("$Tname",1)[1]." ".str_word_count("$Tname",1)[2]);
	}
	else {$Fname  = ucfirst($parts[3]);
		  $Fname2 = ucfirst($parts[3]);  // the first name of this person, needed because Fname gets reset.
		  $Lname2 = "";
		 }

//echo("1: Tname= $Tname, Fname= $Fname, Fname2= $Fname2, Lname2= $Lname2, netID= $netID");

$grid	   = $parts[4];
$tactical  = $parts[5];  //echo "tactical= $tactical";
$latitude  = $parts[6];
$longitude = $parts[7];
$email 	   = $parts[8];
	if ("$Lname" == "") {$Lname = $parts[9];}
$activity  = $parts[10];  //echo("activity= $activity");  // KCNARES Weekly 2m Voice Net
$activity2 = $parts[10];  //echo("<br>activity2 at top= $activity2<br>");  // Same as netname or newnetname
$binaryops = $parts[10];   //echo("binaryops= $binaryops");
$netcall   = $parts[11];  // Net Call Sign;
$comments  = "";

$binaryops = str_pad($binaryops, 5, '0', STR_PAD_LEFT); //echo("showing= $binaryops");
$vops = array_map('intval', str_split($binaryops)); //var_dump($vops);

$findactivity = $db_found->prepare("SELECT min(logdate), activity FROM NetLog WHERE netID = $netID ");
$findactivity->execute();
	$result    	= $findactivity->fetch();
	$activity  	= $result[1];  //echo "result= $activity";
	$activity2 	= $result[1];  //echo "result= $activity";
	
	// testing for activity containing the word Meeting
	
	$x = stripos($activity,"Meeting");
		
		if (empty($x) OR isset($x)) {$toggleE = "toggleE";}
		
		if (stripos($activity,"Meeting") > 0 ) {$toggleE = ""; } // don't hide the column
	

	// End testing 
	
//echo "$netcall $netID $cs1";  // missing netcall
/* Pull the netcall ... just in case */
	$sql3  = "SELECT netcall, pb
				FROM NetLog
			   WHERE netID = '$netID' 
			     and logdate = ( SELECT MIN(logdate) FROM NetLog WHERE netID = '$netID' )";
	    $stmt3 = $db_found->prepare($sql3);
	    $stmt3 -> execute();
	    
	    $netcall = $stmt3->fetchColumn(0);
	    
	    $stmt3 -> execute();
	    $pb		 = $stmt3->fetchColumn(1);   // Added 2018-12-17
	    	//echo "pb @ 79 = $pb";
	    	
//echo "$netcall $netID $cs1";  // TE0ST 439 AA0AX    // looks good
/* Pull the subNetOfID 9/30/2016 */
	$sql2 = "select subNetOfID, frequency
			   from NetLog 
			  where netID = '$netID' 
			  group by netID";
		$stmt2 = $db_found->prepare($sql2);
		$stmt2 -> execute();
	
		$subNetOfID	= $stmt2->fetchColumn(0); 
		$frequency  = $stmt2->fetchColumn(1);
		
//echo "subNetOfID= $subNetOfID frequency= $frequency";  // I think this is good but both are often empty

/* This query pulls the last time this callsign logged on */
$stmt2 = $db_found->prepare("
	SELECT recordID, id, Fname, Lname,  grid, creds, email, latitude, longitude, 
		   tactical, county, state, district, tt
	  FROM NetLog 
	 WHERE callsign = '$cs1' 
	/*   AND pb <> 1 */  /* Dont use pre-builts as a data source */
	 ORDER BY netID DESC LIMIT 0,1 "); // CHANGED TO 0,1 on 2017-09-06
	$stmt2->execute();
	$result = $stmt2->fetch();
	
	$recordID 	= $result[0];	$id    	  	= $result[1];	
	$Fname 	  	= $result[2];	$Lname 	  	= $result[3];
	$grid  		= $result[4];	$creds 		= $result[5];
	$email 		= $result[6];	$latitude  	= $result[7];
	$longitude 	= $result[8];	$tactical  	= $result[9];
	$county    	= $result[10];	$state 		= $result[11];
	$district 	= $result[12];  $tt			= $result[13]; 
	$comments  	= "";	

// Added 2017-11-05 to eliminate dupelicate calls from being entered
$dupes = 0;
$dupes = (int) $db_found->query("SELECT count(*) FROM NetLog WHERE netID = $netID and callsign = '$cs1'")->fetchColumn();

if($dupes > 0){
	$comments = "This is a dupe";
	
	$sql = "INSERT INTO TimeLog 
						(recordID, 		ID, 			netID, 	  callsign, comment, 	 timestamp, tt) 
				VALUES  ('$recordID', 	'$id', 	'$netID', '$cs1', 	'$comments', '$open' ,'$tt')";
			
			$db_found->exec($sql);
}


/* If the ID (tt) is unknown from the above query, this creates a new record, ID (tt) and tactical 
	call for this check in person, it means that this person is a first time check in */
if ("$id" == "") {	
	$stmt = $db_found->prepare("SELECT MIN( unused ) AS unused
		FROM (
		
		SELECT MIN( t1.id ) +1 AS unused
		FROM NetLog AS t1
		WHERE NOT 
		EXISTS (
		
		SELECT * 
		FROM NetLog AS t2
		WHERE t2.id = t1.id +1
		)
		UNION 
		
		SELECT 1 
		FROM DUAL
		WHERE NOT 
		EXISTS (
		
		SELECT * 
		FROM NetLog
		WHERE id =1
		)
		) AS subquery");
	
		$stmt->execute();
	  	$result   = $stmt->fetch();
	  	$id 	  = $result[0];   
	  	//Below code to create a meaningful tactical call added 8/3/2017
	  		$partsofCS1 = str_split($cs1);
	  		$first_num  = -1;
	  		$num_loc    = 0;
	  			foreach ($partsofCS1 AS $a_char) {
		  			if (is_numeric($a_char)) {
			  			$first_num = $num_loc;
			  			break;
		  			}
		  			$num_loc++;
	  			}
	  			if ($first_num > -1) {
		  			$tactical = substr($cs1,$num_loc+1);
	  			} else {
		  			$tactical = cs1;
	  			}
	  		  
	  	$comments = "";
				
		$fccsql = $db_found->prepare("SELECT last 
				 ,first
				 ,state
				 ,CONCAT_WS(' ', address1, city, state, zip)
			 FROM fcc_amateur.en
			WHERE callsign = '$cs1' 
			ORDER BY fccid DESC 
			LIMIT 0,1 ");					
		
		$fccsql->execute();
	
		$rows = $fccsql->rowCount();
		
		// Do this if something is returned
		if( !$fccsql->rowCount() < 1 ) {
			$result = $fccsql->fetch();
				//$tt			= $result[0];
				// Convert first & last name into proper case (first letter uppercase)
				$Lname 		= ucfirst(strtolower($result[0]));
				$Fname 		= ucfirst(strtolower($result[1]));
				$state2	 	= $result[2];
				$address 	= $result[3];  //echo "$address"; // 73 Summit Avenue NE Swisher IA 52338
			//	$comments 	= "First Log In";  // adding state to this works
				$firstLogIn = 1;
		
				// This happens either way but really don't matter
				$koords    = geocode("$address");
				$latitude  = $koords[0];  //echo "lat= $latitude";
				$longitude = $koords[1];  //echo "lon= $longitude";
				
			//	[0] => 44.9596871 [1] => -93.2895616 [2] => Hennepin [3] => MN
				$county	   = $koords[2];
				//$district  = $koords[3];
				$state	   = $koords[3];
					if ($state == '') {
						$state = $state2;
					}
				$gridd 	   = gridsquare($latitude, $longitude);
				$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";  
				
				$comments 	= "First Log In";  // adding state to this works
				
		} else { // Do this if nothing is returned in otherwords there is not record in the FCC DB
				$comments 	= "No FCC Record";
		}
		
			// If this is the first log in for this station add them to the TimeLog table 
			if ("$comments" == "First Log In" OR "$comments" == "No FCC Record"){
				//$bgcolor = "red"; // 2017-12-27
				$sql = "INSERT INTO TimeLog 
						(recordID, 		ID, 	netID, 	  callsign, comment, 	 timestamp) 
				VALUES  ('$recordID', 	'$id', 	'$netID', '$cs1', 	'$comments', '$open')";
			
			$db_found->exec($sql);
	} // End of comments = "First Log In"
} // end of id == blank, meaning its a first time log in
	
//*******************************************************
// Added 2017-11-05 to eliminate dupelicate calls from being entered
/*
$dupes = 0;
$dupes = (int) $db_found->query("SELECT count(*) FROM NetLog WHERE netID = $netID and callsign = '$cs1'")->fetchColumn();

if($dupes > 0){
	$comments = "This is a dupe";
} */

// Added 2018-02-07. NOTE: the use of "" not " " with a space.
if ($cs1 == "NONHAM") {
	$tactical = "";
	$comments = "Not A Ham";
	$Lname = "";
	$Fname = "";
}
if ($Fname == "") {$Fname = "$Fname2";}
if ($Lname == "") {$Lname = "$Lname2";}

// 0 means it is NoT a pre-build, 1 means it is a pre-built

	switch ($pb) {
      case 0;  // Not a pre-build
       	$statusValue = 'In';
	   	$timeLogIn	 = $open;
       	break;
      case 1:   // is a pre-build
      	$statusValue = 'Out';
      	$timeLogIn	 = 0;
      	break;
      
      default:
      	$statusValue = 'In';
      	$timeLogIn	 = $open;
   }

  // echo ("<br>pb= $pb");
	// Added county and state on 2017-09-04
	// Added pb on 2018-12-17
	$sql = "INSERT INTO NetLog (ID, active, callsign, Fname, Lname, netID, grid, tactical, email, latitude, longitude, 
							    creds, activity, comments, logdate, netcall, subNetOfID, frequency, county, state, district,
							    firstLogIn, pb, tt) 
				   VALUES (\"$id\", \"$statusValue\", \"$cs1\", \"$Fname\", \"$Lname\", \"$netID\", \"$grid\", \"$tactical\", 			   \"$email\", \"$latitude\", \"$longitude\", \"$creds\", \"$activity2\", \"$comments\", \"$timeLogIn\",		   \"$netcall\", \"$subNetOfID\", \"$frequency\", \"$county\", \"$state\", \"$district\", \"$firstLogIn\", \"$pb\", \"$tt\" )"; 
	//echo ("<br>$sql");
	
	$db_found->exec($sql);
//} //end else part of dupes above 
	
	// create the where clause needed for the sql below it
	
	if (($netID) <> '0') {
		
		// the below wherestuff changed 2017-10-25 to place the last checked in station at the bottom of the list
  	/*	$wherestuff = "WHERE netID = '".$netID."'
				  order by netcontrol DESC, traffic DESC, logdate DESC;"; */
		
		$wherestuff = "WHERE netID = '".$netID."'
				  order by netcontrol DESC,  logdate;"; 
  				  
		$g_query = "SELECT  recordID, netID, Mode, subNetOfID, id, callsign, tactical, Fname, grid, traffic, 
							latitude, longitude, netcontrol, activity, Lname, email, active, comments, frequency, 
							creds, DATE_FORMAT(logdate, '%H:%i') as logdate, DATE_FORMAT(timeout, '%H:%i') as timeout,
							sec_to_time(timeonduty) as time, county, state, district, netcall, firstLogIn, tt
					  FROM  NetLog
				$wherestuff";
		  
	} else if ($netID == '0') {
	  		$wherestuff = "group by (id) order by (ID);";
	  		
	  		$g_query = "SELECT recordID, netID, subNetOfID, id, callsign, tactical, Fname, grid, latitude, longitude, 				   	   activity, Lname, email, creds, sec_to_time(timeonduty) as time, county, state, district, tt
	  					  FROM  NetLog
	  			$wherestuff";
	}
		  	
		echo ("	<table class=\"sortable\" id=\"thisNet\">
		  <thead id=\"thead\" style=\"text-align: center\">			
            <tr>            	
	            <th>Role</th>
	            <th>Mode</th>
	            <th>Status</th>   <!-- active -->
	            <th>Traffic<br>YN</th>
	            
	            <th  width=\"5%\">tt#</th>
	            <th title='Call Sign' oncontextmenu='heardlist()'>Callsign</th>
                <th>First Name</th>
                
                <th class=\"toggleLN\">Last Name</th>
	            <th>Tactical</th>
	            <th class=\"toggleG\">Grid</th>
	            
	            <th class=\"toggleLAT\">Latitude</th>
	            <th class=\"toggleLON\">Longitude</th>                    
                <th class=" . $toggleE . ">eMail</th>     
                   
                <th>Time In</th>
                <th>Time Out</th> 
                <th>Time Line<br>Comments</th>
                
                <th class=\"toggleCREDS editCREDS\"	>Credentials</th>
                <th class=\"toggleTOD\"				>Time On Duty</th>
                
                <th class=\" toggleCNTY editCNTY\"	>County</th>
                <th class=\" editstate toggleSTATE\"	>State</th>
                <th class=\"  editdist toggleDIST\"	>Dist</th>
            </tr>
		  </thead> 
		  
		  <tbody id=\"netBody\"> ");  //ends the echo of the thead creation
	                                	
	                  $num_rows = 0;   // Counter to color row backgrounds in loop below
	      $netTypes = array('Emergency','Priority','Welfare','Routine','Question','Announcement','Comment','Bulletin');
	      $os 		= array("PRM", "2nd", "3rd", "LSN", "Log", "PIO", "EM"); // removed STB and EOC
              
	foreach($db_found->query($g_query) as $row) {
				 ++$num_rows; // Increment row counter for coloring background of rows
				 $bgcol = "                 ";
				 				 
				if ("$row[netcall]" == "") {
					$netcall = "All";
				} else {
					$netcall = "$row[netcall]";
				}
				
				// Set background row color based on some parameters
				
				//if ($row[traffic] <> "" ) {$bgcol = 'bgcolor="#ff9cc2"';}
				if (in_array("$row[traffic]",$netTypes)) {$bgcol = 'bgcolor="#ff9cc2"';}
				// #2 If netcontrol is in the above array turn it blue
				else if (in_array($row[netcontrol], $os)) {$bgcol = 'bgcolor="#bae5fc"';}
				
				
				// #3 If its digital station turn it salmon
				else if ($row[Mode] == "Dig") {
					$bgcol = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;
				}
				else if ($row[Mode] == "D*") {     
					$bgcol = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;
				}
				else if ($row[Mode] == "Echo") {     
					$bgcol = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;
				}
				else if ($row[Mode] == "V&D") {     
					$bgcol = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;
				} 
				
				
				// Turn the rest either green or white 
				else if($row[netcontrol] == NULL and $row[traffic] <> "Sent" and $num_rows % 2 == 0) {
					$bgcol = 'bgcolor="#EAF2D3"'; }
					
				// If the station has logged out of the net turn it grey
				if ($row[active] == "Out") 		{$bgcol = 'bgcolor="#cacaca"';}
				if ($row[active] == "In-Out") 	{$bgcol = 'bgcolor="#faff87"';}
				if ($row[active] == "MISSING") 	{$bgcol = 'bgcolor="#d350a0"';}
				
				
				// Turn background of just one row of comments red if ist a dupe
				$warnbg = '';
				$bgcolor = '';
				$badCols = '';
				$newCall = '';
				
				if ($row[comments] == "No FCC Record" OR $row[comments] == "This is a dupe") {
					$bgcolor 	 = 'bgcolor="pink"';
					$dupeCallKey = 1;
					$redKey 	 = 1;
				
				} else if ($row[firstLogIn] == 1 ) {
					$badCols = 'bgcolor="#ffdb2b"';
					$newCall = 'bgcolor="#ffdb2b"';
						$fliKey = 1; /* This is just a switch to turn on a footer to the table */
				}
		
				  
				 $id = str_pad($row[id],2,'0', STR_PAD_LEFT);
				 
				 if ($row[recordID] % 2 == 0) { // Even
					echo ("<tr $bgcol id=\"$row[recordID]\">");			
				}else{  // Odd
					echo ("<tr $bgcol id=\"$row[recordID]\">");
				};

				$class = empty($row[comments]) ? 'nonscrollable' : 'scrollable' ;
				$class = strlen($row[comments]) < 300 ? 'nonscrollable' : 'scrollable' ;

			
	if (($netID) <> '0') {		 
	    echo ("<td 		class=\"editable_selectNC   cent \" id=\"netcontrol:$row[recordID]\">$row[netcontrol] </td>"); 	 
	    
	    echo ("<td      class=\"editable_selectMode cent \" id=\"mode:$row[recordID]\">		 $row[Mode] </td>"); 
	      
	    echo ("<td 		class=\"editable_selectACT  cent \" id=\"active:$row[recordID]\">	 $row[active] </td>");	  
	      
	    echo ("<td 		class=\"editable_selectTFC	cent \" id=\"traffic:$row[recordID]\">	 $row[traffic] </td>");  
	    
	    echo ("<td 		class=\"cent\">$row[tt]</td>");  // Callsign ID, not the recordID, not editable	
	    				// editCS1 removed from class in line below on 2017-12-01
        echo ("<td $newCall	class=\"  \" id=\"callsign:$row[recordID]\" style=\'text-transform:uppercase\' oncontextmenu=\"getCallHistory('$row[callsign]');return false;\" > $row[callsign] </td>");
        	
        echo ("<td $newCall class=\"editFnm\" id=\"Fname:$row[recordID]\"> $row[Fname] </td>");
        echo ("<td class=\"editLnm toggleLN\" id=\"Lname:$row[recordID]\" style=\'text-transform:capitalize\'> $row[Lname] </td>");

        echo ("<td class=\"editTAC cent\" id=\"tactical:$row[recordID]\" style=\'text-transform:uppercase\'> $row[tactical] </td>");
        	
        echo ("<td class=\"editGRID toggleG \" id=\"grid:$row[recordID]\"> $row[grid] </td>"); 
        echo ("<td class=\"editLAT toggleLAT \" id=\"latitude:$row[recordID]\"> $row[latitude] </td>");
        echo ("<td class=\"editLON toggleLON \" id=\"longitude:$row[recordID]\"> $row[longitude] </td>");
                            	
        echo ("<td class=\"editEMAIL " . $toggleE . "\" id=\"email:$row[recordID]\"> $row[email] </td>");      	
        echo ("<td class=\"cent\" id=\"logdate:$row[recordID]\"> $row[logdate] </td>");
        echo ("<td class=\"cent\" id=\"timeout:$row[recordID]\"> $row[timeout] </td>");
        	
        echo ("<td $bgcolor $newCall class=\"editC\" id=\"comments:$row[recordID]\" onClick=\"empty('comments:$row[recordID]');\" > $row[comments]</td>");
        	
        echo ("<td class=\"toggleCREDS editCREDS\" id=\"creds:$row[recordID]\"> $row[creds] </td>");
        echo ("<td class=\"toggleTOD cent \" id=\"timeonduty:$row[recordID]\">$row[time] </td>");
        
        
    // when you move this to after the MySQL is executed you can add the toggleCNTY, toggleSTATE, toggleDIST to the else 
    // clause.
        if ("$row[netcall]" == "MESN" OR "$row[netcall]" == "CARROLL" OR "$row[netcall]" == "FSQCALL" OR "$row[netcall]" == "W0KCN" OR "$row[netcall]" == "W0TE" OR "$row[netcall]" == "ORCA") {
	        echo ("<td class=\" cent editcnty toggleCNTY \" id=\"county:$row[recordID]\">$row[county] </td>");
	        echo ("<td class=\" cent editstate toggleSTATE \" id=\"state:$row[recordID]\">$row[state] </td>");
	        echo ("<td class=\" cent editdist toggleDIST \" id=\"district:$row[recordID]\">$row[district] </td>");
        } else {
	        echo ("<td class=\" cent editcnty toggleCNTY \" id=\"county:$row[recordID]\">$row[county] </td>");
	        echo ("<td class=\" cent editstate toggleSTATE\" id=\"state:$row[recordID]\">$row[state] </td>");
	        echo ("<td class=\" cent editdist toggleDIST \" id=\"district:$row[recordID]\">$row[district] </td>");
        }
        
        echo ("<td id=\"delete:$row[recordID]\"> 
        		<a href=\"#\" class=\"delete cent\" >
        				<img alt=\"x\" border=\"0\" src=\"images/delete.png\" />
        		</a>
			   </td>");
        
        $warnbg = '';
        
       // I'm not sure why, but this == 0 code must stay here for the checkins to work
       // Commented else on 2018-03-15
    } // End netID <> 0
     	} // End the foreach
			 			 
			echo ("</tr></tbody></table>"); //End of tbody and the table	
			
			echo ("<div hidden id='freq2'>					$row[frequency]	</div>");
			echo ("<div hidden id='freq'>									</div");
			echo ("<div hidden id='type'>Type of Net:       $row[activity]	</div>");
			echo ("<div hidden id='idofnet'>		 		$row[netID]		</div>");
			echo ("<div hidden id='activity'>				$row[activity]	</div>");
?>