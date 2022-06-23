<?php
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "GridSquare.php";
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
  
  
   // Get TimeLog information about possible objects 
   $sql = (" SELECT callsign, counter from (
                select callsign, x(latlng) ,y(latlng), 
                	@counter := if (callsign = @prev_callsign, @counter + 1, 1) counter,
                    @prev_callsign := callsign
                           FROM `TimeLog`, (select @counter := 0, @prev_callsign := null) init 
                          WHERE netID = 3814
                            AND callsign <> 'GENCOMM'
                          ORDER BY callsign
            )s
          ");
          
          echo "$sql";
          
       foreach($db_found->query($sql) as $row) {
        
        $dup = 0;
        if(id==144) {$dup =50;}
        
        $markNO     = ''; // the marker number (might be alpha)
        $markername = "$row[callsign]-$row[counter]";
        $objBounds  = "";
	    $objMarkers = "";
        
        $objMarkers .= "
            var object = new L.marker(new L.LatLng($row[x(latlng)],$row[y(latlng]),{ 
                        rotationAngle: $dup,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `$markername`, iconSize: [32, 34]}),
                        title:`marker_1`}).addTo(fg).bindPopup(`tactical<br>addr`).openPopup();                        
 
                        $(`$row[class]`._icon).addClass(`$objmrkr`);";
        
        };  

	echo "$objMarkers";
    
    // replace last comma with closed square bracket, or a comma or whatever....       
        $objBounds  = substr($objBounds, 0, -1)."]";            //echo "$poiBounds";       
        $$OBJMarkerList = substr($OBJMarkerList, 0, -1)."]);\n"; //echo ("$POIMarkerList<br><br>");
        $objMarkers = substr($pbkMarkers, 0, -1).";\n";             //echo ("$poiMarkers<br><br>");
               
        $listofMarkers = substr($listofMarkers, 0, -1)."";  //echo ("$listofMarkers<br><br>");       
        $overlayListNames = substr($overlayListNames, 0, -1).""; //echo ("$overlayListNames<br><br>");  
		    
?>