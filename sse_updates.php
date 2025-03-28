<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Try to use system temp directory for logging to avoid permission issues
$logPath = sys_get_temp_dir() . '/sse_log.txt';
$logFile = fopen($logPath, 'a');

function logMessage($message) {
    global $logFile;
    if ($logFile) {
        fwrite($logFile, date('Y-m-d H:i:s') . ' - ' . $message . "\n");
        fflush($logFile);
    }
    // Also log to PHP error log
    error_log("SSE: " . $message);
}

logMessage('SSE connection started. Log path: ' . $logPath);

// Set headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Flush headers immediately
flush();

// Get database connection
require_once "dbConnectDtls.php";
logMessage('Database connection established');

// Get the requested net ID
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;
logMessage('Requested Net ID: ' . $netID);

if (!$netID) {
    echo "event: error\n";
    echo "data: {\"message\":\"No valid net ID provided\"}\n\n";
    flush();
    if ($logFile) fclose($logFile);
    exit();
}

// Function to send an event
function sendEvent($name, $data) {
    global $logFile;
    $encodedData = json_encode($data);
    logMessage("Sending event: $name - $encodedData");
    
    echo "event: {$name}\n";
    echo "data: {$encodedData}\n\n";
    flush();
}

// Send initial connection event
sendEvent('connected', [
    'message' => 'Connection established',
    'netID' => $netID,
    'time' => date('Y-m-d H:i:s')
]);

// Variables to track state
$lastModified = '';
$lastCount = 0;

// Get initial state
$query = "SELECT MAX(sse_timestamp) as last_modified, COUNT(*) as record_count 
          FROM NetLog WHERE netID = {$netID}";
logMessage("Initial query: $query");

$result = mysqli_query($conn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $lastModified = $row['last_modified'] ?? '';
    $lastCount = $row['record_count'] ?? 0;
    logMessage("Initial state - Last modified: " . (empty($lastModified) ? 'NULL' : $lastModified) . ", Count: $lastCount");
    mysqli_free_result($result);
}

// Main loop - keep checking for updates
$counter = 0;
while (true) {
    // Every few iterations, send a keepalive comment
    if ($counter % 5 === 0) {
        echo ": keepalive " . time() . "\n\n";
        flush();
    }
    
    // Check if client disconnected
    if (connection_aborted()) {
        logMessage('Client disconnected');
        break;
    }
    
    // Debug check to see what values we're comparing
    if ($counter % 10 === 0) {
        logMessage("Current check iteration: $counter");
        
        // Send a debug event to client
        echo ": debug - Checking for changes at " . date('Y-m-d H:i:s') . "\n\n";
        flush();
    }
    
    // Check for changes
    $query = "SELECT MAX(sse_timestamp) as last_modified, COUNT(*) as record_count 
              FROM NetLog WHERE netID = {$netID}";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $currentModified = $row['last_modified'] ?? '';
        $currentCount = $row['record_count'] ?? 0;
        
        // Debug output every 10 iterations
        if ($counter % 10 === 0) {
            logMessage("Current state - Last modified: " . (empty($currentModified) ? 'NULL' : $currentModified) . ", Count: $currentCount");
            logMessage("Previous - Last modified: " . (empty($lastModified) ? 'NULL' : $lastModified) . ", Count: $lastCount");
        }
        
        // Debug output if values are different
        if ($currentModified != $lastModified) {
            logMessage("DIFFERENCE DETECTED in timestamp: '$lastModified' vs '$currentModified'");
        }
        
        if ($currentCount != $lastCount) {
            logMessage("DIFFERENCE DETECTED in count: $lastCount vs $currentCount");
        }
        
        // Check if there are changes
        if ($currentModified != $lastModified || $currentCount != $lastCount) {
            logMessage("Change detected! Sending update event");
            
            // Send update event
            sendEvent('update', [
                'netID' => $netID,
                'lastModified' => $currentModified,
                'previousModified' => $lastModified,
                'recordCount' => $currentCount,
                'previousCount' => $lastCount,
                'time' => date('Y-m-d H:i:s')
            ]);
            
            // Update tracking variables
            $lastModified = $currentModified;
            $lastCount = $currentCount;
        }
        
        mysqli_free_result($result);
    } else {
        logMessage('Query failed: ' . mysqli_error($conn));
    }
    
    // Increment counter
    $counter++;
    
    // Prevent CPU overuse
    sleep(2);
}

// Cleanup
logMessage('SSE connection ended');
if ($logFile) fclose($logFile);
mysqli_close($conn);
?>