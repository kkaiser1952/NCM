<?php
	// This PHP only reads whats in the TimeLog table it does 
	// not write to it. TimeLog is written to by save.php, in 
	// this case when the comments column is modified.
	
	require_once "dbConnectDtls.php";	    
	
	$q = intval($_GET['q']); 
	//$q = 5961;
	
	try {  // Get the start time of the net 
	$sql = $db_found->prepare("SELECT min(logdate) as minTime from NetLog where netID = '$q' limit 1" );
    	$sql->execute();
    	$ts = $sql->fetchColumn();
	
	// Now get the specifics from the Time Log 
	$sql = $db_found->prepare("SELECT count(*) as maxCount FROM TimeLog WHERE netID = '$q' limit 1" );
	    $sql->execute();
        $maxCount = $sql->fetchColumn()+1;
            //echo "$maxCount"; 
            // Creating the tbody here allows us to count down from the max to 0 at the bottom of the time line display
        $tbody = "<tbody style=\"counter-reset: sortabletablescope $maxCount;\">";
            //echo "$tbody";
            
    $header = '<table class="sortable2" id="pretimeline" style="width:100%;">
		<thead> 
			<tr>
				<th>Date Time</th>
				<th>ID</th>
				<th>Callsign</th>
				<th style="width:1400px; max-width:1400px;">Comments Report</th>
			</tr>
		</thead> ';
		
	
	$sql = "SELECT timestamp, ID, callsign, comment from TimeLog where netID = '$q' ORDER BY timestamp DESC";
	
	echo ("$header");  
	echo ("$tbody");
	
	foreach($db_found->query($sql) as $row) {
		
		// To make the comments <td> scrollable but still stay at the default height if is not needed
				// this code checks if there are commets and changes the class name, a simple solution.
					$class = empty($row['comments']) ? 'nonscrollable' : 'scrollable' ;
					//$class = strlen($row['comments']) < 300 ? 'nonscrollable' : 'scrollable' ;
					if(isset($row['comments'])) {
                    $class = strlen($row['comments']) < 300 ? 'nonscrollable' : 'scrollable';
                        }
                        else {
                            // Handle the case where the 'comments' key is not present in the $row array.
                        }

		
		echo ("<tr>");
		echo ("<td nowrap>$row[timestamp]</td>");
		echo ("<td>$row[ID]</td>");
		echo ("<td>$row[callsign]</td>");
		echo ("<td><div class='$class'>$row[comment]</div></td>");
		echo ("</tr>");
	}
		echo ("<tr><td>$ts</td>");
		echo ("<td>$id</td> <td>$cs1</td> <td>Start of Net</td>");
		echo ("</tr></tbody></table>");
			
	}
	
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
?>