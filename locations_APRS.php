<?php
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
	
	$aprs_call = $_GET["aprs_call"];      
        $aprs_callsign = strtoupper($aprs_call);
    $recordID   = $_GET["recordID"]; 
    $CurrentLat = $_GET["CurrentLat"];
    $CurrentLng = $_GET["CurrentLng"];
    $cs1        = $_GET["cs1"]; // callsign of row
    $nid        = $_GET["nid"]; // netID
    $objName    = $_GET["objName"];
    
    //echo "<br><u>For Callsign: $aprs_callsign</u><br><br>";
    //echo "<u>From The APRS API, part 1</u><br>";
     
    include('config2.php');
    
    $aprs_fi_api_key = $config['aprs_fi']['api_key'];
    
    $api_url = "http://api.aprs.fi/api/get?name={$aprs_callsign}&what=loc&apikey={$aprs_fi_api_key}&format=json";
    
    // Fetch the data from the API
    $json_data = file_get_contents($api_url);
    $data = json_decode($json_data, true);
    
    // Add debugging statement to check if $data contains the expected values
    //echo "<pre>";
        //print_r($data);
    //echo "</pre>";
    
    // Extract the required data from the aprs.fi api 
    $lat             = $data['entries'][0]['lat'];
    $lng             = $data['entries'][0]['lng'];
    $altitude_meters = $data['entries'][0]['altitude'];
    $alt_feet        = $data['entries'][0]['altitude']*3.28084;
        $altitude_feet   = number_format($alt_feet, 1);
    $aprs_comment    = $data['entries'][0]['comment'];
        //echo "aprs comment: {$aprs_comment};
    
    // $firsttime is the value of time in the returned array. It is the last time heard
    // $thistime is the value of lasttime in the array. It is the most current time heard
    $firsttime = gmdate('Y-m-d H:i:s', $data['entries'][0]['time']);
    $thistime = gmdate('Y-m-d H:i:s', $data['entries'][0]['lasttime']);
    
    // Output the aprs supplied data
    //echo "<u>From The APRS API part 2</u><br>";
    //echo "Latitude: {$lat}<br>";
    //echo "Longitude: {$lng}<br>";
    //echo "Altitude: {$altitude}<br>";
    //echo "First Time: {$firsttime} UTC<br>";
    //echo "This Time: {$thistime} UTC<br>";
    //echo "aprs comment: {$aprs_comment};
    
    // Now get the crossroads data
    //echo "<br><u>From The getCrossRoads()</u><br>";
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($lat, $lng);
    
    //echo "{$crossroads}<br>";
    
    // Now get the gridsquare
    include('GetGridSquare.php');
    //echo "<br><u>From GetGridSquare.php</u>";
    $grid = getgridsquare($lat, $lng);
    //echo "<br>Grid Square: {$grid}<br>";
    
    // Output the entire data array for debugging purposes
    //echo "<br><u>The Data Array From The APRS.fi API:</u><br>";
   // print_r($data);
    
    // Now lets add the what3words words from the W3W geocoder
    $w3w_api_key = $config['geocoder']['api_key'];
    
    require_once('Geocoder.php');
  //  use What3words\Geocoder\Geocoder;
    
    $latx = (float) $data['entries'][0]['lat'];
        $lat = number_format($latx, 6);
    $lngx = (float) $data['entries'][0]['lng'];
        $lng = number_format($lngx, 6);
    
    //echo ('<br><br>lat '.$lat.', lng '.$lng.'<br>');
    
    $api = new What3words\Geocoder\Geocoder($w3w_api_key);
       
    $result = $api->convertTo3wa($lat, $lng);
    //echo "<br><br><u>The W3W Geocoder Array by What3Words</u><br>";
        //print_r($result);
    
    //echo "<br>"; 
    
    //$southwest_lat = $result['square']['southwest']['lat'];
    //$southwest_lng = $result['square']['southwest']['lng'];
    //$northeast_lat = $result['square']['northeast']['lat'];
    //$northeast_lng = $result['square']['northeast']['lng'];
    $words = $result['words'];
    //$language = $result['language'];
    $map = $result['map'];
    //$place = $result['nearestPlace'];
    
    //echo "<br><u>From Geocoder by What3Words</u><br>";
    //echo "Words: {$words}<br>";
    //echo "Map: {$map}<br>";
    //echo "Nearest Place: {$place}<br>";
    
    
    // This is for printing only

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
        "objName"       => htmlspecialchars($objName)
    );

$json = json_encode($varsToKeep, JSON_PRETTY_PRINT);
echo $json;
echo "\n\n";

// This SQL updates the NetLog with all the information we just created.
    require_once "dbConnectDtls.php";
    
       $sql = 
       "UPDATE NetLog 
           SET latitude     = '$lat'
              ,longitude    = '$lng'
              ,ipaddress    = '$ipaddress'
              ,grid         = '$grid'
              ,w3w          = '$words<br>$crossroads'
              ,dttm         = NOW()
              ,comments     = '$objName'
         WHERE recordID = $recordID;
       ";
       
       $stmt = $db_found->prepare($sql);
       $stmt->execute();
       
       //echo $sql;   
       //echo "\n\n";
       
       //$deltaX = 'LOC&#916;';
       $deltax = 'LOC&#916:APRS '.$aprs_callsign.': Also changed lat/lng, grid, w3w.  '.$aprs_comment;
       $sql = 
       "INSERT INTO TimeLog 
            (timestamp, callsign, comment, netID)
            VALUES ( NOW(), '$cs1', '$deltax', '$nid');      
       ";
       
       echo $sql;
       
       $stmt = $db_found->prepare($sql);
       $stmt->execute();
        
?>
