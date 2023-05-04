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
    
    // $firsttime is the value of time in the returned array. It is the last time heard
    // $thistime is the value of lasttime in the array. It is the most current time heard
    $firsttime = gmdate('Y-m-d H:i:s', $data['entries'][0]['time']);
    $thistime = gmdate('Y-m-d H:i:s', $data['entries'][0]['lasttime']);
    
    // Output the aprs supplied data
    echo "Latitude: {$lat}<br>";
    echo "Longitude: {$lng}<br>";
    echo "Altitude: {$altitude}<br>";
    echo "First Time: {$firsttime} UTC<br>";
    echo "This Time: {$thistime} UTC<br>";
    //echo "Koords: {$koords}<br>";
    
    // Now get the crossroads data
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($lat, $lng);
    echo "{$crossroads}<br>";
    
    // Now get the gridsquare
    include('GetGridSquare.php');
    $yqth = getgridsquare($lat, $lng);
    echo "Grid Square {$yqth}<br><br>";
    
    // Output the entire data array for debugging purposes
    echo "<br><br>Data Array:<br>";
    print_r($data);
    
    // Now lets add the what3words words from the W3W geocoder
    require_once('/path/to/w3w-php-wrapper/src/Geocoder.php');

    $w3w_api_key = $config['geocoder']['api_key'];
    $geocoder = new \What3words\Geocoder\Geocoder($config['geocoder']['w3w_api_key']);
   // $language = 'EN';
   // $format = 'json';
    
    $result = $geocoder->convertTo3wa($lat, $lng, $language, $format);
    echo ("$result");
    print_r($result);
 
}

get_aprs_data("wa0tjt-1");

?>
