<!doctype html>
<?php
    /* This program uses any changed email address, Fname, Lname, creds in the NetLog Table to update the stations table */
    /* Writte: 2021-03-29 */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    //$netID = intval( $_GET["NetID"] ); 
    $netID = 4440;
 
/*   
st = stations table
nl = NetLog table
fcc = fcc_amateur.en table
hp = HPD table
tl = TimeLog table
*/   
   
/* tactical no comparison to NetLog */
$sql = ("
    UPDATE stations
       SET tactical = RIGHT(callsign,3),
           dttm  = '$open'
     WHERE tactical = ''
       AND dttm > DATE_SUB(now(), INTERVAL 90 DAY)
");
    $db_found->exec($sql);
   // printf("\nTactical calls added: %d\n", mysql_affected_rows());

/* email */
$sql = ("
    UPDATE stations st
     INNER JOIN NetLog nl ON st.callsign = nl.callsign
       SET st.email = nl.email,
           st.dttm  = '$open'
     WHERE nl.NetID >= '$netID'
       AND nl.callsign = st.callsign  
       AND nl.ID = st.ID
       AND nl.email <> st.email;
    SELECT ROW_COUNT()
");
    $db_found->exec($sql);
   // printf("Email records changed or added: ", mysql_affected_rows());
    

/* Fname */
$sql = ("
    UPDATE stations st
     INNER JOIN NetLog nl ON st.callsign = nl.callsign
       SET st.Fname = CONCAT(UCASE(LEFT(nl.Fname, 1)), LCASE(SUBSTRING(nl.Fname, 2))),
           st.dttm  = '$open'
     WHERE nl.NetID >= '$netID'
       AND nl.callsign = st.callsign
       AND nl.ID = st.ID
       AND nl.Fname <> st.Fname
");
    $db_found->exec($sql);

/* Lname */    
$sql = ("
    UPDATE stations st
     INNER JOIN NetLog nl ON st.callsign = nl.callsign
       SET st.Lname = CONCAT(UCASE(LEFT(nl.Lname, 1)), LCASE(SUBSTRING(nl.Lname, 2))),
           st.dttm  = '$open'
     WHERE nl.NetID >= '$netID'
       AND nl.callsign = st.callsign
       AND nl.ID = st.ID
       AND nl.Lname <> st.Lname
");
$db_found->exec($sql);

/* creds */
$sql = ("
    UPDATE stations st
     INNER JOIN NetLog nl ON st.callsign = nl.callsign
       SET st.creds = nl.creds,
           st.dttm  = '$open'
     WHERE nl.NetID >= '$netID'
       AND nl.callsign = st.callsign
       AND nl.ID = st.ID 
       AND nl.creds <> st.creds
");
$db_found->exec($sql);

/* fccid from fcc_amateur.en */
$sql = ("
    UPDATE stations st
     INNER JOIN fcc_amateur.en fcc ON st.callsign = fcc.callsign
       SET st.fccid = fcc.fccid,
           st.dttm  = '$open'
     WHERE fcc.callsign = st.callsign  
       AND fcc.fccid <> st.fccid
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
                          ");
    $stmt->execute();
    	$result = $stmt->fetch();
    		$openNets = $result[netids];
    		$theCount = $result[theCount];
    		    echo("List of $theCount open nets:<br>$openNets<br><br>");
    		    

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