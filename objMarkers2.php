<?php
    
    ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);         

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
   // require_once "extractVariables.php";
   

function extractVariables($string) {
    $variables = explode('&', $string);
    $extractedVariables = [];

    foreach ($variables as $index => $variable) {
        $extractedVariables["variable" . ($index + 1)] = trim($variable);
    }

    return $extractedVariables;
}


   $q = 9114;
   
   //LOCΔ:APRS& OBJ::18 - Back at Driveway & Keith and Deb from KCMO & mice.beak.glimmer & N Ames Ave & NW 60th Ct & 39.20283,-94.60267
     
      
$sql = (" SELECT
            callsign,
            timestamp,
            comment, 
            SUBSTRING(comment, -18, 8) AS lat,
            SUBSTRING(comment, -9, 8) AS lng,
            SUBSTRING(comment, LOCATE('&', comment) + 16, LOCATE(' & ', comment, LOCATE('&', comment) + 1) - LOCATE('&', comment) - 16) AS aprs_call
        FROM TimeLog
        WHERE netID = $q
          AND comment LIKE '%OBJ::%'
          AND callsign LIKE '%w0dlk%'
        ORDER BY timestamp  
          ");
          
          //echo ("$sql");
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
          $allcallList      = "";
          $alllatlngs       = "";
          

foreach($db_found->query($sql) as $row) {
    $koords = $row['lat'] . ',' . $row['lng'];
    $callsign = $row['callsign'];
    $objType = $row['objType'];
    $comment = $row['comment'];
            
    $result = extractVariables($comment);
    // Output the extracted variables
    //var_dump($result);
        $crossroads = '';

$javascriptVariables = [];

$crossroads = '';

foreach ($result as $name => $variable) {
    if ($name !== 'variable1' && $name !== 'variable2') {
        echo $row['callsign'] . ' ' . $row['aprs_call'] . ' ' . $name . ": " . $variable . "<br>";

        if ($name === 'variable6') {
            $crossroads .= $variable;
        } elseif ($name === 'variable7') {
            $crossroads .= ' & ' . $variable;
        }
    }
}

echo "Crossroads: " . $crossroads;


} // end foreach
      
?>
  