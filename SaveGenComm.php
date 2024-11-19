<?php
// SaveGenComm.php
// Written: ~2016
// Re-Written: 2024-11-19
// This code saves whatever is entered into the genComm field
require_once "dbConnectDtls.php";
require_once "getRealIpAddr.php";

function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

try {
    // Get and validate input
    $rawdata = file_get_contents('php://input');
    if (empty($rawdata)) {
        throw new Exception('No data received');
    }

    // Parse input - keeping your original structure
    $parts = explode("=", $rawdata);
    if (count($parts) < 4) {
        throw new Exception('Invalid data format');
    }

    // PHP 5.6 compatible filtering
    $netID = strip_tags(trim($parts[0]));
    $comment = $parts[2];
    $WRU = strtoupper($parts[3]);

    // Your original comment processing
    $comment = str_replace("+", " ", $comment);
    $comment = encodeURIComponent($comment);
    $comment = rawurldecode("$WRU: $comment");
    $comment = str_replace("&", " ", $comment);
    $comment = rawurldecode($comment);

    $ipaddress = getRealIpAddr();
    
    // PHP 5.6 compatible prepared statement
    $stmt = $db_found->prepare("INSERT INTO TimeLog 
                               (callsign, netID, comment, timestamp, ipaddress) 
                               VALUES 
                               (:callsign, :netID, :comment, :timestamp, :ipaddress)");
    
    // Bind parameters - more explicit for PHP 5.6
    $stmt->bindValue(':callsign', 'GENCOMM', PDO::PARAM_STR);
    $stmt->bindValue(':netID', $netID, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':timestamp', $open, PDO::PARAM_STR);
    $stmt->bindValue(':ipaddress', $ipaddress, PDO::PARAM_STR);
    
    $stmt->execute();

    // Return processed comment
    echo str_replace("+", " ", htmlspecialchars(urldecode($comment)));

} catch (PDOException $e) {
    // Database specific errors
    error_log("Database Error in SaveGenComm.php: " . $e->getMessage());
    http_response_code(500);
    echo "Database error occurred";
} catch (Exception $e) {
    // Other errors
    error_log("Error in SaveGenComm.php: " . $e->getMessage());
    http_response_code(400);
    echo "Error processing request";
}
?>