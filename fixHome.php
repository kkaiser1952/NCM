<?php

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */


// NOT working yet 

// What it should do
// 1) make sure home is correctly formated with the correct data
// 2) 

// home: 39.149499,-94.557956,EM29RD,Clay ,MO

SET @needle = ',';
$sql = "SELECT recordID, id, Fname, Lname,  grid, creds, email, latitude, longitude, 
    		   tactical, district, tt, home
               ,SUBSTRING_INDEX(home, ',', -1) as state
               ,SUBSTRING_INDEX(SUBSTRING_INDEX(home, ',', -2),',',1) as county
               ,CHAR_LENGTH(home) - CHAR_LENGTH(REPLACE(home, @needle, SPACE(LENGTH(@needle)-1))) AS `Commacount`
    	  FROM NetLog 
    	 WHERE CHAR_LENGTH(home) - CHAR_LENGTH(REPLACE(home, @needle, SPACE(LENGTH(@needle)-1))) = 2
    	 ORDER BY netID DESC
    	 
    	 
    SET @needle = ',';
    	UPDATE NetLog SET
    	    home = CONCAT(latitude,',',longitude,',',grid,',',county,',',state)
    	  WHERE CHAR_LENGTH(home) - CHAR_LENGTH(REPLACE(home, @needle, SPACE(LENGTH(@needle)-1))) = 2;
    	 
";
	 
	 SET @needle = ',';
SELECT *
    	  FROM NetLog 
         WHERE CHAR_LENGTH(home) - CHAR_LENGTH(REPLACE(home, @needle, SPACE(LENGTH(@needle)-1))) = 2
    	 ORDER BY netID DESC 
;
	

		
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