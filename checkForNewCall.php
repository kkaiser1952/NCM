<?php
    // checkForNewCall.php
    //
	//$date = new DateTime('2000-01-01', new DateTimeZone('America/Chicago'));
	//echo $date->format('Y-m-d H:i:sP') . "\n";
//date_default_timezone_set("America/Chicago");
// Fix times in the dbConnectDtls.php program 

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

// Clean up the incoming data which should look like this  WA0TJT
// var q from BuildNewGroup is  thiscall+","+thisemail+","+thisname;
$q = $_POST["q"]; //$q = "W9ABC,kkaiser@me.com,Keith Kaiser<br>"; 
	//print "q= $q<br>";
	$parts	= explode(",",$q);
		$thiscall 	= strtoupper($parts[0]);  
		$thisemail 	= $parts[1];  
		$thisname   = $parts[2];
			//echo "$thisname";
			$name = explode(" ",$thisname);
				$Fname = $name[0];
				$Lname = $name[1];
	//echo "thisCall= $thiscall<br> thisEmail= $thisemail<br> thisName= $thisname<br> Fname= $Fname<br> Lname= $Lname <br>";

// This first SQL checks to see if the callsign is already in the DB, if it is nothing happens, if its not it gets added.
$sql1 = "SELECT count(*) FROM NetLog WHERE callsign = '$thiscall' ";
	//echo "$sql1<br>";

	if ($res = $db_found->query($sql1)) {
		if ($res->fetchColumn() > 0) {
			$sql2 = "SELECT ID, callsign FROM NetLog WHERE callsign = '$thiscall' LIMIT 0,1 ";
				foreach ($db_found->query($sql2) as $row ) {
					//print "Doing nothing with this call: $row[callsign] " . $row['ID'] ;
				}
		}
		else { 
			// This gets the next ID number for the new callsign
			$sql2 = $db_found->prepare("SELECT MIN( unused ) AS unused
				FROM (
				
				SELECT MIN( t1.id ) +1 AS unused
				FROM NetLog AS t1
				WHERE NOT 
				EXISTS (
				
				SELECT * 
				FROM NetLog AS t2
				WHERE t2.id = t1.id +1
				)
				UNION 
				
				SELECT 1 
				FROM DUAL
				WHERE NOT 
				EXISTS (
				
				SELECT * 
				FROM NetLog
				WHERE id =1
				)
				) AS subquery");
				
				$sql2->execute();
				$result   = $sql2->fetch();
				$id 	  = $result[0];   
				
				//	echo "Inside sql to pull next available ID# = $id call= $thiscall<br><br>";
					
		  // Find the other variable values
		  $fccsql = $db_found->prepare("SELECT first 
				 ,last
				 ,full_name
				 ,state
				 ,CONCAT_WS(' ', address1, city, state, zip) as fulladdress
			 FROM fcc_amateur.en
			WHERE callsign = '$thiscall' 
			AND fccid = (SELECT MAX(fccid) FROM fcc_amateur.en WHERE callsign = '$thiscall')
		/*	ORDER BY fccid DESC */
			LIMIT 0,1 ");				
		
		$fccsql->execute();
	
		$rows = $fccsql->rowCount();
		
		//echo "rows from fccsql= $rows<br>";
		
		// Do this if something is returned
		if( $rows = 1 ) {
			$result = $fccsql->fetch();
				//$tt			= $result[0];
				// Convert first & last name into proper case (first letter uppercase)
				$Fname 		= ucfirst(strtolower($result[first]));
				$Lname 		= ucfirst(strtolower($result[last]));
				
				$state2	 	 = $result[state];
				$fulladdress = $result[fulladdress];  //echo "$address"; // 73 Summit Avenue NE Swisher IA 52338
			//	$comments 	= "First Log In";  // adding state to this works
				$firstLogIn = 1;
		
				// This happens either way but really don't matter
				$koords    = geocode("$fulladdress");
					$latitude  = $koords[0];  //echo "lat= $latitude";
					$longitude = $koords[1];  //echo "lon= $longitude";
				
			//	[0] => 44.9596871 [1] => -93.2895616 [2] => Hennepin [3] => MN
				$county	   = $koords[2];
				//$district  = $koords[3];
				$state	   = $koords[3];
					if ($state == '') {
						$state = $state2;
					}
				$gridd 	   = gridsquare($latitude, $longitude);
				$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";  
				
				echo "$Fname $Lname<br>full_name= $result[full_name]<br>state= $state2<br> $address<br> $latitude, $longitude<br>county= $county<br> $state <br>grid= $grid <br><br>";
		} // end of finding the FCC stuff
		} // End of finding what the new id will be
	} // End of $db_found->query($sql1))

$res = null;	

	$sql3 = $db_found->prepare("
			  INSERT INTO NetLog (netID, ID, callsign, Fname, Lname, email,  latitude, longitude, grid,
						  county, state, tt)
				    VALUES ('0', '$id', '$thiscall', '$Fname', '$Lname', '$thisemail',  
				    	'$latitude', '$longitude', '$grid', '$county', '$state', '$id')");
			$sql3->execute();
			
			echo "Updates Done!";
			//echo "ID $id for $thiscall \n $Fname $Lname \n has been added to NetLog";
?>