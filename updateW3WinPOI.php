<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";

try {

    // Check the connection
    if ($db_found->connect_error) {
        die("Connection failed: " . $db_found->connect_error);
    }

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude FROM `poi-2023-08-05`";
    $result = $db_found->query($sql);

    // Get the number of rows returned by the query
    $num_rows = $result->num_rows;

    if ($num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];

            // ...
        }
    } else {
        echo "No records found in the poi table.";
    }

    // Close the database connection
    $db_found->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

