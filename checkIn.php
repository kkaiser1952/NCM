<?php
// This program is called when a station logs into NCM
// Fix times in the dbConnectDtls.php program 

require_once "dbConnectDtls.php";
require_once "geocode.php";     /* added 2017-09-03 */
require_once "GridSquare.php";  /* added 2017-09-03 */
//require_once "getFCCrecord.php";/* added 2019-11-24 */
require_once "getJSONrecord.php";

// Get the IP address of the person making the changes.
require_once "getRealIpAddr.php";

// The below error output if used looks a lot like echo output so be aware of that

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//ini_set('display_startup_errors', 1);


// Clean up the incoming data which should look like this  :439:aa0ax:::0:TE0ST
if(isset($_POST['q'])){
    $q = strip_tags(substr($_POST["q"],0, 100));
   // echo ("$q"); 
      //  undefined:3551:W0DLK:DEBORAH KAISER:undefined:0:TE0ST:0:::A
      
}
if(isset($q)){ 
} 

//echo "$q";  
//undefined:3517:AC0YK:Michael Hartmann:undefined:0:TE0ST:0:::Q
            

// Pull the incoming string apart
$parts	= explode(":",$q);   
 //echo '<br><pre>'; print_r($parts); echo '</pre>';
 
 /* 
    Array
(
    [0] => undefined
    [1] => 3212
    [2] => W0DLK/H
    [3] => 
    [4] => 1
    [5] => 0
    [6] => TE0ST
    [7] => 0
    [8] => 
    [9] => 
    [10]=> A
)

    Array
(
    [0] => undefined        station ID
    [1] => 2290             netID
    [2] => KA0SXY           callsign
    [3] => Dennis           Fname (maybe two)
    [4] => 1        Is this a PB net
    [5] => 0                binaryops   
    [6] => TE0ST            netcall
    [7] => 1                multi-band indicator 1 = yes, 0 or null = no
    [8] => 2F               cat custom category
    [9] => MO               section custom section (not in use)
    [10] => A               shortcut letter of traffic column
) */


$id 	= $parts[0];                //echo "id= $id"; // The users ID (13 = WA0TJT)
$netID 	= $parts[1];                //echo("netid= $netID");   // The net ID we are working with
$cs0    = strtoupper($parts[2]);    //echo "cs0 = $cs0";
$cs1    = $cs0;
$ispb   = $parts[4];                //echo "ispb = $ispb";
    $pbspot = '';
    if ($ispb == 1) {$pbspot = 'PB';}
//$cspart = explode("/", $cs0); 
//$cspart = preg_split('/ (/|-) /', $cs1);  // same as explode but for / or - to split. the \ is an escapt mark.
$cspart = preg_split("/[\/|\-]+/", $cs0); // I THINK THIS WORKS!

$csbase = $cspart[0];

$Tname 	= ucfirst($parts[3]);       // The first or both names of this person depending how it was entered
$fdcat  = $parts[8];                //echo "fdcat: $fdcat";
$fdsec  = $parts[9];
$mBand  = $parts[7];                // the multiple bands indicator 1 = Yes, 0 or NULL = No
$tfksrt = $parts[10];               // the shortcut of the traffic column 

$ipaddress = getRealIpAddr();
    

// If mBand = 1 (Yes) then its going to be OK to have duplicate callsigns check in, presumably for each band

	if (str_word_count("$Tname") >= 2){
		$Fname = str_word_count("$Tname",1)[0]; 
		$Fname2 = $Fname;
		$Lname2 = ucfirst(str_word_count("$Tname",1)[1]." ".str_word_count("$Tname",1)[2]);
	}
	else {$Fname  = ucfirst($parts[3]);
		  $Fname2 = ucfirst($parts[3]);  // the first name of this person, needed because Fname gets reset.
		  $Lname2 = "";
		 }
		 
