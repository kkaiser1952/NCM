

<?php
function get_aprs_data($callsign) {
    // Construct the API URL
    $api_url = "http://api.aprs.fi/api/get?name={$callsign}&what=loc&apikey=5275.AYRjLwAFgx6ud&format=json";
    //$api_url = "http://api.aprs.fi/api/get?name=" . strtoupper($callsign) . "&what=loc&apikey=" . $api_key . "&format=json";

    
    echo "url: {$api_url} <br><br>";
    
    // Fetch the data from the API
    $json_data = file_get_contents($api_url);
    $data = json_decode($json_data, true);
    
    // Extract the required data
    $lat = $data['entries'][0]['lat'];
    $lng = $data['entries'][0]['lng'];
    $altitude = $data['entries'][0]['altitude'];
    $time = gmdate('Y-m-d H:i:s', $data['entries'][0]['time']);
    $pastime = gmdate('Y-m-d H:i:s', $data['entries'][0]['lasttime']);
    $koords = "{$lat},{$lng}";
    
    // Output the data
    echo "Latitude: {$lat}<br>";
    echo "Longitude: {$lng}<br>";
    echo "Altitude: {$altitude}<br>";
    echo "Time: {$time} UTC<br>";
    echo "Past Time: {$pastime} UTC<br>";
    echo "Koords: {$koords}<br>";
    
    // Output the entire data array for debugging purposes
    echo "Data Array:<br>";
    print_r($data);
}

get_aprs_data("KJ4NES-2");

?>
