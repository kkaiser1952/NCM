<!doctype html>

<!-- INCIDENT RADIO COMMUNICATIONS PLAN (ICS 205A) -->

<!-- https://training.fema.gov/emiweb/is/icsresource/assets/ics%20forms/ics%20form%20205,%20incident%20radio%20communications%20plan%20(v2).pdf -->

<?php 

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = intval($_GET["NetID"]);   //$q = 1580;
    
   // $q = 815;
    
    $sql = "SELECT frequency,
    			CASE WHEN CONVERT(SUBSTRING(frequency,1,3),UNSIGNED INTEGER) > 400.0 THEN 'UHF'
				     WHEN CONVERT(SUBSTRING(frequency,1,3),UNSIGNED INTEGER) > 140.0 THEN 'VHF'			     
				     WHEN CONVERT(SUBSTRING(frequency,1,3),UNSIGNED INTEGER) < 140.0 THEN 'HF'
				     ELSE 'Unknown'
				END AS 'band'
    		  FROM NetLog
    		 WHERE netID = $q
    		   AND frequency <> '' ";
    $stmt = $db_found->prepare($sql);
		$stmt -> execute();
			$freq = $stmt->fetchColumn(0);
			$stmt -> execute();
			$band = $stmt->fetchColumn(1);
    
    $sql1 = ("SELECT min(a.logdate) AS minlog, 
    				 DATE(min(a.logdate)) AS indate, 
    				 TIME(min(a.logdate)) AS intime, 
    				 DATE(max(a.timeout)) AS outdate, 
    				 TIME(max(a.timeout)) AS outtime, 
    				 a.activity, a.fname, a.lname, 
    				 a.netcontrol, 
    				 a.callsign, a.netcall,
    				 b.kindofnet, b.box4, b.box5
    	       FROM NetLog as a
    	       	   ,NetKind   as b
    	       WHERE a.netcall = b.call
			     AND netID = $q 
			     AND logdate = (SELECT min(logdate) 
					FROM NetLog 
				   WHERE netID = $q )
			");
			
			//echo("$sql1");
			
			
    foreach($db_found->query($sql1) as $row) {
	    
	    $fname  = $row[fname];  $lname   = $row[lname]; 	$activity = $row[activity];
	    $indate = $row[indate]; $outdate = $row[outdate];	$netcntl = $row[callsign];
	    $intime = $row[intime]; $outtime = $row[outtime];	$name = $row[kindofnet];

	    //$home	= $row[home];
	    	if ($row[netcontrol] == "PRM") {$netcontrol = "Net Control Operator"; $netopener = $row[callsign];};
    }
?>

<html lang="en" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ICS 205A</title>
    <meta name="author" content="Kaiser" />
    <link rel="stylesheet" type="text/css" media="all" href="css/ics205.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    
    <script>
	
	</script>
	<style>
		body table {
			width:100%;
		}
	</style>
	
    
</head>
<body>
	<div id="tableDiv">
    <table class="table1">
        <tr>
            <td class="box1" >
	                <p style="font-weight: bold;">ICS 205A Communications List</p>
	                <br><br>
                    <b>1. Incident Name:</b><?php echo "<br>Log:#$q/$row[activity]";?>
            </td>
             
            <td class="box3">
                    <b>2. Operational Period:</b><br><br>
                    <b>Date From:</b> <?php echo $indate ?> <b>To:</b> <?php echo $outdate ?>
					<br>
                    <b>Time From:</b> <?php echo $intime ?> <b>To:</b> <?php echo $outtime ?>
            </td>
        </tr>
    </table>
    <table class="table1">
        <tr>
            <td colspan="3">
                <b>3. Basic Local Communications Information:</b>
            </td>
        </tr>
        <tr>
            <th class="box3-1">
                 
                 Band and Incident Assigned Position
            </th>
            <th class="box3-2">

                    Name (Alphabetized)
            </th>
            <th class="box3-3">

                    Method(s) of Contact (phone, pager, cell, etc.)
            </th>
        </tr>
        
        <?php 
	      	$sql1 = ("SELECT band, fname, lname, callsign, Mode, email, tactical, netcontrol, phone,
	      	              (CASE WHEN lname = '' THEN tactical
	      	                   ELSE lname 
	      	               END) as lname, 
	      						CASE WHEN netcontrol = 'PRM' THEN 'Primary Net Control'
	      							 WHEN netcontrol = 'Log' THEN 'Primary Net Logger'
		  							 WHEN netcontrol = '2nd' THEN 'Secondary Net Control'
		  							 WHEN netcontrol = 'LSN' THEN 'Net Liaison'
		  							 WHEN netcontrol = 'EM'  THEN 'Primary Net Logger'
		  							 WHEN netcontrol = 'PIO' THEN 'Public Information Officer'
	      						ELSE 'Operator'
	      						END as role
		  				FROM NetLog
		  			   WHERE netID = $q 
		  			   ORDER BY lname
			");

			foreach($db_found->query($sql1) as $row) {
				$bonusRole = explode(">",$row[tactical])[1];
			//	$bonusRole = end(explode('>',$row[tactical]));
				//$bonusRole = 'testing';
				
				echo "<tr>
						<td style='width: 25%'>$row[band] $row[role] $bonusRole</td>
						<td>$row[lname], $row[fname], $row[callsign]</td>
						<td>$band - $freq, $row[Mode] &nbsp; $row[email] &nbsp; $row[phone]</td>
					  </tr>";
			} 
        ?>
        
        <tr>
	        <td>4. Prepared by: <?php echo "<br>$fname $lname" ?></td>
	        <td>Position/Title: Net Control Operator</td>
	        <td>Signature</td>
        </tr>
        <tr>
	        <td>ICS 205A</td>
	        <td>IAP Page</td>
	        <td>Date/Time: <?php echo "$outdate $outtime" ?></td>
        </tr>
        
    </table>
    </div>
    <p>ics205A.php</p>
</body>
</html>