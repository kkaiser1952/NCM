<?php
	//Written: 2024-03-13
	// API to get the city, state, and county from latitude and longitude
require_once "config.php";


function reverseGeocode($lat, $lng, $apiKey) {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if(isset($data['results']) && !empty($data['results'])) {
        $addressComponents = $data['results'][0]['address_components'];
        $state = $county = $city = null;

        foreach ($addressComponents as $component) {
            if (in_array('administrative_area_level_1', $component['types'])) {
                $state = $component['short_name'];
            }
            if (in_array('administrative_area_level_2', $component['types'])) {
                $county = str_replace(' County', '', $component['long_name']);
            }
            if (in_array('locality', $component['types'])) {
                $city = $component['long_name'];
            }
        }
        
        return [$state, $county, $city];
    }

    return [null, null, null];
}

// Example usage:
/*
$latitude = 39.2028965;
$longitude = -94.602876;
$apiKey = 'YOUR_API_KEY';

list($state, $county, $city) = reverseGeocode($latitude, $longitude, $_GOOGLE_MAPS_API_KEY);
echo "State: {$state}<br>";
echo "County: {$county}<br>";
echo "City: {$city}<br>";
*/
?>