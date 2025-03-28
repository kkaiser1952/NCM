<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Basic headers
header('Content-Type: application/json');

// Connect to database
require_once "dbConnectDtls.php";

// Get parameters
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;
$lastUpdate = isset($_GET['lastUpdate']) ? $_GET['lastUpdate'] : '';

// Validate input
if (!$netID) {
    echo json_encode(['error' => 'Invalid net ID']);
    exit;
}

try {
    // Simple query using mysqli directly
    $query = "SELECT MAX(timestamp) as last_update FROM NetLog WHERE netID = " . $netID;
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($conn));
    }
    
    $row = mysqli_fetch_assoc($result);
    $currentUpdate = $row['last_update'];
    
    // Return result
    echo json_encode([
        'hasChanges' => ($lastUpdate != $currentUpdate),
        'lastUpdate' => $currentUpdate,
        'debug' => [
            'query' => $query,
            'lastUpdate' => $lastUpdate
        ]
    ]);
    
} catch (Exception $e) {
    // Return error
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>