<?php

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */

?>

<!DOCTYPE HTML>
<html>
<head>
 <meta charset="utf-8">
 <title>TechJunkGigs</title>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([
 
 ['Net Week','Net Count'],
 <?php 
			foreach($db_found->query("
				SELECT Date, DOW, Week, Year,  Month, monum, netID, Logins, 
					       creds, newb, netCnt, TOD, activity, logdate,
					       COALESCE (Month, 'GT') as MonthNM
					  FROM (SELECT logdate
					              ,activity
					              ,DATE( logdate )                   	AS Date
					              ,DAYOFWEEK( logdate )					AS DOW
					              ,WEEK( logdate,0 )		      		AS Week
					              ,YEAR( logdate )						AS Year
					        	  ,MONTHNAME ( logdate )				AS Month
					              ,MONTH( logdate )  					AS monum
					              ,CONVERT( netID,UNSIGNED INTEGER )	AS netID
					              ,COUNT( callsign )                	AS Logins
					              ,COUNT( IF(creds <> '',1,NULL) ) 		AS creds
					              ,COUNT( IF(comments LIKE '%first log in%',1,NULL) ) AS newb
					              ,count( DISTINCT netID )				AS netCnt
					              ,SUM(  DISTINCT netID)				AS allCnt
					              ,SEC_TO_TIME( SUM(timeonduty) )    	AS TOD
					         FROM NetLog
					        WHERE netID <> 0 
					          AND netcall = 'W0KCN'
					          AND YEAR( logdate ) = 2018
						GROUP BY netID WITH ROLLUP ) AS t 
						ORDER BY 
					     CASE
					     	WHEN MonthNM = 'GT' THEN  1
							ELSE 0
						 END
					        ,t.logdate
					    	,logins
			") as $row) {
							 
				echo "['".$row['Week']."',".$row['netCnt']."],";     
			}      	

			 ?> 
 
 ]);
 
 var options = {
 title: 'Numbers of Net check-ins by Week',
  pieHole: 0.5,
          pieSliceTextStyle: {
            color: 'black',
          },
          legend: 'none'
 };
 var chart = new google.visualization.LineChart(document.getElementById("columnchart12"));
 chart.draw(data,options);
 }
	
    </script>
 
</head>
<body>
 <div class="container-fluid">
 <div id="columnchart12" style="width: 100%; height: 500px;"></div>
 </div>
 
</body>
</html>