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

   $q = 9114;
      
   $sql = (" SELECT callsign, 
                    CONCAT(callsign,'OBJ') as callOBJ,
                    COUNT(callsign) as numofcs, 
                    CONCAT ('var ',callsign,'OBJ = L.latLngBounds( [' , GROUP_CONCAT('[',SUBSTRING(comment, -18, 8),',',SUBSTRING(comment, -9, 8) ,']'),']);') as objBounds,
                    
                    CONCAT (' [', GROUP_CONCAT('[',SUBSTRING(comment, -18, 8),',',SUBSTRING(comment, -9, 8),']'),'],') as arrBounds,
                    
                    CONCAT (callsign,'arr') as allnameBounds
               FROM TimeLog 
              WHERE netID = $q 
                AND callsign <> 'GENCOMM'
                AND comment LIKE '%OBJ::%' /* or comment LIKE '%COM::%' */
              GROUP BY callsign
              ORDER BY callsign, timestamp
          ");
          
          //echo "First sql:<br> $sql <br><br>";
    
        $allnameBounds = "";
        $allPoints = "";
        $oByersCnt = 0;
        
     foreach($db_found->query($sql) as $row) {
         $objBounds .= "$row[objBounds]";    
         $oByersCnt  = $oByersCnt + 1;
         
         $allnameBounds .= "'$row[allnameBounds]',";
         $objMiddle .= "$row[callsign]OBJ.getCenter();";
         $allPoints .= "$row[arrBounds]";
         
         $objPadit  .= "var $row[callsign]PAD    = $row[callsign]OBJ.pad(.075);";
         $objSW     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthWest();";
         $objNW     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthWest();";
         $objNE     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthEast();";
         $objSE     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthEast();";
         
        // //echo ("$objPadit");
            // var W0DLKPAD = W0DLKOBJ.pad(.075);
         
     } // end of foreach loop 
     
     $oByers = "var oByers = $oByersCnt";
     
     //echo "objSW: $objSW <br>";
     //echo "oByers: $oByers <br><br>";
     
        // This creates a lat/lon list for each callsign with objects. This is used in
        // the map.php program in the polyline function
        $sqlk = ("SELECT CONCAT(
                            'var ',
                            callsign,
                            'latlngs = [',
                            GROUP_CONCAT(
                                CONCAT('[', SUBSTRING(comment, -18, 8),
                                ',',
                                SUBSTRING(comment, -9, 8),
                                ']')
                            ),
                            ']'
                        ) AS allKoords
                    FROM TimeLog
                   WHERE netID = 9114 AND COMMENT LIKE '%OBJ:%'
                   GROUP BY callsign
                ");
                
        //echo "sqlk:<br> $sqlk <br><br>";
                
            foreach($db_found->query($sqlk) as $row) {
                $alltheKoords .= $row[allKoords].';';
            }
             
     //echo "alltheKoords:<br>$alltheKoords<br><br>";
      
        $sql = ("SELECT callsign, timestamp, comment, counter,
                	CASE 
                    	WHEN comment LIKE '%W3W OBJ:%'  THEN  'W3W'
                        WHEN comment LIKE '%APRS OBJ:%' THEN 'APRS' 
                    END AS 'objType',           
	              
	                SUBSTRING(comment, -18, 8) AS lat,
                    SUBSTRING(comment, -9, 8) AS lng,
                   
                    CONCAT('[',SUBSTRING(comment, -18, 8),',',SUBSTRING(comment, -9, 8),']') as koords         
               FROM (
             SELECT callsign, timestamp, comment,  
              	    SUBSTRING(comment, -18, 8), SUBSTRING(comment, -9, 8),
                        @counter := if (callsign = @prev_c, @counter + 1, 1) counter,
                        @prev_c := callsign
               FROM TimeLog, (select @counter := 0, @prev_c := null) init
              WHERE netID = $q
                AND comment LIKE '%OBJ:%' 
              ORDER BY callsign, timestamp ) s         
          ");
          
        //echo "3rd sql:<br> $sql <br><br>";
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
          $allcallList      = "";
          $alllatlngs       = "";
          
foreach($db_found->query($sql) as $row) {
    $koords   = "$row[koords]";
    $callsign = "$row[callsign]";  
    $objType  = "$row[objType]";
    $comment  = "$row[comment];"; 
    
    //echo "$comment<br><br>";
               
    //$comm1 = $comm2 = $comm3 = $comm4 = $comm5 = '';
    //$pos1 = $pos2 = 0;
    
    //$comment = "LOCΔ:APRS OBJ::wa0tjt-1 & 1 Driveway & Keith and Deb from KCMO & ///mice.beak.glimmer & N Ames Ave & NW 60th Ct & 39.20283,-94.60267";

    $pos1 = strpos($comment, 'OBJ::') + 5;
    $pos2 = strpos($comment, ' & ');
    
    $comm51 = substr($comment, $pos1, $pos2 - $pos1);
    echo "comm51: $comm51 <br><br>";
    
    $variableArray = [];
    $startPos = $pos2 + 3;
    $index = 1;
    
    while (($endPos = strpos($comment, ' & ', $startPos)) !== false) {
        $variableArray[] = trim(substr($comment, $startPos, $endPos - $startPos));
        $startPos = $endPos + 3;
        $index++;
    }
    
    $variableArray[] = trim(substr($comment, $startPos));
    
    // Assign variables dynamically
    for ($i = 0; $i < count($variableArray); $i++) {
        ${'comm' . ($i + 1)} = $variableArray[$i];
    }
    
    // Output the variables
    echo "comm1: $comm1 <br>";
    echo "comm2: $comm2 <br>";
    echo "comm3: $comm3 <br>";
    echo "comm4: $comm4 <br>";
    echo "comm5: $comm5 <br>";

        
    // Switch is used to break apart the comment line in the TimeLog table for easier
    // additon to the marker pop-ups.
   
  /*  switch ($objType) {
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
            // the APRES call
            $pos1  = strpos($comment,'OBJ::')+5;     
            $pos2  = strpos($comment, ' & ');
            $comm5 = substr($comment, $pos1, $pos2-$pos1);
                echo "comm5: $comm5 <br><br>";
                
            // the APRS OBJ
            $pos1  = stripos($comment,'&');    
            //$pos2  = strpos($comment,'&', $pos1+1);
            $comm3 = substr($comment, $pos2, stripos($comment,$pos2,$pos2+1));
                echo "pos1:  $pos1 <br>";
                echo "pos2:  $pos2 <br>";
                echo "comm3: $comm3 <br><br>";
                
            // the what 3 words
            $pos1  = strpos($comment,'///')+3;    
            $pos2  = strpos($comment, 'Cross');
            $comm1 = trim(substr($comment, $pos1, $pos2-$pos1));
            // the cross roads
            $pos1  = strpos($comment,'Roads:')+6; 
            $pos2  = strpos($comment, 'Object:');
            $comm2 = substr($comment, $pos1, $pos2-$pos1);     
            // the object description
            $pos1  = strpos($comment,'Object:')+8; 
            $comm4 = substr($comment, $pos1);
            break;  
    } // end switch */
           
   /*
    echo "1 $comm0 <br> $comm1<br><br> ";
    echo "pos1: $pos1 <br><br>";
    echo "pos2: $pos2 <br><br>";
    echo "comm5: $comm5 <br><br>";
   /*
    echo "2 $comm0 <br> $comm2<br><br> ";
    echo "3 $comm0 <br> $comm3<br><br> ";
    echo "4 $comm0 <br> $comm4<br><br> ";
    echo "5 $comm0 <br> $comm5<br><br> "; 
   */
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
        
        //echo "<br>gs: $gs <br>";
                
        $icon = "";
        
        $OBJMarkerList .= "$objmrkr,";  
       
        $comment = "$row[comment]";
 
            $div1 = "<div class='xx' style='text-transform:uppercase;'>OBJ:<br>$objmrkr<br><br></div>
            
                     /*<div style='color:red; font-weight: bold; font-size:14pt;'>Object Description:<br>$comm4</div>*/
                     
                     <div class='gg'><br>LOCATION: $comm5<br><a href='https://what3words.com/$comm1?maptype=osm' target='_blank'>///$comm1</a><br><br>Cross Roads:<br>$comm2<br><br>Coordinates:<br>$comm3<br>Grid: $gs<br></div>";  
                     
            $div2 = "<div class='cc'>Full Comment:<br>".substr($comment,19)."<br><br></div>
            
                     <div class='xx'>Captured:<br>$row[timestamp]</div>";       
                     
    //echo "<br>div1:<br> $div1 <br><br>";   
   // echo "<br>div2: $div1 <br><br>";
   
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
    //echo "objMarkers:<br> $objMarkers <br>";
} // end foreach


 // Create corner markers for each callsign that has objects.
    $sql = ("SELECT  MIN(SUBSTRING(comment, -18, 8)) as minLat,
	                 MAX(SUBSTRING(comment, -18, 8)) as maxLat,
	                 MIN(SUBSTRING(comment, -9, 8))  as minLng,
	                 MAX(SUBSTRING(comment, -9, 8))  as maxLng,                 
	                 callsign
	            FROM TimeLog
	           WHERE netID = $q
                 AND comment LIKE '%OBJ%' 
               GROUP BY callsign
               ORDER BY callsign
           ");
           
    //echo "<br>Fourth sql:<br> $sql <br>";
          
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
                                
    	   $minLat = $row[minLat]-0.25;     ////echo "minLat= $minLat";
    	   $maxLat = $row[maxLat]+0.25;     ////echo "maxLat= $maxLat";
    	   $minLng = $row[minLng]+0.25;     ////echo "minLng= $minLng";
    	   $maxLng = $row[maxLng]-0.25;     ////echo "maxLng= $maxLng";


          // It takes 5 sets to complete the square a to b, b to c, c to d, d to e, e back to a
          //           NorthWest              NorthEast           SouthEast            SouthWest              same as first
          //       [[$maxLat, $maxLng],    [$maxLat, $minLng ], [$minLat, $minLng ], [$minLat, $maxLng ],  [$maxLat, $maxLng]]";  
           
          
          // in ob5 I use $row[callsign]OBJ instead of PAD because there is no padding on the center, its the center       
        if ($thecall <> '$row[callsign]') {	
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
           
        var $row[callsign]ob6 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthWest() ),{
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
           title:'ob6'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$maxLng+'<br>The Objects SW Corner');
           ";        
          
        $OBJCornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob5,";

        // It talkes 5 markers to close a square a to b, b to c, c to d, d to e, e to a
        $KornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob6,";
          
          $thecall = '$row[callsign]'; // reset the value
          
        } // end of if loop
    $cmn++;
    }; // end foreach loop
    
    //echo objMarkers:<br> "$objMarkers";
      
    $allPoints = rtrim($allPoints,",");
       //echo allPoints:<br> "$allPoints";
       
    $allnameBounds = "let allnameBounds = [$allnameBounds];";
       //echo "$allnameBounds"; // 
      
    $allcallList = "var allcallList =[$allcallList];";
       // echo "$allcallList";
      
    $uniqueCallList = "var uniqueCallList = [$uniqueCallList];";
       //echo "$uniqueCallList"; 

    $KornerList = "var KornerList = L.layerGroup([$KornerList]);";
      //echo "$KornerList";
    
    $OBJCornerList = "var OBJCornerList = L.layerGroup([$OBJCornerList]);";
      //echo "$OBJCornerList";

    $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);"; 
     //echo "$OBJMarkerList";
        
?>
  