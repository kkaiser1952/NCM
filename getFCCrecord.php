<?php
require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

$csbase = $cs1;
// testing
//$csbase = 'wz9v';
//echo "$csbase<br>";

	$fccsql = $db_found->prepare("
	       SELECT  replace(last,\"'\",\"''\") as last 
				 ,first
				 ,state
				 ,CONCAT_WS(' ', address1, city, state, zip) AS address
				 ,fccid, city, zip
			 FROM fcc_amateur.en
			WHERE callsign = '$csbase' 
			  AND fccid = (SELECT MAX(fccid) FROM fcc_amateur.en WHERE callsign = '$csbase')
			ORDER BY fccid DESC 
			LIMIT 0,1 ");					
		
		$fccsql->execute();
	
		$rows = $fccsql->rowCount();
		
		// Do this if something is returned
		if( !$fccsql->rowCount() < 1 ) {
			$result = $fccsql->fetch();
				// Convert first & last name into proper case (first letter uppercase)
				$fccid      = $result[fccid];
				$Lname 		= ucfirst(strtolower($result[last])); 
				$Fname 		= ucfirst(strtolower($result[first]));
				$state2	 	= $result[2];
				$city       = $result[city];
				$zip        = $result[zip];
				$address 	= $result[3];  //echo "$address<br>"; // 73 Summit Avenue NE Swisher IA 52338
			
				$firstLogIn = 1;
		
				// This happens either way but really don't matter
				$koords    = geocode("$address"); 
				//print_r($koords);  
				    // Array ( [0] => 46.906975 [1] => -92.489501 [2] => St. Louis [3] => MN ) 
				$latitude  = $koords[0];  //echo "<br>lat= $latitude";
				$longitude = $koords[1];  //echo " lon= $longitude";
				$county	   = $koords[2];
				$state	   = $koords[3];
					if ($state == '') {
						$state = $state2;
					}
				$gridd 	   = gridsquare($latitude, $longitude);
				$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";  			
				$home      = "$latitude,$longitude,$grid,$county,$state";						
				$comments 	= "First Log In";  // adding state to this works
				
				
//echo ("<br>Lname: $Lname state2: $state2, city: $city, address: $address zip: $zip");
				
                    include "insertToStations.php";  // added 2020-12-12 to update the stations table
           
				
		} else { // Do this if nothing is returned in otherwords there is no record in the FCC DB
				$comments 	= "No FCC Record";
		}
		
		//echo "<br>$home";
		//echo("<br>$Lname, $Fname, $state2, $address, $latitude, $latitude, $county, $state, $grid");
		//        Cox,    Donald, AR,     17480 Hwy 79 Kingsland AR 71652, -92.2940372, -92.2940372, Cleveland , AR, JA0A
?>