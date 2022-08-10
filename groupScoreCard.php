<!doctype html>
<?php

			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
		
		    require_once "dbConnectDtls.php";
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Group Score Card</title>
    <meta name="author" content="Kaiser" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    <link rel="stylesheet" type="text/css" media="all" href="css/listNets.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    <script src="js/sortTable.js"></script>
    
    <script>
	
	</script>
	
	<style>
		.red {
			color: red;
		}
	</style>
	
</head>

<body>
	
<!--	<p class="listtitle">Click the Net ID for the ICS-214 report or Map</p>  -->
    <h2>Largest Number of Check-ins by Group</h2>
    <h3>Sorted highest to lowest</h3>
	<p class="instruct">Click any column head to sort</p>
    <table class="sortable">
	    <tr>
    	    <th>Net Call</th>
    	    <th>Net<br>Count</th>
    	    <th class='logins'>Highest</th>
    	    <th class='logins'>Average</th>
    	    <th class='netid'>Net ID</th>
		    <th class='netid'>ICS<br>214&nbsp;&nbsp;&nbsp;309&nbsp;&nbsp;&nbsp;Map</th>
		    <th class='dates'>Date</th>
		    <th>Activity</th>
	    </tr>  
	    <?php
    	    //   DATE(logdate) as netDate,
			$sql1 = ("SELECT o.`netcall`, o.logins, o.`netID`, o.`netDate`, o.`activity`, p.`average`, p.`netcount`, o.`timeonduty`
                        FROM (
                              SELECT `netcall`, COUNT(*) `logins`, `netID`, DATE(`logdate`) as netDate, activity,
                            	 	 SUM(timeonduty) as timeonduty
                              FROM NetLog
                              WHERE netID <> 0 AND status = 1
                                AND netcall <> '0' AND netcall <> ''
                              GROUP BY `netcall`, `netID`
                             ) o 
                        JOIN (     
                              SELECT `netcall`, MAX(`logins`) as `logins`
                                    ,AVG(`logins`) as `average`, COUNT(`netcall`) as netcount
                              FROM (
                                SELECT `netcall`, COUNT(*) `logins`
                                FROM NetLog
                                WHERE netID <> 0 AND status = 1
                                  AND netcall <> '0' AND netcall <> ''
                                GROUP BY `netcall`, `netID`
                              ) q  
                              GROUP BY `netcall`
                             ) p
                          ON o.`netcall` = p.`netcall`
                         AND o.`logins` = p.`logins`  
                        ORDER BY `o`.`logins`  DESC
                        					");
					
		    foreach($db_found->query($sql1) as $row) {
			    
			    $subnet = $row[subNetOfID];
			    $colorit = '';
			    $bgcolor = '';
			    
			  //  if ($row[netcall] == 'EVENT') {
				if ($row[pb] == 1 ) {
				    $colorit = 'red';
			    }
			    
			    if ($subnet == 0) {
				    $subnet = '';
			    }
			    
			   echo"
			   <tr class=\" $colorit \">		
			        <td>$row[netcall]</td>	
			        <td>$row[netcount]</td>
			        <td class='logins'>$row[logins]</td>
			        <td class='logins'>$row[average]</td>
			        <td style=\"text-align:center\">$row[netID]</td>	
		<!--	        <td class='subs'>
			   			<a href=\"https://net-control.us/ics214.php?NetID=$row[subNetOfID]\" target =\"_blank\">$subnet</a>
			   		</td>
        -->
			   		<td class='$colorit netid sorttable_customkey=\"$row[netID]\"'>
			   			<span style='padding-right: 15px'>
			   			<a href=\"https://net-control.us/ics214.php?NetID=$row[netID]\" target =\"_blank\"> 214
			   			</a>&nbsp;&nbsp;&nbsp;
			   			<a href=\"https://net-control.us/ics309.php?NetID=$row[netID]\" target =\"_blank\">309
			   			</a>
			   			</span>
			   			<span>
			   			<a href=\"https://net-control.us/map.php?NetID=$row[netID]\" target =\"_blank\"> MAP
			   			</a>
			   			</span>
			   		</td>
			   		<td class='dates'>$row[netDate]</td>
			   		<td>$row[activity]</td>
			   </tr>
			   ";
		    }
		?>

    </table>
    <p>groupScoreCard.php</p>
     <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
   
    
 <script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


</script> <!-- The scrollFunction to move to the top of the page -->
</body>
</html>