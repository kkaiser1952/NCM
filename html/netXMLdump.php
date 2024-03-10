<?php
	// netXMLdump.php is used to create an automatically downloaded XML file of any net or the open net
	// The click point is at the bottom of any open net, called "Export XML"
	// Partial source:
	// Written 2020-09-08 by WA0TJT
	
// https://stackoverflow.com/questions/43762989/mysql-to-xml-using-php-script

// https://net-control.us/netXMLdump.php
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    //$q = $_GET['q'];  //echo "q is $q";
    $q = intval( $_GET["netID"] );
    $q = 2807;
    
    // get the date the net was started to use as part of the output file name
    $sql = $db_found->prepare("SELECT MIN(DATE(logdate)) FROM NetLog WHERE netID = '$q' limit 1" );
    	$sql->execute();
    	$ts = $sql->fetchColumn();
    
        $filename = "NCM_Log$q-" . $ts . ".xml";
              
        //Set the Content-Type and Content-Disposition headers to force the download.
        header('Content-Type: text/xml; charset-utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');   
            
    // get the data 
	$sql = "SELECT recordID, ID, active, callsign, tactical, Fname, Lname, firstLogin, netcontrol as role,
	               grid, latitude, longitude, county, state, district, email, phone, creds, tt, cat, home, Band,
	               traffic, Mode, logdate, timeout, timeonduty, comments
	          FROM NetLog 
	         WHERE netID = $q
	         ORDER BY recordID
           ";
           
    $str ="<?xml version="1.0" encoding="UTF-8"?>n<ham>";
           
        foreach($db_found->query($sql) as $row) {
            $str .= "\n<details>\n\t\t\t<ID>$row[ID]</ID>\n\t\t\t<name>$row[Fname] $row[Lname]</name> ";

            $str .= "\n\t\t\t  <callsign>$row[callsign]</callsign>\n</details>";
        }
        
        $str.= "\n</ham>";
        //$str=nl2br($str);
        //echo htmlspecialchars($str); // remove this line if you are writing to file
        echo $str;
        
        //Open up a file pointer
        $fp = fopen('php://output', 'w');
        
        fwrite ($fp,$str);          // entering data to the file
        fclose ($fp);                                // closing the file pointer
        chmod($file_name,0777);
     
?>