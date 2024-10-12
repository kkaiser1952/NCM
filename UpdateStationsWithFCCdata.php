<?php
// UpdateStationsWithFCCdata.php
// Run this in the browser, it changes 100 at a time, you might have to run 
// it multiple times.
// A program to check for a change of location in the stations table based
// on the data in the FCC en table.
// If found it will up the data in stations
// Written primarily by ChatGPT on 2024-10-12
// Written: 2024-10-12

ini_set('display_errors', 1); 
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "geocode.php";     
require_once "GridSquare.php";  
require_once "config2.php";

$w3w_api_key = $config['geocoder']['api_key'];

function getW3WAddress($latitude, $longitude) {
    global $w3w_api_key;
    $url = "https://api.what3words.com/v3/convert-to-3wa?coordinates=$latitude,$longitude&key=$w3w_api_key";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    return $data['words'];  // This will give you the 3-word address
}

// Batch processing settings
$batchSize = 100; // Process 100 records at a time
$offset = 0;      // Starting point for each batch
$continueProcessing = true;

// Loop through batches
while ($continueProcessing) {
    // Initialize counters for the report
    $totalChecks = 0;
    $totalChanges = 0;
    $failedUpdates = 0;

    // Query for the current batch
    $sql = "
        SELECT st.callsign  as st_callsign,
               st.latitude  as st_latitude, 
               st.longitude as st_longitude,
               st.grid      as st_grid,
               st.county    as st_county,
               st.state     as st_state,
               st.Lname     as st_lname,
               st.Home      as st_home,
               st.fccid     as st_fccid,
               st.comment   as st_comment,
               fcc.callsign as fcc_callsign,
               fcc.address1, 
               fcc.city, 
               fcc.state, 
               fcc.zip,
               fcc.last     as fcc_lastname,
               fcc.fccid,
               CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) AS address
          FROM ncm.stations st
          JOIN fcc_amateur.en fcc ON st.callsign = fcc.callsign
         WHERE LEFT(st.callsign, 1) IN('a','k','n','w')
         LIMIT $batchSize OFFSET $offset;
    ";

    // Execute the query for the current batch
    $results = $db_found->query($sql);
    if ($results->rowCount() == 0) {
        // If no more results, stop processing
        $continueProcessing = false;
        break;
    }

    // Process each row in the current batch
    foreach($results as $row) {      
        $totalChecks++;  // Increment the check counter
        
        $fcc_callsign   = $row['fcc_callsign'];
        $st_callsign    = $row['st_callsign'];
        $state          = $row['state'];
        $address        = $row['address'];
        $fccid          = $row['fccid'];
        $zip            = $row['zip'];
        $fcc_lastname   = $row['fcc_lastname'];

        $koords = geocode("$address");
        $latitude  = $koords[0];
        $longitude = $koords[1];
        $county    = $koords[2];
        $new_state = $koords[3];

        // Check if geocode succeeded
        if (empty($latitude) || empty($longitude)) {
            echo "Geocoding failed for $st_callsign. Skipping.<br>";
            $failedUpdates++;  // Increment failure counter
            continue;
        }

        $w3w = getW3WAddress($latitude, $longitude);
        
        // Compare old vs new values
        if ($row['st_latitude'] != $latitude || $row['st_longitude'] != $longitude || 
            $row['st_county'] != $county || $row['st_state'] != $state || 
            $row['st_lname'] != $fcc_lastname) {
            
            $gridd = gridsquare($latitude, $longitude);
            $grid = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";    
            $home = "$latitude,$longitude,$grid,$county,$state,$row[city],$w3w";
            $updated = 'Updated by updateStationLocation.php on ' . date('Y-m-d H:i:s');
            
            // Perform the update using prepared statement
            $sqlUpdate = "UPDATE stations SET
                latitude  = :latitude,
                longitude = :longitude,
                grid      = :grid,
                county    = :county,
                state     = :state,
                city      = :city,           
                home      = :home,
                fccid     = :fccid,
                zip       = :zip,
                Lname     = :lname,    
                w3w       = :w3w,            
                dttm      = CURRENT_TIMESTAMP,
                comment   = :comment
              WHERE callsign = :callsign;
            ";              

            $stmt2 = $db_found->prepare($sqlUpdate);
            
            // Bind parameters
            $stmt2->bindParam(':latitude', $latitude);
            $stmt2->bindParam(':longitude', $longitude);
            $stmt2->bindParam(':grid', $grid);
            $stmt2->bindParam(':county', $county);
            $stmt2->bindParam(':state', $state);
            $stmt2->bindParam(':city', $row['city']);
            $stmt2->bindParam(':home', $home);
            $stmt2->bindParam(':fccid', $fccid);
            $stmt2->bindParam(':zip', $zip);
            $stmt2->bindParam(':lname', $fcc_lastname);
            $stmt2->bindParam(':w3w', $w3w);
            $stmt2->bindParam(':comment', $updated);
            $stmt2->bindParam(':callsign', $st_callsign);

            if ($stmt2->execute()) {
                $totalChanges++;  // Increment the changes counter if update is successful
            } else {
                $failedUpdates++;  // Increment the failed updates counter if something goes wrong
                echo "Update failed for $st_callsign.<br>";
            }
        }
    }

    // Output the report for the current batch
    echo "<h3>Batch Report (Offset: $offset)</h3>";
    echo "<p>Total checks: $totalChecks</p>";
    echo "<p>Total successful changes: $totalChanges</p>";
    echo "<p>Total failed updates: $failedUpdates</p>";

    // Increase the offset for the next batch
    $offset += $batchSize;

    // Add a delay if needed to prevent server overload
    sleep(2);  // Optional: Pause between batches to avoid server overload
}
?>
