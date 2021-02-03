<?php
// getStationTimeLine.php
// This program produces a report of the time line for this callsign, it opens as a modal or windwo
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    // PHP Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}
    

$netID = strip_tags($_POST["netid"]); // The one we are coping rows to
$call = strip_tags($_POST["call"]); // The name of this new event	

//echo ("<br>$call, $netID<br>");

    $sql = "SELECT timestamp, comment
              FROM TimeLog
             WHERE NetID = $netID
               AND callsign = '$call'
             ORDER BY timestamp ASC
           ";
//echo ("$sql");
         
        echo "<p style='color:blue; font-size:14pt; text-decoration: underline;'>Net $netID Time Line Entries For $call</p>
                <ol>
             ";
         
    foreach($db_found->query($sql) as $row) {
		++$num_rows; // Increment row counter for coloring background of rows
		echo "<li>$row[timestamp]: $row[comment]</li>";
		// echo ("$tlreport");
    }
    
    echo ("</ol><br><br>END OF LINE");

?>
