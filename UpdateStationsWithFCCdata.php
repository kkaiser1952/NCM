<?php
    // UpdateStationsWithFCCdata.php
    // UpdateStationsWithFCCdata.php to remove latlng
    // UpdateStationsWithFCCdata.php  Written 2023-09-16, also look at updateStationsinfo.php but this one should do it all
    
    //error_reporting(E_ALL);
   // ini_set('display_errors', 'On');

require_once "dbConnectDtls.php";
require_once "geocode.php";     // Replace with your actual file name
require_once "GridSquare.php";  // Replace with your actual file name 
 
// Define the batch size (e.g., 100 records at a time)
$batchSize = 25;

$sql = "
SELECT 
    a.fccid,
    CONCAT(UCASE(LEFT(a.first, 1)), LCASE(SUBSTRING(a.first, 2))) AS Fname,
    CONCAT(UCASE(LEFT(a.last, 1)), LCASE(SUBSTRING(a.last, 2))) AS Lname,
    a.address1 AS address,
    CONCAT(UCASE(LEFT(a.city, 1)), LCASE(SUBSTRING(a.city, 2))) AS City,
    CONCAT(UCASE(LEFT(a.state, 1)), LCASE(SUBSTRING(a.state, 2))) AS State,
    LEFT(a.zip, 5) AS zip,
    a.callsign,
    CASE
        WHEN a.city <> s.city THEN 'City'
        WHEN a.state <> s.state THEN 'State'
        WHEN a.last <> s.Lname THEN 'Last Name'
        WHEN a.fccid <> s.fccid THEN 'FCCID'
        ELSE 'No Match'
    END AS TriggeredCondition,
    s.ID
FROM (
    SELECT 
        a.callsign,
        MAX(a.fccid) AS max_fccid
    FROM 
        fcc_amateur.en a
    GROUP BY 
        a.callsign
) AS max_fccids
INNER JOIN 
    fcc_amateur.en a
    ON max_fccids.callsign = a.callsign
    AND max_fccids.max_fccid = a.fccid
INNER JOIN 
    ncm.stations s
    ON a.callsign = s.callsign
WHERE 
    (BINARY a.city <> BINARY s.city OR (a.city IS NOT NULL AND BINARY a.city <> BINARY s.city))
    OR (BINARY a.state <> BINARY s.state OR (a.state IS NOT NULL AND BINARY a.state <> BINARY s.state))
    OR (BINARY a.last <> BINARY s.Lname OR (a.last IS NOT NULL AND BINARY a.last <> BINARY s.Lname))
    OR (BINARY a.fccid <> BINARY s.fccid OR (a.fccid IS NOT NULL AND BINARY a.fccid <> BINARY s.fccid))
ORDER BY 
    TriggeredCondition
    LIMIT 5
;";

// Fetch all records that need to be updated
$stmt = $db_found->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = 0; 

// Start profiling
$startTime = microtime(true);   //echo "$startTime";

// Process the records in batches
for ($i = 0; $i < count($rows); $i += $batchSize) {
    $batch = array_slice($rows, $i, $batchSize);

    // Build a single update query for the batch
    //$updateQuery = "UPDATE ncm.stations SET ";
    //$values = array();

    foreach ($batch as $row) {
        $address = $row['address'];
        $city    = $row['City'];
        $fccid   = $row['fccid'];
        $koords  = geocode("$address $city");
        
        //echo "<br>address: $address $city <br>fccid: $fccid <br>";
        echo "<br>foreach address: " . implode(', ', $koords . "<br><br>");
       // 36.0275443, -94.4273168, Washington , AR

        $latitude  = $koords[0];
        $longitude = $koords[1];

        $county = $koords[2];
        $state  = $koords[3];

        if ($state == '') {
            $state = $row['State'];
        }
        
        echo "<br>$address $city $state <br>Update koords: " . implode(', ', $koords) . "<br>";

        $gridd = gridsquare($latitude, $longitude);
        $grid = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";
        //echo "<br> $gridd[0].$gridd[1].$gridd[2].$gridd[3].$gridd[4].$gridd[5]";
        echo "<br>Calculated grid: $grid <br>";

        $sql2 = "UPDATE stations SET 
             Fname = :Fname,
             Lname = :Lname,
             grid = :grid,
             county = :county,
             state = :state,
             city = :city,
             home = :home,
             fccid = :fccid,
             dttm = :dttm,
             latitude = :latitude,
             longitude = :longitude,
             
             `comment` = 'Updated via fixStationsWithFCCdata.php'
          WHERE id = :callsign";    

        // Bind values to placeholders
        $stmt2 = $db_found->prepare($sql2);
        $stmt2->bindValue(':Fname', $row['Fname']);
        $stmt2->bindValue(':Lname', $row['Lname']);
        $stmt2->bindValue(':grid', $grid);
        $stmt2->bindValue(':county', $county);
        $stmt2->bindValue(':state', $state);
        $stmt2->bindValue(':city', $city);
        $stmt2->bindValue(':home', "$latitude,$longitude,$grid,$county,$state,$city");
        $stmt2->bindValue(':fccid', $fccid);
        $stmt2->bindValue(':dttm', date('Y-m-d H:i:s'));
        $stmt2->bindValue(':latitude', $latitude);
        $stmt2->bindValue(':longitude', $longitude);
        $stmt2->bindValue(':callsign', $row['callsign']);

        // Add debugging output for SQL query and bound values
        echo "<br>Executing query for callsign: " . $row['callsign'] . "<br>";
        echo "SQL Query: $sql2<br>";
        echo "Bound Values: " . json_encode([
            ':Fname' => $row['Fname'],
            ':Lname' => $row['Lname'],
            ':grid' => $grid,
            ':county' => $county,
            ':state' => $state,
            ':city' => $city,
            ':home' => "$latitude,$longitude,$grid,$county,$state,$city",
            ':fccid' => $fccid,
            ':dttm' => date('Y-m-d H:i:s'),
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':callsign' => $row['callsign']
        ]) . "<br>=========================";


        // Execute the prepared statement
        if ($stmt2->execute()) {
            echo "<br><br>Update successful for callsign: " . $row['callsign'] . " ";
        } else {
            echo "<br><br>Error updating callsign: " . $row['callsign'];
        }

        // Add debugging output
        echo "Processed batch #" . ($i / $batchSize) . "<br><br>";

        $count += count($batch);
    }
}

echo "<br><br>Done --> Count= $count";
?>
