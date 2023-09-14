<?php
    
// fixStationsWithFCC-AddCity.php
// Use this program to compare NCM.stations with fcc_amateur.en and to 
// update NCM.stations when there is a difference
// Written: 2022-12-13 as an update to fixStationsWithFCC.php 

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

// Define the batch size (e.g., 100 records at a time)
$batchSize = 100;

$sql = "
SELECT a.fccid,
       CONCAT(UCASE(LEFT(a.first, 1)), LCASE(SUBSTRING(a.first, 2))) AS Fname,
       CONCAT(UCASE(LEFT(a.last, 1)), LCASE(SUBSTRING(a.last, 2))) AS Lname,
       a.address1 AS address,
       CONCAT(UCASE(LEFT(a.city, 1)), LCASE(SUBSTRING(a.city, 2))) AS City,
       CONCAT(UCASE(LEFT(a.state, 1)), LCASE(SUBSTRING(a.state, 2))) AS State,
       LEFT(a.zip, 5) AS zip,
       a.callsign
FROM fcc_amateur.en a
INNER JOIN (
    SELECT a.callsign, MAX(a.fccid) as fccid, a.callsign as ccall
    FROM fcc_amateur.en a
    GROUP BY a.callsign
) b
ON a.callsign = b.callsign 
AND a.fccid = b.fccid
INNER JOIN ncm.stations s
ON a.callsign = s.callsign
WHERE a.city <> s.city
   OR a.state <> s.state
   OR a.first <> s.Fname
   OR a.last <> s.Lname
;";

// Count the total number of records in the query
$totalRecords = $db_found->query($sql)->rowCount();

// Calculate the number of iterations needed
$numIterations = ceil($totalRecords / $batchSize);

$count = 0;

for ($iteration = 0; $iteration < $numIterations; $iteration++) {
    // Calculate the offset for the current batch
    $offset = $iteration * $batchSize;

    // Fetch a batch of records with LIMIT and OFFSET
    $batchSql = $sql . " LIMIT $batchSize OFFSET $offset";
    $stmt = $db_found->query($batchSql);

    foreach ($stmt as $row) {
        $count++;

        $address = $row['address'];
        $city    = $row['City']; // Proper-cased
        $fccid   = $row['fccid'];

        $koords  = geocode("$address");

        $latitude  = $koords[0];
        $longitude = $koords[1];

        $county    = $koords[2];
        $state     = $koords[3];
        if ($state == '') {
            $state = $row['State']; // Proper-cased
        }

        $gridd     = gridsquare($latitude, $longitude);
        $grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";

        echo "<br><br>$count ==> {$row['callsign']}: $fccid, $address, $county, $state, $city";

        // Prepare the SQL statement with placeholders
        $sql2 = "UPDATE stations SET 
                     Fname = :first,
                     Lname = :last,
                     grid = :grid,
                     county = :county,
                     state = :state,
                     city = :city,
                     home = :home,
                     fccid = :fccid,
                     dttm = NOW(),
                     latitude = :latitude,
                     longitude = :longitude,
                     latlng = GeomFromText(:latlng),
                     comment = 'Updated via fixStationsWithFCC-AddCity.php'
                  WHERE id = :callsign";

        // Prepare the SQL statement
        $stmt2 = $db_found->prepare($sql2);

        // Assign values to placeholders
        $stmt2->bindValue(':first', $row['Fname']);
        $stmt2->bindValue(':last', $row['Lname']);
        $stmt2->bindValue(':grid', $grid);
        $stmt2->bindValue(':county', $county);
        $stmt2->bindValue(':state', $state);
        $stmt2->bindValue(':city', $city);
        $stmt2->bindValue(':home', "$latitude,$longitude,$grid,$county,$state,$city");
        $stmt2->bindValue(':fccid', $fccid);
        $stmt2->bindValue(':latitude', $latitude);
        $stmt2->bindValue(':longitude', $longitude);
        $stmt2->bindValue(':latlng', "POINT($latitude $longitude)");
        $stmt2->bindValue(':callsign', $row['callsign']);
    
        // Execute the prepared statement
        if ($stmt2->execute()) {
            echo "<br><br>Update successful for callsign: " . $row['callsign'];
        } else {
            echo "<br><br>Error updating callsign: " . $row['callsign'];
        }
    }
}

echo "<br><br>Done --> Count= $count";
?>
