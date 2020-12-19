<?php
error_reporting( 0 );
	//date_default_timezone_set("America/Chicago");
	require_once "dbConnectDtls.php";    
	
	$q = intval($_GET['q']); 
	
	// read the time diff from UTC for the local time
	if(!isset($_COOKIE[tzdiff])) {
    	//echo "Cookie named '" . tzdiff . "' is not set!";
    }else { 
        $tzdiff = $_COOKIE[tzdiff]/-60; 
        $tzdiff = "$tzdiff:00";         //echo("tzdiff= $tzdiff");
    }
	
	
	function time_elapsed_A($secs){
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
        );
        
    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;
        
    return join(' ', $ret);
    }
	
	//echo("q: $q tz: $tz"); // when  show all station in DB then q = 0
	//$q = 1208;
	
if ( $q <> 0 ){
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
		$netcall = trim($stmt2->fetchColumn(1)); //echo "$netcall<br>"; // TE0ST
		
		$stmt2 -> execute(); // commented out 2017-11-22
		$activity = trim($stmt2->fetchColumn(2)); 

		$stmt2 -> execute(); // commented out 2017-11-22
		$prebuilt = $stmt2->fetchColumn(3); 
			
     // this causes the entire NCM to crash... i have no idea why?		
    $sql9 = "SELECT columnViews
              FROM NetKind
             WHERE `call` = '$netcall'
           ";
    $stmt9 = $db_found->prepare($sql9);
   // echo "$sql9";
    $stmt9->execute();
    $theCookies = $stmt9->fetchColumn(0);
   // echo "from sql9: $theCookies";
    
} // end of q <> 0	
	//	include "headerDefinitions.php";
		
	$headerAll = '
		<table id="thisNet" >
		<thead id="thead" class="forNums" style="text-align: center;" >			
		<tr>            	
		    <th title="Row No." class="besticky c0" > &#35 </th> 
			<th title="Role" class="besticky c1">	Role </th>
			<th title="Mode" class="besticky DfltMode cent c2" id="dfltmode" 
			    oncontextmenu="setDfltMode();return false;"> Mode </th>
			
			<th title="Status" class="besticky c3" > Status </th>  
			<th title="Traffic" class="besticky c4"> Traffic </th>
			
			<th title="TT No. The assigned APRS TT number." class="besticky c5" width="5%"	
				oncontextmenu="whatIstt();return false;"> tt# </th>
            <th title="Band" class="besticky c23" width="5%"> Band </th>
			<th title="Call Sign" class="besticky c6"	oncontextmenu="heardlist()"> Callsign </th>
			
			<th title="TRFK-FOR" class="besticky c50">TRFK-FOR</th>
			<!--
			<th title="Section" class="besticky c51"> Section </th>
			-->
			<th title="First Name" class="besticky c7">	First Name </th>
			 
			<th title="Last Name" class="besticky c8"> Last Name </th>
			
			<th title="Tactical Call, Click to change. Or type DELETE to delete entire row." class="besticky c9" oncontextmenu="Clear_All_Tactical()"> Tactical </th>
			  
			<th title="Phone, Enter phone number." class="besticky c10"> Phone </th>
			
			<th title="email, Enter email address." class="besticky c11"
			    oncontextmenu="sendGroupEMAIL()"> eMail </th>
			    
			<th title="Grid, Maidenhead grid square location." class="besticky c20"> Grid </th>
			
			<th title="Latitude"  class="besticky c21"> Latitude  </th>
			<th title="Longitude" class="besticky c22"> Longitude </th> 
			    
			<th title="Time In, Not for edit. " class="besticky c12" > Time In </th>
			<th title="Time Out, Not for edit." class="besticky c13"> Time Out </th>
			 
			<th title="Comments, All comments are saved." class="besticky c14">	Time Line<br>Comments </th>           
			<th title="Credentials" class="besticky c15"> Credentials </th>
			<th title="Time On Duty" class="besticky c16"> Time On Duty </th>
			
			<th title="County" class="besticky c17"> County </th> 
			<th title="State" class="besticky c18"> State	</th>
			<th title="District" class="besticky c19"> Dist </th>
			<th title="W3W, Enter a What 3 Words location. " class="besticky c24" oncontextmenu="openW3W();"> W3W </th>
			    <!-- Admin Level -->
            <th title="recordID" class="besticky c25"> recordID </th>
            <th title="ID" class="besticky c26"> ID </th>
            <th title="status" class="besticky c27"> status </th>
            <th title="home" class="besticky c28"> home </th>
            <th title="ipaddress" class="besticky c29"> ipaddress </th>
			 			
		</tr>
		</thead>
	
		<tbody class="sortable" id="netBody">
		
		'; // END OF headerAll 
		

		  /* the sort order is determined by the number in each of the when clauses */
   //  if (($q) <> '0') {
			  	
	 	echo $headerAll;	 	
	 	
	 	       $isopen = 0; // furture test to see if net is open or closed
			 
                // Get the frequency from NetLog
			  	$stmt = $db_found->prepare("SELECT frequency, MIN(status) as minstat, MIN(logdate) as startTime, MAX(timeout) as endTime
			  				 FROM `NetLog` 
			  				WHERE netID = $q
			  				  AND frequency <> ''
			  				  AND frequency NOT LIKE '%name%'
			  				 LIMIT 0,1  
			  			");
			  				 
			  	$stmt->execute();
			  	$result = $stmt->fetch();
			  	$freq = $result[frequency];
			  	$isopen = $result[minstat];  // 0 means its open (not closed), 1 means its closed (YES closed)
			  	  if ($isopen == 1 ) { // Net is closed 
                    $nowtime = strtotime($result[endTime]);
                    $startTime = $result[startTime];
                    /// Good place to add a remark between buttn bar and net table
                    echo "<span style='color:red; float:left;'>$netcall ==> This Net is Closed, not available for  edit</span>";
                  } else if ($isopen == 0 ) { // Net is open
                    $nowtime = time(); 
                    $startTime = $result[startTime];
                  }
			 
    // This SQL pulls the appropriate records for the net requested
    // This also determines the sort order the rows appear in.
    if ($q <> 0) {   	  	 	  				  
	        $g_query = "SELECT  recordID, netID, subNetOfID, id, TRIM(callsign) AS callsign, tactical,  
	        					Fname, grid, traffic, latitude, longitude, netcontrol, 
	        					activity, Lname, email, active, comments, logdate as startdate,
	        					creds, DATE_FORMAT(logdate, '%H:%i') as logdate, 
	        					DATE_FORMAT(timeout, '%H:%i') as timeout, 
	        					sec_to_time(timeonduty) as time, netcall, status, Mode, 
	        					TIMESTAMPDIFF(DAY, logdate , NOW()) as daydiff, 
	        					county, 
	        					state, district, firstLogIn, phone, pb, tt, 
	        					logdate =
                                	CASE
                                    	WHEN pb = 1 AND logdate = 0 THEN 1
                                        ELSE 0
                                    end as pbStat,
	        				/*	logdate as pbStat, */
	        					band, w3w,
	        					home, ipaddress, cat, section,
	        					DATE_FORMAT(CONVERT_TZ(logdate,'+00:00','$tzdiff'), '%H:%i') as locallogdate,
	        					DATE_FORMAT(CONVERT_TZ(timeout,'+00:00','$tzdiff'), '%H:%i') as localtimeout,
	        					row_number
	        				   
					FROM  NetLog 
					WHERE netID = $q
		  			ORDER BY case 
		  				when netcontrol = 'PRM' then 0 
		  				when netcontrol in('2nd','3rd','Log','LSN','PIO','EM','SEC') then 1
		  				when active		= 'MISSING' then 2
		  				when active		= 'BRB' then 2
		  				when active 	in('In-Out', 'Out') then 3999
		  				else logdate  
		  				end, 
		  			logdate DESC";   
		  			
    }else if ($q == 0) {
        
	        $g_query = "SELECT DISTINCT callsign, CONCAT(Fname,' ',Lname) as name, email, phone, creds,
	                                    county, state, district, sum(timeonduty) as Vhours
                          FROM NetLog
                        WHERE id <> 0
                          AND netID <> 0
                        GROUP BY id
                        ORDER BY callsign
	        ";
    } // end else
		  			
  		$trafficKey = 0;
  		$logoutKey  = 0;
  		$digitalKey = 0;
  		$brbKey	    = 0;
  		$ioKey		= 0;
  		$noCallKey  = 0;
  		$dupeCallKey= 0;
  		$num_rows   = 0;   // Counters to color row backgrounds in loop below
  		$cnt_status = 0;
  		$subnetkey	= 0;
  		$pbStat		= 0;
  		$bandkey    = 0;
  		$editCS1	= "";
  		//$isopen     = 0;
  		
  		include "dropdowns.php";
			
	foreach($db_found->query($g_query) as $row) {
		++$num_rows; // Increment row counter for coloring background of rows
		
		$pbStat = $row[pbStat] + $pbStat; // just a number about pre-built
		
		if ($row[subNetOfID] > 0) {
    		    $subnetkey = 1;
			$subnetnum = "$row[subNetOfID]";
		} // a switch to turn on the value below
		
		// This accomidation because sometimes you need to edit the callsign especially for events 2019-01-27
		if ($row[pb] == 1) {
			$editCS1 = "editCS1";
		}
		  		
		 $cnt_status = $cnt_status + $row[status];
         $brbCols = "                 ";
				
				// Set background row color based on some parameters
				
				$modCols = $brbCols = $badCols = $newCall = $timeline = $important1 = $important2 = '';
				$f = '<font color="black">';
				
				// This PHP contians all the column color assignments based on various cell values
			    include "colColorAssign.php";

				
				$id = str_pad($row[id],2,'0', STR_PAD_LEFT);
				
				echo ("<tr  id=\"$row[recordID]\">");
				
				// To make the comments <td> scrollable but still stay at the default height if is not needed
				// this code checks if there are commets and changes the class name, a simple solution.
				// Also used in getTimeLog.php
					$class = empty($row[comments]) ? 'nonscrollable' : 'scrollable' ;
					$class = strlen($row[comments]) < 300 ? 'nonscrollable' : 'scrollable' ;

				// The first <tr> is above at the end of the head
				
        // This PHP creates each row (<td>)
		include "rowDefinitions.php";
		
		  	} // End of query run
	 	
	 	//$nowtime = time();
	 	$runtime = time_elapsed_A($nowtime - strtotime($startTime));
	 
	echo ("</tr></tbody>
		   <tfoot>
		   <tr>");
		   // This exception code shows this row in the log only if there is volunteer hours to report 2017-12-21
		   //if ($tottime <> '00:00:00') {
			   echo "
			    <td></td>
			    <td class='runtime' colspan='5' align='left'>Run Time: $runtime </td>
		   		<td class='tvh' colspan='8' align='right'>Total Volunteer Hours = $tottime</td>
		   	   ";
		   //}
		 
	echo ("</tr>
		   </tfoot>
		   </table>"); //End of the table

	echo ("<div hidden id='freq2'>              $row[frequency] </div>");
	echo ("<div hidden id='freq'>                               </div");
	echo ("<div hidden id='cookies'>            $theCookies     </div");
	echo ("<div hidden id='type'>Type of Net:	$row[activity]  </div>");
	echo ("<div hidden id='idofnet'>		 	$row[netID]     </div>");
	echo ("<div hidden id='activity'>			$row[activity]  </div>"); 
	echo ("<div hidden id='domain'>				$row[netcall]   </div>");
	echo ("<div hidden id='thenetcallsign'> 	$row[netcall]   </div>");
	echo ("<div hidden id='isopen' val=$isopen> $isopen</div> <!-- 1 = yes this net is still open -->"); // 1 = yes this net is stillopen 
	echo ("<div hidden id='pbStat'>$pbStat</div>"); // has there been at least one check-in to this pre-built net?
	
	// The subnetkey if > 0 places the value below the primary net table listing     /$row[frequency]&nbsp;&nbsp;
	echo ("<span id='add2pgtitle'>#$row[netID]/$row[netcall]/$freq&nbsp;&nbsp;");
	
	// Both of these items will show up if the net is both a child and a parent
	if ($subnetkey  == 1 ) { echo ("<button class='subnetkey' value='$subnetnum'>Sub Net of: $subnetnum</button>&nbsp;&nbsp;");}
	if ($children) { 		 echo ("<button class='subnetkey' value='$children' >Has Sub Net: $children</button>&nbsp;&nbsp;");}
	
	echo ("<span STYLE='background-color: #befdfc'>Control</span>&nbsp;&nbsp;");
			
	  // These span and class all appear under the curren net depending which is in use
	  if ($digitalKey  == 1 ) { echo ("<span class='digitalKey' >Digital</span>&nbsp;&nbsp;");} 
	  if ($trafficKey  == 1 ) { echo ("<span class='trafficKey' >Traffic</span>&nbsp;&nbsp;");} 
	  if ($logoutKey   == 1 ) { echo ("<span class='logoutKey'  >Logged Out</span>&nbsp;&nbsp;");} 
	  if ($brbKey 	   == 1 ) { echo ("<span class='brbKey'     >BRB</span>&nbsp;&nbsp;");} 
	  if ($ioKey 	   == 1 ) { echo ("<span class='ioKey'      >In-Out</span>&nbsp;&nbsp;");}
	  if ($noCallKey   == 1 ) { echo ("<span class='redKey'     >Call Error</span>&nbsp;&nbsp;");}
	  if ($redKey	   == 1 ) { echo ("<span class='redKey'     >Call Error</span>&nbsp;&nbsp;");}
	  if ($dupeCallKey == 1 ) { echo ("<span class='redKey'     >Duplicate</span>&nbsp;&nbsp;");}
	  if ($fliKey      == 1 ) { echo ("<span class='fliKey'     >New Call</span>&nbsp;&nbsp;");}
	  if ($prioritykey == 1 ) { echo ("<span class='redKey'     >Priority</span>&nbsp;&nbsp;");}
	  
	  echo ("<span class='export2CSV' style='padding-left: 150pt;'>
	  <a href=\"#\" onclick=\"window.open('netCSVdump.php?netID=' + $('#idofnet').html())\" >Export CSV</a>
	  </span>");
	  
	echo ("</span>"); // ends the add2pgtitle div
	echo ("<div hidden id='logstatus'>			$row[status]</div>");	
?>
