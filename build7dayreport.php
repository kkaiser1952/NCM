<?php 
    // The purpose of this page/program is to create a 7 day report of NCM activites.
    // Written: 2023-06-21, first day of summer    
    // Updated: 2024-06-15    

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $dropdownOptions = [
        "browse_net" => "Browse Net",
        "map" => ["Map Net", "https://net-control.us/map.php?NetID="],
        "ics214" => ["ICS-214", "https://net-control.us/ics214.php?NetID="],
        "ics309" => ["ICS-309", "https://net-control.us/ics309.php?NetID="],
        "ics205a" => ["ICS-205A", "https://net-control.us/ics205A.php?NetID="],
        "timeline" => ["TimeLine", "https://net-control.us/HzTimeline.php?NetID="]
    ];  // End $dropdownOptions array

    require_once "NCMStats.php";        
    require_once "dbConnectDtls.php";  

    // Get the main data with all the necessary fields
    $sql = $db_found->prepare("
        SELECT
            CASE WHEN nl.subNetOfID <> 0 THEN CONCAT(nl.subNetOfID, '/', nl.netID)
                ELSE nl.netID END AS netID,
            CONVERT_TZ(nl.logdate,'+00:00','-05:00') AS logdate,
            CONCAT(nl.netcall, '<br>', nl.activity) AS netcall_activity,
            nl.stations,
            nl.frequency,
            nl.logclosedtime,
            subquery.First_Login,
            CASE WHEN nl.pb = '1' THEN 'blue-bg' ELSE '' END AS PBcss,
            CASE WHEN nl.logclosedtime IS NULL THEN 'green-bg' ELSE '' END AS LCTcss,
            CASE WHEN nl.netcall IN ('TEST', 'TE0ST', 'TEOST', 'TE0ST') 
                OR nl.netcall LIKE '%test%' THEN 'purple-bg' ELSE '' END AS TNcss,
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
                COUNT(*) AS stations
            FROM NetLog
            WHERE DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY netID
        ) AS nl
        LEFT JOIN (
            SELECT netID, SUM(firstLogin) AS First_Login
            FROM NetLog
            WHERE DATE(CONVERT_TZ(logdate,'+00:00','-05:00')) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY netID
        ) AS subquery ON nl.netID = subquery.netID
        ORDER BY nl.netID DESC
    ");  // End SQL preparation

    $sql->execute();
    $nets = $sql->fetchAll(PDO::FETCH_ASSOC);

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
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    
    /* Row colors */
    .even-row { background-color: #ffffff; }
    .odd-row { background-color: #f0f0f0; }
    .blue-bg { background-color: #add8e6; }
    .green-bg { background-color: #90EE90; }
    .purple-bg { background-color: #DDA0DD; }
    .red-bg { background-color: #FFB6C6; }
    .yellow-bg { background-color: #FFFF99; }
    .cayenne-bg { background-color: #E3735E; }
    
    /* Date row styling */
    .date-row {
        background-color: #f8f8f8;
        font-weight: bold;
        font-size: 1.1em;
    }
    
    /* Center specific columns */
    .centered { text-align: center; }
    </style>
</head>
<body>
    <h1>7 Day NCM Activity Report</h1>

    <?php
    if (!empty($nets)) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Net ID</th>";
        echo "<th>Log Date</th>";
        echo "<th>Net Call</th>";
        echo "<th>Stations</th>";
        echo "<th>Frequency</th>";
        echo "<th>Closed Time</th>";
        echo "<th>First Logins</th>";
        echo "</tr>";

        $currentDate = null;

        foreach ($nets as $rowIndex => $row) {
            // Handle date grouping
            $localLogDate = date('Y-m-d', strtotime($row['logdate']));
            
            if ($currentDate !== $localLogDate) {
                echo '<tr class="date-row">';
                echo '<td colspan="2">' . $localLogDate . ' (' . date('l', strtotime($localLogDate)) . ')</td>';
                echo '<td colspan="5"></td>';
                echo '</tr>';
                $currentDate = $localLogDate;
            }  // End if($currentDate !== $localLogDate)

            // Determine row color
            $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
            if (!empty($row['LCTcss'])) $rowClass = $row['LCTcss'];
            if (!empty($row['TNcss'])) $rowClass = $row['TNcss'];
            if (!empty($row['CCss'])) $rowClass = $row['CCss'];
            if (!empty($row['PBcss'])) $rowClass = $row['PBcss'];
            if (!empty($row['FNcss'])) $rowClass = $row['FNcss'];
            if (!empty($row['SNcss'])) $rowClass = $row['SNcss'];

            echo '<tr class="' . $rowClass . '">';
            echo '<td class="centered">' . $row['netID'] . '</td>';
            echo '<td>' . date('Y-m-d H:i:s', strtotime($row['logdate'])) . '</td>';
            echo '<td>' . $row['netcall_activity'] . '</td>';
            echo '<td class="centered">' . $row['stations'] . '</td>';
            echo '<td>' . $row['frequency'] . '</td>';
            echo '<td class="centered">' . ($row['logclosedtime'] ? date('H:i:s', strtotime($row['logclosedtime'])) : '') . '</td>';
            echo '<td class="centered">' . $row['First_Login'] . '</td>';
            echo '</tr>';
        }  // End foreach($nets)

        echo "</table>";
    } else {
        echo "<p>No data found</p>";
    }  // End if(!empty($nets))
    ?>

</body>
</html>