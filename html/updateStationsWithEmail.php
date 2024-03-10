<!doctype html>
<?php
    /* This program uses any changed email address, Fname, Lname, creds in the NetLog Table to update the stations table */
    /* Writte: 2021-03-29 */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    //$netID = intval( $_GET["NetID"] ); 
    $netID = 3803;
 
/*   
$sql = ("
    UPDATE stations
       SET dttm  = '$open'
     WHERE dttm = 0
");
    $db_found->exec($sql);
*/   
   
/* tactical no comparison to NetLog */
$sql = ("
    UPDATE stations
       SET tactical = RIGHT(callsign,3),
           dttm  = '$open'
     WHERE tactical = ''
       AND dttm > DATE_SUB(now(), INTERVAL 5 DAY)
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

/* Report on number of updates */
$today = date("Y-m-d"); 

$stmt = $db_found->prepare("
    SELECT COUNT(callsign) AS count 
      FROM stations 
     WHERE dttm > DATE_SUB(now(), INTERVAL 1 DAY)
");            

$stmt->execute();
	$result = $stmt->fetch();
		$count = $result[count];
		
		echo ("updateStationsWithEmail.php Program <br>");
		
        echo ("Records Updated: $count");
                 
?>