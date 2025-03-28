<?php
// Force an update to test polling mechanism
header('Content-Type: text/plain');

$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;

if (!$netID) {
    echo "Error: No valid net ID provided";
    exit;
}

// Connect to database
require_once "dbConnectDtls.php";

// Force an update to sse_timestamp
$now = date('Y-m-d H:i:s');
$query = "UPDATE NetLog SET sse_timestamp = NOW() WHERE netID = ? LIMIT 1";

$stmt = $db_found->prepare($query);
$stmt->bindParam(1, $netID);
$result = $stmt->execute();

if ($result) {
    echo "Success: Updated sse_timestamp for net ID $netID at $now";
} else {
    echo "Error updating record: " . print_r($stmt->errorInfo(), true);
}
?>