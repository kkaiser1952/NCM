<?php
// poiMarkers.php
// Wirtten 2017
// Updated 2024-09-??
    
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			
			require_once "dbConnectDtls.php";
			
			if (!$db_found) {
                die("Database connection failed: " . mysqli_connect_error());
            }
			
			// maxlat is calculated in map.php
			// Eventualy update to bounds for America vs rest of the world
			/*
                if ($maxlat >= 50) 
                    {$whereClause = "where latitude > 50";}
                else
                    {$whereClause = "where latitude < 50";}
                ;
			
			    $whereClause = '';
			 */
			    
    $dupCalls = "";	
    
    $sql = ("SELECT tactical, latitude, COUNT(latitude)
               FROM poi
                
              GROUP BY latitude
              HAVING COUNT(latitude) > 1
            ");
    //echo "$sql";
    
    foreach($db_found->query($sql) as $duperow) {
            $dupCalls .= "$duperow[tactical],";
    };
		//echo "<br>dupCalls= $dupCalls<br>";
		
		$POIMarkerList = "";
        $listofMarkers = "";
        $classNames     = "";  // The rest come from the poi table
    
        /// This is the list needed for overlaymaps
        $sql = ("SELECT 
                    GROUP_CONCAT( DISTINCT CONCAT(class,'L') SEPARATOR ',') AS class
                   FROM poi
                    
                  GROUP BY class
                  ORDER BY class  
                ");
    //echo "$sql";
            foreach($db_found->query($sql) as $row) {
                $classNames .= "$row[class],";
            }
            
        //$classNames .= "$classNames,ObjectL,";
        $classNames = rtrim($classNames, ',');
        //echo "classNames:<br> $classNames";
        // classNames:
        //aviationL,eocL,fireL,hospitalL,kcheartL,policeL,repeaterL,rfholeL,sheriffL,skywarnL,stateL,sirenL

            
        // Create the leaflet LayerGroup for each type (class) of marker 
        // Problem here, perhaps with tackList
        // Fix this when we upgrade MySQL to v8
        // SQL to extend the length of output allowed by GROUP_CONCAT
        $max_len_value = 1000000; // Set the desired maximum length
            $db_found->exec("SET SESSION group_concat_max_len = $max_len_value");
   
        $sql = ("SELECT 
                GROUP_CONCAT( REPLACE(tactical,'-','') SEPARATOR ', ') as tackList,
                CONCAT('var ', class, 'List = L.layerGroup([', GROUP_CONCAT( REPLACE(tactical,'-','') SEPARATOR ', '), '])') as MarkerList
                  FROM  poi 
                   
             	 GROUP BY class
                 ORDER BY class
               ");
            foreach($db_found->query($sql) as $row) {
                $POIMarkerList .= "$row[MarkerList];";
                $listofMarkers .= "$row[tackList],"; 
            }; // End foreach
            
           // echo "<br>$POIMarkerList<br>";
            
  // ===========================================
  
        $class = "";
        $overlayListNames = "";
        
        $max_len_value = 10000000; // Set the desired maximum length
            $db_found->exec("SET SESSION group_concat_max_len = $max_len_value");
  
        $sql = ("SELECT class, 
                        GROUP_CONCAT( REPLACE(tactical,'-','') SEPARATOR ', ') as tackList                     
                   FROM  poi
                    
                /*$whereClause*/
				  GROUP BY class
                  ORDER BY class
               "); 
            foreach($db_found->query($sql) as $row) {
                $class .= "$row[class] ";
                $overlayListNames .= '"'.$class.'": '."$row[tackList],\r\n";
            };
            
            // Remove the .= in the $class definition above if an issue arrives from here
            // echo "<br>$class<br><br>$overlayListNames";
            
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
	    $Y = 0;  // Tornado (siren)
	    
	    
	    $markNO     = ''; // the marker number (might be alpha)
	    $grid       = '';
	    $rowno      = 0;
	    $tactical   = "";
	    $gs         = "";
	    $poiBounds  = "[";
	    $poiMarkers = "";
	    
/* Kansas City International Airport 1 International Square, Kansas City, MO 64153 North Kansas City  39.3003, -94.72721 0 Ft. */
        
        // Pull detail data FROM  poi table
        $sql = "SELECT id,  name,  Notes, w3w,
                        LOWER(class) as class, 
                        address, latitude, longitude, grid,
                        CONCAT(latitude,',',longitude) as koords,
                        
                        CONCAT(name, ' ', 
                                address, ' ', 
                                Notes, ' ',
                                latitude, ', ', 
                                longitude, ' ', 
                                altitude, ' Ft.'
                                 
                                ) as addr,
                        
                        REPLACE(REPLACE(REPLACE(tactical,'-',''), '#', ''), '!', '') AS tactical,

                        callsign,
                        CONCAT(class,id) as altTactical,
                        dttm
                  FROM poi 
                   
                  ORDER BY class 
               ";            
              
      // Prepare the statement
$stmt = $db_found->prepare($sql);
$stmt->execute(); // Execute the prepared statement

$rowno = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $rowno = $rowno + 1;
    $tactical = $row['tactical'];
    
    if ($row['tactical'] === "") {
        $tactical = $row['altTactical'];
    }   
            //echo "$row[altTactical]";}
            
        // Calculates the grdsquare
        // gs is now in the table as grid if you need it
        // $gs = gridsquare($row[latitude], $row[longitude]); 
                
        //$MarkerName = "$row[class]Markers";
        $icon = "";
        $poiBounds .= "[$row[koords]],";  
        
        // for this echo you might need to position a } bracket to close the foreach
        //echo "<br><br>$poiBounds<br>";
        
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
                             
            case "sheriff":  $X = $X+1;  $iconName = "policeicon"; $markNO = "X$X";  
                             $markername = "images/markers/police.png";    
                             $poimrkr = "polmrkr";  break;
                             
            case "skywarn":  $S = $S+1;  $iconName = "skywarnicon"; $markNO = "S$S";  
                             $markername = "images/markers/skywarn2.png";   
                             $poimrkr = "skymrkr";  break;
                             
            case "fire":     $F = $F+1;  $iconName = "fireicon"; $markNO = "F$F";  
                             $markername = "images/markers/fire.png";   
                             $poimrkr = "firemrkr";  break;
                      
            case "police":   $P = $P+1;  $iconName = "policeicon"; $markNO = "P$P";  
                             $markername = "images/markers/police.png";    
                             $poimrkr = "polmrkr";  break; 
                             
            case "chp":      $C = $C+1;  $iconName = "policeicon"; $markNO = "P$P";  
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
                             
            case "rfhole":   $K = $K+1;  $iconName = "holeicon"; $markNO = "K$K";
                             $markername = "images/markers/hole.svg";    
                             $poimrkr = "aviationmrkr";  break;
                             
            case "siren":   $Y = $Y+1;  $iconName = "tornadoicon"; $markNO = "K$K";
                             $markername = "images/markers/siren.png";    
                             $poimrkr = "sirenmrkr";  break;
                                                             
            default:         $D = $D+1;  $iconName = "default";  $markNO = "D$D";
                             $markername = "images/markers/blue_50_flag.png";
                             $poimrkr = "flagmrkr";
    
        } // End of switch
    
    //echo "$iconName,  $markNO,  $markername,  $poimrkr<br>";
       
    $dup = 0;
        if(id==144) {$dup =50;}
        // if(strpos("$dupCalls", "$callsign") !== false) { $dup = 45; }
              
        // if ($tactical == " " ) {$tactical = "$row[class]-$row[id]";}
        
      //  Kansas City International Airport 1 International Square, Kansas City, MO 64153 North Kansas City  39.3003, -94.72721,  0 Ft.
      
       
         $poiMarkers .= "
    var $tactical = new L.marker(new L.LatLng({$row['latitude']},{$row['longitude']}), { 
        // ... other properties
        icon: L.icon({iconUrl: '$markername', iconSize: [32, 34]}),
        title: " . json_encode("{$row['tactical']} {$row['name']}  {$row['Notes']} {$row['koords']}") . ",
    }).addTo(fg).bindPopup(" . json_encode("{$row['tactical']}<br><br>Name: {$row['name']}<br><br>W3W:<br><b style='color:red'> {$row['w3w']}</b><br>
        <br>Crossroads:<br> <b style='color:red'>{$row['address']}</b> <br><br> Grid: {$row[grid]}<br>{$row['Notes']}<br> {$row['koords']}<br><br>Created: {$row['dttm']}<br><br>poiMarkers.php
    ") . ");
    
    $('{$row['class_lower']}'._icon).addClass('$poimrkr');
    ";


 // End of $poiMarkers build
                     
     }; // End of foreach for poi markers
        
    //echo "<br>$poiMarkers<br>";
   
    $poiBounds  = substr($poiBounds, 0, -1)."]"; 
        //echo ("poiBounds= <br>$poiBounds<br><br>");
        
        //echo ("POIMarkerList= <br>$POIMarkerList<br><br>");
    $$POIMarkerList = substr($POIMarkerList, 0, -1)."]);\n";        
        //echo ("POIMarkerList= <br>$POIMarkerList<br><br>");
        
    $poiMarkers = substr($poiMarkers, 0, -1).";\n";                 
        //echo ("poiMarkers= <br>$poiMarkers<br><br>");
        
    $listofMarkers = substr($listofMarkers, 0, -1)."";              
        //echo ("listofMarkers= <br>$listofMarkers<br><br>"); // issue with RFH
        
    $overlayListNames = substr($overlayListNames, 0, -1)."";        
        //echo ("overlayListNames= <br>$overlayListNames<br><br>"); // two commas by RFH
  
?>

