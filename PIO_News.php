<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = intval( $_GET["NetID"] );   
    //$q = 6729;

			
    $sql1 = ("SELECT CONCAT(Fname,' ',Lname) as fullname,
                     callsign
    	       FROM NetLog 
    	       WHERE netID = $q
            ");  
					
    foreach($db_found->query($sql1) as $row) {
	    
	    	$activity = $row[activity];
	    $indate = $row[indate]; $outdate = $row[outdate];	$callsign = $row[callsign];
	    $intime = $row[intime]; $outtime = $row[outtime];	$name = $row[activity];
	    $parent = $row[subNetOfID]; $freq = $row[frequency]; 
    }
    
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PIO News Release</title>
    <meta name="Keith Kaiser" content="Graham" />
    <link rel="stylesheet" type="text/css" media="all" href="css/ics214.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    
    <script>
	    
}
$(document).ready(function()
{
   setInterval('showDTTM()', 1000);
});
	    function getcomm() {
		    $.post('fillics214.php', { unitno: findcomm.unitno.value },
		    	function(output) {
			  		$('#comm').html(output).show();	
		    	});
	    }
	
	
	$.fn.firstword = function() {
		var text = this.text().trim().split(" ");
		var first = text.shift();
		this.html((text.length > 0 ? "<span class='firstword'>" + first + "</span>" : first) + text.join(" "));
	}
	
	$("#firstword").firstword();
	
	</script>
	
	<style>
		.spread {
			float: right;
			padding-right: 5px;
		}
	</style>
	
    
