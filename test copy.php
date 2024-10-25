<?php
/* getCountyFromCoords.php */
/* Uses Census Bureau API to get county name from coordinates */

if (!defined('LOG_FILE')) {
    define('LOG_FILE', '/var/www/NCM/logs/test_log.txt');
}

function getCountyFromCoords($latitude, $longitude) {
    error_log(date('Y-m-d H:i:s') . " - Starting getCountyFromCoords with lat: $latitude, lon: $longitude\n", 3, LOG_FILE);
    
    // Census Bureau Geocoder URL
    $apiUrl = "https://geocoding.geo.census.gov/geocoder/geographies/coordinates";
    $params = [
        'x' => $longitude,
        'y' => $latitude,
        'benchmark' => 'Public_AR_Current',
        'vintage' => 'Current_Current',
        'format' => 'json'
    ];
    
    $queryString = http_build_query($params);
    $apiUrlWithParams = $apiUrl . '?' . $queryString;
    
    error_log(date('Y-m-d H:i:s') . " - API URL: $apiUrlWithParams\n", 3, LOG_FILE);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrlWithParams);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        $error = curl_error($ch);
        error_log(date('Y-m-d H:i:s') . " - cURL Error: $error\n", 3, LOG_FILE);
        curl_close($ch);
        return "Error: " . $error;
    }
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    error_log(date('Y-m-d H:i:s') . " - HTTP Status Code: $httpCode\n", 3, LOG_FILE);
    
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log(date('Y-m-d H:i:s') . " - JSON Decode Error: " . json_last_error_msg() . "\n", 3, LOG_FILE);
        return "Error: Invalid JSON response";
    }
    
    if (isset($data['result']['geographies']['Counties'][0]['NAME'])) {
        $county = $data['result']['geographies']['Counties'][0]['NAME'];
        $state = $data['result']['geographies']['States'][0]['NAME'];
        
        error_log(date('Y-m-d H:i:s') . " - Successfully retrieved County: $county, State: $state\n", 3, LOG_FILE);
        
        return [
            'county' => $county,
            'state' => $state
        ];
    } else {
        error_log(date('Y-m-d H:i:s') . " - Error: Could not find county in response\n", 3, LOG_FILE);
        error_log(date('Y-m-d H:i:s') . " - Response: " . print_r($data, true) . "\n", 3, LOG_FILE);
        return "Error: Could not retrieve county data";
    }
}

// Only run this if the file is called directly (not included)
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    echo "In getCountyFromCoords <br><br>";
    
    // Example usage when run directly
    $latitude = 39.202;
    $longitude = -94.602;
    
    error_log(date('Y-m-d H:i:s') . " - Starting county lookup script\n", 3, LOG_FILE);
    
    $result = getCountyFromCoords($latitude, $longitude);
    
    if (is_array($result)) {
        $message = "County: " . $result['county'] . ", State: " . $result['state'];
        echo $message;
        error_log(date('Y-m-d H:i:s') . " - Success: $message\n", 3, LOG_FILE);
    } else {
        echo $result;
        error_log(date('Y-m-d H:i:s') . " - Error in main script: $result\n", 3, LOG_FILE);
    }
    
    error_log(date('Y-m-d H:i:s') . " - County lookup script completed\n", 3, LOG_FILE);
}
?>