<!doctype html>

<?php
    // Modified on 11/18/23 to fix the prepared by field in the report. The First name was correct the last name was not. 

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = intval( $_GET["NetID"] );  //$q = 10016;
    //$q = 10418;
    
        // Variable initialization
        $children = '';
        $activity = '';
        $indate = '';
    
    // The below SQL is used to report the parent and child nets
    $sql = "SELECT subNetOfID, 
			       GROUP_CONCAT(DISTINCT netID SEPARATOR ', ')
			  FROM NetLog
			 WHERE subNetOfID = :netId
			 ORDER BY netID";
			 
	$stmt = $db_found->prepare($sql);
	$stmt->bindParam(':netId', $q, PDO::PARAM_INT);
    $stmt->execute();
	
			$children = $stmt->fetchColumn(1); 
			
    $sql1 = ("SELECT min(logdate) AS minlog, 
    				 DATE(min(logdate)) AS indate, 
    				 TIME(min(logdate)) AS intime, 
    				 DATE(max(timeout)) AS outdate, 
    				 TIME(max(timeout)) AS outtime, 
    				 activity, netcall, subNetOfID,
    				 frequency
    	       FROM NetLog 
    	       WHERE netID = :netId;
    	         AND logdate <> 0 
            ");  
					
    $stmt = $db_found->prepare($sql1);
    $stmt->bindParam(':netId', $q, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the results as an associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Now, you can access the values using the keys in the $row array
    $activity = $row['activity'];
    $indate = $row['indate'];
    $outdate = $row['outdate'];
    $callsign = $row['callsign'];
    $intime = $row['intime'];
    $outtime = $row['outtime'];
    $name = $row['activity'];
    $parent = $row['subNetOfID'];
    $freq = $row['frequency']; 
    
    
    
    $sql2 = "SELECT CONCAT(Fname, ' ', Lname) as LogPrep
         FROM NetLog
         WHERE netID = :netId
           AND (netcontrol = 'PRM' OR netcontrol = 'LOG')
         ORDER BY CASE WHEN netcontrol = 'PRM' THEN 1 ELSE 2 END
         LIMIT 1";

$stmt = $db_found->prepare($sql2);
$stmt->bindParam(':netId', $q, PDO::PARAM_INT);
$stmt->execute();

// Fetch the results as a single column value
$LogPrep = $stmt->fetchColumn(0);

//echo ($LogPrep);

			
    $sql3 = "SELECT box4, box5, kindofnet
               FROM NetKind
              WHERE `call` = '$row[netcall]'
            ";
   // echo "$sql3";
        $stmt = $db_found->prepare($sql3);
        $stmt->bindParam(':netId', $q, PDO::PARAM_INT);
        $stmt->execute();
    
        // Fetch the results as an associative array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		//	$children = $stmt->fetchColumn(1); 
			$box4  = $stmt->fetchColumn(0); 
        //$stmt3 -> execute();
			$box5   = $stmt->fetchColumn(1); 
        //$stmt3 -> execute();
			$kindofnet   = $stmt->fetchColumn(2); 
			
        if ($box5 == '') {$box5 = 'Volunteer Amateur Radio Operators (Hams)';}
            
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ICS 214</title>
    <meta name="Keith Kaiser" content="Graham" />
    <link rel="stylesheet" type="text/css" media="all" href="css/ics214.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    
    <script>
	    function showDTTM(){
	if (!document.all&&!document.getElementById)
		return
		thelement=document.getElementById? document.getElementById("dttm2"): document.all.dttm2
	var mydate=new Date()
	var year=mydate.getYear()
		if (year < 1000) year+=1900
	var day=mydate.getDay()
	var month=mydate.getMonth()
	var daym=mydate.getDate()
		if (daym<10) daym="0"+daym
	var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
	var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
	var hours=mydate.getHours()
	var minutes=mydate.getMinutes()
	var seconds=mydate.getSeconds()
	var dn="PM"
		if (hours<12) 	dn="AM"
		if (hours>12) 	hours=hours-12
		if (hours==0) 	hours=12
		if (minutes<=9) minutes="0"+minutes
		if (seconds<=9) seconds="0"+seconds
	var ctime=hours+":"+minutes+":"+seconds+" "+dn
		thelement.innerHTML=dayarray[day]+", "+montharray[month]+" "+daym+", "+year+" "+ctime
		//var currentTimeString = dayarray[day]+","+montharray[month]+" "+daym+", "+year+" "+ctime;
		//setTimeout("showDTTM()",1000)
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
                    5. Home Agency <span class="s2">(Unit and Team)</span>:<br>&nbsp;<?php echo "$box5" ?></p>
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
                <span class="box6s2p3b">CREDS, Home Agency (Unit and Team)</span>
            </td>
        </tr>

        
        <?php 
	        $sql4 = "SELECT COUNT(*) as recCount
                     FROM NetLog 
                     WHERE netID = :netId"; 
            
            $stmt = $db_found->prepare($sql4);
            $stmt->bindParam(':netId', $q, PDO::PARAM_INT);
            $stmt->execute();
            
            // Fetch the result as an associative array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $recCount = $row['recCount']; // Access the 'recCount' column from the associative array
            
            $sql5 = "SELECT COUNT(*) as actCount
                     FROM TimeLog 
                     WHERE netID = :netId"; 
            
            $stmt = $db_found->prepare($sql5);
            $stmt->bindParam(':netId', $q, PDO::PARAM_INT);
            $stmt->execute();
            
            // Fetch the result as an associative array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $actCount = $row['actCount'];
  
                /* */
					
				$rowCount = $recCount + $actCount + 11 + 2;
				// break page after rowCount of 36 
					
	        $ManHours = 0;
	        
	        $sql6 = "SELECT  ID, callsign, fname, lname, netcontrol, 
                         TRIM(tactical) as tactical, 
                         TRIM(email) as email,
                         TRIM(creds) as creds, 
                         TRIM(timeonduty) as tmd, 
                         TRIM(sec_to_time(timeonduty)) as tod,
                         TRIM(CONCAT_WS('  ',city, state, county, ' Co., Dist.', district)) as dist,
                         TRIM(band) as band,
                         TRIM(team) as team
                       
                   FROM NetLog 
                  WHERE netID = :netId 
                     
                    AND (timeout <> 0 AND logdate <> 0
                     OR RIGHT(callsign, 2) = '-U')
                  ORDER BY logdate";	

$stmt = $db_found->prepare($sql6);
$stmt->bindParam(':netId', $q, PDO::PARAM_INT);
$stmt->execute();

$ManHours = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nc = "Operator";
    switch ($row['netcontrol']) {
        case "PRM":
            $nc = "Primary Net Control";
            break;
        case "2nd":
            $nc = "Secondary Net Control";
            break;
        case "3rd":
            $nc = "Tertiary Net Control";
            break;
        case "RELAY":
            $nc = "Relay Station";
            break;
        case "PIO":
            $nc = "Public Information Officer";
            break;
        case "Log":
            $nc = "Net Logger";
            break;
        case "LSN":
            $nc = "Liaison to ...";
            break;
        case "EM":
            $nc = "Emergency Manager";
            break;
        case "   ":
            $nc = "Operator";
            break;
    }

    // Fix creds if they exist by adding a comma after its name.
    $creds = trim($row['creds']);
    if (!empty($creds)) {
        $creds .= ',';
    }

    $ManHours += $row['tmd'];

    echo "<tr style=\"height: 17pt; page-break-inside: avoid;\">
               <td class=\"box6td\">{$row['callsign']} <span class=\"spread\">{$row['fname']} {$row['lname']}</span><span><br>{$row['email']}</span></td>
               <td class=\"box6td\">{$row['band']} $nc <span class=\"spread\">{$row['tactical']}</span></td>
               <td class=\"box6td\">
                    <span class=\"tod\">{$row['tod']}</span> 
                    <span class=\"creds\">$creds {$row['dist']}</span>
                    <span class=\"team\" style=\"float:right; padding-right:3pt;\">{$row['team']}</span>
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
	        
	        $sql7 = "SELECT TIMESTAMP, ID, callsign, comment 
                     FROM TimeLog 
                     WHERE netID = :netId 
                     ORDER BY timestamp";
            
            $stmt = $db_found->prepare($sql7);
            $stmt->bindParam(':netId', $q, PDO::PARAM_INT);
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr style=\"height: 17pt\">
                          <td class=\"box7td1\">{$row['TIMESTAMP']}</td>
                          <td class=\"box7td2\" colspan=\"2\">{$row['callsign']}: {$row['comment']}</td>
                      </tr>";
            }

        ?>

        <tr style="height: 20pt">
            <td class="box8" colspan="3">
                <p class="box8s2p1">
	                
                    <b>8. Prepared by: </b><?php echo "$LogPrep" ?> , Net Control Operator <u></u>
                    
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
    <footer>
        <p style="padding:3px; color:a9a9a9; font-size:9pt;">net-control.us/ICS-214.php</p>
    </footer>
</body>
</html>
