<?php 
// build7dayreport_development.php
// The purpose of this page/program is to create a 7 day report of NCM activites.
// Written: 2023-06-21, first day of summer    
// Updated: 2024-06-15  
// Modified: 2024-11-08 // added browse option to dropdwon 	
?>		
</DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>7 Day NCM Activity Report</title>
        
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/NetManager.js"></script>

<script src="js/browse_net_by_number.js"></script>
<script>
  $(document).ready(function() {
      $('tr td:first-child').click(function() {
        var value = $(this).text(); // Get the text value of the clicked <td>
        net_by_number(value); // Call your function with the retrieved value
      });
  });
  
  function net_by_number(value) {
    //alert("You clicked the first table cell with value: " + value);
    // Perform any other desired actions using the value
  }
</script>
<script src="js/NetManager.js"></script>

<script>

    $(document).ready(function() {
        $('.dropdown-on-NetID').each(function() {
            var container = $(this);
            var link = container.find('.dropdown-trigger');
            var select = container.find('.dropdown-list');

            // Add a mouseenter event handler to the link to show the dropdown
            link.on('mouseenter', function() {
                // Calculate the position of the dropdown relative to the link
                var linkOffset = link.offset();
                var linkHeight = link.outerHeight();

                // Set the dropdown's position below the link
                select.css({
                    'z-index': '1000', // Adjust z-index as needed
                    'display': 'block',
                    'position': 'absolute',
                    'top': linkOffset.top + linkHeight + 'px',
                    'left': linkOffset.left + 'px'
                });
            });

            // Add a mouseleave event handler to the container to hide the dropdown
            container.on('mouseleave', function() {
                // Hide the dropdown when the mouse leaves the container
                select.css('display', 'none');
            });

            // Add a change event handler to the dropdown
            select.on('change', function() {
                var selectedOption = select.find('option:selected');
                var url = selectedOption.val();

                if (url) {
                    // Open the URL in a new window/tab
                    window.open(url, '_blank');
                }

                // Hide the dropdown after a selection is made
                select.css('display', 'none');
            });
        });
    });
</script>

<link rel="stylesheet" type="text/css" href="css/build7dayreport.css">
  
</head>
<body>

