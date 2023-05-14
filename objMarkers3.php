<?php
    
    ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			
    // This is for what3words usage
    /* https://developer.what3words.com/public-api/docs#convert-to-3wa */
    // Now lets add the what3words words from the W3W geocoder
    $w3w_api_key = $config['geocoder']['api_key'];
    require_once "Geocoder.php";
        use What3words\Geocoder\Geocoder;
      //  use What3words\Geocoder\AutoSuggestOption;
        
        $api = new Geocoder("$w3w_api_key");           

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";

   //$q = 4743;
      
   $sql = (" SELECT callsign,
               CONCAT(callsign, 'OBJ') AS callOBJ,
               COUNT(callsign) AS numofcs,
               CONCAT('var ', callsign, 'OBJ = L.latLngBounds( [', GROUP_CONCAT('[', latitude, ',', longitude, ']'), ');') AS objBounds,
               CONCAT(GROUP_CONCAT('[', latitude, ',', longitude, '],')) AS arrBounds,
               CONCAT(callsign, 'arr') AS allnameBounds
                FROM (
                    SELECT callsign,
                           SUBSTRING(comment, -18,8) as latitude,
                           SUBSTRING(comment, -9,8) as longitude
                           
                    FROM TimeLog
                    WHERE netID = 9071
                      AND callsign <> 'GENCOMM'
                      AND comment LIKE '%OBJ:%'
                ) AS subquery
                GROUP BY callsign;
          ");
          
          echo "sql1:<br>$sql<br>";
    
        $allnameBounds = "";
        $allPoints = "";
        $oByersCnt = 0;
     foreach($db_found->query($sql) as $row) {
         $objBounds .= "$row[objBounds]";    
         $oByersCnt = $oByersCnt + 1;
         

         $allnameBounds .= "'$row[allnameBounds]',";
         $objMiddle .= "$row[callsign]OBJ.getCenter();";
         $allPoints .= "$row[arrBounds]";
         
         $objPadit  .= "var $row[callsign]PAD    = $row[callsign]OBJ.pad(.075);";
         $objSW     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthWest();";
         $objNW     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthWest();";
         $objNE     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthEast();";
         $objSE     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthEast();";
         
        // echo ("$objPadit");
            // var W0DLKPAD = W0DLKOBJ.pad(.075);
         
     } // end of foreach loop 
     
     $oByers = "var oByers = $oByersCnt";
     
        // This creates a lat/lon list for each callsign with objects. This is used in
        // the map.php program in the polyline function
        $sqlk = ("SELECT CONCAT('var ', callsign, 'latlngs = [',
                         GROUP_CONCAT(CONCAT( '[',SUBSTRING(comment, -18,8),',',SUBSTRING(comment, -9,8),']')),']') as allKoords
                         
                    FROM TimeLog
                   WHERE netID = 9071
                     AND comment LIKE '%OBJ:%'
                   GROUP BY callsign
                ");
                
        echo "sqlk2:<br> $sqlk<br><br>";
                
            foreach($db_found->query($sqlk) as $row) {
                $alltheKoords .= $row[allKoords].';';
                
        // objectLine = L.polyline([[39.201636,-94.602375],[39.201259,-94.603175],[39.20169,-94.603628],[39.201986,-94.603036],[39.202337,-94.602932]],{color: newcolor, weight: 4}).addTo(map);
            } 
     //echo "$alltheKoords";
    // var W0DLKlatlngs = [[39.201636,-94.602375],[39.201259,-94.603175],[39.20169,-94.603628],[39.201986,-94.603036],[39.202337,-94.602932]];var WA0TJTlatlngs = [[39.201393,-94.601576],[39.20067,-94.6015],[39.20167,-94.60217],[39.20117,-94.60167],[39.2025,-94.6025],[39.203,-94.60233],[39.203,-94.60233],[39.201016,-94.601541],[39.203,-94.60233]];
      
        $sql = ("SELECT
                    callsign,
                    timestamp,
                    comment,
                    counter,
                    CASE
                        WHEN comment LIKE '%W3W OBJ::%' THEN 'W3W'
                        WHEN comment LIKE '%APRS OBJ::%' THEN 'APRS'
                    END AS objType,
                    SUBSTRING(comment, -18, 8) AS lat,
                    SUBSTRING(comment, -9, 8) AS lng,
                    CONCAT('[', SUBSTRING(comment, -18, 8), ',', SUBSTRING(comment, -9, 8), ']') AS koords
                FROM (
                    SELECT
                        callsign,
                        timestamp,
                        comment,
                        @counter := IF(callsign = @prev_c, @counter + 1, 1) AS counter,
                        @prev_c := callsign
                    FROM
                        TimeLog,
                        (SELECT @counter := 0, @prev_c := NULL) AS init
                    WHERE
                        netID = 9071
                        AND comment LIKE '%OBJ:%'
                    ORDER BY
                        callsign,
                        timestamp
                ) AS s;      
        ");
          
        echo "<br>sql3: <br>$sql<br><br>";
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
          $allcallList      = "";
          $alllatlngs       = "";
          

foreach($db_found->query($sql) as $row) {
    $koords = $row[koords];
    $callsign = $row[callsign];

        
    $objType = "$row[objType]";
    $comment = "$row[comment]";            
    $comm1   = $comm2 = $comm3 = $comm4 = $comm5 = '';
};

echo "<br>@end koords: $koords, callsign: $callsign, comment: $comment";
?>
        
 
