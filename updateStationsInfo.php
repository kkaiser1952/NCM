<!doctype html>
<?php
    /* This program uses any changed email address, Fname, Lname, creds in the NetLog Table to update the stations table */
    /* Writte: 2021-03-29 */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    //$netID = intval( $_GET["NetID"] ); 
    //$netID = 6100;
 
/*   
st = stations table
nl = NetLog table
fcc = fcc_amateur.en table
hp = HPD table
tl = TimeLog table
*/   

/* fccid from fcc_amateur.en */
$sql = ("
    UPDATE stations st
     INNER JOIN fcc_amateur.en fcc ON st.callsign = fcc.callsign
       SET st.fccID = fcc.fccid,
           st.dttm  = '$open'
     WHERE fcc.callsign = st.callsign  
       AND fcc.fccid <> st.fccID
       AND LEFT(st.callsign, 1) IN('a','k','n','w')
");
$db_found->exec($sql);


/* The district is updated from the HPD table */
$sql = ("
    UPDATE stations st
     INNER JOIN HPD hp ON st.county = hp.county AND st.state = hp.state
       SET st.district = hp.district
     /*      ,st.dttm  = '$open' */
     WHERE hp.state = st.state
       AND hp.county = st.county
       AND st.district = '' or st.district IS NULL
       AND LEFT(st.callsign, 1) IN('a','k','n','w')
");
$db_found->exec($sql);

/*=============================*/

$today = date("Y-m-d"); 

/* List all the TE0ST netID's */
$stmt = $db_found->prepare("SELECT GROUP_CONCAT(DISTINCT netID) AS netids,
                                   COUNT(DISTINCT netID) as theCount
                              FROM NetLog 
                              WHERE netcall LIKE '%te0st'
                           ");
    $stmt->execute();
    	$result = $stmt->fetch();
    		$testNets = $result[netids];
    		$theCount = $result[theCount];
    		    echo("List of $theCount test nets:<br>$testNets<br><br>");
    		    
		    
/* List all the open nets */
$stmt = $db_found->prepare("SELECT GROUP_CONCAT(DISTINCT netID) AS netids,
                                   COUNT(DISTINCT netID) as theCount
                              FROM NetLog 
                             WHERE status = 0  /* 0 is open, 1 is closed */
                               AND pb = 0      /* 0 is not a pre-built net, 1 is */
                             ORDER BY netID DESC  
                          ");
    $stmt->execute();
    	$result = $stmt->fetch();
    		$openNets = $result[netids];
    		$theCount = $result[theCount];
    		    echo("<p style='columns: 20px 2; column-gap: 10px;'>List of $theCount open nets:<br>$openNets<br><br></p>");
    		    
    		    
/* List of bad callsigns in stations */
$stmt = $db_found->prepare("SELECT GROUP_CONCAT(callsign) AS badCalls
                              FROM `stations` 
                             WHERE state = '' 
                               AND callsign not like 'nonham%' AND ID < 38000 
                               AND callsign not like 'emcomm%' AND ID < 38000 
                               AND callsign NOT LIKE ('AF%') AND callsign NOT LIKE ('AAA%') 
                               AND callsign NOT LIKE ('AAR%')
                               AND (callsign like 'a%' OR callsign like 'k%' OR callsign like 'n%' OR callsign like 'w%')  
                           ");
     $stmt->execute();
    	$result = $stmt->fetch();
    		$badCalls = $result[badCalls];
                echo("<p>List of Bad callsigns in the stations table:<br>$badCalls<br><br><br></p>");
    		    

/* Report on number of updates */
$stmt = $db_found->prepare("SELECT COUNT(callsign) AS count 
                              FROM stations 
                             WHERE dttm >= DATE_SUB(now(), INTERVAL .5 HOUR)
                          ");            

$stmt->execute();
	$result = $stmt->fetch();
		$count = $result[count];
		
		echo ("updateStationsWithEmail.php Program <br>Records Updated: $count");
		
        //echo ("Records Updated: $count");
                 
?>