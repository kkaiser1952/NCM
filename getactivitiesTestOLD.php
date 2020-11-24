<?php
error_reporting( 0 );
	//date_default_timezone_set("America/Chicago");
	require_once "dbConnectDtls.php";	    
	
	$q = intval($_GET['q']); 
//	echo("in getactivitiesTest q= $q");
	//$q = 1074;
	// Added 2018-08-14
	// These variables and the SQL below it allow any parent net to display its children and v,v.
	$childCnt = 0;   // number of sub nets and given net has
	$children = "";  // will be a list of those children
	
	$sql = "SELECT subNetOfID as parent, 
			       GROUP_CONCAT(DISTINCT netID SEPARATOR ', ') as child
			  FROM NetLog
			 WHERE subNetOfID = $q
			   AND netID <> 0
			 ORDER BY netID";
			 
	$stmt = $db_found->prepare($sql);
		$stmt -> execute();
		
		//$parent = $stmt->fetchColumn(0);
		$children = $stmt->fetchColumn(1);
	
	/* Changed: 2017-10-27 */
	/* By using the extra data of netcall I can build the <th> and <td> to leave off the toggleSTATE, toggleCNTY */
	/* and toggleDIST. MESN wants to see this stuff by default               */
	$sql2 = "select sec_to_time(sum(timeonduty)) as tottime 
				   ,netcall ,activity, pb
			   from NetLog where netID = '$q' 
			   group by netID";
		$stmt2 = $db_found->prepare($sql2);
		$stmt2 -> execute();
		$tottime = $stmt2->fetchColumn(0); //echo "tottime = $tottime";
		
		$stmt2 -> execute(); // commented out 2017-11-22
		$netcall = $stmt2->fetchColumn(1); //echo "netcall = str_replace(' ', '', $netcall)";
		
		$stmt2 -> execute(); // commented out 2017-11-22
		$activity = $stmt2->fetchColumn(2); 

		$stmt2 -> execute(); // commented out 2017-11-22
		$prebuilt = $stmt2->fetchColumn(3); 
		
		$x = stripos($activity,"Meeting");
		$y = stripos($activity,"Event");
		
		if (empty($x) OR isset($x)) {$toggleE = "toggleE";}
		if (empty($y) OR isset($y)) {$togglePhone = "togglePhone";}
		//if (empty(stripos($activity,Meeting))) {$toggleE = "toggleE"; }
		
		if (stripos($activity,"Meeting") > 0 ) {$toggleE = ""; } // don't hide the column because its a 1 
		
		if (strstr("$activity","Event") ) {$togglePhone = ""; } 
		else $togglePhone = "togglePhone";
	
	$headerAll = '
	
		<table class="sortable " id="thisNet">
		  <thead id="thead" style="text-align: center;">			
            <tr>            	
	            <th title="Role" >Role	</th>
	            <th title="Mode" 	class="DfltMode cent " id="dfltmode">	Mode	</th>
	            <th title="Status" >Status	</th>  <!-- active  -->
	            <th title="Traffic">Traffic	</th>
	            
	            <th title="TT No." 	class="TT"	width="5%"	oncontextmenu="whatIstt();return false;">	tt#	</th> 
	            <th title="Call Sign"  oncontextmenu="heardlist()">Callsign</th>
                <th title="First Name">First Name</th>
                <th title="Last Name" class="toggleLN">Last Name</th>
	            <th title="Tactical Call" class="Ttactical">Tactical</th>
	            
	            <th title="Phone" class="togglePhone">Phone</th>
	            <th title="Grid" class="toggleG">Grid</th>
	            <th title="Latitude" class="toggleLAT">Latitude</th>
	            <th title="Longitude" class="toggleLON">Longitude</th>
                                      
                <th title="email" class="toggleE">eMail</th>        
                <th title="Time In ">Time In</th>
                <th title="Time Out">Time Out</th> 
                <th title="Comments">Time Line<br>Comments</th>           
                
                <th title="Credentials" class="toggleCREDS">Credentials</th>
                <th title="Time On Duty" class="toggleTOD">Time On Duty</th>
              
                <th title="County" class="toggleCNTY">County</th> 
                <th title="State" class="toggleSTATE">State</th>
                <th title="District" class="toggleDIST">Dist</th>
               
            </tr>
		  </thead>
		  
		  <tbody id="netBody">
	'; // End headerAll
		  
			  	$stmt = $db_found->prepare("SELECT frequency 
			  				 FROM `NetLog` 
			  				WHERE netID = $q
			  				  AND frequency <> ''
			  				  AND frequency NOT LIKE '%name%'");
			  	$stmt->execute();
			  	$result = $stmt->fetch();
			  		$freq = $result[0];
			  	 
			  	// Order output so the control operators on top
		  		$wherestuff = "WHERE netID = $q
		  			order by case 
		  				when netcontrol = 'PRM' then 0 
		  				when netcontrol = 'Log' then 1
		  				when netcontrol in('EM','PIO') then 2
		  				when netcontrol in('2nd','3rd','LSN') then 3
		  				when active		= 'MISSING' then 4
		  				when active 	= 'In-Out' then 3999
		  				when active 	= 'Out' then 4000
		  				else logdate  
		  				end, 
		  			logdate DESC;";
		  				  
	        $g_query = "SELECT  recordID, netID, subNetOfID, id,  callsign, tactical,  
	        					Fname, grid, traffic, latitude, longitude, netcontrol, 
	        					activity, Lname, email, active, comments, 
	        					creds, DATE_FORMAT(logdate, '%H:%i') as logdate, 
	        					DATE_FORMAT(timeout, '%H:%i') as timeout, 
	        					sec_to_time(timeonduty) as time, netcall, status, Mode, 
	        					TIMESTAMPDIFF(DAY, logdate , NOW()) as daydiff, county, 
	        					state, district, firstLogIn, phone, pb, tt
					FROM  NetLog 
					$wherestuff";   
		  
		  } else if ($q == '0') {
			   
		  		$wherestuff = "group by id
		  		order by ID;";
		  	$g_query = "SELECT recordID, netID, subNetOfID, id,  callsign, tactical, 
		  					   Fname, grid, latitude, longitude, 
		  					   activity, Lname, email, 
		  					   creds, netcall, status, county, state, district, phone, pb, tt
		  				  FROM  NetLog
		  				  	$wherestuff";	
		  	}        
		  		$trafficKey = 0;
		  		$logoutKey  = 0;
		  		$digitalKey = 0;
		  		$brbKey	    = 0;
		  		$ioKey		= 0;
		  		$noCallKey  = 0;
		  		$dupeCallKey= 0;
		  		$num_rows   = 0;   // Counter to color row backgrounds in loop below
		  		$cnt_status = 0;
		  		$subnetkey	= 0;
		  		
	  		$netTypes = array('Emergency','Priority','Welfare','Routine','Question','Announcement','Comment','Bulletin','Pending');
	  		$os = array("PRM", "2nd", "LSN", "Log", "PIO", "EM"); 
		  		     	              
			 foreach($db_found->query($g_query) as $row) {
				++$num_rows; // Increment row counter for coloring background of rows
				
				$toggleE = "toggleE"; // default value for the email class (column is hidden);
				//$togglePhone = "togglePhone";
				
				if ($row[subNetOfID] > 0) {$subnetkey = 1;
					$subnetnum = "$row[subNetOfID]";
				} // a switch to turn on the value below
				
				if (stripos($row[activity],meeting) > 0 ) {$toggleE = ''; } // don't hide the column
				if (stripos($row[activity],event) > 0 )   {$togglePhone = ''; }	
				
				$cnt_status = $cnt_status + $row[status];

				 $bgcol = "                 ";
				 				 
				if ($row[netcall] == "") {$netcall = "All";}
				
				$brbCols = $badCols = $newCall = '';
					
				// #1 Important, traffic turns it red
				if (in_array("$row[traffic]",$netTypes)) {$bgcol = 'bgcolor="#ff9cc2"';
						$trafficKey = 1;
				}
					
				// #2 If netcontrol is in the above array turn it blue
				else if (in_array($row[netcontrol], $os)) {
					$bgcol = 'bgcolor="#bae5fc"';
				}
				// #3 If its digital station turn it salmon
				else if ($row[Mode] == "Dig") {
					//$bgcol = 'bgcolor="#fbc1ab"';
					$brbCols = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;				
				}
				else if ($row[Mode] == "D*") {     
					$brbCols = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;
				}
				else if ($row[Mode] == "Echo") {     
					$brbCols = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;
				}
				else if ($row[Mode] == "V&D" or $row[Mode] == "FSQ") {     
					$brbCols = 'bgcolor="#fbc1ab"';
						$digitalKey = 1;
				}

				// Turn the rest either green or white 
				else if($row[netcontrol] == NULL and $row[traffic] <> "Sent" and $num_rows % 2 == 0) {
					$bgcol = 'bgcolor="#EAF2D3"'; }
				// If the station has logged out of the net turn it #cacaca
				if ($row[active] == "Out") {
					$bgcol = 'bgcolor="#cacaca"';
						//$logoutKey = 1;
				}
				
				else if ($row[active] == "MISSING") {
					$bgcol = 'bgcolor="#d350a0"';
						$logoutKey = 1;
				}
								
				else if ($row[active] == "BRB") {
					$brbCols = 'bgcolor="#eeaee5"';
						$brbKey = 1;
				} else if ($row[active] == "In-Out") {
					$bgcol = 'bgcolor="#faff87"';
						$ioKey = 1;	// Show the in-out (key) at the bottom of the net display 
				}
				
				else if ($row[comments] == "No FCC Record" OR $row[comments] == "This is a dupe") {
					$badCols = 'bgcolor="pink"';
						$redKey = 1;
				} 
				
				// First Log In
				if ($row[firstLogIn] == 1 ) {
					$newCall = 'bgcolor="#ffdb2b"';
						$fliKey = 1;
				} 
				
				$id = str_pad($row[id],2,'0', STR_PAD_LEFT);
				 
				if ($row[recordID] % 2 == 0) { // Even
					echo ("<tr $bgcol id=\"$row[recordID]\">");			
				}else{  // Odd
					echo ("<tr $bgcol id=\"$row[recordID]\">");
				};
				
				// To make the comments <td> scrollable but still stay at the default height if is not needed
				// this code checks if there are commets and changes the class name, a simple solution.
				// Also used in getTimeLog.php
					$class = empty($row[comments]) ? 'nonscrollable' : 'scrollable' ;
					$class = strlen($row[comments]) < 300 ? 'nonscrollable' : 'scrollable' ;
					
			
if (($q) <> '0') {		
	
	 echo "$headerAll";
	// Only nets <= 2 days old can be editited.

	if ("$row[daydiff]" < 2 ) {   
		
    echo ("<td      	class=\"Trole editable_selectNC   cent \" id=\"netcontrol:$row[recordID]\">$row[netcontrol] </td>"); 
    echo ("<td $brbCols	class=\"Tmode editable_selectMode cent \" id=\"Mode:$row[recordID]\">$row[Mode]</td>");	    
    echo ("<td $brbCols class=\"Tstatus editable_selectACT  cent\"  id=\"active:$row[recordID]\">$row[active]</td>");	    
    echo ("<td $brbCols	class=\"Ttraffic editable_selectTFC\" id=\"traffic:$row[recordID]\">	 $row[traffic] 	  </td>");  
    
    echo ("<td $brbCols	id=\"tt:$row[recordID]\" class=\"TT editTT cent \" title=\"TT No. $row[tt] no edit\" data-pb=\"$row[pb]\">
    		   $row[tt]
		   </td>");  // Callsign ID (tt), not the recordID, not editable
    		// editCS1 removed from class in line below on 2017-12-01
    echo ("<td $brbCols $newCall $badCols class=\"Tcallsign cs1 \" oncontextmenu=\"getCallHistory('$row[callsign]');return false;\" id=\"callsign:$row[recordID]\" title=\"Call Sign $row[callsign] no edit\"> 
    		   $row[callsign]   				  
    	   </td>");
    	
    echo ("<td $newCall $brbCols // And it hides the 'Start a new net' button when a net is selected from the dropdown	class=\"Tfname editFnm\" 					id=\"Fname:$row[recordID]\"> 	 $row[Fname] 	  </td>");
    echo ("<td 		    class=\"Tlname editLnm toggleLN\" 			id=\"Lname:$row[recordID]\" style=\'text-transform:capitalize\'> 															 					     $row[Lname] 	  </td>");

    echo ("<td $brbCols class=\"Ttactical editTAC cent\" 			id=\"tactical:$row[recordID]\" style=\'text-transform:uppercase\'> 
    									 					 $row[tactical]   </td>");
    									 					 
    echo ("<td class=\" editPhone togglePhone cent \"  id=\" phone:$row[recordID] \"> $row[phone] </td>");
    
    echo ("<td oncontextmenu=\"MapGridsquare('$row[latitude]:$row[longitude]:$row[callsign]');return false;\" class=\"editGRID toggleG \" id=\"grid:$row[recordID]\"> 	 $row[grid] 	  </td>");
     
    echo ("<td  		class=\"editLAT toggleLAT \" 		id=\"latitude:$row[recordID]\">  $row[latitude]   </td>");
    echo ("<td  		class=\"editLON toggleLON \" 		id=\"longitude:$row[recordID]\"> $row[longitude]  </td>");
    echo ("<td 		    class=\"editEMAIL toggleE \" 		id=\"email:$row[recordID]\"> 	 $row[email] 	  </td>");
 
    echo ("<td $brbCols class=\"Ttimein editTimeIn cent\"   id=\"logdate:$row[recordID]\">   $row[logdate]    </td>");
    echo ("<td $brbCols class=\"Ttimeout editTimeOut cent\"  id=\"timeout:$row[recordID]\">   $row[timeout]    </td>");
   	
    echo ("<td $badCols $newCall class=\"Tcomments editC\" 	id=\"comments:$row[recordID]\" 
    	onClick=\"empty('comments:$row[recordID]');\" > <div class='$class'> $row[comments] </div> </td>");
    	
    echo ("<td 			class=\"editCREDS toggleCREDS \" 	id=\"creds:$row[recordID]\"> 	 $row[creds] 	  </td>");
    echo ("<td 			class=\"toggleTOD cent \" 			id=\"timeonduty:$row[recordID]\">$row[time] 	  </td>");
    
	echo ("<td oncontextmenu=\"Tcounty MapCounty('$row[county]:$row[state]');return false;\" class=\"editcnty  cent \" id=\"county:$row[recordID]\">	 $row[county] 	  </td>");
    echo ("<td 			class=\"Tstate editstate  cent \" id=\"state:$row[recordID]\">	 $row[state] 	  </td>");
    echo ("<td 			class=\"Tdistrict editdist  cent \" id=\"district:$row[recordID]\">	 $row[district]	  </td>"); 
    
    echo ("<td class= \"dltRow\" id= \"delete:$row[recordID]\"> 
  				<a href= \"#\" class= \"delete cent\" >
    				<img alt= \"x\" border= \"0\" src= \"images/delete.png\" />
				</a>
		   </td>"); 	
} // Continue with $q <> 0 
     
         
} else if ($q == '0') {
       // removed during re-write   
}
	 } // End the foreach
	 
	 // Test to see if the net is open based on all stations having a time out 
	 $isopen = 0; // Default is NO not open
	  
	 	if ($num_rows <> $cnt_status) {$isopen = 1;} // this is YES its open
	 
	echo ("</tr></tbody>
		   <tfoot>
		   <tr>");
		   // This exception code shows this row in the log only if there is volunteer hours to report 2017-12-21
		   if ($tottime <> '00:00:00') {
			   echo "
		   		<td colspan='12' align='right'>Total Volunteer Hours = $tottime</td>
		   	   ";
		   }
	echo ("</tr>
		   </tfoot>
		   </table>"); //End of the table

	echo ("<div hidden id='freq2'>$row[frequency]</div>");
	echo ("<div hidden id='freq'></div");
	echo ("<div hidden id='type'>Type of Net:	$row[activity]</div>");
	echo ("<div hidden id='idofnet'>		 	$row[netID]</div>");
	echo ("<div hidden id='activity'>			$row[activity]</div>"); 
	echo ("<div hidden id='domain'>				$row[netcall]</div>");
	echo ("<div hidden id='thenetcallsign'> 	$row[netcall]</div>");
	echo ("<div hidden id='isopen' val=$isopen></div> <!-- 1 = yes this net is stillopen -->"); // 1 = yes this net is stillopen 
	
	// The subnetkey if > 0 places the value below the primary net table listing     /$row[frequency]&nbsp;&nbsp;
	echo ("<span id='add2pgtitle'>#$row[netID]/$row[netcall]/$freq&nbsp;&nbsp;");
	
	// Both of these items will show up if the net is both a child and a parent
	if ($subnetkey  == 1 ) { echo ("<button class='subnetkey' value='$subnetnum'>S/N of: $subnetnum</button>&nbsp;&nbsp;");}
	if ($children) { 		 echo ("<button class='subnetkey' value='$children' >Has S/N: $children</button>&nbsp;&nbsp;");}
	
	echo ("<span STYLE='background-color: #befdfc'>Control</span>&nbsp;&nbsp;");
			
	  
	  if ($digitalKey == 1 )   { echo ("<span class='digitalKey' >Digital</span>&nbsp;&nbsp;");} 
	  if ($trafficKey == 1 )   { echo ("<span class='trafficKey' >Traffic</span>&nbsp;&nbsp;");} 
	  if ($logoutKey  == 1 )   { echo ("<span class='logoutKey'  >Logged Out</span>&nbsp;&nbsp;");} 
	  if ($brbKey 	  == 1 )   { echo ("<span class='brbKey'     >BRB</span>&nbsp;&nbsp;");} 
	  if ($ioKey 	  == 1 )   { echo ("<span class='ioKey'      >In-Out</span>&nbsp;&nbsp;");}
	  if ($noCallKey  == 1 )   { echo ("<span class='redKey'     >Call Error</span>&nbsp;&nbsp;");}
	  if ($redKey	  == 1 )   { echo ("<span class='redKey'     >Call Error</span>&nbsp;&nbsp;");}
	  if ($dupeCallKey  == 1 ) { echo ("<span class='redKey'     >Duplicate</span>&nbsp;&nbsp;");}
	  if ($fliKey 		== 1 ) { echo ("<span class='fliKey'     >New Call</span>&nbsp;&nbsp;");}
	  
	echo ("</span>"); // ends the add2pgtitle div
	echo ("<div hidden id='logstatus'>			$row[status]</div>");		
?>
