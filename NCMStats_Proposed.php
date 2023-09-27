<?php
// Used by help.php
// 2023-09-26

if (!$db_found) { require_once "dbConnectDtls.php";
    //die("Error: Database connection is not established. Check database credentials. <-- From buildOptionsForSelect_Proposed.php");
}

function convertSecToTime($sec)
{
    $date1 = new DateTime("@0");
    $date2 = new DateTime("@$sec");
    $interval = date_diff($date1, $date2);
    $parts = ['years' => 'y', 'months' => 'm', 'days' => 'd', 'hours' => 'h'];
    $formatted = [];
    foreach ($parts as $i => $part) {
        $value = $interval->$part;
        if ($value !== 0) {
            if ($value == 1) {
                $i = substr($i, 0, -1);
            }
            $formatted[] = "$value $i";
        }
    }

    if (count($formatted) == 1) {
        return $formatted[0];
    } else {
        $str = implode(', ', array_slice($formatted, 0, -1));
        $str .= ' and ' . $formatted[count($formatted) - 1];
        return $str;
    }
}

// echo convertSecToTime(175926108);

require_once "dbConnectDtls.php";

// Logins 10519 newb 559 netCnt 709 allCnt 283940 TOD 838:59:59
$sql = "SELECT COUNT(callsign) AS callsigns,
               COUNT(IF(comments LIKE '%first log in%', 1, NULL)) AS newb,
               COUNT(DISTINCT netID) AS netCnt,
               max(recordID) AS records,
               SUM(timeonduty) AS TOD,
               COUNT(DISTINCT LEFT(grid, 6)) AS gridCnt,
               COUNT(DISTINCT county) AS countyCnt,
               COUNT(DISTINCT state) AS stateCnt,
               COUNT(DISTINCT callsign) AS cscount,
               COUNT(DISTINCT netcall) AS netcall
          FROM NetLog
         WHERE netID <> 0
           AND activity NOT LIKE '%TEST%'
";
$stmt = $db_found->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$callsigns = $row['callsigns'];
$newb = $row['newb'];
$netCnt = $row['netCnt'];
$records = $row['records'];
$records = number_format($records, 0);
$tod = $row['TOD'];
$gridCnt = $row['gridCnt'];
$countyCnt = $row['countyCnt'];
$stateCnt = $row['stateCnt'];
$cscount = $row['cscount'];
$netcall = $row['netcall'];

$volHours = convertSecToTime($tod);

$sql3 = "SELECT count(DISTINCT org) as orgCnt FROM `NetKind`";
$stmt = $db_found->prepare($sql3);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$orgCnt = $row['orgCnt'];

// echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";

?>
