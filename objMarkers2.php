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

  //$q = 3818;
   //$q = 4565;
   $q = 4727;
   
   
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
          
//$comm1 = $comm2 = $comm3 = $comm4 = $comm5 = $comm6 = $comm7 = $comm8 = $comm9 = '';
foreach($db_found->query($sql) as $row) {
    $objType = "$row[objType]";
    $comment = "$row[comment]";            
    $comm1 = $comm2 = $comm3 = $comm4 = $comm5 = $comm6 = $comm7 = $comm8 = $comm9 = '';
       
    switch ($objType) {
        case "W3W":
            // the What 3 Words
            $pos1  = strpos($comment,'W3W:OBJ:')+8;  $pos2 = strpos($comment, '->');
            $comm1 = substr($comment, $pos1, $pos2-$pos1);
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
            // the APRES capture timestamp
            $pos1  = strpos($comment,'@:')+2;     $pos2 = strpos($comment, '(');
            $comm5 = substr($comment, $pos1, $pos2-$pos1);
            // the coordinates
            $pos1  = strpos($comment,'(')+1;    $pos2 = strpos($comment, ')');
            $comm6 = substr($comment, $pos1, $pos2-$pos1);
            // the what 3 words
            $pos1  = strpos($comment,'///')+3;    $pos2 = strpos($comment, 'Cross');
            $comm7 = substr($comment, $pos1, $pos2-$pos1);
            // the cross roads
            $pos1  = strpos($comment,'Roads:')+6; $pos2 = strpos($comment, 'Object:');
            $comm8 = substr($comment, $pos1, $pos2-$pos1);     
            // the object description
            $pos1  = strpos($comment,'Object:')+7; 
            $comm9 = substr($comment, $pos1);
            break;  
    } // end switch
            
    echo "1 W3W $comm1<br>";
    echo "2 W3W $comm2<br>";
    echo "3 W3W $comm3<br>";
    echo "4 W3W $comm4<br>";
    echo "5 APRS $comm5<br>"; 
    echo "6 APRS $comm6<br>";
    echo "7 APRS $comm7<br>";
    echo "8 APRS $comm8<br>";
    echo "9 APRS $comm9<br>";

} // end foreach
?>
  