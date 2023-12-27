<?php
// getCallHistory.php
// This program produces a report of the callsign being called, it opens as a modal or windwo
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    require_once "getCrossRoads.php";
  
    $call = strtoupper($_GET['call']); 
    //$call = strtoupper('w0dlk');
    
    //$recordID   = $_GET['id']; 
    $recordID = isset($_GET['id']) ? $_GET['id'] : 0;  
    
// Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

    $sql = "
        SELECT  callsign, grid, creds, email, tactical, district, id, county, state, home, 
                CONCAT(Fname,' ',Lname) as name,
                latitude, longitude
          FROM stations  /* changed from NetLog to stations on 2021-08-09 */
          WHERE callsign = '$call'
         ";
         
         
         
    $stmt = $db_found->prepare($sql);
	$stmt->execute(); 
	$result = $stmt->fetch();
	    $state		= $result[state];
		$county		= $result[county];
		$tactical	= $result[tactical];
		$district   = $result[district];
		$id			= $result[id];
		$name		= $result[name];
		$creds		= $result[creds];
		$email		= $result[email];
		$Ahome      = explode(',',$result[home]);
		$grid       = "$Ahome[2]";
        $koords     = "$Ahome[0],$Ahome[1]";
        $koords2    = "lat=$Ahome[0],&lon=$Ahome[1]";
               
        $crossroads = "";
        $crossroads = getCrossRoads($result[latitude],$result[longitude]);
        
        //echo ("1 name: $name <br>");
        
    //echo("$name, $grid, $crossroads");

	/* Added the class stuff on 2018-1-17 */
	$sql2 = "
        SELECT   c.fccid
                ,c.callsign
                ,c.full_name
                ,c.address1
                ,c.city
                ,c.state
                ,c.zip
                ,b.class
                ,CASE
                WHEN b.class = 'A' then 'Advanced'
                WHEN b.class = 'E' then 'Extra'
                WHEN b.class = 'G' then 'General'
                WHEN b.class = 'N' then 'Novice'
                WHEN b.class = 'P' then 'Extra'
                WHEN b.class = 'T' then 'Technician'           
                    ELSE 'Club'
                END AS  hamclass
          FROM fcc_amateur.en c
              ,fcc_amateur.am b
         WHERE c.callsign = :call
           AND b.callsign = c.callsign
           AND c.fccid = b.fccid
         ORDER BY c.fccid DESC /* new on 2019-04-29 */
         LIMIT 0,1
        ";
        
        //echo $sql2;
        
        $stmt3 = $db_found->prepare($sql2);
        $stmt3->bindParam(':call', $call, PDO::PARAM_STR);
        $stmt3->execute();
        $result = $stmt3->fetch();
        $hamclass = $result['hamclass']; /* result 25 is actually class in above SQL */
        if (!$hamclass) {$hamclass = 'UNK';}
        $address = $result['address1']; //echo "$address";
        $city = $result['city']; //echo "$city";
        $state = $result['state'];
        $zip = $result['zip']; //echo "$zip";
        $fullname = $result['full_name'];
       // if ($name = ' ' ) { $name = trim($fullname); }
        
        
        //echo ("name: $name");

