<!doctype html>
<?php
    /* This program uses the W3W address to calculate lat/lon, grid, county, state etc. and update the stations table */
    /* REQUIRED: a callsign and the What3Words address
    /* Writte: 2021-10-15 */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "GridSquare.php";
    require_once "geocode.php";
    
    // This is for what3words usage
    /* https://developer.what3words.com/public-api/docs#convert-to-3wa */
    require_once "Geocoder.php";
        use What3words\Geocoder\Geocoder;
        use What3words\Geocoder\AutoSuggestOption;
            $api = new Geocoder("5WHIM4GD");
            
  
    
 $callsign = 'kq4eoq';
 //$w3w     = 'pylon.slamming.grit';        // Brazil
 $w3w     = '///hurricane.burns.commissions';    // k0rgb
 
 
 
 // lifted from getFCCrecord.php just to get the fccid
 $fccsql = $db_found->prepare("
	       SELECT replace(last,\"'\",\"''\") as last 
				 ,first
				 ,state
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

 
// ====================================
// Now get the lat/lon from W3W site
// ====================================
$w3wLL = $api->convertToCoordinates("$w3w");
//print_r($w3wLL);
   $lat    = $w3wLL['coordinates']['lat']; 
   $lng    = $w3wLL['coordinates']['lng'];     
   $grid   = gridsquare($lat, $lng);	 
   $country= $w3wLL['country']; 
   
   
// =======================================================
// Use the goecode.php function to find county and state
// =======================================================
$address = geocode("$lat,$lng");
//echo("<br><br>$address[0], $address[1], $address[2], $address[3]");
$county = $address[2];
$state  = $address[3];


$sql = ("
    UPDATE stations 
        SET latitude    = $lat
           ,longitude   = $lng
           ,grid        = '$grid'
           ,county      = '$county'
           ,state       = '$state'
           ,home        = '$lat,$lng,$grid,$county,$state'
           ,fccid       = $fccid
           ,active_call = 'y'
           ,country     = '$country'
           ,dttm        = NOW()
           ,comment     = 'via: updateStationLocationWithW3W'
           ,zip         = '64089'
     WHERE callsign = '$callsign'
");         

echo "<br><br>sql= <br>$sql";  

$db_found->exec($sql);

?>