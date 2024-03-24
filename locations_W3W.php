<?php
    // locations_w3w.php is designed to work much like its counter part locations_APRS.php but with W3W as input by the logger.
    // It is called by the ajax() in NetManager-W3W-APRS.js
    
// Error handling function
    function customError($errno, $errstr) {
        echo "<script>console.log('Error: [$errno] $errstr');</script>";
    }
// Set error handler
set_error_handler("customError");
        
  //echo "<script>console.log('16) Now In locations_W3W.php: ');</script>";      
        
    require_once "dbConnectDtls.php";
    require_once "w3w_functions.php";
    require_once "getCityStateFromLatLng.php";
    require_once "config.php";
    
    //ini_set('display_errors',1); 
	//error_reporting (E_ALL ^ E_NOTICE);
    
$aprs_call = isset($_POST["aprs_call"]) ? filter_input(INPUT_GET, 'aprs_call', FILTER_SANITIZE_STRING) : '';
$recordID = isset($_POST["recordID"]) ? filter_input(INPUT_GET, 'recordID', FILTER_SANITIZE_NUMBER_INT) : '';
$CurrentLat = isset($_POST["CurrentLat"]) ? filter_input(INPUT_GET, 'CurrentLat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$CurrentLng = isset($_POST["CurrentLng"]) ? filter_input(INPUT_GET, 'CurrentLng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$cs1 = isset($_POST["cs1"]) ? filter_input(INPUT_GET, 'cs1', FILTER_SANITIZE_STRING) : '';
$nid = isset($_POST["nid"]) ? filter_input(INPUT_GET, 'nid', FILTER_SANITIZE_NUMBER_INT) : '';
$objName = isset($_POST["objName"]) ? filter_input(INPUT_GET, 'objName', FILTER_SANITIZE_STRING) : '';
$W3Wcomment = isset($_POST["comment"]) ? filter_input(INPUT_GET, 'comment', FILTER_SANITIZE_STRING) : '';
$what3words = isset($_POST["w3wfield"]) ? filter_input(INPUT_GET, 'w3wfield', FILTER_SANITIZE_STRING) : '';
    
    
// Get coordinates from What3words
list($lat, $lng) = getCoordinatesFromW3W($what3words);

$thislatlng = "$lat, $lng";

//echo "<script>console.log('thislatlng: $thislatlng');</script>";

   
    // Now get the crossroads data
    include('getCrossRoads.php');
    $crossroads = getCrossRoads($lat, $lng);
        
    // This stuff is for printing only
    $crossroads = html_entity_decode($crossroads);
    
    // Now get the gridsquare
    include('GetGridSquare.php');
    $grid = getgridsquare($lat, $lng);
    
    // Now get the City, State, and Count
    list($state, $county, $city) = reverseGeocode($lat, $lng, $_GOOGLE_MAPS_API_KEY);

               
    $varsToKeep = array(
        "recordID"      => htmlspecialchars($recordID),
        "CurrentLat"    => htmlspecialchars($CurrentLat), // Not needed
        "CurrentLng"    => htmlspecialchars($CurrentLng), // Not needed
        "lat"           => htmlspecialchars($lat),
        "lng"           => htmlspecialchars($lng),
        "crossroads"    => htmlspecialchars($crossroads),
        "grid"          => htmlspecialchars($grid),
        "what3words"    => htmlspecialchars($what3words),
        "cs1"           => htmlspecialchars($cs1),
        "nid"           => htmlspecialchars($nid),
        "W3Wcomment"    => htmlspecialchars($W3Wcomment),
        "objName"       => htmlspecialchars($objName),
        "thislatlng"    => htmlspecialchars($thislatlng),
        "city"          => htmlspecialchars($city),
        "county"        => htmlspecialchars($county),
        "state"         => htmlspecialchars($state)
    );
 
    
    $deltax = 'LOC&#916:W3W '.$objName.' : '.$W3Wcomment.' : '.$what3words.' : '.$crossroads.' : ('.$thislatlng.')';
       
      //echo "<script>console.log('deltax:  $deltax');</script>";


    // This SQL updates the NetLog with all the information we just created
    $sql = "UPDATE NetLog
               SET latitude     = :lat
                  ,longitude    = :lng
                  ,grid         = :grid
                  ,w3w          = :w3w
                  ,dttm         = NOW()
                  ,comments     = :comments
                  ,city         = :city
                  ,county       = :county
                  ,state        = :state
             WHERE recordID = :recordID     
    ";
        
    try { 
        $stmt = $db_found->prepare($sql);
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lng', $lng);
        $stmt->bindParam(':grid', $grid);
            $w3wValue = $what3words . "<br>" . $crossroads;
        $stmt->bindParam(':w3w', $w3wValue);
            $commentsValue = $W3Wcomment . "--<br>Via W3W";
        $stmt->bindParam(':comments', $commentsValue);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':county', $county);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':recordID', $recordID);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
                
    // Update the TimeLog with the new information    
    $sql2 = "INSERT INTO TimeLog 
            (timestamp, callsign, netID, comment)
            VALUES (NOW(), :callsign, :netID, :comment)
    ";
 
    try { $stmt = $db_found->prepare($sql2);
            // Bind parameters
            $stmt->bindParam(':callsign', $cs1);
            $stmt->bindParam(':netID', $nid);
            $stmt->bindParam(':comment', $deltax);
    
    if ($stmt->execute()) { 
        echo "sql2 executed successfully";
    } else {
        echo "sql2 execution failed";
    }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
