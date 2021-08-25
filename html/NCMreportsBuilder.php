<?php

require_once "dbConnectDtls.php";

$grp 	     = strtoupper($_GET['grp']);   	    // echo("in php grp= $grp");
$reportKind  = $_GET['reportKind'];	// Week or Month, Callsign, firstLogIn
$reportType  = $_GET['reportType'];  	// All, Vonly, Donly, Monly, VandD
$reportYear  = $_GET['reportYear'];    // 2018, 2019, etc 
$reportMonth = $_GET['reportMonth'];   // 2,3,4, etc 
    if ($reportMonth == 13 ) { 
        $monthAND = "";
        $yearAND = "";
        $reportMonth = '01' ;
        $moFirst = "$reportYear-$reportMonth-01";
        $reportYear = $reportYear+1;
        //$reportMonth = '01' ;
        $next = '01';
        //$moFirst = "$reportYear-$reportMonth-01";
        
        $moLast  = "$reportYear-$next-01";
    }else {$next = 
        $reportMonth+1;
        $monthAND = "AND SUBSTR(logdate, 6, 2) = $reportMonth";
        //$reportYear = $reportYear;
        $moFirst = "$reportYear-$reportMonth-01";
        $moLast  = "$reportYear-$next-01";
        $yearAND = "AND SUBSTR(logdate, 1, 4) = $reportYear";
    }
//$monthAND    = ""; 

//echo("$reportYear");

//$moFirst = "$reportYear-$reportMonth-01";  
//$next = $reportMonth+1; 
//$moLast  = "$reportYear-$next-01";
//echo "$moFirst, $moLast";

/*
if ($reportMonth) {
    if ($reportMonth == 13) {
           $monthAND = "";
    }else {$monthAND = "AND SUBSTR(logdate, 6, 2) = $reportMonth";}
}

if ($reportYear == 'All') {
    $yearAND = "";
}else {$yearAND = "AND SUBSTR(logdate, 1, 4) = $reportYear";
    
}
*/

//echo("grp: $grp, kind: $reportKind, type: $reportType, year: $reportYear, month: $reportMonth, monthAND: $monthAND, yearAND: $yearAND");
//    grp: W0KCN, kind: Month, type: All, year: 2018, month: 11, monthAND: AND SUBSTR(logdate, 6, 2) = 11 sq
//    grp: CARROLL, kind: callsign, type: All, year: 2019, month: 13, monthAND:

// Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

