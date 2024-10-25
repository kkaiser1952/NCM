<!doctype html>
<?php 
    /* updateStationLocationWithW3W.php */
    /* This program uses the W3W address to calculate lat/lon, grid, county, state etc. and update the stations table */
    /* REQUIRED: a callsign and the What3Words address
    /* Writte: 2021-10-15 */
    /* Updated: 2024-10-23 */
    /* .us Version */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "GridSquare.php";
    require_once "geocode.php";
    require_once "config.php";
    
    // This is for what3words usage
    /* https://developer.what3words.com/public-api/docs#convert-to-3wa */
    require_once "Geocoder.php";
        use What3words\Geocoder\Geocoder;
        use What3words\Geocoder\AutoSuggestOption;
            $api = new Geocoder("5WHIM4GD");
   
// Fill the callsign and w3w based on address from FCC 
 $callsign = 'WA0TJT';
 $w3w = '///guiding.confusion.towards'; 
 
// Get the grid and country from W3W
$w3wLL = $api->convertToCoordinates("$w3w");
   $lat    = $w3wLL['coordinates']['lat']; 
   $lng    = $w3wLL['coordinates']['lng'];   
   $country= $w3wLL['country'];
   
   //print_r($w3wLL);
   
   // Get the gridsquare from lat lng  
$grid   = gridsquare($lat, $lng);	 
   //echo "<br>grid: $grid, $country<br><br>";
// End W3W work

 // from the fcc DB and en table
try {
    $sql = "
        SELECT last,
               first,
               state,
               city,
               zip,
               CONCAT_WS(' ', address1, city, state, zip) AS address,
               fccid
        FROM fcc_amateur.en e1
        WHERE callsign = :callsign 
        AND e1.fccid = (
            SELECT MAX(e2.fccid) 
            FROM fcc_amateur.en e2 
            WHERE e2.callsign = :callsign
        )
        ORDER BY e1.fccid DESC 
        LIMIT 0,1";

    $fccsql = $db_found->prepare($sql);

    // Bind the parameter
    $fccsql->bindParam(':callsign', $callsign, PDO::PARAM_STR);

    // Manually substitute for debugging
    $debugQuery = str_replace(':callsign', $db_found->quote($callsign), $sql);
    //echo "<br>Debug Query:<br> " . $debugQuery . "<br><br>"; // Print the debug query

    // Execute the statement
    $fccsql->execute();

    // Fetch the result
    $result = $fccsql->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        print_r($result); // Process the data as needed
    } else {
        echo "No record found for callsign: " . $callsign;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} // End try/catch

// Get county and state from FCC API
/*
$locationInfo = getFCCLocationData($lat, $lng);
    if ($locationInfo) {
        $county = $locationInfo['county'];
        $fccState = $locationInfo['state'];
        echo "<br>";
        echo "FCC API Results:<br>";
        echo "County: $county<br>";
        echo "State: $fccState<br><br>";
    } else {
        echo "Failed to get location data from FCC API<br><br>";
    }
*/    
echo ("<br><br> into koords<br><br>");
    $koords = geocode("$address"); 
        print_r($koords);  
			    // Array ( [0] => 46.906975 [1] => -92.489501 [2] => St. Louis [3] => MN ) 
			$latitude  = $koords[0];  //echo "<br>lat= $latitude";
			$longitude = $koords[1];  //echo " lon= $longitude";
			$county	   = $koords[2];
			$state	   = $koords[3];
				if ($state == '') {
					$state = $state2;
				}
/*
			$gridd 	   = gridsquare($latitude, $longitude);
			$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";  			
			$home      = "$latitude,$longitude,$grid,$county,$state";
*/
    
/* .us Version */
/*
function reverseGeocode($lat, $lng, $apiKey) {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if(isset($data['results']) && !empty($data['results'])) {
        $addressComponents = $data['results'][0]['address_components'];
        $state = $county = $city = null;

        foreach ($addressComponents as $component) {
            if (in_array('administrative_area_level_1', $component['types'])) {
                $state = $component['short_name'];
            }
            if (in_array('administrative_area_level_2', $component['types'])) {
                $county = str_replace(' County', '', $component['long_name']);
            }
            if (in_array('locality', $component['types'])) {
                $city = $component['long_name'];
            }
        }
        
        return [$state, $county, $city];
    }

    return [null, null, null];
}

echo ("<br>county: $county");
    
*/
// =======================================================
// Use the goecode.php function to find county and state
// =======================================================
/*
$address = geocode("$lat,$lng");
echo("$address");
echo("<br><br>$address[0], $address[1], $address[2], $address[3]");
$county = $address[2];
echo ("$county");
$state  = $address[3];

/*
$sql = ("
    UPDATE stations 
        SET latitude    = $lat
           ,longitude   = $lng
           ,grid        = '$grid'
           ,county      = '$county'
           ,city        = '$city'
           ,state       = '$state'
           ,home        = '$lat,$lng,$grid,$county,$state,$city,$w3w'
           ,fccid       = $fccid
           ,active_call = 'y'
           ,country     = '$country'
           ,dttm        = NOW()
           ,comment     = 'via: updateStationLocationWithW3W'
           ,zip         = '$zip'
     WHERE callsign = '$callsign'
");         

echo "<br><br>sql= <br>$sql";  
*/

//$db_found->exec($sql);

?>