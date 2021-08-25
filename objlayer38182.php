<?php
    
    // This is an experimental method of creating markers for each of the objces reported in NCM
    
    /* Reference:  https://leafletjs.com/examples/layers-control/. */

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
    
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			  
   //$q = 3818;
   
    // Create corner markers for each callsign that has objects.
    $sql = ("SELECT  MIN(x(latlng)) as minLat,
	                 MAX(x(latlng)) as maxLat,
	                 MIN(y(latlng)) as minLng,
	                 MAX(y(latlng)) as maxLng,
	                 callsign
	            FROM TimeLog
	           WHERE netID = 3818
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
    	   if ($thecall <> $callsign) {	$theCorners .=	
    		   "var ".$callsign."Corner = [[$maxLat, $maxLng], [$maxLat, $minLng ], [$minLat, $minLng ], [$minLat, $maxLng ], [$maxLat, $maxLng]];";
    		
    		$cornerOBJ .=
    		"var ".$callsign."ob1 = new L.marker(new L.latLng( padit.getSouthWest() ),{contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects SW Corner<br>'+padit.getSouthWest()).openPopup();";
    		   
    		// Reset $thecall to this callsign, test at top of if
    		    $thecall = $row[callsign];
           } 
	   }; 
   
   
        echo "$cornerOBJ";
       //echo "$theCorners";
 /*
var KD0NBHCorner = [[39.45646, -94.85481], [39.45646, -94.35714 ], [38.954385, -94.35714 ], [38.954385, -94.85481 ], [39.45646, -94.85481]];
var W0DLKCorner = [[39.452903, -94.851471], [39.452903, -94.352897 ], [38.947539, -94.352897 ], [38.947539, -94.851471 ], [39.452903, -94.851471]];
var WA0TJTCorner = [[39.452579, -94.852515], [39.452579, -94.355019 ], [38.949318, -94.355019 ], [38.949318, -94.852515 ], [39.452579, -94.852515]];

        var ob1 = new L.marker(new L.latLng( padit.getSouthWest() ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br>'+callsList[i]+'<br>The Objects SW Corner<br>'+padit.getSouthWest()).openPopup();
            
        var KD0NBHob1 = new L.marker(new L.latLng( padit.getSouthWest() ),{contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}], icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }), title:'ob1'}).addTo(map).bindPopup('OBJ:
'+callsList[i]+'
The Objects SW Corner
'+padit.getSouthWest()).openPopup()
*/
   
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
    

    /* echo "$a ${$a}"; These are the corners of each callsigns LayerGroup
KD0NBHCorners = [[39.45646, -94.85481], [39.45646, -94.35714 ], [38.954385, -94.35714 ], [38.954385, -94.85481 ], [39.45646, -94.85481]];
W0DLKCorners = [[39.452903, -94.851471], [39.452903, -94.352897 ], [38.947539, -94.352897 ], [38.947539, -94.851471 ], [39.452903, -94.851471]];
WA0TJTCorners = [[39.452579, -94.852515], [39.452579, -94.355019 ], [38.949318, -94.355019 ], [38.949318, -94.852515 ], [39.452579, -94.852515]];
    */
 
    //echo "$theCalls]);"; // var theCalls = L.layerGroup([KD0NBH,W0DLK,WA0TJT,]);

   // echo "<br>$OBJlayer<br>";
/* 
var KD0NBH67898 = L.marker([39.20646,-94.605575]).bindPopup('LOCΔ:W3W:OBJ: undergoing.arrival.hobble -> Cross Roads: NW 62nd St & N Harden Ct (39.20646,-94.605575) Black Chevy');
var KD0NBH67898 = L.marker([39.206272,-94.60481]).bindPopup('LOCΔ:W3W:OBJ: converter.admitting.shovels -> Cross Roads: N Harden Ct & NW 62nd St (39.206272,-94.60481) White Ford');
var KD0NBH67898 = L.marker([39.205679,-94.605854]).bindPopup('LOCΔ:W3W:OBJ: mincing.starring.engineering -> Cross Roads: NW 62nd St & N Harden Ct (39.205679,-94.605854) Green Toyota');
var KD0NBH67898 = L.marker([39.205544,-94.60714]).bindPopup('LOCΔ:W3W:OBJ: fussed.westerner.ratty -> Cross Roads: NW 62nd St & N Evans Ave (39.205544,-94.60714) Red Honda');
var KD0NBH67898 = L.marker([39.205032,-94.606201]).bindPopup('LOCΔ:W3W:OBJ: falsely.help.delight -> Cross Roads: N Evans Ave & NW 62nd St (39.205032,-94.606201) Black Chevy Truck');
var KD0NBH67898 = L.marker([39.204385,-94.606862]).bindPopup('LOCΔ:W3W:OBJ: craving.since.duchess -> Cross Roads: NW 62nd St & N Evans Ave (39.204385,-94.606862) White Chevy Truck');
var W0DLK60749 = L.marker([39.198159,-94.601576]).bindPopup('LOCΔ:W3W:OBJ: spray.shudder.opting -> Cross Roads: N Ames Ave & NW 57 Ct (39.198159,-94.601576) yellow door');
 */            
?>