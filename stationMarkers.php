<?php
    // When callsign is selected from a table an underscore (_) is concatenated to the front. This is because 
    // we are getting check-ins from countries like Kenya whose callsigns start 5Z, Javascript does not 
    // allow variables with a number as the first character.
    // This change was made on 2021-09-14
    
    // This program selects from the DB/NetLog table all the data needed to create the marker points on a map ;
			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
			
			require_once "Geocoder.php";
                use What3words\Geocoder\Geocoder;
              //  use What3words\Geocoder\AutoSuggestOption;
                
                $api = new Geocoder("5WHIM4GD");
                
              require "getCrossRoads.php";
		
		//    require_once "dbConnectDtls.php";
		//    require_once "GridSquare.php";
		
    // This gives a list of two or more stations with the same latitude (Deb & Keth) 
    // If the count is at least 2 then a tilt is put on the marker so its easier to see on the map
	$dupCalls = "";	
    $sql = ("SELECT
                GROUP_CONCAT(CONCAT('_',callsign)) AS callsignX, 
                CONCAT('_',callsign) AS callsign,
                latitude, 
                COUNT(latitude) as dupCount
               FROM NetLog
              WHERE netID = $q  
                AND latitude <> ''
                AND callsign NOT IN('NONHAM','EMCOMM')
              GROUP BY latitude
              HAVING COUNT(latitude) > 1
            ");
        foreach($db_found->query($sql) as $duperow) {
            $dupCalls .= "$duperow[callsign],";
            $callsignX = "$duperow[callsignX]";
        };
		
	//echo("dupCalls= $dupCalls   callsignX= $callsignX");
	
	// This creates an object of just the callsigns	seperated by a column
    $callsList          = "";
    $sql = ("SELECT 
                CONCAT('var callsList = L.layerGroup([', GROUP_CONCAT( REPLACE(CONCAT('_',callsign),'/','') SEPARATOR ', '), '])') as callsList
                
               FROM NetLog
              WHERE netID = $q  
                AND latitude <> ''
                AND callsign NOT IN('NONHAM','EMCOMM')
           ");
        foreach($db_found->query($sql) as $callrow) {
            $callsList = $callrow[callsList];
        };
        
        
		
    // Pulls the complete list of all station by the netID being requested
    // It also sets up the number to appear on each marker and the color of that marker
    $sql = ("SELECT netID ,ID 
                    ,REPLACE(CONCAT('_',callsign),'/','') as callsign     
                    ,callsign as callsign2
                    ,grid 
                    ,netcall 
                    ,activity 
                    ,netcontrol,
    			   		CASE	
    			   			WHEN netcontrol = 'Log' THEN 'NumberedDivIcon'
    			   			WHEN netcontrol = 'PRM' THEN 'NumberedDivIcon'
    			   			WHEN netcontrol = '2nd' THEN 'NumberedDivIcon'
    			   			WHEN netcontrol = 'LSN' THEN 'NumberedDivIcon'
    			   			WHEN netcontrol = 'EM'  THEN 'NumberedDivIcon'
    			   			WHEN netcontrol = '3rd' THEN 'NumberedDivIcon'
    			   			WHEN netcontrol = 'PIO' THEN 'NumberedDivIcon'
    			   			WHEN netcontrol = 'SEC' THEN 'NumberedDivIcon'
    			   			ELSE 'NumberedGreenDivIcon'
    			   		END as iconColor
    			    ,netcontrol,
    			   		CASE	
    			   			WHEN netcontrol = 'Log' THEN 'bluemrkr'
    			   			WHEN netcontrol = 'PRM' THEN 'bluemrkr'
    			   			WHEN netcontrol = '2nd' THEN 'bluemrkr'
    			   			WHEN netcontrol = 'LSN' THEN 'bluemrkr'
    			   			WHEN netcontrol = 'EM'  THEN 'bluemrkr'
    			   			WHEN netcontrol = '3rd' THEN 'bluemrkr'
    			   			WHEN netcontrol = 'PIO' THEN 'bluemrkr'
    			   			WHEN netcontrol = 'SEC' THEN 'bluemrkr'
    			   			ELSE 'greenmrkr'
    			   		END as classColor
    			    ,CONCAT(latitude, ',', longitude) as koords 
    			    ,CONCAT(Fname, ' ', Lname) AS name 
    			    ,CONCAT('<b>Tactical: ',tactical,'<br>',UPPER(callsign),'</b><br> ID: #',ID, '<br>',Fname, ' ', Lname,'<br>',county,' Co., ',state,' Dist: ',district,'<br>',latitude, ', ', longitude, '<br>',grid) as mrkrfill,
    			    latitude, longitude
    		   FROM NetLog  		   			   
    		  WHERE netID = $q
    		    AND latitude IS NOT NULL
    		    AND longitude IS NOT NULL
    		    AND latitude <> ''
    		    AND longitude <> ''
    		    AND callsign NOT IN('NONHAM','EMCOMM')
    		    AND callsign NOT LIKE '%CAMP%'
    		    AND callsign NOT LIKE '%CREW%'
    		    AND callsign <> ' '
    		   
    		  ORDER BY logdate 
    		  
    		 ");
    		  
		$rowno              = 0;
		$fitBounds          = "[";  // opening [ bracket for the array

		$stationMarkers     = "";
		
		$callsignList       = "";
		$stationList        = "";
		$w3w                = "";
        $CrossRoads         = "";
		
			  
    $dup = -45;  //this is the rotation angle   //echo("$dupCalls");
    foreach($db_found->query($sql) as $logrow) {
	    $rowno = $rowno + 1;  
	    
	    $callsign = $logrow[callsign];
	    $callsignList .= "$logrow[callsign],";
	    $original_callsign = $logrow[callsign];
	    	if (strpos($callsign,'/')) {$callsign = substr($callsign,0,strpos($callsign,'/'));}
	    	if (strpos($callsign,'-')) {$callsign = substr($callsign,0,strpos($callsign,'-'));}  	
	    	    
	    if(strpos("$callsignX", "$callsign") !== false) { 
    	    $dup = $dup+45; 
        } else {$dup = 0;}
	    	
			// Missing argument 2 for What3words\Geocoder\Geocoder::convertTo3wa(), called in /var/www/html/stationMarkers.php on line 118 and defined in /var/www/html/Geocoder.php on line 45
			
        // The if validates there are coordinates to work with
		if ($logrow[koords]) {
    		//$cr = getCrossRoads( $logrow[latitude], $logrow[longitude] );
    		// below api returns array so the [words] returns just the 3 words
            $w3w = $api->convertTo3wa($logrow[latitude], $logrow[longitude])[words]; 
    		  //echo($api->convertTo3wa(51.520847, -0.195521));
    		  $div1 = "<div class='cc' style='text-transform:uppercase;'>$rowno<br>$logrow[mrkrfill]<br><a href='https://what3words.com/$w3w?maptype=osm' target='_blank'>///$w3w</a></div>";
    		  $div2 = "<div class='cc'>Show Cross Roads</div>";
    		  //$div3 = "<a class='cc' href='#' onclick=\"jeoquery.getGeoNames('findNearestIntersectionOSM',{lat: $logrow[latitude], lng: $logrow[longitude] }, dbg); return false;\">Cross Roads</a>";
    		  
    		//  $div4 = "<div class='cc' >$cr</div>";
    		  
    		  $div5 = "<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=$logrow[latitude]&lon=$logrow[longitude]&cnt=10' target='_blank'>Nearby APRS stations</a><br><br>stationMarkers.php</div>";
    		  
    		  //echo ("$dup --> $callsign ");
    		  
		  $stationMarkers .= "
			var $callsign = new L.marker(new L.latLng($logrow[koords]),{ 
			    rotationAngle: $dup,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.{$logrow[iconColor]}({number: '$rowno' }),
				title:`marker_$rowno` }).addTo(fg).bindPopup(`
				$div1<br><br>
				$div5<br><br>
                `).openPopup();
				
				$(`$callsign`._icon).addClass(`$logrow[classColor]`);
                stationMarkers.push($callsign);
				";
						
        } // End $row[koords] test... is there a value     
        
        //$dup = $dup + 45;  //this is the rotation angle	   
        
		$fitBounds .= "[$logrow[koords]],";  //each set must be in [] brackets
		//echo "$fitBounds";
		
		// for the station list on the 
		$stationList .= "<a class='rowno' id='marker_$rowno' href='#'>$rowno $original_callsign</a><br>";
		
		$netcall = $logrow[netcall];
		
    }; // End of foreach for check-in calls 
    
        $fitBounds  = substr($fitBounds, 0, -1)."]";                //echo ("$fitBounds");
        $stationMarkers = substr($stationMarkers, 0, -1).";\n";     //echo ("$stationMarkers<br><br>");
        $callsignList = substr($callsignList, 0, -1)."";            //echo ("$callsignList");  // list of the callsigns who checked-in
        //$callsList = substr($callsignList, 0, -1)."";	
        $callsList = substr($callsList, 0, -1).");\n";	    
        
// This is called here because it needs the fitBounds information created above    
   
//require_once "poiMarkers.php"; 
?>