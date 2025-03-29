<?php
// force_timestamp_update.php - Force an update to trigger the notification system
header('Content-Type: text/plain');

require_once "dbConnectDtls.php";

$netID = isset($_GET['netID']) ? intval($_GET['netID']) : 14292;

try {
    // Update all records in the net
    $sql = "UPDATE NetLog SET sse_timestamp = NOW() WHERE netID = :netID";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
    $result = $stmt->execute();
    
    $count = $stmt->rowCount();
    echo "Updated $count records in net $netID\n";
    echo "Timestamp updated to: " . date('Y-m-d H:i:s');
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>