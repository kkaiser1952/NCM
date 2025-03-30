<!doctype html>
<?php
// getCallHistory.php A.K.A. The Usual Suspects
// This program produces a report of the callsign being called, it opens as a modal or window
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $netcall = $_POST['netcall']; 
       // $netcall = 'mesn';
    $nomo = $_POST[nomo];
        //$nomo = 3;
    $and1 = '';
    $netcall = strtoupper($netcall);

    $state = '';
    
    if ($state <> '') {
        $and1 = "AND state = '$state'";
    }
    
// Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}
/* ORDER BY `NetLog`.`district`, cnt_call DESC, callsign ASC */
// Define your base query
// Define your base query
$sql = "
    SELECT callsign, Fname, Lname, 
        CONCAT(state,' ',county,' ',district) as place,
        county,
        COUNT(callsign) as cnt_call,
        district
    FROM NetLog 
    WHERE netcall = '$netcall'  
      AND logdate > DATE_SUB(now(), INTERVAL $nomo MONTH)
    GROUP BY callsign, Fname, Lname, county, district";

// Add conditional ORDER BY based on netcall value
if (strtoupper($netcall) == 'MESN') {
    $sql .= " ORDER BY 
              CASE 
                  WHEN district REGEXP '^[A-Z]$' THEN 1 
                  ELSE 2 
              END, 
              state ASC,
              district ASC, 
              cnt_call DESC, 
              callsign ASC";
}
 else if (strtoupper($netcall) == 'MODES') {
    $sql .= " ORDER BY county ASC, cnt_call DESC"; // Sort by county, then by count descending
} else if (strtoupper($netcall) == 'NR0AD') {
    $sql .= " ORDER BY county ASC, cnt_call DESC"; // Sort by county, then by count descending
} else {
    // Default: Sort alphabetically by name
    $sql .= " ORDER BY county ASC, callsign ASC, cnt_call, Lname ASC, Fname ASC";
}

$previousCounty = null;
$firstInCounty = true;
$rowno = 0;

foreach($db_found->query($sql) as $row) {
    $rowno = $rowno + 1;

    // MESN uses the defaults 
    
    if (strtoupper($netcall) == 'MODES' || strtoupper($netcall) == 'NR0AD') {
        // For MODES, highlight only the first row of each county
        if ($previousCounty != $row['county']) {
            $liteItUp = "style=\"background-color:lightgreen\"";
            $previousCounty = $row['county'];
            $firstInCounty = true;
        } else {
            $liteItUp = "";
            $firstInCounty = false;
        }
    } else {
        // Regular district-based highlighting for other nets
        if ($lastDist != $row['district']) {
            $liteItUp = "style=\"background-color:lightblue\"";
            $lastDist = $row['district'];
        } else {
            $liteItUp = "";
        }
    }
    
    $listing .= "<tr $liteItUp>
                 <td><input type='checkbox' class='station-checkbox' id='check_$rowno' /></td>
                 <td>$rowno</td>  
                 <td>$row[callsign]</td>  
                 <td>$row[Fname]</td>   
                 <td>$row[Lname]</td> 
                 <td>$row[place]</td>  
                 <td>$row[cnt_call]</td>
                 </tr>";
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
	    // Function to refresh the page
        function refreshPage() {
            saveCheckboxStates();
            location.reload();
        }
        
        // Save checkbox states when refreshing
        function saveCheckboxStates() {
            const checkboxes = document.querySelectorAll('.station-checkbox');
            const checkboxStates = {};
            
            checkboxes.forEach(checkbox => {
                checkboxStates[checkbox.id] = checkbox.checked;
            });
            
            localStorage.setItem('suspectCheckboxStates_<?php echo $netcall ?>', JSON.stringify(checkboxStates));
        }
        
        // Restore checkbox states after page loads
        function restoreCheckboxStates() {
            const savedStates = localStorage.getItem('suspectCheckboxStates_<?php echo $netcall ?>');
            
            if (savedStates) {
                const checkboxStates = JSON.parse(savedStates);
                
                Object.keys(checkboxStates).forEach(id => {
                    const checkbox = document.getElementById(id);
                    if (checkbox) {
                        checkbox.checked = checkboxStates[id];
                    }
                });
            }
        }
        
        // Add keyboard shortcut for refresh (F5 or Ctrl+R)
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F5' || (event.ctrlKey && event.key === 'r')) {
                event.preventDefault();
                refreshPage();
            }
        });
        
        // Load the saved checkbox states when the page finishes loading
        window.addEventListener('load', restoreCheckboxStates);
	</script>
	
	<style>
    	html {
        	width: 100%;
    	}
		h2 {
			column-span: all;
		}

        /* How many columns? */
		.prime {
    		columns: 20px 1; 
    		column-gap: 10px; 
		}
		
		/* Checkbox styles */
        .station-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        /* Highlight row when checkbox is checked */
        .station-checkbox:checked ~ td {
            font-weight: bold;
            background-color: #e6ffe6 !important;
        }
        
        /* Refresh button styles */
        #refreshBtn {
            position: fixed;
            top: 20px;
            right: 20px;
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
        
        /* Table styles */
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 0.9em;
            line-height: 1.0;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 1px 1px;
            text-align: left;
        }
        
        th {
            background-color: #04AA6D;
            color: white;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Make the callsign column (3rd column) bold */
        td:nth-child(3) {
            font-weight: bold;
        }
	</style>
	
</head>

<body>
    <h1>The Usual Suspects</h1>
    <h2>This is a list of the stations that have checked into the <?php echo $netcall ?> net in the past <?php echo $nomo ?> months</h2>
    
    <!--
    <button id="refreshBtn" onclick="refreshPage()" title="Refresh data">Refresh</button>
    -->
    
    <div class="prime">
        <table>
            <tr>
                <th></th><th class="<?php $liteItUp ?>"></th><th>CALL</th><th>First</th><th>Last</th><th>St, CO, Dist</th><th>Count</th>
            </tr>
            <?php echo "$listing</table></div><div><br><br>getCallsHistoryByNetCall.php"; ?>
        </table>
    </div>
</body>
</html>