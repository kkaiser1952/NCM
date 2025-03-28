<?php
// Simple SSE script with forced periodic updates
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Get the requested net ID
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;

if (!$netID) {
    echo "event: error\n";
    echo "data: {\"message\":\"No valid net ID provided\"}\n\n";
    flush();
    exit();
}

// Database connection
require_once "dbConnectDtls.php";

// Send initial connection event
echo "event: connected\n";
echo "data: " . json_encode([
    'message' => 'Connection established',
    'netID' => $netID,
    'time' => date('Y-m-d H:i:s')
]) . "\n\n";
flush();

// Main loop
$counter = 0;
while (true) {
    // Send keepalive every second
    echo ": keepalive " . time() . "\n\n";
    flush();
    
    // Check for client disconnect
    if (connection_aborted()) {
        break;
    }
    
    // Send a forced update every 20 seconds regardless of database changes
    if ($counter % 20 === 0 && $counter > 0) {
        echo "event: update\n";
        echo "data: " . json_encode([
            'netID' => $netID,
            'forced' => true,
            'counter' => $counter,
            'time' => date('Y-m-d H:i:s')
        ]) . "\n\n";
        flush();
    }
    
    $counter++;
    sleep(1);
}

// Close database connection
mysqli_close($conn);
?>