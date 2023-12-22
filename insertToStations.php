<?php
require_once "dbConnectDtls.php";

// 2020-12-12 This program loads any first time stations that get logged into NCM into the stations table
// Called by getFCCrecord.php

    // Because MySQL can only have one auto increment column per table, and recrodID is already set to it.
    // We need to increment the ID manually by first getting the next higher number.
	
	// Get the next ID 
	$sql = "SELECT MAX(ID)+1 as nextid
              FROM stations 
             WHERE ID < 38000
             LIMIT 0,1
           ";
         $stmt = $db_found->prepare($sql);
         $stmt->execute();
    	    $nextid = $stmt->fetchColumn(0);
    	    //echo("$nextid");
     
     // Removed latlng from insert on 2023-12-22
       $sql = "INSERT INTO stations 
                    (ID, callsign, Fname, Lname, grid, tactical,
                     email, fccid, latitude, longitude, creds, county, 
                     state, district, home, city, phone, zip, lastLogDT, 
                     firstLogDT )
    
	           VALUES ('$nextid', '$csbase', '$Fname', '$Lname', '$grid',   
	                   '$tactical', '$email', '$fccid', '$latitude', '$longitude', 
	                   '$creds', '$county', '$state', '$district', '$home', 
                       '$city', ' ', '$zip', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
	          ";	      
	        
	   $stmt2 = $db_found->prepare($sql);
	   $stmt2 -> execute();
	
      // $db_found->exec($sql);      
?>