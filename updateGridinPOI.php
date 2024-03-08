<?php
// updateGridinPOI.php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "GridSquare.php";

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude, Type, grid 
              FROM `poi`
             WHERE grid is NULL
               AND class = 'siren'
                ";
               
               echo ("$sql");
               
         foreach($db_found->query($sql) as $row) {
             $id = $row['id'];
             $latitude = $row['latitude'];
             $longitude = $row['longitude'];
             $grid = gridsquare($latitude, $longitude);
             
             echo ("grid: $grid");
             
         // Update the w3w column in the poi table
                $update_stmt = $db_found->prepare("
                UPDATE poi 
                   SET GRID = :GRID_value 
                 WHERE id = :id 
                   AND grid is NULL
                   AND class = 'siren'
                    ");
                $update_stmt->bindParam(':GRID_value', $grid);
                $update_stmt->bindParam(':id', $id);
              echo "Attempting to execute update statement...";
                $update_stmt->execute();
  
                echo $update_stmt->queryString;

            //$update_stmt->execute();
            if (!$update_stmt->execute()) {
                echo "Update failed: " . $update_stmt->errorInfo()[2];
            }

            
         }
            
?>

