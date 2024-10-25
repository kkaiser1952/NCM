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
    
    //print_r($result);

        $fccid      = $result[fccid];
		$Lname 		= ucfirst(strtolower($result[last])); 
		$Fname 		= ucfirst(strtolower($result[first]));
		$state	 	= $result[state];
		$city       = $result[city];
		$zip        = $result[zip];
		$address 	= $result[address];
		
		//echo "<br><br> $Fname $Lname<br>$address<br>$city $state $zip";
        
        print_r($result);
        
        echo "<br><br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} // End try/catch

// Get county and state from FCC API

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

    
/* .us Version */
?>