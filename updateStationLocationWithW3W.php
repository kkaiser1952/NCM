<?php 
/* updateStationLocationWithW3W.php
/* This program uses the W3W address to calculate lat/lon, grid, county, state etc. and update the stations table */
/* REQUIRED: a callsign and the What3Words address */
/* Written: 2021-10-15 */
/* Updated: 2024-10-24 */
    
// Set up logging
$logFile = '/var/www/NCM/logs/test_log.txt';

// Make sure the directory exists
$logDir = dirname($logFile);
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}    

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 'On');
ini_set('error_log', $logFile);

// Function to log messages - with error checking
function logMessage($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "$timestamp - $message" . PHP_EOL;
    
    // Try to write to log file, if fails, output to screen
    if (@error_log($logEntry, 3, $logFile) === false) {
        echo "<strong>Log Error</strong>: $logEntry<br>";
    }
}

// Output errors in a formatted way
function outputError($message, $file = '', $line = '') {
    $errorMsg = "<div style='color: red; margin: 5px; padding: 5px; border: 1px solid red;'>";
    $errorMsg .= "<strong>Error:</strong> $message";
    if ($file && $line) {
        $errorMsg .= " in <strong>$file</strong> on line <strong>$line</strong>";
    }
    $errorMsg .= "</div>";
    echo $errorMsg;
    logMessage("ERROR: $message" . ($file && $line ? " in $file on line $line" : ""));
}

echo "<html><head><title>Station Location Update</title></head><body>";

try {
    logMessage("Script started.");

    // Include required files
    require_once "dbConnectDtls.php";
    require_once "GridSquare.php";
    require_once "geocode.php";
    require_once "config.php";
        
    // Setup for what3words
    require_once "Geocoder.php";
    use What3words\Geocoder\Geocoder;
    use What3words\Geocoder\AutoSuggestOption;
    $api = new Geocoder("5WHIM4GD");

    // Test values - these should be passed in or from config
    $callsign = 'KE6KEN';
    $w3w = 'organ.pioneered.instances';

    // Function to get county and state from coordinates
    function getCountyFromCoordinates($lat, $lng) {
        global $logFile;
        $proxyUrl = "https://net-control.space/fcc_proxy.php?latitude=$lat&longitude=$lng";
        
        logMessage("Attempting to fetch county data from proxy: $proxyUrl");
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 30,
                'ignore_errors' => true
            ]
        ]);
        
        $response = @file_get_contents($proxyUrl, false, $context);
        
        if (isset($http_response_header)) {
            $httpStatus = substr($http_response_header[0], 9, 3);
            logMessage("Proxy HTTP Status: $httpStatus");
        }
        
        if ($response === false) {
            outputError("Failed to retrieve data from proxy");
            return null;
        }
        
        $data = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            outputError("JSON decode error: " . json_last_error_msg());
            logMessage("Raw response: " . $response);
            return null;
        }
        
        if (isset($data['County']['name'])) {
            $county = str_replace(' County', '', $data['County']['name']);
            logMessage("Successfully retrieved county: $county");
            return $county;
        }
        
        outputError("County data not found in response");
        return null;
    }

    // Get FCC data
    $fccsql = $db_found->prepare("
        SELECT last,
               first,
               state,
               city,
               zip,
               CONCAT_WS(' ', address1, city, state, zip) AS address,
               fccid
        FROM fcc_amateur.en
        WHERE callsign = :callsign 
        AND fccid = (
            SELECT MAX(fccid) 
            FROM fcc_amateur.en 
            WHERE callsign = :callsign
        )
        ORDER BY fccid DESC 
        LIMIT 0,1
    ");
    
    $fccsql->execute([':callsign' => $callsign]);
    $result = $fccsql->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        outputError("No FCC data found for callsign: $callsign");
        exit;
    }
    
    // Extract FCC data
    $fccid = $result['fccid'];
    $state = $result['state'];
    $city = $result['city'];
    $zip = $result['zip'];
    
    logMessage("Retrieved FCC data for $callsign");
    echo "<div>Retrieved FCC data for $callsign</div>";
    
    // Get coordinates from What3Words
    $w3wLL = $api->convertToCoordinates($w3w);
    if (!isset($w3wLL['coordinates'])) {
        outputError("Failed to get coordinates from What3Words");
        exit;
    }
    
    $lat = $w3wLL['coordinates']['lat'];
    $lng = $w3wLL['coordinates']['lng'];
    $country = $w3wLL['country'];
    
    logMessage("W3W Coordinates: lat=$lat, lng=$lng");
    echo "<div>Coordinates: $lat, $lng</div>";
    
    // Validate coordinates
    if (!is_numeric($lat) || !is_numeric($lng)) {
        outputError("Invalid coordinates received: lat=$lat, lng=$lng");
        exit;
    }
    
    // Get grid square
    $grid = gridsquare($lat, $lng);
    logMessage("Grid Square: $grid");
    echo "<div>Grid Square: $grid</div>";
    
    // Get county
    $county = getCountyFromCoordinates($lat, $lng);
    if ($county === null) {
        outputError("Cannot proceed without valid county information");
        exit;
    }
    
    logMessage("County: $county");
    echo "<div>County: $county</div>";
    
    // Prepare and execute database update
    $updateSql = $db_found->prepare("
        UPDATE stations 
        SET latitude = :lat,
            longitude = :lng,
            grid = :grid,
            county = :county,
            city = :city,
            state = :state,
            home = :home,
            fccid = :fccid,
            active_call = 'y',
            country = :country,
            dttm = NOW(),
            comment = 'via: updateStationLocationWithW3W',
            zip = :zip
        WHERE callsign = :callsign
    ");
    
    $updateParams = [
        ':lat' => $lat,
        ':lng' => $lng,
        ':grid' => $grid,
        ':county' => $county,
        ':city' => $city,
        ':state' => $state,
        ':home' => "$lat,$lng,$grid,$county,$state,$city,$w3w",
        ':fccid' => $fccid,
        ':country' => $country,
        ':zip' => $zip,
        ':callsign' => $callsign
    ];
    
    $updateSql->execute($updateParams);
    $rowCount = $updateSql->rowCount();
    
    logMessage("Database update completed. Rows affected: $rowCount");
    echo "<div style='color: green; margin: 10px; padding: 10px; border: 1px solid green;'>";
    echo "<strong>Update completed successfully. Rows affected: $rowCount</strong>";
    echo "</div>";
    
} catch (PDOException $e) {
    outputError("Database error: " . $e->getMessage());
} catch (Exception $e) {
    outputError("General error: " . $e->getMessage());
}

logMessage("Script completed.");
echo "</body></html>";
?>