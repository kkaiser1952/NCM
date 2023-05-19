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
            CONCAT(callsign,'OBJ') as callOBJ,
            COUNT(callsign) as numofcs, 
            SUBSTRING(comment, -18, 8) AS lat,
            SUBSTRING(comment, -9, 8) AS lng,
            
            SUBSTRING(comment, LOCATE('&', comment) + 16, LOCATE(' & ', comment, LOCATE('&', comment) + 1) - LOCATE('&', comment) - 16) AS aprs_call,
            
            CONCAT ('var ',callsign,'OBJ = L.latLngBounds( [' , GROUP_CONCAT('[',SUBSTRING(comment, -18, 8),',',SUBSTRING(comment, -9, 8) ,']'),']);') as objBounds,
            
            CONCAT (' [', GROUP_CONCAT('[',SUBSTRING(comment, -18, 8),',',SUBSTRING(comment, -9, 8),']'),'],') as arrBounds,
            
            CONCAT (callsign,'arr') as allnameBounds
            
          FROM TimeLog
         WHERE netID = $q
           AND comment LIKE '%OBJ::%'
           AND callsign LIKE '%w0dlk%'  /* OR callsign LIKE '%wa0tjt%' */
         ORDER BY timestamp  
      ");
          
          echo ("$sql <br><br>");
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
          $allcallList      = "";
          $alllatlngs       = "";
          
          $allnameBounds    = "";
          $allPoints        = "";
          $oByersCnt        = 0;
          

foreach($db_found->query($sql) as $row) {
    $koords = $row['lat'] . ',' . $row['lng'];
    $callsign = $row['callsign'];
    $objType = $row['objType'];
    $comment = $row['comment'];
    
    $allPoints .= "$row[arrBounds]";
    $objBounds .= "$row[objBounds]"; 
    $oByersCnt = $oByersCnt + 1;
    $allnameBounds .= "'$row[allnameBounds]',";
    
     $objPadit  .= "var $row[callsign]PAD    = $row[callsign]OBJ.pad(.075);";
     $objSW     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthWest();";
     $objNW     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthWest();";
     $objNE     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthEast();";
     $objSE     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthEast();";
            
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

echo "Crossroads:  $crossroads <br>";
echo "objBounds: $objBounds <br>";
echo "allPoints: $allPoints <br>";
echo "oByersCnt: $oByersCnt <br>";
echo "allnameBounds: $allnameBounds <br>";


} // end foreach

$oByers = "var oByers = $oByersCnt";
echo "oByers: $oByers <br>";
      
?>
  