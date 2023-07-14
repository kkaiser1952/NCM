<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #000000;
            background-color: #F0F0F0; /* Set primary color for all <td> elements */
        }

        .red-td {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>

<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("SELECT netID, logdate, netcall, COUNT(*) AS count,
            pb,   /* testnet, */
            (SELECT COUNT(DISTINCT netID)
             FROM NetLog
             WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)) AS netID_count,
             logclosedtime,
             /*SUM(timeonduty) as total_time*/
             CONCAT(
                    LPAD(FLOOR(SUM(timeonduty) / 3600), 2, '0'), ':',
                    LPAD(FLOOR(MOD(SUM(timeonduty), 3600) / 60), 2, '0'), ':',
                    LPAD(MOD(SUM(timeonduty), 60), 2, '0')
                  ) AS Volunteer_Time     
        FROM NetLog
       WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
       GROUP BY netID, netcall
       ORDER BY netID DESC
");

// Execute the SQL query and store the result in $result variable
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report for " . $result[0]['netID_count'] . " Nets <br> Today is: " . date("l") .", " . date("Y/m/d") . "<br>";

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

    // Add the headers
    foreach (array_keys($result[0]) as $column) {
        if ($column !== 'netID_count' && $column !== 'pb') {
            echo '<th>' . $column . '</th>';
        }
    }
    echo '</tr>'; // end for Table header

    // Table rows
    $currentDate = null;
    foreach ($result as $rowIndex => $row) {
        // Check if logclosedtime is null or empty
        $isClosed = empty($row['logclosedtime']);
        // Get the row class
        $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';

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

        // Column data you don't want to see
        foreach ($row as $column => $columnValue) {
            if ($column === 'netID_count' OR $column === 'pb') {
                continue;
            }

            // If logclosedtime is null or empty, leave the column entry empty
            if ($isClosed && $column === 'logclosedtime') {
                echo '<td></td>';
            } else {
                // Add the red-td class to the first <td> if count is 1
                if ($column === 'netID' && $row['count'] == 1) {
                    echo '<td class="red-td">' . $columnValue . '</td>';
                } else {
                    echo '<td>' . $columnValue . '</td>';
                }
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Define the function
  function checkAndSetColor(tdIndex, valueToCheck, bgColor) {
    // Get the value of the specified <td> using .eq()
    var tdValue = $("tr td").eq(tdIndex - 1).text();

    // Check if the value matches the specified value
    if (tdValue.trim() === valueToCheck) {
      // Set the background color of the first <td> to the specified color
      $("tr td").eq(0).css("background-color", bgColor);
      // Set the background color of the entire <tr> to the specified color
      $("tr").css("background-color", bgColor);
    }
  }

  // Call the function with the desired parameters
  //checkAndSetColor(4, "1", "red");
});

</script>

</body>
</html>
