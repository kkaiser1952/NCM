<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

try {

    // SQL query
    $sql = "
        SELECT
          DATE_FORMAT(n.logdate, '%Y-%m-%d') AS logdate,
          n.netID,
          n.netcall,
          COUNT(n.callsign) AS call_count,
          TIME_FORMAT(TIMEDIFF(MAX(n.logclosedtime), MIN(n.logdate)), '%H:%i') AS TOD,
          DATE_FORMAT(n.logdate, '%W') AS dow,
          CASE
            WHEN n.logclosedtime IS NULL OR n.logclosedtime = '0000-00-00 00:00:00' THEN 'open'
            WHEN COUNT(n.callsign) < 2 THEN 'one checkin'
            ELSE 'closed'
          END AS status
        FROM
          NetLog n
        WHERE
          n.logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
        GROUP BY
          DATE(n.logdate), n.netID";

    // Prepare and execute the query
    $stmt = $db_found->prepare($sql);
    $stmt->execute();

    // HTML table generation
    echo '<table>';

    // Variable to keep track of the current logdate
    $currentLogdate = '';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Check if the logdate has changed
        if ($currentLogdate != $row['logdate']) {
            // Display the new logdate group header
            echo '<tr>';
            echo '<th>' . $row['logdate'] . ' (' . $row['dow'] . ')</th>';
            echo '<th>' . $row['call_count'] . '</th>';
            echo '</tr>';

            // Update the current logdate
            $currentLogdate = $row['logdate'];
        }

        // Determine the row background color and text color based on the status
        $rowBgColor = '';
        $textColor = '';
        $fontSize = '12px';

        if ($row['status'] == 'open') {
            $rowBgColor = 'red';
            $textColor = 'white';
        } elseif ($row['status'] == 'one checkin') {
            $rowBgColor = 'blue';
            $textColor = 'white';
        }

        // Display the row with the appropriate styling
        echo '<tr style="background-color: ' . $rowBgColor . '; color: ' . $textColor . ' font-size: ' . $fontSize . ';">';
        echo '<td>' . $row['netID'] . '</td>';
        echo '<td>' . $row['netcall'] . '</td>';
        echo '<td>' . $row['call_count'] . '</td>';
        echo '<td>' . $row['TOD'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} catch (PDOException $e) {
    // Handle any errors
    echo 'Error: ' . $e->getMessage();
}

// Close the database connection
$dbh = null;
?>
