<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "getCrossroads.php";

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude, Type
              FROM `poi`
             WHERE Type = 'TORNADO' ";
             
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
       /*         $update_stmt = $db_found->prepare("
                UPDATE poi 
                   SET address = :ADDR_value 
                 WHERE id = :id 
                   AND Type = 'TORNADO' ");
                $update_stmt->bindParam(':ADDR_value', $address);
                $update_stmt->bindParam(':id', $id);
            $update_stmt->execute();
       */     
         }
           
?>

