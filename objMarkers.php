<?php
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
  
    //$q = 3818;
   
    
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
              /*  AND callsign = 'wa0tjt' */
              ORDER BY callsign, timestamp ) s          
          ");
          
        //  echo "$sql<br><br>";
          $OBJMarkerList    = "";
          $objMarkers       = "";
          $objBounds        = "[";
          
          $listofMarkers    = "";
          $ObjectList       = "var ObjectList = L.layerGroup([";
          $overlayListNames = '"Objects":';
          
          //echo "<br>$objMarkers  $objBounds  $OBJMarkerList  $listofMarkers  $ObjectList  $overlayListNames<br>";
          
       foreach($db_found->query($sql) as $row) {
        
        $dup = 0;
        if(id==144) {$dup =50;}
        
        $markNO     = ''; // the marker number (might be alpha)
     // pad the first 9 markers with a zero
        $zerocntr   = str_pad($row[counter], 2, "0", STR_PAD_LEFT);
        $markername = "images/markers/marker$zerocntr.png";
        $koords     = "$row[lat],$row[lng]";   // echo "<br>$row[callsign] --> $koords";
        $tactical   = "$row[callsign]-$zerocntr";
        $objmrkr    = "$row[callsign]$zerocntr";
        $markNO     = "O$zerocntr";
        
        $gs = gridsquare($row[lat], $row[lng]); 
       // echo "gridsquare= $gs <br>";
                
        //$MarkerName = "$row[class]Markers";
        $icon = "";
      //  $objBounds .= "[$koords],";  //echo "$objBounds";
        $OBJMarkerList    .= "$objmrkr,";
        $objBounds        .= "[$koords],";  //echo "<br>$objBounds<br>";
        $ObjectList       .= "$objmrkr,";  
         
        $listofMarkers    .= "$objmrkr,";
        $overlayListNames .= "$objmrkr,";       
        $comment = "$row[comment]";
        
        // get the what 3 words value
        $arr = explode("-", $row[comm1], 2);
        $w3w = $arr[0]; //echo "$w3w";

        // get the cross roads names 
        $arr = explode("(", $row[comm2], 2);
        $cr  = $arr[0]; //echo "$cr";
        
        
        // foreach callsign create a new set of objemarkers and their center and corner markers
        
            
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
          
           };  // End of the foreach row
            
        $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);";
        //echo "@109 $OBJMarkerList";
        
            // find the bounds of these markers
    /*    $sql = (" SELECT MIN(x(latlng))-0.05  as OminLat,
    	                 MAX(x(latlng))+0.05  as OmaxLat,
    	                 MIN(y(latlng))+0.05  as OminLng,
    	                 MAX(y(latlng))-0.05  as OmaxLng
    	            FROM TimeLog
    	           WHERE netID = $q
                     AND comment LIKE '%OBJ%'
                     AND callsign <> 'GENCOMM'
               ");   */
   /* Not needed ?            
        $SQL = (" SELECT 	CONCAT('[[', MAX(x(latlng))+0.05,',', MAX(y(latlng))-0.05,'],'
                   , MAX(x(latlng))+0.05,',', MIN(y(latlng))+0.05,'],'
                   , MIN(x(latlng))-0.05,',', MIN(y(latlng))+0.05,'],'
                   , MIN(x(latlng))-0.05,',', MAX(y(latlng))-0.05,'],'
                   , MAX(x(latlng))+0.05,',', MAX(y(latlng))-0.05,
                            ']]') AS cntObjPoints
    	            FROM TimeLog
    	           WHERE netID = $q
                     AND comment LIKE '%OBJ%'
                     AND callsign <> 'GENCOMM'
                     LIMIT 1
                ");
     */          
     /*      foreach($db_found->query($sql) as $objCorners) {
        	   $OminLat = $objCorners[minLat]-0.05;
        	   $OmaxLat = $objCorners[maxLat]+0.05;
        	   $OminLng = $objCorners[minLng]+0.05;
        	   $OmaxLng = $objCorners[maxLng]-0.05;
        	   
        	   $Objpoly = " $OmaxLat $OmaxLng  , $OmaxLat $OminLng  , $OminLat $OminLng  , $OminLat $OmaxLng  , $OmaxLat $OmaxLng  ";
    	   };	  */
    	   
    	   // This var is used to find the lanlngBounds and hence determine the center of the important area of the map
           //                 NorthWest            NorthEast           SouthEast            SouthWest           same as first
     //      foreach($db_found->query($sql) as $objCorners) {
     //          $cntObjPoints = $objCorners[cntObjPoints];
     //      }
           //$cntObjPoints = "[[$OmaxLat, $OmaxLng], [$OmaxLat, $OminLng ], [$OminLat, $OminLng ], [$OminLat, $OmaxLng ], [$OmaxLat, $OmaxLng]]";
        
        
        //echo "OBJ vars=<br><br>";  
   //         $ObjectList = substr($ObjectList, 0, -1)."]);\n";          //echo ("<br><br><br><br><br><br><br>ObjectList=<br>$ObjectList");
        // replace last comma with closed square bracket, or a comma or whatever....       
            $objBounds  = substr($objBounds, 0, -1)."]";                    
                if ($objBounds == ']') {$objBounds = '';}              //echo ("<br>$objBounds");
            $$OBJMarkerList = substr($OBJMarkerList, 0, -1)."]);";     //echo ("<br><br>OBJMarkerList= <br>$OBJMarkerList \n");

          //  $$POIMarkerList = substr($POIMarkerList, 0, -1)."]);\n"; //echo ("POIMarkerList= <br>$POIMarkerList<br><br>");
            $objMarkers = substr($objMarkers, 0, -1).";\n";            //echo ("objMarkers= <br>$objMarkers");
    
    /* do i need these?               
            $listofMarkers = substr($listofMarkers, 0, -1)."";         //echo ("listofMarkers= <br>$listofMarkers<br><br>");       
            $overlayListNames = substr($overlayListNames, 0, -1)."";   //echo ("overlayListNames= <br>$overlayListNames");  
	*/	    
?>