<?php
// UpdateStationsWithFCCdata.php
// Run this in the browser, it changes 100 at a time, you might have to run 
// it multiple times.
// A program to check for a change of location in the stations table based
// on the data in the FCC en table.
// If found it will up the data in stations
// Written primary by ChatGPT on 2024-10-12
// Written: 2024-10-12

    ini_set('display_errors', 1); 
    error_reporting(E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "geocode.php";     
    require_once "GridSquare.php";  
    require_once "config2.php";
    
    $batchSize = 10;  // Set the batch size (adjust as needed)
    $offset = 0;       // Start at offset 0

    $w3w_api_key = $config['geocoder']['api_key'];

    function getW3WAddress($latitude, $longitude) {
        global $w3w_api_key;
        $url = "https://api.what3words.com/v3/convert-to-3wa?coordinates=$latitude,$longitude&key=$w3w_api_key";
        
        $context = stream_context_create(['http' => ['timeout' => 5]]);  // 5-second timeout
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            throw new Exception("Failed to connect to What3Words API.");
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['words'])) {
            throw new Exception("Failed to retrieve W3W address or parse JSON.");
        }
        
        return $data['words'];
    }
    
    // Loop through stations in manageable batches
    $sql = "
    SELECT st.callsign  as st_callsign,
           st.latitude  as st_latitude, 
           st.longitude as st_longitude,
           st.grid      as st_grid,
           st.county    as st_county,
           st.state     as st_state,
           st.Lname     as st_Lname,     -- Lname from stations
           st.Home      as st_home,
           st.fccid     as st_fccid,
           st.comment   as st_comment,
           fcc.callsign as fcc_callsign,
           fcc.address1, 
           fcc.city, 
           fcc.state, 
           fcc.zip,
           fcc.fccid,
           fcc.last     as fcc_last,     -- Last name from fcc
           CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) AS address
      FROM ncm.stations st
      JOIN fcc_amateur.en fcc ON st.callsign = fcc.callsign
     WHERE LEFT(st.callsign, 1) IN('a','k','n','w');
"; 

foreach($db_found->query($sql) as $row) {
    // (Your existing geocode and W3W logic)
    
    // Check for last name changes
    if ($row['st_Lname'] != $row['fcc_last']) {
        $new_Lname = $row['fcc_last'];
    } else {
        $new_Lname = $row['st_Lname'];
    }
    
    // Compare old vs new values for latitude, longitude, county, state, and last name
    if ($row['st_latitude'] != $latitude || $row['st_longitude'] != $longitude || 
        $row['st_county'] != $county || $row['st_state'] != $state || 
        $row['st_Lname'] != $new_Lname) {
        
        $gridd = gridsquare($latitude, $longitude);
        $grid = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";    
        $home = "$latitude,$longitude,$grid,$county,$state,$city,$w3w";
        $updated = 'Updated by updateStationLocation.php on ' . NOW();
        
        // Update query including Lname
        $sqlUpdate = "UPDATE stations SET
            latitude  = '$latitude',
            longitude = '$longitude',
            grid      = '$grid',
            county    = '$county',
            state     = '$state',
            city      = '$city',
            Lname     = '$new_Lname',    // Update Lname if changed
            home      = '$home',
            fccid     = '$fccid',
            zip       = '$zip',
            w3w       = '$w3w',
            dttm      = CURRENT_TIMESTAMP,
            comment   = '$updated'
          WHERE callsign = '$st_callsign';
        ";              
        
        $stmt2 = $db_found->prepare($sqlUpdate);
        //$stmt2->execute();  // Uncomment to execute update
        
        echo "$sqlUpdate";  // For testing
    }
}      
?>