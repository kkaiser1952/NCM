<?php
// locations_APRS.php is designed to work much like its counter part locations_W3W.php but with APRS_call from the APRSIS as input. Done via right click on the field.
// It is called by the ajax() in NetManager-W3W-APRS.js

// Function to calculate the distance between two sets of coordinates, did current vs new coordinates change?
function calculateDistance($lat1, $lng1, $lat2, $lng2) {
    $earthRadius = 6371000; // Earth's radius in meters
    
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    
    $distance = $earthRadius * $c;
    
    return $distance;
}

require_once "dbConnectDtls.php";
require_once "w3w_functions.php";
require_once "getCityStateFromLatLng.php";
require_once "config.php";

//ini_set('display_errors',1); 
//error_reporting (E_ALL ^ E_NOTICE);

// Check if the variables are set before sanitizing
if (isset($_GET["aprs_call"])) {
    $aprs_call = filter_input(INPUT_GET, 'aprs_call', FILTER_SANITIZE_STRING);
    $aprs_callsign = strtoupper($aprs_call);
}

if (isset($_GET["recordID"])) {
    $recordID = filter_input(INPUT_GET, 'recordID', FILTER_SANITIZE_NUMBER_INT);
}

if (isset($_GET["CurrentLat"])) {
    $currentLat = filter_input(INPUT_GET, 'CurrentLat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($_GET["CurrentLng"])) {
    $currentLng = filter_input(INPUT_GET, 'CurrentLng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($_GET["cs1"])) {
    $cs1 = filter_input(INPUT_GET, 'cs1', FILTER_SANITIZE_STRING);
}

if (isset($_GET["nid"])) {
    $nid = filter_input(INPUT_GET, 'nid', FILTER_SANITIZE_NUMBER_INT);
}

if (isset($_GET["objName"])) {
    $objName = filter_input(INPUT_GET, 'objName', FILTER_SANITIZE_STRING);
}

if (isset($_GET["comment"])) {
    $APRScomment = filter_input(INPUT_GET, 'comment', FILTER_SANITIZE_STRING);
}

// passcodes
include('config2.php');
$aprs_fi_api_key = $config['aprs_fi']['api_key'];
$api_url = "http://api.aprs.fi/api/get?name={$aprs_callsign}&what=loc&apikey={$aprs_fi_api_key}&format=json";

// Fetch the data from the API
$json_data = file_get_contents($api_url);
$data = json_decode($json_data, true);

// Extract the required data from the aprs.fi api 
$newLat = $data['entries'][0]['lat'];
$newLng = $data['entries'][0]['lng'];

// Do we have duplicate coordinates
$toleranceMeters = 30; // Approximately 30 meters
// Calculate the distance between the current and new coordinates
$distance = calculateDistance($currentLat, $currentLng, $newLat, $newLng);

// Compare the distance with the tolerance
if ($distance < $toleranceMeters) {
    // Coordinates are within the tolerance
    $warningMessage = "<b style='color:red;'>Warning:</b> Coordinates have not significantly changed since the last update.<br>";
    
    // Update the NetLog table with the warning message
    $sql = "UPDATE NetLog
               SET comments = CONCAT(:warning, '<br>', comments)
             WHERE recordID = :recordID     
    ";   

    try { 
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':warning', $warningMessage);
        $stmt->bindParam(':recordID', $recordID);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error updating NetLog: " . $e->getMessage();
    }

    // Update the TimeLog table with the warning message
    $sql2 = "INSERT INTO TimeLog 
            (timestamp, callsign, netID, comment)
            VALUES (NOW(), :callsign, :netID, :comment)
    ";

    try { 
        $stmt = $db_found->prepare($sql2);
        $stmt->bindParam(':callsign', $cs1);
        $stmt->bindParam(':netID', $nid);
        $stmt->bindParam(':comment', $warningMessage);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error updating TimeLog: " . $e->getMessage();
    }

    // Send a response back to the AJAX call indicating no update is needed
    $response = array(
        'status' => 'warning',
        'message' => $warningMessage
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); // Stop further execution of the script
}

$altitude_meters = $data['entries'][0]['altitude'];
$alt_feet        = $data['entries'][0]['altitude']*3.28084;
$altitude_feet   = number_format($alt_feet, 1);
$aprs_comment    = $data['entries'][0]['comment'];

// $firsttime is the value of time in the returned array. It is the last time heard
// $thistime is the value of lasttime in the array. It is the most current time heard
$firsttime = gmdate('Y-m-d H:i:s', $data['entries'][0]['time']);
$thistime = gmdate('Y-m-d H:i:s', $data['entries'][0]['lasttime']);

// for including into the Time Line Log at end of the comment or object
$thislatlng = "$newLat,$newLng";

// Now get the crossroads data
include('getCrossRoads.php');
$crossroads = getCrossRoads($newLat, $newLng);

/*
    error_reporting(0);
function getCrossRoads($lat, $lng, $maxRetries = 2, $retryDelay = 1) {
    $retryCount = 0;
    $crossroads = '';

    while ($retryCount < $maxRetries) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.geonames.org/findNearestIntersectionJSON?lat=$lat&lng=$lng&radius=1&username=ncm_wa0tjt",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5, // Set a timeout of 5 seconds
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            // If there's an error, increment the retry count and wait before retrying
            $retryCount++;
            if ($retryCount < $maxRetries) {
                sleep($retryDelay);
                continue;
            } else {
                // If the maximum number of retries is reached, return an error message
                return "Error retrieving crossroads: " . $err;
            }
        } elseif ($httpCode === 200) {
            // If the API call is successful (HTTP code 200), process the response
            $crc = json_decode($response, true);
            if (isset($crc['intersection']['street1']) && isset($crc['intersection']['street2'])) {
                $street1 = $crc['intersection']['street1'];
                $street2 = $crc['intersection']['street2'];
                $crossroads = "$street1 &amp; $street2";
                return $crossroads;
            } else {
                // If the response doesn't contain the expected data, return a default message
                return "Crossroads not found";
            }
        } else {
            // If the API call returns a non-200 status code, increment the retry count and wait before retrying
            $retryCount++;
            if ($retryCount < $maxRetries) {
                sleep($retryDelay);
                continue;
            } else {
                // If the maximum number of retries is reached, return an error message
                return "Error retrieving crossroads. HTTP status code: " . $httpCode;
            }
        }
    }

    // If no crossroads are found after all retries, return a default message
    return "Crossroads not found";
}
  */


// Now get the gridsquare
include('GetGridSquare.php');
$grid = getgridsquare($newLat, $newLng);

// Now get the City, State, and Count
include('getCityStateromLatLng.php');
list($state, $county, $city) = reverseGeocode($newLat, $newLng, $_GOOGLE_MAPS_API_KEY);

// Now lets add the what3words words from the W3W geocoder
$w3w_api_key = $config['geocoder']['api_key'];

// use What3words\Geocoder\Geocoder;
require_once('Geocoder.php');
$latx = (float) $data['entries'][0]['lat'];
$lat = number_format($latx, 6);
$lngx = (float) $data['entries'][0]['lng'];
$lng = number_format($lngx, 6);


$api = new What3words\Geocoder\Geocoder($w3w_api_key);
   
// Get the what3words using lat lng
$result = $api->convertTo3wa($lat, $lng);
$what3words = $result['words'];
//$language = $result['language'];
$map = $result['map'];
//$place = $result['nearestPlace'];

// This stuff is for printing only
$crossroads = html_entity_decode($crossroads);

$varsToKeep = array(
    "aprs_callsign" => htmlspecialchars($aprs_callsign),
    "recordID"      => htmlspecialchars($recordID),
    "currentLat"    => htmlspecialchars($currentLat),
    "currentLng"    => htmlspecialchars($currentLng),
    "newLat"        => htmlspecialchars($newLat),
    "newLng"        => htmlspecialchars($newLng),
    "altitude_meters" => htmlspecialchars($altitude_meters),
    "altitude_feet" => htmlspecialchars($altitude_feet),
    "crossroads"    => htmlspecialchars($crossroads),
    "firsttime"     => htmlspecialchars($firsttime),
    "thistime"      => htmlspecialchars($thistime),
    "grid"          => htmlspecialchars($grid),
    "what3words"    => htmlspecialchars($what3words),
    "map"           => htmlspecialchars($map),
    "cs1"           => htmlspecialchars($cs1),
    "nid"           => htmlspecialchars($nid),
    "aprs_comment"  => htmlspecialchars($aprs_comment),
    "objName"       => htmlspecialchars($objName),
    "thislatlng"    => htmlspecialchars($thislatlng),
    "city"          => htmlspecialchars($city),
    "county"        => htmlspecialchars($county),
    "state"         => htmlspecialchars($state)
);

$json = json_encode($varsToKeep, JSON_PRETTY_PRINT);
echo "<br><br> $json";
echo "\n\n";

$deltax = 'LOC&#916:APRS '.$objName.' : '.$APRScomment.' : '.$what3words.' : '.$crossroads.' : ('.$thislatlng.')';
   
// This SQL updates the NetLog with all the information we just created.   
$sql = "UPDATE NetLog
           SET latitude     = :lat
              ,longitude    = :lng
              ,grid         = :grid
              ,w3w          = :w3w
              ,dttm         = NOW()
              ,comments     = :comments
              ,city         = :city
              ,county       = :county
              ,state        = :state
         WHERE recordID = :recordID     
";   
   
try { 
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':lat', $newLat);
    $stmt->bindParam(':lng', $newLng);
    $stmt->bindParam(':grid', $grid);
    $w3wValue = $what3words . "<br>" . $crossroads;
    $stmt->bindParam(':w3w', $w3wValue);
    $commentsValue = $APRScomment . "--<br>Via APRS";
    $stmt->bindParam(':comments', $commentsValue);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':county', $county);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':recordID', $recordID);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
   
// Update the TimeLog with the new information    
$sql2 = "INSERT INTO TimeLog 
        (timestamp, callsign, netID, comment)
        VALUES (NOW(), :callsign, :netID, :comment)
";
   
try { 
    $stmt = $db_found->prepare($sql2);
    // Bind parameters
    $stmt->bindParam(':callsign', $cs1);
    $stmt->bindParam(':netID', $nid);
    $stmt->bindParam(':comment', $deltax);

    if ($stmt->execute()) { 
        echo "sql2 executed successfully";
    } else {
        echo "sql2 execution failed";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Send a response back to the AJAX call indicating successful update
$response = array(
    'status' => 'success',
    'message' => 'Coordinates updated successfully'
);
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>