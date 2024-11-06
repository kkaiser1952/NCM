<?php
// geocode.php
// function to geocode address using OpenStreetMap's Nominatim service
// function to geocode address, it will return false if unable to geocode address
// Re-Written: 2024-11-05 help from Claude AI

require_once "dbConnectDtls.php";
require_once "ENV_SETUP.php";


function geocode($address){
   // Clean the address first
   $address = cleanAddress($address);
   
   // MapQuest API key
   $mapquest_key = '4fj7GQudJyamkYjO3eQyjHtApPZa9l53';
   
   // url encode the cleaned address
   $address = urlencode($address);
   
   // MapQuest geocoding URL
   $url = "https://www.mapquestapi.com/geocoding/v1/address?key={$mapquest_key}&location={$address}&outFormat=json";
   
   $resp_json = file_get_contents($url);
   $resp = json_decode($resp_json, true);
   
   // For debugging
    // var_dump($resp);
   
   if(isset($resp['results'][0]['locations'][0])) {
       $location = $resp['results'][0]['locations'][0];
       
       // Format coordinates to 6 decimal places
       $lati = number_format((float)$location['latLng']['lat'], 6);
       $longi = number_format((float)$location['latLng']['lng'], 6);
       
       // Get state (already comes as abbreviation from MapQuest)
       $state = $location['adminArea3'];
       
       // Get county and remove 'County' from the name
       $county = $location['adminArea4'];
       $county = str_replace(' County', '', $county);
       
       if($lati && $longi && $county && $state){
           $koords = array();            
           array_push($koords, $lati, $longi, $county, $state);
           return $koords;             
       }
   }
   return false;
}

function cleanAddress($address) {
   // Remove apartment numbers, unit numbers, etc.
   $patterns = array(
       '/\bAPT\b.*?\b/i',      // Matches "APT" and following text
       '/\bUNIT\b.*?\b/i',     // Matches "UNIT" and following text
       '/\b#\d+\b/',           // Matches "#" followed by numbers
       '/\bSTE\b.*?\b/i',      // Matches "STE" (Suite) and following text
       '/,.*?(?=\b[A-Z]{2}\b)/'// Removes everything between comma and state code
   );
   
   $address = preg_replace($patterns, '', $address);
   
   // Remove extra spaces and trim
   $address = preg_replace('/\s+/', ' ', $address);
   return trim($address);
}

////////// ***** DON'T LEAVE THIS STUFF UNCOMMENTED *******//////
// Only test locally if no net is in operation //
/////////////////////////////////////////////////////////////////

// Test with single address
//$address = "1700 Lindberg Rd, Apt 126 West Lafayette IN 47906 7318";
//$koords = geocode($address);
//if($koords) {
//   echo("<br><br>$koords[0], $koords[1], $koords[2], $koords[3]");
//} else {
//   echo "Could not geocode address";
//}
?>