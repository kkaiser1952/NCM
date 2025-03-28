<?php
// Direct database update to test SSE
header('Content-Type: text/plain');

// Get the net ID
$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;

if (!$netID) {
    echo "Error: No valid netID provided";
    exit;
}

// Connect to the database
require_once "dbConnectDtls.php";

// Force an update to sse_timestamp only
$query = "UPDATE NetLog SET sse_timestamp = NOW() WHERE netID = ? LIMIT 1";
$stmt = $db_found->prepare($query);
$stmt->bindParam(1, $netID);
$result = $stmt->execute();

if ($result) {
    echo "Success: Updated sse_timestamp for net ID $netID at " . date('Y-m-d H:i:s');
} else {
    echo "Error: " . implode(" ", $stmt->errorInfo());
}
?>