<?php
require_once "NCMStats.php";		
	//echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";


ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  
 
 
// Collect the daily totls of stations and first logins 
$sql = $db_found->prepare("
SELECT
    DATE(DATE_SUB(logdate, INTERVAL 5 HOUR)) AS log_date,
    COUNT( callsign) AS total_stations,
    SUM(firstLogin) AS total_first_logins,
    sum(timeonduty) AS v_time
FROM
    NetLog
WHERE
    DATE(DATE_SUB(logdate, INTERVAL 5 HOUR)) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
GROUP BY
    DATE(DATE_SUB(logdate, INTERVAL 5 HOUR))
ORDER BY
    log_date DESC;
");
$sql->execute();
$dailyTotals = $sql->fetchAll(PDO::FETCH_ASSOC);
//$result = $sql->fetchAll(PDO::FETCH_ASSOC);
// Display the column headers
//echo "Log Date, Total Stations, Total First Logins<br>";


// Check if $result is an array and has elements
if (is_array($result) && !empty($result)) {
    // Loop through each row in the result set
    foreach ($result as $row) {
        $logDate = $row['log_date'];
        $totalStations = $row['total_stations'];
        $totalFirstLogins = $row['total_first_logins'];
        $v_time = $row['v_time'];
        // Display the row data
        //echo "$logDate, $totalStations, $totalFirstLogins, $v_time<br>";
    }
} else {
    //echo "No results found.";
}

// Grand totals SQL
$sql = $db_found->prepare("
SELECT  count(callsign) as all_callsigns,
        sum(firstLogIn) as ttl_1st_logins,
        CONCAT(FLOOR(SUM(`timeonduty`) / 86400), ' days ',
            LPAD(FLOOR((SUM(`timeonduty`) % 86400) / 3600), 2, '0'), ':',
            LPAD(FLOOR((SUM(`timeonduty`) % 3600) / 60), 2, '0'), ':',
            LPAD(SUM(`timeonduty`) % 60, 2, '0')
        ) AS time_on_duty
  FROM NetLog
 WHERE (DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY));
");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $ttl_callsigns = $result[0]['all_callsigns'];
    $ttl_first_logins = $result[0]['ttl_1st_logins'];
    $time_on_duty = $result[0]['time_on_duty'];

// Your SQL query
$sql = $db_found->prepare("
    SELECT
        CASE WHEN nl.subNetOfID <> 0 THEN CONCAT(nl.subNetOfID, '/', nl.netID)
            ELSE nl.netID END AS netID,
        CASE WHEN CONVERT_TZ(nl.logdate,'+00:00','-05:00') <> '0000-00-00 00:00:00' THEN CONVERT_TZ(nl.logdate,'+00:00','-05:00')
            ELSE (SELECT max(dttm) FROM NetLog) END AS logdate,
        CONCAT(nl.netcall, '<br>', nl.activity) AS netcall_activity,
        nl.stations,
        nl.pb,
        nl.testnet,
        nl.frequency,
        CASE WHEN nl.logclosedtime IS NULL THEN DATE_ADD((SELECT max(dttm) FROM NetLog), INTERVAL 30 MINUTE)
        WHEN nl.logclosedtime = '' THEN DATE_ADD((SELECT max(dttm) FROM NetLog), INTERVAL 30 MINUTE)
            ELSE nl.logclosedtime END AS logclosedtime,
        CASE WHEN nl.pb = '0' THEN '' WHEN nl.pb = '1' THEN 'blue-bg'
            ELSE '' END AS PBcss,
        CASE WHEN nl.logclosedtime IS NOT NULL THEN ''
        WHEN nl.logclosedtime IS NULL THEN 'green-bg'
            ELSE '' END AS LCTcss,
        CASE WHEN nl.netcall IN ('TEST', 'TE0ST', 'TEOST', 'TE0ST') OR nl.netcall LIKE '%test%' THEN 'purple-bg'
            ELSE '' END AS TNcss,
        CASE WHEN nl.stations = 1 THEN 'red-bg'
            ELSE '' END AS CCss,
        CASE WHEN nl.facility <> '' THEN 'yellow-bg'
            ELSE '' END as FNcss,
        CASE WHEN nl.subNetOfID <> 0 THEN 'cayenne-bg'
            ELSE '' END AS SNcss,
        subquery.First_Login,
    (SELECT COUNT(DISTINCT netID)
       FROM NetLog
      WHERE (DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
      ) AS netID_count,
           SEC_TO_TIME(SUM(
        CASE
            WHEN nl.timeonduty IS NULL THEN 0
            WHEN CONVERT_TZ(nl.logdate,'+00:00','-05:00') = '0000-00-00 00:00:00' THEN TIME_TO_SEC((SELECT max(dttm) FROM NetLog))
                ELSE TIME_TO_SEC(nl.timeonduty)
        END
    )) AS Volunteer_Time,
    SEC_TO_TIME(
        CASE
            WHEN subquery.total_timeonduty_sum IS NULL THEN 0
            WHEN CONVERT_TZ(nl.logdate,'+00:00','-05:00') = '0000-00-00 00:00:00' THEN TIME_TO_SEC((SELECT max(dttm) FROM NetLog))
                ELSE subquery.total_timeonduty_sum
    END
    ) AS Total_Time,
        MAX(CASE
            WHEN tl.comment LIKE '%Opened the%' THEN tl.callsign
                ELSE NULL
        END) AS Open,
        MAX(CASE
            WHEN tl.comment LIKE '%log was Closed%' THEN tl.callsign
                ELSE NULL
        END) AS Close
      FROM (
    SELECT  netID,
            activity,
            subNetOfID,
            pb,
            netcall,
            COUNT(*) AS stations,
            logclosedtime,
            testnet,
            timeonduty,
            facility,
            frequency,
            CASE WHEN logdate <> '0000-00-00 00:00:00' THEN logdate
                ELSE (SELECT max(dttm) FROM NetLog) END AS logdate
     FROM NetLog
    WHERE (DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
    GROUP BY netID
    ) AS nl
    LEFT JOIN (
        SELECT netID,
    SUM(firstLogin) AS First_Login, IFNULL(SUM(timeonduty), 0) AS total_timeonduty_sum
    FROM NetLog
    WHERE (DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
    GROUP BY netID
    ) AS subquery ON nl.netID = subquery.netID
    LEFT JOIN TimeLog tl ON nl.netID = tl.netID
    GROUP BY netID
    ORDER BY CAST(nl.netID AS SIGNED) DESC;
    ");

// Execute the SQL query and store the result in $result variable
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Print the title
if (!empty($result)) {
            	 
    // top of the report, before the day 7 stuff 
   // echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";
 
	//echo '<div class="reportTitle">' . 'Today is: ' . date('l') . ', ' . date('Y/m/d') . '<br>' .
    echo '<div class=\'reportTitle\';>' . $netcall . ' Groups, ' . $cscount . ' Unique Stations, ' . $netCnt . ' Nets, ' . $records . ' Entries, <br>' . $volHours . ' of Volunteer Time</div>';
    
		 
    $title = "Today is: " . date("l") . ', ' . date('Y/m/d') .
    "<br>Past 7 DAYs NCM Report for " . $result[0]['netID_count'] . " Nets <br>";		
    
    echo '<h1 style="margin-left:300;">' . $title . '</h1>
        <div class="report-container">     
        <form>
          <!-- First line -->
          <div class="form-row">
            <div class="form-column">
              <label for="open_nets">Open Nets:</label>
              <input type="text" id="open_nets" name="open_nets" class="green-bg" value="">
            </div>
            <div class="form-column">
              <label for="one_entry">One Entry:</label>
              <input type="text" id="one_entry" name="one_entry" class="red-bg" value="">
            </div>
          </div>
          
          <!-- Second line -->
          <div class="form-row">
            <div class="form-column">
              <label for="prebuilt">Pre-Built:</label>
              <input type="text" id="prebuilt" name="prebuilt" class="blue-bg" value="">
            </div>
            <div class="form-column">
              <label for="test">Test Nets:</label>
              <input type="text" id="test" name="test" class="purple-bg" value="">
            </div>
          </div>
          
          <!-- Third line -->
          <div class="form-row">
            <div class="form-column">
              <label for="facility">Facility Nets:</label>
              <input type="text" id="facility" name="facility" class="yellow-bg" value="">
            </div>
          <div class="form-column">
              <label for="test">Sub Nets:</label>
              <input type="text" id="test" name="test" class="cayenne-bg" value="">
            </div>
          </div>
          
          <!-- Fourth line -->
          <div class="form-row">
            <label for="combo">Combo Nets:</label>
            <input type="text" id="combo" name="combo" class="combo-bg" value="" style="width: 300px;">
          </div>
        </form>
        </div>
    ' // this tick closes the echo at the $title line 
    ;
} else {
    echo 'No results found.';
} // overall end of IF after Print the title

// Check if there are any rows in the result set
if (!empty($result)) {
    // Start the table
    echo '<table>';

    
    // Create the grand total row over the headers
    echo '<tr class="sum-row">';
    echo '<td class="" >' . $result[0]['netID_count'] . '</td>';
    echo '<td class="" > All Days are Local' . '</td>';
    echo '<td colspan="1" style="text-align: right;">Grand Totals:</td>';
    echo '<td class="" >' . $ttl_callsigns . '</td>';
    echo '<td class="" >';
    echo '<td colspan="1" style="text-align: center;"></td>';
    echo '<td colspan="1" style="text-align: center;">First Logins:<br>' . $ttl_first_logins . '</td>';
    echo '<td class="" >' . 'TOD:<br>' . $time_on_duty . '</td>';
    echo '<td class="" >' . $OpenCall . '</td>';
    echo '<td class="" >' . $CloseCall . '</td>';
    echo '</tr>';
    echo '<tr>';
    
    // Start the Table header
    // Add the headers 
    foreach (array_keys($result[0]) as $column) {
        if ($column !== 'netID_count' && $column !== 'pb' && $column !== 'testnet' && $column !== 'PBcss' && $column !== 'LCTcss' && $column !== 'TNcss' && $column !== 'CCss' && $column !== 'Volunteer_Time' && $column !== 'FNcss' && $column !== 'SNcss') {
        
            echo '<th>' . $column . '</th>';
        }
    }
    
    echo '</tr>'; // end for Table header

    // Table rows
    $currentDate = null;
    //$dailyTotals = [];
    
    foreach ($result as $rowIndex => $row) {
        // Calculate the value of $THEcss for this specific row based on the conditions
        $PBcss  = $row['PBcss'];     // Blue:    Prebuilt
        $LCTcss = $row['LCTcss'];    // Green:   Log Closed Time (its an open net) 
        $TNcss  = $row['TNcss'];     // Purple:  Test Nets
        $CCss   = $row['CCss'];      // Closed
        $FNcss  = $row['FNcss'];     // Yellow:  Facility Nets
        $SNcss  = $row['SNcss'];     // Ceyenne: Sub Nets
        
        // style every other row
        $THEcss = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
    
        if (!empty($LCTcss) && !empty($TNcss) && !empty($CCss)) {
            // ALL LCTcss and TNcss and CCss are set
            $THEcss = 'combo-bg';
        } elseif (!empty($FNcss) && !empty($PBcss)) {
            // Both FNcss and PBcss are set
            $THEcss = 'blueyellow-bg';
        } elseif (!empty($LCTcss) && !empty($TNcss)) {
            // Both LCTcss and TNcss are set
            $THEcss = 'greenpurple-bg';
        } elseif (!empty($LCTcss) && !empty($CCss)) {
            // Both LCTcss and CCss are set
            $THEcss = 'redgreen-bg';
        } elseif (!empty($TNcss) && !empty($CCss)) {
            // Both TNcss and CCss are set
            $THEcss = 'redpurple-bg';
        } elseif (!empty($PBcss) && !empty($CCss)) {
            // Both PBcss and CCss are set
            $THEcss = 'redblue-bg';
        } elseif (!empty($TNcss) && !empty($PBcss)) {
            // Both TNcss and PBcss are set
            $THEcss = 'bluepurple-bg';
        } elseif (!empty($LCTcss) && !empty($PBcss)) {
            // Both LCTcss and PBcss are set
            $THEcss = 'greenblue-bg';
        } elseif (!empty($LCTcss)) {
            // Only LCTcss is set
            $THEcss = $LCTcss;
        } elseif (!empty($TNcss)) {
            // Only TNcss is set
            $THEcss = $TNcss;
        } elseif (!empty($CCss)) {
            // Only CCss is set
            $THEcss = $CCss;
        } elseif (!empty($PBcss)) {
            // Only PBcss is set
            $THEcss = $PBcss;
        } elseif (!empty($FNcss)) {
            // Only FNcss is set
            $THEcss = $FNcss;
        } elseif (!empty($SNcss)) {
            // Only FNcss is set
            $THEcss = $SNcss;
        }
        
    // Output the date and day of the week in a separate row for the start of a new day
    $localLogDate = date('Y-m-d', strtotime($row['logdate']));
    $dayOfWeek = date('l', strtotime($localLogDate));

    if ($currentDate !== $localLogDate) {
        // Find the corresponding daily totals for the current date
        $totalStations = 0;
        $totalFirstLogins = 0;
        $v_time = 0;

        foreach ($dailyTotals as $dailyTotal) {
            if ($dailyTotal['log_date'] === $localLogDate) {
                $totalStations = $dailyTotal['total_stations'];
                $totalFirstLogins = $dailyTotal['total_first_logins'];
                $v_time = $dailyTotal['v_time'];
                break;
            }
        }

        echo '<tr class="date-row">';
        echo '<td colspan="2">' . $localLogDate . ' (' . $dayOfWeek . ')</td>';
        echo '<td></td>'; // Empty cell for netcall_activity
        echo '<td style="text-align: center;">' . $totalStations . '</td>'; // Total stations
        echo '<td></td>'; // Empty cell for frequency
        echo '<td></td>'; // Empty cell for logclosedtime
        echo '<td style="text-align: center;">' . $totalFirstLogins . '</td>'; // Total first logins
        
        echo '<td style="text-align: center;">' . gmdate("H:i:s", $v_time) . '</td>'; // Total volunteer hours
        echo '<td></td>'; // Empty cell for Volunteer_Time
        echo '<td></td>'; // Empty cell for Open
        echo '<td></td>'; // Empty cell for Close
        echo '</tr>';
        $currentDate = $localLogDate;
    }
            
            // The row color if there is one
            echo '<tr class="' . $THEcss . '">'; 
            
            // Define an array of options and their corresponding URLs
            // add new options here and in the <options below
            $options = [
                "Map Net" => "https://net-control.us/map.php?NetID="    . $netID,
                "ICS-214" => "https://net-control.us/ics214.php?NetID=" . $netID,
                "ICS-209" => "https://net-control.us/ics309.php?NetID=" . $netID,
                "ICS-205" => "https://net-control.us/ics205A.php?NetID=". $netID,
                "Time Line" => "https://net-control.us/HzTimeline.php?NetID=" . $netID
                // https://net-control.us/buildUniqueCallList.php
                // Add more options as needed
            ];
            
            $columnOrder = array(
                        'netID',  'netID_count',  'pb', 'testnet', 'PBcss', 'LCTcss', 'TNcss', 'CCss',
                        'Volunteer_Time', 'FNcss', 'SNcss', 'Open', 'Close'
                    );
     
            foreach ($row as $column => $columnValue) {
                if ($column === 'netID_count' OR $column === 'pb' OR $column === 'testnet' OR $column === 'PBcss' OR $column === 'LCTcss' OR $column === 'TNcss' OR $column === 'CCss' OR $column === 'Volunteer_Time' OR $column === 'FNcss' OR $column === 'SNcss' ) {
                    continue;
                }
                   
                   
                    echo '<td class="centered" ' . ($column === 'Open' || $column === 'Close' ? 'oncontextmenu="getCallHistory7Day(\'' . $columnValue . '\')"' : '') . '>';

                    
                    if ($column === 'netID') {
                        $netID = $columnValue;
                        
                        // We are building a dropdown list when the NetID value is clicked
                        echo '<div class="dropdown-on-NetID">';
                        echo '<a href="javascript:void(0);" class="dropdown-trigger" style="color: blue;">' . $netID . '</a>';
                        echo '<select class="dropdown-list" style="display: none;">';
                        echo '<option disabled selected>Choose</option>';
                        
                        // add new options here and in the $options above
                        echo '<option value="https://net-control.us/map.php?NetID=' . $netID . '">Map Net</option>';
                        echo '<option value="https://net-control.us/ics214.php?NetID=' . $netID . '">ICS-214</option>';
                        echo '<option value="https://net-control.us/ics309.php?NetID=' . $netID . '">ICS-309</option>';
                        echo '<option value="https://net-control.us/ics205A.php?NetID=' . $netID .
                            '">ICS-205A</option>';
                        echo '<option value="https://net-control.us/HzTimeline.php?NetID=' . $netID .
                            '">TimeLine</option>';
                            
                        echo '</select>';
                        echo '</div>';
                                        
                    } else {
                        echo $columnValue;
                    }
                        echo '</td>';
            } // End foreach
    
            
            echo '</tr>'; 
                
} // End foreach
        // End the table
        echo '</table>';     
        echo '<br><br>build7dayreport.php';
    } else {
        echo 'No results found.';
    } 
?>

<script>
/* The following function put UTC after logdate and logclosedtime column names in the title */
$(document).ready(function() {
    // Adding a word to one of the header <th> values
    // Find the second <th> element using :eq(1) selector (index starts from 0)
    var firstHeader     = $("th:eq(0)"); // netID
    var secondHeader    = $("th:eq(1)"); // logdate
    var thirdHeader     = $("th:eq(2)"); // netcall
    var fourthHeader    = $("th:eq(3)"); // station count
    var fiftheHeader    = $("th:eq(4)"); // frequency
    var sixthhHeader    = $("th:eq(5)"); // logclosedtime
    var seventhHeader   = $("th:eq(6)"); // first login count
    var eighthHeader    = $("th:eq(7)"); // Time on duty
    //var nineththHeader    = $("th:eq(8)"); // Open (callsign)
    //var tenththHeader    = $("th:eq(9)"); // Close (callsign)

    // Append the word using .append() method
    //secondHeader.append(" UTC");
    //fourthHeader.append(" UTC");
    //sixthHeader.append(" H:M:S");
    
    firstHeader.text("Net ID");
    secondHeader.text("Log Date");
    thirdHeader.text("Net Call");
    fourthHeader.text("Stations");
    fiftheHeader.text("Frequency");
    sixthhHeader.text("Closed Time");
    seventhHeader.text("1st Logins");
    eighthHeader.text("TOD - H:M:S");
    //ninethHeader.text("Open");
    //tenthHeader.text("Close");

        $('tr').each(function () {
            var $row = $(this);
            var backgroundColor = $row.css('background-color');
            var netIDCell = $row.find('td:first-child');

            if (backgroundColor !== 'rgb(255, 255, 255)' && backgroundColor !== 'rgb(240, 240, 240)' && netIDCell.find('a').length > 0) {
                // Check if the row's background color is not white or off-white and the netID cell contains a link
                netIDCell.find('a').css('color', 'white');
            }
        });
});
</script>

</body>
</html>
