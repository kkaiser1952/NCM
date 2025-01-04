<!doctype html>
<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
?>

<html lang="en">
<head>
    <title>Net Control Manager Statistics</title>
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
    
    <!-- =============== All above this should not be editied ====================== -->
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 2018-03-04 -->
	
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 2018-1-18 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 2018-1-18 -->
	<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1/jquery-ui.min.css" >	

     <!-- My style sheets -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >    			<!-- Primary style sheet for NCM -->
    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css" >		<!-- All the @media stuff -->
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >					<!-- 2018-1-17 2018-1-18 --> 
</head>
<body>
	
<script>
	
function buildReport() {
	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var dttm = d.getFullYear() + '/' +
	
    (month<10 ? '0' : '') + month + '/' +
    (day<10 ? '0' : '') + day;
    
	var grp 	    = $("#grp").val(); 
	var reportKind  = $("input[name='reportKind']:checked").val(); 
	var reportType  = $("input[name='reportType']:checked").val(); 
	var reportYear  = $("input[name='reportYear']:checked").val();
    var reportMonth = $("input[name='reportMonth']:checked").val();
	
//alert('grp: '+grp+'  reportKind: '+reportKind+'  reportType: '+reportType+'  reportYear: '+reportYear+'  reportMonth: '+reportMonth);
 //      grp: CARROLL  reportKind: Month  reportType: All  reportYear: 2018  reportMonth: 9
	
	$.ajax({
		type: 'GET',
		url: 'NCMreportsBuilder.php',
		data: {grp : grp , reportKind : reportKind , reportType : reportType , reportYear : reportYear , reportMonth : reportMonth }
		})
		.done(function(html) {
			$("#theRpt").html(html); 
			$("#rptRequest").addClass("hidden");
			
			if (reportKind == "callsign") { //alert("in reportKind");
                $('#rptTitle').html(dttm+"<br>"+grp+" Callsign Activity Report for Past "+reportYear+" Months ");  
	        } else if (reportKind == "firstLogIn") {
                $('#rptTitle').html(dttm+"<br>"+grp+" First timers for the Past "+reportYear+" Months ");
	        } else {$('#rptTitle').html(dttm+"<br>"+grp+" Rollup by "+reportYear+" Months ");}
		}); // end success response
}


</script>

<style>

body {
	 margin: 20px;
}
table {
	width: 75%;
}

table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
th {
    text-align: center;
}
.h3size {
	font-size: 18pt; 
	font-weight: bold;
	color: #075400;
}
.smaller {
	font-weight: bold;
	color: #0030fc;
}
#rptTitle {
	width: 90%;
	font-size: 18pt;
	color:#060ef4;
}

.myclass {
	color:red; 
	font-weight:bold; 
    border-top:2px solid black;  
    border-bottom:2px solid black; 
    background-color:#dbf3f5;    
    font-size:12pt; 
}
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}
#pgtitle {
	font-family: 'Cantora One', sans-serif;
	font-size: 48px;
	text-shadow: 4px 4px 4px #aaa;
	padding-right: 5px;
	text-shadow: 2px 2px 2px #aaa;
	position: relative;
	left: 15px; 
	top: 5px;
	font-size: 2.5em; 
	font-weight:900;
	color:#2c742f;
}
#theRpt {
    padding-top: 10px;
}
.greyon {
    background-color: #c2bdbd;
    color: blue;
    font-weight: bold;
}

</style>

</head>
<body>
 		

<span id="pgtitle"> Net Control Manager Reports</span>
<br><br>
<div id="rptTitle"></div>
<div id="theRpt"></div> 

