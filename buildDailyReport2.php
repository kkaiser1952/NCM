<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer	
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("SELECT netID, logdate, netcall, COUNT(*) AS count,
            (SELECT COUNT(DISTINCT netID)
             FROM NetLog
             WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
               AND logdate <= CURDATE()
            ) AS netID_count,
            logclosedtime
        FROM NetLog
        WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
          AND logdate <= CURDATE()
          
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
        background-color: red;
        color: white;
        font-weight: bold;
    }
    
    .red-bg {
        background-color: red;
        color: white;
    }
    
    .blue-row {
        background-color: blue;
        color: white;
        font-weight: bold;
    }
    
    label {
      font-weight: bold;
    }
    
    .date-row {
      font-weight: bold;
      font-size: 14pt;
      color: green;
</style>
";

// Print CSS styles
echo $cssStyles;

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report of " . $result[0]['netID_count'] . " Nets";
    echo '<h1>' . $title . '</h1>
    
     <form>  <!-- This adds a legend to the top of the report -->
        <label for="open_nets">Open Net:</label>
        <input type="text" id="open_nets" name="open_nets" class="red-bg" value="">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <label for="one_entry">One Entry:</label>
        <input type="text" id="one_entry" name="one_entry" class="blue-row" value=""><br><br>
      </form>
    '
    ;
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
    $currentDate = null;
    foreach ($result as $rowIndex => $row) {
        // Check if logclosedtime is null or empty
        $isClosed = empty($row['logclosedtime']);
        // Get the row class
        $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
        // Add red-row class if logclosedtime is null or empty
        $rowClass .= $isClosed ? ' red-row' : '';
        // Add blue-row class if count is 1
        if ($row['count'] == 1) {
            $rowClass .= ' blue-row ';
        }

        // Output each column value in a table row
        echo '<tr class="' . $rowClass . '">';

        // Output the date and day of the week in a separate row for the start of a new day
        $date = substr($row['logdate'], 0, 10);
        $dayOfWeek = date('l', strtotime($date));
        
        if ($currentDate !== $date) {
            echo '<tr class="date-row">';
            echo '<td colspan="' . (count($row) + 1) . '">' . $date . ' (' . $dayOfWeek . ')</td>';
            echo '</tr>';
            $currentDate = $date;
        }

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

        echo '</tr>';
    }

    // End the table
    echo '</table>';
} else {
    echo 'No results found.';
}
?>
