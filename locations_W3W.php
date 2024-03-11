<?php
    // locations_w3w.php is designed to work much like its counter part locations_APRS.php but with W3W as input by the logger.
    // It is called by the ajax() in NetManager-W3W-APRS.js
    
// Error handling function
    function customError($errno, $errstr) {
        echo "<script>console.log('Error: [$errno] $errstr');</script>";
}
// Set error handler
set_error_handler("customError");
        
  echo "<script>console.log('16) Now In locations_W3W.php: <br>');</script>";      
        
    require_once "dbConnectDtls.php";
    require_once "w3w_functions.php";
    //include "config2.php";
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
	
	$aprs_call      = $_GET["aprs_call"];
	    echo "<script>console.log('17) aprs_call: " . $aprs_call . "<br>');</script>";
	$aprs_callsign  = strtoupper($aprs_call);
	$recordID       = $_GET["recordID"];
    $CurrentLat     = $_GET["CurrentLat"];
    $CurrentLng     = $_GET["CurrentLng"];
    $cs1            = $_GET["cs1"];
    $nid            = $_GET["nid"];
    $objName        = $_GET["objName"];
    $APRScomment    = $_GET["comment"];
    $what3words     = $_GET["w3wfield"];

/*
    echo ("@22 in locations_W3W.php::   <br>
       aprs_call: $aprs_call            <br>
       recordID: $recordID              <br>
       
       cs1: $cs1                        <br>
       nid: $nid                        <br>
       objName: $objName                <br>
       APRScomment: $APRScomment        <br>
       w3wfield: $what3words            <br>
    ");
*/
    
// Get coordinates from What3words
list($latitude, $longitude) = getCoordinatesFromW3W($what3words);

//echo "@49 W3W Latitude: " . $latitude . "<br>";
//echo "@50 W3W Longitude: " . $longitude . "<br>";
   
    // Now get the crossroads data
    //echo "<br><u>From The getCrossRoads()</u><br>";
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($latitude, $longitude);
    //echo "{$crossroads}<br>";
    
    // Now get the gridsquare
    include('GetGridSquare.php');
    $grid = getgridsquare($latitude, $longitude);
    //echo "<br>Grid Square: {$grid}<br>";
           
    //$southwest_lat = $result['square']['southwest']['lat'];
    //$southwest_lng = $result['square']['southwest']['lng'];
    //$northeast_lat = $result['square']['northeast']['lat'];
    //$northeast_lng = $result['square']['northeast']['lng'];
    $words = $result['words'];
    //$language = $result['language'];
    $map = $result['map'];
    //$place = $result['nearestPlace'];
    
    //echo "<br><u>From Geocoder by What3Words</u><br>";
    //echo "Words: {$words}<br>";
    //echo "Map: {$map}<br>";
    //echo "Nearest Place: {$place}<br>";
    
    
    // This stuff is for printing only
    $crossroads = html_entity_decode($crossroads);

    $varsToKeep = array(
        "aprs_callsign" => htmlspecialchars($aprs_callsign),
        "recordID"      => htmlspecialchars($recordID),
        "CurrentLat"    => htmlspecialchars($CurrentLat),
        "CurrentLng"    => htmlspecialchars($CurrentLng),
        "lat"           => htmlspecialchars($latitude),
        "lng"           => htmlspecialchars($longitude),
        "altitude_meters" => htmlspecialchars($altitude_meters),
        "altitude_feet" => htmlspecialchars($altitude_feet),
        "crossroads"    => htmlspecialchars($crossroads),
        "firsttime"     => htmlspecialchars($firsttime),
        "thistime"      => htmlspecialchars($thistime),
        "grid"          => htmlspecialchars($grid),
        "what3words"    => htmlspecialchars($what3words),
        "map"           => htmlspecialchars($map),
        "cs1"           => htmlspecialchars($cs1),
        "nid"           => htmlspecialchars($nid),
        "aprs_comment"  => htmlspecialchars($aprs_comment),
        "objName"       => htmlspecialchars($objName),
        "thislatlng"    => htmlspecialchars($thislatlng)
    );
    
    $deltax = 'LOC&#916:W3W '.$objName.' : '.$APRScomment.' : '.$what3words.' : '.$crossroads.' : ('.$thislatlng.')';
       
       echo "<br>deltax: $deltax<br>";


// This SQL updates the NetLog with all the information we just created.
    
       $sql1 = 
       "UPDATE NetLog 
           SET latitude     = '$latitude'
              ,longitude    = '$longitude'
              
              ,grid         = '$grid'
              ,w3w          = '$words<br>$crossroads'
              ,dttm         = NOW()
              ,comments     = '$aprs_comment--<br>Via W3W'
         WHERE recordID = $recordID;
       ";
       
       
       try {
            $stmt = $db_found->prepare($sql1);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
       

       $sql2 = 
       "INSERT INTO TimeLog 
            (timestamp, callsign, comment, netID)
            VALUES ( NOW(), '$cs1', '$deltax', '$nid');      
       "; 
       
              
       try {
            $stmt = $db_found->prepare($sql2);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

?>
