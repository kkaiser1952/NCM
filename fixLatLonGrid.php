<?php

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

$sql = "
SELECT ncm.id, ncm.callsign, ncm.Fname, ncm.Lname, ncm.latitude, ncm.longitude, ncm.grid, fcc.last,
	   CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) as address
  FROM ncm.NetLog ncm
      ,fcc_amateur.en fcc
 WHERE ncm.latitude = ''
   AND ncm.callsign = fcc.callsign
   AND ncm.callsign <> 'W0KCN'
   AND ncm.callsign <> 'KC0NWS'
   AND ncm.callsign <> 'W0RR'
   AND ncm.callsign <> 'NR0AD'
   AND ncm.callsign <> 'WA0QFJ'
   AND ncm.callsign <> 'WA0NQA'
   AND ncm.callsign <> 'WA0FQL'
   AND ncm.callsign <> ''
 GROUP BY ncm.callsign
   
";
		
foreach($db_found->query($sql) as $row) {
	
	 // fix last name
	 if ($row[Lname] == '') {$Lname = $row[last];}
	// else {$Lname = $row[Lname];} 
	
	$Lname = ucfirst(strtolower($row[Lname]));
	$Fname = ucfirst(strtolower($row[Fname]));
	 
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

}

?>