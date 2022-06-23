<?php
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			  
   $q = 3818;
   //$q = 4425;
   
   /*
   $stmt = $db_found->prepare("
                SELECT GROUP_CONCAT(CONCAT(
                    'var ',callsign,recordID,' = L.marker([',x(latlng),y(latlng),']).bindPopup("',comment,'")')) as layer
                  FROM TimeLog 
                 WHERE netID = $q
             ");
    $stmt->execute();
    	$result = $stmt->fetch();
    		$layer = $result[layer];
                echo ("$layer");
     */
   
   // How many distinct callsigns have objects associated with them? 
   // To include the callsign do it like this;
   // SELECT DISTINCT callsign, CONCAT('$',callsign,'objBounds = L.latLngBounds( [',
   $sql = (" SELECT callsign, 
                    CONCAT(callsign,'OBJ') as callOBJ,
                    COUNT(callsign) as numofcs, 
                    CONCAT ('var ',callsign,'OBJ = L.latLngBounds( [', GROUP_CONCAT('[',x(latlng),',',y(latlng),']'),']);') as objBounds  
               FROM TimeLog 
              WHERE netID = $q 
                AND callsign <> 'GENCOMM'
                AND comment LIKE '%OBJ%'
              GROUP BY callsign
          ");
        
           //$cntr = 0;
           $lastcall = '';  // to keep track of unique calls in the if loop inside the for loop below
          // $callOBJb = 'var callOBJb = [';
           $callOBJb = '';
           
           $callsList = '';
           foreach($db_found->query($sql) as $row) {
               //$callsList .= "$row[callsign],";
               //$cntr ++;
               //$thiscs = $row[callsign];        // current callsign being processed in if loop
               $objBounds .= $row[objBounds];
               
               
               for ($i=1; $i <= $row[numofcs]; $i++) {
                   $thiscall = $row[callsign];   // current callsign being processed in if loop
                // We want the number to always have two digits, so add 0 to the 1 through 9
                   $zerocntr = str_pad($i, 2, "0", STR_PAD_LEFT);
                        $OML .= "$row[callsign]$zerocntr,";
                        
                   // this is to create names for each of the objBounds values in map.php
                   if ( $thiscall <> $lastcall ) {
                        $callOBJb .= "$row[callOBJ],";  
                        $callsList .= "'$row[callsign]',";
                        //echo "callsList= $callsList<br>";
                   } // end of the if loop
                   $lastcall = "$row[callsign]";   // the last call processed in the loop
                   
               } // end of for loop
           } // end foreach of distinct callsigns
           
           
           //$callsList = '[$callsList]';
           
           // Create the object marker list 
           $OBJMarkerList = 'var OBJMarkerList = L.layerGroup(['.$OML.']);';
   
    
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
                    counter,
                    CONCAT('[',x(latlng),',',y(latlng),']') as koords
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
          
          $objMarkers       = "";

          $listofMarkers    = "";
          $ObjectList       = "var ObjectList = L.layerGroup([";
          $overlayListNames = '"Objects":';
        
          
    foreach($db_found->query($sql) as $row) {
        
        $dup = 0;
        if(id==144) {$dup =50;}
        
        $markNO     = ''; // the marker number (might be alpha)
     // pad the first 9 markers with a zero
        $zerocntr   = str_pad($row[counter], 2, "0", STR_PAD_LEFT);
        $markername = "images/markers/marker$zerocntr.png";
        //$koords     = "$row[lat],$row[lng]";
        //$tactical   = "$row[callsign]-$zerocntr";
        $objmrkr    = "$row[callsign]$zerocntr";
        $markNO     = "O$zerocntr";
        
        $gs = gridsquare($row[lat], $row[lng]); 
       // echo "gridsquare= $gs <br>";
                
        //$MarkerName = "$row[class]Markers";
        $icon = "";

        //$objBounds        .= "[$koords],";  //echo "<br>objBounds: $objBounds<br>";
        
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
            $div1 = "<div class='xx'>OBJ:<br>$objmrkr<br></div><div class='gg'>W3W: $w3w</div>";                          //echo "$div1<br>";   
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
                echo ($objMarkers);
          
    };  // End of the foreach row
    
        $callsList = substr($callsList, 0, -1)."";
        
        $callOBJb = substr($callOBJb, 0, -1).""; // this becomes an array on JS s
        //echo($callOBJb);
            
        $objMarkers = substr($objMarkers, 0, -1).";\n";      // echo ("objMarkers= <br>$objMarkers");    
?>