<?php

function getCountyAndStateFromFCC($latitude, $longitude) {
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

    // Output the full URL for debugging
    echo "Generated URL: " . $apiUrlWithParams . "<br>";

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiUrlWithParams);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Set the User-Agent to mimic a browser request
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
        'Accept-Encoding: gzip' // Ensure gzip is supported
    ]);

    // Execute the request
    $response = curl_exec($ch);

    // Check for cURL errors
    if ($response === false) {
        return "Error: " . curl_error($ch);
    }

    // Close cURL resource
    curl_close($ch);

    // Handle gzip encoded responses
    if (isset($response[0]) && ord($response[0]) == 0x1f && ord($response[1]) == 0x8b) {
        // Decompress the gzip response
        $response = gzdecode($response);
    }

    // Output the raw response for debugging
    echo "Raw API Response: " . $response . "<br>";

    // Decode the JSON response
    $data = json_decode($response, true);

    // Output the decoded response for debugging
    echo "Decoded Response: <pre>" . print_r($data, true) . "</pre><br>";

    // Check if the response contains valid county and state data
    if (isset($data['County']['name']) && isset($data['State']['code'])) {
        // Extract county and state
        $county = $data['County']['name'];
        $state = $data['State']['code'];

        // Return an associative array with county and state
        return [
            'county' => $county,
            'state' => $state
        ];
    } else {
        return "Error: Could not retrieve county or state.";
    }
}

// Example usage:
$latitude = 39.202;
$longitude = -94.602;

$result = getCountyAndStateFromFCC($latitude, $longitude);

if (is_array($result)) {
    echo "County: " . $result['county'] . ", State: " . $result['state'];
} else {
    echo $result;
}

?>
