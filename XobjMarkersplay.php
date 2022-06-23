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
    
    echo 'PHP version: ' . phpversion();

  //$q = 3818;
   //$q = 4565;
   $q = 4743;
  
   
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
          
  $db_found->prepare("$sql");
    $data = [];
    $result = '';
    
  while($row = $query->fetch(PDO::fetch_assoc()) {
       $result .= '<option value="'.$row['callsign'].'" ';
       if(in_array($row['callsign'], $exp))
       {
           $result .= ' selected';
       }
       $result .= '>';
       $result .= $row['id'];
       $result .= '</option>';
  }
   
   echo $result;
          
/*
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
*/

?>
  