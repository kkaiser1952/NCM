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

   // Switch is used to break apart the comment line in the TimeLog table for easier
    // additon to the marker pop-ups.
    switch ($objType) {
        case "W3W":
            $comm0 = 'W3W';
            // the What 3 Words
            $pos1  = strpos($comment,'W3W OBJ:')+8;  $pos2 = strpos($comment, '->');
            $comm1 = trim(substr($comment, $pos1, $pos2-$pos1));
            // the cross roads
            $pos1  = strpos($comment,'Roads:')+6;    $pos2 = strpos($comment, '(');
            $comm2 = substr($comment, $pos1, $pos2-$pos1);
            // the coordinates
            $pos1  = strpos($comment,'(')+1;        $pos2 = strpos($comment, ')');
            $comm3 = substr($comment, $pos1, $pos2-$pos1);
            // the object description
            $pos1  = strpos($comment,')')+1;    
            $comm4 = substr($comment, $pos1);
            break;
        case "APRS":
            $comm0 = 'APRS';
            // the APRES capture timestamp
            $pos1  = strpos($comment,'@:')+2;     $pos2 = strpos($comment, '(');
            $comm5 = '@ '.substr($comment, $pos1, $pos2-$pos1);
            // the coordinates
            $pos1  = strpos($comment,'(')+1;    $pos2 = strpos($comment, ')');
            $comm3 = substr($comment, $pos1, $pos2-$pos1);
            // the what 3 words
            $pos1  = strpos($comment,'///')+3;    $pos2 = strpos($comment, 'Cross');
            $comm1 = trim(substr($comment, $pos1, $pos2-$pos1));
            // the cross roads
            $pos1  = strpos($comment,'Roads:')+6; $pos2 = strpos($comment, 'Object:');
            $comm2 = substr($comment, $pos1, $pos2-$pos1);     
            // the object description
            $pos1  = strpos($comment,'Object:')+7; 
            $comm4 = substr($comment, $pos1);
            break;  
    } // end switch
         
    echo "1; $comm0 $comm1<br>";
    echo "2; $comm0 $comm2<br>";
    echo "3; $comm0 $comm3<br>";
    echo "4; $comm0 $comm4<br>";
    echo "5; $comm0 $comm5<br>"; 
 

    $dup = 0;
        if(id==144) {$dup =50;}


        
        $markNO     = ''; // the marker number (might be alpha)
        
        // pad the first 9 markers with a zero
        $zerocntr   = str_pad($row[counter], 2, "0", STR_PAD_LEFT);
        $markername = "images/markers/marker$zerocntr.png";
        $objmrkr    = "$row[callsign]$zerocntr";
        $markNO     = "0$zerocntr";
        
       
        
        $allcallList .= "'$row[callsign]',";
               
        $gs = gridsquare($row[lat], $row[lng]); 
                
        $icon = "";
        
        $OBJMarkerList .= "$objmrkr,";  
       
        $comment = "$row[comment]";
        
     //echo "<br>@end koords: $koords, callsign: $callsign, comment: $comment, <br>comm1:<br> $comm1<br>comm5:<br> $comm5<br>objMarkers: $objMarkers";
       echo "<br>zerocntr: $zerocntr, markername: $markername, objmrkr: $objmrkr, markNO; $markNO<br>allcallList: $allcallList, gs: $gs<br>";
        echo "<br>Good To Here<br><br>";
        echo "<br>div1: $div1<br><br>";
//}; // end the foreach
?> 


     $div1 = "<div class='xx' style='text-transform:uppercase;'>OBJ:<br>$objmrkr<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br>$comm4</div>
                     <div class='gg'><br>LOCATION: $comm5<br><a href='https://what3words.com/$comm1?maptype=osm' target='_blank'>///$comm1</a><br><br>Cross Roads:<br>$comm2<br><br>Coordinates:<br>$comm3<br>Grid: $gs<br></div>";  
                     
                           
            $div2 = "<div class='cc'>Full Comment:<br>".substr($comment,19)."<br><br></div>
                     <div class='xx'>Captured:<br>$row[timestamp]</div>";          
   
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
                           "; // End of objMarkers
} // end foreach



