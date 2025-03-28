<?php
// Minimal SSE implementation
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Disable output buffering
if (ob_get_level()) ob_end_clean();

// Get the net ID
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;

// Database connection
require_once "dbConnectDtls.php";

// Initial values
$lastUpdate = '';
$lastCount = 0;

// Send initial connection message
echo "data: connected\n\n";
flush();

// Get initial state
$query = "SELECT MAX(timestamp) as last_update, COUNT(*) as count FROM NetLog WHERE netID = $netID";
$result = mysqli_query($conn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $lastUpdate = $row['last_update'];
    $lastCount = $row['count'];
    mysqli_free_result($result);
}

// Running time - 30 minutes maximum
$endTime = time() + 1800;

// Main loop
while (time() < $endTime) {
    // Check for client disconnect
    if (connection_aborted()) {
        break;
    }
    
    // Check for updates
    $query = "SELECT MAX(timestamp) as last_update, COUNT(*) as count FROM NetLog WHERE netID = $netID";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $currentUpdate = $row['last_update'];
        $currentCount = $row['count'];
        
        // If anything has changed, send an update
        if ($currentUpdate !== $lastUpdate || $currentCount !== $lastCount) {
            echo "data: update\n\n";
            flush();
            
            $lastUpdate = $currentUpdate;
            $lastCount = $currentCount;
        }
        
        mysqli_free_result($result);
    }
    
    // Prevent browser timeout by sending a comment
    echo ": keepalive\n\n";
    flush();
    
    // Sleep for a short time to prevent high CPU usage
    sleep(2);
}

// Close connection
mysqli_close($conn);
?>