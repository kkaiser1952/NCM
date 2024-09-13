<?php
// w3w_functions.php
// Written: 2024-09-13
// Updated: 2024-09-13

function getCoordinatesFromW3W($w3w) {
    global $config;
    
    require_once "config2.php";
    
    if (!isset($config['geocoder']['api_key'])) {
        throw new Exception("What3Words API key is not set in the configuration.");
    }
    
    $w3w_api_key = $config['geocoder']['api_key'];
    $url = "https://api.what3words.com/v3/convert-to-coordinates?words=" . urlencode($w3w) . "&key=" . $w3w_api_key;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("cURL Error: " . $error);
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        throw new Exception("What3Words API request failed with status code: " . $httpCode);
    }
    
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Failed to parse JSON response from What3Words API");
    }
    
    if (!isset($data['coordinates']) || !isset($data['coordinates']['lat']) || !isset($data['coordinates']['lng'])) {
        throw new Exception("Invalid response from What3Words API: Coordinates not found");
    }
    
    return array($data['coordinates']['lat'], $data['coordinates']['lng']);
}
?>