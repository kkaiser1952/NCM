<!doctype html>
<?php
// getCallOrderByNet.php
// This program looks at the past several months of a given net. Determines the best grouping of suffix letters to use to evenly call a net by suffix.
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $netcall = $_POST['netcall']; 
    $nomo = $_POST[nomo];
    $and1 = '';
    $netcall = strtoupper($netcall);
    $nomo = 16;  // number of months
    $netcall = 'MESN';
    $state = '';
    
    if ($state <> '') {
        $and1 = "AND state = '$state'";
    }
    
// Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

    $sql = "
        SELECT  DISTINCT (callsign)
          FROM NetLog 
         WHERE netcall = '$netcall'  
           AND logdate > DATE_SUB(now(), INTERVAL $nomo MONTH)
        ";
         
//echo "$sql<br>";

    $listing = '<tr>';
    $suffix  = "";
    foreach($db_found->query($sql) as $row) {
        $firstNum = strcspn("$row[callsign]",'0123456789'); // position of 1st number
	    $nextLetr = substr("$row[callsign]",$firstNum+1,1); // first letter after 1st number
	    
	        //echo "$row[callsign], $firstNum, $nextLetr <br>";

	     $suffix .= "'$nextLetr',";
    }
    
        //$suffix2 = array("$suffi]");
        print_r($suffix);
        //$bigSuffix = array_count_values(array $suffix): array;
        //$suffix = array("$suffix");
        //$array_freq = array_count_values($suffix);
        //print_r($suffix);
        print_r(array_count_values($suffix));
        //print_r($array_freq);
?>
<!--
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> Stations Associated With This Net </title>
    <meta name="author" content="Kaiser" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    <script>
	
	</script>
	
	<style>
    	html {
        	width: 100%;
    	}
		h2 {
			column-span: all;
		}
		.prime {
    	/*	column-width: 40px; 
    		column-count: 2; */
    		columns: 20px 2; 
    		column-gap: 10px; 
    	/*	column-rule-width: 3px;
    		column-rule-style: solid;
    		column-rule-color: green; 
    		column-rule: 3px solid green; */
		}
	</style>
	
</head>

<body>
    <h1>The Usual Suspects</h1>
        <h2>This is a list of the stations that have checked into the <?php echo $netcall ?> net in the past <?php  echo $nomo ?> months</h2>
        
            <div class="prime">
                <table>
                    <tr>
                        <th></th>  <th>CALL</th>  <th>First</th>   <th>Last</th> <th>St, CO, Dist</th>  <th>Count</th>
                    </tr>
                        <?php echo "$listing</table></div><div><br><br>getCallsHistoryByNetCall.php"; ?>
                </table>
            </div>
</body>
</html>
