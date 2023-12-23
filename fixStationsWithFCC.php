<?php
    
// Use this program to compare NCM.stations with fcc_amateur.en and to 
// update NCM.stations when there is a difference
// Written: 2021-09-13 

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

$sql = "
SELECT n.callsign as callsign, 
       n.id, 
       n.Fname, 
       n.Lname,
       n.fccid as ncmfccid,
       n.state as ncmstate,
       f.callsign as fcccallsign,     
       f.fccid as fccfccid,
       f.state as fccstate,
       f.first as first,
       f.last  as last,
       f.city  as city,
       (SELECT MAX(fccid) FROM fcc_amateur.en WHERE callsign = n.callsign) as maxfccid,        
       CONCAT_WS(' ', f.address1, f.city, f.state, f.zip) as address
  FROM ncm.stations n
      ,fcc_amateur.en f
 WHERE n.callsign = f.callsign
  AND (SELECT MAX(fccid) FROM fcc_amateur.en WHERE callsign = n.callsign) 
  AND f.fccid > n.fccid 
  AND n.id < 38000
ORDER BY `n`.`callsign` ASC
LIMIT 500
";

//echo "$sql"; 


$count = 0;		
foreach($db_found->query($sql) as $row) {
$count++;

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

//echo "<br>$count";
// Removed latlng 2023-12-22
$sql2 = "UPDATE stations SET Fname      = \"$row[first]\" ,
                             Lname      = \"$row[last]\" ,
                             grid       = '$grid' ,
                             county     = '$county' ,
                             state      = '$state' ,
                             home       = '$latitude,$longitude,$grid,$county,$state' ,
                             fccid      = $row[fccfccid] ,
                             dttm       = NOW() ,
                             latitude   = $latitude , 
                             longitude  = $longitude     
          WHERE id = $row[id];         
";


echo("<br><br>$sql2");


//$db_found->exec($sql2); 


} // End foreach
echo "<br><br>Done --> Count= $count";
?>