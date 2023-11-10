<?php
error_reporting( 0 );
	//date_default_timezone_set("America/Chicago");
	//require_once "dbConnectDtls.php";     
    
   // $q = $_GET["q"];    
	
// =========================================================================================
// Now lets get the nearest cross roads, 
// http://www.geonames.org/maps/osm-reverse-geocoder.html
// =========================================================================================

function getCrossRoads($lat, $lng) {
   // echo "$lat $lng";
   
   // This disables the SSL certificate verification and allows CURL to make the request without checking the certificate validity. So dont use it in production.
   //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $curl = curl_init();
    
// http://www.geonames.org/maps/osm-reverse-geocoder.html

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.geonames.org/findNearestIntersectionJSON?lat=$lat&lng=$lng&radius=1&username=ncm_wa0tjt",
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));
    
    $response = curl_exec($curl);
       // echo "GeoNames CURL Response= $response<br>";
    $err = curl_error($curl);
        //echo "GeoNames CURL Error Response= $err<br><br>";
    
    curl_close($curl);
    
    if ($err) {
      echo "CURL Error #:" . $err;
    
    } else { // no curl error
      
        $crc = json_decode($response, true);
        
           $street1  = $crc['intersection']['street1']; 
           $street2  = $crc['intersection']['street2'];     
           
           $CrossRoads = "$street1 &amp; $street2";
           
           //return "$street1 &amp; $street2";
           
           //echo "$CrossRoads";
           return $CrossRoads;
           
          // return "$street1 &amp; $street2";
            
    } // end else	
};  // End function
//echo getCrossRoads(39.203, -094.604);
//getCrossRoads(.203, -094.604);
?>
