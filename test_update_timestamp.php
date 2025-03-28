<?php
// Direct test of timestamp update
header('Content-Type: text/plain');

require_once "dbConnectDtls.php";

$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 0;

if (!$netID) {
    echo "Error: No netID provided";
    exit;
}

// Update the sse_timestamp for ALL records in this net
$sql = "UPDATE NetLog SET sse_timestamp = NOW() WHERE netID = :netID";
$stmt = $db_found->prepare($sql);
$stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
$result = $stmt->execute();

if ($result) {
    $count = $stmt->rowCount();
    echo "Success: Updated sse_timestamp for $count records in net $netID";
} else {
    echo "Error: " . print_r($stmt->errorInfo(), true);
}
?>