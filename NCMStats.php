<?php
	
	// Used by help.php
	
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

//echo convertSecToTime( 175926108);

require_once "dbConnectDtls.php";

// Logins 10519 newb 559 netCnt 709 allCnt 283940 TOD 838:59:59
$sql = "SELECT  COUNT( callsign )                	AS callsigns
	   		   ,COUNT( IF(comments LIKE '%first log in%',1,NULL) ) AS newb
	   		   ,COUNT( DISTINCT netID )				AS netCnt
	   		   ,max(recordID)						AS records
	   		   ,SUM(timeonduty)    	                AS TOD
	   		   ,COUNT( DISTINCT LEFT(grid, 6 ))     AS gridCnt
               ,COUNT( DISTINCT county )            AS countyCnt
               ,COUNT( DISTINCT state )             AS stateCnt
               ,COUNT( DISTINCT callsign)           AS cscount
               ,COUNT( DISTINCT netcall)			AS netcall
	   	  FROM NetLog
	   	 WHERE netID <> 0 
	   	   AND activity NOT LIKE '%TEST%'
";  
	$stmt = $db_found->prepare($sql);
		$stmt -> execute();
		$callsigns  = $stmt->fetchColumn(0); //echo "\n$callsigns\n";
		$stmt -> execute();
		$newb		= $stmt->fetchColumn(1); //echo "$newb\n";		
		$stmt -> execute();
		$netCnt		= $stmt->fetchColumn(2); //echo "$netCnt\n";
		$stmt -> execute();
		$records	= $stmt->fetchColumn(3); //echo "$records\n";
		$records	= number_format($records,0);
		$stmt -> execute();
		$tod		= $stmt->fetchColumn(4); //echo "$tod\n";
		$stmt -> execute();
		$gridCnt	= $stmt->fetchColumn(5);
		$stmt -> execute();
		$countyCnt	= $stmt->fetchColumn(6);
		$stmt -> execute();
		$stateCnt	= $stmt->fetchColumn(7);
		$stmt -> execute();
		$cscount    = $stmt->fetchColumn(8);
		$stmt -> execute();
		$netcall    = $stmt->fetchColumn(9);

        $volHours = convertSecToTime( $tod);	
		
$sql3 = "SELECT count(DISTINCT org) as orgCnt FROM `NetKind`";
	$stmt = $db_found->prepare($sql3);
		$stmt -> execute();
		$orgCnt  = $stmt->fetchColumn(0);      	  
     	//  echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";
     	                  
?>