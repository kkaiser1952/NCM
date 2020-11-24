<?php
require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

	$fccsql = $db_found->prepare("SELECT replace(last,\" \",\"'\") as last
				 ,first
				 ,state
				 ,CONCAT_WS(' ', address1, city, state, zip)
			 FROM fcc_amateur.en
			WHERE callsign = '$cs1' 
			ORDER BY fccid DESC 
			LIMIT 0,1 ");					
		
		$fccsql->execute();
	
		$rows = $fccsql->rowCount();
		
		// Do this if something is returned
		if( !$fccsql->rowCount() < 1 ) {
			$result = $fccsql->fetch();
				// Convert first & last name into proper case (first letter uppercase)
				$Lname 		= ucfirst(strtolower($result[0])); 
				$Fname 		= ucfirst(strtolower($result[1]));
				$state2	 	= $result[2];
				$address 	= $result[3];  //echo "$address<br>"; // 73 Summit Avenue NE Swisher IA 52338
			
				$firstLogIn = 1;
		
				// This happens either way but really don't matter
				$koords    = geocode("$address"); //print_r($koords);  
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
				
		} else { // Do this if nothing is returned in otherwords there is no record in the FCC DB
				$comments 	= "No FCC Record";
		}
		
		//echo "<br>$home";
		//echo("<br>$Lname, $Fname, $state2, $address, $latitude, $latitude, $county, $state, $grid");
		//        Cox,    Donald, AR,     17480 Hwy 79 Kingsland AR 71652, -92.2940372, -92.2940372, Cleveland , AR, JA0A
?>