<div id="rptRequest">
	<h3>Select the report options below</h3>
	<br>
	<span class="h3size">Select the group</span>
	<br>
	
        <select id="grp" name="grp" style="width:400px;">    
            <option value="All" disabled selected >Select a net to report about</option>
        <!--    <option value="All"  >All Groups</option> -->
            <option value="notlisted">Group Not Listed</option>
	<?php       	            	   	
    	$row = 0;
    	$sql = "
        	SELECT DISTINCT `call`, org, orgType
			  FROM `NetKind` 
			 WHERE `call` NOT IN ( 'TE0ST', 'EVENT') 
			  ORDER BY orgType, org
        	";
        	foreach($db_found->query($sql) as $act) {

                 $mod = $row % 4;  // row number devided by 4 
                 $row = $row +1;   
                 $call = strtoupper($act[call]);        
                 
            //    if ($mod == '' ) { 
                  if ($thisOrgType <> $act[orgType] ) { 
                    echo "<option value='' disabled>===$act[orgType]===</option>";
                    echo ("<option value='$act[call]'>$act[call] --> $act[org]</option>");
                }else {
                    echo ("<option value='$act[call]'>$act[call]  $act[org]</option>");
                } // end else
                
                $thisOrgType = $act[orgType];
        	} // end foreach
	?>
        </select>
        
        <script>
           // var grp 	    = $("#grp").val();
           // if ("#grp" == 'notlisted') {alert( 'no group')};
        </script>
        
	<div id="reportKind">
		<br>
	<span class="h3size">What Kind of Report</span>
		<br>
	<span class="thelist">
		<input type="radio" name="reportKind" value="Month" checked > Rollup by Month 
		&nbsp;&nbsp;&nbsp;
		<!--
		<input type="radio" name="reportKind" value="Year" > Rollup by Year 
		&nbsp;&nbsp;&nbsp;
		-->
		<!--
		<input type="radio" name="reportKind" value="callsign" > Net Attendance by Callsign 
		&nbsp;&nbsp;&nbsp; -->
		<!--
		<input type="radio" name="reportKind" value="firstLogIn" > First Time Log In's 
		&nbsp;&nbsp;&nbsp;
		-->
	</span>
	</div> <!-- End reportKind -->
	
	<div id="reportType">
		<br>
		<span class="h3size">Activity Types</span>
		<span class="smaller"> (the All Types is for all net types.. voice, digital, &amp; meetings)</span>
		<br>
		<input type="radio" name="reportType" value="All" checked > All Types
		&nbsp;&nbsp;&nbsp;
		
		<input type="radio" name="reportType" value="Vonly"> Voice Only
		&nbsp;&nbsp;&nbsp;
		
		<input type="radio" name="reportType" value="VandD"> Voice &amp; Digital
		&nbsp;&nbsp;&nbsp;
		
		<input type="radio" name="reportType" value="Donly"> Digital Only
		&nbsp;&nbsp;&nbsp;
		
		<input type="radio" name="reportType" value="Monly"> Meetings Only
		&nbsp;&nbsp;&nbsp;
	</div> <!-- End rptFeature -->
	
	<div id="reportHistory">
		<br>

		<span class="h3size">Select a year (i.e. 2017)</span>
		<br>
		<input type="radio" name="reportYear" value="2025" checked > 2025
        &nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2024"  > 2024
        &nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2023"  > 2023
        &nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2022"  > 2022
        &nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2021"  > 2021
        &nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2020" > 2020
        &nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2019" > 2019
        &nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2018"> 2018
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2017"> 2017
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportYear" value="2016"> 2016
		&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="reportYear" value="All"  > All Years
		
		
		<br><br>
		<span class="h3size">Select a month</span>
		<br>
<!--		<input type="radio" name="reportMonth" value="13" checked > All Months -->
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="1" checked > January
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="2"> February
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="3"> March
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="4"> April
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="5"> May
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="6"> June
		&nbsp;&nbsp;&nbsp;<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="7"> July
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="8"> August
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="9"> September
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="10"> October
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="11"> November
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="12"> December
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="reportMonth" value="13"> All
		<br><br>

		<input id='submit' type='submit' value='Submit' onclick="buildReport();"> 
	</div> <!-- End reportYearory -->
	
</div> <!-- End of rptRequest -->
	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
	<script src="js/hamgridsquare.js"></script>									<!-- Paul Brewer KI6CQ 2014 -->
	<script src="js/jquery.countdownTimer.js"></script>							<!-- 1.0.8 2018-1-18 -->
	
	<script src="js/w3data.js"></script>										<!-- 1.31 2018-1-18 -->
	
	<!-- My javascript -->
	
	<script src="js/NetManager.js"></script> 	
<!--	<script src="js/NetManager.js"></script> -->				<!-- NCM Primary Javascrip 2018-1-18 -->
	
	<script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	
	<script src="js/grid.js"></script>
	<script src="js/gridtokoords.js"></script>
	<script src="js/cookieManagement.js"></script>

</body>
</html>
