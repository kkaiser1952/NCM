<?php
// This PHP is called by NetManager-p2.js

ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

//date_default_timezone_set("America/Chicago");
require_once "dbConnectDtls.php";
require_once "WXdisplay.php";
require_once "wx.php";
//require_once "getFCCrecord.php";/* added 2019-11-24 */

$q = strip_tags(substr($_POST["q"],0, 100)); 

//echo ("$q");

// // WA0TJT;MODES;Missouri Digital Emergency Service;80/40 Meters;0;Weekly Net;0
// // W0GPS;W0KCN;KCNARES;146.790MHz, PL107.2Hz;0;Weekly 2 Meter Voice;0;;y

//$q = strip_tags(substr("WA0TJT:W0KCN: KCNARES :146.790MHz, T 107.2Hz:0:Weekly 2 Meter Voice Net:0",0,100));
//$q = strip_tags(substr("WA0BC;TE0ST;TE0ST For Testing Only;444.550Mhz(+) PL100.0Hz;0;Test;0"));

//echo("$q");    //   0        1.      2.           3.            4.          5             6 7  8
                // W0GPS  ;W0KCN. ;KCNARES ;146.790MHz, PL107.2Hz ;0 ; Weekly 2 Meter Voice; 0; ; y
  // echo("$q");            
			    
$parts		= explode(":",$q);
$cs1 		= strtoupper($parts[0]);  // The NCS call sign
$netcall	= strtoupper($parts[1]);  // Call sign of the new net
$newnetnm	= $parts[2];  	// The org of the new net
$frequency  = $parts[3];	// The freq of the new net
$subNetOfID = $parts[4];	// The submet (if any) of the new net
$netKind	= $parts[5];	// The kind of net (DMR, weekly 2meter...)
$pb			= $parts[6];	// The Pre-Built Net Indicator (1 for yes, 0 for no)
$testEmail  = $parts[7];    // The email that created this net
$testnet    = $parts[8];    // If 'y' this is a test net    
//echo ("tn= $testnet");
$activity	= ltrim($newnetnm) . " " . ltrim($netKind);  //echo "activity= $activity";

$pbspot = '';
if ($pb == 1){$pbspot = 'PB';}

/* get the next netID from NetLog */
$stmt = $db_found->prepare("SELECT max(netID) as maxID FROM NetLog limit 1");
	$stmt->execute();
	$result = $stmt->fetchColumn(); 
		$newNetID = $result + '1';
	
        
// Below was added 2020-12-15
    $stmt2 = $db_found->prepare("
        SELECT MAX(recordID) AS maxID, MAX(id) as newid, id, Fname, Lname, creds, email, latitude, longitude,
		       grid, county, state, district, home, phone, tactical
	      FROM stations 
	     WHERE callsign = '$cs1'
         LIMIT 0,1
    ");                      
                            
	$stmt2->execute();
	$result = $stmt2->fetch();
	
		$maxID = $result[maxID];
		$id    = $result[id];	    
		$newid = $result[newid]; // get it if i need it for a new callsign
		$latitude  = $result[latitude];   //echo("tt = $tt");	
		$longitude = $result[longitude];
		$Fname = ucwords(strtolower($result[Fname]));	
		$Lname = ucwords(strtolower($result[Lname]));
		$Lname = $result[Lname];
		$Lname = str_replace("'","\'",$Lname);   // The \ is to escape the apostraphe (')
		$state = $result[state];
		$grid  = $result[grid]; 	$county	   = ucwords(strtolower($result[county]));
		$creds = $result[creds];	$district  = $result[district];
		$email = $result[email];    $home      = $result[home];	
		   // if ( !$email <> '' | $email <> ' ' ) { $email = $testEmail; }
		    if ( $email == ' ' ) { $email = $testEmail; }
		
		//$id	   = $result[1];
		$firstLogIn = 0;
		
		$from = '';
		//if (empty($maxID)) {
        if (is_null($maxID)) {
    		include "getFCCrecord.php";
    		
    		$stmt = $db_found->prepare("SELECT MAX(ID)+1 AS newid 
                                  FROM stations 
                                 LIMIT 0,1");
                $stmt->execute();
                $result = $stmt->fetch();
        		    $id = $result[newid];
                    $from = 'FCC';
		}
		
		//include "insertToStations.php";  // added 2020-12-12 to update the stations table
		
	// 0 means it is NoT a pre-build, 1 means it is a pre-built
	switch ($pb) {
      case 0;   // NOT a pre-built
       	$statusValue = 'In';
	   	$timeLogIn	 = $open;  // $open is created in dbConnectDtls.php 
       	break;
      case 1:   // IS a pre-built
      	$statusValue = 'OUT';
      	$timeLogIn	 = 0;
      	$PBcomment	 = 'Pre-Build Template Net for use at a later date';
      		$sql1 = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp) 
	  				 VALUES ('$maxID', '$id', '$newNetID', 'GENCOMM', '$PBcomment',   '$open')";
			$db_found->exec($sql1);
      	break;
      
      default:
      	$statusValue = 'In';
      	$timeLogIn	 = $open;
   }

	$sql = "INSERT INTO NetLog (netcontrol, active, callsign, Fname, Lname, activity, tactical, id, netID, grid, latitude, longitude, creds, email, comments, frequency, subNetOfID, logdate, netcall, state, county,
		district, pb, tt, firstLogin, home, testnet) 
	
		VALUES ('PRM', '$statusValue', '$cs1', '$Fname', \"$Lname\", '$activity', 'Net', '$id', '$newNetID', '$grid', '$latitude', '$longitude', '$creds', '$email', 'Opened NCM', '$frequency', '$subNetOfID', '$timeLogIn', '$netcall', '$state', '$county', '$district', '$pb', '00', '$firstLogIn', '$home', '$testnet' )";
		
	$db_found->exec($sql);
	
	/* This puts the creation time and weather into the TimeLog table */
	//$wxNOW = WXdisplay(1,getRealIpAddr());
	$wxNOW = currentWX();
	//echo("$wxNOW");
	
	$ipaddress = getRealIpAddr(); 
	
	$comment = "$Fname $Lname Opened the $pbspot net from $ipaddress on $frequency by: $testEmail";
		if ($subNetOfID > 0) {
			$comment = "$comment. Opened as a subnet of #$subNetOfID.";
		}
	
	$sql1 = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress) 
		VALUES ('$maxID', '$id', '$newNetID', '$cs1', '$comment', '$open', '$ipaddress')";
		
			$db_found->exec($sql1);
			
	$sql1 = "INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress)
		VALUES ('$maxID', '0', '$newNetID', 'WEATHER', '$wxNOW',   '$open', '$ipaddress')";
			$db_found->exec($sql1);
	
	/* This puts any satellite net number into its parent */
	if ($subNetOfID > 0) {
		/* Find whats in the subNetOfID field already */
		$sql = $db_found->prepare("select subNetOfID FROM NetLog where netID = $subNetOfID");
		$sql->execute();
		$result = $sql->fetchColumn();
		$curr_sub_nets = $result;
		
		$newList = $curr_sub_nets ."+". $newNetID;
	}
	
	/* Removed 2021-08-21 no longer needed
	if ("$from" == "FCC"){
	    include "insertToStations.php";  // added 2020-12-12 to update the stations table
	}*/
	
	/* push this back to the page */
	echo $newNetID;
	
?>