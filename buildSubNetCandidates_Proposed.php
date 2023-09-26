<?php
// Include your database connection code (e.g., dbConnectDtls.php) here
//require_once "dbConnectDtls.php";
// 2023-09-26

if (!$db_found) { require_once "dbConnectDtls.php";
    //die("Error: Database connection is not established. Check database credentials. <-- From buildOptionsForSelect_Proposed.php");
}

// Check if the database connection is valid
if ($db_found) {
    // Prepare the SQL statement with placeholders
    $sql = "SELECT netID, activity, netcall
            FROM NetLog 
            WHERE (dttm >= NOW() - INTERVAL 3 DAY AND pb = 1)
            OR (logdate >= NOW() - INTERVAL 3 DAY AND pb = 0)
            GROUP BY netID 
            ORDER BY netID DESC";
        //echo "SQL in Candidates: <br>$sql";
    try {
        $stmt = $db_found->prepare($sql);

        // Execute the prepared statement
        $stmt->execute();

        // Fetch the results in a loop
        while ($act = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $netID = htmlspecialchars($act['netID']);
            $activity = htmlspecialchars($act['activity']);
            $netcall = htmlspecialchars($act['netcall']);
            
            echo ("<option title='$netID' value='$netID'>Net #: $netID --> $activity</option>\n");
        } // End while
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Database connection is not established.";
}
?>
