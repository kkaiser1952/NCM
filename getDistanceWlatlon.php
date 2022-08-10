<!doctype html>
<?php
	
require_once "dbConnectDtls.php";

//$netID = intval($_POST["q"]);
$netID = 5707;

/*
function getDistanceWlatlon($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles') {
  $theta = $longitude1 - $longitude2; 
  $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
  $distance = acos($distance); 
  $distance = rad2deg($distance); 
  $distance = $distance * 60 * 1.1515; 
  switch($unit) { 
    case 'miles': 
      break; 
    case 'kilometers' : 
      $distance = $distance * 1.609344; 
  } 
  return (round($distance,2)); 
} // End getDistanceWlatlon function
*/


/*
The below query creates a list showing the distance between the home station 39.202,-94.602 and all the other stations.
*/
/*
SET  @netid 	= 5707;
SET  @NCSlatitude  = 39.202;
SET  @NCSlongitude = -94.602;
SET  @distance  = 75;
*/

/* This first SQL gets the station and its lat/lon for the NCS (PRM) */
$sql = "SELECT callsign, latitude, longitude
          FROM NetLog
         WHERE netID = $netID
           AND netcontrol = 'PRM'
         LIMIT 1
       ";

$stmt= $db_found->prepare($sql);
	$stmt->execute();
	
	$result = $stmt->fetch();
		$NCScallsign  = $result[callsign];
		$NCSlatitude  = $result[latitude];
		$NCSlongitude = $result[longitude];
		
    //echo "$NCScallsign $NCSlatitude $NCSlongitude <br><br>";
    

/* This SQL calculates the mileage between the NCS station and all the rest of the stations */
$sql = "SELECT callsign, ROUND((((acos(sin((latitude*pi()/180)) * 
           sin(($NCSlatitude*pi()/180)) + cos((latitude*pi()/180)) * 
           cos(($NCSlatitude*pi()/180)) * cos(((longitude- $NCSlongitude)*pi()/180)))) * 
           180/pi()) * 60 * 1.1515),2) as distance 
          FROM `NetLog` 
         WHERE netID = $netID
        HAVING distance >= 1   
 ";
 
 //echo "$sql";
 
    $STAcallsign = '';
    $STAdistance = 0;
    $out = '';

foreach($db_found->query($sql) as $row) {
   // $STAcallsign = $row[callsign];
   // $STAdistance = $row[distance];
    
    $out .= "$row[callsign] $row[distance]<br>";
    
}
 
    echo "$out <br>"; 
    


/*
 working version 
     
SET  @netid 	= 5707;
SET  @NCSlatitude  = 39.202;
SET  @NCSlongitude = -94.602;
SET  @distance  = 0;

SELECT callsign, ROUND((((acos(sin((latitude*pi()/180)) * 
       sin((@NCSlatitude*pi()/180)) + cos((latitude*pi()/180)) * 
       cos((@NCSlatitude*pi()/180)) * cos(((longitude- @NCSlongitude)*pi()/180)))) * 
       180/pi()) * 60 * 1.1515),2) as distance 
  FROM `NetLog` 
 WHERE netID = @netid
 HAVING distance >= @distance  
     
     

SELECT callsign, latitude,longitude, (((acos(sin((latitude*pi()/180)) * sin((39.202*pi()/180)) + cos((latitude*pi()/180)) * cos((39.202*pi()/180)) * cos(((longitude- -94.602)*pi()/180)))) * 180/pi()) * 60 * 1.1515) as distance 
  FROM `NetLog` 
 WHERE netID = 5707
 HAVING distance >= 75  
 
 */

    
?>

 
                     
