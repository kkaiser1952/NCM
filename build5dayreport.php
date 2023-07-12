<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer	
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("SELECT netID, logdate, netcall, COUNT(*) AS count,
            pb,
            (SELECT COUNT(DISTINCT netID)
             FROM NetLog
             WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)) AS netID_count,
             logclosedtime,
         
             CONCAT(
    FLOOR(TIMESTAMPDIFF(MINUTE, MIN(logdate), logclosedtime) / 60), 'h ',
    TIMESTAMPDIFF(MINUTE, MIN(logdate), logclosedtime) % 60, 'm'
  ) AS ttl_time
        FROM NetLog
       WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
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
        background-color: #087f47;
        color: white;
        font-weight: bold;
    }
    
    .red-bg {
        background-color: red;
        color: white;
    }
    
    .green-bg {
        background-color: green;
        color: white;
    }
    
    .blue-bg {
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
      color: darkgreen;
      
    .opcolors {
        font-weight: bold !important;
        color: white !important;
        align-content: center;
  
        background: #1b6013; /* Old browsers */
        background: -moz-linear-gradient(left,  #1b6013 44%, #2989d8 47%, #207cca 49%, #1c1fcc 52%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left,  #1b6013 44%,#2989d8 47%,#207cca 49%,#1c1fcc 52%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right,  #1b6013 44%,#2989d8 47%,#207cca 49%,#1c1fcc 52%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

</style>
";

// Print CSS styles
echo $cssStyles;

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report for " . $result[0]['netID_count'] . " Nets <br> Today is: " . date("l") .", " . date("Y/m/d") . "<br>";
    
    echo '<h1>' . $title . '</h1>
    
     <form>  <!-- This adds a legend to the top of the report -->
        <label for="open_nets">Open Net:</label>
        <input type="text" id="open_nets" name="open_nets" class="green-bg" value="">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <label for="one_entry">Only One Entry:</label>
        <input type="text" id="one_entry" name="one_entry" class="red-bg" value=""><br>
        
        <label for="prebuilt">Pre-Built:</label>
        <input type="text" id="prebuilt" name="prebuilt" class="blue-bg" value=""><br><br>
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
        if ($column !== 'netID_count' && $column !== 'pb') {
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
        // Add blue-bg class if logclosedtime is null or empty
        $rowClass .= $isClosed ? ' red-row' : '';
        // Add red-bg class if count is 1
        if ($row['count'] == 1) {
            $rowClass .= ' red-bg ';
        }
        
        // Pre-built net background
        if ($row['pb'] == 1) {
            $rowClass .= ' blue-bg ';
        }

        // Output each column value in a table row
        if ($row['pb'] !== 'pb') {
        echo '<tr class="' . $rowClass . '">';
        }

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


