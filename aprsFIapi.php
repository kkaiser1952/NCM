<?php

// Set the API endpoint and parameters
$url = 'http://api.aprs.fi/api/get';
$params = array(
    'name' => 'WA0TJT-1',
    'what' => 'loc',
    'apikey' => '5275.AYRjLwAFgx6ud',
    'format' => 'json'
);
$query_string = http_build_query($params);
$request_url = $url . '?' . $query_string;

// Create a new cURL handle
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if(curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

// Close the cURL handle
curl_close($ch);

// Parse the JSON response
$data = json_decode($response, true);

// Output the latitude and longitude data
$lat = $data['entries'][0]['lat'];
$lng = $data['entries'][0]['lng'];
echo "Latitude: $lat, Longitude: $lng";

?>
