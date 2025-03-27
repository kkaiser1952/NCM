<?php
/**
 * Net Control Manager (NCM) - SSE-Compatible Save Handler
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log file for debugging
$logPath = sys_get_temp_dir() . '/save_sse_log.txt';
$logFile = fopen($logPath, 'a');

function logMessage($message) {
    global $logFile;
    if ($logFile) {
        fwrite($logFile, date('Y-m-d H:i:s') . ' - ' . $message . "\n");
        fflush($logFile);
    }
}

logMessage('save_sse.php called');

// Get the IP address of the person making the changes
require_once "getRealIpAddr.php";
require_once "dbConnectDtls.php";

// Get raw data from the request
$rawdata = file_get_contents('php://input');
logMessage("Raw data: $rawdata");

// Parse the data
$parts = explode("&", $rawdata);

// Part 0 contains the value
$valuePart = explode("=", $parts[0]);
$value = isset($valuePart[1]) ? $valuePart[1] : '';
$value = trim($value, "+");
$value = str_replace("+", " ", $value);
$value = rawurldecode($value);
$value = trim($value);

logMessage("Value: $value");

// Part 1 contains the column and recordID
$idPart = explode("=", $parts[1]);
$idValue = isset($idPart[1]) ? $idPart[1] : '';
$idParts = explode("%3A", $idValue);
$column = isset($idParts[0]) ? $idParts[0] : '';
$recordID = isset($idParts[1]) ? $idParts[1] : '';

logMessage("Column: $column, RecordID: $recordID");

// Get the IP address
$ipaddress = getRealIpAddr();
logMessage("IP Address: $ipaddress");

try {
    // Get information about the record
    $sql = "SELECT ID, netID, callsign FROM NetLog WHERE recordID = :recordID LIMIT 1";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$row) {
        throw new Exception("No record found for recordID: $recordID");
    }
    
    $netID = $row['netID'];
    $ID = $row['ID'];
    $cs1 = $row['callsign'];
    
    logMessage("Found: NetID: $netID, ID: $ID, Callsign: $cs1");
    
    // Special case: handle DELETE action
    if ($column == "tactical" && $value == "DELETE") {
        logMessage("DELETE action detected");
        
        // Log the deletion
        $timestamp = date('Y-m-d H:i:s');
        $comment = "The call $cs1 with this ID was deleted";
        
        $sql = "INSERT INTO TimeLog (recordID, timestamp, ID, netID, callsign, comment, ipaddress) 
                VALUES (:recordID, :timestamp, :ID, :netID, 'GENCOMM', :comment, :ipaddress)";
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
        $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
        $stmt->bindParam(':netID', $netID, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':ipaddress', $ipaddress, PDO::PARAM_STR);
        $stmt->execute();
        
        // Delete the record
        $sql = "DELETE FROM NetLog WHERE recordID = :recordID";
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
        $stmt->execute();
        
        echo "DELETED successfully";
        exit;
    }
    
    // Log the change in TimeLog
    $timestamp = date('Y-m-d H:i:s');
    $comment = "$column changed to: $value";
    
    $sql = "INSERT INTO TimeLog (recordID, timestamp, ID, netID, callsign, comment, ipaddress) 
            VALUES (:recordID, :timestamp, :ID, :netID, :cs1, :comment, :ipaddress)";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
    $stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
    $stmt->bindParam(':netID', $netID, PDO::PARAM_STR);
    $stmt->bindParam(':cs1', $cs1, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':ipaddress', $ipaddress, PDO::PARAM_STR);
    $stmt->execute();
    
    // Update the record
    $sql = "UPDATE NetLog SET $column = :value, sse_timestamp = NOW() WHERE recordID = :recordID";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->execute();
    
    // Return the updated value to the client
    echo $value;
    
    logMessage("Update successful");
    
} catch (Exception $e) {
    logMessage("Error: " . $e->getMessage());
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}

if ($logFile) {
    fclose($logFile);
}
?>