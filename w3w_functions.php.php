<?php

function getCoordinatesFromW3W($w3w) {
    $w3w_api_key = $config['geocoder']['api_key']; // Make sure $config is available in this file
    $url = "https://api.what3words.com/v3/convert-to-coordinates?words=" . $w3w . "&key=" . $w3w_api_key;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if (isset($data['coordinates'])) {
            $latitude = $data['coordinates']['lat'];
            $longitude = $data['coordinates']['lng'];
            return array($latitude, $longitude);
        } else {
            echo "Invalid response from API";
        }
    } else {
        echo "Request failed with status code: " . $httpCode;
    }
}

?>
