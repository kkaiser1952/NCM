<!doctype html>
<!-- This program uses the fcc amateur radio data base to pull some of the missing values and put them into NetLog.
	 Written by: Keith, WA0TJT
	 Date: 6/18/2017
	 
	 *** USE CAREFULLY *** IT UPDATES A DATABASE
-->
<?php
ini_set('display_errors',1); 
error_reporting (E_ALL ^ E_NOTICE);
	
require_once "dbConnectDtls.php";
require_once "geocode.php";
require_once "GridSquare.php";

$fixid   = $_GET['id'];
$fixcall = $_GET['call'];
//echo ("fixcall= $fixcall<br><br>");
 
$row_count = 0;

// This SQL gets the information from the FCC database
$sql = "SELECT *, CONCAT_WS(' ', address1, city, state, zip) as address 
		  FROM fcc_amateur.en
		 WHERE callsign = '$fixcall'";
	   
	  // echo "$sql <br>"; 

	  foreach($db_found->query("$sql") as $row ){
	
		$koords = geocode("$row[address]");
			$lat 	= $koords[0];
			$lon 	= $koords[1];
			$county	= $koords[2];
		
		$lastname = $row[last];  // from FCC db
		$state	  = $row[state];
		
			if($lat <> '' && $lon <> ''){
				$grid = gridsquare($lat, $lon);
				$gridsquare = "$grid[0]$grid[1]$grid[2]$grid[3]$grid[4]$grid[5]";
			}
			// This SQL updates the NetLog with the new information
			$sql2 = "UPDATE NetLog 
						SET longitude 	= $lon
						   ,latitude 	= $lat
						   ,Lname 		= '$lastname'
						   ,grid 		= '$gridsquare'
						   ,county		= '$county'
						   ,state		= '$state'
					  WHERE ID = $fixid" ;
					  
			$db_found->exec($sql2);		
	  }		 
		 
		echo("<br> $sql <br><br>");
		echo("$sql2 <br><br>");
		echo("grid= $gridsquare lname= $lastname lat= $lat lon= $lon");
//echo("<br><br>Row Count= $row_count");

?>