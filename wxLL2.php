<?php 
	// Written by: Jeremy Geeo
	// Written: 2018-04-06
	//
	// Replaces WXdisplay.php
	// Use: This program usese the National Weather Service API and the openweathermap API to display current weather information
	// based on the lat/lon of anyone who clicks the NWS icon
	// Modified by: WA0TJT on 2022-05-15
	
	//phpinfo();

require('config.php');

function doWeatherLLAPI( $url , $cache=300 ) {
		$cache_file = "/var/www/wx_cache/".sha1($url).".json";
		if ( file_exists( $cache_file ) && time()-filemtime( $cache_file ) < $cache )
			return json_decode(file_get_contents( $cache_file ));
		
		$curl = curl_init( $url );
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Accept: application/vnd.noaa.dwml+xml;version=1' ));
		curl_setopt($curl, CURLOPT_USERAGENT, 'net-control.us/1.0 kd0eav@clear-sky.net');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 7 );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		
		if ( !is_object( json_decode( $data ) ) ) 
		{
			file_put_contents( "/var/www/wx_cache/error_".time().rand() , "$url\n$data" );
			if ( file_exists( $cache_file ) )
				return json_decode(file_get_contents( $cache_file ));
			else
				return false;
		}
		
		file_put_contents( $cache_file , $data );
			
		return json_decode($data);
} 
    
function currentLLWX( $x, $y) { 	

		$lat = $x;
		$lon = $y;
				
		//echo "<!-- " ;

		// print_r( $geo );
		// // print_r( $stations );
		// print_r( $wx );

		//echo " -->";


		$current = $wx->features[0]->properties; 
		$obs['station'] = $stations->features[0]->id;
		$obs['temp'] = round( ($current->temperature->value * (9/5)) + 32 , 1 );  // Convert C to F degrees
		$obs['humidity'] = round( $current->relativeHumidity->value );
		$obs['desc'] = $current->textDescription;
		$obs['icon'] = $current->icon;
		$obs['windSpeed'] = round( $current->windSpeed->value * 2.2369 );

		$d = $current->windDirection->value;
		if ( $d > 348.75 || $d < 11.25 ) $obs['windDirection'] = 'N'; //N 348.75 - 11.25
		elseif ( $d > 326.25 ) $obs['windDirection'] = 'NNW'; 	//NNW 326.25 - 348.75
		elseif ( $d > 303.75 ) $obs['windDirection'] = 'NW'; 	//NW 303.75 - 326.25
		elseif ( $d > 281.25 ) $obs['windDirection'] = 'WNW'; 	//WNW 281.25 - 303.75
		elseif ( $d > 258.75 ) $obs['windDirection'] = 'W'; 	//W 258.75 - 281.25
		elseif ( $d > 236.25 ) $obs['windDirection'] = 'WSW'; 	//WSW 236.25 - 258.75
		elseif ( $d > 213.75 ) $obs['windDirection'] = 'SW'; 	//SW 213.75 - 236.25
		elseif ( $d > 191.25 ) $obs['windDirection'] = 'SSW'; 	//SSW 191.25 - 213.75
		elseif ( $d > 168.75 ) $obs['windDirection'] = 'S'; 	//S 168.75 - 191.25
		elseif ( $d > 146.25 ) $obs['windDirection'] = 'SSE'; 	//SSE 146.25 - 168.75
		elseif ( $d > 123.75 ) $obs['windDirection'] = 'SE'; 	//SE 123.75 - 146.25
		elseif ( $d > 101.25 ) $obs['windDirection'] = 'ESE'; 	//ESE 101.25 - 123.75
		elseif ( $d > 78.75 ) $obs['windDirection'] = 'E'; 		//E 78.75 - 101.25
		elseif ( $d > 56.25 ) $obs['windDirection'] = 'ENE';	//ENE 56.25 - 78.75
		elseif ( $d > 33.75 ) $obs['windDirection'] = 'NE';		//NE 33.75 - 56.25
		else $obs['windDirection'] = 'NNE';						//NNE 11.25 - 33.75
		
} // end currentLLWX()
	
