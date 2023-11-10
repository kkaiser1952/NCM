<?php 
	// Written by: Jeremy Geeo
	// Written: 2018-04-06
	//
	// Replaces WXdisplay.php
	// Use: This program usese the National Weather Service API to display current weather information
	// based on the IP address of anyone who opens the NCM. The IP is changed to a lat/lon combination
	// to drive the API.
	// Or if a users clicks the NWS icon, and enters a callsign the lat/lon information is 
	// looked up in the stations table and used to find the current wx conditions.
	
	//phpinfo();
	
    //$token = '136.32.223.249';

require('config.php');


	function currentWX( $token=false ) {
    	echo "\n\n <br><br> @17 In wx2.php the currentWX function \n\n";
    	//echo "\n@18 in currentWX() token= $token \n\n";
    	$broken = explode(",", $token);
    	    
    	    $callsign = $broken[0];
    	    
    	    $lat      = $broken[1];
    	    $lon      = $broken[2];
    	    
    	    //echo "\n OK @26 $callsign $lat $lon \n";           
    	
	   // if (is_numeric(ip2long($lat))) { // is a float, double, or integer
        if ($lon == '') { // This means an I.P. has been passed as the token
    	    //echo "\n@35 this means token is an IP= $token of type= gettype($longv);\n";
    	    $ip = $callsign;
    	    
            	    $geo = getGeoIP( $ip );
        		if ( $geo->countryCode != 'US' ) return false;
        
                // Get lat & lon from getGeoIP instead of stations
        		$lat = $geo->lat;
        		$lon = $geo->lon;
        		
        		if ( $geo->city != '' ) $loc = $geo->city;
        		elseif ( $geo->region != '' ) $loc = $geo->region;
        		else $loc = $geo->country;
        		
        		echo "<br> @44 $lat $lon $loc <br><br>";
        		
        		
	    } else { // Thise means a new callsign was used to make token
    	    // Need the else to not do things
    	    //echo "\n@51 this is the else for token = $token \n";
    	        //$splode = explode(",", $coords);
    	        
    	        //$lat = $splode[0]; 
    	        //$lon = $splode[1];
    	        
    	       // echo "\n@57 next else step, lat= $lat and lon= $lon \n";
    	}
    	
		//echo "\n OK @58 $lat,$lon\n";

		$points = doWeatherAPI( "https://api.weather.gov/points/{$lat},{$lon}" , 86400 );
		
		if ( $points === false ) return false;
		
		//echo "\n@64 $lat  $lon \n";
		
		$stations = doWeatherAPI( $points->properties->observationStations , 86400 );
        print_r($stations);
		if ( $stations === false ) return false;
		
	//	echo "\n@72 $lat  $lon";
		
		$wx = doWeatherAPI( $stations->features[0]->id.'/observations' );
   echo "$wx";
		if ( $wx === false ) return false;
		
		$current = $wx->features[0]->properties; 
		
		$obs['station']   = $stations->features[0]->id;
		$obs['temp']      = round( ($current->temperature->value * (9/5)) + 32 , 1 );  // Convert C to F degrees
		$obs['humidity']  = round( $current->relativeHumidity->value );
		$obs['desc']      = $current->textDescription;
		$obs['icon']      = $current->icon;
		$obs['windSpeed'] = round( $current->windSpeed->value * 2.2369 );
		
		echo "\n@87 temp: $obs[station] $obs[temp] $obs[humidity] $obs[desc] $obs[icon] $obs[windSpeed]";

		$d = $current->windDirection->value; echo "\n @87 wind dir: $d \n";
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
		
		
		echo "@106 {$loc}: {$obs['desc']}, {$obs['temp']}F, wind: {$obs['windDirection']} @ {$obs['windSpeed']}, humidity: {$obs['humidity']}%";

		return "{$loc}: {$obs['desc']}, {$obs['temp']}F, wind: {$obs['windDirection']} @ {$obs['windSpeed']}, humidity: {$obs['humidity']}%";
		
		echo "@110 curWX;<br>$curWX";
	//	echo "{$loc}: {$obs['desc']}, {$obs['temp']}F, wind: {$obs['windDirection']} @ {$obs['windSpeed']}, humidity: {$obs['humidity']}%";
		
		//Kansas City: Mostly Cloudy, 37.4, wind: West @ 13, humidity: 65%
		echo "@113 current below\n";
		print_r( $current );
	}
	
	
	  
	  
	function doWeatherAPI( $url , $cache=300 ) {
    	echo "<br> @122 Now in doWeatherAPI function<br>";
	    echo "<br> OK @123 $url <br>";

		$cache_file = "/var/www/wx_cache/".sha1($url).".json";
		
		echo "<br> @127 cache_file= $cache_file <br><br>";
		
		
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
	
	function getGeoIP( $ip=false )
	{
		if ( $ip === false ) {
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
	}
	
	function distance( $lat1 , $lon1 , $lat2 , $lon2 )
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		return rad2deg($dist)*60;
	}
	
	//echo currentWX(); 

?>
