<!doctype html>
<?php
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "geocode.php";  
    require_once "GridSquare.php";
    
    $netID = 3605;
    
/* This program updates the following fields in the stations table */
/* fccid Fname, Lname, county, state, grid, latitude, longitude, emial, creds, home, latlng */

/* Select records with possible issues */
$sql = ("
SELECT  fcc.fccid
	   ,log.netID
       ,log.ID
       ,log.callsign
       ,ncm.home
       
       ,SUBSTRING_INDEX(log.callsign, IF(LOCATE('/', log.callsign), '/', '-'), 1) AS b4Delim
       
       ,    CASE
            	WHEN (ncm.Fname IS NULL OR ncm.Fname = ' ') AND log.Fname <> ' ' THEN log.Fname 
            	WHEN (log.Fname = '' or log.Fname IS NULL) THEN fcc.first 
            	WHEN log.Fname <> ncm.Fname THEN log.Fname
                ELSE fcc.first
            END as Fname
       ,    CASE
                WHEN (ncm.Lname IS NULL OR ncm.Lname = ' ') AND log.Lname <> ' ' THEN log.Lname 
            	WHEN (log.Lname = '' or log.Lname IS NULL) THEN fcc.last 
            	WHEN log.Lname <> ncm.Lname THEN log.Lname
                ELSE fcc.last
            END as Lname
       ,    CASE
            	WHEN ncm.state IS NULL OR ncm.state = ' ' OR ncm.state <> fcc.state THEN fcc.state
                ELSE ncm.state
            END as state
       ,    CASE
            	WHEN (ncm.email IS NULL OR ncm.email = ' ' OR ncm.email <> log.email) 
                 AND log.email <> ' ' THEN log.email
            END as email
       ,    CASE
            	WHEN (ncm.creds IS NULL OR ncm.creds = ' ' OR ncm.creds <> log.creds) 
                 AND log.creds <> ' ' THEN log.creds
            END as creds
                        
       ,    CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) as fulladdress
   FROM fcc_amateur.en  fcc
       ,ncm.stations    ncm 
       ,ncm.NetLog      log
  WHERE log.netId = $netID
    AND fcc.callsign = substring_index(log.callsign, '/', 1)
    AND fcc.fccid = (SELECT MAX(fcc.fccid) FROM fcc_amateur.en fcc WHERE fcc.callsign = log.callsign)
    AND (ncm.Fname = '' OR ncm.Lname = '' OR ncm.county = '' OR ncm.state = '' OR ncm.latitude = '' OR ncm.home = '' OR ncm.state <> fcc.state)
    AND LEFT(log.callsign, 1) IN('A','K','N','W')
    AND LEFT(log.callsign, 3) NOT IN('AAA','AAR','NON','AFA')
    AND ncm.tactical NOT LIKE '%BAD%'
    GROUP BY log.callsign
");

$fixrequests = "<h2>Fixes to the following records in net #".$netID." were made:</h2><br>";
$query = '';
$address = '';
foreach($db_found->query($sql) as $row) {
	 
	$address = "$row[fulladdress]";
	 
	$koords  = geocode("$address");
		$latitude  = $koords[0];
		$longitude = $koords[1];
	
		$county	   = $koords[2];
		$state	   = $koords[3];

		$gridd 	   = gridsquare($latitude, $longitude);
		$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]"; 
		
    $fixrequests .= "$row[recordID], $row[callsign], $row[Fname], $row[Lname], $address, $county, $row[state]<br>";
		
    $query .= "UPDATE stations SET  
                    fccid     = '$row[fccid]', 
                    Fname     = TRIM('$row[Fname]'), 
                    Lname     = TRIM('$row[Lname]'),
                    county    = TRIM('$county'), 
                    state     = TRIM('$row[state]'),
                    grid      = TRIM('$grid'),
                    latitude  = '$latitude', 
                    longitude = '$longitude', 
                    email     = TRIM('$row[email]'),
                    creds     = TRIM('$row[creds]'),
                    home      = CONCAT('$latitude',',','$longitude',',','$grid',',','$county',',','$row[state]'),
                    latlng    = GeomFromText(CONCAT('POINT (', '$latitude', ' ', '$longitude', ')'))
                WHERE ID = '$row[ID]' AND callsign = '$row[b4Delim]' ; ";
}

/* Run the UPDATE Query */
//$db_found->exec($query);

/* Show what was fixed */
echo "$fixrequests";

echo "<br><br>The BIG Query<br>$sql<br><br>";

echo "THE UPDATE Query<br> $query";

	
?>