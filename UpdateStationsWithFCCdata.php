<?php
// UpdateStationsWithFCCdata.php
// Run this in the browser, it changes 100 at a time, you might have to run 
// it multiple times.
// A program to check for a change of location in the stations table based
// on the data in the FCC en table.
// If found it will up the data in stations
// Written primarily by ChatGPT on 2024-10-12
// Written: 2024-10-12


// UpdateStationsWithFCCdata.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Script started.<br>";
error_log("Script started.<br>");

// Check if required files exist
$requiredFiles = ["dbConnectDtls.php", "geocode.php", "GridSquare.php", "config2.php"];
foreach ($requiredFiles as $file) {
    if (!file_exists($file)) {
        die("Error: Required file $file not found.<br>");
    }
}

require_once "dbConnectDtls.php";
require_once "geocode.php";
require_once "GridSquare.php";
require_once "config2.php";

echo "All required files loaded successfully.<br>";

$w3w_api_key = $config['geocoder']['api_key'] ?? null;
if (!$w3w_api_key) {
    die("Error: What3Words API key not found in config.<br>");
}

echo "What3Words API key loaded.<br>";

function getW3WAddress($latitude, $longitude) {
    global $w3w_api_key;
    $url = "https://api.what3words.com/v3/convert-to-3wa?coordinates=$latitude,$longitude&key=$w3w_api_key";
    $response = file_get_contents($url);
    if ($response === false) {
        echo "Error: Unable to connect to What3Words API.<br>";
        return null;
    }
    $data = json_decode($response, true);
    return $data['words'] ?? null;
}

// Batch processing settings
$batchSize = 100;
$offset = 0;
$continueProcessing = true;

echo "Preparing database statements...<br>";

// Prepare statements outside the loop
try {
    $stmt = $db_found->prepare("
        SELECT st.callsign as st_callsign, st.latitude as st_latitude, 
               st.longitude as st_longitude, st.grid as st_grid,
               st.county as st_county, st.state as st_state,
               st.Lname as st_lname, st.Home as st_home,
               st.fccid as st_fccid, st.comment as st_comment,
               fcc.callsign as fcc_callsign, fcc.address1, 
               fcc.city, fcc.state, fcc.zip,
               fcc.last as fcc_lastname, fcc.fccid,
               CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) AS address
        FROM ncm.stations st
        JOIN fcc_amateur.en fcc ON st.callsign = fcc.callsign
        WHERE LEFT(st.callsign, 1) IN ('a','k','n','w')
        LIMIT :limit OFFSET :offset
    ");

    $updateStmt = $db_found->prepare("
        UPDATE stations SET
        latitude = :latitude, longitude = :longitude,
        grid = :grid, county = :county, state = :state,
        city = :city, home = :home, fccid = :fccid,
        zip = :zip, Lname = :lname, w3w = :w3w,
        dttm = CURRENT_TIMESTAMP, comment = :comment
        WHERE callsign = :callsign
    ");

    echo "Database statements prepared successfully.<br>";
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage() . "<br>");
}

echo "Starting main processing loop...<br>";

while ($continueProcessing) {
    $totalChecks = 0;
    $totalChanges = 0;
    $failedUpdates = 0;

    $stmt->bindParam(':limit', $batchSize, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Database query error: " . $e->getMessage() . "<br>";
        break;
    }

    if (empty($results)) {
        echo "No more results to process.<br>";
        $continueProcessing = false;
        break;
    }

    echo "Processing batch of " . count($results) . " records...<br>";

    foreach ($results as $row) {
        $totalChecks++;

        $koords = geocode($row['address']);
        if (empty($koords[0]) || empty($koords[1])) {
            echo "Geocoding failed for {$row['st_callsign']}.<br>";
            $failedUpdates++;
            continue;
        }

        $latitude = $koords[0];
        $longitude = $koords[1];
        $county = $koords[2];
        $new_state = $koords[3];

        if ($row['st_latitude'] != $latitude || $row['st_longitude'] != $longitude || 
            $row['st_county'] != $county || $row['st_state'] != $new_state || 
            $row['st_lname'] != $row['fcc_lastname']) {

            $w3w = getW3WAddress($latitude, $longitude);
            $gridd = gridsquare($latitude, $longitude);
            $grid = implode('', array_slice($gridd, 0, 6));
            $home = "$latitude,$longitude,$grid,$county,{$row['state']},{$row['city']},$w3w";
            $updated = 'Updated by updateStationLocation.php on ' . date('Y-m-d H:i:s');

            try {
                $updateStmt->execute([
                    ':latitude' => $latitude,
                    ':longitude' => $longitude,
                    ':grid' => $grid,
                    ':county' => $county,
                    ':state' => $row['state'],
                    ':city' => $row['city'],
                    ':home' => $home,
                    ':fccid' => $row['fccid'],
                    ':zip' => $row['zip'],
                    ':lname' => $row['fcc_lastname'],
                    ':w3w' => $w3w,
                    ':comment' => $updated,
                    ':callsign' => $row['st_callsign']
                ]);

                $totalChanges++;
            } catch (PDOException $e) {
                echo "Update failed for {$row['st_callsign']}: " . $e->getMessage() . "<br>";
                $failedUpdates++;
            }
        }
    }

    echo "<h3>Batch Report (Offset: $offset)</h3>";
    echo "<p>Total checks: $totalChecks</p>";
    echo "<p>Total successful changes: $totalChanges</p>";
    echo "<p>Total failed updates: $failedUpdates</p>";

    $offset += $batchSize;
    
    // Flush output buffer to show progress
    ob_flush();
    flush();
}

echo "Script completed.<br>";
?>
