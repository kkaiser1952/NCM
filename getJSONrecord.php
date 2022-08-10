<?php
// This code was written 2020-09-09 as a replacement for getFCCrecord.php which stopped working when the FCC 
// data base became corrupt 

// https://callook.info  ==> The source of this API


require_once "geocode.php";     /* added 2017-09-03 */
//require_once "GridSquare.php";  /* added 2017-09-03 */

//function getJSONcallData($cs1) {
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://callook.info/$cs1/json",
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
      echo "CURL Error #:" . $err;
    
    } else { // no curl error
      
        $crc = json_decode($response, true);
        
           $status    = $crc['status'];                     // VALID
           $cs1  = $crc['current']['callsign'];        // WA0TJT 
           $operClass = $crc['current']['operClass'];       // EXTRA
           $name      = $crc['name'];                       // Keith D Kaiser
           $latitude  = $crc['location']['latitude'];       // 39.202919
           $longitude = $crc['location']['longitude'];      // -94.602898
           $grid      = $crc['location']['gridsquare'];     // EM29qe
           $addr1     = $crc['address']['line1'];           // street
           $addr2     = $crc['address']['line2'];           // city, state, zip
           $expires   = $crc['otherInfo']['expiryDate'];    // 01/12/2029           
    
           $firstLogIn = 1; // default value is yes this is the first log in
                       
    } // end else
    
    // Process any valid callsign
    if ( $status == 'VALID' ){
                
        // Split the name into three parts, this works with O'Neil type names
        $parts = explode(' ', $name); // $meta->post_title
        $Fname = ucfirst(strtolower(array_shift($parts))); 
        $Lname = ucfirst(strtolower(array_pop($parts)));
        $Mname = trim(implode(' ', $parts));

		$koords    = geocode("$addr1 $addr2"); //print_r($koords);  

		$county	   = $koords[2];
		$state	   = $koords[3];
			if ($state == '') {
				$state = $state2;
			} 
		
		$home      = "$latitude,$longitude,$grid,$county,$state";
		
		$comments 	= "First Log In";  // adding state to this works
				
    }elseif ( $status == 'INVALID' ) { // Do this if nothing is returned in otherwords there is no record in the FCC DB
        $comments 	= "No FCC Record";
        $cs1 = $cs0; // carried over from checkIn.php
    }
    
    /*
    return "<br><br>$status <br> $cs1 <br> $operClass <br> $name <br> $latitude <br> $longitude <br> $grid <br>
                $firstLogIn <br> $home <br> $county <br> $state <br>$comments <br>
                $Fname <br> $Mname <br> $Lname
                
               "; 
    */
//};  // End function

//echo getJSONcallData(kc0yso); // kc0yso

?>




