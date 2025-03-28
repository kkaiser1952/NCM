<?php
/**
 * Net Control Manager (NCM) - SSE Updates Endpoint
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Try to use system temp directory for logging to avoid permission issues
$logPath = sys_get_temp_dir() . '/sse_log.txt';
$logFile = fopen($logPath, 'a');

if (!$logFile) {
    // If we can't open the log file, log to PHP error log instead
    error_log("Could not open log file at $logPath");
} else {
    error_log("SSE log file opened at $logPath");
}

function logMessage($message) {
    global $logFile;
    if ($logFile) {
        fwrite($logFile, date('Y-m-d H:i:s') . ' - ' . $message . "\n");
        fflush($logFile);
    }
    // Also log to PHP error log for redundancy
    error_log($message);
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

// Add the test update here
sleep(5);
sendEvent('debug', [
    'message' => 'Test update event',
    'time' => date('Y-m-d H:i:s')
]);

// Variables to track state - Now using sse_timestamp instead of dttm
$lastModified = '';
$lastCount = 0;

// Get initial state
$query = "SELECT MAX(sse_timestamp) as last_modified, COUNT(*) as record_count 
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
    
    // Check for changes - Using sse_timestamp now
    $query = "SELECT MAX(sse_timestamp) as last_modified, COUNT(*) as record_count 
              FROM NetLog WHERE netID = {$netID}";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        // Debug output
        if ($counter % 5 === 0) {
            logMessage("Current - Last modified: {$row['last_modified']}, Count: {$row['record_count']}");
            logMessage("Previous - Last modified: $lastModified, Count: $lastCount");
        }
        
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
if ($logFile) fclose($logFile);
mysqli_close($conn);
?>