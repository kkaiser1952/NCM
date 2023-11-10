<?php
// Initialize error reporting if needed
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once "getRealIpAddr.php";
require_once "dbConnectDtls.php";
require_once "GridSquare.php";

// Get raw data from POST request
$rawdata    = file_get_contents('php://input');
$part       = explode("&", $rawdata);
$part2      = explode("=", $part[1]);
$part30     = $part2[0];
$part31     = $part2[1];
$part4      = explode("%3A", $part31);
$recordID   = $part4[1];
$column     = $part4[0];
$valueParts = explode("=", $part[0]);
$value      = rawurldecode(str_replace("+", " ", trim($valueParts[1], "+")));
$ipaddress  = getRealIpAddr();
$moretogo   = 0;

// Define a list of columns that can be updated
$allowedColumns = ["county", "state", "grid", "latitude", "longitude", "district", "tactical", "team", "aprs_call", "cat", "section"];

if (in_array($column, $allowedColumns) && ($column != "tactical" || $value != "DELETE")) {
    // Check if the column is "tactical"
    if ($column == "tactical" && !empty($value)) {
        // Handle tactical update
        $sql = "SELECT ID, netID, callsign, tactical FROM NetLog WHERE recordID = :recordID";
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $netID = $row['netID'];
        $ID = $row['ID'];
        $cs1 = $row['callsign'];
        $tactical = $row['tactical'];

        $sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress)
                VALUES (:recordID, :ID, :netID, :cs1, :comment, :timestamp, :ipaddress)";
        $stmt = $db_found->prepare($sql);
        $comment = "Tactical set to: $value";
        $timestamp = date('Y-m-d H:i:s'); // Adjust timestamp format as needed
        $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
        $stmt->bindParam(':netID', $netID, PDO::PARAM_STR);
        $stmt->bindParam(':cs1', $cs1, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
        $stmt->bindParam(':ipaddress', $ipaddress, PDO::PARAM_STR);
        $stmt->execute();
    }

    if ($column == "cat") {
        $column = "TRFK-FOR";
        $value = strtoupper($value);
    }

    $sql = "SELECT ID, netID, callsign FROM NetLog WHERE recordID = :recordID";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $netID = $row['netID'];
    $ID = $row['ID'];
    $cs1 = $row['callsign'];

    $deltaX = "$column Change";
    if ($column == "grid") {
        $deltaX = 'LOCΔGrid: ' . $value . ' This also changed LAT/LON values';
    } elseif ($column == "state") {
        $deltaX = 'LOCΔState: ' . $value;
    } elseif ($column == "county") {
        $deltaX = 'LOCΔCounty: ' . $value;
    } elseif ($column == "district") {
        $deltaX = 'LOCΔDistrict: ' . $value;
    } elseif ($column == "latitude") {
        $deltaX = 'LOCΔLAT: ' . $value . ' This also changed the grid value';
    } elseif ($column == "longitude") {
        $deltaX = 'LOCΔLON: ' . $value . ' This also changed the grid value';
    }

    $sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress)
            VALUES (:recordID, :ID, :netID, :cs1, :deltaX, :timestamp, :ipaddress)";
    $stmt = $db_found->prepare($sql);
    $comment = $deltaX;
    $timestamp = date('Y-m-d H:i:s'); // Adjust timestamp format as needed
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
    $stmt->bindParam(':netID', $netID, PDO::PARAM_STR);
    $stmt->bindParam(':cs1', $cs1, PDO::PARAM_STR);
    $stmt->bindParam(':deltaX', $deltaX, PDO::PARAM_STR);
    $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
    $stmt->bindParam(':ipaddress', $ipaddress, PDO::PARAM_STR);
    $stmt->execute();

    if ($column == "TRFK-FOR") {
        $column = "cat";
    }
}

if ($column == "active") {
    // Handle active status change
    $sql = "SELECT ID, netID, callsign FROM NetLog WHERE recordID = :recordID";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $netID = $row['netID'];
    $ID = $row['ID'];
    $cs1 = $row['callsign'];

    $comment = "Status change: $value";
    $timestamp = date('Y-m-d H:i:s'); // Adjust timestamp format as needed
    $sql = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress)
            VALUES (:recordID, :ID, :netID, :cs1, :comment, :timestamp, :ipaddress)";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
    $stmt->bindParam(':netID', $netID, PDO::PARAM_STR);
    $stmt->bindParam(':cs1', $cs1, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
    $stmt->bindParam(':ipaddress', $ipaddress, PDO::PARAM_STR);
    $stmt->execute();

    // Update the timeout value when the active(status) setting is changed
    if (in_array($value, ["OUT", "Out", "BRB", "QSY", "In-Out"])) {
        $to = date('Y-m-d H:i:s'); // Adjust timestamp format as needed
        $sql = "UPDATE NetLog SET timeout = :timeout, timeonduty = (timestampdiff(SECOND, logdate, :timeout) + timeonduty), status = 1 WHERE recordID = :recordID";
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':timeout', $to, PDO::PARAM_STR);
        $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
        $stmt->execute();
    } elseif ($value == "In") {
        $to = date('Y-m-d H:i:s'); // Adjust timestamp format as needed
        $newopen = date('Y-m-d H:i:s'); // Adjust timestamp format as needed
        $sql = "UPDATE NetLog SET timeout = NULL, logdate = :newopen, status = 0, logdate = CASE WHEN pb = 1 AND logdate = 0 THEN :to ELSE logdate END WHERE recordID = :recordID";
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':newopen', $newopen, PDO::PARAM_STR);
        $stmt->bindParam(':to', $to, PDO::PARAM_STR);
        $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
        $stmt->execute();
    }
}

// Handle other updates for specific columns (e.g., 'Fname', 'Lname', 'email', 'city', etc.)
$specialColumns = ["Fname", "Lname", "email", "city"];
if (in_array($column, $specialColumns)) {
    $sql = "SELECT callsign FROM NetLog WHERE recordID = :recordID LIMIT 1";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $callsign = $result['callsign'];

    $sql = "UPDATE stations SET $column = :value WHERE callsign = :callsign";
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->bindParam(':callsign', $callsign, PDO::PARAM_STR);
    $stmt->execute();
}

// Update the NetLog with the new information
$sql = "UPDATE NetLog SET $column = :value WHERE recordID = :recordID";
$stmt = $db_found->prepare($sql);
$stmt->bindParam(':value', $value, PDO::PARAM_STR);
$stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
$stmt->execute();
?>
