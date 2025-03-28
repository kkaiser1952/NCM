<?php
// Extremely simple SSE test
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Disable output buffering
if (ob_get_level()) ob_end_clean();

// Send an initial message
echo "data: Connection established\n\n";
flush();

// Start time
$start = time();

// Run for 60 seconds
while (time() < $start + 60) {
    // Send a message every 5 seconds
    echo "data: " . date('Y-m-d H:i:s') . "\n\n";
    flush();
    
    // Sleep for 5 seconds
    sleep(5);
}
?>