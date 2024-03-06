<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "GridSquare.php";

    // Select data from the poi table
    $sql = "SELECT id, latitude, longitude, Type 
              FROM `poi`
             WHERE grid = 'EM28TX' 
               AND Type = 'TORNADO' ";
               
              // echo ("$sql");
               
         foreach($db_found->query($sql) as $row) {
             echo "$id";
           }
/*
        foreach($db_found->query($sql) as $row) {
            $id = $row['id'];
            //$latitude = $row['latitude'];
            //$longitude = $row['longitude'];
            
         //   $grid = gridsquare($latitude, $longitude);
            
            echo "id: $id ,grid: $grid ";
        }
       */     
?>

