<?php
/**
 * Net Control Manager (NCM) - SSE Updates Endpoint
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */

// Set headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // For Nginx - helps prevent buffering

// Prevent script time-out
set_time_limit(0);
ini_set('display_errors', 0);

// Prevent session blocking issues
session_start();
session_write_close();

// Get database connection
require_once "dbConnectDtls.php";

// Get the net ID from the request
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;

if (!$netID) {
    echo "event: error\n";
    echo "data: No valid net ID provided\n\n";
    exit();
}

// Function to send an SSE message
function sendEvent($eventName, $data) {
    echo "event: $eventName\n";
    echo "data: " . json_encode($data) . "\n\n";
    
    // Flush output buffer and send data to client
    ob_flush();
    flush();
}

// Track the latest state
$lastUpdate = null;
$lastCount = null;

// Keep the connection open
while (true) {
    // Get current state of the net
    $query = "SELECT 
                MAX(timestamp) as last_update, 
                COUNT(*) as record_count 
              FROM netLog 
              WHERE netID = $netID";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        sendEvent("error", ["message" => "Database query failed"]);
        break;
    }
    
    $data = mysqli_fetch_assoc($result);
    
    // Check if there's a change
    if ($lastUpdate !== $data['last_update'] || $lastCount !== $data['record_count']) {
        $lastUpdate = $data['last_update'];
        $lastCount = $data['record_count'];
        
        // Send update notification
        sendEvent("update", [
            "timestamp" => $data['last_update'],
            "record_count" => $data['record_count'],
            "netID" => $netID
        ]);
    }
    
    // Close the result set
    mysqli_free_result($result);
    
    // Check if client has disconnected
    if (connection_aborted()) {
        break;
    }
    
    // Short delay between checks
    sleep(2);
}

// Close database connection
mysqli_close($conn);
?>