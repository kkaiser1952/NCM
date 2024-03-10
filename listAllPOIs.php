<!doctype html>
<?php

			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
		
		    require_once "dbConnectDtls.php";
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>List of All POIs</title>
    <meta name="author" content="Kaiser" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    <link rel="stylesheet" type="text/css" media="all" href="css/listNets.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    <script src="js/sortTable.js"></script>
    
    <script src="js/NetManager.js"></script> 	
<!--	<script src="js/NetManager.js"></script> -->				<!-- NCM Primary Javascrip 2018-1-18 -->
    
    <script>
	
	</script>
	
	<style>
		.red {
			color: red;
		}
		th {
    		text-align: center;
    		font-weight: bold;
    		font-size: 14pt;
    		text-decoration: underline;
		}
	</style>
	
</head>

<body>
	<h2>List of all POI's in NCM Maps</h2>
	<p class="instruct">Click any column head to sort</p>
    <table class="sortable">
	    <tr>
    	    <th>ID</th>
		    <th>class</th>
		    <th>Type</th>
		    <th>name</th>
		    <th>county</th>
		    <th>address</th>
		    <th>city</th>
		    <th>latitude</th>
		    <th>longitude</th>
		    <th>grid</th>
		    <th>tactical</th>
		    <th>DGID</th>
		    <th>mode</th>
		    <th>Notes</th>
		    <th>Country</th>
		    <th>W3W</th>
		    <th>Radius</th>
	    </tr>
	    <?php
			$sql1 = ("SELECT id, class, Type, name, county, address, city,
			                 latitude, longitude, grid, altitude, tactical,
			                 DGID, mode, Notes, country, w3w, radius
                        FROM poi
                       ORDER BY ID
					;");
					
		    foreach($db_found->query($sql1) as $row) {
			    
			   echo"
			   <tr>			
			        <td>$row[id]</td>
			        <td>$row[class]</td>
			        <td>$row[Type]</td>
			        <td>$row[name]</td>
			        <td>$row[county]</td>
			        <td>$row[address]</td>
			        <td>$row[city]</td>
			        <td>$row[latitude]</td>
			        <td>$row[longitude]</td>
			        <td>$row[grid]</td>
			        <td>$row[tactical]</td>
			        <td>$row[DGID]</td>
			        <td>$row[mode]</td>	
                    <td>$row[Notes]</td>
                    <td>$row[country]</td>
                    <td>$row[w3w]</td>
                    <td>$row[radius]</td> 
			   </tr>
			   ";
		    }
		?>

    </table>
    <p>listAllPOIs.php</p>
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