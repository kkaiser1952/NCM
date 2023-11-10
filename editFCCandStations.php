<?php
require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

/* This program compares using the callsigns in the NetLog/stations to callsigns.
   It checks the geocoded address in FCC with the latitude, longitude, grid, county, state in stations
   and fixes any that are out of date.
   In NetLog this is done by netID to prevent older address from changing, in stations it changes the entries
*/

SET @callsign := 'AB0H';
SET @netID := 3357;

$fccsql = ("
    SELECT nl.ID AS ID,       
           nl.callsign AS callsign,    
           nl.Fname AS nl_Fname,  nl.Lname AS nl_Lname,
           fcc.first AS fcc_first, fcc.last AS fcc_last,
           
           /* These are used in case $ koords can't figure it out like W0FP */
           nl.latitude AS nl_lat, nl.longitude AS nl_lon, nl.grid AS nl_grid, nl.county AS nl_county,
           nl.state AS nl_state,
           
    		CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) as fulladdr,
            fcc.address1    as address,
            fcc.city        as city, 
            fcc.state       as fcc_state, 

      FROM NetLog  nl,
           fcc_amateur.en fcc
     WHERE nl.netID = @netID
     GROUP BY nl.ID
     ORDER BY nl.ID ASC
");


$inserts = array();
foreach($db_found->query($fccsql) as $row) {	

    $address 	= $row[fulladdr];  //echo "$address<br>"; // 73 Summit Avenue NE Swisher IA 52338
        //echo("$row[callsign] $address <br>");
    $koords    = geocode("$address"); //print_r($koords);  
        // Array ( [0] => 46.906975 [1] => -92.489501 [2] => St. Louis [3] => MN ) 
    $latitude  = $koords[0];  //echo "<br>lat= $latitude";
        //echo("$row[callsign] $latitude <br>");
    $longitude = $koords[1];  //echo " lon= $longitude";
        //echo("$row[callsign] $longitude <br>");
    $county	   = "$koords[2]";
        //echo("$row[callsign] $county <br>");
    
    $gridd 	   = gridsquare($latitude, $longitude);
        //print_r($gridd);
    $grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";  
        //echo("$row[callsign] $grid <br>");
        if ($grid == 'JJ00AA') {
            $gridd 	   = gridsquare($latitude, $longitude);
            $grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";
            $latitude  = $row[lat]; $longitude = $row[lon]; 
            $county    = "$row[cnty]";
            $gridd 	   = gridsquare($latitude, $longitude);
            $grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";    
        }
    
    $avalstate = array('IA','MN','MO','KS'); // Only have infor about districts from these states
    $district = 'N/A'; // Use as default district
    
    if ($row[state] == 'IA' || $row[state] == 'MN' || $row[state] == 'MO' || $row[state] == 'KS') {
        foreach($db_found->query("SELECT District
									FROM HPD 
								   WHERE county = '$county'
								     AND state LIKE '%$row[state]%'
                                   LIMIT 0,1
								 ") as $act){ $district = $act[District]; }
    } // end if
    
    $home      = "$latitude,$longitude,$grid,$county,$row[state],$district";
                              
   $inserts[] = "('$row[ID]', '$row[tempCall]', '$row[tactical]', '$row[Fname]', \"$row[Lname]\", '$latitude', '$longitude', '$grid',
                  \"$row[city]\", \"$county\", \"$row[state]\", '$district', '$row[zip]', '$row[email]', '$row[phone]',
                  '$row[creds]', '$row[lastLogDT]', '$row[firstLogDT]', '$row[recordID]', '$row[fccid]', 
                   GeomFromText(CONCAT('POINT (', $latitude, ' ', $longitude, ')')), \"$home\")<br><br>";                 
		
} // end foreach of fccsql query

//$inserts  = substr($inserts, 0, -1).")";
//print_r ($inserts); 

$values = implode(",", $inserts);

$sql = "UPDATE stations SET
    latitude = $latitude,
    longitude = $longitude,
    county = $county,
    state = $state,
    district = $district,
    home = $home
    ;


?>