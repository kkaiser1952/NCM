<!doctype html>
<html lang="en">
<head>
    <title>First 100 Locations</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" />   
    
    <style>
	   
	</style>
		
</head>
<body>
	<div><h2>The 100</h2>
		 <h3>100 tt Locations under Northland ARES</h3>
	</div>
	<div id="100table">
	<table class="sortable " id="thisNet">
		  <thead id="thead" style="text-align: center;">			
            <tr>            	
	            <th>TT</th>
	            <th width="8%">Call Sign</th>
	            <th>Name</th>  
	            <th>eMail</th>
	            
	            <th>Credentials</th>
	            <th>Coords</th>
                <th>Grid</th>
                <th>Locality</th>               
            </tr>
		  </thead>
		  
		  <tbody id="netBody">

<?php
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
	
	require_once "dbConnectDtls.php";

	$sql = "SELECT DISTINCT tt ,
				   callsign,
				   CONCAT(Fname, ' ', Lname) AS name, 
				   email, 
				   creds, 
				   CONCAT(latitude, ', ', longitude) as coords, 
				   grid,
				   CONCAT(county,' Co. ', state, ', ', district) as locality
			  FROM NetLog 
			 WHERE tt < 100
			 GROUP by tt
			 ORDER BY tt";
			 
	//echo "$sql";
	
	$num_rows = 0;   // Counter to color row backgrounds in loop below
		  		     	              
			foreach($db_found->query($sql) as $row) {
				++$num_rows; 				

				echo ("
					  <tr>
					  <td> $row[tt] 			</td>
					  <td> $row[callsign] 		</td>
					  <td> $row[name] 			</td>
					  <td> $row[email] 			</td>
					  <td> $row[creds] 			</td>
					  <td> $row[coords] 		</td>
					  <td> $row[grid] 			</td>
					  <td> $row[locality] 		</td>
					  </tr>
					 ");
			}

?>
	</tbody>
	</table>
	</div>
</body>
</html>