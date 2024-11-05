<?php
// function to geocode address, it will return false if unable to geocode address
require_once "dbConnectDtls.php";
require_once "ENV_SETUP.php";

function geocode($address){
    
    // Specify the exact path for the log file
    $log_path = '/var/www/html/geocode_debug.log';
    
    // Test if we can write to the directory
    if (!is_writable('/var/www/html/')) {
        error_log("Directory not writable: /var/www/html/");
        // Continue with function but log to system error log
    }
    
    // Add timestamp and start logging
    $timestamp = date('[Y-m-d H:i:s] ');
    error_log($timestamp . "Starting geocode for address: $address\n", 3, $log_path);
    
 
    // url encode the address
    $address = urlencode($address); //echo "$address";
    
    $google_api_key = getenv('GOOGLE_MAPS_API_KEY'); 
     
    // google map geocode api url
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$google_api_key}";
    
    // Log the constructed URL (maybe remove in production for security)
    error_log(date('[Y-m-d H:i:s] ') . "API URL: $url\n", 3, $log_file);
    
     
    // get the json response
    $resp_json = file_get_contents($url);
    
    error_log($timestamp . "Response received\n", 3, $log_path);
    
    $resp = json_decode($resp_json, true);
    
     
    // decode the json
    $resp = json_decode($resp_json, true);
    
    //var_dump($resp);
   
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];
        
		// Routine to find the County name
        foreach ($resp['results'][0]['address_components'] as $comp) {
		//loop through each component in ['address_components']
			foreach ($comp['types'] as $currType){
			//for every type in the current component, check if it = the check
				if($currType == 'administrative_area_level_2'){
					//echo $comp['long_name'];
					$county = $comp['long_name'];
					$county = str_replace('County','',$county);
        		}
			}
        }        
        
        // Routine to find the State code
        foreach ($resp['results'][0]['address_components'] as $comp) {
		//loop through each component in ['address_components']
			foreach ($comp['types'] as $currType){
			//for every type in the current component, check if it = the check
				if($currType == 'administrative_area_level_1'){
					//echo $comp['long_name'];
					$state = $comp['short_name'];
        		}
			}
        }
        
        $formatted_address = $resp['results'][0]['formatted_address'];
         
        // verify if data is complete
        if($lati && $longi && $formatted_address){
         
            // put the data in the array
            
            $koords = array();            
             
            array_push(
                $koords, 
                $lati, 
                $longi,
                $county,
                $state
                    /*
                    , 
                    $formatted_address */
                );
            // print_r($koords); // Array ( [0] => 39.2029101 [1] => -94.6028748 [2] => Platte [3] => MO )
             				   // Array ( [0] => 44.9596871 [1] => -93.2895616 [2] => Hennepin [3] => MN ) 
            return $koords;             
        }else{
            return false;
        }
         
    }else{
        return false;
    }
}

//$address = "16640 Tara Rd. Lincoln Ar";

//$address = "2310 Aldrich Ave S Apt 110 Minneapolis MN 55405";
$address = "6024 N Ames Kansas City MO 64151";
//$address = '333 RASPBERRY LN MONUMENT CO 80132';
//$address = '73 Summit Avenue NE Swisher IA 52338';


//$address = '39.503,-93.602';
//$address = '64154';  zip code works

$koords = geocode("$address");
echo("<br><br>$koords[0], $koords[1], $koords[2], $koords[3]");

?>
