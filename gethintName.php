<?php
//date_default_timezone_set("America/Chicago");
require_once "dbConnectDtls.php";

$q = $_REQUEST["q"]; 	//$q = "keith";

/* This query pulls the last time this callsign logged on */
/*
$stmt = $db_found->prepare("SELECT DISTINCT callsign, Fname, ID, grid, tactical, latitude, longitude, email, Lname
		FROM NetLog 
		WHERE recordID IN (SELECT max(recordID) 
		FROM NetLog 
		WHERE (Fname LIKE ? )
		AND callsign NOT IN ('W0KCN','WA0QFJ','T0EST','K0ERC')
		GROUP BY callsign)");
*/
$stmt = $db_found->prepare("
SELECT DISTINCT 
    callsign
  , Fname
  , ID
  , grid
  , tactical
  , latitude
  , longitude
  , email
  , Lname
FROM NetLog 
INNER JOIN ( 
    SELECT max(recordID) as recordID
    FROM NetLog 
    WHERE Fname LIKE  ?
    AND callsign NOT IN ('W0KCN','WA0QFJ','T0EST','K0ERC','NR0AD')
    GROUP BY callsign
  ) t1 on t1.recordID = NetLog.recordID;"); 
		
$stmt->execute(array("%$q%"));

//$result = $stmt->fetchAll();
//print_r($result);

$list = $stmt->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$ID = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['ID']);
	$callsign = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['callsign']);
	$Fname = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['Fname']);
	
	$grid  		 = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['grid']);
	$tactical 	 = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['tactical']);
	$latitude	 = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['latitude']);
	$longitude	 = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['longitude']);
	$email		 = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['email']);
	$Lname		 = str_replace($_POST['q'], '<b>'.$_POST['q'].'</b>', $rs['Lname']);
	// add new option
	
	
    echo '<li onclick="set_cs1		(\''.str_replace("'", "\'", $rs['callsign']).'\');
    				   set_Fname	(\''.str_replace("'", "\'", $rs['Fname']).'\');
    				   set_hidden	(\''.str_replace("'", "\'", $rs['ID']).'\');
    				   set_hidestuff(\''.str_replace("'", "\'", $rs['grid'].':'.
    				   											$rs['tactical'].':'.
    				   											$rs['latitude'].':'.
    				   											$rs['longitude'].':'.
    				   											$rs['email'].':'. 
    				   											$rs['Lname']).'\')
    				   											;

    	">'.$callsign.',   '.$Fname.'</li>';
}

?>