<?php
// Force an update to test SSE functionality
header('Content-Type: text/plain');

$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;

if (!$netID) {
    echo "Error: No valid net ID provided";
    exit;
}

// Connect to database
require_once "dbConnectDtls.php";

// Update the dttm field and add a test comment to make the change visible
$now = date('Y-m-d H:i:s');
$testComment = " [SSE test update at $now]";

// First, update an existing record
$query = "UPDATE NetLog 
          SET dttm = NOW(), 
              comments = CONCAT(IFNULL(comments, ''), ?) 
          WHERE netID = ? 
          LIMIT 1";

$stmt = $db_found->prepare($query);
$stmt->bindParam(1, $testComment);
$stmt->bindParam(2, $netID);
$result = $stmt->execute();

if ($result) {
    echo "Success: Test update performed at $now";
} else {
    echo "Error updating record: " . print_r($stmt->errorInfo(), true);
}
?>