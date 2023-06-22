<?php
	// The purpose of this page/program is to send a daily report of NCM to my messages
	// Written: 2023-06-21, first day of summer	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
    // This comes from index.php when the 'editPoi' button is clicked
    // Get the netID of this net from the div idofnet
    
    //$netID = 2667;
    

<?php
// Assuming you have established a database connection

// Your SQL query
    $sql = $db_found->prepare("SELECT netID, dttm, netcall, COUNT(*) AS count,
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
//$result = /* Execute your SQL query here */;
    $sql->execute();
    	$result = $sql->fetch();

// CSS classes for zebra-like coloring
$oddRowClass = "odd-row";
$evenRowClass = "even-row";

// CSS styles for the report
$cssStyles = "
<style>
    .odd-row {
        background-color: #F0F0F0;
    }
    
    .even-row {
        background-color: #FFFFFF;
    }
</style>
";

// Print CSS styles
echo $cssStyles;

// Check if there are any rows in the result set
if ($result && $result->num_rows > 0) {
    // Variable to keep track of row index
    $rowIndex = 0;

    // Iterate over the result set and create the report
    while ($row = $result->fetch_assoc()) {
        // Get the row class
        $rowClass = $rowIndex % 2 === 0 ? $evenRowClass : $oddRowClass;

        // Create the <div> row with the appropriate class
        echo '<div class="' . $rowClass . '">';

        // Iterate over each column in the row
        foreach ($row as $columnValue) {
            echo '<div>' . $columnValue . '</div>';
        }

        // Close the row <div>
        echo '</div>';

        // Increment the row index
        $rowIndex++;
    }
} else {
    echo 'No results found.';
}

// Close the database connection
// ...

?>