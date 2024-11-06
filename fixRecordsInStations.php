<?php
    // fixRecordsInStations.php
    // Written: 2024-11-05
    // This program updates a record based only on its callsign
    // Updates stations: lat/lng, Lname, latituded, longituded, grid, county
    // state, city, district, Home, dttm, comment, country, fccid
    // Updates netLog: lat/lng, grid, county, state, city, district, comment
    
///////////////////////////////////////////////////
//////////////* CAREFUL THIS IS WORKS *////////////
///////////////////////////////////////////////////
    
    // Step 1: Enter the callsign
$callsign = "kc0yso";
    
// Error checking/reporting    
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Path settings and imports
require_once "dbConnectDtls.php";
require_once "config2.php";
require_once "GridSquare.php";
require_once "getCrossRoads.php";
require_once "geocode.php";
//require_once "config.php";
    
    // Step 2-3: Get address, first, last from the FCC en
// Prepare the SQL query with parameters
$sql = "
SELECT e1.fccid, e1.callsign, e1.first, e1.last, e1.city, e1.zip,
    CONCAT(e1.address1, '  ', e1.city, '  ', e1.state, '  ', e1.zip) as address
  FROM fcc_amateur.en e1
  JOIN (
    SELECT MAX(fccid) as max_fccid 
    FROM fcc_amateur.en 
    WHERE callsign = :callsign
  ) e2 ON e1.fccid = e2.max_fccid
  WHERE e1.callsign = :callsign
  LIMIT 1";

// Debug output
 //echo "<br>" . htmlspecialchars($sql) . "<br>";

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
        $city = $result['city'];
        
        
        // Now you can use these variables in your code
        // For example, you could output them:
        echo "<br>FCCID: " . htmlspecialchars($fccid) . "<br>";
        echo "Callsign: " . htmlspecialchars($callsign) . "<br>";
        echo "Name: " . htmlspecialchars($first) . " " . htmlspecialchars($last) . "<br>";
        echo "Address: " . htmlspecialchars($address) . "<br>";
        echo "City: " . htmlspecialchars($city) . "<br>";
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
    echo("<br>$koords[0], $koords[1], $koords[2], $koords[3]<br>");
    $latitude = $koords[0];
    $longitude = $koords[1];
    $county = $koords[2];
    $state = $koords[3];
} else {
   echo "Could not geocode address";
}

echo "<br>$county";

    // Step 5: Get grid square
$grid = gridsquare($latitude, $longitude);

echo "<br>$grid<br>";

    // Step 5: Convert lat/lng to W3W
$api_key = $config['geocoder']['api_key'];

// Debug output to verify coordinates
// echo "<br>Attempting W3W conversion with coordinates: $latitude, $longitude<br>";

function getWhat3Words($lat, $lng, $api_key) {
    $url = "https://api.what3words.com/v3/convert-to-3wa";
    $params = http_build_query([
        'coordinates' => "$lat,$lng",
        'language' => 'en',
        'key' => $api_key
    ]);
    
    $full_url = $url . '?' . $params;
    // Debug output
    //echo "API URL: " . htmlspecialchars($full_url) . "<br>";
    
    $ch = curl_init($full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    
    // Add error handling for CURL
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch) . "<br>";
    }
    
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Debug output
    //echo "HTTP Response Code: " . $http_code . "<br>";
    //echo "Raw Response: " . htmlspecialchars($response) . "<br>";
    
    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON decode error: " . json_last_error_msg() . "<br>";
    }
    
    return $decoded;
} // End getWhat3Words()

// Call the function with error checking
if (isset($latitude) && isset($longitude)) {
    $result = getWhat3Words($latitude, $longitude, $api_key);
    if (isset($result['words'])) {
        $neww3w = $result['words'];  // Remove htmlspecialchars here - store raw data
        echo "What3Words address: " . htmlspecialchars($result['words']) . "<br>";
    } else {
        echo "Error in W3W response: " . "<br>";
        print_r($result); // This will show the full error response
    }
} else {
    echo "Error: Latitude or longitude not set<br>";
}

    // Step 6: Create Home
    // Example: 39.202903,-94.602862,EM29QE,Platte,MO,KANSAS CITY,///guiding.confusion.towards
$home = "$latitude,$longitude,$grid,$county,$state,$city,$neww3w";  // Use double quotes, not single quotes
echo "<br>home: $home<br>";  // Use double quotes to show the actual values

// Function for proper case that handles apostrophes
function properCase($string) {
    // Split on apostrophes to handle names like O'Neil
    $parts = explode("'", $string);
    // Proper case each part
    $parts = array_map(function($part) {
        return ucwords(strtolower(trim($part)));
    }, $parts);
    // Rejoin with apostrophes
    return implode("'", $parts);
} // End properCase()

    // Step 7: Get district values
$district = null;  // Default to null
$district_sql = "SELECT `District` 
                   FROM HPD 
                  WHERE county = :county 
                    AND state = :state 
                  LIMIT 1";

try {
    $stmt_district = $db_found->prepare($district_sql);
    $stmt_district->bindParam(':county', $county);
    $stmt_district->bindParam(':state', $state);
    $stmt_district->execute();
    
    if ($row = $stmt_district->fetch(PDO::FETCH_ASSOC)) {
        $district = $row['District'];
        $district = strtoupper($district);
    }
} catch(PDOException $e) {
    echo "<br>Error looking up district: " . $e->getMessage();
} // End try or district look-up


    // Step 8: Create SQL to update stations
// Format variables before binding
$last = properCase($last);          // Handles O'Neil correctly
$city = properCase($city);          // Makes "new york" into "New York"
$county = properCase($county);      // Makes "san diego" into "San Diego"
$state = strtoupper($state);        // Makes "new york" into "New York"
$callsign = strtoupper($callsign);  // Ensures callsign is uppercase


$sql = "UPDATE stations SET
            `latitude` = :latitude,
            `longitude` = :longitude,
            `Lname` = :last,
            `city` = :city,
            `county` = :county,
            `state` = :state,
            `District` = :district,
            `grid` = :grid,
            `home` = :home,
            `zip` = :zip,
            `fccid` = :fccid,
            `country` = :country,
            `w3w` = :w3w,
            `dttm` = CURRENT_TIMESTAMP,
            `comment` = 'updated by fixRecordsInStations.php',
            `active_call` = 'y'
        WHERE `callsign` = :callsign";

try {
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':last', $last);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':county', $county);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':district', $district);
    $stmt->bindParam(':grid', $grid);
    $stmt->bindParam(':home', $home);
    $stmt->bindParam(':zip', $zip);
    $stmt->bindParam(':fccid', $fccid);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':w3w', $neww3w);  
    $stmt->bindParam(':callsign', $callsign);
    
    $stmt->execute();
    
    echo "<br>Record updated successfully for callsign: " . htmlspecialchars($callsign);
} catch(PDOException $e) {
    echo "<br>Error updating record: " . $e->getMessage();
}
       
    // test
        echo "<br>$sql<br>";     
       
    // Step 8: Create SQL to update netLog
    
    
?>
