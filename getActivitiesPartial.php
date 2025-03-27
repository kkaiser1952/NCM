<?php
/**
 * Net Control Manager (NCM) - Partial Activity Log Fetcher
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log file for debugging - use an absolute path
$logDir = dirname(__FILE__);
$logPath = $logDir . '/partial_log.txt';
$logFile = fopen($logPath, 'a');

function logMessage($message) {
    global $logFile;
    fwrite($logFile, date('Y-m-d H:i:s') . ' - ' . $message . "\n");
    fflush($logFile);
}

logMessage("getActivitiesPartial.php called with netID: " . (isset($_GET['q']) ? $_GET['q'] : 'none'));
logMessage("Log location: " . $logPath);

// Include database connection
require_once "dbConnectDtls.php";

// Get net ID
$netID = isset($_GET['q']) ? intval($_GET['q']) : 0;

if (!$netID) {
    echo "<p>Error: No valid net ID provided</p>";
    logMessage("Error: No valid net ID provided");
    fclose($logFile);
    exit();
}

// Create a simpler implementation that directly queries the database
// This avoids the complexity of including getactivities.php

logMessage("Starting direct database query for net ID: " . $netID);

// Here we'll implement a simplified version of the query from getactivities.php
$g_query = "SELECT recordID, callsign, Fname, activity, netcall, comments 
            FROM NetLog 
            WHERE netID = $netID 
            ORDER BY logdate ASC";

logMessage("Query: " . $g_query);

$result = mysqli_query($conn, $g_query);

if (!$result) {
    logMessage("Query failed: " . mysqli_error($conn));
    echo "<p>Error fetching data: " . mysqli_error($conn) . "</p>";
    fclose($logFile);
    exit();
}

// Start building the HTML
$html = '<table class="table">';
$html .= '<thead><tr><th>#</th><th>Call</th><th>Name</th><th>Comments</th></tr></thead>';
$html .= '<tbody class="sortable" id="netBody">';

$rowCount = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $rowCount++;
    $html .= "<tr id=\"{$row['recordID']}\">";
    $html .= "<td>{$rowCount}</td>";
    $html .= "<td>" . htmlspecialchars($row['callsign']) . "</td>";
    $html .= "<td>" . htmlspecialchars($row['Fname']) . "</td>";
    $html .= "<td>" . htmlspecialchars($row['comments']) . "</td>";
    $html .= "</tr>";
}

$html .= '</tbody></table>';

logMessage("Generated table HTML with " . $rowCount . " rows");

echo $html;

logMessage("Finished processing");
fclose($logFile);
mysqli_close($conn);
?>