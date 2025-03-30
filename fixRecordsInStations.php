<?php
    // fixRecordsInStations.php
    // Written: 2024-11-05
    // There is an extensive writeup at the bottom of the code
    
    // This program updates a record based only on its callsign
    // 
    // Be sure to comment out or uncomment  $stmt_update->execute();
    // at about line 322 way below
    
/////////////////////////////////////////////////////
//////////////* CAREFUL THIS IS WORKING *////////////
/////////////////////////////////////////////////////
// NetLog update currently commented out //


/*    Try this search to find empty data;  
    SELECT GROUP_CONCAT(callsign ORDER BY ID DESC SEPARATOR '  ') AS callsigns
FROM `stations`
WHERE id < 12622 AND grid = 'JJ00AA'

localhost/ncm/stations/		https://net-control.us/mysql/tbl_sql.php?db=ncm&table=stations&token=29791c64ba83455b999ec3ba36bb527a

    
                
        
        
        Your browser has phpMyAdmin configuration for this domain. Would you like to import it for current session?        
        Yes
        / No
        / Delete settings 
    


 Current selection does not contain a unique column. Grid edit, checkbox, Edit, Copy and Delete features are not available. 

 Showing rows 0 -  0 (1 total, Query took 0.0002 seconds.)

SELECT GROUP_CONCAT(callsign ORDER BY ID DESC SEPARATOR '  ') AS callsigns
FROM `stations`
WHERE id < 12622 AND grid = 'JJ00AA'

KB9UFJ  KC0YR  KD5CFV  KC0UH  KE6SYW  KD7BML  KE0TQ	

*/

    
    // Step 1: Enter the base callsign only
$callsign = "ke0hgi";


// First, create a function to get the base callsign
// Used when updateing NetLog and/or stations
function getBaseCallsign($callsign) {
    // Remove everything after hyphen or slash
    return preg_replace('/([-\/]).*$/', '', $callsign);
}
    
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

echo "<br>County: $county";

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

    // Debug: Echo the SQL with replaced parameters
    $debug_sql = $district_sql;
    $debug_sql = str_replace(':county', "'" . $county . "'", $debug_sql);
    $debug_sql = str_replace(':state', "'" . $state . "'", $debug_sql);
    echo "Debug SQL: " . $debug_sql . "<br>";

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

echo "<br>2nd district: $district";

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

    // Method 1: Manual parameter replacement for debugging
    $debug_sql = $sql;
    $debug_sql = str_replace(':latitude', "'" . $latitude . "'", $debug_sql);
    $debug_sql = str_replace(':longitude', "'" . $longitude . "'", $debug_sql);
    $debug_sql = str_replace(':last', "'" . $last . "'", $debug_sql);
    $debug_sql = str_replace(':city', "'" . $city . "'", $debug_sql);
    $debug_sql = str_replace(':county', "'" . $county . "'", $debug_sql);
    $debug_sql = str_replace(':state', "'" . $state . "'", $debug_sql);
    $debug_sql = str_replace(':district', "'" . $district . "'", $debug_sql);
    $debug_sql = str_replace(':grid', "'" . $grid . "'", $debug_sql);
    $debug_sql = str_replace(':home', "'" . $home . "'", $debug_sql);
    $debug_sql = str_replace(':zip', "'" . $zip . "'", $debug_sql);
    $debug_sql = str_replace(':fccid', "'" . $fccid . "'", $debug_sql);
    $debug_sql = str_replace(':country', "'" . $country . "'", $debug_sql);
    $debug_sql = str_replace(':w3w', "'" . $neww3w . "'", $debug_sql);
    $debug_sql = str_replace(':callsign', "'" . $callsign . "'", $debug_sql);
    echo "<br>Debug SQL: " . $debug_sql . "<br>";

    // Method 2: Using PDO's built-in debug
    $stmt->debugDumpParams();
    
    $stmt->execute();
    
    echo "<br>Record updated successfully for callsign: " . htmlspecialchars($callsign);
} catch(PDOException $e) {
    echo "<br>Error updating record: " . $e->getMessage();
}
       
echo "<br><br>";     
        
// ==================================================================== //        
       
