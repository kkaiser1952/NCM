<?php
// ShortCutNCMStats.php

function convertSecToTime($sec)
{
    $date1 = new DateTime("@0");
    $date2 = new DateTime("@$sec");
    $interval = date_diff($date1, $date2);
    //$parts = ['years' => 'y', 'months' => 'm', 'days' => 'd', 'hours' => 'h', 'min.' => 'i', 'sec.' => 's'];
    $parts = ['years' => 'y', 'months' => 'm', 'days' => 'd', 'hours' => 'h'];
    $formatted = [];
    foreach($parts as $i => $part)
    {
        $value = $interval->$part;
        if ($value !== 0)
        {
            if ($value == 1){
                $i = substr($i, 0, -1);
            }
            $formatted[] = "$value $i";
        }
    }

    if (count($formatted) == 1)
    {
        return $formatted[0];
    }
    else
    {
        $str = implode(', ', array_slice($formatted, 0, -1));
        $str.= ' and ' . $formatted[count($formatted) - 1];
        return $str;
    }
}

require_once "dbConnectDtls.php";

$sql = "SELECT COUNT( callsign ) AS logins
        ,COUNT( IF(comments LIKE '%first log in%',1,NULL) ) AS newb
        ,COUNT( DISTINCT netID ) AS netCnt
        ,max(recordID) AS records
        ,SUM(timeonduty) AS TOD
        ,COUNT( DISTINCT LEFT(grid, 6 )) AS gridCnt
        ,COUNT( DISTINCT county ) AS countyCnt
        ,COUNT( DISTINCT state ) AS stateCnt
        ,COUNT( DISTINCT callsign) AS cscount
        ,COUNT( DISTINCT netcall) AS netcall
        FROM NetLog
        WHERE netID <> 0
        AND activity NOT LIKE '%TEST%'";

$stmt = $db_found->prepare($sql);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

$logins = $results['logins'];
$newb = $results['newb'];
$netCnt = $results['netCnt'];
$records = number_format($results['records'], 0);
$tod = $results['TOD'];
$gridCnt = $results['gridCnt'];
$countyCnt = $results['countyCnt'];
$stateCnt = $results['stateCnt'];
$cscount = $results['cscount'];
$netcall = $results['netcall'];

$volHours = convertSecToTime($tod);

$sql3 = "SELECT count(DISTINCT org) as orgCnt FROM `NetKind`";
$stmt = $db_found->prepare($sql3);
$stmt->execute();
$orgCnt = $stmt->fetchColumn(0);

// Generate the HTML output
echo '<div style="font-family: Arial, sans-serif; padding: 20px;">';
echo '<h2>V1 NCM Statistics</h2>';
echo '<table style="border-collapse: collapse; width: 100%;">';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Total Logins:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $logins . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>New Logins:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $newb . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Nets:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $netCnt . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Records:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $records . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Volunteer Hours:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $volHours . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Grids:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $gridCnt . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Counties:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $countyCnt . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>States:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $stateCnt . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Unique Stations:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $cscount . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Distinct Net Names:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $netcall . '</td></tr>';
echo '<tr><td style="padding: 10px; border: 1px solid #ccc;"><strong>Organizations:</strong></td><td style="padding: 10px; border: 1px solid #ccc;">' . $orgCnt . '</td></tr>';
echo '</table>';
echo '</div>';
?>