function doWeatherLL2API( $url , $cache=300 ) {
		$cache_file = "/var/www/wx_cache/".sha1($url).".json";


//		echo "<!-- " ;

//		print_r( $cache_file );

//		echo " -->";


		if ( file_exists( $cache_file ) && time()-filemtime( $cache_file ) < $cache )
			return json_decode(file_get_contents( $cache_file ));
		
		$curl = curl_init( $url );
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Accept: application/vnd.noaa.dwml+xml;version=1' ));
		curl_setopt($curl, CURLOPT_USERAGENT, 'net-control.us/1.0 kd0eav@clear-sky.net');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 7 );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		
		if ( !is_object( json_decode( $data ) ) ) 
		{
			file_put_contents( "/var/www/wx_cache/error_".time().rand() , "$url\n$data" );
			if ( file_exists( $cache_file ) )
				return json_decode(file_get_contents( $cache_file ));
			else
				return false;
		}
		
		file_put_contents( $cache_file , $data );
			
		return json_decode($data);
} // End of doWeatherLL2API function
	
	
function getDirectionLL( $d ) {

	if ( $d > 348.75 || $d < 11.25 ) return 'N'; //N 348.75 - 11.25
	elseif ( $d > 326.25 ) return 'NNW'; 	//NNW 326.25 - 348.75
	elseif ( $d > 303.75 ) return 'NW'; 	//NW 303.75 - 326.25
	elseif ( $d > 281.25 ) return 'WNW'; 	//WNW 281.25 - 303.75
	elseif ( $d > 258.75 ) return 'W'; 	//W 258.75 - 281.25
	elseif ( $d > 236.25 ) return 'WSW'; 	//WSW 236.25 - 258.75
	elseif ( $d > 213.75 ) return 'SW'; 	//SW 213.75 - 236.25
	elseif ( $d > 191.25 ) return 'SSW'; 	//SSW 191.25 - 213.75
	elseif ( $d > 168.75 ) return 'S'; 	//S 168.75 - 191.25
	elseif ( $d > 146.25 ) return 'SSE'; 	//SSE 146.25 - 168.75
	elseif ( $d > 123.75 ) return 'SE'; 	//SE 123.75 - 146.25
	elseif ( $d > 101.25 ) return 'ESE'; 	//ESE 101.25 - 123.75
	elseif ( $d > 78.75 ) return 'E'; 		//E 78.75 - 101.25
	elseif ( $d > 56.25 ) return 'ENE';	//ENE 56.25 - 78.75
	elseif ( $d > 33.75 ) return 'NE';		//NE 33.75 - 56.25
	else return 'NNE';						//NNE 11.25 - 33.75
} // End getDirectionLL function


function getOpenLLWX($x, $y) {
	
	//echo "$x, $y";
	
	$lat = $x;
	$lon = $y;

	$wx = getOpenWeatherLLAPI( $lat , $lon );
	
	$points = doWeatherLLAPI( "https://api.weather.gov/points/{$lat},{$lon}" , 86400 );
	//print_r($points);
	$obs['city']          = $points->properties->relativeLocation->properties->city;
    $obs['state']         = $points->properties->relativeLocation->properties->state;
    $obs['county']        = $points->properties->county;
    // [county] => https://api.weather.gov/zones/county/MOC165
    
    //echo "{$obs['county']}";

	//$loc = $wx->name;
	$obs['temp']          = round( $wx->main->temp );
	$obs['humidity']      = round( $wx->main->humidity );
	$obs['desc']          = $wx->weather[0]->main;
	$obs['icon']          = $wx->weather[0]->icon;
	$obs['windSpeed']     = round( $wx->wind->speed );
	$obs['windDirection'] = getDirectionLL( $wx->wind->direction );
	
	$county = doWeatherLLAPI( "{$obs['county']}", 86400 );
	//print_r($county);
	$obs['co'] = $county->properties->name;
	

	return "{$obs['co']} Co., {$obs['state']}: {$obs['desc']}, {$obs['temp']}F, wind: {$obs['windDirection']} @ {$obs['windSpeed']}, humidity: {$obs['humidity']}%";
} // End getOpenLLWX function

function getOpenWeatherLLAPI( $lat , $lon ) {

	$url = "https://api.openweathermap.org/data/2.5/weather?units=imperial&lat=$lat&lon=$lon&appid=".$GLOBALS['_API_OPEN_WXMAP_APPID'];
	
	//echo "$url";
	// https://api.openweathermap.org/data/2.5/weather?units=imperial&lat=39.202903&lon=-94.602907&appid=

	$cache_file = "/var/www/wx_cache/owm_".sha1($url).".json";

	if ( file_exists( $cache_file ) && time()-filemtime( $cache_file ) < $cache )
	return json_decode(file_get_contents( $cache_file ));

	$curl = curl_init( $url );
	curl_setopt($curl, CURLOPT_PORT, 443);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Accept: application/vnd.noaa.dwml+xml;version=1' ));
	curl_setopt($curl, CURLOPT_USERAGENT, 'net-control.us/1.0 kd0eav@clear-sky.net');
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 7 );
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);

	if ( !is_object( json_decode( $data ) ) ) 
	{
		file_put_contents( "/var/www/wx_cache/error_".time().rand() , "$url\n$data" );
		if ( file_exists( $cache_file ) )
			return json_decode(file_get_contents( $cache_file ));
		else
			return false;
	}

	file_put_contents( $cache_file , $data );
		
	return json_decode($data);
} // End getOpenWeatherLLAPI function

    // Examples:
	//echo getOpenLLWX(39.202903, -94.602907); 

?>
