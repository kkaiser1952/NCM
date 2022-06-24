<!doctype html>
<html lang="en">
<head>
    <title>Closing</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" />   
    <link rel="stylesheet" type="text/css" href="css/closing.css" /> 
    
    <script>
	    function closeWin() {
			close();   // Closes the new window
		}
	</script>
		
</head>
<body>
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

    
    if ($domain == 'ALL') { 
	    	$thewhere = "WHERE NOW() <= end AND docType LIKE '%closing%'"; 
	    	$domain = "<p style='font-size:18pt; color:red';>Examples</p>";
	    	}
    	
    	else {$thewhere = "WHERE docType LIKE '%closing%'
	    	AND domain like '%$domain%'
    		    AND (subdomain like '%$activity%' OR subdomain = '')
			 	AND NOW() <= end
			 	";}
	    		
	    //echo "$thewhere";
	    // WHERE docType LIKE '%closing%' AND NOW() <= end AND domain LIKE '%domain%'    
	        
    // http://php.net/json_decode    decodes JSON strings.
    function json_clean_decode($json, $assoc = false, $depth = 512, $options = 0) {
    // search and remove comments like /* */ and //
    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
    
    if(version_compare(phpversion(), '5.4.0', '>=')) {
        $json = json_decode($json, $assoc, $depth, $options);
    }
    elseif(version_compare(phpversion(), '5.3.0', '>=')) {
        $json = json_decode($json, $assoc, $depth);
    }
    else {
        $json = json_decode($json, $assoc);
    }

    return $json;
}

	$sql = ("SELECT * 
			   FROM events 
			   $thewhere
			  ORDER BY dttm DESC
			  LIMIT 1");
			  
			  //echo "$sql";
			   // SELECT * FROM events WHERE docType LIKE '%closing%' AND NOW() <= end AND domain LIKE '%KCNARES%' AND doctype LIKE '%DMR%' ORDER BY dttm DESC LIMIT 1

	$num_rows = 0;   // Counter to color row backgrounds in loop below
		  		     	              
		foreach($db_found->query($sql) as $row) {
			++$num_rows; // Increment row counter for coloring background of rows
			echo("<div>$domain Net</div>");
			echo("<div id=\"subby\">Submitted by: $row[contact],$row[callsign]</div>");

			echo("<br>");
			echo("<div id=\"whatitis\">$row[description]</div>");

			echo("<br><br>");
			echo("<button onclick=\"closeWin()\">Close Window</button>");
			echo("<br><br>");
			echo("<span id=\"edit\">Something wrong? Click <a href=\"buildEvents.php?id=$row[id]\" target=\"_blank\"> here </a> to edit</span>");
			echo("<br>");
			echo("****************************************************************");
			echo("<br>$row[id]");
			echo("<br><br>");
		}
		
		    echo("<p>buildClosingListing.php</p>");
?>
</body>
</html>