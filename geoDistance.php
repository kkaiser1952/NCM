<!doctype html>
<?php
    // Written: 2023-03-20 

			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
		
		    require_once "dbConnectDtls.php";
		    
		    $q = intval($_GET["NetID"]);
		    //$q = 8626;
		    
    echo "<h2>Distance & Bearings for All Stations on Net $q </h2>";
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Geo-Distance and Location</title>
    <meta name="author" content="Kaiser" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
  <!--  <link rel="stylesheet" type="text/css" media="all" href="css/listNets.css"> -->
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    <script src="js/sortTable.js"></script>
	
	<style>
		.red {
			color: red;
		}
		html {
        	width: 80%;
    	}
		td {
          text-align: center;
          font-size: large;
        }
        tr:hover {background-color: coral; font-weight: bold; font-size: xx-large;}
        th {
          background-color: #04AA6D;
          color: white;
          font-size: 14pt;
        }
        .prime {
    		columns: 20px 2; 
    		column-gap: 10px; 
		}
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #04AA6D;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
        }
        #myBtn:hover {
            background-color: #555;
        }
        #refreshBtn {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 16px;
        }
        #refreshBtn:hover {
            background-color: #45a049;
        }
	</style>
	
</head>

<body>
	<h3 class="instruct">Click any column head to sort</h3>
	<div class="prime">
    <table class="sortable" style="width: 35%">
                    
	    <tr>
    	    <th class="<?php $liteItUp ?>" style="text-align: center;">Station 1</th>
    	    <th>Station 2</th>
    	    <th>Miles</th>
    	    <th>Bearing</th>
    	    <th>Reverse</th>
	    </tr>  
	    <?php
    	    //   DATE(logdate) as netDate,
    	    $sql = ("
    	        SELECT 
                  n1.callsign AS callsign1,
                  n2.callsign AS callsign2,
                  ROUND(69.09 * DEGREES(ACOS(COS(RADIANS(n1.latitude)) * COS(RADIANS(n2.latitude)) * COS(RADIANS(n2.longitude) - RADIANS(n1.longitude)) + SIN(RADIANS(n1.latitude)) * SIN(RADIANS(n2.latitude)))), 1) AS miles,
                  
                  ROUND(DEGREES(ATAN2(SIN(RADIANS(n2.longitude - n1.longitude)) * COS(RADIANS(n2.latitude)), COS(RADIANS(n1.latitude)) * SIN(RADIANS(n2.latitude)) - SIN(RADIANS(n1.latitude)) * COS(RADIANS(n2.latitude)) * COS(RADIANS(n2.longitude - n1.longitude)))) + 360) % 360 AS bearing,
                  
                  ROUND(DEGREES(ATAN2(SIN(RADIANS(n1.longitude - n2.longitude)) * COS(RADIANS(n1.latitude)), COS(RADIANS(n2.latitude)) * SIN(RADIANS(n1.latitude)) - SIN(RADIANS(n2.latitude)) * COS(RADIANS(n1.latitude)) * COS(RADIANS(n1.longitude - n2.longitude)))) + 360) % 360 AS reverse
                FROM 
                  NetLog n1 
                  JOIN NetLog n2 
                  ON n1.netID = n2.netID AND n1.callsign < n2.callsign
                WHERE 
                  n1.netID = $q
                ORDER BY 
                  n1.callsign, n2.callsign
            ");
		
			$rowno = 0;
            $firstrow = 0;
            $liteItUp = '';
            $lastCall = null;
					
		    foreach($db_found->query($sql) as $row) {
    		    
    		    if($lastCall != $row[callsign1]) {
                    $liteItUp = "style=\"background-color:lightblue\"";
                    $lastCall = $row[callsign1];
                } else $liteItUp = "";

                $rowno = $rowno + 1;
                
    			   echo"
    			   <tr $liteItUp>		
    			        <td>$row[callsign1]</td>	
    			        <td>$row[callsign2]</td>
    			        <td>$row[miles]</td>
    			        <td>$row[bearing]</td>
    			        <td>$row[reverse]</td>
    			   </tr>
		    ";
		    } // End foreach
		?>

    </table>
	</div>
    
    <p>geoDistance.php</p>
    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    <button onclick="refreshPage()" id="refreshBtn" title="Refresh data">Refresh</button>
   
    
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

// Function to refresh the page
function refreshPage() {
    location.reload();
}

// Add keyboard shortcut for refresh (F5 or Ctrl+R)
document.addEventListener('keydown', function(event) {
    if (event.key === 'F5' || (event.ctrlKey && event.key === 'r')) {
        event.preventDefault();
        refreshPage();
    }
});

// Auto-refresh every 5 minutes (300000 milliseconds)
// Uncomment the line below if you want automatic refresh
// setTimeout(refreshPage, 300000);
</script>
</body>
</html>