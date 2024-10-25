<?php
/* getCountyAndStateFromFCC.php */
/* Written: 2024-10-24
   Updated: 2024-10-25
*/

// Define log file path globally
$logFile = '/var/www/NCM/logs/test_log.txt';

echo "In getCountyAndStateFromFCC <br><br>";

function getCountyAndStateFromFCC($latitude, $longitude) {
    global $logFile;
    
    // Log function start with parameters
    error_log(date('Y-m-d H:i:s') . " - Starting getCountyAndStateFromFCC with lat: $latitude, lon: $longitude\n", 3, $logFile);
    
    // FCC Block API URL
    $fccApiUrl = "https://geo.fcc.gov/api/census/block/find";
    // Parameters for the API call
    $params = [
        'format' => 'json',
        'latitude' => $latitude,
        'longitude' => $longitude,
        'showall' => 'true'
    ];
    
    // Build the query string
    $queryString = http_build_query($params);
    // Full API URL with query string
    $apiUrlWithParams = $fccApiUrl . '?' . $queryString;
    
    // Log the generated URL
    error_log(date('Y-m-d H:i:s') . " - API URL: $apiUrlWithParams\n", 3, $logFile);
    
    // Initialize cURL
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiUrlWithParams);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // Set the User-Agent
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
        'Accept-Encoding: gzip'
    ]);
    
    // Execute the request
    $response = curl_exec($ch);
    
    // Check for cURL errors
    if ($response === false) {
        $error = curl_error($ch);
        error_log(date('Y-m-d H:i:s') . " - cURL Error: $error\n", 3, $logFile);
        curl_close($ch);
        return "Error: " . $error;
    }
    
    // Get HTTP status code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    error_log(date('Y-m-d H:i:s') . " - HTTP Status Code: $httpCode\n", 3, $logFile);
    
    // Close cURL resource
    curl_close($ch);
    
    // Handle gzip encoded responses
    if (isset($response[0]) && ord($response[0]) == 0x1f && ord($response[1]) == 0x8b) {
        error_log(date('Y-m-d H:i:s') . " - Decompressing gzip response\n", 3, $logFile);
        $response = gzdecode($response);
    }
    
    // Log raw response length
    error_log(date('Y-m-d H:i:s') . " - Response length: " . strlen($response) . " bytes\n", 3, $logFile);
    
    // Decode the JSON response
    $data = json_decode($response, true);
    
    // Check for JSON decode errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        $jsonError = json_last_error_msg();
        error_log(date('Y-m-d H:i:s') . " - JSON Decode Error: $jsonError\n", 3, $logFile);
        return "Error: Invalid JSON response - $jsonError";
    }
    
    // Check if the response contains valid county and state data
    if (isset($data['County']['name']) && isset($data['State']['code'])) {
        $county = $data['County']['name'];
        $state = $data['State']['code'];
        
        // Log successful retrieval
        error_log(date('Y-m-d H:i:s') . " - Successfully retrieved County: $county, State: $state\n", 3, $logFile);
        
        return [
            'county' => $county,
            'state' => $state
        ];
    } else {
        error_log(date('Y-m-d H:i:s') . " - Error: Could not retrieve county or state from response\n", 3, $logFile);
        return "Error: Could not retrieve county or state.";
    }
} // End getCountyAndStateFromFCC()

// Example usage:
$latitude = 39.202;
$longitude = -94.602;

// Log the start of the script
error_log(date('Y-m-d H:i:s') . " - Starting FCC location lookup script\n", 3, $logFile);

$result = getCountyAndStateFromFCC($latitude, $longitude);

if (is_array($result)) {
    $message = "County: " . $result['county'] . ", State: " . $result['state'];
    echo $message;
    error_log(date('Y-m-d H:i:s') . " - Success: $message\n", 3, $logFile);
} else {
    echo $result;
    error_log(date('Y-m-d H:i:s') . " - Error in main script: $result\n", 3, $logFile);
}

// Log the end of the script
error_log(date('Y-m-d H:i:s') . " - FCC location lookup script completed\n", 3, $logFile);
?>