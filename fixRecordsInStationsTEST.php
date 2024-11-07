<?php
    // fixRecordsInStations.php
    // Written: 2024-11-05
    // This program updates records based on callsigns
    // Updates stations: lat/lng, Lname, grid, county, state, city, district, Home, dttm, comment, etc
    // Updates netLog: lat/lng, grid, county, state, city, district, comment
    
/////////////////////////////////////////////////////
//////////////* CAREFUL THIS IS WORKING *////////////
/////////////////////////////////////////////////////
    
// Error checking/reporting    
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function Declarations
function getBaseCallsign($callsign) {
    return preg_replace('/([-\/]).*$/', '', $callsign);
}

function properCase($string) {
    $parts = explode("'", $string);
    $parts = array_map(function($part) {
        return ucwords(strtolower(trim($part)));
    }, $parts);
    return implode("'", $parts);
}

function getWhat3Words($lat, $lng, $api_key) {
    $url = "https://api.what3words.com/v3/convert-to-3wa";
    $params = http_build_query([
        'coordinates' => "$lat,$lng",
        'language' => 'en',
        'key' => $api_key
    ]);
    
    $full_url = $url . '?' . $params;
    $ch = curl_init($full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo '<br>Curl error: ' . curl_error($ch) . "<br>";
    }
    
    curl_close($ch);
    return json_decode($response, true);
}

// Path settings and imports
require_once "dbConnectDtls.php";
require_once "config2.php";
require_once "GridSquare.php";
require_once "getCrossRoads.php";
require_once "geocode.php";



?>