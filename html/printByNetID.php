<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
   
    $q = intval($_GET["NetID"]);
    
    $sql1 = ("SELECT min(a.logdate) AS minlog, 
    				 DATE(min(a.logdate)) AS indate, 
    				 TIME(min(a.logdate)) AS intime, 
    				 DATE(max(a.timeout)) AS outdate, 
    				 TIME(max(a.timeout)) AS outtime, 
    				 a.activity, email,
    				 CONCAT(a.fname, a.lname) as allname,
    				 a.netcontrol, a.callsign, a.netcall,
    				 b.name, b.box4, b.box5
    	       FROM NetLog as a
    	       	   ,meta   as b
    	       WHERE a.netcall = b.call
			     AND netID = $q 
			     AND logdate = (SELECT min(logdate) 
					FROM NetLog 
				   WHERE netID = $q )
			");
			
    foreach($db_found->query($sql1) as $row) {
	    
	    $fname  = $row[allname]; $activity = $row[activity];
	    $indate = $row[indate];  $outdate = $row[outdate];	$netcntl = $row[callsign];
	    $intime = $row[intime];  $outtime = $row[outtime];	$name = $row[name];
	    $allname = $row[allname]; $email = $row[email];
	    
	    	if ($row[netcontrol] == "PRM") {$netcontrol = "Net Control Operator"; $netopener = $row[callsign];};
    }
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>NCM Print</title>
    <meta name="author" content="Graham" />
    <link rel="stylesheet" type="text/css" media="all" href="css/ics214.css">
    <link href="https://fonts.googleapis.com/css?family=Allerta" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Cantora+One" rel="stylesheet" type="text/css"  >
    <link rel="stylesheet" type="text/css" href="css/printByNetID.css" >
    
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <link href="bootstrap/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script> -->
    
   <script src="js/sortTable.js"></script> 
    
    <script>

	</script>
	
	<style>
			
	</style>
	
    
</head>
<body>
    
    <div class = "titlebox">
	    <span id="topbox1"> 
	    	<p class="title">Net Control Manager</p>
			<p class="activity"><?php echo "Log: #$q  $row[activity]";?></p>
        </span>
        
        <span id="topbox2">	
        	<p class="period">
	        	Operational Period
	        </p>
	        	
            <p class="fromperiod">
            	<b>Date Range:</b><br> 
            	<?php echo "$indate  $intime" ?> 
            </p>
			
            <p class="toperiod">
            	<?php echo "$outdate $outtime" ?> 
            </p>
        </span>
        
    </div> <!-- end of titlebox -->
    
		<table id="pntTable" class="sortable tablesorter" cellspacing="0" border="2">
		<thead>
        <tr class="thstuff">
            <th title="Role">Role</th>
   <!--         <th title="Mode">Mode</th>  -->
            <th title="Status">Status</th>  <!-- active  -->
    <!--        <th title="Traffic">Traffic</th>        -->

            <th title="TT No." width="5%" oncontextmenu="whatIstt();return false;">tt#</th> 
            <th title="Call Sign">Callsign</th>
            <th title="Name">Name</th>
    <!--        <th title="Name">First Name</th>
            <th title="Last Name">Last Name</th> -->
            <th title="Tactical Call">Tactical</th>   
            <th title="Email">Email</th>
            <th title="Latitude">Latitude</th>
            <th title="Longitude">Longitude</th>
            <th title="Grid">Grid</th>
                                      
            <th title="Time In">In</th>
            <th title="Time Out">Out</th> 
            <th title="Time On Duty" class="toggleTOD">TOD</th>
            
            <th title="Comments">Comments</th>           
            
            <th title="State">State</th>
            <th title="County">County</th> 
            <th title="District">Dist</th>
            <th title="Creds">Creds</th>
        </tr>
		</thead>
		<tbody>
        
        <?php 
	        $ManHours = 0;
	        
	        $sql = ("SELECT  ID, callsign, fname, lname, netcontrol, tactical,
	        				 creds, timeonduty as tmd, mode, active, comments,
	        			     sec_to_time(timeonduty) as tod,
	        			     DATE_FORMAT(logdate, '%H:%i') as timein,
	        			     DATE_FORMAT(timeout, '%H:%i') as timeout,
	        			     CONCAT(fname, ' ', lname) as allname,
	        			     state, county, district, email,
	        			     latitude, longitude, grid

	        		   FROM NetLog 
	        		  WHERE netID = $q 
	        		  ORDER BY logdate");	
				foreach($db_found->query($sql) as $row) {
				  
					$ManHours = $ManHours + $row[tmd];
					echo "<tr>
							<td>$row[netcontrol]</td>
							
							<td style='text-align:center'>$row[active]</td>
							
							
							<td>$row[ID]</td>
							<td>$row[callsign]</td>
							<td nowrap >$row[allname]</td>
							 
							<td>$row[tactical]</td>
							<td nowrap >$row[email]</td>
							<td>$row[latitude]</td>
							<td>$row[longitude]</td>
							<td>$row[grid]</td>
							
							<td>$row[timein]</td>
							<td>$row[timeout]</td>
							<td>$row[tod]</td>
							
							<td>$row[comments]</td>
							
							<td style='text-align:center'>$row[state]</td>
							<td>$row[county]</td>
							<td style='text-align:center'>$row[district]</td>
					
							<td>$row[creds]</td>
						  </tr>";			
			}
			
			echo "</tbody>
				  </table>";
				$init    = $ManHours;
				$hours   = floor($init / 3600);
				$minutes = floor(($init / 60) % 60);
				$seconds = $init % 60;
			
				echo "<table><tr class='lastrow' >
					  <td colspan='18'>Total Volunteer Hours: $hours hours $minutes minutes $seconds seconds</td>
					  </tr></table>";
        ?>

		</tbody>
    </table>
</body>
</html>