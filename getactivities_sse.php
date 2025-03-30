<?php
// getactivities_sse.php - SSE-optimized version of getactivities.php
// Enhanced for better compatibility with SSE updates

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "dbConnectDtls.php";    

$q = intval($_GET['q']); 

// Only output the activity log portion, not the entire table structure
echo "<div id='actLog'>";

// Include your existing query and table generation code here
// This is the core of getactivities.php without the header/footer parts

// Get timezone info
if(!isset($_COOKIE[tzdiff])) {
    $tzdiff = "0:00"; // Default to UTC if not set
} else { 
    $tzdiff = $_COOKIE[tzdiff]/-60; 
    $tzdiff = "$tzdiff:00";
}

// Include essential functions
function time_elapsed_A($secs){
    // Your existing time_elapsed_A function
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

// Get net information
if ($q != 0) {
    // Your existing code for getting net information
    // (But simplified to only what's needed for the activity log)
    
    include "headerDefinitions.php";
    include "dropdowns.php";
    
    // Your main query for activity data
    $g_query = "SELECT  recordID, netID, subNetOfID, id, ID, 
                    TRIM(callsign) AS callsign, tactical,  
                    TRIM(BOTH ' ' FROM Fname) as Fname, 
                    /* Rest of your existing query */";
    
    // Initialize counters and flags
    $trafficKey = 0;
    $logoutKey  = 0;
    $digitalKey = 0;
    $brbKey     = 0;
    // ... other variables
    
    // Start the table body
    echo "<tbody class=\"sortable\" id=\"netBody\">";
    
    // Loop through results
    foreach($db_found->query($g_query) as $row) {
        // Your existing row processing code
        ++$num_rows;
        
        // Color assignments
        include "colColorAssign.php";
        
        // Output the row HTML
        echo ("<tr id=\"$row[recordID]\">");
        
        // Row definitions
        include "rowDefinitions.php";
        
        echo ("</tr>");
    }
    
    echo "</tbody>";
    
    // Calculate runtime
    $nowtime = time();
    $runtime = time_elapsed_A($nowtime - strtotime($startTime));
    
    // Add footer
    echo ("<tfoot><tr>");
    echo "<td></td>
          <td class='runtime' colspan='5' align='left'>Run Time: $runtime </td>
          <td class='tvh' colspan='8' align='right'>Total Volunteer Hours = $tottime</td>";
    echo ("</tr></tfoot>");
    
    // Important: Include the hidden variables that might be needed
    echo ("<div hidden id='freq2'>$row[frequency]</div>");
    echo ("<div hidden id='freq'></div>");
    // ... other hidden variables
    
    // Close the table
    echo ("</table>");
    
    // Include status indicators
    echo ("<span id='add2pgtitle'>#$row[netID]/$row[netcall]/$freq&nbsp;&nbsp;");
    
    // ... your existing status indicators
    
    echo ("</span>");
}

echo "</div>"; // Close the actLog div
?>