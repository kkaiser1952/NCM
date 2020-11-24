<!doctype html>
<?php
	//date_default_timezone_set("America/Chicago");
    require_once "dbConnectDtls.php";       
    
    $q = intval($_GET['q']);   
    $q = 780;
    //echo "$q";
    
    $lastid = '';
     
    $sql = "SELECT  recordID,  netID, subNetOfID, id, 		Mode,  	  callsign, 
     					 tactical,  Fname, grid, 	   traffic, latitude, longitude, netcontrol, 
     					 activity,  Lname, email, 	   active, 	comments, frequency, creds, 
     					 DATE_FORMAT(logdate, '%H:%i') as logdate, 
     					 DATE_FORMAT(timeout, '%H:%i') as timeout
	 			   FROM NetLog 
	 			  WHERE subNetOfID = $q
	 			  ORDER BY netID, logdate
	 	  ";
            
    //echo "$sql";
        
        foreach($db_found->query($sql) as $row) {
	         echo ("$row[callsign]"); 
	    
	  
	   
         	if ($lastid != $row[netID]) {
	         	
	
	         	 $subheader = "<br>

    <table class=\"sortable\" id=\"thisNet\">
        <thead>
            <tr><td colspan=14><span id=\"subsubheader\">Net #:&nbsp;$row[netID]&nbsp;-->&nbsp;$row[activity]</span><span style=\"float:right;\">$row[frequency]</span></td></tr>
            <tr>
	            <th>Role</th>
	            <th>Mode</th>
	            <th>Active</th>
	            <th>Traffic<br>YN</th>
	            <th  width=\"5%\">#</th>
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
                <th>Time Line</th>
                <th>Credentials</th>
                <th class=\"toggleTOD\">Time On Duty</th>
                <th>Credentials</th>
            </tr>
        </thead><tbody>";
	         	
	         	echo "$subheader";
	         
    } }
             /*
        	echo ("<tr>");
				 
			     echo ("<td      class=\"editable_selectNC   cent \" id=\"netcontrol:$row[recordID]\">$row[netcontrol] </td>"); 
	    echo ("<td $dig class=\"editable_selectMode cent \" id=\"Mode:$row[recordID]\">      $row[Mode]       </td>");	    
	    echo ("<td      class=\"editable_selectACT  cent\"  id=\"active:$row[recordID]\">    $row[active] 	  </td>");	    
	    echo ("<td class=\"editable_selectTFC\" id=\"traffic:$row[recordID]\">$row[traffic] </td>");  
	    
	    echo ("<td class=\"cent\">$row[id]</td>");  // Callsign ID, not the recordID, not editable
        	
        echo ("<td $dig class=\"editCS1\" id=\"callsign:$row[recordID]\" style=\'text-transform:uppercase\'> $row[callsign] </td>");
        	
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
	            	$lastid = $row[netID];
			 } // End the foreach
			echo ("</tbody></table>"); //End of tbody and the table
		//}
		
		*/

?>