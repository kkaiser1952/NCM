<?php
// check_column.php - Verify sse_timestamp column exists and can be updated
header('Content-Type: text/plain');

require_once "dbConnectDtls.php";

try {
    // First, check if the column exists
    $sql = "SHOW COLUMNS FROM NetLog LIKE 'sse_timestamp'";
    $stmt = $db_found->prepare($sql);
    $stmt->execute();
    $columnExists = $stmt->rowCount() > 0;
    
    echo "sse_timestamp column exists: " . ($columnExists ? "YES" : "NO") . "\n\n";
    
    if (!$columnExists) {
        echo "Column doesn't exist - trying to add it now...\n";
        
        // Try to add the column
        $sql = "ALTER TABLE NetLog ADD COLUMN sse_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        $stmt = $db_found->prepare($sql);
        $stmt->execute();
        
        echo "Column added successfully!\n\n";
    }
    
    // Now test updating a record
    $netID = 14292; // Your test net ID
    
    // Update the timestamp
    $sql = "UPDATE NetLog SET sse_timestamp = NOW() WHERE netID = :netID LIMIT 1";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
    $result = $stmt->execute();
    
    echo "Test update result: " . ($result ? "SUCCESS" : "FAILED") . "\n";
    echo "Rows affected: " . $stmt->rowCount() . "\n\n";
    
    // Get the current timestamp
    $sql = "SELECT sse_timestamp FROM NetLog WHERE netID = :netID LIMIT 1";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
    $stmt->execute();
    
    $timestamp = $stmt->fetchColumn();
    echo "Current timestamp value: " . $timestamp . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>