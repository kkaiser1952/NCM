<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer	
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("SELECT netID, dttm, netcall, COUNT(*) AS count,
            (SELECT COUNT(DISTINCT netID)
             FROM NetLog
             WHERE dttm >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
               AND dttm <= CURDATE()
            ) AS netID_count,
            logclosedtime
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
    
    .red-row {
        background-color: #FF0000;
    }
</style>
";

// Print CSS styles
echo $cssStyles;

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report of " . $result[0]['netID_count'] . " Nets";
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
    foreach (array_keys($result[0]) as $column) {
        if ($column !== 'netID_count') {
            echo '<th>' . $column . '</th>';
        }
    }
    echo '</tr>';

    // Table rows
    foreach ($result as $rowIndex => $row) {
        // Check if logclosedtime is null or empty
        $isClosed = empty($row['logclosedtime']);
        // Get the row class
        $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
        // Add red-row class if logclosedtime is null or empty
        $rowClass .= $isClosed ? ' red-row' : '';

        // Start a table row with the appropriate class
        echo '<tr class="' . $rowClass . '">';

        // Output each column value in a table cell
        foreach ($row as $column => $columnValue) {
            if ($column === 'netID_count') {
                continue;
            }

            // If logclosedtime is null or empty, leave the column entry empty
            if ($isClosed && $column === 'logclosedtime') {
                echo '<td></td>';
            } else {
                echo '<td>' . $columnValue . '</td>';
            }
        }

        // Close the table row
        echo '</tr>';
    }
    
        // End the table
    echo '</table>';
} else {
    echo 'No results found.';
}
?>



