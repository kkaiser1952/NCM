<?php
// function to geocode address, it will return false if unable to geocode address
require_once "dbConnectDtls.php";

//$netID = strip_tags($_POST["q"]);
$netID = intval($_POST["q"]);
//$netID = 10503;
// you may have to increase the size of the GROUP_CONCAT if the number of callsigns is above 146
// this is done with a SET GLOBAL group_concat_max_len=2048 this makes the max about 292 callsigns

	$sql0 = "SET GLOBAL group_concat_max_len=2048";
	mysql_query($sql0);
	
	// Build the simple list of calls for use as the initial here list to tell the net
	
	$sql = "SELECT LOWER(callsign) AS callsign,
               CASE 
                   WHEN active IN('Out','OUT','In-Out','BRB','MISSING','Moved') THEN active
                   ELSE ''
               END as act,
               netcontrol
        FROM NetLog
        WHERE netID = $netID   
        ORDER BY (CASE 
                      WHEN netcontrol = 'PRM'   THEN 1
                      WHEN netcontrol = '2ND'   THEN 2
                      WHEN netcontrol = 'Log'   THEN 3
                      WHEN netcontrol = 'RELAY' THEN 4
                      WHEN netcontrol = 'LSN'   THEN 5
                      WHEN netcontrol IN ('EM', 'PIO') THEN 6
                      WHEN netcontrol = 'SEC'   THEN 7
                      ELSE 8 -- assign a value that places the unmatched rows last
                  END),
                 dttm ASC;
		   ";
		   
        $callList = '';
        $callListwStat = '';
        $relaystation = '';
        $logstation = '';
        $ncsstation = '';
        $stationList = '';
        $stationcount = 0;
    	foreach($db_found->query($sql) as $row) {
        	$stationcount++;
        	if ("$row[netcontrol]" == 'RELAY' ) { 
            	$relaystation = "$row[callsign];"; 
            	$allrelaystation = "$row[callsign];allcall";
            } ELSE IF ("$row[netcontrol]" == 'PRM' ) { 
            	$PRM = "$row[callsign]"; 
            } ELSE IF ("$row[netcontrol]" == 'Log' ) { 
            	$LOG = "$row[callsign]"; 
            } 
        	$callList            .= "$row[callsign] <br>";
        	$callListwStat       .= "$row[callsign]   $row[netcontrol]   $row[act]<br>";
        	$callListwStatPound  .= "$row[callsign]#<br>";

            $callListwSNR       .= "<tr><td>$relaystation $row[callsign]?
                                    </td>
                                    <td>$relaystation allcall $row[callsign] ack</td></tr>";
            
            $callListwACK       .= "<tr><td>allcall $row[callsign]#
                                    </td>
                                    <td>$relaystation allcall $row[callsign] ack</td></tr>";
            
            $callListwTFK       .= "<tr><td>$relaystation $row[callsign]&
                                    </td>
                                    <td>$relaystation allcall $row[callsign] ack</td></tr>";
	    } // end foreach
	    
	    //   For ack to all: w0wts;allcall w0nrp/a ack
	
	echo("<!DOCTYPE html>
        <html>
        <head>				
		    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
		    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Share+Tech+Mono' >
		    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Allerta' >
					 
        <style>
            div table {
                font-size:24pt;
            }
            td {
                padding-right:35px;
            }
            p {
                font-size:30pt;
                color:Blue;
            }
            h2 {
                font-size:30pt;
                color:green;
            }
            .p2 {
                font-size:24pt;
                color:green;
            }
            h3 {
                color:red;
            }
        </style>
        </head>
        <body>
            <h2>FSQ Heard List cut/past for Net #$netID </h2>
            <h3>Scroll for several more options SNR, ACK and QTC </h3>
            
            <h3> Just cut the part you need, with or without the relay station and paste into FSQ</h3>
            
            
            
            <div><p>Station replys with SNR (?)...</p>
            
                <table>
                    $callListwSNR
                </table>
            
                <br><br>
                <p>Station replys with ack (#)...</p>
                
                <table>
                    $callListwACK
                </table>
                
                <br><br>
                <p>Station replys for QTC traffic (&)...</p>
                
                <table>
                    $callListwTFK
                </table>
                
                <p class='p2'>For ack to all:  w0wts;allcall w0nrp/a ack   </p>
            </div>
               
            <div>
            <div><p>$relaystation allcall ncs final list of stations for net #$netID <br> $callList</p></div>
                <p class='p2'>===== Finals and closing =====<br>
        	       allcall NCS calling late and missed stations, call NCS now. <br>
        	       $allrelaystation NCS calling late and missed stations, call NCS now. <br><br>
        	       
        	       allcall final call for late and missed stations, please call now. <br>
        	       $allrelaystation final call for late and missed stations, please call NCS now.<br><br>
        	       
        	       allcall no stations heard for late or missed calls. <br>
        	       $allrelaystation no stations heard for late or missed calls.<br><br>
        	       
        	       allcall is there any message traffic for the net? If so please call now.<br><br>
        	       
        	       
        	       allcall Thank you $LOG for logging and to our relay station $relaystation today. <br>
        	       The MODES Net #$netID with $stationcount checkins is now closed, <br>$PRM is clear 73. <br><br>
        	       
        	       $allrelaystation Thank you $LOG for logging and to our relay station $relaystation today. <br>
        	       The MODES Net #$netID with $stationcount checkins is now closed, <br>$PRM is clear 73. 
        	    </p>
            </div>
            
                <br><br><br>
                
            <div>
                update: 2023-11-30<br>
                buildFSQHeardList.php
            </div>
        </body>
        </html>

    ");
?>