$sql3 = "
SELECT count(a.callsign) as logCount
         
      ,max(a.tt) as tt
      ,max(a.recordID) as recordID
      
      ,MIN(a.logdate) as firstLogDte 
      ,MAX(a.logdate) as lastLogDte
      
      ,MIN(a.netID) as minID 
	  ,MAX(a.netID) as maxID 
      
      ,SUM(a.timeonduty) as TOD
      ,SUM(IF(YEAR(a.logdate) = '2016', 1,0)) as y2016
	  ,SUM(IF(YEAR(a.logdate) = '2017', 1,0)) as y2017
      ,SUM(IF(YEAR(a.logdate) = '2018', 1,0)) as y2018
      ,SUM(IF(YEAR(a.logdate) = '2019', 1,0)) as y2019 
      ,SUM(IF(YEAR(a.logdate) = '2020', 1,0)) as y2020 
      ,SUM(IF(YEAR(a.logdate) = '2021', 1,0)) as y2021
      ,SUM(IF(YEAR(a.logdate) = '2022', 1,0)) as y2022
      ,SUM(IF(YEAR(a.logdate) = '2023', 1,0)) as y2023
      ,SUM(IF(YEAR(a.logdate) = '2024', 1,0)) as y2024
      
      ,SUM(IF(YEAR(a.logdate) = '2016', a.timeonduty,0)) as h2016
	  ,SUM(IF(YEAR(a.logdate) = '2017', a.timeonduty,0)) as h2017
      ,SUM(IF(YEAR(a.logdate) = '2018', a.timeonduty,0)) as h2018
      ,SUM(IF(YEAR(a.logdate) = '2019', a.timeonduty,0)) as h2019 
      ,SUM(IF(YEAR(a.logdate) = '2020', a.timeonduty,0)) as h2020
      ,SUM(IF(YEAR(a.logdate) = '2021', a.timeonduty,0)) as h2021
      ,SUM(IF(YEAR(a.logdate) = '2022', a.timeonduty,0)) as h2022
      ,SUM(IF(YEAR(a.logdate) = '2023', a.timeonduty,0)) as h2023
      ,SUM(IF(YEAR(a.logdate) = '2024', a.timeonduty,0)) as h2024
      
   FROM ncm.NetLog a
  WHERE a.callsign = '$call'
    AND a.netID <> 0
    AND a.logdate <> 0
";

	$stmt2 = $db_found->prepare($sql3);
	$stmt2->execute();   

	$result = $stmt2->fetch();
	
		$logCount	= $result[logCount];	    
		$firstLogD	= $result[firstLogDte];		
		
		$lastLogDte	= $result[lastLogDte];	       
	    $minID		= $result[minID];		
		$maxID		= $result[maxID];
		$activity	= $result[activity];	     
		$district	= $result[district];		
				
		$TOD		    = $result[TOD];		
		$tt			= $result[tt];			     
		$recordID	= $result[recordID];	
		$callsign	= $result[callsign];
		
		$years = array();
        $currentYear = date("Y"); // Get the current year
    
		
		$y2016		= $result[y2016];		     $y2017		= $result[y2017];  	
		$y2018		= $result[y2018];		     $y2019		= $result[y2019];
		$y2020		= $result[y2020];            $y2021		= $result[y2021];
		$y2022		= $result[y2022];            $y2023		= $result[y2023];
		$y2024		= $result[y2024];
		
		/* This is different than above */		
		$h2016		= $result[h2016];		     $h2017		= $result[h2017];  	
		$h2018		= $result[h2018];		     $h2019		= $result[h2019];
		$h2020		= $result[h2020];            $h2021		= $result[h2021];         
        $h2022		= $result[h2022];            $h2023		= $result[h2023]; 
		$h2024		= $result[h2024];
		
		// Start what3word stuff
		// ======================================
		// This part deals with the what3words address
		// https://docs.what3words.com/api/v3/
		
		//$3words   = GET https://api.what3words.com/v3/convert-to-3wa?coordinates=39.202%2C-94.602&key=5WHIM4GD
	
	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.what3words.com/v3/convert-to-3wa?key=5WHIM4GD&coordinates=$koords&language=en&format=json",
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  
    $w3w = json_decode($response, true);
        
        $what3words = $w3w['words'];
        $themap     = $w3w['map'];
      //  $w3wmap     = "<a href = '$themap' target='_blank'>Map</a>";
        $w3wmap     = "<a href = 'https://map.what3words.com/$what3words?maptype=osm' target='_blank'>Map</a>";
        
} // end else
		    
        // End what3word stuff
        // ======================================
        // Start fcc county stuff
        
