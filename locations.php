<?php
// The idea here is; if any of these feilds is edited in NCM, some cases by a right clcik, each
// will call this function to update itself and all the other columns. A change of value on any
// of these values will have an effect on ALL of these values.
// Latitude:    This will get its value here
// Longitude:   This will get its value here 
// W3W:         This field requires a right clcik of the call-ssid to fill all the rest
// Grid:        This will get its value here
// Call_APRS:   This field requires a right clcik of the call-ssid to fill all the rest
    
// callsign must be in the form WA0TJT-8 

// When running this from netManager-p2.js, if you need to add variables just uncomment the echo statments and everything will be displayed.

function locations($aprs_callsign) {
      
    $aprs_callsign = strtoupper($aprs_callsign);
    
    echo "<br><u>For Callsign: $aprs_callsign</u><br><br>";
    echo "<u>From The APRS API, part 1</u><br>";
     
    include('config2.php');
    
    $aprs_fi_api_key = $config['aprs_fi']['api_key'];
    
    $api_url = "http://api.aprs.fi/api/get?name={$aprs_callsign}&what=loc&apikey={$aprs_fi_api_key}&format=json";
    
    echo "url: {$api_url} <br><br>";
    
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
    echo "<u>From The APRS API part 2</u><br>";
    echo "Latitude: {$lat}<br>";
    echo "Longitude: {$lng}<br>";
    echo "Altitude: {$altitude}<br>";
    echo "First Time: {$firsttime} UTC<br>";
    echo "This Time: {$thistime} UTC<br>";
    
    // Now get the crossroads data
    echo "<br><u>From The getCrossRoads()</u><br>";
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($lat, $lng);
    
    echo "{$crossroads}<br>";
    
    // Now get the gridsquare
    include('GetGridSquare.php');
    echo "<br><u>From GetGridSquare.php</u>";
    $yqth = getgridsquare($lat, $lng);
    echo "<br>Grid Square: {$yqth}<br>";
    
    // Output the entire data array for debugging purposes
    echo "<br><u>The Data Array From The APRS.fi API:</u><br>";
    print_r($data);
    
    // Now lets add the what3words words from the W3W geocoder
    $w3w_api_key = $config['geocoder']['api_key'];
    
    require_once('Geocoder.php');
  //  use What3words\Geocoder\Geocoder;
    
    $lat = (float) $data['entries'][0]['lat'];
    $lng = (float) $data['entries'][0]['lng'];
    
    echo ('<br><br>lat '.$lat.', lng '.$lng.'<br>');
    
    $api = new What3words\Geocoder\Geocoder($w3w_api_key);
       
    $result = $api->convertTo3wa($lat, $lng);
    echo "<br><br><u>The Geocoder Array by What3Words</u><br>";
    echo "<br><br><u>W3W Array:</u><br>";
    print_r($result);
    
    echo "<br>";
    
    $southwest_lat = $result['square']['southwest']['lat'];
    $southwest_lng = $result['square']['southwest']['lng'];
    $northeast_lat = $result['square']['northeast']['lat'];
    $northeast_lng = $result['square']['northeast']['lng'];
    $words = $result['words'];
    $language = $result['language'];
    $map = $result['map'];
    $place = $result['nearestPlace'];
    
    echo "<br><u>From Geocoder by What3Words</u><br>";
    echo "Words: {$words}<br>";
    echo "Map: {$map}<br>";
    echo "Nearest Place: {$place}<br>";
        
}

//Examples:
//locations("wa0tjt-1");

 // Capture the output of echo statements into a variable
//$output = ob_get_contents();
//ob_end_clean();

// Return the output as the result of the script
//echo $output;


?>
