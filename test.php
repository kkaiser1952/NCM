<?php
echo "1. Script started\n";

require_once "dbConnectDtls.php";
require_once "GridSquare.php";
require_once "geocode.php";
require_once "config.php";
require_once "Geocoder.php";

echo "2. Required files loaded\n";

// Fill the callsign and w3w based on address from FCC 
$callsign = 'KE6KEN';
$w3w = 'organ.pioneered.instances'; 

try {
    // Initialize W3W API using fully qualified name
    echo "3. Initializing W3W API\n";
    $api = new \What3words\Geocoder\Geocoder("5WHIM4GD");
    
    echo "4. Getting FCC database information\n";
    $fccsql = $db_found->prepare("
           SELECT  last 
                 ,first
                 ,state
                 ,city
                 ,zip
                 ,CONCAT_WS(' ', address1, city, state, zip) AS address
                 ,fccid
             FROM fcc_amateur.en
            WHERE callsign = :callsign 
              AND fccid = (SELECT MAX(fccid) FROM fcc_amateur.en WHERE callsign = :callsign)
            ORDER BY fccid DESC 
            LIMIT 0,1");        
                    
    $fccsql->bindValue(':callsign', $callsign);
    $fccsql->execute();
    $result = $fccsql->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        throw new Exception("No FCC record found for $callsign");
    }
    
    $fccid = $result['fccid'];
    $state = $result['state'];
    $city = $result['city'];
    $zip = $result['zip'];
    echo "5. FCC data retrieved\n";

    // Get coordinates from W3W
    echo "6. Getting W3W coordinates\n";
    $w3wLL = $api->convertToCoordinates($w3w);
    
    $lat = $w3wLL['coordinates']['lat']; 
    $lng = $w3wLL['coordinates']['lng'];   
    $country = $w3wLL['country'];
    echo "7. Coordinates obtained: $lat, $lng\n";
   
    // Get the gridsquare
    echo "8. Calculating grid square\n";
    $grid = gridsquare($lat, $lng);     
    echo "9. Grid square: $grid\n";

    // Get county using our working CURL method
    echo "10. Starting county lookup\n";
    if (function_exists('curl_init')) {
        $ch = curl_init();
        $url = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lng&format=json&addressdetails=1";
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'HAM_Radio_Station_Locator/1.0');
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            echo "11. CURL Error: " . curl_error($ch) . "\n";
            $county = null;
        } else {
            $data = json_decode($response, true);
            if ($data && isset($data['address']['county'])) {
                $county = str_replace(' County', '', $data['address']['county']);
                echo "11. County found: $county\n";
            } else {
                $county = null;
                echo "11. No county found in response\n";
            }
        }
        
        curl_close($ch);
    }

    echo "12. Preparing database update\n";
    $sql = "UPDATE stations 
            SET latitude = :lat,
                longitude = :lng,
                grid = :grid,
                county = :county,
                city = :city,
                state = :state,
                home = :home,
                fccid = :fccid,
                active_call = 'y',
                country = :country,
                dttm = NOW(),
                comment = 'via: updateStationLocationWithW3W',
                zip = :zip
            WHERE callsign = :callsign";

    $stmt = $db_found->prepare($sql);
    
    $home = "$lat,$lng,$grid,$county,$state,$city,$w3w";
    
    $stmt->bindValue(':lat', $lat);
    $stmt->bindValue(':lng', $lng);
    $stmt->bindValue(':grid', $grid);
    $stmt->bindValue(':county', $county);
    $stmt->bindValue(':city', $city);
    $stmt->bindValue(':state', $state);
    $stmt->bindValue(':home', $home);
    $stmt->bindValue(':fccid', $fccid);
    $stmt->bindValue(':country', $country);
    $stmt->bindValue(':zip', $zip);
    $stmt->bindValue(':callsign', $callsign);
    
    echo "13. Database statement prepared\n";
    
    // Uncomment the next line when ready to update the database
    //$stmt->execute();
    //echo "14. Database updated\n";
    
    echo "\nFinal values:\n";
    echo "Latitude: $lat\n";
    echo "Longitude: $lng\n";
    echo "Grid: $grid\n";
    echo "County: " . ($county ?? 'Not found') . "\n";
    echo "State: $state\n";
    echo "City: $city\n";
    echo "Country: $country\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
}

echo "15. Script completed\n";
?>