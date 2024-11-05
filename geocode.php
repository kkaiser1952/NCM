<?php
// geocode.php
// function to geocode address using OpenStreetMap's Nominatim service
// function to geocode address, it will return false if unable to geocode address

require_once "dbConnectDtls.php";
require_once "ENV_SETUP.php";

function geocode($address){
   // Clean the address first
   $address = cleanAddress($address);
   
   // Add delay to prevent rate limiting (1 second)
   sleep(1);
   
   // url encode the cleaned address
   $address = urlencode($address);
   
   $url = "https://nominatim.openstreetmap.org/search?format=json&q={$address}&addressdetails=1";
   
   $opts = array(
       'http' => array(
           'header' => array("User-Agent: MyPHPApp/1.0")
       )
   );
   $context = stream_context_create($opts);
   
   $resp_json = file_get_contents($url, false, $context);
   $resp = json_decode($resp_json, true);
   
   if(!empty($resp) && isset($resp[0])) {
       // Format coordinates to 6 decimal places
       $lati = number_format((float)$resp[0]['lat'], 6);
       $longi = number_format((float)$resp[0]['lon'], 6);
       
       $state = '';
       $county = '';
       
       if(isset($resp[0]['address'])) {
           if(isset($resp[0]['address']['state'])) {
               $state = getStateAbbreviation($resp[0]['address']['state']);
           }
           
           if(isset($resp[0]['address']['county'])) {
               $county = $resp[0]['address']['county'];
               $county = str_replace(' County', '', $county);
           }
       }
       
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

function getStateAbbreviation($state_name) {
   $states = array(
       'Alabama' => 'AL', 'Alaska' => 'AK', 'Arizona' => 'AZ', 'Arkansas' => 'AR',
       'California' => 'CA', 'Colorado' => 'CO', 'Connecticut' => 'CT', 'Delaware' => 'DE',
       'Florida' => 'FL', 'Georgia' => 'GA', 'Hawaii' => 'HI', 'Idaho' => 'ID',
       'Illinois' => 'IL', 'Indiana' => 'IN', 'Iowa' => 'IA', 'Kansas' => 'KS',
       'Kentucky' => 'KY', 'Louisiana' => 'LA', 'Maine' => 'ME', 'Maryland' => 'MD',
       'Massachusetts' => 'MA', 'Michigan' => 'MI', 'Minnesota' => 'MN', 'Mississippi' => 'MS',
       'Missouri' => 'MO', 'Montana' => 'MT', 'Nebraska' => 'NE', 'Nevada' => 'NV',
       'New Hampshire' => 'NH', 'New Jersey' => 'NJ', 'New Mexico' => 'NM', 'New York' => 'NY',
       'North Carolina' => 'NC', 'North Dakota' => 'ND', 'Ohio' => 'OH', 'Oklahoma' => 'OK',
       'Oregon' => 'OR', 'Pennsylvania' => 'PA', 'Rhode Island' => 'RI', 'South Carolina' => 'SC',
       'South Dakota' => 'SD', 'Tennessee' => 'TN', 'Texas' => 'TX', 'Utah' => 'UT',
       'Vermont' => 'VT', 'Virginia' => 'VA', 'Washington' => 'WA', 'West Virginia' => 'WV',
       'Wisconsin' => 'WI', 'Wyoming' => 'WY'
   );
   
   return isset($states[$state_name]) ? $states[$state_name] : $state_name;
}

// Test with single address
$address = "1700 Lindberg Rd, Apt 126 West Lafayette IN 47906 7318";
$koords = geocode($address);
if($koords) {
   echo("<br><br>$koords[0], $koords[1], $koords[2], $koords[3]");
} else {
   echo "Could not geocode address";
}
?>