if ($reportKind == 'Month' ){
// Month rollup report

echo"<table>
    <tr>
        <th>#</th>
        <th>netID   </th>
<!--        <th>Net Call</th> -->
        <th>Log Date </th>
        <th>Activity</th>
        <th>Logins  </th>
        <th>First<br>Logins</th>
        <th>Credentialed<br>Stations    </th>
        <th>Volunteer<br>D:H:M:S     </th>
    </tr>
    ";
  

$sql = "
    SELECT date(t1.logdate) AS logdate, 
	   t1.netcall, t1.netID, t1.activity,
	   COALESCE (t1.netID, 
	   CONCAT(MONTHNAME(MIN(t1.logdate)),' Total')) AS netID2,
       COUNT(t1.ID)                    AS logins,
       SUM(firstLogin)                 AS fstLogins, 
       SUM(timeonduty)                 AS tod,
       COUNT( IF(t1.creds <> '',1,NULL) ) AS creds,
	   month(t1.logdate) AS month
       FROM (SELECT DISTINCT
                    t2.netid
                    FROM NetLog t2
                    WHERE t2.netcall LIKE '%$grp%'  
                          AND t2.logdate >= '$moFirst'
                          AND t2.logdate < '$moLast') x
            INNER JOIN NetLog t1
                       ON t1.netID = x.netID
                    WHERE date(t1.logdate) <> 0
     GROUP BY year(t1.logdate), month, netID WITH ROLLUP
";
 
//echo("sql: $sql");

$c = 0; // counter

foreach($db_found->query($sql) as $rpt) {
    $c = $c + 1;
	    $TOD = secondsToDHMS($rpt[tod]); //echo("new tod= $TOD <br><br>");
	        if ($rpt[fstLogins] == 0) {$fstLogins = null;
	        }else {$fstLogins = $rpt[fstLogins];}
	        
	     $hiliteit = '';
	        if ($rpt[netID] == 'Month Total'){
    	        $hiliteit = 'greyon';
	        }
	     
    echo "<tr>

        <td >$c</td>
        <td class='$hiliteit'>$rpt[netID2]   </td>
<!--        <td>$rpt[netcall] </td> -->
        <td class='$hiliteit'>$rpt[logdate] </td>
        <td class='$hiliteit'>$rpt[activity]</td>
        <td class='$hiliteit'>$rpt[logins]  </td>
        <td class='$hiliteit'>$fstLogins</td>
        <td class='$hiliteit'>$rpt[creds]    </td>
        <td class='$hiliteit'>$TOD     </td>
    </tr>";	    
} // End foreach of Month rollup reports

echo "</table>";

} else if ($reportKind == 'callsign') {  // End of rollup reports, start of callsign reports
  
    $tableHead = "<dl><dd>
              <table style='width:100%'>
              <tr><th>Call and Name</th>    <th>Logins</th> <th>First</th> <th>Creds</th> <th>Volunteer<br>D:H:M:S</th></tr>
    ";  
    $tableEnd = "</table></dd></dl>";

$sql = "
    SELECT date(logdate)                   AS logdate, 
           CONCAT(Fname,' ',Lname)         AS name,
           callsign, 
           netcall, 
           netID, 
           
           activity,
           COALESCE (netID,'Month Total')  AS netID,
           COUNT( ID)                      AS logins, 
           SUM(firstLogin)                 AS fstLogins, 
           SUM(timeonduty)                 AS tod, 
           creds,
           month(logdate)                  AS month

      FROM NetLog
     WHERE netcall like '%$grp%' 
       AND netID <> 0
       $yearAND
       $monthAND
    GROUP BY
     YEAR(logdate) ,netID, MONTH(logdate), callsign WITH ROLLUP
";

//echo("sql: $sql");
/*
SELECT date(logdate) AS logdate, CONCAT(Fname,' ',Lname) AS name, callsign, netcall, netID, activity, COALESCE (netID,'Month Total') AS netID, COUNT( ID) AS logins, SUM(firstLogin) AS fstLogins, SUM(timeonduty) AS tod, creds, month(logdate) AS month FROM NetLog WHERE netcall like '%K4EOC%' AND netID <> 0 GROUP BY YEAR(logdate) ,netID, MONTH(logdate), callsign WITH ROLLUP
*/
$row = 0; 
foreach($db_found->query($sql) as $rpt) {
    $row = $row + 1;
        
        if ($row == 1) {
            echo "<dl>
                  <dt>$rpt[netID] $rpt[netcall] $rpt[logdate] $rpt[activity] </dt>
                  <dd><table style='width:100%'>
                    $tableHead";
        }
    
        $TOD = secondsToDHMS($rpt[tod]); //echo("new tod= $TOD <br><br>");
        $logins = $rpt[logins];
        $fstLogins = $rpt[fstLogins];
        
            if ($rpt[fstLogins] == 0) {$fstLogins = null;
            }else {$fstLogins = $rpt[fstLogins];}
            
            if ($logins == 1) { $logins = null;}
            if ($fstLogins > 0) {$fstLogins = 'Yes';}       
    
       echo "<tr><td style='width:20%;'>$rpt[callsign] $rpt[name]</td>
                 <td style='width:5%;'>$logins</td>
                 <td style='width:5%;'>$fstLogins</td>
                 <td style='width:20%;'>$rpt[creds]</td>
                 <td style='width:10%;'>$TOD</td>
            </tr>";
    
} // End foreach of callsign reports
    echo "$tableEnd"; 
//} // End of callsign report
} else if ($reportKind == 'firstLogIn') {  // End of callsign reports, start of first logins reports
    echo("inside first logins report");
} // End of first logins report

?>