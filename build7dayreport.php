<?php 
    // The purpose of this page/program is to create a 7 day report of NCM activites.
    // Written: 2023-06-21, first day of summer    
    // Updated: 2024-06-15    

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

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
    
    <style>
    /* Base styles */
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
    }
    
    .hidden { display: none; }
    .centered { text-align: center; }
    
    /* Table styles */
    table { 
        border-collapse: collapse; 
        width: 100%; 
        margin: 20px 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    
    th, td { 
        padding: 12px 8px; 
        border: 1px solid #ddd;
        text-align: center;
    }
    
    /* Row background colors */
    .even-row { background-color: #ffffff; }
    .odd-row { background-color: #f0f0f0; }
    .blue-bg { background-color: #add8e6; }
    .green-bg { background-color: #90EE90; }
    .purple-bg { background-color: #DDA0DD; }
    .red-bg { background-color: #FFB6C6; }
    .yellow-bg { background-color: #FFFF99; }
    .cayenne-bg { background-color: #E3735E; }
    
    /* Dropdown styles */
    .dropdown-trigger {
        color: blue;
        text-decoration: none;
        cursor: pointer;
    }

    .dropdown-list {
        display: none;
        position: absolute;
        background-color: white;
        border: 1px solid #ddd;
        z-index: 1000;
        padding: 5px;
    }
    </style>

    <script>
    function net_by_number(s) {
        if(s) {
            $.ajax({
                type: "GET",
                url: "getkind.php",  
                data: {q: s},
                success: function(html) {
                    var remarks = 'Net No: '+s+', '+html;
                    $("#remarks").html(remarks);
                    $("#remarks").removeClass("hidden");
                },
                error: function() {
                    alert('Last Query Failed, try again.');
                }
            });
                    
            showActivities(s);
            
            $(".ckin1").addClass("hidden");
            $("#closelog").addClass("hidden");
            $("#cs1").addClass("hidden");
            $("#Fname").addClass("hidden");
            $("#newbttn").addClass("hidden");
            $(".tohide").addClass("hidden");
        }
    }

    $(document).ready(function() {
        $('.dropdown-on-NetID').each(function() {
            var container = $(this);
            var link = container.find('.dropdown-trigger');
            var select = container.find('.dropdown-list');

            link.on('mouseenter', function() {
                var linkOffset = link.offset();
                var linkHeight = link.outerHeight();

                select.css({
                    'display': 'block',
                    'top': linkHeight + 'px',
                    'left': '0'
                });
            });

            container.on('mouseleave', function() {
                select.css('display', 'none');
            });

            select.on('change', function() {
                var selectedOption = select.find('option:selected');
                var value = selectedOption.val();
                var netID = link.text();

                if (value === "browse_net") {
                    net_by_number(netID);
                } else if (value) {
                    window.open(value, '_blank');
                }
                select.css('display', 'none');
            });
        });
    });
    </script>
</head>
<body>

<?php
require_once "NCMStats.php";        
require_once "dbConnectDtls.php";  

// Your original SQL query
$sql = $db_found->prepare("
    SELECT
    CASE WHEN nl.subNetOfID <> 0 THEN CONCAT(nl.subNetOfID, '/', nl.netID)
        ELSE nl.netID END AS netID,
    CONVERT_TZ(nl.logdate,'+00:00','-05:00') AS logdate,
    CONCAT(nl.netcall, '<br>', nl.activity) AS netcall_activity,
    nl.stations,  -- This was failing because stations wasn't defined
    nl.frequency,
    nl.logclosedtime,
    subquery.First_Login,
    CASE WHEN nl.pb = '1' THEN 'blue-bg' ELSE '' END AS PBcss,
    CASE WHEN nl.logclosedtime IS NULL THEN 'green-bg' ELSE '' END AS LCTcss,
    CASE WHEN nl.netcall IN ('TEST', 'TE0ST', 'TEOST', 'TE0ST') OR nl.netcall LIKE '%test%' 
        THEN 'purple-bg' ELSE '' END AS TNcss,
    CASE WHEN nl.stations = 1 THEN 'red-bg' ELSE '' END AS CCss,
    CASE WHEN nl.facility <> '' THEN 'yellow-bg' ELSE '' END as FNcss,
    CASE WHEN nl.subNetOfID <> 0 THEN 'cayenne-bg' ELSE '' END AS SNcss
FROM (
    SELECT 
        netID,
        subNetOfID,
        logdate,
        netcall,
        activity,
        frequency,
        logclosedtime,
        pb,
        facility,
        COUNT(*) AS stations  -- Added this back
    FROM NetLog
    WHERE DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY netID  -- Added GROUP BY
) AS nl
LEFT JOIN (
    SELECT netID, SUM(firstLogin) AS First_Login
    FROM NetLog
    WHERE DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY netID
) AS subquery ON nl.netID = subquery.netID
ORDER BY nl.netID DESC
");

$sql->execute();
$nets = $sql->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>7 Day NCM Activity Report</h1>";

if (!empty($nets)) {
    echo '<table>';
    
    // Table Headers
    echo '<tr>';
    echo '<th>Net ID</th>';
    echo '<th>Log Date</th>';
    echo '<th>Net Call<br/>Activity</th>';
    echo '<th>Stations</th>';
    echo '<th>Frequency</th>';
    echo '<th>Closed Time</th>';
    echo '<th>First Logins</th>';
    echo '<th>Open</th>';
    echo '<th>Close</th>';
    echo '</tr>';
    
    $currentDate = null;

    foreach ($nets as $rowIndex => $row) {
        $localLogDate = date('Y-m-d', strtotime($row['logdate']));
        
        // Let's start with just a simple date check and row
        if ($currentDate !== $localLogDate) {
            echo '<tr class="date-row">';
            echo '<td colspan="2">' . $localLogDate . ' (' . date('l', strtotime($localLogDate)) . ')</td>';
            echo '<td colspan="7"></td>';
            echo '</tr>';
            
            $currentDate = $localLogDate;
        } // End if

        // Regular row display
        $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
        if (!empty($row['LCTcss'])) $rowClass = $row['LCTcss'];
        if (!empty($row['TNcss'])) $rowClass = $row['TNcss'];
        if (!empty($row['CCss'])) $rowClass = $row['CCss'];
        if (!empty($row['PBcss'])) $rowClass = $row['PBcss'];
        if (!empty($row['FNcss'])) $rowClass = $row['FNcss'];
        if (!empty($row['SNcss'])) $rowClass = $row['SNcss'];

        echo '<tr class="' . $rowClass . '">';
        
        // NetID with dropdown
        echo '<td class="centered">';
        echo '<div class="dropdown-on-NetID">';
        echo '<a href="javascript:void(0);" class="dropdown-trigger">' . $row['netID'] . '</a>';
        echo '<select class="dropdown-list">';
        echo '<option disabled selected>Choose</option>';
    } // End foreach
        
        foreach ($dropdownOptions as $key => $value) {
            if ($key === "browse_net") {
                echo '<option value="browse_net">' . $value . '</option>';
            } else {
                echo '<option value="' . $value[1] . $row['netID'] . '">' . $value[0] . '</option>';
            }
        }
        
        echo '</select>';
        echo '</div>';
        echo '</td>';
        
        // Other columns
        echo '<td>' . date('Y-m-d H:i:s', strtotime($row['logdate'])) . '</td>';
        echo '<td>' . $row['netcall_activity'] . '</td>';
        echo '<td>' . $row['stations'] . '</td>';
        echo '<td>' . $row['frequency'] . '</td>';
        echo '<td>' . ($row['logclosedtime'] ? date('H:i:s', strtotime($row['logclosedtime'])) : '') . '</td>';
        echo '<td>' . $row['First_Login'] . '</td>';
        echo '<td>' . ($row['Open'] ?? '') . '</td>';
        echo '<td>' . ($row['Close'] ?? '') . '</td>';
        echo '</tr>';
    }
    
           
        
        $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
        if (!empty($row['LCTcss'])) $rowClass = $row['LCTcss'];
        if (!empty($row['TNcss'])) $rowClass = $row['TNcss'];
        if (!empty($row['CCss'])) $rowClass = $row['CCss'];
        if (!empty($row['PBcss'])) $rowClass = $row['PBcss'];
        if (!empty($row['FNcss'])) $rowClass = $row['FNcss'];
        if (!empty($row['SNcss'])) $rowClass = $row['SNcss'];
        
        

        echo '<tr class="' . $rowClass . '">';
        
        // NetID with dropdown
        echo '<td class="centered">';
        echo '<div class="dropdown-on-NetID">';
        echo '<a href="javascript:void(0);" class="dropdown-trigger">' . $row['netID'] . '</a>';
        echo '<select class="dropdown-list">';
        echo '<option disabled selected>Choose</option>';
        
        foreach ($dropdownOptions as $key => $value) {
            if ($key === "browse_net") {
                echo '<option value="browse_net">' . $value . '</option>';
            } else {
                echo '<option value="' . $value[1] . $row['netID'] . '">' . $value[0] . '</option>';
            }
        }
        
        echo '</select>';
        echo '</div>';
        echo '</td>';
        
        echo '<td>' . $row['logdate'] . '</td>';
        echo '<td>' . $row['netcall_activity'] . '</td>';
        echo '<td>' . $row['stations'] . '</td>';
        echo '<td>' . $row['frequency'] . '</td>';
        echo '<td>' . $row['First_Login'] . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
}

?>

<div id="remarks" class="hidden"></div>

</body>
</html>