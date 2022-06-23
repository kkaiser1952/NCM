<!doctype html>
<html lang="en">
<head>
    <title>Announcements</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" />   
    <link rel="stylesheet" type="text/css" href="css/events.css" /> 
    
    <script>
	    function closeWin() {
			close();   // Closes the new window
		}
	</script>
		
</head>
<body>

<!-- Modified: 2018-01-30 -->
<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $activity = $_GET["activity"]; //echo "incoming activity = $activity";
    
    $domain = $_GET["domain"]; 									//echo("<br>1 domain= $domain");
    $domain = preg_replace('/\W\w+\s*(\W*)$/', '$1', $domain);  //echo("<br>2 domain= $domain<br>");
    $domain = preg_replace('!\s+!', ' ', $domain);  // replace multiple spaces with a single space
    $domain = trim($domain," ");
    
    $domain = explode(" ",$domain)[0];
    //echo "domain= $domain";

    if ($domain == 'All') { 
	    	$thewhere = "WHERE NOW() <= end 
	    	    AND deletedON IS NULL
	    	    AND docType LIKE '%agenda%' 
	    	    
	    	    "; 
	  /*  	$domain = "<p style='font-size:18pt; color:red';>Examples</p>"; */
	    	}
    	
    	else {$thewhere = "WHERE docType LIKE '%agenda%'
        	    AND NOW() <= end
			    AND deletedON IS NULL
			    AND domain LIKE '%$domain%'
			     
    		    AND (subdomain like '%$activity%' OR subdomain = '')
			 	AND title NOT IN('Closing','Preamble')
			 	";}

	$sql = ("SELECT description, contact, callsign, id, title, location, 
	                eventDate, dttm,
					DATE(start) as stdt, 
					DATE(end) as endt,
					TIME_FORMAT(start, '%H:%i') as sttm,
                    TIME_FORMAT(end, '%H:%i') as entm,
                    DATE(dttm) as ondt
			   FROM events 
			   $thewhere
			  ORDER BY start, dttm DESC, id DESC
			  LIMIT 0,5");	      
			  
        //echo "@70 buildEventListing.php sql= $sql";
			  
			  //echo("$sql");
		      
	$num_rows = 0;   // Counter to color row backgrounds in loop below
		  		     	          		     	              
		foreach($db_found->query($sql) as $row) {
			++$num_rows; // Increment row counter for coloring background of rows
			echo("<div>$domain Net</div>");
			
			
			
			//echo("<br>");
			echo("<div id=\"subj\"><h2>Subject:</br> $row[title]</h2></div>");
			echo("<div><h3>Location:<br><b> $row[location]</b></h3></div>");
			echo("<div><h3>Event Date: $row[eventDate]</h3></div>");
			//echo("<div><h3>Date(s): <b> $row[stdt] to $row[endt]</b>
				//  <br>Time(s): <b> $row[sttm] to $row[entm] </b></h3>
				//	</div>");
			echo("<div id=\"whatitis\">$row[description]</div>");
			echo("<br>");
			
			echo("<div id=\"subby\">Submitted by: $row[contact], $row[callsign] on $row[ondt]</div>");
						    
			echo("<div id=\"qs\">Questions: <a href='mailto:$row[email]?subject=$row[title]'>$row[email] </a>");

			echo("<br><br>");
			echo("<button onclick=\"closeWin()\">Close Window</button>");
			echo("<br><br>");
			echo("<span id=\"edit\">Something wrong? Click <a href=\"buildEvents.php?id=$row[id]\" target=\"_blank\"> here </a> to edit</span>");
			echo("<br>");
			echo("****************************************************************");
			echo("<br>$row[id]");
		}
		    echo("<p>buildEventListing.php</p>");
?>
</body>
</html>