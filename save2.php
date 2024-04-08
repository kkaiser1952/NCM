<?php
/*
    In this refactored version:

The code is organized into separate classes (Database, NetLog, TimeLog) to encapsulate related functionality.
Database operations are abstracted away into methods of the Database class.
Business logic related to NetLog updates and logging is encapsulated within the NetLog class.
The code uses prepared statements and proper error handling to prevent SQL injection and other security vulnerabilities.
The save.php script iterates through each row and column of the submitted data, updating the NetLog accordingly and logging changes in the TimeLog table.
Additional actions are performed based on the column being updated, using a switch statement for clarity and maintainability.
Comments are added to explain the purpose of each section of the code.
    */
// Include necessary files
require_once "Database.php";
require_once "NetLog.php";
require_once "TimeLog.php";

// Get the IP address of the person making the changes
$ipAddress = getRealIpAddr();

// Get POST data
$data = $_POST;

// Initialize database connection
$database = new Database();

// Iterate through each row of data
foreach ($data as $recordID => $columns) {
    // Initialize NetLog object for the record
    $netLog = new NetLog($database, $recordID);

    // Iterate through each column of data
    foreach ($columns as $column => $value) {
        // Update the NetLog with the new information
        $netLog->updateColumn($column, $value, $ipAddress);

        // Perform additional actions based on the column
        switch ($column) {
            case 'tactical':
                if ($value == 'DELETE') {
                    // Delete the row from NetLog
                    $netLog->delete();
                } else {
                    // Log tactical change in TimeLog
                    $netLog->logTacticalChange($value, $ipAddress);
                }
                break;
            case 'active':
                // Log status change in TimeLog
                $netLog->logStatusChange($value, $ipAddress);
                break;
            // Add more cases for other columns as needed
            // Example:
            // case 'comments':
            //     $netLog->logCommentChange($value, $ipAddress);
            //     break;
            default:
                // Handle other column updates
                $netLog->logColumnChange($column, $value, $ipAddress);
                break;
        }
    }
}

// Function to get the real IP address
function getRealIpAddr() {
    // Implementation of getRealIpAddr function
}

?>
