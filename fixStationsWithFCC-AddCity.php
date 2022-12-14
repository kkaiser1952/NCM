<?php
    
// fixStationsWithFCC-AddCity.php
// Use this program to compare NCM.stations with fcc_amateur.en and to 
// update NCM.stations when there is a difference
// Written: 2022-12-13 as an update to fixStationsWithFCC.php 

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

$sql = "
SELECT a.fccid, a.full_name,
	   a.first, a.middle, a.last,
       a.address1, a.city, a.state, 
       a.zip, a.callsign,
       CONCAT_WS(' ', a.address1, a.city, a.state, a.zip) as address
  FROM fcc_amateur.en a
   
 INNER JOIN (
    SELECT a.callsign, MAX(a.fccid) fccid, c.callsign as ccall
      FROM fcc_amateur.en a
     GROUP BY a.callsign ) b
        ON a.callsign = b.callsign 
       AND a.fccid = b.fccid
       AND callsign = 'wa0tjt'
    /*   AND LEFT(b.callsign, 3) = 'wz1' */
";

echo "$sql"; 

$count = 0;		
foreach($db_found->query($sql) as $row) {
$count++;

	$address = $row[address];
	$city    = $row[city];
	$fccid   = $row[fccid];
	 
	$koords  = geocode("$address");
	
	//echo "<br>4: $koords[4];";
		$latitude  = $koords[0];
		$longitude = $koords[1];
	
		$county	   = $koords[2];
		$state	   = $koords[3];
			if ($state == '') {
				$state = $row[state];
			}

		$gridd 	   = gridsquare($latitude, $longitude);
		$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]"; 

//echo "<br><br>count: $count";
echo "<br><br>$count ==> $row[callsign]: $fccid, $address, $county, $state, $city";

//UPDATE stations SET latlng = GeomFromText(POINT(39.791869,-93.549968)) WHERE callsign = 'kf0evg';

// to update all the latlng values do this
// UPDATE stations SET latlng = GeomFromText(CONCAT('POINT(',latitude,' ',longitude,')'));

// to update only one latlng value tod this
// UPDATE stations SET latlng = POINT(latitude, longitude) WHERE id = 'xxxxxxx';

$sql2 = "UPDATE stations SET Fname      = \"$row[first]\" ,
             Lname      = \"$row[last]\" ,
             grid       = '$grid' ,
             county     = '$county' ,
             state      = '$state' ,
             city       = '$city' ,
             home       = '$latitude,$longitude,$grid,$county,$state,$city' ,
             fccid      = $row[fccid] ,
             dttm       = NOW() ,
             latitude   = $latitude , 
             longitude  = $longitude ,
             latlng     = GeomFromText('POINT($latitude $longitude)')    
          WHERE id = $row[callsign];         
";


echo("<br><br>$sql2");

// uncomment below to do the update
//$db_found->exec($sql2); 


} // End foreach
//echo "<br><br>Done --> Count= $count";
?>