<?php
require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

// laglng removed 2023-12-22
// MARS based

/* This program compares all the callsigns in the NetLog to callsigns in the FCC DB. For matches it creates 
   an entry for the stations table in the ncm DB. Several additonal columns are geocoded or API derived also.
   The IF condition in the select is explained here; 
   https://www.w3resource.com/mysql/string-functions/mysql-substring_index-function.php
   
   The only way to update the stations table right now is to run this program then copy the sql created, and 
   paste it into phpMyAdmin for the table.
*/

$fccsql = ("
    SELECT nl.ID AS ID,       
           nl.callsign AS tempCall,    /* keep the original as it appears in NetLog */
           
           /* If the callsign has a slash return everything left of the slash, otherwise return callsign */
           IF( nl.callsign LIKE '%/%', SUBSTRING_INDEX(nl.callsign,'/',1), nl.callsign ),
           nl.tactical,
           nl.Fname AS Fname,  nl.Lname AS Lname,
           nl.email AS email,  nl.phone AS phone,  nl.creds AS creds,
           
           MAX(nl.logdate)  as lastLogDT,
           MIN(nl.logdate)  as firstLogDT,
           MAX(nl.recordID) as recordID,
           
           /* These are used in case $ koords can't figure it out like W0FP */
           nl.latitude AS lat, nl.longitude AS lon, nl.grid AS gr, nl.county AS cnty,
           
    		CONCAT_WS(' ', fcc.address1, fcc.city, fcc.state, fcc.zip) as fulladdr,
            fcc.address1    as address,
            fcc.city        as city, 
            fcc.state       as state, 
            fcc.zip         as zip,
            fcc.fccid       as fccid
      FROM NetLog  nl,
           fcc_amateur.en fcc
     WHERE IF( nl.callsign LIKE '%/%', SUBSTRING_INDEX(nl.callsign,'/',1), nl.callsign ) = fcc.callsign
       AND nl.netID > 0 
       AND nl.ID > 0
       AND nl.logdate > 0
     /*  AND nl.latitude <> '' AND nl.longitude <> '' */
      AND nl.ID > 2515 AND nl.ID <= 2845 
       AND nl.netCall LIKE '%0TX%'
     /*  AND nl.callsign LIKE '%/%' */
     GROUP BY nl.ID
     ORDER BY nl.ID ASC
");

$marsSQL = ("
SELECT nl.ID AS ID,       
           nl.callsign AS tempCall,    /* keep the original as it appears in NetLog */
           
           /* If the callsign has a slash return everything left of the slash, otherwise return callsign */
           IF( nl.callsign LIKE '%/%', SUBSTRING_INDEX(nl.callsign,'/',1), nl.callsign ),
           
           nl.Fname AS Fname,  nl.Lname AS Lname,
           nl.email AS email,  nl.phone AS phone,  nl.creds AS creds,
           
           MAX(nl.logdate)  as lastLogDT,
           MIN(nl.logdate)  as firstLogDT,
           MAX(nl.recordID) as recordID
  FROM NetLog nl
 WHERE nl.netCall LIKE '%0TX%'
   AND nl.netID > 0
   AND nl.ID > 0
   AND nl.logdate > 0
   AND nl.ID <> 2234
 GROUP BY nl.ID
 ORDER BY nl.ID ASC  
");

$marsInserts = array();
foreach($db_found->query($marsSQL) as $rowM ) {
    $marsInserts[] = "('$rowM[ID]', '$rowM[tempCall]', '$rowM[Fname]', \"$rowM[Lname]\", '', '', '',
                  \"\", \"\", \"\", '', '', '', '',
                  'MARS', '$rowM[lastLogDT]', '$rowM[firstLogDT]', '$rowM[recordID]', '', 
                   '', \"\")<br><br>";
}
$values = implode(",", $marsInserts);

$Msql = "INSERT INTO stations (ID, callsign, tactical, Fname, Lname, latitude, longitude, grid, 
                              city, county, state, district, zip, email, phone, 
                              creds, lastLogDT, firstLogDt, recordID, fccid, home) 
                    VALUES $values
        ";
        
echo($Msql); 



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
        
/*
echo "$row[ID] $row[callsign] $row[Fname] $row[Lname] $latitude $longitude $grid <br> $row[city] $county $row[state] $district
      $row[zip]<br> $home <br> $row[email] $row[phone] $row[creds] $row[lastLogDT] $row[firstLogDT] $row[recordID] 
      $row[fccid] <BR><br>";
   
*/                       
   $inserts[] = "('$row[ID]', '$row[tempCall]', '$row[tactical]', '$row[Fname]', \"$row[Lname]\", '$latitude', '$longitude', '$grid',
                  \"$row[city]\", \"$county\", \"$row[state]\", '$district', '$row[zip]', '$row[email]', ' ',
                  '$row[creds]', '$row[lastLogDT]', '$row[firstLogDT]', '$row[recordID]', '$row[fccid]', 
                    \"$home\")<br><br>";                 
		
} // end foreach of fccsql query

//$inserts  = substr($inserts, 0, -1).")";
//print_r ($inserts); 

$values = implode(",", $inserts);

$sql = "INSERT INTO stations2 (ID, callsign, tactical, Fname, Lname, latitude, longitude, grid, 
                              city, county, state, district, zip, email, phone, 
                              creds, lastLogDT, firstLogDt, recordID, fccid, home) 
                    VALUES $values
        ";
        
//echo($sql);
      // $db_found->exec($sql);

?>