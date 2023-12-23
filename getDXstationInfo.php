<!doctype html>
<?php
    /* This program uses the HamCall.net database to look up DX callsigns. The data is then distributed to the stations & NetLog tables. */
    /* Written: 2021-12-03 */
    /* This program is executed by a double click on any DX station in the NetLog, launched by function doubleClickCall() in NetManager-p2.js */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php"; 
    require_once "getRealIpAddr.php";
   
    
   $rID = intval( $_GET['rID']); 
   $cs1 = strtoupper($_GET['cs1']);
   $netID = $_GET['netID'];
   
   echo "$rID  /  $cs1";

/*   
   $rID = 80860;
   $cs1 = strtoupper('ur3hc');
   $netID = 5306;
*/
    
   // See HamCall-JSON File.txt for details on thie output of the below 
   // Output:  https://hamcall.net/layoutcsv.txt
   // https://hamcall.net/call?username=wa0tjt&password='.$hamcallpw.'&rawlookupCSV=1&callsign='.$cs.'&program=ncm
   //$url = 'https://hamcall.net/call?username=wa0tjt&password='.$hamcallpw.'&rawlookupCSV=1&callsign='.$cs.'&program=ncm';
   $url = 'https://hamcall.net/call?username=wa0tjt&password=tjt0aw52&rawlookupCSV=1&callsign='.$cs1.'&program=ncm';
   
   echo "$url <br>";
   
   $lines_string = file_get_contents($url);
   
        $str = explode(",",$lines_string); 
        
        print_r (explode(",",$lines_string));
        
        $name       = $str[5];       //echo "<br>name: $name";     
        
        $pieces     = explode(' ', $name);
        $Lname      = array_pop($pieces);       //echo "<br>Lname: $Lname";  

        $string     = explode (' ', $name, 2);  
        $Fname      = $name[1];               //echo "<br>Fname: $Fname<br>";  
      
        $country    = $str[8];       //echo $crty;     
        $latitude   = $str[19];      //echo $lat;
        $longitude  = $str[20];      //echo $lon;
        $grid       = $str[21];      //echo $grid;
        
        $email      = $str[28];      //echo $email;
   
        $home      = "$latitude,$longitude,$grid,,$country";
        
        $t = time();
        $d = date("Y-m-d h:i:s",$t);
        
        $updated   = 'Updated by updateDXstationInfo.php on '.$d;
        
/*================================== UPDATE stations ====================================================================*/
        
         $sql = "UPDATE stations SET
                latitude  = '$latitude'
               ,longitude = '$longitude'
               ,grid      = '$grid'

               ,home      = '$home'
               ,Fname     = '$Fname'
               ,Lname     = '$Lname'
               ,tactical  = RIGHT(callsign, 3)
 
           /*    ,latlng    = GeomFromText(CONCAT('POINT (', $latitude, ' ', $longitude, ')')) */
               ,dttm      = CURRENT_TIMESTAMP
               ,comment   = '$updated'
               ,country   = '$country'
               ,email     = '$email'
              WHERE callsign = '$cs1'
                AND LEFT(callsign, 1) NOT IN('a','k','n','w'); 
	       ";	      
	       
	   
    echo "<p>stations UPDATE:<br>$sql</p>";
   
        $stmt1 = $db_found->prepare($sql);
	    $stmt1 -> execute();
	
/*==================================== UPDATE NetLog ==================================================================*/
	 
	    $sql = "UPDATE NetLog SET
	            latitude  = '$latitude'
               ,longitude = '$longitude'
               ,grid      = '$grid'

               ,home      = '$home'
               ,Fname     = '$Fname'
               ,Lname     = '$Lname'
               ,country   = '$country'
 
               ,comments  = '$updated'
               ,email     = '$email'
              WHERE callsign = '$cs1'
                AND LEFT(callsign, 1) NOT IN('a','k','n','w')
                AND recordID = '$rID';
	    ";
	    
	   echo "<p>NetLog UPDATE:<br>$sql</p>";

	   $stmt2 = $db_found->prepare($sql);
	   $stmt2 -> execute();

/*======================================= INSERT INTO TimeLog ===============================================================*/	
	
	   $ipaddress = getRealIpAddr();
	   $updated   = 'NetLog & stations tables updated by updateDXstationInfo.php on '.$d;
	   
	   $sql = "INSERT INTO TimeLog (ID, recordID, netID, callsign, ipaddress, comment)
	                        VALUES ('0', '$rID','$netID','$cs1','$ipaddress','$updated')
	   ";
	   
	   echo "<p>TimeLog INSERT:<br>$sql</p>";
	   
	   
	   $stmt2 = $db_found->prepare($sql);
	   $stmt2 -> execute();
	   
?>