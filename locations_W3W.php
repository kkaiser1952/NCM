<?php
    // locations_w3w.php is designed to work much like its counter part locations_APRS.php but with W3W as input by the logger.
    // It is called by the ajax() in NetManager-W3W-APRS.js
    
header('Content-Type: application/json'); 
    
echo "<script>console.log('16) Now In locations_W3W.php: ');</script>";
    
// Error handling function
function customError($errno, $errstr) {
    echo "<script>console.log('18) Error: [$errno] $errstr');</script>";
}
// Set error handler
set_error_handler("customError");  
        
    require_once "dbConnectDtls.php";
    require_once "w3w_functions.php";
    require_once "getCityStateFromLatLng.php";
    require_once "config.php";
    
$response = ['success' => false, 'message' => '', 'error' => ''];

    
try {
    $aprs_call = isset($_GET["aprs_call"]) ? filter_input(INPUT_GET, 'aprs_call', FILTER_SANITIZE_STRING) : '';
    $recordID = isset($_GET["recordID"]) ? filter_input(INPUT_GET, 'recordID', FILTER_SANITIZE_NUMBER_INT) : '';
    $CurrentLat = isset($_GET["CurrentLat"]) ? filter_input(INPUT_GET, 'CurrentLat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
    $CurrentLng = isset($_GET["CurrentLng"]) ? filter_input(INPUT_GET, 'CurrentLng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
    $cs1 = isset($_GET["cs1"]) ? filter_input(INPUT_GET, 'cs1', FILTER_SANITIZE_STRING) : '';
    $nid = isset($_GET["nid"]) ? filter_input(INPUT_GET, 'nid', FILTER_SANITIZE_NUMBER_INT) : '';
    $objName = isset($_GET["objName"]) ? filter_input(INPUT_GET, 'objName', FILTER_SANITIZE_STRING) : '';
    $W3Wcomment = isset($_GET["comment"]) ? filter_input(INPUT_GET, 'comment', FILTER_SANITIZE_STRING) : '';
    $what3words = isset($_GET["w3wfield"]) ? filter_input(INPUT_GET, 'w3wfield', FILTER_SANITIZE_STRING) : '';

    // Get coordinates from What3words
    list($lat, $lng) = getCoordinatesFromW3W($what3words);

    // Check if coordinates are valid
    if (empty($lat) || empty($lng)) {
        throw new Exception('Invalid What3Words input');
    }

    $thislatlng = "$lat, $lng";

    // Now get the crossroads data
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($lat, $lng);

    if ($crossroads === false) {
        throw new Exception('Failed to get crossroads data');
    }

    // Now get the gridsquare
    include('GetGridSquare.php');
    $grid = getgridsquare($lat, $lng);

    // Now get the City, State, and County
    list($state, $county, $city) = reverseGeocode($lat, $lng, $_GOOGLE_MAPS_API_KEY);

    $deltax = 'LOC&#916:W3W '.$objName.' : '.$W3Wcomment.' : '.$what3words.' : '.$crossroads.' : ('.$thislatlng.')';

    // Database operations
    $db_found->beginTransaction();

    // Update NetLog
    $sql = "UPDATE NetLog
               SET latitude = :lat, longitude = :lng, grid = :grid, w3w = :w3w,
                   dttm = NOW(), comments = :comments, city = :city, county = :county, state = :state
             WHERE recordID = :recordID";
    
    $stmt = $db_found->prepare($sql);
    $w3wValue = $what3words . "<br>" . $crossroads;
    $commentsValue = $W3Wcomment . "--<br>Via W3W";
    $stmt->execute([
        ':lat' => $lat, ':lng' => $lng, ':grid' => $grid, ':w3w' => $w3wValue,
        ':comments' => $commentsValue, ':city' => $city, ':county' => $county,
        ':state' => $state, ':recordID' => $recordID
    ]);

    // Update TimeLog
    $sql2 = "INSERT INTO TimeLog (timestamp, callsign, netID, comment)
             VALUES (NOW(), :callsign, :netID, :comment)";
    
    $stmt = $db_found->prepare($sql2);
    $stmt->execute([':callsign' => $cs1, ':netID' => $nid, ':comment' => $deltax]);

    $db_found->commit();

    $response['success'] = true;
    $response['message'] = 'Data updated successfully';
} catch (Exception $e) {
    if (isset($db_found) && $db_found->inTransaction()) {
        $db_found->rollBack();
    }
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>