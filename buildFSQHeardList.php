<?php
// function to geocode address, it will return false if unable to geocode address
require_once "dbConnectDtls.php";

$netID = strip_tags($_POST["q"]);
//$netID = 3361;
// you may have to increase the size of the GROUP_CONCAT if the number of callsigns is above 146
// this is done with a SET GLOBAL group_concat_max_len=2048 this makes the max about 292 callsigns

	$sql0 = "SET GLOBAL group_concat_max_len=2048";
	mysql_query($sql0);

	$sql = "
		SELECT LOWER(callsign) AS callsign, netcontrol, 
		       IF(netcontrol = 'RELAY', callsign, '') as relay,
               CONCAT('w0wts;allcall NCS calling ',callsign,' ',callsign) as viaRelay,
               CONCAT('allcall NCS calling ',callsign,' ',callsign) as direct
		  FROM NetLog
		 WHERE netID = $netID
		   AND active NOT LIKE '%Out%'
         ORDER BY netcontrol DESC, logdate 
	";
	
	//echo "$sql";
	$fsqList = '';
	$relaystation = '';
	
	foreach($db_found->query($sql) as $row) {
    	if ("$row[relay]" <> '' ) { $relaystation = "$row[callsign];"; }
    	$fsqList .= "allcall NCS calling $row[callsign] $row[callsign] <br>
    	             $relaystation allcall NCS calling $row[callsign] $row[callsign] <br> <br>
    	            ";
	} // end foreach
	
	 echo "$fsqList";
?>
