<?php
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $call = $_GET['call']; 
//echo "$call[0] and $call<br>";
    $call = $call[0];
    $id   = $_GET['id']; 
//echo "$id";
    
  //$call = 'wa0tjt';
    
// Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

	/* Added the class stuff on 2018-1-17 */
	$sql2 = "SELECT c.fccid
	  ,c.callsign
	  ,c.address1
      ,c.city
      ,c.state
      ,c.zip
      ,b.class
      	,CASE 
         	WHEN b.class = 'A' then  'Advanced'
         	WHEN b.class = 'E' then  'Extra'
         	WHEN b.class = 'T' then  'Technician'
         	WHEN b.class = 'N' then  'Novice'
         	WHEN b.class = 'P' then  'Extra'
         	WHEN b.class = 'G' then  'General'
         		ELSE 'Club'
         END AS hamclass
         
      ,count(a.callsign) as logCount
      ,a.grid
      ,a.creds
      ,a.email
      ,a.tactical
      ,a.activity
      ,a.district
      ,a.id
      ,a.county
      
      ,max(a.tt) as tt
      ,max(a.recordID) as recordID
      
      ,MIN(a.logdate) as firstLogDte 
      ,MAX(a.logdate) as lastLogDte
      
      ,MIN(a.netID) as minID 
	  ,MAX(a.netID) as maxID 
      
      ,CONCAT(SUBSTRING_INDEX(a.Fname, ':', 1),' ',a.Lname) as name
      ,CONCAT(a.latitude,', ',a.longitude) as koords 
      
      ,SUM(a.timeonduty) as TOD
      ,SUM(IF(YEAR(a.logdate) = '2016', 1,0)) as y2016
	  ,SUM(IF(YEAR(a.logdate) = '2017', 1,0)) as y2017
      ,SUM(IF(YEAR(a.logdate) = '2018', 1,0)) as y2018
      ,SUM(IF(YEAR(a.logdate) = '2019', 1,0)) as y2019 
      
      ,SUM(IF(YEAR(a.logdate) = '2016', a.timeonduty,0)) as h2016
	  ,SUM(IF(YEAR(a.logdate) = '2017', a.timeonduty,0)) as h2017
      ,SUM(IF(YEAR(a.logdate) = '2018', a.timeonduty,0)) as h2018
      ,SUM(IF(YEAR(a.logdate) = '2019', a.timeonduty,0)) as h2019 
      
  FROM ncm.NetLog a
	  ,fcc_amateur.en c
      ,fcc_amateur.am b
  WHERE a.callsign = '$call'
    AND a.netID <> 0
    AND a.logdate <> 0
    AND a.callsign = c.callsign
    AND b.callsign = c.callsign
    AND c.fccid = ( SELECT MAX(d.fccid) 
                      FROM fcc_amateur.en d
                     WHERE d.callsign = '$call' )
  ORDER BY c.fccid DESC
  /*LIMIT 1 */
";

