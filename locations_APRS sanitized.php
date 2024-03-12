<?php
    // locations_APRS.php is designed to work much like its counter part locations_W3W.php but with APRS_call from the APRSIS as input. Done via right click on the field.
    // It is called by the ajax() in NetManager-W3W-APRS.js
    
    require_once "dbConnectDtls.php";
    require_once "w3w_functions.php";
        
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
	
$aprs_call = isset($_GET["aprs_call"]) ? filter_input(INPUT_GET, 'aprs_call', FILTER_SANITIZE_STRING) : '';
$recordID = isset($_GET["recordID"]) ? filter_input(INPUT_GET, 'recordID', FILTER_SANITIZE_NUMBER_INT) : '';
$CurrentLat = isset($_GET["CurrentLat"]) ? filter_input(INPUT_GET, 'CurrentLat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$CurrentLng = isset($_GET["CurrentLng"]) ? filter_input(INPUT_GET, 'CurrentLng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$cs1 = isset($_GET["cs1"]) ? filter_input(INPUT_GET, 'cs1', FILTER_SANITIZE_STRING) : '';
$nid = isset($_GET["nid"]) ? filter_input(INPUT_GET, 'nid', FILTER_SANITIZE_NUMBER_INT) : '';
$objName = isset($_GET["objName"]) ? filter_input(INPUT_GET, 'objName', FILTER_SANITIZE_STRING) : '';
$APRScomment = isset($_GET["comment"]) ? filter_input(INPUT_GET, 'comment', FILTER_SANITIZE_STRING) : '';
    
    
    
    echo ("@30 in locations_APRS.php:: <br>
       aprs_call: $aprs_call <br>
       recordID: $recordID <br>
       CurrentLat: $CurrentLat <br>
       CurrentLng: $CurrentLng <br>
       cs1: $cs1 <br>
       nid: $nid <br>
       objName: $objName <br>
       APRScomment: $APRScomment <br>");
    
    
    // passcodes
    include('config2.php');
    
    // Everything below here matches the locations_W3W.php
    // ===================================================
    
    $aprs_fi_api_key = $config['aprs_fi']['api_key'];

    $api_url = "http://api.aprs.fi/api/get?name={$aprs_callsign}&what=loc&apikey={$aprs_fi_api_key}&format=json";
    
    // Fetch the data from the API
    $json_data = file_get_contents($api_url);
    $data = json_decode($json_data, true);
    
    // Add debugging statement to check if $data contains the expected values
    /*
    echo "<pre>";
        print_r($data);
    echo "</pre>";
    */
    
    // Extract the required data from the aprs.fi api 
    $lat             = $data['entries'][0]['lat'];
    $lng             = $data['entries'][0]['lng'];
    $altitude_meters = $data['entries'][0]['altitude'];
    $alt_feet        = $data['entries'][0]['altitude']*3.28084;
    $altitude_feet   = number_format($alt_feet, 1);
    $aprs_comment    = $data['entries'][0]['comment'];
        //echo "lat: $lat lng: $lng aprs comment: $aprs_comment";
    
    // $firsttime is the value of time in the returned array. It is the last time heard
    // $thistime is the value of lasttime in the array. It is the most current time heard
    $firsttime = gmdate('Y-m-d H:i:s', $data['entries'][0]['time']);
    $thistime = gmdate('Y-m-d H:i:s', $data['entries'][0]['lasttime']);
    
    // for including into the Time Line Log at end of the comment or object
    $thislatlng = "$lat,$lng";
    
    // Output the aprs supplied data
    /*
    echo "<br><u>From The APRS API part 2</u><br>";
    echo "Latitude: {$lat}              <br>";
    echo "Longitude: {$lng}             <br>";
    echo "Altitude: {$altitude}         <br>";
    echo "First Time: {$firsttime} UTC  <br>";
    echo "This Time: {$thistime} UTC    <br>";
    echo "aprs comment: {$aprs_comment} <br>";
    echo "thislatlng: {$thislatlng}     <br>";
    */
    
    // Now get the crossroads data
    //echo "<br><u>From The getCrossRoads()</u><br>";
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($lat, $lng);
    //echo "{$crossroads}<br>";
    
    // Now get the gridsquare
    include('GetGridSquare.php');
    $grid = getgridsquare($lat, $lng);
    //echo "<br>Grid Square: {$grid}<br>";
    
    // Now lets add the what3words words from the W3W geocoder
    $w3w_api_key = $config['geocoder']['api_key'];
    
    // use What3words\Geocoder\Geocoder;
    require_once('Geocoder.php');
    $latx = (float) $data['entries'][0]['lat'];
        $lat = number_format($latx, 6);
    $lngx = (float) $data['entries'][0]['lng'];
        $lng = number_format($lngx, 6);
    echo ('@107 <br><br>lat '.$lat.', lng '.$lng.'<br>');
    
    $api = new What3words\Geocoder\Geocoder($w3w_api_key);
       
    // Get the what3words using lat lng
    $result = $api->convertTo3wa($lat, $lng);
    //echo "<br><br><u>The W3W Geocoder Array by What3Words</u><br>";
        //print_r($result);
    
    $words = $result['words'];
    //$language = $result['language'];
    $map = $result['map'];
    //$place = $result['nearestPlace'];
    
    //echo "<br><u>From Geocoder by What3Words</u><br>";
    //echo "Words: {$words}<br>";
    //echo "Map: {$map}<br>";
    //echo "Nearest Place: {$place}<br>";
    
    
    // This stuff is for printing only
    $crossroads = html_entity_decode($crossroads);

    $varsToKeep = array(
        "aprs_callsign" => htmlspecialchars($aprs_callsign),
        "recordID"      => htmlspecialchars($recordID),
        "CurrentLat"    => htmlspecialchars($CurrentLat),
        "CurrentLng"    => htmlspecialchars($CurrentLng),
        "lat"           => htmlspecialchars($lat),
        "lng"           => htmlspecialchars($lng),
        "altitude_meters" => htmlspecialchars($altitude_meters),
        "altitude_feet" => htmlspecialchars($altitude_feet),
        "crossroads"    => htmlspecialchars($crossroads),
        "firsttime"     => htmlspecialchars($firsttime),
        "thistime"      => htmlspecialchars($thistime),
        "grid"          => htmlspecialchars($grid),
        "what3words"    => htmlspecialchars($words),
        "map"           => htmlspecialchars($map),
        "cs1"           => htmlspecialchars($cs1),
        "nid"           => htmlspecialchars($nid),
        "aprs_comment"  => htmlspecialchars($aprs_comment),
        "objName"       => htmlspecialchars($objName),
        "thislatlng"    => htmlspecialchars($thislatlng)
    );
    
    $deltax = 'LOC&#916:APRS '.$objName.' : '.$APRScomment.' : ///'.$words.' : '.$crossroads.' : ('.$thislatlng.')';
       
       echo "<br>deltax: $deltax<br>";


$json = json_encode($varsToKeep, JSON_PRETTY_PRINT);
echo "<br><br> $json";
echo "\n\n";


// This SQL updates the NetLog with all the information we just created.

$sql =
"UPDATE NetLog
    SET latitude = :lat
        ,longitude = :lng
        ,ipaddress = :ipaddress
        ,grid = :grid
        ,w3w = :words
        ,dttm = NOW()
        ,comments = :APRScomment
  WHERE recordID = :recordID;
";
try {
$stmt = $db_found->prepare($sql);
$stmt->bindParam(':lat', $lat);
$stmt->bindParam(':lng', $lng);
$stmt->bindParam(':ipaddress', $ipaddress);
$stmt->bindParam(':grid', $grid);
$stmt->bindParam(':words', $words."<br>".$crossroads);
$stmt->bindParam(':APRScomment', $APRScomment."--<br>Via APRS");
$stmt->bindParam(':recordID', $recordID);
$stmt->execute();
} catch (PDOException $e) {
echo "Error: " . $e->getMessage();
}

            
$stmt = $db_found->prepare("INSERT INTO TimeLog (timestamp, callsign, netID, comment) VALUES (NOW(), :cs1, :nid, :deltax)";
try {
$stmt->bindParam(':cs1', $cs1);
$stmt->bindParam(':nid', $nid);
$stmt->bindParam(':deltax', $deltax);
if ($stmt->execute()) {
echo "sql2 executed successfully";
} else {
echo "sql2 execution failed";
}
} catch (PDOException $e) {
echo "Error: " . $e->getMessage();
} 
 
?>
