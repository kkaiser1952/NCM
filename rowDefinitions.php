    <?php
	//Written: 2019-04-04
	// This PHP is used in getactivities.php and checkIn.php to define each row (<td>)
	//$f = '<font color="black">';  
	
	// need to adjust for a number with spaces on either side, this is in the tactical column
	$numsort = '';
	$tacNO = number_format(intval(preg_replace('/[^0-9.]/','',$row['tactical'])));
    //$tacNO = number_format(intval(preg_replace('(?:[ ])[0-9]+(?:[ ])','',$row[tactical])));
	    if ($tacNO) {
    	    $numsort = "sorttable_customkey=$tacNO";
	    }
	
echo (" 

        <td class=\"cent c0 \" >     </td>  <!-- needs $row[row_number] -->
        
    	<td $brbCols class=\"editable editable_selectNC cent c1 \" 
    	    id=\"netcontrol:$row[recordID]\"  data-role=\"$row[netcontrol]\"> 
    	    $row[netcontrol]
        </td> 
        
       
         
    	<td $modCols $brbCols class=\"editable editable_selectMode cent c2 Mode$row[recordID] \" 
    	    id=\"Mode:$row[recordID]\" data-mode=\"$row[Mode]\"> 
    	    $row[Mode]
        </td>
        
    	<td $important1 $brbCols class=\"editable editable_selectACT  cent c3 status$row[recordID] \" 
    	    oncontextmenu=\"rightClickACT('$row[recordID]');return false;\"
    	    id=\"active:$row[recordID]\"  data-status=\"$row[active]\"> 
    	    $row[active]
        </td>  
        
        <td $important2 $brbCols class=\"editable editable_selectTFC c4 traffic$row[recordID] \"
    	    oncontextmenu=\"rightClickTraffic('$row[recordID]');return false;\"   
    	    id=\"traffic:$row[recordID]\"  data-traffic=\"$row[traffic]\">  
    	    $row[traffic]           
        </td>
        
        <td $brbCols class=\"editable editTT cent c5 TT\" 
    	    id=\"tt:$row[recordID]\"
    	    title=\"TT No. $row[tt] no edit\"> 
    	    $row[tt] 
        </td>
    	    	
    	<td $brbCols class=\"editable editBand c23\" 
    	    id=\"band:$row[recordID]\"
    	    title=\"$row[band] Band \" > 
    	    $row[band]  
        </td>

   
        <td $timeline $brbCols $badCols 
            class=\"editable editfacility c33 \"	
            id=\"facility:$row[recordID]\"      
            onClick=\"empty('facility:$row[recordID]'); \"> 
                $row[facility]       
        </td>
        
        <td $brbCols
            class=\"editable editonSite c34 \"	
            oncontextmenu=\"rightClickOnSite('$row[recordID]');return false;\"
            id=\"onsite:$row[recordID]\" 
            data-onsite=\"$row[onsite]\">
             $row[onSite]	       
        </td>
    	
    	    	
        <td $newCall $brbCols $badCols $cs1Cols
            class=\"editable cs1 $editCS1 c6 \" 
            id=\"callsign:$row[recordID]\"
            oncontextmenu=\"getCallHistory('$row[callsign]');return false;\" 
            
            ondblclick=\"doubleClickCall('$row[recordID]', '$row[callsign]', '$row[netID]');return false;\"
            
            title=\"Call Sign $row[callsign] no edit\"> 
            $row[callsign]  
        </td>
        
        <!-- TRFK-FOR -->
        <td $brbCols class=\"editable editCat cent c50 \" 
            id=\"cat:$row[recordID]\"
            style=\"text-transform: uppercase; color:green;\"
            onClick=\"empty('cat:$row[recordID]');\"> 
    	    <div class='$class'>$row[cat] </div>
        </td>
      <!--
        <td $brbCols class=\"editable editSec cent c51 \" 
    	    id=\"section:$row[recordID]\"
    	    title=\"Section $row[section] \"> 
    	    $row[section] 
        </td>
       -->
    	<td $newCall $brbCols class=\"editable editFnm c7 \"
    	    style=\"text-transform:capitalize\"	
    	    id=\"Fname:$row[recordID]\"
    	    onClick=\"empty('Fname:$row[recordID]');\"> 	 
    	    <div class='$class'> $row[Fname] </div>	  		          
        </td>    
        
        <td $newCall $brbCols class=\" editable editLnm c8 \"	
            id=\"Lname:$row[recordID]\" style=\"text-transform:capitalize\"
            onClick=\"empty('Lname:$row[recordID]');\"> 
            <div class='$class'> $row[Lname] </div>	      
        </td>
    
    <!-- Removed style=\"text-transform:uppercase\" on 2021-11-18 by request -->
    <!-- if you want to add it back, see if you can build it into the group profile or cookies -->
        <td $brbCols $numsort
            class=\"editable editTAC cent c9 \"	
            id=\"tactical:$row[recordID]\"
            
            onClick=\"empty('tactical:$row[recordID]');\">
            <div class='$class'> $row[tactical] </div> 
        </td>	 
    	
        <td $brbCols class=\"editable editPhone c10 cent\" 
            id=\"phone:$row[recordID]\"> 
            $row[phone] 	  						
        </td>
        
        <td $brbCols class=\"editable editEMAIL c11 \" 
            oncontextmenu=\"sendEMAIL('$row[email]','$row[netID]');return false;\"
            id=\"email:$row[recordID]\">
            $row[email]	   						
        </td>
        
        <td $brbCols class=\"editable editGRID c20 \"
            id=\"grid:$row[recordID]\"
            style=\"text-transform:uppercase\"
            oncontextmenu=\"MapGridsquare('$row[latitude]:$row[longitude]:$row[callsign]');return false;\"
            onClick=\"empty('grid:$row[recordID]');\"> 
            <div class='$class'> $row[grid] </div> 						
        </td>
    		
        <td $brbCols class=\"editable editLAT c21 \"	 
            oncontextmenu=\"getCrossRoads('$row[latitude],$row[longitude]');return false;\"
            id=\"latitude:$row[recordID]\"
            onClick=\"empty('latitude:$row[recordID]');\"> 
            $row[latitude]   						
        </td>
        
    	<td $brbCols class=\"editable editLON c22 \"
    	    oncontextmenu=\"getCrossRoads('$row[latitude],$row[longitude]');return false;\"
    	    id=\"longitude:$row[recordID]\"
    	    onClick=\"empty('longitude:$row[recordID]');\"> 
    	    $row[longitude]  						
        </td>
    	
    	<td $brbCols class='editable editTimeIn cent c12 '  
    	    id='logdate:$row[recordID]'>   
            <span class='tzld'> $row[logdate] </span>
            <span class='tzlld hidden'> '$row[locallogdate]' </span>
        </td>
        
    	<td $brbCols class='editable editTimeOut cent c13 ' 
    	    id='timeout:$row[recordID]'>   
    	    <span class='tzto'> $row[timeout] </span>
            <span class='tzlto hidden'> '$row[localtimeout]' </span>
    	        			
        </td>
        	
        <td $timeline $brbCols $badCols 
            class=\"editable editC c14 \"	
            id=\"comments:$row[recordID]\"
            oncontextmenu=\"stationTimeLineList('$row[callsign]:$row[netID]');return false;\"
            onClick=\"empty('comments:$row[recordID]');\"> 
                <div class='$class'> $row[comments] </div>	       
        </td>
        	
    	<td $brbCols class=\"editable editCREDS c15 \"	 
    	    id=\"creds:$row[recordID]\"> 	 
    	    $row[creds] 	  					   
        </td>
        
    	<td $brbCols class=\"editable c16 cent \" 
    	    id=\"timeonduty:$row[recordID]\"> 
    	    $row[time] 	  					           
        </td>
    	
    	<td $brbCols oncontextmenu=\"MapCounty('$row[county]:$row[state]');return false;\" 
    	    class=\"editable editcnty c17 cent \"
    	    id=\"county:$row[recordID]\"
    	    style=\"text-transform:capitalize\"
    	    onClick=\"empty('county:$row[recordID]');\"> 
            <div class='$class'> $row[county] </div>								
        </td>
        
        <td $brbCols class=\"editable editcity c35 cent\" 
            id=\"city:$row[recordID]\"  
            onClick=\"empty('city:$row[recordID]');\"> 
            <div class='$class'> $row[city] </div> 	  					
        </td>
        
        	
        <td $brbCols class=\"editable editstate c18 cent\" 
            id=\"state:$row[recordID]\"  
            style=\"text-transform:uppercase\"
            onClick=\"empty('state:$row[recordID]');\"> 
            <div class='$class'> $row[state] </div> 	  					
        </td>
     
       
        <td $brbCols class=\"editable editdist  c59 cent \" 
            style=\" text-transform:uppercase;\"
            id=\"district:$row[recordID]\"
            sorttable_customkey=\"$row[district] $row[county] $row[state] \"
            oncontextmenu=\"rightClickDistrict('$row[recordID], $row[state], $row[county]');return false; \"
            onClick=\"empty('district:$row[recordID]'); \">
            
            <div class='$class'> $row[district]	</div>			
        </td>   

        <!-- Column W3W -->
        <td $brbCols 
            class=\" readonly W3W  c24 cent\" 
            id=\"w3w:$row[recordID]\" 
            
            oncontextmenu=\"mapWhat3Words('$row[w3w]');return false; \" 
            
            onClick=\"empty('w3w:$row[recordID]'); 
                getAPRSLocations('NOTUSED, $row[recordID], $row[latitude],$row[longitude],$row[callsign],$row[netID], W3W');\" 
            
            style=\"cursor: pointer;\">
            <div class='$class' readonly> $row[w3w]	</div> 
        </td> 
        
        
        <!-- Saved as the original code for c24 
        <td $brbCols 
            class=\" readonly W3W  c24 cent\" 
            id=\"w3w:$row[recordID]\" 
            oncontextmenu=\"mapWhat3Words('$row[w3w]');return false; \" 
            onClick=\"empty('w3w:$row[recordID]'); 
            getAPRSLocations('NOTUSED, $row[recordID], $row[latitude],$row[longitude],$row[callsign],$row[netID], W3W');\" 
            style=\"cursor: pointer;\">
            <div class='$class' readonly> $row[w3w]	</div> 
        </td> 
        -->
     
        <td $brbCo
            class=\"editable editteam  c30 cent\" 
            id=\"team:$row[recordID]\" 
            onClick=\"empty('team:$row[recordID]');\">
            <div class='$class'> $row[team]	</div> 
        </td>

        
        <!-- Column APRS_CALL -->
        <td $brbCols 
            class=\"editable editaprs_call  c31 cent\" 
            id=\"aprs_call:$row[recordID]\" 
            style=\"text-transform:uppercase\"
            oncontextmenu=\"getAPRSLocations('$row[aprs_call], $row[recordID], $row[latitude],$row[longitude],$row[callsign],$row[netID], APRS');return false; \"
            onClick=\"empty('aprs_call:$row[recordID]');\">
            <div class='$class'> $row[aprs_call] </div> 
        </td>
        
        <td $brbCols 
    	    class=\"editable editcntry c32 cent \"
    	    id=\"country:$row[recordID]\"
    	    style=\"text-transform:capitalize\"
    	    onClick=\"empty('country:$row[recordID]');\"> 
            <div class='$class'> $row[country] </div>								
        </td>
        
        <!-- Admin Level -->
        <td $brbCols class=\"editable  c25 cent\" id=\"state:$row[recordID]\" >	 $row[recordID] 	  				</td>
        <td $brbCols class=\"editable  c26 cent\" id=\"state:$row[id]\" >	     $row[id]    	  					</td>
        <td $brbCols class=\"editable  c27 cent\" id=\"state:$row[status]\" >	 '$row[status]' 	  					</td>
        <td $brbCols class=\"editable  c28 cent\" id=\"state:$row[home]\" >	     '$row[home]' 	  					</td>
        
        
        <td $brbCols class='editable c29 cent' id='state:$ipaddress'> $ipaddress</td>
        
        <td class=\"editable dltRow\"
            id=\"delete:$row[recordID]\"> 
      			<a href=\"#\"class=\"editable delete cent\">
        			<img alt=\"x\"border=\"0\"src=\"images/delete.png\"/>
    			</a>                                                                                            
        </td>
     ");
?>