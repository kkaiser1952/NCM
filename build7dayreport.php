<?php 
    // The purpose of this page/program is to create a 7 day report of NCM activites.
    // Written: 2023-06-21, first day of summer    
    // Updated: 2024-06-15    

    // Define the dropdown options at the top of the file for easy maintenance
    $dropdownOptions = [
        "browse_net" => "Browse Net",
        "map" => ["Map Net", "https://net-control.us/map.php?NetID="],
        "ics214" => ["ICS-214", "https://net-control.us/ics214.php?NetID="],
        "ics309" => ["ICS-309", "https://net-control.us/ics309.php?NetID="],
        "ics205a" => ["ICS-205A", "https://net-control.us/ics205A.php?NetID="],
        "timeline" => ["TimeLine", "https://net-control.us/HzTimeline.php?NetID="]
    ];
?>        
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7 Day NCM Activity Report</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/NetManager.js"></script>
    
    <script>
    // Define net_by_number function
    function net_by_number(s) {
        if(s) {
            $.ajax({
                type: "GET",
                url: "getkind.php",  
                data: {q: s},
                success: function(html) {
                    var remarks = 'Net No: '+s+', '+html;
                    $("#remarks").html(remarks);
                },
                error: function() {
                    alert('Last Query Failed, try again.');
                }
            });
                    
            showActivities(s);
            
            // Hide some elements to prevent play
            $(".ckin1").addClass("hidden");
            $("#closelog").addClass("hidden");
            $("#cs1").addClass("hidden");
            $("#Fname").addClass("hidden");
            $("#newbttn").addClass("hidden");
            $(".tohide").addClass("hidden");
            
            $("#remarks").removeClass("hidden");
            
            // Set this value before the MySQL get the data to prevent editing
            $(".closenet").html('Net Closed');
        }
    }

    $(document).ready(function() {
        $('.dropdown-on-NetID').each(function() {
            var container = $(this);
            var link = container.find('.dropdown-trigger');
            var select = container.find('.dropdown-list');

            // Add a mouseenter event handler to show the dropdown
            link.on('mouseenter', function() {
                var linkOffset = link.offset();
                var linkHeight = link.outerHeight();

                select.css({
                    'z-index': '1000',
                    'display': 'block',
                    'position': 'absolute',
                    'top': linkOffset.top + linkHeight + 'px',
                    'left': linkOffset.left + 'px'
                });
            });

            // Add a mouseleave event handler to hide the dropdown
            container.on('mouseleave', function() {
                select.css('display', 'none');
            });

            // Add a change event handler to the dropdown
            select.on('change', function() {
                var selectedOption = select.find('option:selected');
                var value = selectedOption.val();
                var netID = link.text();

                if (value === "browse_net") {
                    net_by_number(netID);
                    select.css('display', 'none');
                } else if (value) {
                    window.open(value, '_blank');
                    select.css('display', 'none');
                }
            });
        });

        // Link color handling
        $('tr').each(function () {
            var $row = $(this);
            var netIDCell = $row.find('td:first-child');
            var link = netIDCell.find('a');
            
            if (link.length > 0) {
                var backgroundColor = $row.css('background-color');
                
                // Convert rgb(x, x, x) to brightness value
                var rgb = backgroundColor.match(/\d+/g);
                if (rgb) {
                    var brightness = (parseInt(rgb[0]) * 299 + 
                                    parseInt(rgb[1]) * 587 + 
                                    parseInt(rgb[2]) * 114) / 1000;
                    
                    if (brightness < 128) {
                        link.css('color', 'white');
                    } else {
                        link.css('color', '#0000EE');
                    }
                }
            }
        });

        // Header text updates
        var headers = {
            0: "Net ID",
            1: "Log Date",
            2: "Net Call",
            3: "Stations",
            4: "Frequency",
            5: "Closed Time",
            6: "1st Logins",
            7: "TOD - H:M:S"
        };
        
        Object.keys(headers).forEach(function(index) {
            $("th:eq(" + index + ")").text(headers[index]);
        });
    });
    </script>

    <style>
    /* Base styles */
    .hidden { display: none; }
    .centered { text-align: center; }
    
    /* Table styles */
    table { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px; border: 1px solid #ddd; }
    
    /* Row background colors */
    .even-row { background-color: #ffffff; }
    .odd-row { background-color: #f0f0f0; }
    .blue-bg { background-color: #add8e6; }
    .green-bg { background-color: #90EE90; }
    .purple-bg { background-color: #DDA0DD; }
    .red-bg { background-color: #FFB6C6; }
    .yellow-bg { background-color: #FFFF99; }
    .cayenne-bg { background-color: #E3735E; }
    
    /* Combo background colors */
    .combo-bg { background: linear-gradient(45deg, #90EE90, #DDA0DD, #FFB6C6); }
    .blueyellow-bg { background: linear-gradient(45deg, #add8e6, #FFFF99); }
    .greenpurple-bg { background: linear-gradient(45deg, #90EE90, #DDA0DD); }
    .redgreen-bg { background: linear-gradient(45deg, #FFB6C6, #90EE90); }
    .redpurple-bg { background: linear-gradient(45deg, #FFB6C6, #DDA0DD); }
    .redblue-bg { background: linear-gradient(45deg, #FFB6C6, #add8e6); }
    .bluepurple-bg { background: linear-gradient(45deg, #add8e6, #DDA0DD); }
    .greenblue-bg { background: linear-gradient(45deg, #90EE90, #add8e6); }

    /* Dropdown styles */
    .dropdown-trigger {
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
    }

    .dropdown-list {
        position: absolute;
        background-color: white;
        border: 1px solid #ddd;
        padding: 5px;
        z-index: 1000;
    }

    /* Form styles */
    .report-container {
        margin: 20px;
        padding: 15px;
        border: 1px solid #ddd;
    }

    .form-row {
        margin-bottom: 10px;
        display: flex;
        gap: 20px;
    }

    .form-column {
        flex: 1;
    }
    </style>
</head>

<!-- Part 2 starts here -->

<body>

<?php
require_once "NCMStats.php";        
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
require_once "dbConnectDtls.php";  

// Collect the daily totals of stations and first logins 
$sql = $db_found->prepare("
SELECT
    DATE(DATE_SUB(logdate, INTERVAL 5 HOUR)) AS log_date,
    COUNT(callsign) AS total_stations,
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

// Main data SQL query
$sql = $db_found->prepare("
    SELECT
        CASE WHEN nl.subNetOfID <> 0 THEN CONCAT(nl.subNetOfID, '/', nl.netID)
            ELSE nl.netID END AS netID,
        CASE WHEN CONVERT_TZ(nl.logdate,'+00:00','-05:00') <> '0000-00-00 00:00:00' 
            THEN CONVERT_TZ(nl.logdate,'+00:00','-05:00')
            ELSE (SELECT max(dttm) FROM NetLog) END AS logdate,
        CONCAT(nl.netcall, '<br>', nl.activity) AS netcall_activity,
        nl.stations,
        nl.pb,
        nl.testnet,
        nl.frequency,
        CASE WHEN nl.logclosedtime IS NULL 
            THEN DATE_ADD((SELECT max(dttm) FROM NetLog), INTERVAL 30 MINUTE)
            WHEN nl.logclosedtime = '' 
            THEN DATE_ADD((SELECT max(dttm) FROM NetLog), INTERVAL 30 MINUTE)
            ELSE nl.logclosedtime END AS logclosedtime,
        CASE WHEN nl.pb = '0' THEN '' 
            WHEN nl.pb = '1' THEN 'blue-bg'
            ELSE '' END AS PBcss,
        CASE WHEN nl.logclosedtime IS NOT NULL THEN ''
            WHEN nl.logclosedtime IS NULL THEN 'green-bg'
            ELSE '' END AS LCTcss,
        CASE WHEN nl.netcall IN ('TEST', 'TE0ST', 'TEOST', 'TE0ST') 
            OR nl.netcall LIKE '%test%' THEN 'purple-bg'
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
                WHEN CONVERT_TZ(nl.logdate,'+00:00','-05:00') = '0000-00-00 00:00:00' 
                    THEN TIME_TO_SEC((SELECT max(dttm) FROM NetLog))
                ELSE TIME_TO_SEC(nl.timeonduty)
            END
        )) AS Volunteer_Time,
        SEC_TO_TIME(
            CASE
                WHEN subquery.total_timeonduty_sum IS NULL THEN 0
                WHEN CONVERT_TZ(nl.logdate,'+00:00','-05:00') = '0000-00-00 00:00:00' 
                    THEN TIME_TO_SEC((SELECT max(dttm) FROM NetLog))
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
        SUM(firstLogin) AS First_Login, 
        IFNULL(SUM(timeonduty), 0) AS total_timeonduty_sum
        FROM NetLog
        WHERE (DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
        GROUP BY netID
    ) AS subquery ON nl.netID = subquery.netID
    LEFT JOIN TimeLog tl ON nl.netID = tl.netID
    GROUP BY netID
    ORDER BY CAST(nl.netID AS SIGNED) DESC;
");

// Part 3 starts here //

<?php
// Execute the SQL query and store the result
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Print the title and report container
if (!empty($result)) {
    echo '<div class="reportTitle">' . $netcall . ' Groups, ' . $cscount . ' Unique Stations, ' . 
         $netCnt . ' Nets, ' . $records . ' Entries, <br>' . $volHours . ' of Volunteer Time</div>';
    
    $title = "Today is: " . date("l") . ', ' . date('Y/m/d') .
             "<br>Past 7 DAYs NCM Report for " . $result[0]['netID_count'] . " Nets <br>";        
    
    // Report Container with Legend
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
              <label for="subnets">Sub Nets:</label>
              <input type="text" id="subnets" name="subnets" class="cayenne-bg" value="">
            </div>
          </div>
          
          <!-- Fourth line -->
          <div class="form-row">
            <label for="combo">Combo Nets:</label>
            <input type="text" id="combo" name="combo" class="combo-bg" value="" style="width: 300px;">
          </div>
        </form>
        </div>';

    // Start the table
    echo '<table>';

    // Create the grand total row over the headers
    echo '<tr class="sum-row">';
    echo '<td class="">' . $result[0]['netID_count'] . '</td>';
    echo '<td class=""> All Days are Local</td>';
    echo '<td colspan="1" style="text-align: right;">Grand Totals:</td>';
    echo '<td class="">' . $ttl_callsigns . '</td>';
    echo '<td class=""></td>';
    echo '<td colspan="1" style="text-align: center;"></td>';
    echo '<td colspan="1" style="text-align: center;">First Logins:<br>' . $ttl_first_logins . '</td>';
    echo '<td class="">' . 'TOD:<br>' . $time_on_duty . '</td>';
    echo '<td class="">' . $OpenCall . '</td>';
    echo '<td class="">' . $CloseCall . '</td>';
    echo '</tr>';
    
    // Add the headers
    echo '<tr>';
    foreach (array_keys($result[0]) as $column) {
        if ($column !== 'netID_count' && $column !== 'pb' && $column !== 'testnet' && 
            $column !== 'PBcss' && $column !== 'LCTcss' && $column !== 'TNcss' && 
            $column !== 'CCss' && $column !== 'Volunteer_Time' && $column !== 'FNcss' && 
            $column !== 'SNcss') {
            echo '<th>' . $column . '</th>';
        }
    }
    echo '</tr>';

    // Table rows
    $currentDate = null;
    foreach ($result as $rowIndex => $row) {
        // Calculate row styling
        $PBcss  = $row['PBcss'];     // Blue:    Prebuilt
        $LCTcss = $row['LCTcss'];    // Green:   Log Closed Time (its an open net) 
        $TNcss  = $row['TNcss'];     // Purple:  Test Nets
        $CCss   = $row['CCss'];      // Red:     Closed
        $FNcss  = $row['FNcss'];     // Yellow:  Facility Nets
        $SNcss  = $row['SNcss'];     // Cayenne: Sub Nets
        
        // Default styling for alternating rows
        $THEcss = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
    
        // Determine row styling based on conditions
        if (!empty($LCTcss) && !empty($TNcss) && !empty($CCss)) {
            $THEcss = 'combo-bg';
        } elseif (!empty($FNcss) && !empty($PBcss)) {
            $THEcss = 'blueyellow-bg';
        } elseif (!empty($LCTcss) && !empty($TNcss)) {
            $THEcss = 'greenpurple-bg';
        } elseif (!empty($LCTcss) && !empty($CCss)) {
            $THEcss = 'redgreen-bg';
        } elseif (!empty($TNcss) && !empty($CCss)) {
            $THEcss = 'redpurple-bg';
        } elseif (!empty($PBcss) && !empty($CCss)) {
            $THEcss = 'redblue-bg';
        } elseif (!empty($TNcss) && !empty($PBcss)) {
            $THEcss = 'bluepurple-bg';
        } elseif (!empty($LCTcss) && !empty($PBcss)) {
            $THEcss = 'greenblue-bg';
        } elseif (!empty($LCTcss)) {
            $THEcss = $LCTcss;
        } elseif (!empty($TNcss)) {
            $THEcss = $TNcss;
        } elseif (!empty($CCss)) {
            $THEcss = $CCss;
        } elseif (!empty($PBcss)) {
            $THEcss = $PBcss;
        } elseif (!empty($FNcss)) {
            $THEcss = $FNcss;
        } elseif (!empty($SNcss)) {
            $THEcss = $SNcss;
        }
        
        // Output date headers
        $localLogDate = date('Y-m-d', strtotime($row['logdate']));
        $dayOfWeek = date('l', strtotime($localLogDate));

        if ($currentDate !== $localLogDate) {
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
            echo '<td></td>';
            echo '<td style="text-align: center;">' . $totalStations . '</td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td style="text-align: center;">' . $totalFirstLogins . '</td>';
            echo '<td style="text-align: center;">' . gmdate("H:i:s", $v_time) . '</td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '</tr>';
            $currentDate = $localLogDate;
        }
            
        // Output data row
        echo '<tr class="' . $THEcss . '">';
        
        foreach ($row as $column => $columnValue) {
            if (!in_array($column, ['netID_count', 'pb', 'testnet', 'PBcss', 'LCTcss', 
                                  'TNcss', 'CCss', 'Volunteer_Time', 'FNcss', 'SNcss'])) {
                
                echo '<td class="centered"' . 
                     ($column === 'Open' || $column === 'Close' ? 
                     ' oncontextmenu="getCallHistory7Day(\'' . $columnValue . '\')"' : '') . '>';

                if ($column === 'netID') {
                    $netID = $columnValue;
                    
                    echo '<div class="dropdown-on-NetID">';
                    echo '<a href="javascript:void(0);" class="dropdown-trigger">' . $netID . '</a>';
                    echo '<select class="dropdown-list" style="display: none;">';
                    echo '<option disabled selected>Choose</option>';
                    
                    foreach ($dropdownOptions as $key => $value) {
                        if ($key === "browse_net") {
                            echo '<option value="browse_net">' . $value . '</option>';
                        } else {
                            echo '<option value="' . $value[1] . $netID . '">' . $value[0] . '</option>';
                        }
                    }
                    
                    echo '</select>';
                    echo '</div>';
                } else {
                    echo $columnValue;
                }
                echo '</td>';
            }
        }
        echo '</tr>';
    }
    
    echo '</table>';
    echo '<br><br>build7dayreport.php';
} else {
    echo 'No results found.';
}
?>

<!-- Add an element for remarks display -->
<div id="remarks" class="hidden"></div>

</body>
</html>