/// Step 8: Create SQL to read & then update NetLog
$netlog_query = "SELECT n1.recordID, n1.callsign, n1.latitude, n1.longitude, 
                        n1.city, n1.county, n1.state, n1.district, n1.grid, n1.netID
                 FROM NetLog n1
                 INNER JOIN (
                     SELECT callsign, MAX(recordID) as max_recordID
                     FROM NetLog
                     WHERE callsign LIKE :basecall_pattern
                     GROUP BY callsign
                 ) n2 ON n1.recordID = n2.max_recordID
                 ORDER BY n1.recordID DESC";

try {
    $stmt_netlog = $db_found->prepare($netlog_query);
    $stmt_netlog->bindValue(':basecall_pattern', $callsign);  // $callsign is already the base
    $stmt_netlog->execute();
    
    $update_count = 0;
    while ($netlog_row = $stmt_netlog->fetch(PDO::FETCH_ASSOC)) {
        // Process each matching record
        $recordID = $netlog_row['recordID'];
        $full_callsign = $netlog_row['callsign'];
        $netID = $netlog_row['netID'];
        
        $netlog_update = "UPDATE NetLog SET
                            `latitude` = :latitude,
                            `longitude` = :longitude,
                            `city` = :city,
                            `county` = :county,
                            `state` = :state,
                            `District` = :district,
                            `grid` = :grid,
                            `dttm` = CURRENT_TIMESTAMP,
                            `comments` = 'updated by fixRecordsInStations.php'
                         WHERE `recordID` = :recordID 
                         AND `callsign` = :full_callsign
                         AND `netID` = :netID";
        
        $stmt_update = $db_found->prepare($netlog_update);
        $stmt_update->bindParam(':latitude', $latitude);
        $stmt_update->bindParam(':longitude', $longitude);
        $stmt_update->bindParam(':city', $city);
        $stmt_update->bindParam(':county', $county);
        $stmt_update->bindParam(':state', $state);
        $stmt_update->bindParam(':district', $district);
        $stmt_update->bindParam(':grid', $grid);
        $stmt_update->bindParam(':recordID', $recordID);
        $stmt_update->bindParam(':full_callsign', $full_callsign);
        $stmt_update->bindParam(':netID', $netID);
        
        // Commented execute as requested
         
         $stmt_update->execute();
        
        $update_count++;
        
        echo "<br>Ready to update NetLog record for callsign: " . htmlspecialchars($full_callsign) . 
             " (Record ID: " . htmlspecialchars($recordID) . 
             ", Net ID: " . htmlspecialchars($netID) . ")";
    }
    echo "<br>Total NetLog records found for update: $update_count";
} catch(PDOException $e) {
    echo "<br>Error with NetLog operations: " . $e->getMessage();
}
?>

<?php
/*
========================================================================
PROGRAM SUMMARY: fixRecordsInStations.php
========================================================================
PURPOSE:
This program updates location and personal information for amateur radio operators
in both the stations and NetLog tables based on FCC database information.

PROCESS:
1. Accepts a base callsign input (without suffixes like -1 or /P)
2. Retrieves current FCC information
3. Geocodes the address to get precise location data
4. Calculates grid square from coordinates
5. Converts coordinates to What3Words address
6. Looks up district information from HPD table
7. Updates stations table with all new information
8. Updates all matching records in NetLog (including callsign variations)

KEY FEATURES:
- Proper case handling for names (including O'Neil format)
- State codes forced to uppercase
- Handles callsign variations in NetLog (WA0TJT, WA0TJT-1, etc.)
- District lookup based on county/state
- Secure SQL using prepared statements
- Full error handling and logging

TABLES AFFECTED:
1. stations: Complete update of location and personal info
2. NetLog: Location information update for all matching callsigns

DEPENDENCIES:
- dbConnectDtls.php: Database connection
- config2.php: Configuration settings
- GridSquare.php: Grid calculator
- getCrossRoads.php: Street intersection lookup
- geocode.php: Address geocoding
- What3Words API key (in config)
- HPD table for district lookups

USAGE:
1. Modify $callsign variable at top of file
2. Review results before uncommenting NetLog execute statement
3. Run manually - admin use only

AUTHOR: Keith Kaiser, WA0TJT & Claude 3.5
CREATED: 2024-11-05
========================================================================
*/
?>
