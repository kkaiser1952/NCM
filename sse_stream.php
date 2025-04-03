<?php
// sse_stream.php - Improved version with timeout and better error handling

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Access-Control-Allow-Origin: *'); // Allow cross-domain requests if needed

// Prevent buffering
if(ob_get_level()) ob_end_clean();
ob_implicit_flush(true);

// Set script timeout to prevent long-running connections
set_time_limit(300); // 5 minutes max

// Get the requested net ID
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;
if (!$netID) {
    echo "event: error\n";
    echo "data: {\"error\": \"Missing netID parameter\"}\n\n";
    exit;
}

// Store the last event timestamp
$lastEventTime = 0;
$connectionStartTime = time();
$maxConnectionTime = 240; // 4 minutes (slightly less than PHP timeout)

// Send initial connection success event
echo "event: open\n";
echo "data: {\"status\": \"connected\", \"netID\": $netID}\n\n";
flush();

// Loop to keep connection open and send updates
while (true) {
    // Check if we've been running too long - close gracefully
    if (time() - $connectionStartTime > $maxConnectionTime) {
        echo "event: close\n";
        echo "data: {\"status\": \"timeout\", \"message\": \"Connection timeout, please reconnect\"}\n\n";
        flush();
        exit;
    }
    
    try {
        // Connect to database
        require_once "dbConnectDtls.php";
        
        // Check for updates
        $query = "SELECT MAX(UNIX_TIMESTAMP(sse_timestamp)) as last_update 
                  FROM NetLog 
                  WHERE netID = :netID";
        
        $stmt = $db_found->prepare($query);
        $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentUpdate = $row['last_update'] ?: time();
        
        // If we have a newer timestamp, send an event
        if ($currentUpdate > $lastEventTime) {
            $lastEventTime = $currentUpdate;
            
            echo "id: " . time() . "\n";
            echo "event: update\n";
            echo "data: {\"netID\": $netID, \"timestamp\": $currentUpdate}\n\n";
            flush();
        } else {
            // Send a keep-alive comment every few checks
            echo ": keepalive " . time() . "\n\n";
            flush();
        }
        
        // Close database connection
        $db_found = null;
    } catch (Exception $e) {
        // Report error but don't exit
        echo "event: error\n";
        echo "data: {\"error\": \"" . addslashes($e->getMessage()) . "\"}\n\n";
        flush();
    }
    
    // Use 5-second interval to match existing app's behavior
    sleep(4);
}
?>