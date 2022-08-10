<?php
    
    ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			
    // This is for what3words usage
    /* https://developer.what3words.com/public-api/docs#convert-to-3wa */
    require_once "Geocoder.php";
                use What3words\Geocoder\Geocoder;
              //  use What3words\Geocoder\AutoSuggestOption;
                
                $api = new Geocoder("5WHIM4GD");           

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";

  //$q = 3818;
   //$q = 4565;
   $q = 4743;
   
   
   //echo 'PHP version: ' . phpversion();
   
   // Create a layer by callsign for every object
   // Also Create a LayerGroup to make adding them to the map easier
   /*
   $sql = ("SELECT callsign, 
                   uniqueID, 
                   x(latlng) as lat, 
                   y(latlng) as lon, 
                   comment,
                   CONCAT('[',x(latlng) , y(latlng),']') as koords
              FROM TimeLog
             WHERE netID =  $q
               AND comment LIKE '%OBJ%'                      
             ORDER BY callsign, timestamp
         ");
   
    // initial values of variables
    $theCalls = "var theCalls = L.layerGroup([";
    $theBounds = "";
    
    $thecall = "";
    
    $x=0;
    $len = count($db_found->query($sql)); //echo "<br>len= $len <br>";
    foreach($db_found->query($sql) as $result) {  
        
    		$callsign = $result[callsign];
    		$recordID = $result[uniqueID];
    		$lat      = $result[lat];
    		$lon      = $result[lon];
    		$comment  = $result[comment];
    		 		
    		$OBJlayer .= "var $callsign$recordID = L.marker([$lat,$lon]).bindPopup('$comment');";
    		    		
       // To get only one of each callsign step through this loop 
       if ($thecall <> $result[callsign]) {	
            $x++;   
    		$theCalls  .= $result[callsign]."OBJ,";	  	
    		$theBounds .= "]); var ".$result[callsign]."OBJ = L.latLngBounds([[$lat , $lon]";		
    		// Reset $thecall to this callsign, test at top of if
    		$thecall = $result[callsign];
       }else if ($thecall == $result[callsign]) {
    		$theBounds .= "[$lat,$lon],"; 		
    		// Reset $thecall to this callsign, test at top of if
    		$thecall = $result[callsign];
       }

            
    }; // end foreach...
    
    $theBounds = "$theBounds]);";
    $theCalls  = "$theCalls]);";
    
    // This adds the var to the first record while removing the extra ]); stuff
    $theBounds  = substr("var ".$theBounds, 7 )."";  
    
    $objMiddle  = '';
    $objPadit   = '';
    $objSW      = '';
    $objNW      = '';
    $objNE      = '';
    $objSE      = '';
*/
   
   $sql = (" SELECT callsign, 
                    CONCAT(callsign,'OBJ') as callOBJ,
                    COUNT(callsign) as numofcs, 
                    CONCAT ('var ',callsign,'OBJ = L.latLngBounds( [', GROUP_CONCAT('[',x(latlng),',',y(latlng),']'),']);') as objBounds  
               FROM TimeLog 
              WHERE netID = $q 
                AND callsign <> 'GENCOMM'
                AND comment LIKE '%OBJ%' 
              GROUP BY callsign
              ORDER BY callsign, timestamp
          ");
     foreach($db_found->query($sql) as $row) {
         $objBounds .= "$row[objBounds]";    
         $objMiddle .= "$row[callsign]OBJ.getCenter();";
 
         $objPadit  .= "var $row[callsign]PAD    = $row[callsign]OBJ.pad(.075);";
         $objSW     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthWest();";
         $objNW     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthWest();";
         $objNE     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthEast();";
         $objSE     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthEast();";
     } // end of foreach loop 
      
        $sql = ("SELECT callsign, timestamp,
                	CASE 
                    	WHEN comment LIKE '%W3W:OBJ:%'  THEN  'W3W'
                        WHEN comment LIKE '%APRS:OBJ:%' THEN 'APRS' 
                    END AS 'objType',
            
	                comment,
	                x(latlng) as lat, 
	                y(latlng) as lng,
                    counter,
                    CONCAT('[',x(latlng),',',y(latlng),']') as koords
               FROM (
             SELECT callsign, 
              	    comment,  timestamp,
              	    latlng, x(latlng), y(latlng),
                        @counter := if (callsign = @prev_c, @counter + 1, 1) counter,
                        @prev_c := callsign
               FROM TimeLog, (select @counter := 0, @prev_c := null) init
              WHERE netID = $q
                AND comment LIKE '%OBJ:%' 
              ORDER BY callsign, timestamp ) s         
          ");
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
          $allcallList      = "";
foreach($db_found->query($sql) as $row) {
    $objType = "$row[objType]";
    $comment = "$row[comment]";            
    $comm1   = $comm2 = $comm3 = $comm4 = $comm5 = '';
        
    switch ($objType) {
        case "W3W":
            $comm0 = 'W3W';
            // the What 3 Words
            $pos1  = strpos($comment,'W3W:OBJ:')+8;  $pos2 = strpos($comment, '->');
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
/*           
    echo "1 $comm0 $comm1<br>";
    echo "2 $comm0 $comm2<br>";
    echo "3 $comm0 $comm3<br>";
    echo "4 $comm0 $comm4<br>";
    echo "5 $comm0 $comm5<br>"; 
*/
    
    $dup = 0;
        if(id==144) {$dup =50;}
        
        $markNO     = ''; // the marker number (might be alpha)
        
        // pad the first 9 markers with a zero
        $zerocntr   = str_pad($row[counter], 2, "0", STR_PAD_LEFT);
        $markername = "images/markers/marker$zerocntr.png";
        $objmrkr    = "$row[callsign]$zerocntr";
        $markNO     = "0$zerocntr";
        
        $allcallList .= "'$row[callsign]$zerocntr',";
        
        $gs = gridsquare($row[lat], $row[lng]); 
                
        $icon = "";
        
        $OBJMarkerList    .= "$objmrkr,";  
        $listofMarkers    .= "$objmrkr,";  
        $comment           = "$row[comment]";
 
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
            
            $cmn++;
            	
    		$cornerMarkers .=
           "var $row[callsign]ob1 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthWest() ),{   
    	/*	contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}], */
            icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$maxLng+'<br>The Objects SW Corner');
                        
           var $row[callsign]ob2 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthWest() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NW<br>'+$maxLat+','+$maxLng+'<br>The Objects NW Corner');
                           
           var $row[callsign]ob3 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthEast() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [200,200] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NE<br>'+$maxLat+','+$minLng+'<br>The Objects NE Corner');
                           
           var $row[callsign]ob4 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthEast() ),{
       /*    contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
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
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$minLng+'<br>The Objects SE Corner');
           ";        
          
        $OBJCornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob5,";

        // It talkes 5 markers to close a square a to b, b to c, c to d, d to e, e to a
        $KornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob6,";
          
          $thecall = $row[callsign]; // reset the value
          
        //  $objmrkrarray .= "'$row[callsign]',"; // used to change colors in map.php of the object lines between markers
        
          
        } // end of if loop
    $cmn++;
    }; // end foreach loop
    
   // $objmrkrarray =  "var objmrkrarray = [$objmrkrarray];";
    
      //echo "$listofMarkers";
      // W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,WA0TJT10,WA0TJT11,
      
    $allcallList = "var allcallList =[$allcallList];";
      
    $uniqueCallList = "var uniqueCallList = [$uniqueCallList];";

    $KornerList = "var KornerList = L.layerGroup([$KornerList]);";
    
    $OBJCornerList = "var OBJCornerList = L.layerGroup([$OBJCornerList]);";
    
    //$objMarkerListArray = "var objMarkerListArray = [$markNOArray];";
    //echo "$objMarkerListArray";
    $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);";
  
    //echo "$allcallList";
    //echo "$cornerMarkers";
    //echo "<br><br>";
    //echo "$OBJCornerList";
    //echo "<br><br>";
    //echo "$OBJMarkerList";

?>
  