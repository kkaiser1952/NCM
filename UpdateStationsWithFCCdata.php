<?php
    ini_set('display_errors', 1); 
    error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "geocode.php";     
    require_once "GridSquare.php";  
    require_once "config2.php";
    
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
    
    // Loop through all stations that require location update
    $sql = "
        SELECT st.callsign  as st_callsign,
               st.latitude  as st_latitude, 
               st.longitude as st_longitude,
               st.grid      as st_grid,
               st.county    as st_county,
               st.state     as st_state,
               st.Home      as st_home,
               st.fccid     as st_fccid,
               st.comment   as st_comment,
               fcc.callsign as fcc_callsign,
               fcc.address1, 
               fcc.city, 
               fcc.state, 
               fcc.zip,
               fcc.fccid,
               CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) AS address
          FROM ncm.stations st
          JOIN fcc_amateur.en fcc ON st.callsign = fcc.callsign
         WHERE LEFT(st.callsign, 1) IN('a','k','n','w');
    ";           

    foreach ($db_found->query($sql) as $row) {      
        $st_callsign = $row['st_callsign'];
        $address = $row['address'];
        $city = $row['city'];
        
        $koords = geocode($address);
        $latitude = $koords[0];
        $longitude = $koords[1];
        $county = $koords[2];
        $state = $koords[3];
        
        if (empty($latitude) || empty($longitude)) {
            echo "Geocoding failed for $st_callsign. Skipping.";
            continue;
        }
        
        $w3w = getW3WAddress($latitude, $longitude);
        
        if ($row['st_latitude'] != $latitude || $row['st_longitude'] != $longitude || 
            $row['st_county'] != $county || $row['st_state'] != $state) {
            
            $gridd = gridsquare($latitude, $longitude);
            $grid = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";
            $home = "$latitude,$longitude,$grid,$county,$state,$city,$w3w";
            $updated = 'Updated by updateStationLocation.php on ' . date('Y-m-d H:i:s');
            
            // Construct the SQL UPDATE statement, but don't execute it yet
            $sqlUpdate = "UPDATE stations SET
                latitude  = '$latitude',
                longitude = '$longitude',
                grid      = '$grid',
                county    = '$county',
                state     = '$state',
                city      = '$city',
                home      = '$home',
                fccid     = '$row[fccid]',
                zip       = '$row[zip]',
                w3w       = '$w3w',
                dttm      = CURRENT_TIMESTAMP,
                comment   = '$updated'
              WHERE callsign = '$st_callsign';
            ";              
              
            // Instead of executing, just echo the SQL update statement
            echo "$sqlUpdate\n";  // Add a newline for clarity between queries
        }
    }
?>
