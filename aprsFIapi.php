<?php
    
function get_aprs_data($callsign, $aprs_fi_api_key) {
    
    $callsign = strtoupper($callsign);
    
    include('config2.php');
    
    $aprs_fi_api_key = $config['aprs_fi']['api_key'];
    
    $api_url = "http://api.aprs.fi/api/get?name={$callsign}&what=loc&apikey={$aprs_fi_api_key}&format=json";
    
    //echo "url: {$api_url} <br><br>";
    
    // Fetch the data from the API
    $json_data = file_get_contents($api_url);
    $data = json_decode($json_data, true);
    
    // Extract the required data
    $lat = $data['entries'][0]['lat'];
    $lng = $data['entries'][0]['lng'];
    $altitude = $data['entries'][0]['altitude'];
    $firsttime = gmdate('Y-m-d H:i:s', $data['entries'][0]['time']);
    $thistime = gmdate('Y-m-d H:i:s', $data['entries'][0]['lasttime']);
    //$koords = "{$lat}, {$lng}";
    
   
    
    // Output the data
    echo "Latitude: {$lat}<br>";
    echo "Longitude: {$lng}<br>";
    echo "Altitude: {$altitude}<br>";
    echo "First Time: {$firsttime} UTC<br>";
    echo "This Time: {$thistime} UTC<br>";
    //echo "Koords: {$koords}<br>";
    
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($lat, $lng);

    echo "Crossroads: {$crossroads}<br><br>";
    
    
    // Output the entire data array for debugging purposes
    echo "Data Array:<br>";
    print_r($data);
}

get_aprs_data("wa0tjt-5");

?>
