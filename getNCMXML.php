<?php
date_default_timezone_set("America/Chicago");
require_once"dbConnectDtls.php";
require_once"getCenterFromDegrees.php";
    
if (isset($_GET['needle'])){
	$needle = "%".$_GET['needle']."%";
	$whch   = "n";
	echo("needle= $needle");
}else {
	$lat  = $_GET['lat'];    // center latitude.
	$lng  = $_GET['lng'];    // center longitude
	$dist = $_GET['dist'];
	$netID = $_GET['netID'];
	$whch = "l";
}

// for testing
//$lat = 39.202903;   //center latitude
//$lng = -94.602907;  //center longitude
//$netID = 812;

//Set content-type header for XML 
header("Content-type: text/xml");
	
$dom     = new DOMDocument("1.0");
$node    = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


//getNCMXML.php?lat=39.202&lng=-94.602&dist=2&netID=275
/* Returns:
	<markers>
<marker ID="013" netID="275" Fname="Keith" callsign="WA0TJT" Lname="KAISER" grid="EM29QE" tactical="TJT" lat="39.202911" lng="-94.602887" email="wa0tjt@gmail.com" creds="NARES" distance="0" type="Station"/>
</markers>
*/

// Use the Haversine formula to find stations within a certain distance of a give lat/lng
if ($whch === "l"){
try {     /* 	
	$sql = "SELECT AVG( longitude ) AS Avg_Long,
				   AVG( latitude ) AS Avg_Lat
			  FROM NetLog
			 WHERE netID = $netID	
		   ";
	$stmt = $db_found->prepare($sql);
		$stmt -> execute();
			$AvgLong = $stmt->fetchColumn(0);
		$stmt -> execute();
			$AvgLat  = $stmt->fetchColumn(1); 
			
			echo "$AvgLong"; */
	
	$stmt = "SELECT
					ID,
					ID as tt,
					CONCAT (Fname, ' ', Lname) as name,
				    callsign,
				    tactical,
				    grid,
				    latitude,
				    longitude,
				    email,
				    creds,
				    (
				        3959 * ACOS(
				            COS(RADIANS(39.202903)) * COS(RADIANS(latitude)) * 
				            COS(RADIANS(longitude) - RADIANS(-94.602907)) +
				            SIN(RADIANS(39.202903)) * SIN(RADIANS(latitude))
				        )
				    ) AS distance
				FROM
				    `NetLog`
				WHERE
				    netID = $netID
				ORDER BY
				    ID";
     	
     		
     		// HAVING distance < ? removed from SQL after Group By
     
     $sth = $db_found->prepare($stmt);
     
	// Assign parameters to each ? in 
	$sth->bindParam(1,$lat);
	$sth->bindParam(2,$lng);
	$sth->bindParam(3,$lat);
	$sth->bindParam(4,$netID);
	//$sth->bindParam(5,$dist);
	
	
	$sth->setFetchMode(PDO::FETCH_ASSOC);

	//Execute query
	$sth->execute();
	
	// Iterate through the rows, adding XML nodes for each
	while($row = $sth->fetch()) {
	
		// ADD TO XML DOCUMENT NODE
		$node = $dom->createElement("marker");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("ID", $row['ID']);
		//$newnode->setAttribute("tt", $row['tt']);
		$newnode->setAttribute("netID", $row['netID']);
        $newnode->setAttribute("Fname", utf8_encode($row['Fname']));
		$newnode->setAttribute("callsign", utf8_encode($row['callsign']));
		$newnode->setAttribute("Lname", utf8_encode($row['Lname']));
		$newnode->setAttribute("grid", utf8_encode($row['grid']));
		$newnode->setAttribute("tactical", $row['tactical']);
		$newnode->setAttribute("lat", $row['latitude']);
        $newnode->setAttribute("lng", $row['longitude']);
        $newnode->setAttribute("email", utf8_encode($row['email']));
        $newnode->setAttribute("creds", utf8_encode($row['creds']));
        $newnode->setAttribute("distance", round($row['distance'],1));
        $newnode->setAttribute("type", utf8_encode('Station'));
        
	} // end of while loop
}
catch (Exception $e) {throw new Exception( 'Something really gone wrong', 0, $e);}
}

//print_r($koords);

if ($whch === "n") {
try {
	$stmt2 = $db_found->prepare(' SELECT * FROM NetLog WHERE ID LIKE :needle ');
	//echo("stmt2= $stmt2");
	// Assign parameters
	$stmt2->bindParam(':needle', $needle, PDO::PARAM_STR);
	$stmt2->setFetchMode(PDO::FETCH_ASSOC);
	//Execute query
	$stmt2->execute();
	while($row = $stmt2->fetch()) {
		$node = $dom->createElement("marker");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("ID", $row['ID']);
		$newnode->setAttribute("tt", $row['tt']);
		$newnode->setAttribute("netID", $row['netID']);
        $newnode->setAttribute("Fname", utf8_encode($row['Fname']));
		$newnode->setAttribute("callsign", utf8_encode($row['callsign']));
		$newnode->setAttribute("Lname", utf8_encode($row['Lname']));
		$newnode->setAttribute("grid", utf8_encode($row['grid']));
		$newnode->setAttribute("tactical", $row['tactical']);
		$newnode->setAttribute("lat", $row['latitude']);
        $newnode->setAttribute("lng", $row['longitude']);
        $newnode->setAttribute("email", utf8_encode($row['email']));
        $newnode->setAttribute("creds", utf8_encode($row['creds']));
        $newnode->setAttribute("type", utf8_encode('Station'));
    }
} // end of try
catch (Exception $e) {throw new Exception( 'Something really gone wrong', 0, $e);}
} // end of whch = n

	echo $dom->saveXML();
	//Close the connection
	$db_found = NULL; 
?>