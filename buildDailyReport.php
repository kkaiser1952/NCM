<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer	
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("SELECT netID, MIN(logdate) AS start_date, MAX(logclosedtime) AS end_date, netcall, COUNT(*) AS count, 
    MAX(logclosedtime) AS logclosedtime,
    (SELECT COUNT(DISTINCT netID)
     FROM NetLog
     WHERE dttm >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
       AND dttm <= CURDATE()
    ) AS netID_count
    FROM NetLog
    WHERE dttm >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
      AND dttm <= CURDATE()
    GROUP BY netID, netcall
    ORDER BY netID DESC
");

// Execute the SQL query and store the result in $result variable
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// CSS styles for the report table
$cssStyles = "
<style>
    table {
        border-collapse: collapse;
    }
    
    th, td {
        padding: 8px;
        border: 1px solid #000000;
    }
    
    .odd-row {
        background-color: #F0F0F0;
    }
    
    .even-row {
        background-color: #FFFFFF;
    }
    
    .empty-value {
        background-color: red;
    }
</style>
";

// Print CSS styles
echo $cssStyles;

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report of " . $result[0]['netID_count'] . " net";
    echo '<h1>' . $title . '</h1>';
} else {
    echo 'No results found.';
}

// Check if there are any rows in the result set
if (!empty($result)) {
    // Start the table
    echo '<table>';

    // Table header
    echo '<tr>';
    echo '<th>Net ID</th>';
    echo '<th>Net Call</th>';
    echo '<th>Count</th>';
    echo '<th>Start Date</th>';
    echo '<th>End Date</th>';
    echo '<th>Elapsed Time</th>';
    echo '</tr>';

    // Table rows
    foreach ($result as $rowIndex => $row) {
        // Calculate elapsed time
        $startDate = strtotime($row['start_date']);
        $endDate = strtotime($row['end_date']);
        $elapsedTime = gmdate('H:i', $endDate - $startDate);

        // Get the row class
        $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';

        // Start a table row with the appropriate class
        echo '<tr class="' . $rowClass . '">';

        // Output each column in the desired order
        echo '<td>' . ($row['netID'] ?? '<span class="empty-value">Empty</span>') . '</td>';
        echo '<td>' . ($row['netcall'] ?? '<span class="empty-value">Empty</span>') . '</td>';
        echo '<td>' . ($row['count'] ?? '<span class="empty-value">Empty</span>') . '</td>';
        echo '<td>' . ($row['start_date'] ?? '<span class="empty-value">Empty</span>') . '</td>';
        echo '<td>' . ($row['end_date'] ?? '<span class="empty-value">Empty</span>') . '</td>';
        echo '<td>' . ($elapsedTime ?? '<span class="empty-value">Empty</span>') . '</td>';

        // Close the table row
        echo '</tr>';
    }

    // End the table
    echo '</table>';
} else {
    echo 'No results found.';
}
?>

