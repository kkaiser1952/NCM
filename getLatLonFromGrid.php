<?php
	define("MAX_LAT",   90);
	define("MIN_LAT",  -90);
	define("MAX_LON",  180);
	define("MIN_LON", -180);
	define("LAT_DISTANCE", 180);
	define("LON_DISTANCE", 360);
	
	function subdivisor() {
		$last = array(18, 10, 24, 10);
		$i = 0;
		return function () use (&$i, &$last) {
			if ($i >= count($last)) {
				$i = 2;
			}
			return $last[$i++];
		};
	}
	function parse_digit($digit) {
		$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$value = strpos($alphabet, $digit);
		if ($value == FALSE) {
			$value = floatval($digit);
		}
		return $value;
	}
	function get_grid_square($grid_square_id) {
		if (strlen($grid_square_id) % 2 != 0) {
			return array(null, null, null, null);
		}
		$grid_square_id = strtoupper($grid_square_id);
		$lat = floatval(MIN_LAT);
		$lon = floatval(MIN_LON);
		$lat_div = floatval(LAT_DISTANCE);
		$lon_div = floatval(LON_DISTANCE);
		$base_calculator = subdivisor();
		for ($base = $base_calculator(); strlen($grid_square_id) > 0; $base = $base_calculator()) {
			$lat_id = $grid_square_id[1];
			$lon_id = $grid_square_id[0];
			$lat_div /= $base;
			$lon_div /= $base;
			$lat += parse_digit($lat_id) * $lat_div;
			$lon += parse_digit($lon_id) * $lon_div;
			$grid_square_id = substr($grid_square_id, 2);
		}
		
		return array($lat, $lon, $lat_div, $lon_div);

	}
	
	//$lat = number_format((float)get_grid_square(EM29qe78pq)[0],5,'.','');
	//$lon = number_format((float)get_grid_square(EM29qe78pq)[1],5,'.','');
	
		//echo "$lat, $lon";
	
	//print_r( get_grid_square(EM29qe78pq));
?>

