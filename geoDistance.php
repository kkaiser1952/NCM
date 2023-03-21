<!doctype html>
<?php
    // The SQL for this program was written by chat(AI) (ChatGPT) on 2023-03-20 

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
	</style>
	
</head>

<body>
	<h3 class="instruct">Click any column head to sort</h3>
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
			$sql = ("/* SET @netID = 8626; */
                SELECT
                    t1.callsign AS callsign1,
                    t2.callsign AS callsign2,
                    ROUND(
                        3959 * acos(
                            cos(radians(t1.latitude)) * cos(radians(t2.latitude)) * cos(radians(t2.longitude) - radians(t1.longitude)) + sin(radians(t1.latitude)) * sin(radians(t2.latitude))
                        ),
                        1
                    ) AS miles,
                    ROUND(
                        degrees(
                            atan2(
                                sin(radians(t2.longitude) - radians(t1.longitude)) * cos(radians(t2.latitude)),
                                cos(radians(t1.latitude)) * sin(radians(t2.latitude)) - sin(radians(t1.latitude)) * cos(radians(t2.latitude)) * cos(radians(t2.longitude) - radians(t1.longitude))
                            )
                        ),
                        1
                    ) AS bearing,
                    ROUND(
                        degrees(
                            atan2(
                                sin(radians(t1.longitude) - radians(t2.longitude)) * cos(radians(t1.latitude)),
                                cos(radians(t2.latitude)) * sin(radians(t1.latitude)) - sin(radians(t2.latitude)) * cos(radians(t1.latitude)) * cos(radians(t1.longitude) - radians(t2.longitude))
                            )
                        ),
                        1
                    ) AS reverse
                FROM
                    NetLog t1
                    JOIN NetLog t2
                    ON t1.callsign < t2.callsign
                WHERE t1.netID = $q AND t2.netID = $q
                ORDER BY t1.callsign, t2.callsign
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
    
    
    <p>geoDistance.php</p>
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