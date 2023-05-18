<?php
    
    ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);         

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
    require_once "extractVariables.php";

   $q = 9045;
   
   //LOCΔ:APRS& OBJ::18 - Back at Driveway & Keith and Deb from KCMO & mice.beak.glimmer & N Ames Ave & NW 60th Ct & 39.20283,-94.60267
     
      
$sql = (" SELECT
            callsign,
            timestamp,
            comment, 
            SUBSTRING(comment, -18, 8) AS lat,
            SUBSTRING(comment, -9, 8) AS lng
        FROM TimeLog
        WHERE netID = $q
          AND comment LIKE '%OBJ::%'
          ");
          
          echo ("$sql");
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
          $allcallList      = "";
          $alllatlngs       = "";
          

foreach($db_found->query($sql) as $row) {
    $koords = $row[lat].','.$row[lng];
    $callsign = $row[callsign];

        
    $objType = "$row[objType]";
    $comment = "$row[comment]";            
    $comm1   = $comm2 = $comm3 = $comm4 = $comm5 = '';
        
    extractVariables($comment);
    // Output the extracted variables
        foreach ($result as $name => $variable) {
        echo $name . ": " . $variable . "<br>";
} // end foreach

      
?>
  