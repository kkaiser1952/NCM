<?php
// updateGridinPOI.php

//ini_set('display_errors', 1);
//error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "GridSquare.php";

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude, Type, grid 
              FROM `poi`
             WHERE grid = 'EM28TX' 
               AND Type = 'TORNADO' ";
               
              // echo ("$sql");
               
         foreach($db_found->query($sql) as $row) {
             $id = $row['id'];
             $latitude = $row['latitude'];
             $longitude = $row['longitude'];
             $grid = gridsquare($latitude, $longitude);
             
         // Update the w3w column in the poi table
                $update_stmt = $db_found->prepare("
                UPDATE poi 
                   SET GRID = :GRID_value 
                 WHERE id = :id 
                   AND grid = 'EM28TX'
                   AND Type = 'TORNADO' ");
                $update_stmt->bindParam(':GRID_value', $grid);
                $update_stmt->bindParam(':id', $id);
            $update_stmt->execute();
            
         }
            
?>

