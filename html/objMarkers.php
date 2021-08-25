<?php
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
  
   // $q = 3818;
   
    
   // Get TimeLog information about possible objects 
   // must leave the latlng in the selects, it errors out without it.
   $sql = (" SELECT callsign, 
                    `timestamp`,
                    /* comment, */              
                    SUBSTRING(comment, POSITION('OBJ:' IN comment)+5, POSITION(' -> C' IN comment)) as comm1,
                    SUBSTRING(comment, POSITION('Cross' IN comment)+13, POSITION(' (' IN comment)) as comm2,
                    SUBSTRING(comment, POSITION(')' IN comment)+1) as comment,
	                latlng, 
	                x(latlng) as lat, 
	                y(latlng) as lng,
                    counter 
               FROM (
             SELECT callsign, 
              	    comment,  `timestamp`,
              	    latlng, x(latlng), y(latlng),
                        @counter := if (callsign = @prev_c, @counter + 1, 1) counter,
                        @prev_c := callsign
               FROM TimeLog, (select @counter := 0, @prev_c := null) init
              WHERE netID = $q
                AND callsign <> 'GENCOMM'
                AND comment LIKE '%OBJ%'
              ORDER BY callsign, timestamp ) s          
          ");
          
        //  echo "$sql<br><br>";
          $objMarkers = "";
          $objBounds = "[";
          $OBJMarkerList = "";
          $listofMarkers = "";
          $ObjectList = "var ObjectList = L.layerGroup([";
          $overlayListNames = '"Objects":';
          
        //  var SkyWarnList = L.layerGroup([P3, P5, P6, P7, P8, P9, P10, P11, P12, P13, C1, C2, C3, C5, C6, C7, C8, C9, C10, C11, C12, TANEY210, CTEAUELV, HWY291on210]);
          
       foreach($db_found->query($sql) as $row) {    
        
        $dup = 0;
        if(id==144) {$dup =50;}
        
        $markNO     = ''; // the marker number (might be alpha)
     // pad the first 9 markers with a zero
        $zerocntr   = str_pad($row[counter], 2, "0", STR_PAD_LEFT);
        $markername = "images/markers/marker$zerocntr.png";
        $koords     = "$row[lat],$row[lng]"; 
        $tactical   = "$row[callsign]-$zerocntr";
        $objmrkr    = "$row[callsign]$zerocntr";
        $markNO     = "O$zerocntr";
        
        $gs = gridsquare($row[lat], $row[lng]); 
       // echo "gridsquare= $gs <br>";
                
        //$MarkerName = "$row[class]Markers";
        $icon = "";
      //  $objBounds .= "[$koords],";  //echo "$objBounds";
        $objBounds .= "[$koords],";
        
        $ObjectList .=  "$objmrkr,";  
        
        $OBJMarkerList .= "$objmrkr,"; 
        
        $listofMarkers .= "$objmrkr,";
        
        $overlayListNames .= "$objmrkr,";
        
        $comment = "$row[comment]";
        
        $arr = explode("-", $row[comm1], 2);
        $w3w = $arr[0]; //echo "$w3w";
       // $w3w = substr($row[comm1],0); echo "$w3w";
        $arr = explode("(", $row[comm2], 2);
        $cr  = $arr[0]; //echo "$cr";
        
        
        $div1 = "<div class='xx'>OBJ: $objmrkr<br></div><div class='gg'>W3W: $w3w</div>";                          //echo "$div1<br>";   
        $div2 = "<div class='cc'>Comment:<br>$comment</div>";               //echo "$div2<br>";
        $div3 = "<div class='bb'><br>Cross Roads:<br>$cr</div><br><div class='gg'>$row[lat],$row[lng]<br>Grid: $gs<br><br>Captured:<br>$row[timestamp]</div>";  //echo "$div3<br>";
        
	    
        $objMarkers .= " var $objmrkr = new L.marker(new L.LatLng($row[lat],$row[lng]),{
                            rotationAngle: $dup, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: '$markername', iconSize: [32, 34]}),
                            title:`marker_$markNO`}).addTo(fg).bindPopup(`$div1<br>$div2<br>$div3`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');                                               
                       "; // End of objMarkers
      
       };  // End of the foreach  
        
    $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);";
    
    // find the bounds of these markers
    $sql = (" SELECT MIN(x(latlng))  as minLat,
	                 MAX(x(latlng))  as maxLat,
	                 MIN(y(latlng)) as minLng,
	                 MAX(y(latlng)) as maxLng
	            FROM TimeLog
	           WHERE netID = 3818
                 AND comment LIKE '%OBJ%'
                 AND callsign <> 'GENCOMM'
           ");   
           
       foreach($db_found->query($sql) as $objCorners) {
    	   $OminLat = $objCorners[minLat]-0.05;
    	   $OmaxLat = $objCorners[maxLat]+0.05;
    	   $OminLng = $objCorners[minLng]+0.05;
    	   $OmaxLng = $objCorners[maxLng]-0.05;
    	   
    	   $Objpoly = " $OmaxLat $OmaxLng  , $OmaxLat $OminLng  , $OminLat $OminLng  , $OminLat $OmaxLng  , $OmaxLat $OmaxLng  ";
	   };	  
	   
	   // This var is used to find the lanlngBounds and hence determine the center of the important area of the map
       //                 NorthWest            NorthEast           SouthEast            SouthWest           same as first
       $cntObjPoints = "[[$OmaxLat, $OmaxLng], [$OmaxLat, $OminLng ], [$OminLat, $OminLng ], [$OminLat, $OmaxLng ], [$OmaxLat, $OmaxLng]]";

    
    //echo "OBJ vars=<br><br>";  
        $ObjectList = substr($ObjectList, 0, -1)."]);\n";          //echo ("ObjectList=<br>$ObjectList");
    // replace last comma with closed square bracket, or a comma or whatever....       
        $objBounds  = substr($objBounds, 0, -1)."]";               //echo ("$objBounds");     
            if ($objBounds == ']') {$objBounds = '';}  
        $$OBJMarkerList = substr($OBJMarkerList, 0, -1)."]);";     //echo ("OBJMarkerList= <br>$OBJMarkerList");
      //  $$POIMarkerList = substr($POIMarkerList, 0, -1)."]);\n"; //echo ("POIMarkerList= <br>$POIMarkerList<br><br>");
        $objMarkers = substr($objMarkers, 0, -1).";\n";            //echo ("objMarkers= <br>$objMarkers");
               
        $listofMarkers = substr($listofMarkers, 0, -1)."";         //echo ("listofMarkers= <br>$listofMarkers<br><br>");       
        $overlayListNames = substr($overlayListNames, 0, -1)."";   //echo ("overlayListNames= <br>$overlayListNames");  
		    
?>