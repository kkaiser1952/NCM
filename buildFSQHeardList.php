<?php
// function to geocode address, it will return false if unable to geocode address
require_once "dbConnectDtls.php";

//$netID = strip_tags($_POST["q"]);
$netID = intval($_POST["q"]);
//$netID = 3395;
// you may have to increase the size of the GROUP_CONCAT if the number of callsigns is above 146
// this is done with a SET GLOBAL group_concat_max_len=2048 this makes the max about 292 callsigns

	$sql0 = "SET GLOBAL group_concat_max_len=2048";
	mysql_query($sql0);
	
	// Build the simple list of calls for use as the initial here list to tell the net
	
	$sql = "SELECT LOWER(callsign) AS callsign,
	               CASE 
	                     WHEN active IN('Out','OUT','In-Out','BRB','MISSING','Moved') THEN active
	                     ELSE ''
	                     END as act ,
	               netcontrol
	          FROM NetLog
	          WHERE netID = $netID
	          
              ORDER BY (CASE 
                            WHEN netcontrol = 'RELAY' THEN 0
                		    WHEN netcontrol = 'PRM'   THEN 1
                		    WHEN netcontrol = '2ND'   THEN 2
                		    WHEN netcontrol = 'Log'   THEN 3
                		    WHEN netcontrol = 'LSN'   THEN 4
                		    WHEN netcontrol = 'EM'    THEN 5
                		    WHEN netcontrol = 'PIO'   THEN 6
                		    WHEN netcontrol = 'SEC'   THEN 7 
                		    ELSE 8
                		    END),
                       
                       (CASE 
                            WHEN active IN('Out','OUT','In-Out','BRB','MISSING','Moved') THEN 99 
                            END) 
		   ";
		   
        $callList = '';
        $callListwStat = '';
    	foreach($db_found->query($sql) as $row) {
        	$callList .= "$row[callsign] <br>";
        	$callListwStat .= "$row[callsign]   $row[netcontrol]   $row[act]<br>";
	    } // end foreach
	    
	  //  echo("$callList");
	    
	 // Build the list of macros for use to request a station to check-in   

	$sql = "
		SELECT LOWER(callsign) AS callsign, 
		       netcontrol, netcall,
		       IF(netcontrol = 'RELAY', callsign, '') as relay
		  FROM NetLog
		 WHERE netID = $netID

         ORDER BY (CASE 
                    WHEN netcontrol = 'RELAY' THEN 0
        		    WHEN netcontrol = 'PRM'   THEN 1
        		    WHEN netcontrol = '2ND'   THEN 2
        		    WHEN netcontrol = 'Log'   THEN 3
        		    WHEN netcontrol = 'LSN'   THEN 4
        		    WHEN netcontrol = 'EM'    THEN 5
        		    WHEN netcontrol = 'PIO'   THEN 6
        		    WHEN netcontrol = 'SEC'   THEN 7
        		    WHEN netcontrol = ''      THEN 8
                        END ) DESC,
                  (CASE 
                    WHEN active IN('Out','OUT','In-Out','BRB','MISSING','Moved') THEN 99 
                        END)
	";
	

	$fsqList = '';
	$relaystation = '';
	
	foreach($db_found->query($sql) as $row) {
    	if ("$row[relay]" <> '' ) { $relaystation = "$row[callsign];"; }
    	$fsqList .= "allcall NCS calling $row[callsign] $row[callsign] <br>
    	             $relaystation allcall NCS calling $row[callsign] $row[callsign] <br> <br>
    	            ";
	} // end foreach
	
	 echo "Check-in order <br>$callList<br><br>";
	 echo "Check-in order w/status<br>$callListwStat<br><br>";
	 
	 echo "============= Finals and closing ============<br>
	       allcall NCS calling late and missed stations <br>
	       $relaystation allcall NCS calling late and missed stations <br><br>
	       allcall final call for late and missed stations <br>
	       $relaystation allcall final call for late and missed stations<br><br>
	       allcall no stations heard for late and missed <br>
	       $relaystation allcall no stations heard for late and missed<br><br>
	       allcall $row[netcall] net now closed. <br>
	       $relaystation allcall $row[netcall] net now closed. 73
	       ";
	       
     echo "<br><br>============= Calling Macros ============<br>";
	 echo "$fsqList<br>";
?>
