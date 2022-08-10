<!doctype html>
<?php
// getCallHistory.php
// This program produces a report of the callsign being called, it opens as a modal or windwo
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $netcall = $_POST['netcall']; 
    $nomo = $_POST[nomo];
    $and1 = '';
    $netcall = strtoupper($netcall);
    //$nomo = 12;  // number of months
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
        SELECT  callsign, Fname, Lname, CONCAT(state,' ',county,' ',district) as place,
            COUNT(callsign) as cnt_call
          FROM NetLog 
         WHERE netcall = '$netcall'  
           AND logdate > DATE_SUB(now(), INTERVAL $nomo MONTH)
       /*    $and1 */
           
        GROUP BY callsign
        ORDER BY `NetLog`.`district`, cnt_call DESC, callsign ASC
         ";
         
//echo "$sql<br>";

    $listing = '<tr>';
    $rowno = 0;
    foreach($db_found->query($sql) as $row) {
        $rowno = $rowno + 1;  
	    
	    $netcallsign = '$row[callsign]';
	    $Fname    = ucfirst(strtolower('$row[Fname]'));
	    $Lname    = '$row[Lname]';
	    
	    $listing .= "<td>$rowno</td>  <td>$row[callsign]</td>  <td>$row[Fname]</td>   <td>$row[Lname]</td> <td>$row[place]</td>  <td>$row[cnt_call]</td></tr>";
    }
?>

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
