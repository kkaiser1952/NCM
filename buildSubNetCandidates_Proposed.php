
<?php  
    // This is used in index.php to create a list of sub net candidates for the current open net
//require_once "dbConnectDtls.php";

// Prepare the SQL statement with placeholders
$sql = "SELECT netID, activity, netcall
        FROM NetLog 
        WHERE (dttm >= NOW() - INTERVAL 3 DAY AND pb = 1)
        OR (logdate >= NOW() - INTERVAL 3 DAY AND pb = 0)
        GROUP BY netID 
        ORDER BY netID DESC";

try {
$stmt = $db_found->prepare($sql);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Execute the prepared statement
$stmt->execute();

// Fetch the results in a loop
while ($act = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $netID = htmlspecialchars($act['netID']);
    $activity = htmlspecialchars($act['activity']);
    $netcall = htmlspecialchars($act['netcall']);
    
    echo ("<option title='$netID' value='$netID'>Net #: $netID --> $activity</option>\n");
}

?> 