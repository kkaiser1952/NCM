<?php
// Simple update checker using AJAX polling
header('Content-Type: application/json');

$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;
$lastTimestamp = isset($_GET['lastTimestamp']) ? $_GET['lastTimestamp'] : '';
$lastCount = isset($_GET['lastCount']) ? intval($_GET['lastCount']) : 0;

if (!$netID) {
    echo json_encode([
        'error' => 'No valid net ID provided'
    ]);
    exit;
}

// Database connection
require_once "dbConnectDtls.php";

// Check for updates
$query = "SELECT MAX(sse_timestamp) as last_modified, COUNT(*) as record_count 
          FROM NetLog WHERE netID = ?";
$stmt = $db_found->prepare($query);
$stmt->bindParam(1, $netID);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$currentTimestamp = $row['last_modified'];
$currentCount = $row['record_count'];

$response = [
    'netID' => $netID,
    'timestamp' => $currentTimestamp,
    'count' => $currentCount,
    'serverTime' => date('Y-m-d H:i:s')
];

// Check if there's a change (either timestamp or count)
if ($lastTimestamp != $currentTimestamp || $lastCount != $currentCount) {
    $response['changed'] = true;
    $response['reason'] = ($lastTimestamp != $currentTimestamp) ? 'timestamp' : 'count';
} else {
    $response['changed'] = false;
}

echo json_encode($response);
?>