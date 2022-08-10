<?php 
	// Written by: Jeremy Geeo
	// Written: 2018-04-06
	// This version by: Keith Kaiser
	// Written: 2022-05-13
	//
	// Replaces WXdisplay.php
	// Use: This program usese the National Weather Service API to display current weather information
	// based on the IP address of anyone who opens the NCM. The IP is changed to a lat/lon combination
	// to drive the API.
	
	//phpinfo();  // get php version etc.
    
    // The currentLLWX() call with lat/lon is at the bottom

require('config.php');


    
	function currentLLWX($x, $y) {
    	
    	$lat = $x; $lon = $y;
    	
    	//echo "\n @20 in wxLL.php coords: $lat,$lon \n\n<br>";
		
		/* 
    		Need to get the gridID, gridX and gridy from this https
    		And from properties in it get city, state and maybe radarStation 
    		https://api.weather.gov/points/39.202903,-94.602907
    		
    		Then read those values and build
    		https://api.weather.gov/gridpoints/EAX/42,54/forecast	
    		Read periods where number is 1
    		Get temperature, temperatureUnit, windSpeed, windDirection, shortForecast 
    		and maybe the detailedForecast to use as a link if shortForecast is clicked.
    		
    		Create:
    		Kansas City, clear, 90F, wind: S @41, humidty: 79%
    		*/

		// This echo uses whats retrieved from above
		
		// 86400 is seconds in 24 hours

		$points = doWeatherLLAPI( "https://api.weather.gov/points/{$lat},{$lon}" , 86400 );
		//echo " \n\n points:\n";
		//print_r($points);
		
		if ( $points === false ) return false;
		
		$stations = doWeatherLLAPI( $points->properties->observationStations , 86400 );
		    //$obs['loc'] = $stations->features[0]->properties->name;
		    //echo "$obs[loc]";
		    //echo "\nx\n";
		//echo "\n\nstations:\n";  
		//print_r($stations);
		if ( $stations === false ) return false;
		
		$wx = doWeatherLLAPI( $stations->features[0]->id.'/observations' );
		//echo "\n\nwx:\n";
		//print_r($wx);
		if ( $wx === false ) return false;
		
		$current = $wx->features[0]->properties; 
		//echo "\n\ncurrent:\n";
		//print_r($current);
		
		$obs['station']   = $stations->features[0]->id; 
        $obs['city']      = $points->properties->relativeLocation->properties->city;
        $obs['state']     = $points->properties->relativeLocation->properties->state;

		$obs['temp']      = round( ($current->temperature->value * (9/5)) + 32 , 1 );  // Convert C to F degrees
		$obs['humidity']  = round( $current->relativeHumidity->value );
		$obs['desc']      = $current->textDescription;
		
		$obs['icon']      = $current->icon;
		$obs['windSpeed'] = round( $current->windSpeed->value * 2.2369 );
		
		//echo "values:\n$obs[city] \n $obs[state] \n $obs[station] \n $obs[temp] \n $obs[humidity] \n $obs[desc] \n $obs[icon] \n $obs[windSpeed] \n\n";

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
		

        return "{$obs['city']}, {$obs['state']}, {$obs['desc']}, {$obs['temp']}F, wind: {$obs['windDirection']} @ {$obs['windSpeed']}, humidity: {$obs['humidity']}% ";

	} // End currentLLWX
	
	function doWeatherLLAPI( $url , $cache=300 )
	{
    	
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
	
	/*
	function getGeoLLIP( $ip=false )
	{
		if ( $ip === false )
		{
			if ( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else $ip = $_SERVER['REMOTE_ADDR'];
		}

		if ( $ip == '108.61.195.124' ) return false;

		$cache_file = "/var/www/wx_cache/geo_{$ip}.json";
		if ( file_exists( $cache_file ) && time()-filemtime( $cache_file ) < 86400 )
			return json_decode(file_get_contents( $cache_file ));
		
		$curl = curl_init( "http://extreme-ip-lookup.com/json/{$ip}?key=".$GLOBALS['_API_EXTREME_IP_KEY'] );
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, 'net-control.us/1.0 kd0eav@clear-sky.net');
		$data = curl_exec($curl);
		if ( strlen( $data ) > 0 )
			file_put_contents( $cache_file , $data );
			
		return json_decode($data);
	} */
	
	/* don't need this here its already in wx.php
	function distance( $lat1 , $lon1 , $lat2 , $lon2 )
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		return rad2deg($dist)*60;
	} */
	
	//echo currentLLWX(39.2028965, -94.602976); // Kansas City, MO
	//echo "\n";
	//echo currentLLWX(38.9683231, -95.283432); // Lawrence, KS

?>