/* Pull some variables from the current net */
	$stmt1 = $db_found->prepare(
	         "SELECT netcall, pb, activity, subNetOfID, frequency
				FROM NetLog
			   WHERE netID = '$netID' 
			     and logdate = ( SELECT MIN(logdate) 
			                       FROM NetLog 
			                      WHERE netID = '$netID' 
			                    )
			 ");
        $stmt1->execute();
        $result1 = $stmt1->fetch();
        
            $netcall   = $result1['netcall'];     $pb         = $result1['pb'];
            $activity2 = $result1['activity'];    $subNetOfID  = $result1['subNetOfID'];
            $frequency = $result1['frequency'];   $max_row_num = $result['max_row_num'];
    		
    		
    $stmt2 = $stmt1 = $db_found->prepare(
             "SELECT MAX(row_number) AS max_row_num
                FROM NetLog
               WHERE netID = '$netID' 
             ");
        $stmt2->execute();
        $result2=$stmt2->fetch();
            $max_row_num = $result2['max_row_num'];

/* This experimental query pulls the last time this callsign logged on using the stations table */

/* Tested and passed But any updates to it are not yet done  */
//echo "$csbase";
    $stmt2 = $db_found->prepare("
        SELECT id, Fname, Lname, creds, email, latitude, longitude,
		       grid, county, state, district, home, phone, tactical, country,
		       city
	      FROM stations 
	     WHERE callsign = '$csbase'
	       AND active_call = 'y'
         LIMIT 0,1
    ");  

	$stmt2->execute();
	$result = $stmt2->fetch();
	
	$recordID 	= $result[recordID];   
	$id         = $result[id];  
	$Fname 	  	= ucwords(strtolower($result['Fname']));
	$Lname      = ucwords(strtolower($result['Lname']));  
	$grid  		= $result['grid'];	   $creds 	 = $result['creds'];
	$email 		= $result['email'];	   $latitude = $result[latitude];
	$longitude 	= $result[longitude];  $tactical = $result[tactical];
	$county    	= ucwords(strtolower($result['county']));	   
	$state 	    = $result['state'];
	$country   	= ucwords(strtolower($result['country']));	
	$district 	= $result['district'];   $tt		 = $result['tt']; 
	$home       = $result['home'];       $phone    = $result['phone'];
	$comments  	= "";	  
	$city       = $result['city'];      
	
	//echo "stmt2: $cs1, $county, $state, $grid, $phone <br>";
	
	if (!empty($id)) { $firstLogIn = 0;} // This counters the value set in getFCCrecord.php if we do find a match above

// DUPLICATE CALL CHECK
// We are going to process a duplicate call sign here by rejecting it, actually ignoring it.
// First we test if its a multiple band net if so don't test for dupes
    $dupes = 0;
    $dupes = (int) $db_found->query("SELECT count(*) 
                                       FROM NetLog 
                                      WHERE netID = $netID 
                                        AND callsign = '$cs1'")->fetchColumn();
    
                                        
    if ($mBand == 0 AND $dupes > 0 AND $cs1 <> "NONHAM" AND $cs1 <> "EMCOMM") { // This is a dupe we need to prevent
       // echo("mBand: $mBand \n dupes: $dupes \n");  // mBand: 0 dupes: 1   dupe call in non-mBand
        break;
       // exit("$cs1 is a duplicate call sign"); //IGNORE IT, DON'T ENTER INTO THE DB
    } 

/* Each call sign has a unique ID */
/* If the ID is unknown from the stmt2 query, this creates a new record, ID and tactical 
	call for the person being checked in, it means that this person is a first time check in */
if ("$id" == "") {
    
    $stmt = $db_found->prepare("SELECT MAX(id)+1 as unused
                                  FROM stations
                                 WHERE id < 38000
                              ");	
	
		$stmt->execute();
    	  	$result     = $stmt->fetch();
    	  	$id 	    = $result[unused];   // The ID of this new person
    	  	
	  	$comments = ""; // WILL BE RESET IN getFCCrecord.php

        // This looks to see if the station has a record in the FCC database
        include "getFCCrecord.php";
		
			// If this is the first log in for this station add them to the TimeLog table 
			//if ("$comments" == "First Log In" OR "$comments" == "No FCC Record"){
    if ("$comments" == "No FCC Record") {
        $firstChar = $cs1[0];
        
        // Use this to find any DX station that gets logged. The data comes from the
        // hamcall.net DB courtesy of Daniel Bateman, KK4FOS with Buckmaster International, LLC
        //if ( $cs1[0] <> 'A' AND $cs1[0] <> 'N' AND $cs1[0] <> 'K' AND $cs1[0] <> 'W' ) 
            //{ include "getDXstationInfo.php"; }

                $stmt = $db_found->prepare("SELECT MAX(id)+1 as unused
                                  FROM stations
                                 WHERE id >= 38000 and id < 49999
                              ");	
	
		$stmt->execute();
    	  	$result     = $stmt->fetch();
    	 	$id 	    = $result[unused]; 
    	  	
    	 //	$id = 8000; 
                
				$sql = "INSERT INTO TimeLog 
						(recordID, 		ID, 	netID, 	  callsign, comment, 	 timestamp, ipaddress) 
				VALUES  ('$recordID', 	'$id', 	'$netID', '$cs1', 	'$comments', '$open', '$ipaddress')";
			
                    $db_found->exec($sql);
                    
            if ($id > 37999) {
                    $sql = "INSERT INTO stations 
                            (recordID, ID,  callsign, dttm, comment)
                        VALUES  ('$recordID', 	'$id', 	 '$cs1',  '$open', '$comments')";
                        
                             $db_found->exec($sql);
            }
                  
                
    } // End of comments = "First Log In"
	        
} // end of id == blank, meaning its a first time log in
	
//*******************************************************
// Added 2017-11-05 to eliminate dupelicate calls from being entered

// Added 2018-02-07. NOTE: the use of "" not " " with a space.
if ($cs1 == "NONHAM") {
	$tactical = "";
	$comments = "Not A Ham";
	$Lname = "";
	$Fname = "";
}
if ($cs1 == "EMCOMM") {
	$tactical = "";
	$comments = "Emergency Mgnt. Not A Ham";
	$Lname = "";
	$Fname = "";
}


$traffic = " ";
$logtraffic = " ";
if (trim($fdcat) == "") {$traffic = " ";} else {$traffic = "Routine";}

//echo "$tfksrt";

if (trim($tfksrt) == "") {$traffic = " ";} 
    else if(trim($tfksrt) == "R") {$traffic = "Routine";        $logtraffic = "with Routine Traffic"; }
    else if(trim($tfksrt) == "W") {$traffic = "Welfare";        $logtraffic = "with Welfare Traffic"; }
    else if(trim($tfksrt) == "P") {$traffic = "Priority";       $logtraffic = "with Priority Traffic"; }
    else if(trim($tfksrt) == "E") {$traffic = "Emergency";      $logtraffic = "with Emergency Traffic"; }
    else if(trim($tfksrt) == "Q") {$traffic = "Question";       $logtraffic = "with a Question"; }
    else if(trim($tfksrt) == "A") {$traffic = "Announcement";   $logtraffic = "with an Announcement"; } 
    else if(trim($tfksrt) == "C") {$traffic = "Comment";        $logtraffic = "with a Comment"; }
    else if(trim($tfksrt) == "T") {$traffic = "Traffic";        $logtraffic = "with unknown Traffic"; }
	    
if ($Fname == "") {$Fname = "$Fname2";}
if ($Lname == "") {$Lname = "$Lname2";}


// 0 means it is NoT a pre-build, 1 means it is a pre-built

	switch ($pb) {
      case 0;  // Not a pre-build
       	$statusValue = 'In';
	   	$timeLogIn	 = $open;
       	break;
      case 1:   // is a pre-build
      	$statusValue = 'OUT';
      	$timeLogIn	 = 0;
      	break;
      
      default:
      	$statusValue = 'In';
      	$timeLogIn	 = $open;
   }

	// Added county and state on 2017-09-04
	// Added pb on 2018-12-17
	
	// This duplicated from above
	// Added for the 'Add Stations Table Project' on 2020-09-28
	$partsofCS1 = str_split($cs1);
	$first_num  = -1;
	$num_loc    = 0;
		foreach ($partsofCS1 AS $a_char) {
			if (is_numeric($a_char)) {
  			    $first_num = $num_loc;
  			break;
			}
			    $num_loc++;
		}
		if ($first_num > -1) {
			$tactical = substr($cs1,$num_loc+1);
		} else {
			$tactical = $cs1;
		}
	
	$tt = '';   // Added for the 'Add Stations Table Project' 
	
	$max_row_num = ($max_row_num + 1);
	
	
	$sql = "INSERT INTO NetLog (ID, active, callsign, Fname, Lname, netID, 
	                grid, tactical, email, latitude, longitude, 
				    creds, activity, comments, logdate, netcall, subNetOfID, frequency, county, state, country, district, firstLogIn, pb, tt, home, phone, cat, section, traffic, row_number, city ) 
				VALUES (\"$id\", \"$statusValue\", \"$cs1\", \"$Fname\", \"$Lname\", \"$netID\", \"$grid\",
				        \"$tactical\", \"$email\", \"$latitude\", \"$longitude\", \"$creds\", \"$activity2\", \"$comments\",
				        \"$timeLogIn\", \"$netcall\", \"$subNetOfID\", \"$frequency\", \"$county\", \"$state\", \"$country\", \"$district\",
				        \"$firstLogIn\", \"$pb\", \"$tt\", \"$home\", \" \", \"$fdcat\", \"$fdsec\", \"$traffic\", \"$max_row_num  \", \"$city\" )"; 
	
	$db_found->exec($sql);
	
	if ($comments == "First $pbspot Log In" ) { 
    	//do nothing 	
    	// Initial Log In recording to TimeLog
	}else { $comments = "Initial $pbspot Log In"; }
	
	
	$sql = "INSERT INTO TimeLog 
						(recordID, 		ID, 	netID, 	  callsign, comment, 	 timestamp, ipaddress) 
				VALUES  ('$recordID', 	'$id', 	'$netID', '$cs1', 	'$comments $logtraffic', '$open', '$ipaddress')";
			
                    $db_found->exec($sql);
                    
            include "headerDefinitions.php";
			  	                             	
		$num_rows = 0;   // Counter to color row backgrounds in loop below
		
		$g_query = "
    SELECT  recordID, netID, Mode, subNetOfID, id, callsign, tactical, Fname, grid, traffic, 
			latitude, longitude, netcontrol, activity, Lname, email, active, comments, frequency, 
			creds, DATE_FORMAT(logdate, '%H:%i') as logdate, DATE_FORMAT(timeout, '%H:%i') as timeout,
			sec_to_time(timeonduty) as time, county, state, district, netcall, firstLogIn, tt, w3w, home,phone, band, cat, section, row_number, team, aprs_call, country, facility, onSite, delta, city
	  FROM  NetLog
     WHERE netID = $netID
     ORDER BY case 
			when netcontrol in ('PRM','CMD','TL') then 0 
			when netcontrol in('2nd','3rd','Log','LSN','PIO','EM','RELAY') then 1
			when active		= 'MISSING' then 2
			when active		= 'BRB' then 2
			when active 	in('In-Out', 'Out', 'OUT') then 3999
			when netcall in ('MESN') then district 
			when netcall in ('KCHEART') then facility
			when netcall like '%SBBT%' then team
			else logdate  
			end,
			logdate DESC
    ";
				       
       include "dropdowns.php";
              
	foreach($db_found->query($g_query) as $row) {
				 ++$num_rows; // Increment row counter for coloring background of rows
				 $brbCols = "                 ";
				 $bgcol = "                 ";
				 $cs1Cols = $modCols = $brbCols = $badCols = $newCall = $timeline = $important1 = $important2 = '';
				 $f = '<font color="black">';
				 				 
				if ("$row[netcall]" == "") {
					$netcall = "All";
				} else {
					$netcall = "$row[netcall]";
				}
				
				// This PHP contians all the column color assignments based on various cell values
        include "colColorAssign.php";
		  
				 $id = str_pad($row['id'],2,'0', STR_PAD_LEFT);
				 
				 echo ("<tr  id=\"$row[recordID]\">");
				 
				 $class = empty($row['comments']) ? 'nonscrollable' : 'scrollable' ;
				 $class = strlen($row['comments']) < 300 ? 'nonscrollable' : 'scrollable' ;	
				 
				 // This PHP creates each row (<td>)
        include "rowDefinitions.php";
				 

	} // End of foreach
 			 
			echo ("</tr></tbody></table>"); //End of tbody and the table	
			
			echo ("<div hidden id='freq2'>                  $row[frequency]	</div>");
			echo ("<div hidden id='freq'>									</div");
			echo ("<div hidden id='type'>Type of Net:       $row[activity]	</div>");
			echo ("<div hidden id='idofnet'>	            $row[netID]		</div>");
			echo ("<div hidden id='activity'>               $row[activity]	</div>");
			echo ("<div hidden id='domain'>                 $row[netcall]     </div>");
    
?>
