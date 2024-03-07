<?php
    // updateLATLONw3w.php
    
	// this program calculates a new lat/lon anytime the what3words (w3w) column is changed. 
	// It also find the nearest cross roads based on the lat lon using the GeoNames API
	// It runs from the editLAT and editLON in CallEditFunction.js
	// Written 2019-03-29
	// Modified 2019-05-26 --> Added the cross CrossRoads API
	
	//ini_set('display_errors',1); 
	//error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "GridSquare.php";
    
    $recordID   = $_GET['recordID'];  //echo("recordID= $recordID<br><br>");
    //$recordID = 152964;
    
// ==============================================================
// This part gets the w3w that was entered into the column in NCM
// ==============================================================

$sql = "SELECT SUBSTRING_INDEX(w3w, '<br>', 1) AS w3w, callsign, netID, ID, recordID, team
		  FROM NetLog
		 WHERE recordID =  $recordID
	   ";
    $stmt = $db_found->prepare($sql);
    
	$stmt->execute();
        $w3w = $stmt->fetchColumn(0);	
    $stmt->execute();
        $callsign = $stmt->fetchColumn(1);
    $stmt->execute();
        $netID = $stmt->fetchColumn(2);
    $stmt->execute();
        $ID = $stmt->fetchColumn(3);
    $stmt->execute();
        $recordID = $stmt->fetchColumn(4);
        
       // echo "$w3w, $callsign, $netID, $ID, $recordID";
       // echo "<br>from the DB w3w= $w3w<br><br>";
        
        // replace any of these characters with a period
        $splitarray = array(",", "-", " ", "*", "&", "|", "/", "_", "+", "@");
        
        $w3w = trim($w3w);
        $w3w = str_ireplace('/','',$w3w);
        $w3w = str_ireplace($splitarray, ".", $w3w);
        $prt = str_ireplace('/','',$w3w);
        
        $pieces = explode(".", $prt);
            $w3w = join(".", array_slice($pieces, 0, 3));
            $obj = join(" ", array_slice($pieces, 3));
              
        $CrossRoads = 0;
	
	//echo("sql=<br>$sql<br><br>w3w= $w3w<br>call= $callsign<br>netID= $netID<br>ID= $ID<br>recordID= $recordID<br><br>");
	
// ====================================
// Now get the lat/lon from W3W site
// ====================================
$curl = curl_init();
echo "@71 curl= $curl";

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.what3words.com/v3/convert-to-coordinates?key=5WHIM4GD&words=$w3w",
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
    echo "W3W CURL Response= $response<br>";
$err = curl_error($curl);
    echo "W3W CURL Error Response= $err<br><br>";
    
curl_close($curl);  // close the curl request

// Test if the curl worked or not
if ($err) {
  echo "CURL Error #:" . $err;
// If the curl worked what did it return?
} else {
    $w3wLL = json_decode($response, true);
        // Test if w3w returned a bad words error
        $chkResponse = $w3wLL['error'][code];  
           // echo "chkResponse= $chkResponse<br><br>";
        
            if ($chkResponse == 'BadWords') {
                   $CrossRoads = 0; 
                   $lat = 0; $lng = 0; // used to keep the geonames curl honest
                        echo "BadWords CrossRoads= $CrossRoads<br><br>";
            } else {
                   $lat    = $w3wLL['coordinates']['lat']; 
                   $lng    = $w3wLL['coordinates']['lng'];     
                   $grid   = gridsquare($lat, $lng);	 
                   $CrossRoads = 1;
                   
        echo("<br><br>@101<br>lat= $lat<br> lng= $lng<br> grid= $grid<br> w3w= $w3w<br>call= $callsign<br>netID= $netID<br>ID= $ID<br>recordID= $recordID<br><br>");
                   
// =========================================================================================
// Now lets get the nearest cross roads, notice that this CURL is inside the else loop above
// =========================================================================================
                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "http://api.geonames.org/findNearestIntersectionJSON?lat=$lat&lng=$lng&radius=1&username=ncm_wa0tjt",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                ));
                
                $response = curl_exec($curl);
                    echo "GeoNames CURL Response= $response<br>";
                $err = curl_error($curl);
                    echo "GeoNames CURL Error Response= $err<br><br>";
                
                curl_close($curl);
                
                if ($err) {
                  echo "CURL Error #:" . $err;
                
                } else { // no curl error
                    //echo "<br><br>in readGeoNames(): the Cross Roads CURL response<br> $response";
                  
                    $crc = json_decode($response, true);
                    
                       $street1  = $crc['intersection']['street1']; 
                       $street2  = $crc['intersection']['street2'];     
                       
                       $CrossRoads   = "$street1 &amp; $street2";
                            //echo("<br><br>@147 In readGeoNames():<br> street1= $street1,<br> street2= $street2,<br> CR= $CrossRoads");
                            
                } // end else
            } // end else of chkResponse from what3words curl 
} // end else of what3words curl 

echo "<br>@143 CrossRoads= $CrossRoads";

// ====================================
// Did we have good cross roads provided
// ====================================
if ($CrossRoads) {
// ====================================
// Now update the NetLog table.
// ====================================
$sql2 = "UPDATE NetLog 
		   SET latitude = $lat, longitude = $lng, grid='$grid',  w3w = '$w3w<br>$CrossRoads',
		       delta = 'Y'
		 WHERE recordID = $recordID
        ";
    //echo "@167 sql2<br>$sql2";
	$stmt2 = $db_found->prepare($sql2);
	$stmt2 -> execute();
	
if ($obj == '' ) {
    $delta = 'LOC&#916:W3W:';
}else { $delta = 'LOC&#916:W3W:OBJ:'; }

// Not using the geo any longer, so this value is just lat and lng together
$latlng = "$lat,$lng";

$ipaddress = '';



// removed latlng 2023-12-22
$sql3 = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
            VALUES ('$recordID', '$ID', '$netID', '$callsign', 
                    '$delta $w3w -> Cross Roads: $CrossRoads ($latlng) $obj', '$open', '$ipaddress') 
        ";
                    
       echo "<br>@177 sql3<br>$sql3"; 
    $stmt3 = $db_found->prepare($sql3);
	$stmt3 -> execute();

// ===================================================================================
// Update the NetLog table to reflect the error, so it will appear in the comments
// ===================================================================================
} else {
$sql4 = "UPDATE NetLog
            SET comments = 'Not a Valid W3W entry<br>Please re-enter.'
          WHERE recordID = $recordID";
    $stmt4 = $db_found->prepare($sql4);
	$stmt4 -> execute();

echo "@191 sql4=<br> $sql4<br><br>recordID= $recordID<br>CrossRoads= $CrossRoads";
   
}
	
?>