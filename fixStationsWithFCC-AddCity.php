<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

require_once "dbConnectDtls.php";
require_once "geocode.php";     // Replace with your actual file name

 
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
FROM (
    SELECT a.callsign,
           MAX(a.fccid) AS max_fccid
    FROM fcc_amateur.en a
    GROUP BY a.callsign
) AS max_fccids
INNER JOIN fcc_amateur.en a
ON max_fccids.callsign = a.callsign
   AND max_fccids.max_fccid = a.fccid
INNER JOIN ncm.stations s
ON a.callsign = s.callsign
WHERE a.city <> s.city
   OR a.state <> s.state
   OR a.first <> s.Fname
   OR a.last <> s.Lname
   OR a.fccid <> s.fccid
;";

// Fetch all records that need to be updated
$stmt = $db_found->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = 0; 

// Process the records in batches
for ($i = 0; $i < count($rows); $i += $batchSize) {
    $batch = array_slice($rows, $i, $batchSize);

    // Build a single update query for the batch
    $updateQuery = "UPDATE ncm.stations SET ";
    $values = array();

    foreach ($batch as $row) {
        $address = $row['address'];
        $city    = $row['City'];
        $fccid   = $row['fccid'];

        $koords  = geocode("$address");

            $latitude  = $koords[0];
            $longitude = $koords[1];
            
            $county = $koords[2];
            $state  = $koords[3];
        
            //echo "lat: " . $latitude . " lon: " . $longitude . " Co. " . $county . " state: " . $state;
            
        if ($state == '') {
            $state = $row['State'];
        }
        
        require_once "GridSquare.php";  // Replace with your actual file name

        $gridd = gridsquare($latitude, $longitude);
            $grid = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";
            
            //echo " gridd: " . $gridd . " grid: " . $grid;   
            //echo "<br>1: " . $yn[1] . " 2: " . $yn[2] . " 3: " . $yn[3];
                //gridd: FN13HA grid: FN13HA    
                
        // Prepare the SQL statement with placeholders
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
             latlng = GeomFromText(:latlng),
             comment = 'Updated via fixStationsWithFCC-AddCity.php'
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
        $stmt2->bindValue(':dttm', date('Y-m-d H:i:s')); // Add dttm value here
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
    

    $updateQuery .= implode(',', $values);

    // Execute the batch update
    $db_found->exec($updateQuery);
    $count += count($batch);
}
}

echo "<br><br>Done --> Count= $count";
?>
