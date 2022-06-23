<?php
    
    // This is an experimental method of creating markers for each of the objces reported in NCM
    
 /**
 * w3w-php-wrapper - A PHP library to use the what3words RESTful API
 *
 * @author Gary Gale <gary@what3words.com>
 * @copyright 2016, 2017 what3words Ltd
 * @link http://developer.what3words.com
 * @license MIT
 * @version 3.3.0
 * @package What3words\Geocoder
 */

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
    	
			  
   //$q = 3818;
   //$q = 4565;
   
   
   //echo 'PHP version: ' . phpversion();
   
   // Create a layer by callsign for every object
   // Also Create a LayerGroup to make adding them to the map easier
   $sql = ("SELECT callsign, 
                   uniqueID, 
                   x(latlng) as lat, 
                   y(latlng) as lon, 
                   comment,
                   CONCAT('[',x(latlng) , y(latlng),']') as koords
              FROM TimeLog
             WHERE netID =  $q
               AND comment LIKE '%OBJ%'                      
             ORDER BY callsign, timestamp
         ");
   
    // initial values of variables
    $theCalls = "var theCalls = L.layerGroup([";
    $theBounds = "";
    
    $thecall = "";
    
    $x=0;
    $len = count($db_found->query($sql)); //echo "<br>len= $len <br>";
    foreach($db_found->query($sql) as $result) {  
        
    		$callsign = $result[callsign];
    		$recordID = $result[uniqueID];
    		$lat      = $result[lat];
    		$lon      = $result[lon];
    		$comment  = $result[comment];
    		 		
    		$OBJlayer .= "var $callsign$recordID = L.marker([$lat,$lon]).bindPopup('$comment');";
    		    		
       // To get only one of each callsign step through this loop 
       if ($thecall <> $result[callsign]) {	
            $x++;   
    		$theCalls  .= $result[callsign]."OBJ,";	  	
    		$theBounds .= "]); var ".$result[callsign]."OBJ = L.latLngBounds([[$lat , $lon]";		
    		// Reset $thecall to this callsign, test at top of if
    		$thecall = $result[callsign];
       }else if ($thecall == $result[callsign]) {
    		$theBounds .= "[$lat,$lon],"; 		
    		// Reset $thecall to this callsign, test at top of if
    		$thecall = $result[callsign];
       }
      // $theBounds = "$theBounds);";
            
    }; // end foreach...
    
    $theBounds = "$theBounds]);";
    $theCalls  = "$theCalls]);";
    
    // This adds the var to the first record while removing the extra ]); stuff
    $theBounds  = substr("var ".$theBounds, 7 )."";  
    

    //echo "<br><br>@70 theBounds=<br> $theBounds";

    //echo "<br><br>@72 theCalls: $theCalls"; // var theCalls = L.layerGroup([KD0NBH,W0DLK,WA0TJT,]);

    //echo "<br><br>@74 OBJlayer: $OBJlayer";
    
    $objMiddle  = '';
    $objPadit   = '';
    $objSW      = '';
    $objNW      = '';
    $objNE      = '';
    $objSE      = '';

   
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
     foreach($db_found->query($sql) as $row) {
         $objBounds .= "$row[objBounds]";    
         $objMiddle .= "$row[callsign]OBJ.getCenter();";
 
         $objPadit  .= "var $row[callsign]PAD    = $row[callsign]OBJ.pad(.075);";
         $objSW     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthWest();";
         $objNW     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthWest();";
         $objNE     .= "var $row[callsign]padit  = $row[callsign]PAD.getNorthEast();";
         $objSE     .= "var $row[callsign]padit  = $row[callsign]PAD.getSouthEast();";
     } // end of foreach loop
     
       //echo "$objMiddle"; // KD0NBHOBJ.getCenter();W0DLKOBJ.getCenter();WA0TJTOBJ.getCenter();
       
       // LOC&#916:W3W:OBJ: undergoing.arrival.hobble -> Cross Roads: NW 62nd St &amp; N Harden Ct (39.20646,-94.605575) Black Chevy
       // LOC&#916;:APRS:OBJ: Findu update of location including gridsquare & crossroads at: Poplar St &amp; N 155th St    
       
        $sql = (" SELECT callsign, 
                    timestamp,
                    
                    /* comm1 will get the What 3 words from W3W:objects
                    SUBSTRING(comment, POSITION('OBJ:' IN comment)+5, POSITION(' -> C' IN comment)) as comm1,
                    
                    /* comm2 will be the crossroads from W3W:objects
                    SUBSTRING(comment, POSITION('Cross' IN comment)+13, POSITION(' (' IN comment)) as comm2,
                    
                    
           /*         SUBSTRING(comment, POSITION('OBJ:' IN comment)+6, POSITION(' -> C' IN comment)) as comm3,
                    SUBSTRING(comment, POSITION('at:' IN comment)+1, POSITION(' (' IN comment)) as comm4,
                    SUBSTRING(comment, POSITION(')' IN comment)+1) as comment,
	       */         latlng, 
	                comment,
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

              ORDER BY callsign, timestamp ) s          
          ");
          
          $objMarkers       = "";
          $OBJMarkerList    = "";
        
    
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
        
        //$w3lat = $row[lat]; 
        //$w3lng = $row[lng];
        
        $w3words = $api->convertTo3wa($row[lat],$row[lng])[words];
        $w3nplac = $api->convertTo3wa($row[lat],$row[lng])[nearestPlace];
            print_r($api->getError());
           // print_r($w3words);
            //echo("lat= $row[lat] lng= $row[lng]  w3= $w3words[words]");
        
        $gs = gridsquare($row[lat], $row[lng]); 
       // echo "gridsquare= $gs <br>";
                
        //$MarkerName = "$row[class]Markers";
        $icon = "";

        //$objBounds        .= "[$koords],";  //echo "<br>objBounds: $objBounds<br>";
        
        $OBJMarkerList       .= "$objmrkr,";  

        $listofMarkers    .= "$objmrkr,";
        $overlayListNames .= "$objmrkr,";       
        $comment = "$row[comment]";
        
        // get the what 3 words value
        $arr = explode("-", $row[comm1], 2);
        $w3w = trim($arr[0]," "); //echo "$w3w";

        // get the cross roads names 
        $arr = explode("(", $row[comm2], 2);
        $cr  = trim($arr[0]," "); //echo "$cr";
        
        
        // foreach callsign create a new set of objemarkers and their center and corner markers  
            $div1 = "<div class='xx' style='text-transform:uppercase;'>OBJ:<br>$objmrkr<br></div>
                     <div class='gg'><a href='https://what3words.com/$w3w?maptype=osm' target='_blank'>///$w3words<br><br>Nearest Place:<br>$w3nplac</a></div>";  
            $div2 = "<div class='cc'>Comment:<br>".substr($comment,19)."<br><br>Captured:<br>$row[timestamp]</div>"; 
            $div3 = "<div class='bb'>Cross Roads:<br>$cr</div><br>
                     <div class='gg'>$row[lat],$row[lng]<br>Grid: $gs</div>";            
    	    
            $objMarkers .= " var $objmrkr = new L.marker(new L.LatLng($row[lat],$row[lng]),{
                                rotationAngle: $dup, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: '$markername', iconSize: [32, 34]}),
                                title:`marker_$markNO`}).addTo(fg).bindPopup(`$div1<br>$div3<br>$div2`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                           "; // End of objMarkers
               // echo ($objMarkers);
          
    };  // End of the foreach row        
    
   
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

    $cornerMarkers = "";
    $OBJCornerList = "";
    
    // colored flag markers for the corners
    $colormarkername = array("greenmarkername", "lightbluemarkername","goldmarkername", "orangemarkername", "violetmarkername", "lightbluemarkername","graymarkername", "blackmarkername","redmarkername","greenmarkername", "lightbluemarkername", "goldmarkername", "orangemarkername", "violetmarkername","lightbluemarkername", "graymarkername", "blackmarkername","redmarkername");
    
    $cmn = 0;
    foreach($db_found->query($sql) as $row) {
           $callsign = $row[callsign];
                                
    	   $minLat = $row[minLat]-0.25;     //echo "@216 minLat= $minLat";
    	   $maxLat = $row[maxLat]+0.25;     //echo "@217 maxLat= $maxLat";
    	   $minLng = $row[minLng]+0.25;     //echo "@218 minLng= $minLng";
    	   $maxLng = $row[maxLng]-0.25;     //echo "@219 maxLng= $maxLng";


          // It takes 5 sets to complete the square a to b, b to c, c to d, d to e, e back to a
          //           NorthWest              NorthEast           SouthEast            SouthWest              same as first
          //       [[$maxLat, $maxLng],    [$maxLat, $minLng ], [$minLat, $minLng ], [$minLat, $maxLng ],  [$maxLat, $maxLng]]";   
          
          // in ob5 I use $row[callsign]OBJ instead of PAD because there is no padding on the center, its the center
          
        if ($thecall <> $row[callsign]) {	
            //$thecall = $row[callsign];
            
            $cmn++;
            	
    		$cornerMarkers .=
           "var $row[callsign]ob1 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthWest() ),{   
    	/*	contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}], */
            icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [48,48] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SW<br>'+$minLat+','+$maxLng+'<br>The Objects SW Corner');
                        
           var $row[callsign]ob2 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthWest() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [48,48] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NW<br>'+$maxLat+','+$maxLng+'<br>The Objects NW Corner');
                           
           var $row[callsign]ob3 = new L.marker(new L.latLng( $row[callsign]PAD.getNorthEast() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [48,48] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]NE<br>'+$maxLat+','+$minLng+'<br>The Objects NE Corner');
                           
           var $row[callsign]ob4 = new L.marker(new L.latLng( $row[callsign]PAD.getSouthEast() ),{
       /*    contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: $colormarkername[$cmn] , iconSize: [48,48] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]SE<br>'+$minLat+','+$minLng+'<br>The Objects SE Corner');
                           
           var $row[callsign]ob5 = new L.marker(new L.latLng( $row[callsign]PAD.getCenter() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],   
           icon: L.icon({iconUrl: manInTheMiddle_50 , iconSize: [48,48] }),     
           title:'ob5'}).addTo(map).bindPopup('OBJ:<br> $row[callsign]CT<br>'+$minLat+','+$minLng+'<br>The Objects Center Marker');";        
          
          $OBJCornerList .= "$row[callsign]ob1, $row[callsign]ob2, $row[callsign]ob3, $row[callsign]ob4, $row[callsign]ob5,";
          
          $thecall = $row[callsign];
          
        } // end of if loop
    }; // end foreach loop

    
    $OBJCornerList = "var OBJCornerList = L.layerGroup([$OBJCornerList]);";
    
    $OBJMarkerList = "var OBJMarkerList = L.layerGroup([$OBJMarkerList]);";
  
    //echo "$cornerMarkers";
    //echo "<br><br>";
    //echo "$OBJCornerList";
    //echo "<br><br>";
    //echo "$OBJMarkerList";
?>