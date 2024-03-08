<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude 
              FROM poi
             WHERE w3w = 'w3w' OR w3w = '' ";
    
        foreach($db_found->query($sql) as $row) {
            $id = $row["id"];
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];
            
            // Call the What3words API to get the w3w value
            $curl = curl_init();

            $koords = $latitude . "," . $longitude;
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.what3words.com/v3/convert-to-3wa?key=5WHIM4GD&coordinates=$koords&language=en&format=json",
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
            
            $w3w = json_decode($response, true);
            $w3w_value = $w3w["words"];
            
            // Update the w3w column in the poi table
                $update_stmt = $db_found->prepare("
                    UPDATE poi
                       SET w3w = :w3w_value 
                     WHERE id = :id AND w3w = 'w3w' or w3w = '' ");
                $update_stmt->bindParam(':w3w_value', $w3w_value);
                $update_stmt->bindParam(':id', $id);
                $update_stmt->execute();
            
          //  $sql2 = "UPDATE `poi-2023-08-05` SET w3w = :w3w_value WHERE id = :id";
           // $db_found->exec($sql);
    
        }


?>

