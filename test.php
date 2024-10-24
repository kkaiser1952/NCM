<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Set up logging
    $logFile = '/var/www/NCM/logs/test_log.txt';
    
    // Check if directory exists and is writable
    $logDir = dirname($logFile);
    
    // Debug information
    echo "Log directory: " . $logDir . "<br>";
    echo "Is directory?: " . (is_dir($logDir) ? 'Yes' : 'No') . "<br>";
    echo "Is writable?: " . (is_writable($logDir) ? 'Yes' : 'No') . "<br>";
    
    // Try to write directly to the file
    if(file_put_contents($logFile, "Test log entry at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND)) {
        echo "Successfully wrote to log file<br>";
    } else {
        echo "Failed to write to log file<br>";
    }
    
    // Set up error logging
    ini_set('log_errors', 1);
    ini_set('error_log', $logFile);
    
    // Try to write using error_log
    if(error_log("Test script started at " . date('Y-m-d H:i:s') . "\n", 3, $logFile)) {
        echo "Successfully wrote using error_log<br>";
    } else {
        echo "Failed to write using error_log<br>";
    }
    
    echo "This is a test script.";
?>