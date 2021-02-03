<?php
require_once "dbConnectDtls.php";

// 2020-12-12 This program loads any first time stations that get logged into NCM into the stations table
// Called by getFCCrecord.php
       
    $sql = "INSERT INTO stations (ID, callsign, Fname, Lname, grid, tactical, email, 
                                  latitude, longitude, creds, county, state, district, 
                                  home, phone, latlng, lastLogDT, firstLogDT )
    
	        VALUES ('$id', '$csbase', '$Fname', '$Lname', '$grid', '$tactical', '$email', '$latitude', '$longitude', '$creds', '$county', '$state', '$district', '$home', '$phone', GeomFromText(CONCAT('POINT (', $latitude, ' ', $longitude, ')')), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
	       ";	        
	        
    $db_found->exec($sql);
	        
?>