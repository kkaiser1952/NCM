<?php
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*:: Use this to create the data necessary for the spoke-hub chart           :*/
/*::  https://geodatasource.com/developers/php                               :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::                                                                         :*/
/*:: Bearing calculation at;                                                 :*/
/*:: https://www.dougv.com/2009/07/calculating-the-bearing-and-compass-rose-direction-between-two-latitude-longitude-coordinates-in-php/                                                      :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}

/*
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
*/


$hublat = 0;
$hublon = 0;
$hub = 'WA0TJT';  // Must be upper case
$netID   = 1454;


$sql = "SELECT callsign, latitude, longitude
           /* ,callsign as hubcall, latitude as hublat, longitude as hublon */
         FROM NetLog 
        WHERE netID = $netID
        ORDER BY latitude, longitude
       ";
        
// echo "$sql<br><br>";

// lon2 = longitude;
// lon1 = hublon;
// lat2 = latitude;
// lat1 = hublat;

/*echo ("<table> <tr><td>Call Sign</td>
                 <td>Distance<br>Miles</td>
                 <td>bearing<br>Degrees</td></tr>");
*/
/* This foreach needs to be seperate from below in order to create hublat, hublon across all other variables. */
/* If you try to combine it with the one below, they do not get created for any callsign above the hubcall by */
/* the SQL.                                                                                                   */
foreach($db_found->query($sql) as $row) {
    if($row[callsign] == $hub) {
        $hublat = $row[latitude];
        $hublon = $row[longitude];
    } //else {}
}

foreach($db_found->query($sql) as $row) {

    $distance = round(distance($hublat, $hublon, $row[latitude], $row[longitude], 'M'),1);
    
    $bearing =     (rad2deg(atan2(sin(deg2rad($row[longitude]) - 
                    deg2rad($hublon))  * 
                cos(deg2rad($row[latitude])), 
                cos(deg2rad($hublat))  * 
                sin(deg2rad($row[latitude]))- 
                sin(deg2rad($hublat))  * 
                cos(deg2rad($row[latitude]))* 
                cos(deg2rad($row[longitude])- 
                    deg2rad($hublon)))) + 360) % 360;
                    
// Output for use by polarChart.html 
echo ('{"label":');
echo ("'$row[callsign] ($distance)' },<br>");
                    
// Output as part of a table
//echo ("<tr><td>$row[callsign]</td><td>$distance</td><td>$bearing</td>");
//echo ("<td>$row[hubcall]</td><td>$row[hublat]</td><td>$row[hublon]</td>");
//echo ("</tr>");

} 

foreach($db_found->query($sql) as $row) {
     $distance = round(distance($hublat, $hublon, $row[latitude], $row[longitude], 'M'),1);
     
echo ('{"value":');
echo ("$distance },<br>");
}
// {"value": 176.4},
//echo ("</table>");

?>