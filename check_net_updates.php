<?php
// check_net_updates.php - Enhanced for better timestamp handling
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
    
    // Get current timestamp (newest in this net)
    $timestampQuery = "SELECT MAX(sse_timestamp) as last_update 
                       FROM NetLog WHERE netID = :netID";
    $tsStmt = $db_found->prepare($timestampQuery);
    $tsStmt->bindParam(':netID', $netID, PDO::PARAM_INT);
    $tsStmt->execute();
    
    $tsRow = $tsStmt->fetch(PDO::FETCH_ASSOC);
    $currentUpdate = $tsRow['last_update'];
    
    // If this is a new net or timestamps aren't initialized, use current time
    if (!$currentUpdate || $currentUpdate == '0000-00-00 00:00:00') {
        $currentUpdate = date('Y-m-d H:i:s');
    }
    
    $response['last_update'] = $currentUpdate;
    $response['submitted_timestamp'] = $lastUpdate;
    $response['comparison'] = $lastUpdate . ' vs ' . $currentUpdate;
    $response['timestamps_equal'] = ($lastUpdate === $currentUpdate);
    $response['hasChanges'] = (!empty($lastUpdate) && $lastUpdate !== $currentUpdate);
    
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['success'] = false;
}

// Output as JSON
echo json_encode($response);
?>