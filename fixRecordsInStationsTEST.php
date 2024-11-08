<?php
    // fixRecordsInStationsTEST.php
    // Written: 2024-11-05
    // This program updates records based on callsigns
    // Updates stations: lat/lng, Lname, grid, county, state, city, district, Home, dttm, comment, etc
    // Updates netLog: lat/lng, grid, county, state, city, district, comment
    
/////////////////////////////////////////////////////
//////////////* CAREFUL THIS IS WORKING *////////////
/////////////////////////////////////////////////////
    
// Error checking/reporting    
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function Declarations
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
        echo '<br>Curl error: ' . curl_error($ch) . "<br>";
    }
    
    curl_close($ch);
    return json_decode($response, true);
}

// Path settings and imports
require_once "dbConnectDtls.php";
require_once "config2.php";
require_once "GridSquare.php";
require_once "getCrossRoads.php";
require_once "geocode.php";

// Callsign list to process
$callsign_list = "KQ4FCR  KN4FIQ  WL7BDH";

// start part 2 //

function processCallsign($callsign, $db_found, $config) {
    echo "<br>Step 1: Processing callsign: " . htmlspecialchars($callsign) . "<br>";
    
    try {
        // Step 2: Get FCC Data
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

        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':callsign', $callsign);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            throw new Exception("No FCC record found for " . htmlspecialchars($callsign));
        }

        // Store FCC results
        $fccid = $result['fccid'];
        $first = $result['first'];
        $last = $result['last'];
        $address = $result['address'];
        $city = $result['city'];
        $zip = $result['zip'];
        
        echo "<br>Found FCC Record:<br>";
        echo "FCCID: " . htmlspecialchars($fccid) . "<br>";
        echo "Name: " . htmlspecialchars($first) . " " . htmlspecialchars($last) . "<br>";
        echo "Address: " . htmlspecialchars($address) . "<br>";

        // Step 3: Geocode Address
        $koords = geocode($address);
        if(!$koords) {
            throw new Exception("Could not geocode address for " . htmlspecialchars($callsign));
        }

        $latitude = $koords[0];
        $longitude = $koords[1];
        $county = $koords[2];
        $state = $koords[3];

        echo "<br>Location: $latitude, $longitude<br>";
        echo "County: $county, State: $state<br>";

        // Step 4: Calculate Grid Square
        $grid = gridsquare($latitude, $longitude);
        if (!$grid) {
            throw new Exception("Could not calculate grid square");
        }
        echo "<br>Grid Square: $grid<br>";

        // Step 5: Get What3Words
        $w3w_result = getWhat3Words($latitude, $longitude, $config['geocoder']['api_key']);
        if (!isset($w3w_result['words'])) {
            throw new Exception("Could not get What3Words for location");
        }
        $neww3w = $w3w_result['words'];
        echo "<br>What3Words: $neww3w<br>";

        // Step 6: Get District
        $district = null;
        $district_sql = "SELECT `District` FROM HPD WHERE county = :county AND state = :state LIMIT 1";
        $stmt_district = $db_found->prepare($district_sql);
        $stmt_district->bindParam(':county', $county);
        $stmt_district->bindParam(':state', $state);
        $stmt_district->execute();
        
        if ($row = $stmt_district->fetch(PDO::FETCH_ASSOC)) {
            $district = strtoupper($row['District']);
        }

        // Step 7: Format Variables
        $last = properCase($last);
        $city = properCase($city);
        $county = properCase($county);
        $state = strtoupper($state);
        $callsign = strtoupper($callsign);
        $home = "$latitude,$longitude,$grid,$county,$state,$city,$neww3w";

        // Step 8: Update Stations Table
        $update_sql = "UPDATE stations SET
            `latitude` = :latitude, `longitude` = :longitude,
            `Lname` = :last, `city` = :city,
            `county` = :county, `state` = :state,
            `District` = :district, `grid` = :grid,
            `home` = :home, `zip` = :zip,
            `fccid` = :fccid, `country` = 'USA',
            `w3w` = :w3w, `dttm` = CURRENT_TIMESTAMP,
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
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':fccid', $fccid);
        $stmt->bindParam(':w3w', $neww3w);
        $stmt->bindParam(':callsign', $callsign);
        
        $stmt->execute();
        echo "<br>Stations table updated successfully<br>";

        // Step 9: Update NetLog Records
        $netlog_query = "SELECT n1.recordID, n1.callsign, n1.netID
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
            
            echo "<br>Found NetLog record to update: $full_callsign (ID: $recordID, Net: $netID)<br>";
            
            $netlog_update = "UPDATE NetLog SET
                `latitude` = :latitude, `longitude` = :longitude,
                `city` = :city, `county` = :county,
                `state` = :state, `District` = :district,
                `grid` = :grid, `dttm` = CURRENT_TIMESTAMP,
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
            
            // $stmt_update->execute();  // Commented as requested
            $update_count++;
        }
        
        echo "<br>Total NetLog records found: $update_count<br>";
        return true;

    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

// Start part 3 //

// Step 1: Define list of callsigns to process

echo "<h3>Beginning processing of $total callsigns</h3>";

// Process each callsign
foreach ($callsigns as $current => $callsign) {
    echo "\n<hr><h3>Processing callsign " . ($current + 1) . " of $total: " . strtoupper($callsign) . "</h3>\n";
    
    try {
        $success = processCallsign($callsign, $db_found, $config);
        if ($success) {
            $successful++;
            echo "<br><strong>✓ Successfully processed: $callsign</strong><br>";
        }
    } catch (Exception $e) {
        $failed++;
        echo "<br><strong>✗ Error processing $callsign: " . htmlspecialchars($e->getMessage()) . "</strong><br>";
    }
    
    // Show progress
    echo "<br>Current Progress:<br>";
    echo "- Processed: " . ($current + 1) . " of $total<br>";
    echo "- Successful: $successful<br>";
    echo "- Failed: $failed<br>";
}

// Final summary
echo "<hr><h3>Processing Complete</h3>";
echo "Total callsigns processed: $total<br>";
echo "✓ Successful: $successful<br>";
echo "✗ Failed: $failed<br>";

if ($failed > 0) {
    echo "<br><strong>Note:</strong> Some callsigns failed processing. Please review the errors above.";
}

?>

<?php
/*
========================================================================
PROGRAM SUMMARY: fixRecordsInStations.php
========================================================================
[Your existing documentation here]
========================================================================
*/
?>

?>