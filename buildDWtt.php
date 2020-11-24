<?php
	
require_once "dbConnectDtls.php";

define('CONST_USER_TIMEZONE', 'America/Chicago');
/* server timezone */
define('CONST_SERVER_TIMEZONE', 'CST');
 
/* server dateformat */
define('CONST_SERVER_DATEFORMAT', 'Y-m-d H:i:s');


$q = $_GET["q"]; 
//echo("$q");
$q = 3054;


	$sql = "SELECT substring(tt,-2) as tt, callsign, fname, lname, grid, latitude, longitude, tactical
		  FROM NetLog
		 WHERE tt >= 00 AND tt < 100 
		   AND netID = $q
		 GROUP BY tt
		 ORDER BY tt"; 
		  
	foreach($db_found->query($sql) as $row) {
		$latitude = $row[latitude];
		$longitude = $row[longitude];
	//	$tactical = $row[tactical];
		
	  if ($longitude == '') {$longitude = -94.729280;}	  
	  if ($latitude == '') {$latitude = 39.183506;}
	  
	  
	  $places = array("EOC15","EOC03","EOC04");
	  $varname = "callsign";
	 	if (in_array("$row[tactical]", $places))
		  	{ $varname  = 'tactical'; };
	  

	  if($row[tt] < 80) {
		echo "#$row[tt] $row[callsign] $row[fname] $row[lname] $row[grid] <br>
		TTPOINT B9$row[tt] $row[latitude] $row[longitude] <br>
		TTMACRO $row[tt]yyyyyy BAyyyyyy*AC{{$row[callsign]}}*AB130 <br>
		TTMACRO $row[tt]yyyyyyz BAyyyyyy*Cz*AC{{$row[callsign]}}*AB130 <br>
		TTMACRO $row[tt]     B9$row[tt]*AC{{$row[callsign]}}*AB113 <br>
		TTMACRO $row[tt]z    B9$row[tt]*Cz*AC{{$row[callsign]}}*AB113 <br>
		TTMACRO $row[tt]yy   B9yy*AC{{$row[callsign]}}*AB130 <br>
		TTMACRO $row[tt]yyz  B9yy*Cz*AC{{$row[callsign]}}*AB130
		<br><br>";  
	  } else {
		 
		echo "#$row[tt] $row[callsign] $row[fname] $row[lname] $row[grid] <br>
		TTPOINT B9$row[tt] $row[latitude] $row[longitude] <br>
		TTMACRO $row[tt] B9$row[tt]*AC{{$row[$varname]}}*AB179 <br>
		TTMACRO $row[tt]z B9$row[tt]*Cz*AC{{$row[$varname]}}*AB179
		<br><br>";
	  }
	}
	
	/*
	#13 LHHM Keith (WA0TJT) Kaiser 
	TTPOINT B913 39.246586 -94.439638 
	TTMACRO 13yyyyyy BAyyyyyy*AC{LHHM}*AB130 
	TTMACRO 13yyyyyyz BAyyyyyy*Cz*AC{LHHM}*AB130 
	TTMACRO 13 B913*AC{LHHM}*AB113 
	TTMACRO 13z B913*Cz*AC{LHHM}*AB113 
	TTMACRO 13yy B9yy*AC{LHHM}*AB130 
	TTMACRO 13yyz B9yy*Cz*AC{LHHM}*AB130 
	*/
	
?>