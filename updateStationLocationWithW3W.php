<!doctype html>
<?php 
    /* This program uses the W3W address to calculate lat/lon, grid, county, state etc. and update the stations table */
    /* REQUIRED: a callsign and the What3Words address
    /* Writte: 2021-10-15 */
    /* Updated: 2024-10-23 */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "GridSquare.php";
    require_once "geocode.php";
    //require_once "config.php";
    
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
	  	$result     = $fccsql->fetch();
	 	$fccid 	    = $result[fccid];
	 	$state      = $result[state];
	 	$city       = $result[city];
	 	$zip        = $result[zip];

// ====================================
// Now get the lat/lon from W3W site

/* Array ( [country] => US [square] => Array ( [southwest] => Array ( [lng] => -82.457281 [lat] => 34.9413 ) [northeast] => Array ( [lng] => -82.457248 [lat] => 34.941327 ) ) [nearestPlace] => Travelers Rest, South Carolina [coordinates] => Array ( [lng] => -82.457265 [lat] => 34.941314 ) [words] => organ.pioneered.instances [language] => en [map] => https://w3w.co/organ.pioneered.instances )
*/
// ====================================
$w3wLL = $api->convertToCoordinates("$w3w");
//print_r($w3wLL);
   $lat    = $w3wLL['coordinates']['lat']; 
   $lng    = $w3wLL['coordinates']['lng'];   
   $country= $w3wLL['country'];
   
   // Get the gridsquare from lat lng  
$grid   = gridsquare($lat, $lng);	 

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

echo ("$county");
    

// =======================================================
// Use the goecode.php function to find county and state
// =======================================================
//$address = geocode("$lat,$lng");
//echo("$address");
//echo("<br><br>$address[0], $address[1], $address[2], $address[3]");
//$county = $address[2];
//echo ("$county");
//$state  = $address[3];


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

//$db_found->exec($sql);

?>