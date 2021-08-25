<?php
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
    $netID = 3681;
    
// Count how many unique minute by grouped minutes
$sql = (" 
    DROP TABLE ncm.temp_hrmn;
    
    CREATE TABLE ncm.temp_hrmn    

    SELECT CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
       FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0)) AS hrmn,
                
       COUNT(CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
       FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0))) AS hrmncount
       
      FROM TimeLog
     WHERE netID = $netID AND callsign NOT LIKE '%genc%' AND callsign NOT LIKE '%weather%'
     GROUP BY CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
              FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0));
              
");

$db_found->exec($sql);

$sql = ("
    SELECT 
        timestamp,
        callsign, 
        b.hrmncount as hrmncount,
        date_format(timestamp,'%i') as mn,
        
        CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
        FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0)) AS a_hrmn,
        b.hrmn as b_hrmn,
     
        CONCAT('<li>',date_format(timestamp,'%i'), ':', callsign,' >> ',
         CASE 
			WHEN comment = 'Initial Log In' THEN 'Log In'
            WHEN comment = 'First Log In'   THEN 'First Log'
            WHEN comment = 'No FCC Record'  THEN 'No FCC'
            WHEN comment LIKE '%Role Changed%' THEN CONCAT('Roll:',
                                                           SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%Status Change%' THEN CONCAT('Status:',SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%County Change%' THEN CONCAT( 'County:',
                                                            SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%Traffic set%' THEN CONCAT( 'Traffic:',
                                                            SUBSTRING_INDEX(comment,':',-1))
            WHEN comment LIKE '%The Call%'  THEN 'Deleted'
            WHEN comment LIKE '%Opened the net%' THEN 'OPENED'
            WHEN comment LIKE '%The log was closed%' THEN 'CLOSED'
            ELSE comment
         END, '</li>') as combo,
         
        CONCAT('<li><span class=\"hrmn\">',
            CONCAT(date_format(timestamp,\"%H\"),':',LPAD(MINUTE(
            FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0)),
            '</span><ul class=\"content\">') as firstlist

      FROM TimeLog a
          ,temp_hrmn b
     WHERE netID = $netID AND callsign NOT LIKE '%genc%' AND callsign NOT LIKE '%weather%'
       AND b.hrmn = CONCAT(date_format(timestamp,'%H'),':',LPAD(MINUTE(
        FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/300)*300)),2,0))
     
     GROUP BY combo
     ORDER BY hrmn ASC ");
     
     $tmpArray = array();
       foreach($db_found->query($sql) as $row) {

            if (!in_array ("$row[b_hrmn]",$tmpArray))  {
                $tmpArray[] .= "$row[b_hrmn]";
                echo "$row[firstlist]";              
            } 
            
            echo "$row[combo]";
             
       } // end foreach

?>