</head>
<body>
    <p style="text-indent: 0pt; text-align: left;">
        <br>
    </p>
    <table class="table1">
        <tr style="height: 29pt">
            <td class="box1" colspan="2">
	                <h3>ICS 214 UNIT LOG</h3>
	                <br>
                    <b>1. Incident Name:</b> 
                    <?php echo "
	                    Log:#$q/$activity";
	                    	if ($children) {
		                    	echo "<li style='color:red;'>Has Sub Nets: $children</li>";
		                    }if ($parent) {
			                    echo "<li style='color:red;'>Sub Net of: $parent</li>";
		                    }
		            /*        if ($subNetOfID) {
			                    echo "<li>Sub Net of: $subNetOfID </li>";
		                    }
	                 */   
                    ?>
                    
            </td>
            <td class="box2">
                <p class="box2s1p1">
                    <b>2. Operational Period:</b><br><br>
                    <b>Date From:</b> <?php echo $indate ?> <b>To:</b> <?php echo $outdate ?>
					<br>
                    <b>Time From:</b> <?php echo $intime ?> <b>To:</b> <?php echo $outtime ?>
                </p>
            </td>
        </tr>
        <tr style="height: 33pt">
            <td class="box3">
                <p class="s1">
                    3. Name:<br><?php echo "$name<br>$freq" ?></p>
            </td>
            <td class="box4">
                <p class="s1">
                    4. ICS Position:<br><?php echo "$box4" ?></p>    <!--<?php echo "$fname $lname, $netcontrol" ?></p> -->
            </td>
            <td class="box5">
                <p class="s1">
                    5. Home Agency <span class="s2">(and Unit)</span>:<br>&nbsp;<?php echo "$box5" ?></p>
            </td>
        </tr>
        <tr style="height: 17pt">
            <td class="box6" colspan="3">
                <p class="s1">
                    6. Resources Assigned:</p>
            </td>
        </tr>
        <tr style="height: 16pt">
            <td class="box6name" >
                <p class="box6s2p1">
                    Callsign, Name &amp; email</p>
            </td>
            <td class="box6position">
                <p class="box6s2p2">
                   Band, ICS Position &amp; Tactical</p>
            </td>
            <td class="box6agency">
	            <span class="box6s2p3a">Time On Duty</span>
                <span class="box6s2p3b">CREDS, Home Agency (and Unit)</span>
            </td>
        </tr>

        
        <?php 
	        $sql = ("SELECT COUNT(*) as recCount
	        		   FROM NetLog 
	        		  WHERE netID = $q"); 
				$stmt = $db_found->prepare($sql);
				$stmt->execute();
				
				$result = $stmt->fetch();
					$recCount	= $result[0];
					
	        $sql = ("SELECT COUNT(*) as actCount
	        		   FROM TimeLog 
	        		  WHERE netID = $q"); 
				$stmt = $db_found->prepare($sql);
				$stmt->execute();
				
				$result = $stmt->fetch();
					$actCount	= $result[0];
					
				$rowCount = $recCount + $actCount + 11 + 2;
				// break page after rowCount of 36 
					
	        $ManHours = 0;
	        
	        $sql = ("SELECT  ID, callsign, fname, lname, netcontrol, 
	                         TRIM(tactical) as tactical, 
	                         TRIM(email) as email,
	        				 TRIM(creds) as creds, 
	        				 TRIM(timeonduty) as tmd, 
	        			     TRIM(sec_to_time(timeonduty)) as tod,
	        			     TRIM(CONCAT_WS('  ', state, county, ' Co., Dist.', district)) as dist,
	        			     TRIM(band) as band
	        			     
	        		   FROM NetLog 
	        		  WHERE netID = $q 
	        		     
	        		    AND (timeout <> 0 AND logdate <> 0
	        		     OR RIGHT(callsign, 2) = '-U')
	        		  ORDER BY logdate");	
				foreach($db_found->query($sql) as $row) {
					$nc = "Operator";
					switch($row[netcontrol]) {
						case "PRM": $nc = "Primary Net Control";
						break;
						case "2nd": $nc = "Secondary Net Control";
						break;
						case "3rd": $nc = "Tertiary Net Control";
						break;
						case "PIO": $nc = "Public Information Officer";
						break;
						case "Log": $nc = "Net Logger";
						break;
						case "LSN": $nc = "Liaison to ...";
						break;
						case "EM": $nc = "Emergency Manager";
						break;
						case "   ": $nc = "Operator";
						break;
					}
					
					// fix creds if they exist by adding a comma after its name.
					$creds = "$row[creds]";
						if ("$row[creds]" <> '') {$creds = "$row[creds],";} // only add the comma for non-blank credentials
						else {$creds = '';}
				  
					$ManHours = $ManHours + $row[tmd];
					
					echo "<tr style=\"height: 17pt; page-break-inside: avoid;\">
							   <td class=\"box6td\">$row[callsign] <span class=\"spread\">$row[fname] $row[lname]</span><span><br>$row[email]</span></td>
							   <td class=\"box6td\">$row[band] $nc <span class=\"spread\">$row[tactical]</span></td>
							   <td class=\"box6td\">
							   		<span class=\"tod\">$row[tod]</span> 
							   		<span class=\"creds\">$creds $row[dist]</span>
							   </td>
							   </tr>";			
			}
			
					$hours = floor($ManHours / 3600);
					$mins = floor($ManHours / 60 % 60);
					$secs = floor($ManHours % 60);
					$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
					
					echo "<tr style=\"height: 17pt\">
						  <td>$recCount Stations</td>
						  <td><b>Total Volunteer Hours</b></td>
						  <td>$timeFormat</td>
						  </tr>";
        ?>

        
        <tr style="height: 17pt">
            <td class="box7" colspan="3">
                <p class="box7s1p0">
                    7. Activity Log: 
                    </p>
            </td>
        </tr>
        <tr style="height: 17pt">
            <td class="box7date">
                <p class="box7s2p1">
                    Date/Time</p>
            </td>
            <td class="box7notable" colspan="2">
                <p class="box7s2p2">
                    Notable Activities</p>
            </td>
        </tr>
        
        <?php
	        
	        $sql = ("SELECT TIMESTAMP, ID, callsign, comment 
	        		   FROM TimeLog 
	        		  WHERE netID = $q 
	        		  ORDER BY timestamp");
	
				foreach($db_found->query($sql) as $row) {
				  
					echo "<tr style=\"height: 17pt\">
							   <td class=\"box7td1\" >$row[TIMESTAMP]</td>
							   <td class=\"box7td2\"  colspan=\"2\">$row[callsign]: $row[comment]</td>
							   </tr>";			
			}
        ?>

        <tr style="height: 20pt">
            <td class="box8" colspan="3">
                <p class="box8s2p1">
	                
                    <b>8. Prepared by: </b><?php echo "$fname $lname" ?> , Net Control Operator <u></u>
                    
                </p>
            </td>
        </tr>
        <tr style="height: 17pt">
            <td class="box8page" colspan="2">
                <p class="s1" style="padding-top: 1pt; padding-left: 4pt; text-indent: 0pt; text-align: left;">
                    ICS 214, Page 1</p>
            </td>
            <td class="box8date">
                <p class="box8s2p3">
                    Date/Time: <span id="dttm2"></span> 
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
