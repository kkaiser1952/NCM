<?php
	// This PHP only reads whats in the TimeLog table it does 
	// not write to it. TimeLog is written to by save.php, in 
	// this case when the comments column is modified.
	
	require_once "dbConnectDtls.php";	    
	
$q = strip_tags($_GET["q"]);   //echo "q: $q";
    $q1 = explode(",",$q);
        $netID  = $q1[0];
        $findit = trim($q1[1]);
        
   // echo "$netID $findit";
	
	try {  // Get the start time of the net 
	$sql = $db_found->prepare("
	    SELECT min(logdate) AS minTime 
	      FROM NetLog 
	     WHERE netID = '$netID' 
	     LIMIT 1
    ");
    	$sql->execute();
    	$ts = $sql->fetchColumn();
	
	// Now get the specifics from the Time Log 
	$sql = $db_found->prepare(
	    "SELECT count(*) AS maxCount 
	       FROM TimeLog 
	      WHERE netID = '$netID' 
	      LIMIT 1
    ");
	    $sql->execute();
        $maxCount = $sql->fetchColumn()+1;

        // Creating the tbody here allows us to count down from the max to 0 at the bottom of the time line display
        $tbody = "<tbody style=\"counter-reset: sortabletablescope $maxCount;\">";

    // Create the header for the table      
    $header = '<table class="sortable2" id="pretimeline" style="width:100%;">
		<thead> 
			<tr>
				<th>Date Time</th>
				
				<th>Callsign</th>
				<th style="width:1400px; max-width:1400px;">Search Report for: ' .$findit. '</th>
			</tr>
		</thead> 
    '; // End table header
		
    // This is the SQL to extract just the information we want from the TimeLog table
    $sql = ("
        SELECT netID, callsign, timestamp, 
        	CONCAT( '@ ', (SELECT tactical 
        				     FROM NetLog b 
        			        WHERE netID = $netID 
        				      AND b.recordID = a.recordID 
        				      AND a.recordID <> 0),':: ') 
        				       AS tactical, 	
            REPLACE(comment, ' ', ',') as comment 
          FROM TimeLog a 
         WHERE a.netID = $netID 
           AND a.ID > 0 
           AND a.recordID <> 0 
           AND a.comment NOT LIKE '%Opened the net%' 
           AND a.comment NOT LIKE '%class=%' 
           AND a.comment NOT LIKE '%LOC&%' 
           AND a.comment NOT LIKE '%tactical%' 
           AND FIND_IN_SET( '$findit', REPLACE(a.comment, ' ', ',')) > 0 
         ORDER by a.timestamp DESC
    ");
    
    //echo "$sql";
	
	// Build the table header and body
	echo ("$header");  
	echo ("$tbody");
	
	foreach($db_found->query($sql) as $row) {
		
		// To make the comments <td> scrollable but still stay at the default height if is not needed
        // this code checks if there are commets and changes the class name, a simple solution.
		$class = empty($row[comments]) ? 'nonscrollable' : 'scrollable' ;
		$class = strlen($row[comments]) < 300 ? 'nonscrollable' : 'scrollable' ;
		
		echo ("<tr>");
		echo ("<td nowrap>$row[timestamp]</td>");
		//echo ("<td>$row[ID]</td>");
		echo ("<td>$row[callsign]</td>");
		echo ("<td><div class='$class'>$row[tactical]$row[comment]</div></td>");
		echo ("</tr>");
	}
		echo ("<tr><td>$ts</td>");
		echo ("<td>$cs1</td> <td>Start of Net</td>");
		echo ("</tr></tbody></table>");	
	}
	
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
?>