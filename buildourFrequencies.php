<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";

    $call = $_GET["call"];   //$call = 'W0KCN';
   // $netid = $_GET["netid"];
   
   $netid = 6066;
	
	// get only one record for a return */
	$sql = ("SELECT row1, row2, row3, row4, row5, row6
			  FROM `meta`
			  WHERE `call` LIKE '%$call%'
			  ORDER BY `call` LIMIT 1
		   "); 
			  
			foreach($db_found->query($sql) as $row) {
				++$num_rows;
				$rcols = explode(",","$row[row1]");
					$r1c1 = $rcols[0];
					$r1c2 = $rcols[1];
		    		$r1c3 = $rcols[2];
		    		$r1c4 = $rcols[3];
		    		
		    	$rcols = explode(",","$row[row2]");
					$r2c1 = $rcols[0];
		    		$r2c2 = $rcols[1];
		    		$r2c3 = $rcols[2];
		    		$r2c4 = $rcols[3];
		    		
		    	$rcols = explode(",","$row[row3]");
					$r3c1 = $rcols[0];
		    		$r3c2 = $rcols[1];
		    		$r3c3 = $rcols[2];
		    		$r3c4 = $rcols[3];
		    		
		    	$rcols = explode(",","$row[row4]");
					$r4c1 = $rcols[0];
		    		$r4c2 = $rcols[1];
		    		$r4c3 = $rcols[2];
		    		$r4c4 = $rcols[3];

				$rcols = explode(",","$row[row5]");
					$r5c1 = $rcols[0];
		    		$r5c2 = $rcols[1];
		    		$r5c3 = $rcols[2];
		    		$r5c4 = $rcols[3];
		    		
		    	$rcols = explode(",","$row[row6]");
					$r6c1 = $rcols[0];
		    		$r6c2 = $rcols[1];
		    		$r6c3 = $rcols[2];
		    		$r6c4 = $rcols[3];
		}		
 
	    		
		echo(" <table id='ourfreqs'> ");
		
		echo(" <tr> <th class='r1c1 nobg'>$r1c1</th> 
					<th class='r1c2 nobg'>$r1c2</th>
			   		<th class='r1c3 nobg'>$r1c3</th> 
			   		<th class='r1c4 nobg'>$r1c4</th> </tr> ");
			   		
		echo(" <tr> <td class='r2c1 nobg1'>$r2c1</td> 
					<td class='r2c2 nobg2'>$r2c2</td>
			   		<td class='r2c3 nobg2'>$r2c3</td> 
			   		<td class='r2c4 nobg2'>$r2c4</td> </tr> ");
			   		
		echo(" <tr> <td class='r3c1 nobg1'>$r3c1</td> 
					<td class='r3c2 nobg2'>$r3c2</td>
			   		<td class='r3c3 nobg2'>$r3c3</td> 
			   		<td class='r3c4 nobg2'>$r3c4</td> </tr> ");
			   		
		echo(" <tr> <td class='r4c1 nobg1'>$r4c1</td> 
					<td class='r4c2 nobg'>$r4c2</td>
			   		<td class='r4c3 nobg'>$r4c3</td>  
			   		<td class='r4c4 nobg'>$r4c4</td> </tr> ");
			   		
		echo(" <tr> <td class='r5c1 nobg1'>$r5c1</td> 
					<td class='r5c2 nobg2'>$r5c2</td>
			   		<td class='r5c3 nobg2'>$r5c3</td> 
			   		<td class='r5c4 nobg2'>$r5c4</td> </tr> ");
		if ($call != 'DMR'){
		echo(" <tr> <td class='r6c1 nobg1'>$r6c1</td> 
					<td class='r6c2 nobg2' colspan=3> 
					<a href=\"$r6c2\" target=\"_blank\"> $r6c2 </a></td> ");
					
		} else if ($call == 'DMR'){
		echo(" <tr> <td class='r6c1 nobg1'>$r6c1</td> 
					<td class='r6c2 nobg2'>$r6c2</td>
					<td class='r6c3 nobg2'>$r6c3</td> 
					<td class='r6c4 nobg2'>$r6c4</td> </tr> ");
		}   		
			/*
		echo("</table>");
		*/
		
		
		echo('<tr>
		       <td class="nobg2" colspan="4">
			       <div id="KCNARESinfo">

				       <a id="preambledev" onclick="openPreamble()" rel="modal:open" title="Click for the preamble">Preamble &nbsp;||&nbsp;</a>
				       					   
					   <a id="agendadiv" onclick="openAgenda()" rel="modal:open" title="Click for the agenda">Agenda &nbsp;||&nbsp;</a>
					   
				       <a href="buildEvents.php" target="_blank" style="color:red;" title="Click to create a new preamble, agenda or announcment">New </a>&nbsp;||&nbsp;
				  
				  	   <a id="closingdev" onclick="openClosing()" rel="modal:open" title="Click for the closing script">Closing &nbsp;||&nbsp;</a>
				       
				  	   <span class="dropdown">
					   		<span class="dropbtn">Reports &nbsp;||&nbsp;</span>
							  <div class="dropdown-content">
								<a href="NCMreports.php" target="_blank" title="Stats about NCM">Statistics</a>
							<a href="commplan.php" target="_blank" title="The MECC Communications Plan">MECC Comm Plan</a>	
							   <a href="NCMMaps.php" target="_blank" title="Map show the location of stations">Map Home Locations of The Check-ins </a> 
						       <a href="#" onclick="AprsFiMap(); return false;" title="APRS FI Map of stations logged into the active net">Show APRS.fi presence</a>
							    
					<!--		    <a href="getList.php?q=0">List All Stations</a> -->
						
								<a href="#" id="ics214button" onclick="ics214button()" 
									title="ICS-214 Report of the active net" >ICS-214</a>
							  </div>
					   </span>
					   <a id="helpdev" href="help.html" target="_blank" 
					   		title="Click for the extended help document">Help</a>
				       
			       </div>
		       </td>
	       </tr> 
	       	</table>
		');
		
	
			   	
	//echo('</body></html>');	
?>