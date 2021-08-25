<!doctype html>
<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    //require_once("DateSelector.php");
    
    
    // http://php.net/json_decode    decodes JSON strings.
    function json_clean_decode($json, $assoc = false, $depth = 512, $options = 0) {
    // search and remove comments like /* */ and //
    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
    
    if(version_compare(phpversion(), '5.4.0', '>=')) {
        $json = json_decode($json, $assoc, $depth, $options);
    }
    elseif(version_compare(phpversion(), '5.3.0', '>=')) {
        $json = json_decode($json, $assoc, $depth);
    }
    else {
        $json = json_decode($json, $assoc);
    }

    return $json;
}

require_once "dbConnectDtls.php";

// Clean up the incoming data
$q = substr($_POST["q"],0, 5000);

$str = explode("|", $q);

// This mysqli is needed to make the real_escape_string function work.
$mysqli = new mysqli("$strHostName", "$strUserName", "$strPassword", "$strDbName");

//$eventDisc 		= $str[0]; //echo("<br><br><br>$eventDisc<br><br><br>");
$eventDisc		= $mysqli->real_escape_string($str[0]);
$callsign  		= strtoupper($str[1]);
$contact   		= ucwords($str[2]);
$email	   		= filter_var($str[3], FILTER_SANITIZE_EMAIL);
$eventTitle 	= $mysqli->real_escape_string(htmlspecialchars($str[4]));
$eventURL		= filter_var($str[5], FILTER_SANITIZE_URL);
$eventLocation 	= $mysqli->real_escape_string($str[6]);
$startDate 		= $str[7];
$endDate   		= $str[8];
$domain			= $str[9];
$docType		= $str[10];
//$oldID			= $str[11];
$netkind		= $str[11];
$eventDate		= $str[12];

if (strtotime("$startDate") === false) {
	$fixStart = date("Y-m-d H:i:s", strtotime('today'));
} else {
	$fixStart = date("Y-m-d H:i:s", strtotime("$startDate"));
} 


if (strtotime("$endDate") === false) {
	$fixEnd = date("Y-m-d H:i:s", strtotime('+5 years'));
} else {
	$fixEnd = date("Y-m-d H:i:s", strtotime("$endDate"));
}

if (!$oldID) { // creates a new row
$sql = "INSERT INTO events (callsign, title, description, location, contact, email, url, start, end, domain, doctype, netkind, eventDate) 
		VALUES ('$callsign', '$eventTitle', '$eventDisc', '$eventLocation', '$contact', '$email', '$eventURL', '$fixStart', '$fixEnd', '$domain', '$docType', '$netkind', '$eventDate')";
} else { // updates an existing row
$sql = "UPDATE events SET callsign = '$callsign', title = '$eventTitle', description = '$eventDisc', 
			location = '$eventLocation', contact = '$contact', email = '$email', url = '$eventURL', 
			start = '$fixStart', end = '$fixEnd', domain = '$domain', doctype = '$docType', netkind = '$netkind', eventDate = '$eventDate'
		 WHERE id = $oldID";
}
	//echo "$sql";
	$db_found->exec($sql);
	
	echo("<div id=\"subby\">Submitted by: $contact, $callsign</div>");
	echo("<div>Date(s): $fixStart to $fixEnd");
	echo("<div>Location: $eventLocation</div>");
	echo("<br>");
	echo("<div id=\"subj\">Subject: $eventTitle</div>");
	echo("<div id=\"whatitis\">$eventDisc</div>");
	echo("<br>");
	echo("<div id=\"qs\">Questions: $email");
	echo("<br><br>");
	
?>