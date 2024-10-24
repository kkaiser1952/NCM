<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Set up logging
    $logFile = __DIR__ . '/var/www/NCM/logs/test_log.txt'; // Adjust the path if necessary
    ini_set('log_errors', 'On');
    ini_set('error_log', $logFile);

    error_log("Test script started." . PHP_EOL, 3, $logFile);
    echo "This is a test script.";
?>