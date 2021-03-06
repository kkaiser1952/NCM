<?php
	// This is the Local timzone version 
	// 2020-10-14

// read the time diff from UTC for the local time
	if(!isset($_COOKIE[tzdiff])) {
    	//echo "Cookie named '" . tzdiff . "' is not set!";
    	$tzdiff = "-0:00";   // make no adjustment to the various time values
    }else { 
        $tzdiff = $_COOKIE[tzdiff]/-60;  // adjust the time values based on time zone
        $tzdiff = "$tzdiff:00";    // echo("tzdiff= $tzdiff");
    }
    
   // if (sessionStorage.getItem("tz_domain") == "UTC") { $tzdiff = "-0:00"; }
               
   $sql = ("SELECT netID
               ,MIN(status) as minstat  
               ,MIN((CONVERT_TZ(dttm,'+00:00','$tzdiff'))) AS mindttm 
               ,MIN((CONVERT_TZ(logdate,'+00:00','$tzdiff'))) AS minlogdate
               ,activity ,netcall ,frequency 
               ,MAX((CONVERT_TZ(timeout,'+00:00','$tzdiff'))) AS timeout
               ,status      /* 1 = colose, 0 = open */                                        
               ,IF(MIN(CONVERT_TZ(logdate,'+00:00','$tzdiff') IS NULL) = 0,
                   DATE(MIN(CONVERT_TZ(logdate,'+00:00','$tzdiff'))), 
                   DATE(MIN(CONVERT_TZ(dttm,'+00:00','$tzdiff')))) AS dteonly
               ,IF(MIN(CONVERT_TZ(logdate,'+00:00','$tzdiff') IS NULL) = 0,
                   DAYNAME(MIN(CONVERT_TZ(logdate,'+00:00','$tzdiff'))), 
                   DAYNAME(MIN(CONVERT_TZ(dttm,'+00:00','$tzdiff')))) AS daynm                      
               ,POSITION('Meeting' IN activity) AS meetType
               ,POSITION('Event' IN activity) AS eventType
                                           
               ,SUM(IF(timeout IS NULL, 1,0)) AS lo
               ,pb,
                  (CASE 
                     WHEN pb = '0' THEN ''
                     WHEN pb = '1' THEN 'pbBlue'
                       ELSE ''
                  END)  AS pbcolor   /* color for the open pre-built nets */
             FROM `NetLog` 
            WHERE (CONVERT_TZ(dttm,'+00:00','$tzdiff') >=    NOW() - INTERVAL 10 DAY AND pb = 1)
               OR (CONVERT_TZ(logdate,'+00:00','$tzdiff') >= NOW() - INTERVAL 10 DAY AND pb = 0)
                                                     	
             GROUP BY netID
             ORDER BY netID DESC
    	");
    	
    	
    	//echo "$sql";
   
		$firstDate = true; // put date in list
		$thisDate  = now(); // switch for firstDate
		$daynm = $act[daynm];
		$dteonly = $act[dteonly];
		$spcl = ""; 
		//$status = $act[status];
		//$logdate = 0;

	foreach($db_found->query($sql) as $act) {

      // Open nets are green, Open PB nets are blue, All else have no color
      $pbcolor = '';
      	 if ($act[minstat] < $act[lo]) { 
          	 $pbcolor = 'green'; 
         }if (($act[minstat] < $act[lo]) AND ($act[pb] > 0)) {
             $pbcolor = 'pbBlue';
         }
         
         // We want to know if its a meeting or event so we can set the 'spcl' as a class in the listing
         // This will give us the ability to eventually show the email and phone columns via cookieManagement.js
         if ($act[meetType] > 0 || $act[eventType] > 0) {
             $spcl = "spcl";
         }else{
             $spcl = ""; 
         }
      
       switch ($act[pb]) {
          case 0;   // Not a pre-built
           	$activity = preg_replace('/\s\s+/', ' ', $act[activity]);
           	$dteonly = $act[dteonly];
           	$logdate = "of $dteonly";
           	$daynm = $act[daynm]; 
          break;
          case 1:   // Is a pre-built
          	$activity = preg_replace('/\s\s+/', ' ', $act[activity]);
          	$activity = preg_replace("/Event/","",$activity);
          	$logdate = "created $act[mindttm]";
          	$daynm = "Pre-Built Net(s) For:";
          	//$dteonly = "Future";
          	$dteonly = "$thisDate";		              
          break;
       } // End switch
         	
        // firstDate and thisDate are used as tests allowing us to put the date betweebn nets 
         if ($thisDate == $act[dteonly] ) {
            $firstDate = false;
        } else {$firstDate = true;}
            
        if ($firstDate) {   // Creates the day of week and date seperator 
            $thisDate = "$act[dteonly]"; //2017-10-20
            echo("<option disabled style='color:blue; font-weight:bold'>
            --------------- $daynm --- Local TZ --- $dteonly ----------------------</option>\n");
        } 
        
        // For Pre-Built, future events
        if ($act[pb] = 1 AND $act[logdate] > NOW() ) {
            echo("<option disabled style='color:blue; font-weight:bold'>--------- Future Event --------
            </option>\n");
        }

            echo ("<option data-net-status=\"$act[minstat]\" value=\"$act[netID]\" class=\" $pbcolor $spcl \">
            	$act[netcall], Net #: $act[netID] --> $activity $logdate </option>\n");   
            	
                   	
    } // End foreach  
?>
