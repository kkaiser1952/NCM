<?php
    // objMarkers.php
    // Updated: to remove latlng in SQL
    // This program reads the TimeLog table checking for input from W3W and/or APRS_CALL
    // Updated: 2024-09-22
    
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

   //$q = 12699;
   
   //REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', -1), ')', '') AS lng,
   
   $sql1 = ("
SELECT
    callsign,
    CONCAT(callsign, 'OBJ') AS callOBJ,
    COUNT(*) AS numofcs,
    CONCAT(callsign, 'arr') AS allnameBounds,
    CONCAT('var ', callsign, 'OBJ = L.latLngBounds([',
        '[',
        SUBSTRING_INDEX(REPLACE(SUBSTRING_INDEX(MIN(`comment`), '(', -1), ')', ''), ',', 1),
        ',',
        SUBSTRING_INDEX(REPLACE(SUBSTRING_INDEX(MIN(`comment`), '(', -1), ')', ''), ',', -1),
        '],[',
        SUBSTRING_INDEX(REPLACE(SUBSTRING_INDEX(MAX(`comment`), '(', -1), ')', ''), ',', 1),
        ',',
        SUBSTRING_INDEX(REPLACE(SUBSTRING_INDEX(MAX(`comment`), '(', -1), ')', ''), ',', -1),
        ']]);') AS objBounds,
    CONCAT('[', 
    GROUP_CONCAT(
        CONCAT(
            '[', 
            SUBSTRING_INDEX(REPLACE(SUBSTRING_INDEX(`comment`, '(', -1), ')', ''), ',', 1),
            ',',
            SUBSTRING_INDEX(REPLACE(SUBSTRING_INDEX(`comment`, '(', -1), ')', ''), ',', -1),
            ']'
        )
        ORDER BY timestamp
        SEPARATOR ','
    ),
    ']') AS arrBounds
FROM TimeLog
WHERE netID = $q -- Placeholder for netID
    AND callsign <> 'GENCOMM'
    AND (
    (`comment` LIKE 'LOC&#916:APRS%') 
        OR (`comment` LIKE 'LOC&#916:W3W%')
    )
    AND `comment` NOT LIKE 'LOC&#916:APRS MOV::%'
    AND `comment` NOT LIKE 'LOC&#916:W3W MOV::%'
    AND uniqueID <> 382982
GROUP BY callsign
ORDER BY callsign;

");
        
        ////echo "First sql:<br> $sql1 <br><br>";
          
        $allnameBounds = "";
        $allPoints = "";
        $oByersCnt = 0;
        
     foreach($db_found->query($sql1) as $row) {
         $objBounds .= "$row[objBounds]";    
         $oByersCnt .= $oByersCnt + 1;
         
         $allnameBounds .= "'$row[allnameBounds]',";
         $objMiddle .= "$row[callsign]OBJ.getCenter();";
         $allPoints .= "$row[arrBounds]";
         
         $objPadit  .= "var $row[callsign]PAD    = $row[callsign]OBJ.pad(.075);";
         $objSW     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthWest();";
         $objNW     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthWest();";
         $objNE     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthEast();";
         $objSE     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthEast();";
         
     } // end of foreach loop 
     
     ////echo $objMiddle;
     
     // Count of number of callsigns, will only be 1 if only 1 person being entered
     $oByers = "var oByers = $oByersCnt";
     //echo "oByers: $oByers<br><br>";
     
        // This creates a lat/lon list for each callsign with objects. This is used in
        // the map.php program in the polyline function
        $sql2 = ("SELECT CONCAT(
                    'var ',
                    callsign,
                    'latlngs = [',
                    GROUP_CONCAT(
                        CONCAT(
                            '[',
                            SUBSTRING(REPLACE(SUBSTRING(comment, -18, 17), ')', ''), 2),
                            ',',
                            SUBSTRING(REPLACE(SUBSTRING(comment, -9, 8), ')', ''), 2),
                            ']'
                        )
                    ),
                    ']'
                ) AS allKoords
                FROM TimeLog
                WHERE netID = $q
                AND (
                    (`comment` LIKE 'LOC&#916:APRS%') 
                        OR (`comment` LIKE 'LOC&#916:W3W%')
                    )
                    AND `comment` NOT LIKE 'LOC&#916:APRS MOV::%'
                    AND `comment` NOT LIKE 'LOC&#916:W3W MOV::%'
                GROUP BY callsign
                ORDER BY timestamp ASC;

                ");
                
            ////echo "<br><br>Second sql2:<br> $sql2 <br><br>";
                
            foreach($db_found->query($sql2) as $row) {
                $alltheKoords .= $row[allKoords].';';
            }
             
             // all the cords for each callsign
        //echo "alltheKoords:<br>$alltheKoords<br><br>";
      
        $sql3 = ("SELECT callsign, timestamp, comment, counter,
                	CASE 
                    	WHEN comment LIKE '%W3W OBJ::%'  THEN  'W3W'
                    	WHEN comment LIKE '%W3W COM::%'  THEN  'W3W'
                        WHEN comment LIKE '%APRS OBJ::%' THEN 'APRS' 
                        WHEN comment LIKE '%APRS COM::%' THEN 'APRS' 
                    END AS 'objType',           
	              
	                SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', 1) AS lat,
	                
                    REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', -1), ')', '') AS lng,
                    
                    CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', 1), ',', 
                    REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', -1), ')', '')) AS koords

               FROM (
             SELECT callsign, timestamp, comment,  
              	    SUBSTRING(comment, -18, 8), SUBSTRING(comment, -9, 8),
                        @counter := if (callsign = @prev_c, @counter + 1, 1) counter,
                        @prev_c := callsign
               FROM TimeLog, (select @counter := 0, @prev_c := null) init
              WHERE netID = $q        
                AND (
                    (`comment` LIKE 'LOC&#916:APRS%') 
                        OR (`comment` LIKE 'LOC&#916:W3W%')
                    )
                    AND `comment` NOT LIKE 'LOC&#916:APRS MOV::%'
                    AND `comment` NOT LIKE 'LOC&#916:W3W MOV::%'
              ORDER BY callsign, timestamp ASC) s         
          ");
          
          // AND (comment LIKE 'LOC&#916:APRS%' OR comment LIKE 'LOC&#916:W3W%')
          // above working well
        ////echo "<br><br>3rd sql3:<br> $sql3 <br><br>";
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
          $allcallList      = "";
          $alllatlngs       = "";
          
