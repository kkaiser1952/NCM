<?php
/**
 * Net Control Manager (NCM) - SSE Updates Endpoint
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log file for debugging - use an absolute path to ensure we know where it goes
$logDir = dirname(__FILE__); // This gives us the directory where this script is located
$logPath = $logDir . '/sse_log.txt';
$logFile = fopen($logPath, 'a');

function logMessage($message) {
    global $logFile;
    fwrite($logFile, date('Y-m-d H:i:s') . ' - ' . $message . "\n");
    fflush($logFile); // Ensure it's written immediately
}

logMessage('SSE connection started. Log path: ' . $logPath);

// Set headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Flush headers immediately
flush();

// For large files/updates, we don't want PHP to timeout
set_time_limit(0);

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
    fclose($logFile);
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
$query = "SELECT MAX(timestamp) as last_modified, COUNT(*) as record_count 
          FROM NetLog WHERE netID = {$netID}";
logMessage("Initial query: $query");

$result = mysqli_query($conn, $query);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $lastModified = $row['last_modified'];
    $lastCount = $row['record_count'];
    logMessage("Initial state - Last modified: $lastModified, Count: $lastCount");
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
    
    // Check for changes
    $query = "SELECT MAX(timestamp) as last_modified, COUNT(*) as record_count 
              FROM NetLog WHERE netID = {$netID}";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        // Debug output
        logMessage("Current - Last modified: {$row['last_modified']}, Count: {$row['record_count']}");
        logMessage("Previous - Last modified: $lastModified, Count: $lastCount");
        
        // Check if there are changes
        if ($row['last_modified'] != $lastModified || $row['record_count'] != $lastCount) {
            logMessage("Change detected!");
            
            // Send update event
            sendEvent('update', [
                'netID' => $netID,
                'lastModified' => $row['last_modified'],
                'previousModified' => $lastModified,
                'recordCount' => $row['record_count'],
                'previousCount' => $lastCount,
                'time' => date('Y-m-d H:i:s')
            ]);
            
            // Update tracking variables
            $lastModified = $row['last_modified'];
            $lastCount = $row['record_count'];
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
fclose($logFile);
mysqli_close($conn);
?>