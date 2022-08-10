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
    
    //$sql0 = $db_found->prepare("SET GLOBAL group_concat_max_len=2048");
	//$sql0->execute();

   $q = 4743;
   
   
   $sql = (" SELECT callsign, 
                    CONCAT(callsign,'OBJ') as callOBJ,
                    COUNT(callsign) as numofcs, 
                    CONCAT ('var ',callsign,'OBJ = L.latLngBounds( [', GROUP_CONCAT('[',x(latlng),',',y(latlng),']'),']);') as objBounds,
                    CONCAT (' [', GROUP_CONCAT('[',x(latlng),',',y(latlng),']'),'],' ) as arrBounds,
                    CONCAT (callsign,'arr') as allnameBounds
               FROM TimeLog 
              WHERE netID = $q 
                AND callsign <> 'GENCOMM'
                AND comment LIKE '%OBJ%' 
              GROUP BY callsign
              ORDER BY callsign, timestamp
          ");
    

        $allBounds = "";
     foreach($db_found->query($sql) as $row) {

         $allBounds .= "$row[arrBounds]";
         
         
    }
    
    
    $allBounds = "[".rtrim($allBounds,",")."]";
    //$allBounds = substr($allBounds, 0, -1)."]";
    
    
    
    echo "$allBounds";
      
        // This creates a lat/lon list for each callsign with objects. This is used in
        // the map.php program in the polyline function
        // CONCAT('var ', callsign, 'latlngs = [',
        //                 GROUP_CONCAT(CONCAT( '[',x(latlng),',',y(latlng),']')),']') as allKoords,
        
 /*   $query = $db_found->prepare("SELECT CONCAT( '[', x(latlng),',',y(latlng), ']') as koords
                                   FROM TimeLog 
                                  WHERE netID = 4743
                                    AND comment LIKE '%OBJ:%'
                                  ORDER BY timestamp ASC
                               ");
                               
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSSOC);
        
		echo "<pre> print_r($results); </pre>";
       
     //  echo "$koords";
   /*     $sqlk = ("SELECT CONCAT('[',
                         GROUP_CONCAT( '[',x(latlng),',',y(latlng),']')) AS KOORDS
                    FROM TimeLog
                   WHERE netID = $q
                     AND comment LIKE '%OBJ:%'

                ");
                
            foreach($db_found->query($sqlk) as $row) {
                $KOORDS .= $row[KOORDS].';';
               
            }   
     */                  
       
          //   echo "$KOORDS";
             
             
            
            
        /* var objectLine = L.polyline(
    [        
    [[39.201636,-94.602375],[39.201259,-94.603175],[39.20169,-94.603628],[39.201986,-94.603036],[39.202337,-94.602932]],[[39.201393,-94.601576],[39.20067,-94.6015],[39.20167,-94.60217],[39.20117,-94.60167],[39.2025,-94.6025],[39.203,-94.60233],[39.203,-94.60233],[39.201016,-94.601541],[39.203,-94.60233]]
    ],{color: newcolor , weight: 1}).addTo(map);
    
      */  
?>
  