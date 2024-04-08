<?php
    
     include('config2.php');
    // Get the lat/lon from a what3words address
    
  //  https://api.what3words.com/v3/convert-to-coordinates?words=filled.count.soap&key=[API-KEY]
  //  https://api.what3words.com/v3/convert-to-coordinates?key=5WHIM4GD&words=easily.hardest.ended 
  // {"country":"US","square":{"southwest":{"lng":-94.602915,"lat":39.202889},"northeast":{"lng":-94.60288,"lat":39.202916}},"nearestPlace":"Riverside, Missouri","coordinates":{"lng":-94.602897,"lat":39.202903},"words":"easily.hardest.ended","language":"en","map":"https:\/\/w3w.co\/easily.hardest.ended"};
    
    // example address
    //$w3w = "easily.hardest.ended";
    $w3w = "///custodian.back.glittering";
    	
	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.what3words.com/v3/convert-to-coordinates?key=5WHIM4GD&words=$w3w",
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
  
    $w3wLL = json_decode($response, true);
    
    //echo "<br>Response: <br>"; var_dump($w3wLL);
    print_r($w3wLL);
    
    $nearest = $w3wLL['nearestPlace'];
    
    echo '<br><br>nearest: ' . $nearest . '<br>';
    
    // Use explode to split the string by comma and get the first part
    $parts = explode(',', $nearest);
    
    // Trim any leading or trailing whitespace from the first part
    $firstPart = trim($parts[0]);
    
    echo $firstPart; // Output: "Riverside"
    
   // echo "$wewLL";
        
        $koords = $w3wLL['coordinates']; 
        
        
        
        echo "$koords";
        
        echo "<PRE>".json_encode($koords, JSON_PRETTY_PRINT)."</PRE><br>";
        
} // end else
		    
        // End what3word stuff
      
?>

