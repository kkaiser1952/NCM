<?php
// This program creates the dropdown for previous net selection
// 2020-10-14

require_once "dbConnectDtls.php";

// read the time diff from UTC for the local time
if (!isset($_COOKIE['tzdiff'])) {
    $tzdiff = "-0:00";   // make no adjustment to the various time values
} else {
    $tzdiff = $_COOKIE['tzdiff'] / -60;  // adjust the time values based on the time zone
    $tzdiff = "$tzdiff:1";    // echo("tzdiff= $tzdiff");
}

// if (sessionStorage.getItem("tz_domain") == "UTC") { $tzdiff = "-0:00"; }

$sql = "SELECT netID
               ,status 
               ,activity 
               ,netcall 
               ,frequency
                /* 1 = colose, 0 = open */  
               ,MIN(status) AS minstat  
               ,MIN(CONVERT_TZ(dttm, '+00:00', :tzdiff)) AS mindttm 
               ,MIN(CONVERT_TZ(logdate, '+00:00', :tzdiff)) AS minlogdate
               ,MAX(CONVERT_TZ(timeout, '+00:00', :tzdiff)) AS timeout
                                                       
               ,IF(MIN(CONVERT_TZ(logdate, '+00:00', :tzdiff) IS NULL) = 0,
                   DATE(MIN(CONVERT_TZ(logdate, '+00:00', :tzdiff))), 
                   DATE(MIN(CONVERT_TZ(dttm, '+00:00', :tzdiff)))) AS dteonly
               ,IF(MIN(CONVERT_TZ(logdate, '+00:00', :tzdiff) IS NULL) = 0,
                   DAYNAME(MIN(CONVERT_TZ(logdate, '+00:00', :tzdiff))), 
                   DAYNAME(MIN(CONVERT_TZ(dttm, '+00:00', :tzdiff)))) AS daynm
                                         
               ,POSITION('Meeting' IN activity) AS meetType
               ,POSITION('Event' IN activity)   AS eventType
                                           
               ,SUM(IF(timeout IS NULL, 1, 0)) AS lo
               
               ,pb,
                  (CASE 
                     WHEN pb = '0' THEN ''
                     WHEN pb = '1' THEN 'pbBlue'
                       ELSE ''
                  END)  AS pbcolor   /* color for the open pre-built nets */
             FROM `NetLog` 
            WHERE (CONVERT_TZ(dttm, '+00:00', :tzdiff) >= NOW() - INTERVAL 39 DAY AND pb = 1)
               OR (CONVERT_TZ(logdate, '+00:00', :tzdiff) >= NOW() - INTERVAL 10 DAY AND pb = 0)
               OR (netID = 11117)
                                                     	
             GROUP BY netID
             ORDER BY netID DESC";

try {
    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':tzdiff', $tzdiff, PDO::PARAM_STR);
    $stmt->execute();

    $firstDate = true; // put date in list
    $thisDate  = now(); // switch for firstDate
    $spcl = "";

    while ($act = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Open nets are green, Open PB nets are blue, All else have no color
        $pbcolor = '';
        if ($act['minstat'] < $act['lo']) { 
            $pbcolor = 'green';    // for standard nets
        }
        if (($act['minstat'] < $act['lo']) && ($act['pb'] > 0)) {
            $pbcolor = 'pbBlue';   // For PB nets
        }
        
        // We want to know if it's a meeting or event so we can set the 'spcl' as a class in the listing
        // This will give us the ability to eventually show the email and phone columns via cookieManagement.js
        if ($act['meetType'] > 0 || $act['eventType'] > 0) {
            $spcl = "spcl";
        } else {
            $spcl = ""; 
        }
    
        // Test to see if this is a pre-built net 
        switch ($act['pb']) {
            case 0:   // Not a pre-built
                $activity = preg_replace('/\s\s+/', ' ', $act['activity']);
                $dteonly = $act['dteonly'];
                $logdate = "of $dteonly";
                $daynm = $act['daynm']; 
                break;
            case 1:   // This is a pre-built
                $activity = preg_replace('/\s\s+/', ' ', $act['activity']);
                $activity = preg_replace("/Event/","",$activity);
                $logdate = "For " . $act['minlogdate'];
                $daynm = "Pre-Built Net(s) For: " . $act['daynm'];
                $dteonly = date("Y/m/d", strtotime($act['minlogdate']));
                break;
        } // End switch
             
        // firstDate and thisDate are used as tests allowing us to put the date between nets 
        if ($thisDate == $act['dteonly']) {
            $firstDate = false;
        } else {
            $firstDate = true;
        }
        
        if ($firstDate) {   // Creates the day of the week and date separator 
            $thisDate = $act['dteonly']; // 2017-10-20
            
            echo("<option disabled style='color:blue; font-weight:bold'>
            --------------- $daynm ---==========--- $dteonly ----------------------</option>\n");
        } // end if firstdate 
        
        // For Pre-Built, future events
        if ($act['pb'] == 1 && strtotime($act['logdate']) > strtotime('now')) {
            echo("<option disabled style='color:blue; font-weight:bold'>--------- Future Event --------
            </option>\n");
        }

        // This is the part that gets selected
        echo ("<option data-net-status=\"" . $act['minstat'] . "\" value=\"" . $act['netID'] . "\" class=\" " . $pbcolor . " " . $spcl . "\">
            " . $act['netcall'] . ", Net #: " . $act['netID'] . " --> " . $activity . " " . $logdate . " </option>\n");  
    } // End foreach
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