// use: https://geo.fcc.gov/api/census/area?lat=39.202911&lon=-94.60288&format=json  to get county
 //											
 	$curl = curl_init();
 	
 curl_setopt_array($curl, array(
  CURLOPT_URL => "https://geo.fcc.gov/api/census/area?$koords2&format=json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));
 
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  
  $fccdata = json_decode($response, true); 
} // end if
		
	if ($county <> '' ) {$county = "$county County";}
	if ($district <> '' ) {$district = "District: $district,";}
	if ($creds <> '' ) {$creds = "Creds: $creds";}
		
		$yearHoursArray	 = array($h2016,$h2017,$h2018,$h2019);
		$yearHours 		 = secondsToDHMS(array_sum($yearHoursArray));
		
		$fiAddr		= "<a href = 'https://aprs.fi/#!addr=$koords' target='_blank'>Map</a>";
		$tod  		= secondsToDHMS($TOD);
		$name 		= ucwords(strtolower("$name"));
		
		$h2016		= secondsToDHMS($h2016);
		$h2017		= secondsToDHMS($h2017);
		$h2018		= secondsToDHMS($h2018);
		$h2019		= secondsToDHMS($h2019);
		$h2020		= secondsToDHMS($h2020);
		$h2021		= secondsToDHMS($h2021);
		$h2022		= secondsToDHMS($h2022);
		$h2023		= secondsToDHMS($h2023);
		$h2024		= secondsToDHMS($h2024);
		
		$yearTotalsArray = array($y2016,$y2017,$y2018,$y2019,$y2020,$y2021,$y2022,$y2023,$y2024);
		$yearTotals		 = array_sum($yearTotalsArray);
		
		// Is there a headshot for this person?
		if (file_exists("headshots/$id.JPG")) {
			$headshot = "$id.JPG";
        }else if (file_exists("headshots/$id.png")) {
            $headshot = "$id.png";
		}else {$headshot = 'gen.png';}
		
	echo ("<!DOCTYPE html>
			<html>
			<head>
				
			 <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
			 <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Share+Tech+Mono' >
			 <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Allerta' >
			 <link rel='stylesheet' type='text/css' href='css/getCallHistory.css'>
				
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
	    <br>
		<div class='container'>
			<p class='item1' style='color:red'>
			    $name
			    <br>
			     <a href='mailto:$email?Subject='NCM'target='_top'>$email</a>
			</p>
			<p class='item2'>
			    <img src='headshots/$headshot'>
			</p> 
			<p class='item3' style='color:red'>$callsign
			    Class: $hamclass
			    <br>
			    $creds
			</p>

		</div> <!-- End container -->

		
		<!-- Location Information -->
		<div class='container2'>			   
			
			<!-- <p class='b'>$call</p> -->
			<p class='b'><a href='https://www.qrz.com/db/$call' target='_blank'> $call </a></p>
			
			<span>$address </span>
			
			<span> $city $state $zip </span>
			
			<span> $county </span>
			<span style='color:blue; font-weight:bold;'>$district Grid: $grid</span>
			
			<span> $koords </span>
			
			<span style='color:blue; font-weight:bold;'>Crossroads</span>
			
			<span> $crossroads </span>
						
			<span><br> aprs.fi Map: $fiAddr </span>
			
			<span>what3words: ///$what3words <br>
			    W3W Map: $w3wmap
			</span>

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
		  	<tr><td> 2020 </td> <td> $y2020 </td> <td> $h2020 </td></tr>
		  	<tr><td> 2021 </td> <td> $y2021 </td> <td> $h2021 </td></tr>
		  	<tr><td> 2022 </td> <td> $y2022 </td> <td> $h2022 </td></tr>
		  	<tr><td> 2023 </td> <td> $y2023 </td> <td> $h2023 </td></tr>
		  	<tr><td> 2024 </td> <td> $y2024 </td> <td> $h2024 </td></tr>
		  	
		  	<tr><td> Total </td> <td> $yearTotals </td> <td> $yearHours </td></tr>
		  	
		  </table>
		  <div>
		   		<input type=\"button\" onclick=\"javascript:window.close();\" value=\"Close\" style=\"float:right; padding-left: 20px;\">
		  </div>

		  <h5> <!-- First: $firstLogD,  <span style='float: right';>net#: $minID</span><br> -->
		  	  <span class='equalspace'>First: Net #$minID on $firstLogD </span>
		  	  <span class='equalspace'>Last:  Net #$maxID on $lastLogDte </span>
		  </h5>
		   			  
		  $id 
		  <br><br>
		  getCallHistory.php
		  
		  
		  </body></html>
		  </div>
	   ");
?>