/* SUBSTRING(comment, -18, 8) AS lat,
   SUBSTRING(comment, -9, 8) AS lng

 // Create corner markers for each callsign that has objects.
    $sql = ("SELECT  MIN(x(latlng)) as minLat,
	                 MAX(x(latlng)) as maxLat,
	                 MIN(y(latlng)) as minLng,
	                 MAX(y(latlng)) as maxLng,                 
	                 callsign
	            FROM TimeLog
	           WHERE netID = $q
                 AND comment LIKE '%OBJ%' 
               GROUP BY callsign
               ORDER BY callsign
           ");
          
    $thecall = "";

    $cornerMarkers = "";
    $OBJCornerList = "";
    
    
    // colored flag markers for the corners
    $colormarkername = array("greenmarkername", "bluemarkername", "orangemarkername", "plummarkername", "lightbluemarkername","graymarkername", "goldmarkername","blackmarkername","redmarkername",
        "greenmarkername", "lightbluemarkername", "goldmarkername", "orangemarkername", "plummarkername","lightbluemarkername", "graymarkername", "blackmarkername","redmarkername");
    
    // man in the middle markers
    $maninthemiddlecolor = array("greenmanInTheMiddle", "bluemanInTheMiddle", "orangemanInTheMiddle", "plummanInTheMiddle", "lightbluemanInTheMiddle","graymanInTheMiddle", "goldmanInTheMiddle","blackmanInTheMiddle",
        "greenmanInTheMiddle","lightbluemanInTheMiddle","goldmanInTheMiddle", "orangemanInTheMiddle", "plummanInTheMiddle", "lightbluemanInTheMiddle","graymanInTheMiddle", "blackmanInTheMiddle",);
    
    $cmn = 0;
    $uniqueCallList = "";
    
    foreach($db_found->query($sql) as $row) {
           $callsign = $row[callsign];      
                                
    	   $minLat = $row[minLat]-0.25;     //echo "@216 minLat= $minLat";
    	   $maxLat = $row[maxLat]+0.25;     //echo "@217 maxLat= $maxLat";
    	   $minLng = $row[minLng]+0.25;     //echo "@218 minLng= $minLng";
    	   $maxLng = $row[maxLng]-0.25;     //echo "@219 maxLng= $maxLng";


          // It takes 5 sets to complete the square a to b, b to c, c to d, d to e, e back to a
          //           NorthWest              NorthEast           SouthEast            SouthWest              same as first
          //       [[$maxLat, $maxLng],    [$maxLat, $minLng ], [$minLat, $minLng ], [$minLat, $maxLng ],  [$maxLat, $maxLng]]";   
          
          // in ob5 I use $row[callsign]OBJ instead of PAD because there is no padding on the center, its the center       
        if ($thecall <> $row[callsign]) {	
            $uniqueCallList .= "'$row[callsign]',";
           // $uniqueCallList .= CONCAT('$row[callsign]', 'latlngs');
           //var uniqueCallList = ['W0DLKlatlngs', 'WA0TJTlatlngs'];
            
            $cmn++;
            	
    		$cornerMarkers .=
           "var $row[callsign]ob1 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthWest() ),{   
    		contextmenu: true, 
    		contextmenuWidth: 140, 
    		contextmenuItems: [{ 
            text: 'Click here to add mileage circles', 
            callback: circleKoords}], 
            icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$maxLng+'<br>The Objects SW Corner');
                        
           var $row[callsign]ob2 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthWest() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], 
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NW<br>'+$maxLat+','+$maxLng+'<br>The Objects NW Corner');
                           
           var $row[callsign]ob3 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], 
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NE<br>'+$maxLat+','+$minLng+'<br>The Objects NE Corner');
                           
           var $row[callsign]ob4 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SE<br>'+$minLat+','+$minLng+'<br>The Objects SE Corner');
                           
           var $row[callsign]ob5 = new L.marker(new L.latLng( $row[callsign]PAD.getCenter() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],   
           icon: L.icon({iconUrl: $maninthemiddlecolor[$cmn] , iconSize: [200,200] }),     
           title:'ob5'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]CT<br>'+$minLat+','+$minLng+'<br>The Objects Center Marker');
           
           /* This extra ob6 is so we can draw lines around the objects */
           var $row[callsign]ob6 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthWest() ),{
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
           title:'ob6'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$maxLng+'<br>The Objects SW Corner');
           ";        
          
        $OBJCornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob5,";

        // It talkes 5 markers to close a square a to b, b to c, c to d, d to e, e to a
        $KornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob6,";
          
          $thecall = $row[callsign]; // reset the value
          
        } // end of if loop
    $cmn++;
    }; // end foreach loop
    
    //echo "$objMarkers";
      
    $allPoints = rtrim($allPoints,",");
    //$allPoints = "var allPoints = ([$allPoints]);";
    
      // echo "$allPoints";
       //var W0DLKarr = [[39.201636,-94.602375],[39.201259,-94.603175],[39.20169,-94.603628],[39.201986,-94.603036],[39.202337,-94.602932]];
       //var WA0TJTarr = [[39.20217,-94.60233],[39.20167,-94.60167],[39.201393,-94.601576],[39.20067,-94.6015],[39.20167,-94.60217],[39.20117,-94.60167],[39.2025,-94.6025],[39.203,-94.60233],[39.203,-94.60233],[39.201016,-94.601541],[39.203,-94.60233]];
      
    $allnameBounds = "let allnameBounds = [$allnameBounds];";
        //echo "$allnameBounds"; // 
        //var allnameBounds = (['W0DLKarr','WA0TJTarr',]);
      
    $allcallList = "var allcallList =[$allcallList];";
       // echo "$allcallList";
        //var allcallList =['W0DLK01','W0DLK02','W0DLK03','W0DLK04','W0DLK05','WA0TJT01','WA0TJT02','WA0TJT03','WA0TJT04','WA0TJT05','WA0TJT06','WA0TJT07','WA0TJT08','WA0TJT09','WA0TJT10','WA0TJT11',];
      
    $uniqueCallList = "var uniqueCallList = [$uniqueCallList];";
        //echo "$uniqueCallList"; 
        // var uniqueCallList = ['W0DLKlatlngs','WA0TJTlatlngs',];

    $KornerList = "var KornerList = L.layerGroup([$KornerList]);";
        //echo "$KornerList";
        //var KornerList = L.layerGroup([W0DLKob1, W0DLKob2, W0DLKob3, W0DLKob4, W0DLKob6,WA0TJTob1, WA0TJTob2, WA0TJTob3, WA0TJTob4, WA0TJTob6,]);
    
    $OBJCornerList = "var OBJCornerList = L.layerGroup([$OBJCornerList]);";
        //echo "$OBJCornerList";
        //var OBJCornerList = L.layerGroup([W0DLKob1, W0DLKob2, W0DLKob3, W0DLKob4, W0DLKob5,WA0TJTob1, WA0TJTob2, WA0TJTob3, WA0TJTob4, WA0TJTob5,]);

   // $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);";
    $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);"; 
     //echo "$OBJMarkerList";
        // var OBJMarkerList = L.layerGroup([W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,]);
    
    //$allOftheKoords = "$alltheKoords";
    // use this with leaflet-spline to connect the dots right now its done in a different way
    
    //$alloftheKoords = " $alltheKoords";
    //echo "$allOftheKoords";
    // var W0DLKlatlngs = [[39.201636,-94.602375],[39.201259,-94.603175],[39.20169,-94.603628],[39.201986,-94.603036],[39.202337,-94.602932]];var WA0TJTlatlngs = [[39.201393,-94.601576],[39.20067,-94.6015],[39.20167,-94.60217],[39.20117,-94.60167],[39.2025,-94.6025],[39.203,-94.60233],[39.203,-94.60233],[39.201016,-94.601541],[39.203,-94.60233]];
        
?> 
          
 
