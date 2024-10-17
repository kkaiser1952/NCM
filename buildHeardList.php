<?php
// function to geocode address, it will return false if unable to geocode address
require_once "dbConnectDtls.php";

//$netID = strip_tags($_POST["q"]);

$netID = intval($_POST["q"]);
//$netID = 12369;
// you may have to increase the size of the GROUP_CONCAT if the number of callsigns is above 146
// this is done with a SET GLOBAL group_concat_max_len=2048 this makes the max about 292 callsigns

	$sql0 = "SET GLOBAL group_concat_max_len=2048";
	mysql_query($sql0);


	$sql = $db_found->prepare("
		SELECT GROUP_CONCAT(callsign, IF (netcontrol IS NULL, '', CONCAT('  ',netcontrol))
		    ORDER BY logdate ASC SEPARATOR '<br>   ')                                   AS callList
		      ,GROUP_CONCAT(callsign ORDER BY logdate ASC SEPARATOR '<br>   ')          AS lowcase_callList
			  ,GROUP_CONCAT(callsign ORDER BY logdate ASC SEPARATOR ' ' )               AS callList2
			  ,GROUP_CONCAT(callsign,' (',county,'Co.)' ORDER BY logdate ASC SEPARATOR '<br>  ') AS callCntyList
			  ,GROUP_CONCAT(callsign,' (',county,'Co., Dist: ',district,')' ORDER BY logdate ASC SEPARATOR '<br>  ')                AS callCntyDistList
			  ,GROUP_CONCAT(callsign ORDER BY callsign SEPARATOR '<br> ' )              AS callListAlpha
			  ,GROUP_CONCAT(Fname,', ',callsign ORDER BY callsign SEPARATOR '<br> ' )   AS nameAlpha
			  
		  FROM NetLog
		 WHERE netID = $netID
		 
		 ORDER BY (CASE
		 WHEN netcontrol = 'PRM'   THEN 1
                      WHEN netcontrol = '2ND'   THEN 2
                      WHEN netcontrol = 'Log'   THEN 3
                      WHEN netcontrol = 'RELAY' THEN 4
                      WHEN netcontrol = 'LSN'   THEN 5
                      WHEN netcontrol IN ('EM', 'PIO') THEN 6
                      WHEN netcontrol = 'SEC'   THEN 7
                      ELSE 8 -- assign a value that places the unmatched rows last
            END),
                 dttm ASC;	  
	");
	
	$sql->execute();
		$result = $sql->fetch();
			echo "NCS heard List for Net #$netID<br>Stations listed in net order:<br>$result[callList]";
			
			$vert = "NCS heard List for Net #$netID<br>Stations listed in net order: $result[callList2]";
			$Vcombo = "NCS heard List for Net #$netID<br>Stations listed in net order: $result[callCntyList]";
			$vcomboDist = "NCS heard List for Net #$netID<br>Stations listed in net order: $result[callCntyDistList]";
			
			$alphaList = "NCS  List for Net #$netID<br>$result[callListAlpha]";
			
			$nameAlpha = "NCS  List for Net #$netID<br>$result[nameAlpha]";
			
			$lowcase = strtolower("NCS  List for net #$netID<br>$result[lowcase_callList]");
			
			
			echo "<div><input type=\"button\" onclick=\"javascript:window.close()\" value=\"Close\" style=\"float:right; padding-left: 20px;\">";
			
			echo "<div><br><br> Version1a: Lower Case Horizontal<br><br> $lowcase <div>";
			
			echo "<div><br><br> Version2: Horizontal<br><br> $vert <div>";
			
			echo "<div><br><br> Version3: Vertical Combo<br><br> $Vcombo <div>";
			
			echo "<div><br><br> Version4: Vertical Combo with District<br><br> $vcomboDist <div>";
			
			echo "<div><br><br> Version5: Vertical &amp; Alphabetized:<br><br> $alphaList <div>";
			
			echo "<div><br><br> Version6: Vertical &amp; With Name:<br><br> $nameAlpha <div>";
			
			echo "<div><input type=\"button\" onclick=\"javascript:window.close()\" value=\"Close\" style=\"float:right; padding-left: 20px;\">";
			
			echo "<div><p>Send me an example of anything else you might like. If the information is in the database I'll do my best to supply it.</p></div>";
			
			echo "<p>buildHeardList.php</p>";
			
?>
