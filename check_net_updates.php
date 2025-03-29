<?php
// check_net_updates.php - Fixed for PDO connection
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Basic headers
header('Content-Type: application/json');

// Get parameters
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;
$lastUpdate = isset($_GET['lastUpdate']) ? $_GET['lastUpdate'] : '';

// Response array
$response = [
    'success' => true,
    'netID' => $netID,
    'timestamp' => date('Y-m-d H:i:s')
];

try {
    // Connect to database
    require_once "dbConnectDtls.php";
    $response['db_connected'] = true;
    
    // Use PDO with prepare/execute and sse_timestamp
    $query = "SELECT MAX(sse_timestamp) as last_update FROM NetLog WHERE netID = :netID";
    $stmt = $db_found->prepare($query);
    $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentUpdate = $row['last_update'];
    
$response['last_update'] = $currentUpdate;
$response['submitted_timestamp'] = $lastUpdate;
$response['comparison'] = $lastUpdate . ' vs ' . $currentUpdate;
$response['timestamps_equal'] = ($lastUpdate === $currentUpdate);
$response['hasChanges'] = ($lastUpdate !== $currentUpdate);
    
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['success'] = false;
}

// Output as JSON
echo json_encode($response);
?>