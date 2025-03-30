<?php
// getactivities_sse.php - SSE-optimized version for AJAX updates
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "dbConnectDtls.php";    

$q = intval($_GET['q']); 

// Read timezone difference
if(!isset($_COOKIE[tzdiff])) {
    $tzdiff = "0:00"; // Default to UTC
} else { 
    $tzdiff = $_COOKIE[tzdiff]/-60; 
    $tzdiff = "$tzdiff:00";
}

// Time elapsed function
function time_elapsed_A($secs){
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
    );
        
    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;
        
    return join(' ', $ret);
}

// Start the activity log container
echo "<div id='sse-update-container'>";

if ($q != 0) {
    // Get initial net info (similar to original getactivities.php)
    $childCnt = 0;   
    $children = "";
    
    $sql = "SELECT subNetOfID as parent, 
                  GROUP_CONCAT(DISTINCT netID SEPARATOR ', ') as child
             FROM NetLog
            WHERE subNetOfID = $q
              AND netID <> 0
            ORDER BY netID";
             
    $stmt = $db_found->prepare($sql);
    $stmt->execute();
    $children = $stmt->fetchColumn(1);
        
    $sql2 = "SELECT sec_to_time(sum(timeonduty)) as tottime, activity, pb
             FROM NetLog 
             WHERE netID = '$q' 
             GROUP BY netID";
    $stmt2 = $db_found->prepare($sql2);
    $stmt2->execute();
    $tottime = $stmt2->fetchColumn(0);
        
    $stmt2->execute();
    $activity = trim($stmt2->fetchColumn(1)); 

    $stmt2->execute();
    $prebuilt = $stmt2->fetchColumn(3); 
        
    // Get netcall and organization type
    $sql = "SELECT netcall FROM NetLog WHERE netID = $q LIMIT 1";
    $stmt = $db_found->prepare($sql);
    $stmt->execute();
    $netcall = $stmt->fetchColumn(0);
    
    $sql = "SELECT orgType, columnViews
             FROM NetKind
            WHERE `call` = '$netcall' 
            LIMIT 0,1";
    $stmt = $db_found->prepare($sql);
    $stmt->execute();
    $orgType = $stmt->fetchColumn(0);
    $stmt->execute();
    $theCookies = $stmt->fetchColumn(1);
    
    include "headerDefinitions.php";
    
    // Get frequency and status
    $isopen = 0;
    $stmt = $db_found->prepare("SELECT frequency, MIN(status) as minstat, MIN(logdate) as startTime, MAX(timeout) as endTime
                         FROM `NetLog` 
                        WHERE netID = $q
                          AND frequency <> ''
                          AND frequency NOT LIKE '%name%'
                         LIMIT 0,1");
    $stmt->execute();
    $result = $stmt->fetch();
    $freq = $result['frequency'];
    $isopen = $result['minstat'];
    
    if ($isopen == 1) {
        $nowtime = strtotime($result['endTime']);
        $startTime = $result['startTime'];
        echo "<span style='color:red; float:left;'>$netcall ==> This Net is Closed, not available for edit</span>";
    } else if ($isopen == 0) {
        $nowtime = time(); 
        $startTime = $result['startTime'];
    }
    
    // Main query to get net activity
    $g_query = "SELECT recordID, netID, subNetOfID, id, ID, 
                  TRIM(callsign) AS callsign, tactical,  
                  TRIM(BOTH ' ' FROM Fname) as Fname, 
                  /* Rest of your query columns */
                FROM NetLog 
                WHERE netID = $q
                ORDER BY /* Your ordering clauses */";
                
    // Table counter variables
    $trafficKey = 0;
    $logoutKey = 0;
    $digitalKey = 0;
    $brbKey = 0;
    $ioKey = 0;
    $noCallKey = 0;
    $dupeCallKey = 0;
    $num_rows = 0;
    $cnt_status = 0;
    $subnetkey = 0;
    $pbStat = 0;
    $bandkey = 0;
    $cs1Key = 0;
    $editCS1 = "";
    
    include "dropdowns.php";
    
    // Output the table structure
    echo "<table id='actLog'>";
    echo "<tbody class='sortable' id='netBody'>";
    
    // Loop through records
    foreach($db_found->query($g_query) as $row) {
        ++$num_rows;
        
        $pbStat = $row['pbStat'] + $pbStat;
        
        if ($row['subNetOfID'] > 0) {
            $subnetkey = 1;
            $subnetnum = "$row[subNetOfID]";
        }
        
        if ($row['pb'] == 1) {
            $editCS1 = "editCS1";
        }
        
        $cnt_status = $cnt_status + $row['status'];
        $brbCols = "                 ";
        
        // Set colors
        $cs1Cols = $modCols = $brbCols = $badCols = $newCall = $timeline = $important1 = $important2 = '';
        $f = '<font color="black">';
        
        include "colColorAssign.php";
        
        $id = str_pad($row['id'], 2, '0', STR_PAD_LEFT);
        
        echo ("<tr id=\"$row[recordID]\">");
        
        // Comments cell class
        $class = empty($row['comments']) ? 'nonscrollable' : 'scrollable';
        $class = strlen($row['comments']) < 300 ? 'nonscrollable' : 'scrollable';
        
        // Facility grouping
        $newFacility = trim("$row[facility]");
        
        if ($row['netcall'] == 'MYOWN') {
            $orgType = 'FACILITY';
        }
        
        if (TRIM($orgType) == 'FACILITY' AND $newFacility !== $usedFacility AND $row['facility'] !== '') {
            if ($row['active'] == 'OUT') {
                $color = 'red';
            } else if($row['active'] == 'In') {
                $color = 'green';
            }
            
            echo "</tbody><tbody id=\"netBody\">
                <tr>
                    <td></td><td></td><td></td><td></td><td></td>
                    <td colspan=6 style='color:$color;font-weight:900;font-size:14pt;'>$row[facility]</td>
                </tr>
                </tbody><tbody class=\"sortable\" id=\"netBody\">";
                
            $usedFacility = $newFacility;
        }
        
        // Include row definitions
        include "rowDefinitions.php";
    }
    
    // Calculate runtime
    $runtime = time_elapsed_A($nowtime - strtotime($startTime));
    
    // Table footer
    echo "</tr></tbody>
          <tfoot>
          <tr>
            <td></td>
            <td class='runtime' colspan='5' align='left'>Run Time: $runtime </td>
            <td class='tvh' colspan='8' align='right'>Total Volunteer Hours = $tottime</td>
          </tr>
          </tfoot>
          </table>";
          
    // Hidden variables
    echo "<div hidden id='freq2'>$row[frequency]</div>";
    echo "<div hidden id='freq'></div>";
    echo "<div hidden id='cookies'>$theCookies</div>";
    echo "<div hidden id='type'>Type of Net: $row[activity]</div>";
    echo "<div hidden id='idofnet'>$row[netID]</div>";
    echo "<div hidden id='activity'>$row[activity]</div>";
    echo "<div hidden id='domain'>$row[netcall]</div>";
    echo "<div hidden id='thenetcallsign'>$row[netcall]</div>";
    echo "<div hidden id='isopen' val=$isopen>$isopen</div>";
    echo "<div hidden id='ispb'>$row[pb]</div>";
    echo "<div hidden id='pbStat'>$pbStat</div>";
    
    // Status indicators
    echo "<span id='add2pgtitle'>#$row[netID]/$row[netcall]/$freq&nbsp;&nbsp;";
    
    if ($subnetkey == 1) {
        echo "<button class='subnetkey' value='$subnetnum'>Sub Net of: $subnetnum</button>&nbsp;&nbsp;";
    }
    
    if ($children) {
        echo "<button class='subnetkey' value='$children'>Has Sub Net: $children</button>&nbsp;&nbsp;";
    }
    
    echo "<span STYLE='background-color: #befdfc'>Control</span>&nbsp;&nbsp;";
    
    // Status indicators
    if ($digitalKey == 1) {
        echo "<span class='digitalKey'>Digital</span>&nbsp;&nbsp;";
    }
    
    if ($trafficKey == 1) {
        echo "<span class='trafficKey'>Traffic</span>&nbsp;&nbsp;";
    }
    
    if ($logoutKey   == 1 ) { echo ("<span class='logoutKey'  >Logged Out</span>&nbsp;&nbsp;");} 
	  if ($brbKey 	   == 1 ) { echo ("<span class='brbKey'     >BRB</span>&nbsp;&nbsp;");} 
	  if ($ioKey 	   == 1 ) { echo ("<span class='ioKey'      >In-Out</span>&nbsp;&nbsp;");}
	  if ($noCallKey   == 1 ) { echo ("<span class='redKey'     >Call Error</span>&nbsp;&nbsp;");}
	  if ($redKey	   == 1 ) { echo ("<span class='redKey'     >Call Error</span>&nbsp;&nbsp;");}
	  if ($dupeCallKey == 1 ) { echo ("<span class='redKey'     >Duplicate</span>&nbsp;&nbsp;");}
	  if ($fliKey      == 1 ) { echo ("<span class='fliKey'     >New Call</span>&nbsp;&nbsp;");}
	  if ($prioritykey == 1 ) { echo ("<span class='redKey'     >Priority</span>&nbsp;&nbsp;");}
	  if ($cs1Key      == 1 ) { echo ("<span class='deltakey' title='One of the location values (lat, lon, w3w, grid) changed.'>Location &#916</span>");}
	  
	  echo ("<span class='export2CSV' style='padding-left: 10pt;'>
	  <a href=\"#\" onclick=\"window.open('netCSVdump.php?netID=' + $('#idofnet').html())\" >Export CSV</a></span>
	  <span style='padding-left: 5pt;'>
	  <a href=\"#\" id=\"geoDist\" onclick=\"geoDistance()\" title=\"geoDistance\"><b style=\"color:green;\">geoDistance</b></a></span>
	  <span style='padding-left: 5pt;'>
	  <a href=\"#\" id=\"mapIDs\" onclick=\"map2()\" title=\"Map This Net\"><b style=\"color:green;\">Map This Net</b></a>
	  </span>");
    
    echo "</span>";
    echo "<div hidden id='logstatus'>$row[status]</div>";
}

echo "</div>"; // Close container
?>