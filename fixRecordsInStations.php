<?php
    // fixRecordsInStations.php
    // Written: 2024-11-05
    // There is an extensive writeup at the bottom of the code
    
    // This program updates records based on callsigns
    // Be sure to comment out or uncomment $stmt_update->execute();
    // for NetLog updates
    
/////////////////////////////////////////////////////
//////////////* CAREFUL THIS IS WORKING *////////////
/////////////////////////////////////////////////////
    
// Step 1: Define list of callsigns to process
$callsign_list = "KQ4FCR  KN4FIQ  WL7BDH W0za w0zb";
$callsigns = preg_split('/\s+/', trim($callsign_list));

$total = count($callsigns);
$current = 0;
$successful = 0;
$failed = 0;

echo "<h3>Processing $total callsign(s)</h3>";

// Function definitions
function getBaseCallsign($callsign) {
    return preg_replace('/([-\/]).*$/', '', $callsign);
}

function properCase($string) {
    $parts = explode("'", $string);
    $parts = array_map(function($part) {
        return ucwords(strtolower(trim($part)));
    }, $parts);
    return implode("'", $parts);
}

function getWhat3Words($lat, $lng, $api_key) {
    $url = "https://api.what3words.com/v3/convert-to-3wa";
    $params = http_build_query([
        'coordinates' => "$lat,$lng",
        'language' => 'en',
        'key' => $api_key
    ]);
    
    $full_url = $url . '?' . $params;
    
    $ch = curl_init($full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch) . "<br>";
    }
    
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON decode error: " . json_last_error_msg() . "<br>";
    }
    
    return $decoded;
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

///// Part 2 ////

// Main processing function
function processCallsign($callsign) {
    global $db_found, $config;  // Access to database and config
    
    try {
        echo "<br><hr><br>Processing callsign: " . htmlspecialchars($callsign);
        
        // Step 2-3: Get address, first, last from the FCC en
        $sql = "SELECT e1.fccid, e1.callsign, e1.first, e1.last, e1.city, e1.zip,
            CONCAT(e1.address1, '  ', e1.city, '  ', e1.state, '  ', e1.zip) as address
            FROM fcc_amateur.en e1
            JOIN (
                SELECT MAX(fccid) as max_fccid 
                FROM fcc_amateur.en 
                WHERE callsign = :callsign
            ) e2 ON e1.fccid = e2.max_fccid
            WHERE e1.callsign = :callsign
            LIMIT 1";

        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':callsign', $callsign);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            throw new Exception("No FCC record found");
        }

        // Store results
        $fccid = $result['fccid'];
        $first = $result['first'];
        $last = $result['last'];
        $address = $result['address'];
        $city = $result['city'];
        
        echo "<br>FCCID: " . htmlspecialchars($fccid);
        echo "<br>Name: " . htmlspecialchars($first) . " " . htmlspecialchars($last);
        echo "<br>Address: " . htmlspecialchars($address);

        // Step 4: Geocode address
        $koords = geocode($address);
        if(!$koords) {
            throw new Exception("Could not geocode address");
        }

        $latitude = $koords[0];
        $longitude = $koords[1];
        $county = $koords[2];
        $state = $koords[3];

        echo "<br>Coordinates: $latitude, $longitude";
        echo "<br>County: $county, State: $state";

        // Step 5: Get grid square
        $grid = gridsquare($latitude, $longitude);
        echo "<br>Grid square: $grid";

        // Get W3W
        $w3w_result = getWhat3Words($latitude, $longitude, $config['geocoder']['api_key']);
        if (!isset($w3w_result['words'])) {
            throw new Exception("Could not get W3W");
        }
        $neww3w = $w3w_result['words'];
        echo "<br>What3Words: $neww3w";

        // Create Home string
        $home = "$latitude,$longitude,$grid,$county,$state,$city,$neww3w";

        // Get district
        $district = null;
        $district_sql = "SELECT `District` FROM HPD WHERE county = :county AND state = :state LIMIT 1";
        $stmt_district = $db_found->prepare($district_sql);
        $stmt_district->bindParam(':county', $county);
        $stmt_district->bindParam(':state', $state);
        $stmt_district->execute();
        
        if ($row = $stmt_district->fetch(PDO::FETCH_ASSOC)) {
            $district = strtoupper($row['District']);
        }

        // Format variables
        $last = properCase($last);
        $city = properCase($city);
        $county = properCase($county);
        $state = strtoupper($state);
        $callsign = strtoupper($callsign);

        // Update stations table
        $update_sql = "UPDATE stations SET
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
            `country` = 'USA',
            `w3w` = :w3w,
            `dttm` = CURRENT_TIMESTAMP,
            `comment` = 'updated by fixRecordsInStations.php',
            `active_call` = 'y'
            WHERE `callsign` = :callsign";

        $stmt = $db_found->prepare($update_sql);
        $stmt->bindParam(':latitude', $latitude);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':last', $last);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':county', $county);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':grid', $grid);
        $stmt->bindParam(':home', $home);
        $stmt->bindParam(':zip', $result['zip']);
        $stmt->bindParam(':fccid', $fccid);
        $stmt->bindParam(':w3w', $neww3w);
        $stmt->bindParam(':callsign', $callsign);
        
        $stmt->execute();
        echo "<br>Successfully updated stations table";

        // NetLog Updates
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

        $stmt_netlog = $db_found->prepare($netlog_query);
        $stmt_netlog->bindValue(':basecall_pattern', $callsign . '%');
        $stmt_netlog->execute();
        
        $update_count = 0;
        while ($netlog_row = $stmt_netlog->fetch(PDO::FETCH_ASSOC)) {
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
            
            echo "<br>Ready to update NetLog record:" .
                 "<br>Callsign: " . htmlspecialchars($full_callsign) .
                 "<br>Record ID: " . htmlspecialchars($recordID) .
                 "<br>Net ID: " . htmlspecialchars($netID) .
                 "<br>New Values:" .
                 "<br>- Location: $latitude, $longitude" .
                 "<br>- Grid: $grid" .
                 "<br>- Address: $city, $county, $state" .
                 "<br>- District: " . ($district ?? 'none') . 
                 "<br>------------------------";

            // Commented execute - uncomment when ready
            //$stmt_update->execute();
            
            $update_count++;
        }
        echo "<br>Total NetLog records found for this callsign: $update_count<br>";
        
        return true;

    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

// Process each callsign
foreach ($callsigns as $callsign) {
    $current++;
    try {
        processCallsign(strtoupper(trim($callsign)));
        $successful++;
        echo "<br>Successfully processed callsign #$current: $callsign";
    } catch (Exception $e) {
        $failed++;
        echo "<br>Error processing callsign #$current ($callsign): " . htmlspecialchars($e->getMessage());
    }
    
    echo "<br>Progress: $current of $total (Success: $successful, Failed: $failed)<br>";
}

// Final summary
echo "<br><hr><br>";
echo "Completed processing $total callsign(s)<br>";
echo "Successful: $successful<br>";
echo "Failed: $failed<br>";

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
