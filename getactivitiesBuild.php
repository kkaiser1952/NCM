<?php
	// 2019-02-06
	// This will eventually become the source for the displayed table.
	// Edit column class' will be added via the AddClass() function in CallEditFunction.js
	// Toggling of columns is done using cookieManagement.js and it various parts
		
echo '
	<table id="thisNet">
		<thead id="thead" class="forNums" style="text-align: center;">			
		<tr>            	
		    <th title="Row No." class="" > &#35 </th>
			<th title="Role"   > 							 	Role	 				</th>
			<th title="Mode"   > 							 	Mode	 				</th>
			<th title="Status" > 							 	Status	 				</th>  
			<th title="Traffic"> 							 	Traffic 				</th>
			
			<th title="TT No." 	  		class="" width="5%"	
				oncontextmenu="whatIstt();return false;">  	 	tt#	   					</th>
				 
			<th title="Call Sign"  						
				oncontextmenu="heardlist()">			   	 	Callsign 				</th>
			
			<th title="First Name"> 					   	 	First Name 				</th>
			<th title="Last Name" 	  	class="">  	 			Last Name  				</th>
			<th title="Tactical Call" 	class=""> 	 			Tactical   				</th>
				  
			<th title="Phone"     		class=""> 	 			Phone     				</th>
			<th title="email" 	  		class="">  	 			eMail    			   	</th>
			<th title="Grid"      		class="">    			Grid      				</th>
			<th title="Latitude"  		class="">    			Latitude  				</th>
			
			<th title="Longitude" 		class="">    			Longitude 				</th>     
			<th title="Time In ">				   	 			Time In  			   	</th>
			<th title="Time Out">				   	 			Time Out 			   	</th>
			 
			<th title="Comments">				   	 			Time Line<br>Comments 	</th>           
			<th title="Credentials"  	class=""> 	 			Credentials 			</th>
			<th title="Time On Duty" 	class="">    			Time On Duty 			</th>
			
			<th title="County"   		class="">  	 			County 					</th> 
			<th title="State"    		class=""> 	 			State	 				</th>
			<th title="District" 		class="">  	 			Dist	 				</th>
		</tr>
		</thead>
	
		<tbody class="sortable" id="netBody">
		<tr>
		    <td          class="cent"> </td>
	    	<td      	 class="netcontrol cent" id="netcontrol:$row[recordID]">   $row[netcontrol] </td> 
	    	<td $brbCols class="mode cent" 		 id="Mode:$row[recordID]">         $row[Mode]       </td>	    
			<td $brbCols class="role cent" 		 id="active:$row[recordID]">       $row[active] 	</td>    
	    	<td $brbCols class="traffic "		 id="traffic:$row[recordID]">	   $row[traffic]    </td>   
	    	
    
	    	<td $brbCols class="cent TT"			  
	    		id="tt:$row[recordID]"
	    		title="TT No. $row[tt] no edit"
	    		data-pb="$row[pb]"> 
	    		$row[tt] 
	    	</td>
	    	
			<td $brbCols $newCall $badCols 
				class="cs1" 
				oncontextmenu="getCallHistory(\"$row[callsign]");return false;"
				id="callsign:$row[recordID]" 
				title="Call Sign $row[callsign] no edit"> 
				$row[callsign]   				  
	    	</td> 
	    	   
	    	<td $newCall $brbCols class="Fname"   		  id="Fname:$row[recordID]"> 	    $row[Fname] 	</td>
	    	
			<td class="Lname" id="Lname:$row[recordID]"
				style="text-transform:capitalize"> 
				$row[Lname] 	  
			</td>
			
			<td $brbCols class="tactical cent" 			  id="tactical:$row[recordID]" 
				style="text-transform:uppercase"> 
	    		$row[tactical]   
	    	</td> 
	    									 					 
	    	<td class="phone cent" 	  id="phone:$row[recordID]"> 	   $row[phone] 	  	</td>
	    	<td class="email cent" 	  		  id="email:$row[recordID]"> 	   $row[email] 	  	</td>
	    	
			<td class="grid" 				  id="grid:$row[recordID]"
				oncontextmenu="MapGridsquare(\"$row[latitude]:$row[longitude]:$row[callsign]\");return false;">
				$row[grid] 	  
			</td> 
	        
	    	<td class="latitude"	 			  		  id="latitude:$row[recordID]">    $row[latitude]   </td>
	    	<td class="longitude"	 			  		  id="longitude:$row[recordID]">   $row[longitude]  </td>
	      
	    	<td $brbCols class="logdate cent"  		  	  id="logdate:$row[recordID]">     $row[logdate]    </td>
	    	<td $brbCols class="timeout cent" 		  	  id="timeout:$row[recordID]">     $row[timeout]    </td>
	    	
			<td $badCols $newCall class="comments"		  id="comments:$row[recordID]"
	    		onClick="empty(\"comments:$row[recordID]\");"> 
	    		<div class="$class"> $row[comments] </div> 
	    	</td> 
	    	
	    	<td class="creds"			 				  id="creds:$row[recordID]"> 	   $row[creds]   	</td>
	    	<td class="timeonduty cent"					  id="timeonduty:$row[recordID]">  $row[time] 	  	</td> 
	    	
	    	<td class="county cent"						  id="county:$row[recordID]"
	    		oncontextmenu="MapCounty(\"$row[county]:$row[state]\");return false;">
	    		$row[county] </td>
	    		
	    	<td class="state cent" 					  	  id="state:$row[recordID]">	   $row[state] 	   </td>
	    	<td class="district cent" 					  id="district:$row[recordID]">    $row[district]  </td>
    
			<!-- This is the delete button at the end -->
	    	<td class="dltRow"id="delete:$row[recordID]"> 
	  			<a href="#"class="delete cent">
	    			<img alt="x"border="0"src="images/delete.png"/>
				</a>
			</td> 

		</tr>
		</tbody>
';
?>