//echo $call,\n$sql2;
		
	$stmt2 = $db_found->prepare($sql2);
	$stmt2->execute();
	
	$result = $stmt2->fetch();
		$logCount	= $result[logCount];	$firstLogD	= $result[firstLogDte];		
		$lastLogDte	= $result[lastLogDte];	$id			= $result[id];
		$name		= $result[name];		$grid		= $result[grid];		
		$creds		= $result[creds];
		$email		= $result[email];		$koords		= $result[koords];	
		$tactical	= $result[tactical];
		$callsign	= $result[callsign];	$minID		= $result[minID];		
		$maxID		= $result[maxID];
		$activity	= $result[activity];	$district	= $result[district];		
		$state		= $result[state];
		$county		= $result[county];		$TOD		= $result[TOD];		
		$tt			= $result[tt];			$recordID	= $result[recordID];	
		$y2016		= $result[y2016];		$y2017		= $result[y2017];  	
		$y2018		= $result[y2018];		$y2019		= $result[y2019];
		
		$h2016		= $result[h2016];		$h2017		= $result[h2017];  	
		$h2018		= $result[h2018];		$h2019		= $result[h2019];
		
		$hamclass   = $result[hamclass]; /* result 25 is actually class in above SQL */
		
		$address	= $result[address1];  //echo "$address";
		$city		= $result[city];  //echo "$city";
		$zip		= $result[zip];  //echo "$zip";
		
		if ($county <> '' ) {$county = "$county County";}
		if ($district <> '' ) {$district = "District: $district,";}
		if ($creds <> '' ) {$creds = "Credentials: $creds";}
		
		// Is there a headshot for this person?
		if (file_exists("headshots/$id.JPG")) {
			$headshot = "$id.JPG";
		}else {$headshot = 'gen.png';}
		/*
		if ($id == '0013' ) {$headshot = '0013.JPG';}
		else if ($id == '0797' ) {$headshot = '$id.JPG';}
    	else {$headshot = 'gen.png';}
		*/
		$yearHoursArray	 = array($h2016,$h2017,$h2018,$h2019);
		$yearHours 		 = secondsToDHMS(array_sum($yearHoursArray));
		
		$fiAddr		= "<a href = 'https://aprs.fi/#!addr=$koords' target='_blank'>Map</a>";
		$tod  		= secondsToDHMS($TOD);
		$name 		= ucwords(strtolower("$name"));
		$h2016		= secondsToDHMS($h2016);
		$h2017		= secondsToDHMS($h2017);
		$h2018		= secondsToDHMS($h2018);
		$h2019		= secondsToDHMS($h2019);
		
		$yearTotalsArray = array($y2016,$y2017,$y2018,$y2019);
		$yearTotals		 = array_sum($yearTotalsArray);
		
		
		echo ("<!DOCTYPE html>
				<html>
				<head>
					
					 <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
					 
					 <style>
						/* For the right click on a callsing report (a history of that callsign) */
						
						body {
							font-family: 'Allerta', sans-serif;
						}

						#reportTOD {
						    border-collapse: collapse;
						    width: 100%;
						}
						#reportTOD td, #reportTOD th {
							border: 1px solid #ddd;
							font-wight: bold;
						}
						
						#reportTOD tr:nth-child(even){background-color: #f2f2f2;}
						
						#reportTOD tr:hover {background-color: #ddd;}
						
						#reportTOD th {
						    padding-top: 12px;
						    padding-bottom: 12px;
						    text-align: center;
						    background-color: #4CAF50;
						    color: white;
						}
						
						#reportTOD tr {
							text-align: center;
							font-wight: bold;
							font-size: 10pt;
						}
						
						#places tr {
							text-align: left;
							text-weight: bold;
							font-size: 12pt;
						}
						#places tr td:nth-child(2) {
							padding-left: 10pt;
						}
						
						.printme {
							float: right;
							border-radius: 9px;
							border: 2px solid purple;
							background-color: lightpurple;
						}
						
					    @media print{
						    #lb1{
							    display:block;
							}
						}
						
						.equalspace{
						    display:flex;
						    justify-content: space-between;
						}
						
						img {
							border: 1px solid #ddd;
						    border-radius: 4px;
						    padding: 5px;
						    object-fit: contain;
						    max-width: 100px;
						}
						
						.container {
							display: flex;
							flex-flow: row wrap;
							
							align-items: center;
							justify-content: space-around;
						}
						.item1 {
							flex-grow: 1;
							margin: auto;
							flex: 1 0 33%;
						}
						.item2 {
							flex-grow: 1;
							margin: auto;
							flex: 1 0 33%;
						}
						.item3 {
							flex-grow: 1;
							flex: 1 0 33%;
						}

							
						.container2 {
							display: flex;
							flex-flow: column;
							
							align-items: center;
							justify-content: space-around;
						}
					 </style>
						
				</head>
				<script>
					function printme() {
						window.print();
					}
				</script>
				<body>
				<div id = 'lb1'>
			");
	
		echo("
		
			<div class='container'>
				<span class='item1' style='color:red'>$name<br>tt#:$tt</span>
				<span class='item2'><img src='headshots/$headshot' /></span>
				<span class='item3' style='color:red'>$callsign<br>Class: $hamclass</span>
				<span class='item4'><a href='mailto:$email?Subject='NCM'target='_top'>$email</a></span>
				<span class='item5'>$creds</span>
			</div> <!-- End container -->

			
			<div class='container2'>			   
				<span>&nbsp;</span>
				<span>$address </span>
				
				<span> $city $state $zip </span>
				
				<span> $county </span>
				<span style='color:blue; font-weight:bold;'>$district Grid: $grid</span>
				
				<span> $koords </span>
				
				<span> $fiAddr </span>

			</div> <!-- End container -->

		   ");
			  
			 
		echo("<h3 style='text-align: center; color: green;'>Log-in Activity</h3>
			  <table id='reportTOD'>
			 		
			  	<tr>            	
					<th>Year</th>
					<th>Log Counts</th>
					<th>D:H:M:S on Duty</th>
				</tr>
			
			  	<tr><td> 2016 </td> <td> $y2016 </td> <td> $h2016 </td></tr>
			  	<tr><td> 2017 </td> <td> $y2017 </td> <td> $h2017 </td></tr>
			  	<tr><td> 2018 </td> <td> $y2018 </td> <td> $h2018 </td></tr>
			  	<tr><td> 2019 </td> <td> $y2019 </td> <td> $h2019 </td></tr>
			  	
			  	<tr><td> Total </td> <td> $yearTotals </td> <td> $yearHours </td></tr>
			  	
			  </table>
			  <div>
			   		<input type=\"button\" onclick=\"javascript:window.close();\" value=\"Close\" style=\"float:right; padding-left: 20px;\">
			  </div>

			  <h5> <!-- First: $firstLogD,  <span style='float: right';>net#: $minID</span><br> -->
			  	  <span class='equalspace'>FirstL: Net #$minID on $firstLogD </span>
			  	  <span class='equalspace'>Last: Net#$maxID on $lastLogDte </span>
			  </h5>
			   			  
			  $id 
			  
			  </body></html>
			  </div>
		   ");
?>