foreach($db_found->query($sql3) as $row) {
    $koords   = "$row[koords]";
    $callsign = "$row[callsign]";  
    $objType  = "$row[objType]";
    $comment  = "$row[comment];"; 
    $lat      = "$row[lat];";
    $lng      = "$row[lng];";
    
    //echo "lat: $lat  lng: $lng<br><br>";
    //echo "comment: $comment<br>koords: $koords<br>callsign: $callsign<br>objType: $objType<br><br>";
    
    switch ($objType) {
    case "W3W":
        $pos1 = strpos($comment, 'W3W::') + 5;
        $pos2 = strpos($comment, ' : ');
        
        $aprs_call = substr($comment, $pos1, $pos2 - $pos1);
        //echo "aprs_call: $aprs_call <br><br>";   
        break;
    case "APRS":
        $pos1 = strpos($comment, 'OBJ::') + 5;
        $pos2 = strpos($comment, ' : ');
        
        $aprs_call = substr($comment, $pos1, $pos2 - $pos1);
        //echo "aprs_call: $aprs_call <br><br>";
        break;
    } // end switch
    
    $variableArray = [];
    $startPos = $pos2 + 3;
    $index = 1;
    
    while (($endPos = strpos($comment, ' : ', $startPos)) !== false) {
        $variableArray[] = trim(substr($comment, $startPos, $endPos - $startPos));
        $startPos = $endPos + 3;
        $index++;
    }
    
    $variableArray[] = trim(substr($comment, $startPos));
    
    // Assign variables dynamically
    for ($i = 0; $i < count($variableArray); $i++) {
        ${'comm' . ($i + 1)} = $variableArray[$i];
    }
    
     // this will be the count of markers at the same lat/lng for tilting
    // the marker on the map for duplicates   the rotational angle 
    $dup = 0;
        //if(id==144) {$dup =50;} // what is this?
        
        $markNO     = ''; // the marker number (might be alpha)
        
        // pad the first 9 markers with a zero
        $zerocntr   = str_pad($row[counter], 2, "0", STR_PAD_LEFT);
        $markername = "images/markers/marker$zerocntr.png";
        $objmrkr    = "$row[callsign]$zerocntr";
        $markNO     = "0$zerocntr";
        
        $allcallList .= "'$row[callsign]',";
               
        $gs = gridsquare($row[lat], $row[lng]); 
        //$gs = gridsquare($row[koords]);
        
        ////echo "<br>gs: $gs<br>";
                
        $icon = "";
        
        $OBJMarkerList .= "$objmrkr,";  
        //echo "objmarkerlist 1: $OBJMarkerList<br><br>";
       
        $comment = "$row[comment]";
 
        // Content when an object marker is clicked.
        $div1 = "<div class='xx' style='text-transform:uppercase;'>
                    OBJ: $objmrkr
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> $comm4 & $comm5
                 <br><br>
                    What3Words:<br> $comm3
                 <br><br>
                    Grid Square:<br> $gs &nbsp;&nbsp;&nbsp; AT: $koords
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>$comm2
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>$comm1
                 <br>
               
                 </div>
                ";          
                
        $div2 = "<div class='cc'>
                    Full Comment:<br>".substr($comment,19)."
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>$row[timestamp]
                <br><br>
                    objMarkers.php
                 </div>
                ";       
                     
    ////echo "<br>div1:<br> $div1 <br><br>";   
    ////echo "<br>div2: $div1 <br><br>";
   
    if (isset($row['lat']) && !empty($row['lat']) && isset($row['lng']) && !empty($row['lng'])) {
    $objMarkers .= " var $objmrkr = new L.marker(new L.LatLng($row[lat],$row[lng]),{
        rotationAngle: $dup,
        rotationOrigin: 'bottom',
        opacity: 0.75,
        contextmenu: true,
        contextmenuWidth: 140,
        contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
        icon: L.icon({iconUrl: '$markername', iconSize: [32, 34]}),
        title:`marker_$markNO`}).addTo(fg).bindPopup(`$div1<br><br>$div2`).openPopup();

    $('Objects'._icon).addClass('objmrkr');
    $('Objects'._icon).addClass('huechange');
    ";
    }
} // end foreach


 // Create corner markers for each callsign that has objects.
    $sql4 = ("SELECT  
                    MIN(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', 1)) AS minLat,
                    MAX(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', 1)) AS maxLat,
	                
                    MIN(REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', -1), ')', '')) AS minLat,
                    MAX(REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(comment, '(', -1), ',', -1), ')', '')) AS maxLat,
       
	                 callsign
	            FROM TimeLog
	           WHERE netID = $q
                  AND (
                    (`comment` LIKE 'LOC&#916:APRS%') 
                        OR (`comment` LIKE 'LOC&#916:W3W%')
                    )
                    AND `comment` NOT LIKE 'LOC&#916:APRS MOV::%'
                    AND `comment` NOT LIKE 'LOC&#916:W3W MOV::%'
                 
               GROUP BY callsign
               ORDER BY callsign
           ");
           
           //  AND (comment LIKE 'LOC&#916:APRS%' OR comment LIKE 'LOC&#916:W3W%') 
           
    ////echo "<br><br>Fourth sql:<br> $sql4 <br>";
    
/*
minLat      maxLat      minLng      maxLng      callsign
39.19667    39.20283    -94.5990    -94.6031    WA0TJT
*/

          
    $thecall = "";

    $cornerMarkers = "";
    $OBJCornerList = "";
    
    
    // colored flag markers for the corners
    $colormarkername = array("greenmarkername", "bluemarkername", "orangemarkername", "plummarkername", "lightbluemarkername","graymarkername", "goldmarkername","blackmarkername","redmarkername",
        "greenmarkername", "lightbluemarkername", "goldmarkername", "orangemarkername", "plummarkername","lightbluemarkername", "graymarkername", "blackmarkername","redmarkername");
    
    // man in the middle markers
    $maninthemiddlecolor = array("greenmanInTheMiddle", "bluemanInTheMiddle", "orangemanInTheMiddle", "plummanInTheMiddle", "lightbluemanInTheMiddle","graymanInTheMiddle", "goldmanInTheMiddle","blackmanInTheMiddle",
        "greenmanInTheMiddle","lightbluemanInTheMiddle","goldmanInTheMiddle", "orangemanInTheMiddle", "plummanInTheMiddle", "lightbluemanInTheMiddle","graymanInTheMiddle", "blackmanInTheMiddle",);
    
    // cmn = Color Marker Count
    $cmn = 0; 
    $uniqueCallList = "";
    
    foreach($db_found->query($sql4) as $row) {
           $callsign = $row[callsign];      
                                
           // The 0.25 is to make the square every so little bigger.
    	   $minLat = $row[minLat]-0.25;     //////echo "minLat= $minLat";
    	   $maxLat = $row[maxLat]+0.25;     //////echo "maxLat= $maxLat";
    	   $minLng = $row[minLng]+0.25;     //////echo "minLng= $minLng";
    	   $maxLng = $row[maxLng]-0.25;     //////echo "maxLng= $maxLng";


          // It takes 5 sets to complete the square 
          // a to b, b to c, c to d, d to e, e back to a  
           
          // in ob5 I use $row[callsign]OBJ instead of PAD because there is no padding on the center, its the center       
        if ($thecall <> '$row[callsign]') {	
            $uniqueCallList .= "'$row[callsign]',";
           // $uniqueCallList .= CONCAT('$row[callsign]', 'latlngs');
           //var uniqueCallList = ['W0DLKlatlngs', 'WA0TJTlatlngs'];
            
            // Add 1 to the counter
            $cmn++;
            	
            	// The colormarkername iconSize was [200,200] 2024-01-12
    		$cornerMarkers .=
        "var $row[callsign]ob1 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthWest() ),{   
    		contextmenu: true, 
    		contextmenuWidth: 140, 
    		contextmenuItems: [{ 
            text: 'Click here to add mileage circles', 
            callback: circleKoords}], 
            icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [50,50] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$maxLng+'<br>The Objects SW Corner');
                        
        var $row[callsign]ob2 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthWest() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], 
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [50,50] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NW<br>'+$maxLat+','+$maxLng+'<br>The Objects NW Corner');
                           
        var $row[callsign]ob3 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], 
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [50,50] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NE<br>'+$maxLat+','+$minLng+'<br>The Objects NE Corner');
                           
        var $row[callsign]ob4 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [50,50] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SE<br>'+$minLat+','+$minLng+'<br>The Objects SE Corner');
           
        var $row[callsign]ob6 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthWest() ),{
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [50,50] }),
           title:'ob6'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$maxLng+'<br>The Objects SW Corner');
           
         var $row[callsign]ob5 = new L.marker(new L.latLng( $row[callsign]PAD.getCenter() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add object mileage circles', callback: circleKoords}],   
           icon: L.icon({iconUrl: $maninthemiddlecolor[$cmn] , iconSize: [225,225] }),     
           title:'ob5'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]CT<br>'+$minLat+','+$minLng+'<br>The Objects Center Marker');
           ";        
          
        $OBJCornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob5,";

        // It talkes 5 markers to close a square a to b, b to c, c to d, d to e, e to a
        $KornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob6,";
          
          $thecall = '$row[callsign]'; // reset the value
          
        } // end of if loop
    $cmn++;
    }; // end foreach loop
    
    //echo "KornerList: $KornerList<br><br>";
    
       //echo "objMarkers: $objMarkers<br><br>";
      
    $allPoints = rtrim($allPoints,",");
       //echo "allPoints:<br> $allPoints<br><br>";
       
    $allnameBounds = "let allnameBounds = [$allnameBounds];";
       //echo "$allnameBounds<br><br>"; // 
      
    $allcallList = "var allcallList =[$allcallList];";
       //echo "$allcallList<br><br>";
      
    $uniqueCallList = "var uniqueCallList = [$uniqueCallList];";
       //echo "$uniqueCallList<br><br>"; 

    $KornerList = "var KornerList = L.layerGroup([$KornerList]);";
      //echo "$KornerList<br><br>";
    
    $OBJCornerList = "var OBJCornerList = L.layerGroup([$OBJCornerList]);";
      //echo "$OBJCornerList<br><br>";

    $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);"; 
    
     //echo "objmarkerlist 2: $OBJMarkerList<br><br>";
     //var OBJMarkerList = L.layerGroup([WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,]);
        
echo "
<script>
function createPolylines(map) {
    var colors = ['red', 'blue', 'green', 'purple', 'orange', 'yellow', 'pink', 'brown', 'gray', 'black'];
    
    uniqueCallList.forEach(function(callsign, index) {
        var latlngs = window[callsign + 'latlngs'];
        if (latlngs && latlngs.length >= 2) {
            var color = colors[index % colors.length];
            var polyline = L.polyline(latlngs, {color: color, weight: 3}).addTo(map);
            console.log('Created polyline for ' + callsign, polyline);
        }
    });
}
</script>
";
?>