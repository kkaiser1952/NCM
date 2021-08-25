<!doctype html>
<?php
    
    // This program fixes one callsign in the stations table at a time.  //
    // Use if callsign once had no FCC callsign and now does or us it to //
    // fix a callsign. //
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "geocode.php";  
    require_once "GridSquare.php";
    
    $call  = "WA0TJT";
    
$sql = ("
SELECT  fcc.fccid, 
		ncm.callsign,
		ncm.county as ncm_county,
		ncm.district as ncm_district,
		ncm.grid as ncm_grid,
		ncm.latitude as ncm_latitude,
		ncm.longitude as ncm_longitude,
		ncm.grid as ncm_grid,
        fcc.first, 
        fcc.last,
        fcc.state,
        ncm.state as ncm_state,
        fcc.city,
        fcc.address1,
        fcc.zip,
		CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) as fulladdress,
		ncm.fulladdress as ncm_fulladdress
  FROM fcc_amateur.en fcc
	  ,ncm.stations ncm
 WHERE fcc.callsign = '$call'
   AND ncm.callsign = fcc.callsign
");

//echo $sql;

foreach($db_found->query($sql) as $row) {
	 
	$address = "$row[fulladdress]";
	 
	$koords  = geocode("$address");
		$latitude  = $koords[0];
		$longitude = $koords[1];
	
		$county	   = $koords[2];
		$state	   = $koords[3];

		$gridd 	   = gridsquare($latitude, $longitude);
		$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]"; 
		
    $fixrequests .= "$row[netID], $row[recordID], $row[callsign], $row[Fname], $row[Lname], $address, $county, $row[state]<br>";
		
    $query .= "UPDATE ncm.stations SET  
                    comment   = '',
                    county    = TRIM('$county'), 
                    state     = TRIM('$row[state]'),
                    grid      = TRIM('$grid'),
                    latitude  = '$latitude', 
                    longitude = '$longitude', 
                    tactical  = RIGHT('$call',3),
                    home      = CONCAT('$latitude',',','$longitude',',','$grid',',','$county',',','$row[state]'),
                    latlng    = GeomFromText(CONCAT('POINT (', '$latitude', ' ', '$longitude', ')')),
                    
                    district  = (SELECT district FROM ncm.HPD WHERE state = '$row[state]' AND county = '$county')
                    
                WHERE callsign = '$call' ; "
                  AND ($state <> $row[ncm_state] OR $county <> $row[ncm_county] OR $latitude <> $row[latitude] OR $longitude <> $row[longitude] OR $grid <> $row[ncm_grid]
                      )
}


echo "<br><br>The BIG Query<br>".$sql."<br><br>";

echo "THE UPDATE Query<br>".$query;

?>