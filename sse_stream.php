<?php
// sse_stream.php - Simple SSE implementation for net updates

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Prevent buffering
if(ob_get_level()) ob_end_clean();
ob_implicit_flush(true);

// Get the requested net ID
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;
if (!$netID) {
    echo "data: {\"error\": \"Missing netID parameter\"}\n\n";
    exit;
}

// Store the last event timestamp
$lastEventTime = 0;

// Loop to keep connection open and send updates
while (true) {
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
    } else {
        // Send a keep-alive comment every 15 seconds
        echo ": keepalive\n\n";
    }
    
    // Close database connection
    $db_found = null;
    
    // Flush output
    flush();
    
    // Wait before checking again
    sleep(3);
}
?>