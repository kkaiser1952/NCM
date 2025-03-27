<?php
/**
 * Net Control Manager (NCM) - Partial Activities Fetcher
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */

// Include database connection
require_once "dbConnectDtls.php";

// Get the net ID
$netID = isset($_GET['q']) ? intval($_GET['q']) : 0;

if (!$netID) {
    echo "<p>Error: No valid net ID provided</p>";
    exit();
}

// This file should contain just the code needed to generate the activity log table
// Extract the relevant part from your getactivities.php file
// Make sure it only returns the HTML for the activity log table

// Example (you'll need to adapt this to your actual code):
$query = "SELECT * FROM netLog WHERE netID = $netID ORDER BY timestamp";
$result = mysqli_query($conn, $query);

// Build the HTML table for the activity log
$html = '<table class="yourtableclasses">';
$html .= '<thead><tr><!-- Your table headers --></tr></thead>';
$html .= '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    // Add cells based on your data
    $html .= '</tr>';
}

$html .= '</tbody></table>';

echo $html;
?>