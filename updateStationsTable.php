<!doctype html>
<?php
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "geocode.php";  
    require_once "GridSquare.php";
    
/* Select records with possible issues */
$sql = ("
SELECT  fcc.fccid
       ,ncm.recordID
       ,ncm.callsign
       ,SUBSTRING_INDEX(ncm.callsign, IF(LOCATE('/', ncm.callsign), '/', '-'), 1) AS b4Delim
       ,ncm.home
       
       ,    CASE
            	WHEN ncm.Fname IS NULL OR ncm.Fname = ' ' OR ncm.Fname <> fcc.first THEN fcc.first
                ELSE ncm.Fname
            END as Fname
       ,    CASE
            	WHEN ncm.Lname IS NULL OR ncm.Lname = ' ' OR ncm.Lname <> fcc.last THEN fcc.last
                ELSE ncm.Lname
            END as Lname
       ,    CASE
            	WHEN ncm.state IS NULL OR ncm.state = ' ' OR ncm.state <> fcc.state THEN fcc.state
                ELSE ncm.state
            END as state
                        
       ,CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) as fulladdress
   FROM fcc_amateur.en fcc
       ,ncm.stations ncm 
  WHERE fcc.callsign = substring_index(ncm.callsign, '/', 1)
    AND fcc.fccid = (SELECT MAX(fcc.fccid) FROM fcc_amateur.en fcc WHERE fcc.callsign = ncm.callsign)
    AND (ncm.Fname = '' OR ncm.Lname = '' OR ncm.county = '' OR ncm.state = '' OR ncm.latitude = '' OR ncm.home = '' 
         OR ncm.state <> fcc.state)
    
    AND LEFT(ncm.callsign, 1) IN('A','K','N','W')
    AND LEFT(ncm.callsign, 3) NOT IN('AAA','AAR','NON','AFA')
    AND ncm.tactical NOT LIKE '%BAD%';
");


$fixrequests = '<h2>Fixes to the following records were made:</h2><br>';
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
		
    $fixrequests .= "$row[recordID],  $row[callsign],  $row[Fname],  $row[Lname],   $address,  $county, $row[state]  <br>";
		
    $query .= "UPDATE stations SET fccid = '$row[fccid]', Fname = '$row[Fname]', Lname = '$row[Lname]',
                      county = '$county', state = '$row[state]', grid = '$grid',
                      latitude = '$latitude', longitude = '$longitude', 
                      home = CONCAT(latitude,',',longitude,',',grid,',',county,',',state)
                WHERE recordID = '$row[recordID]' AND callsign = '$row[b4Delim]' ; ";
}

/* Run the UPDATE Query */
$db_found->exec($query);

/* Show what was fixed */
echo "$fixrequests";

echo "<br><br>The BIG Query<br>$sql<br><br>";

echo "THE UPDATE Query<br> $query";

	
?>