<!doctype html>
<?php 
    /* updateStationLocationWithW3W.php
    /* This program uses the W3W address to calculate lat/lon, grid, county, state etc. and update the stations table */
    /* REQUIRED: a callsign and the What3Words address
    /* Writte: 2021-10-15 */
    /* Updated: 2024-10-23 */
    
    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Set up logging
    $logFile = __DIR__ . '/logs/update_log.txt';
    
    ini_set('log_errors', 'On');
    ini_set('error_log', $logFile);
    
    
    // Function to log messages
    function logMessage($message) {
        global $logFile;
        error_log(date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, 3, $logFile);
    }

    logMessage("Script started.");

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
 $callsign = 'KE6KEN';
 $w3w     = 'organ.pioneered.instances'; 
 

 // from the fcc DB and en table
 $fccsql = $db_found->prepare("
	       SELECT  last 
				 ,first
				 ,state
				 ,city
				 ,zip
				 ,CONCAT_WS(' ', address1, city, state, zip) AS address
				 ,fccid
			 FROM fcc_amateur.en
			WHERE callsign = '$callsign' 
			  AND fccid = (SELECT MAX(fccid) FROM fcc_amateur.en WHERE callsign = '$callsign')
			ORDER BY fccid DESC 
			LIMIT 0,1 ");		
					
    $fccsql->execute();
    $result = $fccsql->fetch();
    if ($result) {
        $fccid = $result['fccid'];
        $state = $result['state'];
        $city = $result['city'];
        $zip = $result['zip'];
    } else {
        logMessage("No result found for callsign: $callsign");
        exit; // Exit if no result is found
    }

// ====================================

$w3wLL = $api->convertToCoordinates("$w3w");
//print_r($w3wLL);
   $lat    = $w3wLL['coordinates']['lat']; 
   $lng    = $w3wLL['coordinates']['lng'];   
   $country= $w3wLL['country'];
   
   // Get the gridsquare from lat lng  
$grid   = gridsquare($lat, $lng);	 

function getCountyFromCoordinates($lat, $lng) {
    $proxyUrl = "https://net-control.space/fcc_proxy.php?latitude=$lat&longitude=$lng"; // Replace with your actual new server URL
    
    $response = file_get_contents($proxyUrl);

    if ($response === false) {
            logMessage("Error: Could not retrieve county or state.");
            return null;
    }

    $data = json_decode($response, true);
    
    if (isset($data['County']['name'])) {
        // Remove the word "County" from the response
        return str_replace(' County', '', $data['County']['name']);
    }
    
    return null;
} // End getCountyFromCoordinates()


// Example usage with your coordinates
$lat = 34.941314;
$lng = -82.457265;

$county = getCountyFromCoordinates($lat, $lng);
    logMessage("County: " . ($county ?? 'Not found'));


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

//echo "<br><br>sql= <br>$sql";  
logMessage("SQL: $sql");

//$db_found->exec($sql);

?>