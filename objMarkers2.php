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

   $q = 9678;
      
   $sql = (" SELECT
    callsign,
    CONCAT(callsign, 'OBJ') AS callOBJ,
    COUNT(callsign) AS numofcs,
    CONCAT('var ', callsign, 'OBJ = L.latLngBounds([', GROUP_CONCAT('[', SUBSTRING(comment, -18, 8), ',', SUBSTRING(comment, -9, 8), ']'), ']);') AS objBounds,
    CONCAT('[', GROUP_CONCAT('[', SUBSTRING(comment, -18, 8), ',', SUBSTRING(comment, -9, 8), ']'), '],') AS arrBounds,
    CONCAT(callsign, 'arr') AS allnameBounds
FROM (
    SELECT callsign, comment
    FROM TimeLog
    WHERE netID = $q AND callsign <> 'GENCOMM'
        AND comment LIKE '%OBJ::%' /* or comment LIKE '%COM::%' */
) AS filtered_data
GROUP BY callsign
ORDER BY callsign, timestamp;

          ");
          
         echo "First sql:<br> $sql <br><br>";
          
    
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
         
     } // end of foreach loop 
     
     $oByers = "var oByers = $oByersCnt";
     
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
                   WHERE netID = $q
                     AND COMMENT LIKE '%OBJ::%'
                   GROUP BY callsign
                ");
                
        //echo "sqlk:<br> $sqlk <br><br>";
                
            foreach($db_found->query($sqlk) as $row) {
                $alltheKoords .= $row[allKoords].';';
            }
             
     //echo "alltheKoords:<br>$alltheKoords<br><br>";
      
        $sql = ("SELECT callsign, timestamp, comment, counter,
                	CASE 
                    	WHEN comment LIKE '%W3W OBJ::%'  THEN  'W3W'
                        WHEN comment LIKE '%APRS OBJ::%' THEN 'APRS' 
                    END AS 'objType',           
	              
	                SUBSTRING(comment, -18, 8) AS lat,
                    SUBSTRING(comment, -9, 8) AS lng,
                   
                    CONCAT(SUBSTRING(comment, -18, 8),',',SUBSTRING(comment, -9, 8)) as koords         
               FROM (
             SELECT callsign, timestamp, comment,  
              	    SUBSTRING(comment, -18, 8), SUBSTRING(comment, -9, 8),
                        @counter := if (callsign = @prev_c, @counter + 1, 1) counter,
                        @prev_c := callsign
               FROM TimeLog, (select @counter := 0, @prev_c := null) init
              WHERE netID = $q
                AND comment LIKE '%OBJ::%' 
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
    
    //$comment = "LOCΔ:APRS OBJ::wa0tjt-1 : 1 Driveway : Keith and Deb from KCMO : ///mice.beak.glimmer & N Ames Ave & NW 60th Ct : 39.20283,-94.60267";
    
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
    

    //$pos1 = strpos($comment, 'OBJ::') + 5;
    //$pos2 = strpos($comment, ' & ');
    
    //$aprs_call = substr($comment, $pos1, $pos2 - $pos1);
    //echo "aprs_call: $aprs_call <br><br>";
    
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
    
    // Output the variables
    /*
    echo "<br>aprs_call:  $aprs_call <br>";  // Aprs_call
    echo "comm1: $comm1 <br>";          // Entered comment
    echo "comm2: $comm2 <br>";          // From APRS comment 
    echo "comm3: $comm3 <br>";          // What3Words
    echo "comm4: $comm4 <br>";          // Crossroad
    echo "comm5: $comm5 <br>";          // koords
    echo "<br>";
    */
    /*
    aprs_call: 1134 WA0TJT-1 
    comm1: harden 
    comm2: Keith and Deb from KCMO 
    comm3: ///chum.hamstrings.conspire 
    comm4: N Harden St & NW 58th St 
    comm5: 39.19900,-94.60667; 
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
                 </div>
                ";       
                     
    //echo "<br>div1:<br> $div1 <br><br>";   
    //echo "<br>div2: $div1 <br><br>";
   
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
                 AND comment LIKE '%OBJ::%' 
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
       //echo "allPoints:<br> $allPoints";
       
    $allnameBounds = "let allnameBounds = [$allnameBounds];";
       //echo "$allnameBounds"; // 
      
    $allcallList = "var allcallList =[$allcallList];";
       //echo "$allcallList";
      
    $uniqueCallList = "var uniqueCallList = [$uniqueCallList];";
       //echo "$uniqueCallList"; 

    $KornerList = "var KornerList = L.layerGroup([$KornerList]);";
      //echo "$KornerList";
    
    $OBJCornerList = "var OBJCornerList = L.layerGroup([$OBJCornerList]);";
      //echo "$OBJCornerList";

    $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);"; 
     //echo "$OBJMarkerList";
        
?>
  