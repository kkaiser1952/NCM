<?php
// updateCRinPOI.php

// used to update the crossroads field

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "getCrossRoads.php";

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude, Type
              FROM `poi`
             WHERE Type = 'PUBLIC' 
               AND class = 'siren' ";
             
             $id = '';
             $address = '';
             $latitude = '';
             $longitude = '';
               
         foreach($db_found->query($sql) as $row) {
             $id = $row['id'];
             $latitude = $row['latitude'];
             $longitude = $row['longitude'];
             
             $address = getCrossRoads($latitude, $longitude);

             echo "$id, $latitude, $longitude, $address<br>";
             
         // Update the w3w column in the poi table
                $update_stmt = $db_found->prepare("
                UPDATE `poi`
                   SET address = :ADDR_value 
                 WHERE id = :id 
                   AND Type = 'PUBLIC'
                   AND class = 'siren' ");
                $update_stmt->bindParam(':ADDR_value', $address);
                $update_stmt->bindParam(':id', $id);
            $update_stmt->execute();
            
         }
           
?>

