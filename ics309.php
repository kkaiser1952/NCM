<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = intval($_GET["NetID"]);  // $q = 1189;
    
    // The below SQL is used to report the parent and child nets
    $sql = "SELECT subNetOfID, 
			       GROUP_CONCAT(DISTINCT netID SEPARATOR ', ')
			  FROM NetLog
			 WHERE subNetOfID = $q
			 ORDER BY netID";
			 
	$stmt = $db_found->prepare($sql);
	
	//	$stmt -> execute();
	//		$parent = $stmt->fetchColumn(0);
		$stmt -> execute();
			$children = $stmt->fetchColumn(1); 
		
	//	echo "p= $parent<br>";
	//	echo "c= $children<br>";
    
    
    $sql1 = ("SELECT min(a.logdate) AS minlog, 
    				 DATE(min(a.logdate)) AS indate, 
    				 TIME(min(a.logdate)) AS intime, 
    				 DATE(max(a.timeout)) AS outdate, 
    				 TIME(max(a.timeout)) AS outtime, 
    				 a.activity, a.fname, a.lname, 
    				 a.netcontrol, 
    				 a.callsign, 
    				 a.netcall,
    				 b.kindofnet, b.box4, b.box5, a.subNetOfID,
    				 a.frequency
    	       FROM NetLog  as a
    	       	   ,NetKind as b
    	       WHERE a.netcall = b.call
			     AND netID = $q 
			     AND logdate = (SELECT min(logdate) 
								  FROM NetLog 
								  WHERE netID = $q )
			");
    			
			
    foreach($db_found->query($sql1) as $row) {
	    
	    $fname  = $row[fname];  $lname   = $row[lname]; 		$activity = $row[activity];
	    $indate = $row[indate]; $outdate = $row[outdate];	$netcntl = $row[callsign];
	    $intime = $row[intime]; $outtime = $row[outtime];	$name = $row[activity];
	    $parent = $row[subNetOfID]; $freq = $row[frequency]; $netCall = $row[netcall];
	    //$home	= $row[home];
	    	if ($row[netcontrol] == "PRM") {$netcontrol = "Net Control Operator"; $netopener = $row[callsign];};
    }
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ICS 309</title>
    <meta name="author" content="Graham" />
    <link rel="stylesheet" type="text/css" media="all" href="css/ics309.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    
    <script>

	
	</script>
	
	<style>
		
	</style>
	
    
</head>
<body>
	<div class = "row1">
		<span class = "r1box1">COMM Log<br>ICS 309<br><?php echo "$netCall"; ?>
		</span>
		<span class = "r1box2">1. Incident Name:<?php echo "  Net#: $q<br>$activity"; ?>
		</span>
		<span class = "r1box3">2. Operational Period (Date/Time)<br>
			From:<?php echo " $indate $intime<br>
			To: $outdate $outtime"; ?>
		</span>
	</div>
	
	
	<div class = "row2">
		<span class = "r2box1">3. Radio Net Name or Position/Tactical Call
		</span>
		<span class = "r2box2">4. Radio Operator (Name, Call Sign)<br><?php echo "$netcntl - $fname $lname Net Control"; ?>
		</span>
	</div>
	
	<div class = "row3">
		<span class = "r3box1">COMMUNICATIONS LOG
		</span>
	</div>
	
	<div class = "logtable">
		<table class = "table1">
			<thead id="thead" style="text-align: center;">			
				<tr> 
					<th class="th1" colspan="1">	Time<br>(Local)</th>
					<th class="th2" colspan="2">FROM:<br>Call Sign/ID | Msg #</th>
					<th class="th3" colspan="2">TO:<br>Call Sign/ID | Msg #</th>
					<th class="th4" colspan="1">Message</th>
				</tr>
			</thead>
			<tbody>
				<?php
	        
			     /*   $sql = ("SELECT time(TIMESTAMP) as timestamp, 
			                        ID, callsign, comment
			        		   FROM TimeLog 
			        		  WHERE netID = $q 
			        		    AND comment <> 'Initial Log In'
			        		    AND comment NOT LIKE 'this id was deleted'
			        		  ORDER BY timestamp");
			     */   		  
                    $sql = ("SELECT time(TIMESTAMP) as timestamp, 
			                        ID, callsign, comment, uniqueID
			        		   FROM TimeLog 
			        		  WHERE netID = $q
			        		    AND comment <> 'Initial  Log In'
			        		    AND comment NOT LIKE '%this id was deleted%'
                                AND comment <> 'The log was closed, ICS-214 Created'
                                AND callsign NOT IN('GENCOMM', 'weather')
                                AND comment <> 'The log was re-opened'
                                AND comment NOT LIKE '%Mode set to:%'
                                AND comment NOT LIKE '%Opened the  net from%'
			        		  ORDER BY timestamp");
			/*
			  
    			  SELECT DISTINCT time(timestamp) as timestamp, band, comment,
	   TimeLog.callsign
  FROM TimeLog, NetLog
 WHERE TimeLog.netID = 1274 
   AND NetLog.netID = 1274
   AND TimeLog.id = NetLog.id
 ORDER BY timestamp
    			  
    			  
    			         $sql = ("SELECT time(t1.timestamp) as timestamp, t1.callsign, t2.band, t1.comment, t1.netID, t1.id
FROM TimeLog t1 
JOIN (SELECT band, netID, id FROM NetLog WHERE netID = 1274) t2 
ON (t1.id = t2.id ) 
WHERE t1.netID=1274 AND t2.netID = 1274
GROUP BY band, callsign, timestamp
ORDER by timestamp"); */
						foreach($db_found->query($sql) as $row) {
							
							echo "<tr style=\"height: 17pt\">
									   <td class=\"box4td1\"  colspan=\"1\">	$row[timestamp]</td>
									   <td class=\"box4td2\"  colspan=\"1\">	$row[callsign]</td>
									   <td class=\"box4td3\"  colspan=\"1\">UNK</td>
									   <td class=\"box4td4\"  colspan=\"1\">	NCO</td>
									   <td class=\"box4td5\"  colspan=\"1\">$row[uniqueID]</td>
									   <td class=\"box4td6\"  colspan=\"1\">	$row[comment]</td>
								  </tr>";			
					}
				?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
	
	<div class = "row5">
		<span class = "r5box1">6. Prepared By (Name, Call sign)<br><?php echo "$fname $lname -- $netcntl"; ?>
		</span>
		<span class = "r5box2">7. Date &amp; Time Prepared<br><?php echo date('l jS \of F Y h:i:s A'); ?>
		</span>
		<span class = "r5box3">8.<br>Page 1 of 
		
		</span>
	</div>
	
	
	
	
	
</body>
</html>