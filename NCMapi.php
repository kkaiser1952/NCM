 <!doctype html>
<?php
	//https://code.tutsplus.com/tutorials/how-to-build-a-simple-rest-api-in-php--cms-37000
	
	// This code is an API for use in Apple Shortcuts
	// Based on callsign it gets the address, city, state from the fcc table
	// Then in geocodes the above into latitude and longitude
	// Also returning the county and state information
	// Then GridSquare.php calculates the six character gridsquare
	// Curl is then used to convert lat/lon into the what3words address
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "geocode.php";
    require_once "GridSquare.php";
    
    
    // The callsign is requested when the shortcut is executed    
    $cs1 = $_GET['cs1'];
    
    $cs1 = 'wa0tjt';
    
    $cs1 = strtoupper($cs1);
    
    // Is this a U.S. callsign?
    $csArray = array('a','k','n','w');
    
        // If this a U.S. callsign do this
        if (in_array(substr("$cs1",0,1), $csArray)) {
            //echo "in first array<br><br>";
       // Use the callsign to find the address in the fcc table 
           $sql = $db_found->prepare("
                SELECT CONCAT(address1,' ',city,' ',state,' ',zip) as addr,
                       fccid, zip
                  FROM fcc_amateur.en 
                 WHERE callsign = '$cs1' 
                 LIMIT 0,1 ");
                 
           $sql->execute();
           $result      = $sql->fetch();
           $fulladdress = $result[addr];
           $fccid       = $result[fccid];
           $zip         = $result[zip];
        	 	
           // Geocode the address to get the latitude & longitude 
	 	   // And the county & state
	 	   $koords = geocode("$fulladdress");
                $latitude  = $koords[0];  //echo "lat= $latitude";
				$longitude = $koords[1];  //echo "lon= $longitude";
				
			//	[0] => 44.9596871 [1] => -93.2895616 [2] => Hennepin [3] => MN
				$county	   = $koords[2];
				//$district  = $koords[3];
				$state	   = $koords[3];
					if ($state == '') {
						$state = 'Unknown';
					}
					
				// Use gridsquare.php to get the gridsquare	
				$gridd 	   = gridsquare($latitude, $longitude);
				$grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";
				
	 	} // if not in U.S. then get from hamcall
	 	else { 
    	 	//echo "in second else $cs1<br><br>";
    	 	    $url = 'https://hamcall.net/call?username=wa0tjt&password=tjt0aw52&rawlookupCSV=1&callsign='.$cs1.'&program=ncm';
   
    	 	    $lines_string = file_get_contents($url);
   
                $str = explode(",",$lines_string); 
        //echo "<br><br>";
                //print_r (explode(",",$lines_string));
//Array ( [0] => VA3GDZ [1] => Basic with Honours [2] => A [3] => [4] => [5] => Gary Zakaib [6] => [7] => (Address withheld) [8] => CANADA [9] => [10] => ... [11] => ON [12] => [13] => [14] => [15] => [16] => 20200928 [17] => [18] => [19] => [20] => [21] => [22] => [23] => [24] => [25] => [26] => [27] => [28] => [29] => [30] => [31] => [32] => [33] => [34] => [35] => [36] => [37] => [38] => [39] => [40] => [41] => [42] => [43] => [44] => [45] => [46] => 1-5 [47] => [48] => NA ) 
       // echo "<br><br>";
                $name       = $str[5];       //echo "<br>name: $name";     
                
                $pieces     = explode(' ', $name);
                $Lname      = array_pop($pieces);       //echo "<br>Lname: $Lname";  
        
                $string     = explode (' ', $name, 2);  
                $Fname      = $name[1];               //echo "<br>Fname: $Fname<br>";  
              
                $country    = $str[8];       //echo $crty;     
                $latitude   = $str[19];      //echo $lat;
                $longitude  = $str[20];      //echo $lon;
                $grid       = $str[21];      //echo $grid;
                
                $email      = $str[28];      //echo $email;
           
                $home      = "$latitude,$longitude,$grid,,$country";
                
	 	} // end of else
	 	
// To get the what3words address we'll ask W3W via curl, using lat/lon
// copied from getCallHistory.php
$curl = curl_init();

// Use below to test the curl to W3W
//$latitude = 55.634; //$longitude = 37.326;

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.what3words.com/v3/convert-to-3wa?key=5WHIM4GD&coordinates=$latitude,$longitude&language=en&format=json",
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
    $w3w = json_decode($response, true);
        $what3words = $w3w['words'];
        $country = $w3w['country'];
} // end else of $err

    // Now we have everyting we need to update the stations table for this callsign
    // removed latlng 2023-12-22
    $sql2 = "UPDATE stations SET 
               home      = '$latitude,$longitude,$grid,$county,$state',
               latitude  = '$latitude',
               longitude = '$longitude',
               grid      = '$grid',
               county    = '$county',
               state     = '$state',
               fccid     = '$fccid',
               comment   = 'Update Stations w/Callsign Shortcut',
               dttm      = NOW(),
               zip       = '$zip',
               country   = '$country'
              WHERE callsign = '$cs1' ";
    
        $stmt = $db_found->prepare($sql2);
		//$stmt -> execute();

    //echo "$sql2<br><br>";
/*
    echo "$fulladdress, $latitude, $longitude, $county, $grid, $zip <br>";
    echo "$latitude,$longitude,$grid,$county,$state<br>";
    echo "$fccid<br>";
    echo "$dttm $zip<br>";
    echo "$what3words";
    */
?>

<html>
    <head>
    </head>
    <body>
        <?php echo "$sql2<br>
            <h2>Stations update for call: $cs1</h2>
                    <div>Coordinates: $latitude, $longitude </div>
                    <div>grid: $grid, county: $county, state: $state, zip: $zip, country: $country  </div>";
        ?>
    </body>
</html>
   