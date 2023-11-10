<?php
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $call = $_GET['call']; 
    
    $call = $call[0];
    $id   = $_GET['id']; 
    
   //$call = 'WA0TJT';
    
    $sql = "SELECT a.callsign
    			  ,CONCAT(a.first, ' ', a.middle, ' ', a.last) as name
    			  ,CONCAT(a.city, ', ', a.state) as qth
    			  ,c.status
    			  ,CASE 
     			  		WHEN b.class = 'A' THEN  'Advanced'
     			  		WHEN b.class = 'E' THEN  'Extra'
     			  		WHEN b.class = 'T' THEN  'Technician'
     			  		WHEN b.class = 'N' THEN  'Novice'
     			  		WHEN b.class = 'P' THEN  'Extra'
     			  		WHEN b.class = 'G' THEN  'General'
     			  		ELSE 'Club'
    		       END AS hamclass
    		       
    		  FROM fcc_amateur.en a
    		  	  ,fcc_amateur.am b
    		      ,fcc_amateur.hd c    
    		      
    		 WHERE a.callsign = '$call'
    		   AND a.callsign = b.callsign
    		   AND b.callsign = c.callsign
    	   ";

	$stmt= $db_found->prepare($sql);
	$stmt->execute();
	
	$result = $stmt->fetch();
		$callsign	= $result[0];
		$name		= $result[1];
			$name 	= ucwords(strtolower("$name"));
		$qth		= $result[2];
		$status		= $result[3];
		$hamclass	= $result[4];
		
		
		echo ("<!DOCTYPE html>
				<html>
				<head>
					
					 <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
					 	<style>
						/* For the information on any callsign */
						
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
							font-size: 14pt;
						}
						
						#places tr {
							text-align: left;
							text-weight: bold;
							font-size: 16pt;
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
			  <table id='places' class='equalspace'>
			    <tr><td> $callsign Class: $hamclass</td></tr>
			    <tr><td> $name </td></tr>
			  	<tr><td> $qth </td></tr>

			  </table>

			  
		   ");
			  
			 
					  
		echo("

			  <br><br><a href=\"#lli\" rel=\"modal:close\" class=\"modal-dialog modal-xl\">Close</a><br>
			 
			  </body></html>
			  </div>
		   ");
?>