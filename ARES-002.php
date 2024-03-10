<!doctype html>

<!-- Monthly DEC/EC Report -->
<!-- Written for Kansas City Northland ARES -->

<?php 

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);


require_once "dbConnectDtls.php";

$year = 2023;
$month = 7;
$netcall = 'w0kcn';

$sql = "SELECT netID,
               COUNT(callsign) AS `ARES_Members`, 
               SEC_TO_TIME(SUM(timeonduty)) AS `total_time_on_duty`,
               TIME_FORMAT(SEC_TO_TIME(SUM(timeonduty)), '%H:%i') AS `total_time_on_duty_hm`,
               COUNT(DISTINCT activity) AS distinct_activity,
               activity as activity
        FROM NetLog
        WHERE YEAR(logdate) = ?
        AND MONTH(logdate) = ?
        AND netcall = ?
        GROUP BY callsign";

$stmt = $db_found->prepare($sql);
$stmt->execute([$year, $month, $netcall]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$ARES_Members = $result['ARES_Members'];
$total_time_on_duty = $result['total_time_on_duty'];
$total_time_on_duty_hm = $result['total_time_on_duty_hm'];
$distinct_activity = $result['distinct_activity'];

echo "ARES Members: $ARES_Members<br>\n";
echo "Total Time on Duty: $total_time_on_duty<br>\n";
echo "Total Time on Duty (H:M): $total_time_on_duty_hm<br>\n";
echo "Distinct Activity Count: $distinct_activity\n";


?>
