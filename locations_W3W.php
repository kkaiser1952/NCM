<?php
    // locations_w3w.php is designed to work much like its counter part locations_APRS.php but with W3W as input by the logger.
    // It is called by the ajax() in NetManager-W3W-APRS.js
    
    /*
        GOALS:
        1) Hold off on displaying the dialogbox until after the W3W three words are entered
        2) Get the cross roads, post them under the just entered three words
        3) Display the dialogbox
        4) Clear current 'comments' field
        5) Add comment info into 'comments' field 
    */
    
    //ini_set('display_errors',1); 
	//error_reporting (E_ALL ^ E_NOTICE);
	
	// Lets build the two queries we need to get and data and update the tables.

    
// Get values from the NetLog table
$sql = "SELECT ID, netID, callsign, w3w, latitude, longitude
          FROM NetLog 
		WHERE recordID = '$recordID'";
//echo "sql1: $sql1";
			foreach($db_found->query($sql) as $row) {
				$netID = $row['netID'];
				$ID	   = $row['ID'];
				$cs1   = $row['callsign'];
				$w3w  = $row['W3W'];
			    $lat = $row['latitude'];
			    $lng = $row['longitude'];
			}
	
/*
// Update the TimeLog table			
$sql2 = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, latitude, longitude, ipaddress) 
        VALUES ('$recordID', '$ID', '$netID', '$cs1', 'W3W set to: $value', 
        NOW(), '$lat', '$lng', '$ipaddress')";
	
	echo "sql2: $sql2";
    //$db_found->exec($sql);
*/

// Function to convert W3W into lat/long
function convertW3WtoCoordinates($what3words) {
    $w3w_api_key = $config['geocoder']['api_key'];
    //$apiKey = "YOUR_API_KEY"; // Replace with your actual API key
    $url = "https://api.what3words.com/v3/convert-to-coordinates?words=" . $what3words . "&key=" . $w3w_api_key;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if (isset($data['coordinates'])) {
            $latitude = $data['coordinates']['lat'];
            $longitude = $data['coordinates']['lng'];
            return array($latitude, $longitude);
        } else {
            echo "Invalid response from API";
        }
    } else {
        echo "Request failed with status code: " . $httpCode;
    }
} // End of convertW3WtoCoordinates() function
	
	$W3W_entered = $_GET["W3W_entered"];      
	$recordID    = $_GET["recordID"]; 
    $CurrentLat  = $_GET["CurrentLat"];       
    $CurrentLng  = $_GET["CurrentLng"];        
    $cs1         = $_GET["cs1"];  
    $nid         = $_GET["nid"];   
    $objName     = $_GET["objName"];      
    
    // This variable not needed for W3W, set to stay like locations_APRS.php
    $aprs_callsign = ""; 
    
    echo("@47 in locations_W3W.php:: <br>
        W3W entered: $W3W_entered <br>
        recordID: $recordID <br>
        CurrentLat: $CurrentLat <br>
        CurrentLng: $CurrentLng <br>
        cs1: $cs1 <br>
        nid: $nid <br>
        objName: $objName <br>");
     
    // passcodes 
    include('config2.php');
    
    //$api = new What3words\Geocoder\Geocoder($w3w_api_key);
    list($latitude, $longitude) = convertW3WtoCoordinates($W3W_entered);
    
    echo "@62 W3W Latitude: " . $latitude . "<br>";
    echo "@63 W3W Longitude: " . $longitude . "<br>";

    // Everything below here matches the locations_APRS.php
    // ====================================================

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
    
    // for including into the Time Line Log at end of the comment or object
    $thislatlng = "$lat,$lng";
    
    // Output the aprs supplied data
    echo "<u>From The APRS API part 2</u><br>";
    echo "Latitude: {$lat}<br>";
    echo "Longitude: {$lng}<br>";
    echo "Altitude: {$altitude}<br>";
    echo "First Time: {$firsttime} UTC<br>";
    echo "This Time: {$thistime} UTC<br>";
    echo "aprs comment: {$aprs_comment} <br>";
    echo "thislatlng: {$thislatlng} ";
    
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
        //$lat = number_format($latx, 6);
    $lngx = (float) $data['entries'][0]['lng'];
        //$lng = number_format($lngx, 6);
    //echo ('<br><br>lat '.$lat.', lng '.$lng.'<br>');
    
    $api = new What3words\Geocoder\Geocoder($w3w_api_key);
       
    // Get the what3words using lat lng
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

$json = json_encode($varsToKeep, JSON_PRETTY_PRINT);
//echo $json;
//echo "\n\n";

// This SQL updates the NetLog with all the information we just created.
    
       $sql1 = 
       "UPDATE NetLog 
           SET latitude     = '$lat'
              ,longitude    = '$lng'
              ,ipaddress    = '$ipaddress'
              ,grid         = '$grid'
              ,w3w          = '$words<br>$crossroads'
              ,dttm         = NOW()
              ,comments     = '$objName : '
         WHERE recordID = $recordID;
       ";
       
       $stmt = $db_found->prepare($sql1);
       $stmt->execute();
       */
       //echo $sql;   
       //echo "\n\n";
       
       //Interpretation of the deltax variable;
       /* The field delimiter is the colon, :
    
        Identifier: 'LOC&#916:W3W OBJ::8'  This could also be APRS COM::
        Item name: '8'  This can also be things like 'Red Car', 'Tree on roof', etc.
        Additional information: past 56th ct & Keith and Deb from KCMO these are APRS comments from the reporting source
        what3words string: '///summer.topic.yesterday'  The W3W address
        Nearest crossroads: '60th Court & Ames Ave'   The nearest crossroads
        Latitude and longitude: '39.20245, -94.60254'  The lat/lng of W3W
       */
       $deltax = 'LOC&#916:W3W '.$objName.' : '.$aprs_comment.' : ///'.$words.' : '.$crossroads.' : ('.$thislatlng.')';
       
       
       $sql2 = 
       "INSERT INTO TimeLog 
            (timestamp, callsign, comment, netID)
            VALUES ( NOW(), '$cs1', '$deltax', '$nid');      
       "; 
       
       // The recordID below is from the NetLog
       
       $sql2 = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, latitude, longitude, ipaddress) 
                VALUES ('$recordID', '$ID', '$nid', '$cs1', '$deltax', NOW(), '$lat', '$lng', '$ipaddress')";
       
       echo $sql2;
       
       $stmt = $db_found->prepare($sql2);
       $stmt->execute();
        
?>
