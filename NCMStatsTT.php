<?php
	
function convertSecToTime($sec)
{
    $date1 = new DateTime("@0");
    $date2 = new DateTime("@$sec");
    $interval = date_diff($date1, $date2);
    $parts = ['years' => 'y', 'months' => 'm', 'days' => 'd', 'hours' => 'h', 'min.' => 'i', 'sec.' => 's'];
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
$stmt = $db_found->prepare("
    SELECT  COUNT( DISTINCT callsign ) AS cscount
    	   ,COUNT( callsign )            AS callsigns
    	   ,COUNT( IF(comments LIKE '%first log in%',1,NULL) ) AS newb
    	   ,COUNT( DISTINCT netID )	     AS netCnt
           ,COUNT( DISTINCT grid )       AS gridCnt
           ,COUNT( DISTINCT county )     AS countyCnt
           ,COUNT( DISTINCT state )      AS stateCnt
    	   ,max(recordID)                AS records
    	   ,SUM(timeonduty)              AS TOD
      FROM NetLog
     WHERE netID <> 0 
       AND activity NOT LIKE '%TEST%'
    ";
		
    $stmt->execute();
        $result = $stmt->fetch();
            $callsigns  = $result[callsigns];    
            $newb       = $result[newb];
            $netCnt     = $result[netCnt];
            $records    = $result[records];
            $cscount    = $result[cscount];
            $gridcount  = $result[gridCnt];
            $countycount= $result[countyCnt];
            $statecount = $result[stateCnt];
            $tod		= $result[TOD];
            $volHours   = convertSecToTime($tod); 

		
$sql3 = "SELECT count(DISTINCT org) as orgCnt FROM `NetKind`";
	$stmt = $db_found->prepare($sql3);
		$stmt -> execute();
		$orgCnt  = $stmt->fetchColumn(0);      	  
     	//  echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";
     	                  
?>