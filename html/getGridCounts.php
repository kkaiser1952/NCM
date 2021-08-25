<!doctype html>
<html lang="en">
<head>
    <title>NCM Usage by Maidenhead Grid</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" />   
    
    <style>
        html {
            width: 35%;
        }
	   
	</style>
		
</head>
<body>
	<div><h2>The 100</h2>
		 <h3>100 top Grid Locations</h3>
	</div>
	<div id="100grids">
	<table>
		  <thead id="thead" style="text-align: center;">			
            <tr>            	
	            <th>GRID</th>
	            <th>Log-ins</th>               
            </tr>
		  </thead>
		  
		  <tbody id="netGrid">

<?php
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
	
	require_once "dbConnectDtls.php";

	$sql = "SELECT DISTINCT SUBSTRING(grid, 1, 6) AS grid, 
            	   COUNT( SUBSTRING(grid, 1, 6) ) as logins
              FROM NetLog 
             WHERE grid <> ''
             GROUP BY grid  
             ORDER BY `logins` DESC
             LIMIT 0, 100";
			 
	
	$num_rows = 0;   // Counter to color row backgrounds in loop below
		  		     	              
			foreach($db_found->query($sql) as $row) {
				++$num_rows; 				

				echo ("
					  <tr>
					  <td> $row[grid] 			</td>
					  <td> $row[logins] 		</td>
					  </tr>
					 ");
			}

?>
	</tbody>
	</table>
	</div>
</body>
</html>