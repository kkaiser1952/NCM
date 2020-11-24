<?php
error_reporting( 0 );
	//date_default_timezone_set("America/Chicago");
	require_once "dbConnectDtls.php";	    
	
	$q = intval($_GET['q']); 
	
	
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
	
		$children = $stmt->fetchColumn(1);
				
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
		//echo "$activity";
		//$toggleE = "toggleE"; // default value for the email class (column is hidden);
		$stmt2 -> execute(); // commented out 2017-11-22
		$prebuilt = $stmt2->fetchColumn(3); 
		
		/*
		$x = stripos($activity,"Meeting");
		$y = stripos($activity,"Event");
		
		if (empty($x) OR isset($x)) {$toggleE = "toggleE";}
		if (empty($y) OR isset($y)) {$togglePhone = "togglePhone";}
		
		if (stripos($activity,"Meeting") > 0 ) {$toggleE = ""; } // don't hide the column because its a 1 		
		if (strstr("$activity","Event") ) {$togglePhone = ""; } 
		*/
		
	$headerAll = '
		<table class="sortable" id="thisNet">
		<thead id="thead" style="text-align: center;">			
		<tr>            	
			<th title="Role"   >Role	 				</th>
			<th title="Mode" class="DfltMode cent" id="dfltmode">Mode			</th>
			
			<th title="Status" > 							 	Status	 				</th>  
			<th title="Traffic"> 							 	Traffic 				</th>
			
			<th title="TT No." 	  		class="c5" width="5%"	
				oncontextmenu="whatIstt();return false;">  	 	tt#	   				</th>
				 
			<th title="Call Sign"  						
				oncontextmenu="heardlist()">			   	 	Callsign 			</th>
			
			<th title="First Name"> 					   	 	First Name 				</th>
			<th title="Last Name" 	  	class="c8">  	 		Last Name  				</th>
			<th title="Tactical Call" 	class=""> 	 			Tactical   				</th>
			  
			<th title="Phone"     		class="c10"> 	 		Phone     				</th>
			<th title="email" 	  		class="c11">  	 		eMail    			   	</th>
			<th title="Grid"      		class="c20">    		Grid      				</th>
			
			<th title="Latitude"  		class="c21">    		Latitude  				</th>
			<th title="Longitude" 		class="c22">    		Longitude 				</th> 
			    
			<th title="Time In ">				   	 			Time In  			   	</th>
			<th title="Time Out">				   	 			Time Out 			   	</th>
			 
			<th title="Comments">				   	 			Time Line<br>Comments 	</th>           
			<th title="Credentials"  	class="c15"> 	 			Credentials 		</th>
			<th title="Time On Duty" 	class="c16">    		Time On Duty 			</th>
			
			<th title="County"   		class="c17">  	 		County 					</th> 
			<th title="State"    		class="c18"> 	 		State	 				</th>
			<th title="District" 		class="c19">  	 		Dist	 				</th>
		</tr>
		</thead>
	
		<tbody id="netBody">
		
		'; // END OF headerAll 
		
		  /* the sort order is determined by the number in each of the when clauses */
     if (($q) <> '0') {
			  	
	 	echo $headerAll;
			 
			  	$stmt = $db_found->prepare("SELECT frequency 
			  				 FROM `NetLog` 
			  				WHERE netID = $q
			  				  AND frequency <> ''
			  				  AND frequency NOT LIKE '%name%'");
	
			  				 
			  	$stmt->execute();
			  	$result = $stmt->fetch();
			  		$freq = $result[0];
			  				  	 
		  				  
	        $g_query = "SELECT  recordID, netID, subNetOfID, id,  callsign, tactical,  
	        					Fname, grid, traffic, latitude, longitude, netcontrol, 
	        					activity, Lname, email, active, comments, 
	        					creds, DATE_FORMAT(logdate, '%H:%i') as logdate, 
	        					DATE_FORMAT(timeout, '%H:%i') as timeout, 
	        					sec_to_time(timeonduty) as time, netcall, status, Mode, 
	        					TIMESTAMPDIFF(DAY, logdate , NOW()) as daydiff, county, 
	        					state, district, firstLogIn, phone, pb, tt, logdate as pbStat
	        				   
					FROM  NetLog 
					WHERE netID = $q
		  			ORDER BY case 
		  				when netcontrol = 'PRM' then 0 
		  				when netcontrol = '2nd' then 1 
		  				when netcontrol = 'Log' then 2
		  				when netcontrol = 'LSN' then 2
		  				when netcontrol in('EM','PIO') then 3
		  				when netcontrol in('3rd') then 4
		  				when active		= 'MISSING' then 5

		  				when active 	= 'In-Out' then 3999
		  				when active 	= 'Out' then 4000
		  				else logdate  
		  				end, 
		  			logdate DESC";   
		  			
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
  		$pbStat		= 0;
  		$editCS1	= "";
  		
  		$netTypes = array('Emergency','Priority','Welfare','Routine','Question','Announcement','Comment','Bulletin','Pending');
  		$os = array("PRM", "2nd", "LSN", "Log", "PIO", "EM"); // removed STB and EOC
		  			
//echo "$q <br> $sql <br> childeren= $children<br>sql2= $sql2<br>x= $x y= $y <br>freq= $freq<br>pbStat= $pbStat<br>";
		  			
	foreach($db_found->query($g_query) as $row) {
		++$num_rows; // Increment row counter for coloring background of rows
		
		$pbStat = $row[pbStat] + $pbStat; // just a number about pre-built
		
		if ($row[subNetOfID] > 0) {$subnetkey = 1;
			$subnetnum = "$row[subNetOfID]";
		} // a switch to turn on the value below
		
		// This accomidation because sometimes you need to edit the callsign especially for events 2019-01-27
		if ($row[pb] == 1) {
			$editCS1 = "editCS1";
		}
		  		
		 $cnt_status = $cnt_status + $row[status];

				 $bgcol = "                 ";
				 				 
				if ($row[netcall] == "") {$netcall = "All";}
				
				// Set background row color based on some parameters
				//$brbCols = ''; // Keeps the bacground color for each <td> empty unless below 5
				//$badCols = '';
				//$newCall = '';
				
				$brbCols = $badCols = $newCall = '';
				
				// #1 Important, traffic turns it red
				if (in_array("$row[traffic]",$netTypes)) {$bgcol = 'bgcolor="#ff9cc2"';
					$trafficKey = 1;
				}
					
				// #2 If netcontrol is in the above array turn it blue
				else if (in_array($row[netcontrol], $os)) {
					$bgcol = 'bgcolor="#bae5fc"';
				}
				
				else if ($row[Mode] == "Dig") {
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
					$bgcol = 'bgcolor="#eaf2d3"'; }
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
				}
				
				else if ($row[active] == "In-Out") {
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

				// The first <tr> is above at the end of the head
		echo ("
    	<td      	 class=\"editable_selectNC   cent\" id=\"netcontrol:$row[recordID]\">$row[netcontrol] 	</td> 
    	<td $brbCols class=\"editable_selectMode cent\" id=\"Mode:$row[recordID]\">      $row[Mode]       	</td>
    	<td $brbCols class=\"editable_selectACT  cent\" id=\"active:$row[recordID]\">    $row[active] 	  	</td>    
    	<td $brbCols class=\"editable_selectTFC\"		id=\"traffic:$row[recordID]\">	 $row[traffic] 	  	</td>
    	
    	<td $brbCols	id=\"tt:$row[recordID]\"class=\"editTT cent c5 TT\"title=\"TT No. $row[tt] no edit\"data-pb=\"$row[pb]\">$row[tt] 																		</td>
    	
		<td $brbCols $newCall $badCols class=\"cs1 $editCS1 \" oncontextmenu=\"getCallHistory('$row[callsign]');return false;\"id=\"callsign:$row[recordID]\"title=\"Call Sign $row[callsign] no edit\"> 
    		   $row[callsign]   				  															</td>
    	   
    	<td $newCall $brbCols	class=\"editFnm\"	id=\"Fname:$row[recordID]\"> 	 $row[Fname] 	  		</td>
		<td class=\"editLnm c8\"	id=\"Lname:$row[recordID]\"style=\'text-transform:capitalize\'> 															 					     $row[Lname] 	  				</td>
		<td $brbCols class=\"editTAC cent\"	id=\"tactical:$row[recordID]\"style=\'text-transform:uppercase\'> 
    		$row[tactical]   																				</td>	 
    	
    	<td class=\"editPhone c10 cent\" id=\"phone:$row[recordID]\"> $row[phone] 	  						</td>
    	<td class=\"editEMAIL c11 \" id=\"email:$row[recordID]\">  	  $row[email] 	   						</td>
		<td oncontextmenu=\"MapGridsquare('$row[latitude]:$row[longitude]:$row[callsign]');return false;\"class=\"editGRID c20 \"id=\"grid:$row[recordID]\"> 	 $row[grid] 	  						</td>
		
		<td class=\"editLAT c21 \"	 id=\"latitude:$row[recordID]\">  $row[latitude]   						</td>
    	<td class=\"editLON c22 \"	 id=\"longitude:$row[recordID]\"> $row[longitude]  						</td>
    	
    	<td $brbCols class=\"editTimeIn cent\"  id=\"logdate:$row[recordID]\">   $row[logdate]    			</td>
    	<td $brbCols class=\"editTimeOut cent\" id=\"timeout:$row[recordID]\">   $row[timeout]    			</td>
    	
		<td $badCols $newCall class=\"editC\"	id=\"comments:$row[recordID]\"
    	onClick=\"empty('comments:$row[recordID]');\"> <div class='$class'> $row[comments] </div>			</td>
    	
    	<td class=\"editCREDS c15 \"	 id=\"creds:$row[recordID]\"> 	 $row[creds] 	  					</td>
    	<td class=\"toggleTOD c16 cent\" id=\"timeonduty:$row[recordID]\">$row[time] 	  					</td>
    	
    	<td oncontextmenu=\"MapCounty('$row[county]:$row[state]');return false;\" 
    	class=\"editcnty c17 cent \"id=\"county:$row[recordID]\">$row[county]								</td>
    	
	    <td class=\"editstate c18 cent\" id=\"state:$row[recordID]\">	 $row[state] 	  					</td>
	    <td class=\"editdist  c19 cent\" id=\"district:$row[recordID]\"> $row[district]	  					</td>
	    
	    <td class=\"dltRow\"id=\"delete:$row[recordID]\"> 
  			<a href=\"#\"class=\"delete cent\">
    			<img alt=\"x\"border=\"0\"src=\"images/delete.png\"/>
			</a>
		</td>
    	");	
		  	} // End of query run
     } // end of <> 0		
     
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
	echo ("<div hidden id='pbStat'>$pbStat</div>"); // has there been at least one check-in to this pre-built net?
	
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
