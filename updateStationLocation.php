<!doctype html>
<?php
    /* This program uses any changed email address, Fname, Lname, creds in the NetLog Table to update the stations table */
    /* Writte: 2021-03-29 */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    //$netID = intval( $_GET["NetID"] ); 
   // $cs = 'KC0UCA';
 
/*   
st = stations table
nl = NetLog table
fcc = fcc_amateur.en table
hp = HPD table
tl = TimeLog table
*/   
   
$sql = ("
    SELECT st.callsign as st_callsign,
	   st.latitude, st.longitude,
           fcc.callsign as fcc_callsign,
       fcc.address1, fcc.city, fcc.state, fcc.zip
      FROM ncm.stations st
          ,fcc_amateur.en fcc
     WHERE st.callsign = '$cs'
       AND st.callsign = fcc.callsign;
");           

    foreach($db_found->query($sql) as $row) {      
        $fcc_callsign = $row[fcc_callsign];
        $st_callsign = $row[st_callsign];
    } // end of foreach
    
    echo("fcc= $fcc_callsign   ncm= $st_callsign");
?>