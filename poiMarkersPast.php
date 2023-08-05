<?php
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			
			// maxlat is calculated in map.php
			// Eventualy update to bounds for America vs rest of the world
                if ($maxlat > 50) 
                    {$whereClause = "where latitude > 50";}
                else
                    {$whereClause = "where latitude < 50";}
                ;
			
            //$whereClause = "where latitude < 50";
            //$whereClause = "where latitude < 50";
          /*  $whereClause = "where (latitude > $minlat and latitude < $maxlat) 
                            and (longitude > $minlon and longitude < $maxlon)";
			*/
			
			    $whereClause = '';
    $dupCalls = "";	
    $sql = ("SELECT
                tactical, latitude, COUNT(latitude)
               FROM poi
              $whereClause  

              GROUP BY latitude
              HAVING COUNT(latitude) > 1
            ");

        foreach($db_found->query($sql) as $duperow) {
            $dupCalls .= "$duperow[tactical],";
        };
		//echo "$dupCalls";

			
    $POIMarkerList = "";
    $listofMarkers = "";
    $classList = "";  // The rest come from the poi table
    
        // This is the list needed for overlaymaps
        $sql = ("SELECT 
                    GROUP_CONCAT( DISTINCT CONCAT(class,'L') SEPARATOR ',') AS class
                   FROM poi

              $whereClause
                  GROUP BY class
                  ORDER BY class  
                ");
    //echo "$sql";
            foreach($db_found->query($sql) as $row) {
                $classList .= "$row[class],";
            }
            
            //$classList .= "$classList,ObjectL,";
            $classList = "$classList";
            
           // echo "$classList";
    
      // Create the leaflet LayerGroup for each type (class) of marker 
      // Problem here, perhaps with tackList
        $sql = ("SELECT 
                GROUP_CONCAT( REPLACE(tactical,'-','') SEPARATOR ', ') as tackList,
                CONCAT('var ', class, 'List = L.layerGroup([', GROUP_CONCAT( REPLACE(tactical,'-','') SEPARATOR ', '), '])') as MarkerList
                  FROM  poi 
        $whereClause
             	 GROUP BY class
                 ORDER BY class
               ");
            foreach($db_found->query($sql) as $row) {
                $POIMarkerList .= "$row[MarkerList];";
                $listofMarkers .= "$row[tackList],"; 
            }; // End foreach
            
  // ===========================================
  
    $class = "";
    $overlayListNames = "";
  
        $sql = ("SELECT class, GROUP_CONCAT( REPLACE(tactical,'-','') SEPARATOR ', ') as tackList                     
                   FROM  poi
                $whereClause
				  GROUP BY class
                  ORDER BY class
               "); 
            foreach($db_found->query($sql) as $row) {
                $class = "$row[class]";
                $overlayListNames .= '"'.$class.'": '."$row[tackList],\r\n";
            };
            
  // ===========================================
  
        // Class of POI
        $H = 0;  // Hospitals
	    $E = 0;  // EOC
	    $R = 0;  // Repeaters
	    $P = 0;  // Police / Sheriff / CHP
	    $S = 0;  // SkyWarn
	    $F = 0;  // Firestations
	    $A = 0;  // Aviation
	    $G = 0;  // State / Federal / 
	    $T = 0;  // Town Hall
	    $K = 0;  // RF Holes 
	    
	    
	    $markNO     = ''; // the marker number (might be alpha)
	    $grid       = '';
	    $rowno      = 0;
	    $tactical   = "";
	    $gs         = "";
	    $poiBounds  = "[";
	    $poiMarkers = "";
        
        // Pull detail data FROM  poi table
        $sql = ("SELECT id, LOWER(class) as class, 
                       address, latitude, longitude,
                       CONCAT(latitude,',',longitude) as koords,
                       CONCAT(name,'<br>',address,'<br>',city,'<br><b style=\'color:red;\'>',
                       Notes,'</b><br>',latitude,', ',longitude,',  ',altitude,' Ft.') as addr,
                       REPLACE(tactical,'-','') AS tactical, 
                       callsign,
                       CONCAT(class,id) as altTactical
                  FROM  poi 
         $whereClause
         
                 ORDER BY class 
               ");              
     // echo "$sql";                  
    foreach($db_found->query($sql) as $row) {
        $rowno = $rowno + 1;
        $tactical = $row[tactical]; //echo "$tactical";
           // if ($tactical == "" ) {$tactical = $row[class]$row[id];}
           if ($row[tactical] === "" ) {$tactical = $row[altTactical];}   //echo "$row[altTactical]";}
        // Calculates the grdsquare
        $gs = gridsquare($row[latitude], $row[longitude]); 
                
        //$MarkerName = "$row[class]Markers";
        $icon = "";
        $poiBounds .= "[$row[koords]],";  
                              
        // Assign variables based on the class                     
        switch ("$row[class]") {
            case "hospital": $H = $H+1;  $iconName = "firstaidicon"; $markNO = "H$H";  
                             $markername = "images/markers/firstaid.png";  
                             $poimrkr = "hosmrkr";  break;
                             
            case "eoc":      $E = $E+1;  $iconName = "eocicon"; $markNO = "E$E";  
                             $markername = "images/markers/eoc.png";       
                             $poimrkr = "eocmrkr";  break;
                             
            case "repeater": $R = $R+1;  $iconName = "repeatericon"; $markNO = "R$R";  
                             $markername = "markers/repeater.png";  
                             $poimrkr = "rptmrkr";  break;
                             
            case "sheriff":  $P = $P+1;  $iconName = "policeicon"; $markNO = "P$P";  
                             $markername = "images/markers/police.png";    
                             $poimrkr = "polmrkr";  break;
                             
            case "skywarn":  $S = $S+1;  $iconName = "skywarnicon"; $markNO = "S$S";  
                             $markername = "images/markers/skywarn.png";   
                             $poimrkr = "skymrkr";  break;
                             
            case "fire":     $F = $F+1;  $iconName = "fireicon"; $markNO = "F$F";  
                             $markername = "images/markers/fire.png";   
                             $poimrkr = "firemrkr";  break;
                      
            case "police":   $P = $P+1;  $iconName = "policeicon"; $markNO = "P$P";  
                             $markername = "images/markers/police.png";    
                             $poimrkr = "polmrkr";  break; 
                             
            case "chp":      $P = $P+1;  $iconName = "policeicon"; $markNO = "P$P";  
                             $markername = "images/markers/police.png";    
                             $poimrkr = "polmrkr";  break; 
                             
            case "state":    $G = $G+1;  $iconName = "govicon"; $markNO = "G$G";  
                             $markername = "images/markers/gov.png";    
                             $poimrkr = "govmrkr";  break; 
                             
            case "federal":  $G = $G+1;  $iconName = "govicon"; $markNO = "G$G";  
                             $markername = "images/markers/gov.png";    
                             $poimrkr = "govmrkr";  break; 
                        
            case "townhall": $T = $T+1;  $iconName = "govicon"; $markNO = "T$T";  
                             $markername = "images/markers/gov.png";    
                             $poimrkr = "govmrkr";  break;
            
            case "aviation": $A = $A+1;  $iconName = "govicon"; $markNO = "A$A";  
                             $markername = "images/markers/aviation.png";    
                             $poimrkr = "aviationmrkr";  break;     
                             
            case "rf-hole"    $K = $k+1;  $iconName = "govicon"; $markNO = "K$K";
                             $markername = "images/markers/aviation.png";    
                             $poimrkr = "rfholemrkr";  break;
                                                             
            default:         $D = $D+1;  $iconName = "default";  $markNO = "D$D";
                             $markername = "images/markers/blue_50_flag.png";
                             $poimrkr = "flagmrkr"; 
        } 
        
        $dup = 0;
        if(id==144) {$dup =50;}
      //  if(strpos("$dupCalls", "$callsign") !== false) { $dup = 45; }
              
         //if ($tactical == " " ) {$tactical = "$row[class]-$row[id]";}
       
         $poiMarkers .= "
            var $tactical = new L.marker(new L.LatLng($row[latitude],$row[longitude]),{ 
                        rotationAngle: $dup,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: '$markername', iconSize: [32, 34]}),
                        title:'marker_$markNO'}).addTo(fg).bindPopup('$row[tactical]<br>$row[addr]<br>$gs'); /*.openPopup(); */                       
 
                        $('$row[class]'._icon).addClass('$poimrkr');";
                     
    }; // End of foreach for poi markers
    
    
    
    echo "<br><br>poiMarkers= $poiMarkers";
   

        //echo "POI vars<br><br>";    
    // replace last comma with closed square bracket, or a comma or whatever....       
        $poiBounds  = substr($poiBounds, 0, -1)."]";                    //echo ("poiBounds= <br>$poiBounds<br><br>");       
        $$POIMarkerList = substr($POIMarkerList, 0, -1)."]);\n";        //echo ("POIMarkerList= <br>$POIMarkerList<br><br>");
        $poiMarkers = substr($poiMarkers, 0, -1).";\n";                 //echo ("poiMarkers= <br>$poiMarkers<br><br>");
               
        $listofMarkers = substr($listofMarkers, 0, -1)."";              //echo ("listofMarkers= <br>$listofMarkers<br><br>");       
        $overlayListNames = substr($overlayListNames, 0, -1)."";        //echo ("overlayListNames= <br>$overlayListNames<br><br>");  
		    
?>