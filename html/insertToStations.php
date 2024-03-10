<?php
require_once "dbConnectDtls.php";

// 2020-12-12 This program loads any first time stations that get logged into NCM into the stations table
// Called by getFCCrecord.php

    // Because MySQL can only have one auto increment column per table, and recrodID is already set to it.
    // We need to increment the ID manually by first getting the next higher number.
/*    $stmt = $db_found->prepare("SELECT MAX(ID)+1 AS newid 
                                  FROM stations 
                                 LIMIT 0,1");
        $stmt->execute();
        $result = $stmt->fetch();
		    $newid = $result[newid];
	*/	
       
    $sql = "INSERT INTO stations (ID, callsign, Fname, Lname, grid, tactical, email, fccid,
                                  latitude, longitude, creds, county, state, district, 
                                  home, phone, latlng, lastLogDT, firstLogDT )
    
	        VALUES ('$id', '$csbase', '$Fname', '$Lname', '$grid', '$tactical', '$email', '$fccid', '$latitude', '$longitude', '$creds', '$county', '$state', '$district', '$home', '$phone', GeomFromText(CONCAT('POINT (', $latitude, ' ', $longitude, ')')), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
	       ";	        
	        
    $db_found->exec($sql);
	        
?>