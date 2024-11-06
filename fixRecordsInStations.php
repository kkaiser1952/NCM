<?php
    // fixRecordsInStations.php
    // Written: 2024-11-05
    // This program updates a record based only on its callsign
    // Updates: lat/lng, Lname, latituded, longituded, grid, county
    // state, city, district, Home, dttm, comment, country, fccid
    // Think about active_call
    
// Error checking/reporting    
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Path settings and imports
require_once "dbConnectDtls.php";
require_once "GridSquare.php";
require_once "geocode.php";
require_once "config.php";
    
    // Step 1: Enter the callsign
$callsign = "wa0tjt";  //then: wd4nit, wd5gmx
    
    // Step 2-3: Get address, first, last from the FCC en
// Prepare the SQL query with parameters
$sql = "
SELECT e1.fccid, e1.callsign, e1.first, e1.last, CONCAT(e1.address1, '  ', e1.city, '  ', e1.state, '  ', e1.zip) as address
  FROM fcc_amateur.en e1
  JOIN (
    SELECT MAX(fccid) as max_fccid 
    FROM fcc_amateur.en 
    WHERE callsign = :callsign
  ) e2 ON e1.fccid = e2.max_fccid
  WHERE e1.callsign = :callsign
  LIMIT 1";

// Debug output
echo "<br>" . htmlspecialchars($sql) . "<br>";

try {
    // Prepare and execute the statement
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':callsign', $callsign);
    $stmt->execute();
    
    // Fetch the results
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        // Store each column in a variable
        $fccid = $result['fccid'];
        $callsign = $result['callsign'];
        $first = $result['first'];
        $last = $result['last'];
        $address = $result['address'];
        
        // Now you can use these variables in your code
        // For example, you could output them:
        echo "FCCID: " . htmlspecialchars($fccid) . "<br>";
        echo "Callsign: " . htmlspecialchars($callsign) . "<br>";
        echo "Name: " . htmlspecialchars($first) . " " . htmlspecialchars($last) . "<br>";
        echo "Address: " . htmlspecialchars($address) . "<br>";
    } else {
        echo "No results found for callsign: " . htmlspecialchars($callsign);
    }
} catch (PDOException $e) {
    // Handle any database errors
    echo "Database error: " . htmlspecialchars($e->getMessage());
}

    // Step 4: Use geocode.php to get all the detail location information
$koords = geocode($address);
if($koords) {
    echo("<br><br>$koords[0], $koords[1], $koords[2], $koords[3]<br>");
    $latitude = $koords[0];
    $longitude = $koords[1];
    $county = $koords[2];
    $state = $koords[3];
} else {
   echo "Could not geocode address";
}

echo "<br>$county";

    // Step 4a: Get grid square
$grid = gridsquare($latitude, $longitude);


echo "<br>$grid";


    
?>
