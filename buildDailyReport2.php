<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("
    SELECT 
        DATE(dttm) AS date,
        COUNT(DISTINCT netID) AS netID_count,
        DATE_FORMAT(MAX(dttm), '%Y-%m-%d %W') AS dttm,
        SUM(`count`) AS total_count
    FROM NetLog
    WHERE dttm >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
    GROUP BY date
    ORDER BY date DESC
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
        color: white;
        font-weight: bold;
    }
    
    .red-bg {
        background-color: red;
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
        color: green;
</style>
";

// Print CSS styles
echo $cssStyles;

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report";
    echo '<h1>' . $title . '</h1>
    
     <form>  <!-- This adds a legend to the top of the report -->
        <label for="open_nets">Open Net:</label>
        <input type="text" id="open_nets" name="open_nets" class="red-bg" value="">
        
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <label for="one_entry">One Entry:</label>
        <input type="text" id="one_entry" name="one_entry" class="blue-bg" value=""><br><br>
      </form>
    ';
} else {
    echo 'No results found.';
}

// Check if there are any rows in the result set
if (!empty($result)) {
    // Start the table
    echo '<table>';

    // Table header
    echo '<tr>';
    echo '<th>netID</th>';
    echo '<th>dttm</th>';
    echo '<th>netcall</th>';
    echo '<th>count</th>';
    echo '</tr>';

    // Table rows
    foreach ($result as $row) {
        // Output the summary row for each day
        echo '<tr class="date-row">';
        echo '<td>' . $row['netID_count'] . '</td>';
        echo '<td>' . $row['dttm'] . '</td>';
        echo '<td></td>';
        echo '<td>' . $row['count'] . '</td>';
        echo '</tr>';

        // Fetch and output the detailed rows for each net and call
        $date = $row['date'];
        $sqlDetails = $db_found->prepare("
            SELECT netID, dttm, netcall, `count`
            FROM NetLog
            WHERE DATE(dttm) = :date
            ORDER BY dttm
        ");
        $sqlDetails->execute(array(':date' => $date));
        $detailsResult = $sqlDetails->fetchAll(PDO::FETCH_ASSOC);

        foreach ($detailsResult as $detailRow) {
            echo '<tr>';
            echo '<td>' . $detailRow['netID'] . '</td>';
            echo '<td>' . $detailRow['dttm'] . '</td>';
            echo '<td>' . $detailRow['netcall'] . '</td>';
            echo '<td>' . $detailRow['count'] . '</td>';
            echo '</tr>';
        }
    }

    // End the table
    echo '</table>';
} else {
    echo 'No results found.';
}
?>
