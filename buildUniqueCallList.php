<!doctype html>

<html lang="en">
<head>
    <title>Amateur Radio Net Control Manager Unique Call Signs</title>
    <link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120-precomposed.png" /> 
    <link rel="apple-touch-icon" sizes="152x152" href="apple-touch-icon-152x152-precomposed.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    
    <!-- The meta tag below sends the user to the help file after 90 minutes of inactivity. -->
    <meta http-equiv="refresh" content="5400; URL=https://net-control.us/help.php" >
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="Amateur Radio Net Control Manager" >
    <meta name="author" content="Keith Kaiser, WA0TJT" >
    
    <meta name="Rating" content="General" >
    <meta name="Revisit" content="1 month" >
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager" >
    
    <!-- https://fonts.google.com -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Allerta" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Stoke" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cantora+One" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Risque" >
    
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
       <!-- My style sheets -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >    			<!-- Primary style sheet for NCM -->
    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css" >		<!-- All the @media stuff -->
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >					<!-- 2018-1-17 2018-1-18 -->

<style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid black;
}

th, td {
      text-align: left;
      padding: 6px;
      border: 1px solid black;
}

tr:nth-child(even) {
    background-color: #f2f2f2
}
table>thead {
      background-color: darkgreen;
      color: white;
      font-weight: bold;
}
th {
    white-space: nowrap;
} 
p {
    color: red;
    font-size: larger;
    font-weight: bold;
}
	 
</style>

</head>
<body>
    <h1> Unique Call Signs in the NCM Data Base</h1>
<p>Sort by clicking a column title. Right Click a Call Sign for details.</p>

<?php
// function to geocode address, it will return false if unable to geocode address
require_once "dbConnectDtls.php";

// Function below converts seconds to days, hours, minutes, seconds 
function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}

function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

//echo("tod: secondsToTime(36585739)");


echo "
		<table class='sortable'>
		<thead id='thead' style='text-align: left; font-weight: bold;'>			
		<tr>            
		    <th title='id'>                            ID                                       </th>	
			<th title='Call Sign'  	    class='c6'>	   Callsign 				                </th>
			<th title='First Name'     	class='c7'>    First Name 	</th>
			<th title='Last Name'     	class='c8'>    Last Name  	</th>
			  
			<th title='Phone'     		class='c10'>   Phone     				                </th>
			<th title='email' 	  		class='c11'>   eMail    			   	                </th>	          
			<th title='Credentials'  	class='c15'>   Credentials 		                        </th>
			
			<th title='call_count'      class='c20'>   Net Count       		                    </th>
			<th title='Grid'          	class='c20'>   Grid        		                        </th>
						
			<th title='County'   		class='c17'>   County 					                </th> 
			<th title='State'    		class='c18'>   State	 				                </th>
			<th title='District' 		class='c59'>   Dist	 					                </th>
			<th title='Time On Duty'	class='c16'>   Time On Duty </th>
			
		</tr>
		</thead>
	
		<tbody id='netBody'>
		
"; // END OF header

	$sql = ("
		SELECT  id, COUNT(*) AS call_count, callsign, Fname, Lname, phone, email, 
		        creds, county, state, district, grid,
		        SUM(timeonduty) as tod
          FROM `NetLog` 
         WHERE netID <> 0
           AND id <> 0

           AND Fname NOT LIKE '%(%'
      /*     AND callsign NOT IN ('NONHAM','WX','EMCOMM') */

         GROUP BY `callsign`
         ORDER BY call_count DESC
	");
	
	$station_count = 0;
	
foreach($db_found->query($sql) as $row) {
    
    $station_count = $station_count + 1;
    
    $tod = secondsToDHMS($row[tod]);
    
    $call_count += $row[call_count];
    
    echo "
        <tr>
        <td class='c0'  > $row[id]       </td>
        <td class='c6'  oncontextmenu=\"getCallHistory('$row[callsign]');return false;\" id=\"callsign:$row[recordID]\" > $row[callsign]  </td>   
        <td class='c7' style='white-space:nowrap;' > $row[Fname] 	  </td>
        <td class='c8' style='white-space:nowrap;' > $row[Lname] 	  </td> 
        	
        <td class='c10' > $row[phone] 	  </td>
        <td class='c11' > $row[email] 	  </td>
    	<td class='c15'	> $row[creds] 	  </td>
    	
    	<td class='c20' > $row[call_count]</td>
    	<td class='c20' > $row[grid]      </td>
    	
        <td class='c17' > $row[county]	  </td>
        <td class='c18' > $row[state] 	  </td>
        <td class='c59' > $row[district]  </td>
        <td class='c16' sorttable_customkey=\"$row[time]\"> $tod </td>
        <!-- The customkey give is a value it can sort on -->
        </tr>
    ";   
}
    echo '</tbody></table>';
    
    echo "<br><br>$station_count<br><br>$call_count";
    
    echo "<p>buildUniqueCallList.php</p>";
				
?>
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

<script>
    // When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
};
function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--
  	<script src="js/jQuery-3.3.1.js"></script>
	-->
	<script src="bootstrap/js/bootstrap.min.js"></script>			<!-- v3.3.2 -->
	<script src="js/jquery.freezeheader.js"></script>				<!-- v1.0.7 -->
	<script src="js/jquery.simpleTab.min.js"></script>				<!-- v1.0.0 2018-1-18 -->
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<!--
	<script src="js/jquery.modal.min.js"></script> -->
	<script src="bootstrap/js/bootstrap-select.min.js"></script>				<!-- v1.12.4 2018-1-18 -->
	<script src="bootstrap/js/bootstrap-multiselect.js"></script>				<!-- 2.0 2018-1-18 -->

    <!-- http://www.appelsiini.net/projects/jeditable -->
    <script src="js/jquery.jeditable.js"></script>							<!-- 1.8.1 2018-04-05 -->

	<!-- http://www.kryogenix.org/code/browser/sorttable/ -->
	<script src="js/sortTable.js"></script>										<!-- 2 2018-1-18 -->

	
	<script src="js/w3data.js"></script>										<!-- 1.31 2018-1-18 -->
	
	<!-- My javascript -->
	
	<script src="js/NetManager.js"></script> 	<!-- NCM Primary Javascrip 2018-1-18 -->
	
	<!--<script src="js/NetManager-p2.js"></script>		-->			<!-- Part 2 of NCM Primary Javascript 2018-1-18 -->

	<!-- End My javascript -->
	
	<script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	
	<script>
	    /* these must remain under all the script srource files abnove. */
        // This is the setup for the popup windows
        var strWindowFeatures = "resizable=yes,scrollbars=yes,status=no,left=20px,top=20px,height=800px,width=600px";
    </script>
	
</body>
</html>
