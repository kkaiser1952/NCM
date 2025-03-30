<?php
// check_net_updates.php - Enhanced for SSE with more aggressive change detection
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
    
    // Force a check for any changes in the last minute
    $oneMinuteAgo = date('Y-m-d H:i:s', strtotime('-1 minute'));
    
    // Get most recent timestamp for this net
    $timestampQuery = "SELECT MAX(sse_timestamp) as last_update, 
                              COUNT(*) as record_count
                       FROM NetLog 
                       WHERE netID = :netID";
    $tsStmt = $db_found->prepare($timestampQuery);
    $tsStmt->bindParam(':netID', $netID, PDO::PARAM_INT);
    $tsStmt->execute();
    
    $tsRow = $tsStmt->fetch(PDO::FETCH_ASSOC);
    $currentUpdate = $tsRow['last_update'];
    $recordCount = $tsRow['record_count'];
    
    // Handle null or default values
    if (!$currentUpdate || $currentUpdate == '0000-00-00 00:00:00') {
        $currentUpdate = date('Y-m-d H:i:s');
    }
    
    // Check for real changes (added/removed records or timestamp changes)
    $changeQuery = "SELECT COUNT(*) as changes_detected
                   FROM NetLog 
                   WHERE netID = :netID 
                   AND (
                     sse_timestamp > :lastUpdate
                     OR sse_timestamp >= :oneMinuteAgo
                   )";
    
    $changeStmt = $db_found->prepare($changeQuery);
    $changeStmt->bindParam(':netID', $netID, PDO::PARAM_INT);
    $changeStmt->bindParam(':lastUpdate', $lastUpdate, PDO::PARAM_STR);
    $changeStmt->bindParam(':oneMinuteAgo', $oneMinuteAgo, PDO::PARAM_STR);
    $changeStmt->execute();
    
    $changeRow = $changeStmt->fetch(PDO::FETCH_ASSOC);
    $changesDetected = $changeRow['changes_detected'] > 0;
    
    // Get record count when last checked
    $lastRecordCount = isset($_GET['recordCount']) ? intval($_GET['recordCount']) : 0;
    $countChanged = ($lastRecordCount > 0 && $lastRecordCount != $recordCount);
    
    // Force real detection
    $hasChanges = $changesDetected || $countChanged || 
                 (!empty($lastUpdate) && $lastUpdate !== $currentUpdate);
    
    $response['last_update'] = $currentUpdate;
    $response['submitted_timestamp'] = $lastUpdate;
    $response['comparison'] = $lastUpdate . ' vs ' . $currentUpdate;
    $response['timestamps_equal'] = ($lastUpdate === $currentUpdate);
    $response['hasChanges'] = $hasChanges;
    $response['record_count'] = $recordCount;
    $response['debug_info'] = [
        'changes_detected' => $changesDetected,
        'count_changed' => $countChanged,
        'timestamp_different' => (!empty($lastUpdate) && $lastUpdate !== $currentUpdate),
        'one_minute_ago' => $oneMinuteAgo
    ];
    
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['success'] = false;
}

// Output as JSON
echo json_encode($response);
?>