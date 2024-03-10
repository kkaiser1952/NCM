<?php
// updateCRinPOI.php

// used to update the crossroads field

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "getCrossRoads.php";

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude
              FROM `poi`
             WHERE address = ''
               AND class = 'siren' ";
               
     //echo ("$sql<br><br>");          
             
             $id = '';
             $address = '';
             $latitude = '';
             $longitude = '';
               
         foreach($db_found->query($sql) as $row) {
             $id = $row['id'];
             $latitude = $row['latitude'];
             $longitude = $row['longitude'];
             
             $address = getCrossRoads($latitude, $longitude);

             echo "id: $id, lat: $latitude, lon: $longitude, addr: $address<br>";
             
         // Update the address with crossroads values in the poi table
                $update_stmt = $db_found->prepare("
                UPDATE `poi`
                   SET address = :ADDR_value 
                 WHERE id = :id 
               AND    address = ''
               AND class = 'siren' ");
                $update_stmt->bindParam(':ADDR_value', $address);
                $update_stmt->bindParam(':id', $id);
                 echo $update_stmt->queryString;
            $update_stmt->execute();
            
         } // End foreach
           
?>

