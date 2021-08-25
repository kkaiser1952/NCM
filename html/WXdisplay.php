<?php
	//This function gets the IP address of the user
	//http://itman.in/en/how-to-get-client-ip-address-in-php/
function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
//echo getRealIpAddr();
		// This function builds the weather display using the above IP address
		// https://www.wunderground.com/weather/api/d/docs?d=data/conditions&MR=1
function WXdisplay($use,$user_ip) {
	 // $json_string = file_get_contents("http://api.wunderground.com/api/bf697a18d3f01c48/geolookup/conditions/q/$state/$city.json");
	
	//function WXdisplay($user_ip,$use)
	
	
	// BLACKLISTED IP addresses -- just leave instead of getting WX data
	switch( $user_ip )
	{
		case '108.61.195.124':
		//case '99.198.173.31':
			return;
	}
	
	// Cache WU response for 15 minutes (900 seconds)
	$cache_file = "/var/www/wx_cache/{$user_ip}.json";
	if ( file_exists( $cache_file ) && time()-filemtime( $cache_file ) < 900 )
	{
		$json_string = file_get_contents( $cache_file );
	} else {
		$json_string = file_get_contents("http://api.wunderground.com/api/aeaa0003367cc605/geolookup/conditions/q/autoip.json?geo_ip=$user_ip ");
		file_put_contents( $cache_file , $json_string );
	}
	 // echo "$use <br>";
	  
	  $parsed_json = json_decode($json_string);
	  $location = $parsed_json->{'location'}->{'city'};
	  $temp_f 	= $parsed_json->{'current_observation'}->{'temp_f'};
	  $wind   	= $parsed_json->{'current_observation'}->{'wind_mph'};
	  $wind_dir	= $parsed_json->{'current_observation'}->{'wind_dir'};
	  $wx   	= $parsed_json->{'current_observation'}->{'weather'};
	  $humid  	= $parsed_json->{'current_observation'}->{'relative_humidity'};
	  
	  if ("$use" == 1) {
		  $wxNOW = "$location: $wx, $temp_f, wind: $wind_dir @ $wind, humidity: $humid";
		  return $wxNOW;
		  //echo "$wxNOW";
	  } else {
	  		echo "
	  			<span class=\"weather-place\"  oncontextmenu=\"defaultMode();return false;\">
	  			<img src=\"images/wundergroundLogo_4c.png\" alt=\"wundergroundLogo_4c\" width=\"40\" /><a href=\"https://www.wunderground.com/?apiref=a8092edcfa49acfb\" target=\"_blank\">
	  			${location}: ${wx}, ${temp_f} F,  wind: ${wind_dir} @ ${wind}mph, humidity: ${humid} \n
	  			</a></span>";
	  }
}
?>
