<?php
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
  
    $q = 3818;
    
    

            

   
   
   $sql = (" SELECT DISTINCT callsign FROM TimeLog WHERE netID = $q AND callsign <> 'GENCOMM'
                AND comment LIKE '%OBJ%'");
         // create a php array of the unique callsigns 
       $collecting_stations = array();
       
       
       foreach($db_found->query($sql) as $csrow) {
           $collecting_stations[] = $csrow[callsign];
           
            // create a 'varible variable' name for each callsign
          $callOML  = "$csrow[callsign]OBJMarkerList";
          $calloM   = "$csrow[callsign]objMarkers";
          $calloB   = "$csrow[callsign]objBounds";
          $callloM  = "$csrow[callsign]listofMarkers";
          $callOL   = "$csrow[callsign]ObjectList";
          $callolLN = "$csrow[callsign]overlayListNames";
          
          
           // initiate each of the above varibles
          $calloM   = "";     //objMarkers
          $calloB   = "";    //objBounds  // removed [ from ""
          $callOML  = "";    //OBJMarkerList
          $callloM  = "";    //listofMarkers
          $callOL   = "var $callOL = L.layerGroup([";  //echo "<br>initial $callOL<br>";
          $callolLN = '"Objects":';
       } 
       
          //echo "<br> TEST1: $callOML  $calloM  $calloB  $callloM  $callOL  $callolLN<br>";
          // create an array of all the callsigns that have objects
          $collecting_stations = array_unique($collecting_stations);
             //print_r($collecting_stations);     // Array ( [0] => W0DLK [22] => WA0TJT )
             
// This sets the callsign (from above) to use for the rest of the code below
foreach($collecting_stations as $callsign) {

   // Get TimeLog information about possible objects 
   // must leave the latlng in the selects, it errors out without it.
   $sql = (" SELECT callsign, 
                    `timestamp`,         
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
                AND callsign = '$callsign' /* from the foreach */
              ORDER BY callsign, timestamp ) s          
          ");
          
         //echo "<br>$sql<br><br>";
         
         
    // echo "<br> $callOML  $calloM <br>";
    foreach($db_found->query($sql) as $row) {
        
        $dup = 0;
        if(id==144) {$dup =50;}
        
        $markNO     = ''; // the marker number (might be alpha)
        // pad the first 9 markers with a zero
        $zerocntr   = str_pad($row[counter], 2, "0", STR_PAD_LEFT);
        $markername = "images/markers/marker$zerocntr.png";
        $koords     = "$row[lat],$row[lng]";           //echo "<br>$row[callsign]--> $koords<br>";
        //$tactical   = "$row[callsign]-$zerocntr";
        //$objmrkr    = "$row[callsign]$zerocntr";
        $tactical   = "$row[callsign]-$zerocntr";
        $objmrkr    = "$row[callsign]$zerocntr";
        $markNO     = "O$zerocntr";
        
        //echo "<br>$markNO  $zerocntr  $markername  $koords  $tactical  $objmrkr<br>";
        
        $gs = gridsquare($row[lat], $row[lng]); 
        // echo "gridsquare= $gs <br>";
                
        //$MarkerName = "$row[class]Markers";
        $icon = "";
        //  $calloB .= "[$koords],";  //echo "$calloB";
        $calloB   .= "[$koords]";     // echo "<br>$calloB<br>";  // removed comma after koords],
        $callOL   .= "$objmrkr,";  
        $callOML  .= "$objmrkr,";      
        $callloM  .= "$objmrkr,";
        $callolLN .= "$objmrkr,";     
        $comment   = "$row[comment]";
        
        // get the what 3 words value
        $arr = explode("-", $row[comm1], 2);
        $w3w = $arr[0]; 
        //echo "$w3w";

        // get the cross roads names 
        $arr = explode("(", $row[comm2], 2);
        $cr  = $arr[0]; //echo "$cr";
        
            
            $div1 = "<div class='xx'>OBJ: $objmrkr<br></div><div class='gg'>W3W: $w3w</div>";                          //echo "$div1<br>";   
            $div2 = "<div class='cc'>Comment:<br>$comment</div>";               //echo "$div2<br>";
            $div3 = "<div class='bb'><br>Cross Roads:<br>$cr</div><br><div class='gg'>$row[lat],$row[lng]<br>Grid: $gs<br><br>Captured:<br>$row[timestamp]</div>";  //echo "$div3<br>";
            
    	    
            $calloM .= " var $objmrkr = new L.marker(new L.LatLng($row[lat],$row[lng]),{
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
    
     //echo "<br><br><br><br><br><br><br><br>$calloB <br><br>  $callOL <br><br> $callOML <br><br> $callloM <br><br> $callolLN  <br>";
    // echo all the major variables
    //echo "<br> TEST2: $callOML  $calloM  $calloB  $callloM  $callOL  $callolLN<br>";
    //echo "<br> TEST3: $markNO  $zerocntr  $markername  $koords  $tactical  $objmrkr  $gs<br>";
            
        //$OBJMarkerList = 
        $callOML = "var $callOML = L.layerGroup([$callOML]);";
            // echo the above
            // echo "<br>callOML= $callOML<br>";
        
        // find the bounds of these markers
        $sql = (" SELECT MIN(x(latlng))  as minLat,
    	                 MAX(x(latlng))  as maxLat,
    	                 MIN(y(latlng)) as minLng,
    	                 MAX(y(latlng)) as maxLng
    	            FROM TimeLog
    	           WHERE netID = $q
                     AND comment LIKE '%OBJ%'
                     AND callsign <> 'GENCOMM'
                     AND callsign = '$callsign' /* from the foreach */
               ");   
               
               //echo "<br>$sql<br>";
               
           foreach($db_found->query($sql) as $objCorners) {
        	   $OminLat = $objCorners[minLat]-0.05;
        	   $OmaxLat = $objCorners[maxLat]+0.05;
        	   $OminLng = $objCorners[minLng]+0.05;
        	   $OmaxLng = $objCorners[maxLng]-0.05;
        	   
        	   $Objpoly = " $OmaxLat $OmaxLng  , $OmaxLat $OminLng  , $OminLat $OminLng  , $OminLat $OmaxLng  , $OmaxLat $OmaxLng  ";
    	   };	  
    	   
    	   // echo the above 
    	   // echo "<br>Objpoly= $Objpoly<br>";
    	   
    	   // This var is used to find the lanlngBounds and hence determine the center of the important area of the map
           //                 NorthWest            NorthEast           SouthEast            SouthWest           same as first
           $cntObjPoints = "[[$OmaxLat, $OmaxLng], [$OmaxLat, $OminLng ], [$OminLat, $OminLng ], [$OminLat, $OmaxLng ], [$OmaxLat, $OmaxLng]]";
             // echo the above
             // echo "<br>cntObjPoints= $cntObjPoints<br>";
        
        //echo "OBJ vars=<br><br>";  
            $callOL = substr($callOL, 0, -1)."]);\n";          //echo ("<br><br><br><br><br><br><br><br>ObjectList=<br>$calloL");
        // replace last comma with closed square bracket, or a comma or whatever....       
        /*
            $objBounds  = substr($objBounds, 0, -1)."]";               //echo ("<br>$objBounds");     
                if ($objBounds == ']') {$objBounds = '';}  
            */
            $objBounds  = substr($calloB, 0, -1)."]";                
                if ($objBounds == ']') {$calloB = '';}        // echo ("<br>$objBounds");  
            $callOML = substr($callOML, 0, -1)."]);";     //echo ("<br>callOML= <br>$callOML= <br>$callOML \n");
          //  $$POIMarkerList = substr($POIMarkerList, 0, -1)."]);\n"; //echo ("POIMarkerList= <br>$POIMarkerList<br><br>");
            $calloM = substr($calloM, 0, -1).";\n";       //echo ("$calloM= <br>$calloM");
                   
            $callloM = substr($callloM, 0, -1)."";         //echo ("listofMarkers= <br>$callloM<br><br>");       
            $callolLN = substr($callolLN, 0, -1)."";   //echo ("overlayListNames= <br>$callolLN");  
} // end first foreach
?>