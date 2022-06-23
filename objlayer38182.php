<?php
    
    // This is an experimental method of creating markers for each of the objces reported in NCM
    
    /* Reference:  https://leafletjs.com/examples/layers-control/. */

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
    
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			  
   $q = 3818;
   
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
    $theCorners = "";
    $cornerOBJ = "";
    
    foreach($db_found->query($sql) as $row) {
           $callsign = $row[callsign];
                             
    	   $minLat = $row[minLat]-0.25;
    	   $maxLat = $row[maxLat]+0.25;
    	   $minLng = $row[minLng]+0.25;
    	   $maxLng = $row[maxLng]-0.25;

           // It takes 5 sets to complete the square a to b, b to c, c to d, d to e, e back to a
           // [[$maxLat, $maxLng], [$maxLat, $minLng ], [$minLat, $minLng ], [$minLat, $maxLng ], [$maxLat, $maxLng]]   	   
        if ($thecall <> $callsign) {	
            $theCorners .= "var ".$callsign."Corner = [[$maxLat, $maxLng], [$maxLat, $minLng ], [$minLat, $minLng ], [$minLat, $maxLng ], [$maxLat, $maxLng]];";
    	// Reset $thecall to this callsign, test at top of if
    		    $thecall = $row[callsign];
        } // end if 
    	/*
    		$cornerOBJ .=
           "var $row[callsign]ob1 = new L.marker(new L.latLng( padit.getSouthWest() ),{
    		contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects SW Corner<br>'+padit.getSouthWest()).openPopup();
            
           var $row[callsign]ob2 = new L.marker(new L.latLng( padit.getNorthWest() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ: <br>'+callsList[i]+'<br>The Objects NW Corner<br>'+padit.getNorthWest()).openPopup(); 
                
           var $row[callsign]ob3 = new L.marker(new L.latLng( padit.getNorthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ: <br>'+callsList[i]+'<br>The Objects NE Corner<br>'+padit.getNorthEast()).openPopup();	
                
           var $row[callsign]ob4 = new L.marker(new L.latLng( padit.getSouthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ: <br>'+callsList[i]+'<br>The Objects SE Corner<br>'+padit.getSouthEast()).openPopup();   
                
           var $row[callsign]ob5 = new L.marker(new L.latLng( middle ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],   
           icon: L.icon({iconUrl: manInTheMiddle_50 , iconSize: [32, 36] }),     
           title:'ob51'}).addTo(map).bindPopup('OBJ: OB51<br>The Objects Center Marker<br>'+middle1).openPopup();		
          ";
          */
          $cornerOBJ .= 
          "var {$callsign}ob1 = new L.marker(new L.latLng( padit.getSouthWest() ),{contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }), title:'ob1'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects SW Corner<br>'+padit.getSouthWest()).openPopup();
                       
           var {$callsign}ob2 = new L.marker(new L.latLng( padit.getNorthWest() ),{contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }), title:'ob2'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects NW Corner<br>'+padit.getNorthWest()).openPopup();
                    
           var {$callsign}ob3 = new L.marker(new L.latLng( padit.getNorthEast() ),{contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }), title:'ob3'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects NE Corner<br>'+padit.getNorthEast()).openPopup();
                    
           var {$callsign}ob4 = new L.marker(new L.latLng( padit.getSouthEast() ),{contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}], icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),title:'ob4'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects SE Corner<br>'+padit.getSouthEast()).openPopup();
                                    
           var {$callsign}ob5 = new L.marker(new L.latLng( val.getCenter() ),{contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}], icon: L.icon({iconUrl: manInTheMiddle_50 , iconSize: [32, 36] }), title:'ob5'}).addTo(map).bindPopup('OBJ: Middle<br>'+callsList[i]+'<br>The Objects Center Marker<br>'+val.getCenter()).openPopup();";
            
    }; // end foreach
   
        echo "cornerOBJ: $cornerOBJ";
        echo "<br><br>theCorners: $theCorners";
    
   // Create a layer by callsign for every object
   // Also Create a LayerGroup to make adding them to the map easier
   $sql = ("SELECT callsign, recordID, x(latlng) as lat, y(latlng) as lon, comment,
                   CONCAT('[',x(latlng),y(latlng),']') as koords
              FROM TimeLog
             WHERE netID =  $q
               AND comment LIKE '%OBJ%'                            
             ORDER BY callsign  
         ");
   
    // initial values of variables
    $theCalls = "var theCalls = L.layerGroup([";
    $theBounds = "L.latLngBounds([";
    
    $thecall = "";
    foreach($db_found->query($sql) as $result) {  
    		$callsign = $result[callsign];
    		$recordID = $result[recordID];
    		$lat      = $result[lat];
    		$lon      = $result[lon];
    		$comment  = $result[comment];
    		 		
    		$OBJlayer .= "var $callsign$recordID = L.marker([$lat,$lon]).bindPopup('$comment');";
    		    		
       // To get only one of each callsign step through this loop 
       if ($thecall <> $result[callsign]) {	
    		$theCalls .= $result[callsign].',';	
    		// Reset $thecall to this callsign, test at top of if
    		$thecall = $result[callsign];
       }   		    
    }; // end foreach...
    


    echo "<br><br>theCalls: $theCalls]);"; // var theCalls = L.layerGroup([KD0NBH,W0DLK,WA0TJT,]);

    echo "<br><br>OBJlayer: $OBJlayer";
           
?>