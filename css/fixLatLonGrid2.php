<?php
    
// Use this program to fill in location information 
// Written: 2020-10-09 to fill in lat/lon/grid for about 20 stations

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

$sql = "
SELECT ncm.id, ncm.callsign, 	  
	   CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) as address
  FROM ncm.NetLog ncm
      ,fcc_amateur.en fcc
 WHERE ncm.netID > 2500 AND ncm.netID < 2804
   AND ncm.latitude = ''
   AND ncm.grid = ''
   AND ncm.callsign = fcc.callsign
 /*  AND ncm.netID IN(2827,2824,2820, 2804 ) */
   
 GROUP BY ncm.callsign

";
		
foreach($db_found->query($sql) as $row) {
	 
	$address = $row[address];
	 
	$koords  = geocode("$address");
		$latitude  = $koords[0];
		$longitude = $koords[1];
	
		$county	   = $koords[2];
		$state	   = $koords[3];
			if ($state == '') {
				$state = $row[state];
			}
		$gridd 	   = gridsquare($latitude, $longitude);
		$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]"; 
	

echo "
	$row[id],
	$row[callsign], $Fname, $Lname, $latitude, $longitude, $grid, $address,
	$county, $state, $grid
	<br>
"; 

$sql2 = "UPDATE NetLog SET latitude = $latitude, longitude = $longitude, grid = '$grid'
           WHERE id = $row[id] 
             AND grid = ''
";
echo("<br><br>$sql2");

$db_found->exec($sql2); 

}

?>