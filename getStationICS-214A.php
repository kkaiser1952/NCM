<?php
// getStationICS-214A.php
// This program produces a report of the time line for this callsign, it opens as a modal or window
// Written: 2021-12-10
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    // This is for what3words usage
    /* https://developer.what3words.com/public-api/docs#convert-to-3wa */
    require_once "Geocoder.php";
        use What3words\Geocoder\Geocoder;
        use What3words\Geocoder\AutoSuggestOption;
            $api = new Geocoder("5WHIM4GD");
    
    // PHP Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}
    

$netID = strip_tags($_POST["netid"]); // The one we are copying rows to
$call = strip_tags($_POST["call"]); // The name of this new event	

//$netID = 10684;
//$call = 'wa0tjt';

    // change dttm below to timeout or choose the later timestamp
    $sql = $db_found->prepare("
        SELECT CONCAT(Fname,' ',Lname,', ',callsign) AS fullName,
               county, state,
               
               (SELECT logdate
                  FROM NetLog WHERE callsign = '$call' AND netID = $netID GROUP BY callsign) as logdate,
               (SELECT MAX(timeout)
                  FROM NetLog WHERE callsign = '$call' AND netID = $netID GROUP BY callsign) as timeout,
               (SELECT MAX(DTTM)
                  FROM NetLog WHERE callsign = '$call' AND netID = $netID GROUP BY callsign) as maxdttm,
               (SELECT activity
                  FROM NetLog WHERE callsign = '$call' AND netID = $netID GROUP BY callsign) as activity
                  
          FROM stations
         WHERE callsign = '$call'
          GROUP BY callsign
    "); 
    
    //echo "<br>$sql<br>";
          
    $sql->execute();
	  	$result     = $sql->fetch();
	 	$fullName   = $result[fullName];   //echo "<br> $fullName <br>";
	 	$county     = $result[county];
	 	$state      = $result[state];
	 	$opPeriod   = $result[opPeriod];
	 	$act        = $result[activity];
	 	$logdate    = $result[logdate];
	 	$dateout    = $result[timeout];
	 	$maxdttm    = $result[maxdttm];
	 	
	 	   if ($dateout == '') {$dateout = $maxdttm.' <b style="color:red;">(Open Net)</b>';}


    $sql = "SELECT timestamp, comment
              FROM TimeLog
             WHERE NetID = $netID
               AND callsign = '$call'
             ORDER BY timestamp ASC       
           ";   
     
    foreach($db_found->query($sql) as $row) {
		++$num_rows; // Increment row counter for coloring background of rows
		
		$activity .= "
		<tr>
		    <td class='highlightMe' style='white-space: nowrap; width:25%;'> $row[timestamp] </td>
            <td colspan=2> $row[comment] </td>
        </tr>";
		
		// ====================================
        // Now get the W3W words from lat/lon
        // ====================================
    //    $url = 'https://api.what3words.com/v3/convert-to-3wa?key=5WHIM4GD&coordinates='.$row[coordinates].'&language=en&format=json';
   
   //echo "$url <br>";
   
  // $lines_string = file_get_contents($url);
  //      $str = explode(",",$lines_string); 

 //  print_r (explode(",",$lines_string));
   
  //      $w3w = $str[9];  
    
  //  echo "<br> w3w= $w3w<br>";
        //$w3wLL = $api->convertToCoordinates("$row[coordinates]");
        //print_r($w3wLL);
         //  echo "w3wll: $w3wLL"; 
          
		//echo "<tr><td>$row[timestamp | $row[coordinates] </td>";
		
    } // End foreach
    
    // CONCAT(logdate, '</td><td> To:<br> ', timeout,'</td>')
    //   <tr><td colspan=3 white-space: nowrap;><b>2. Operational Period: From:<br></b> $opPeriod</td>
    
     $body = "<h2 style='text-align: center;'> $call Individual Activity Log (ICS-214A)</h2>
                <div style='overflow-x:auto;'>
                <table>
                    <tr><td colspan=3 style='white-space: nowrap;'><b>1. Incident Name:</b> NCM #$netID<br> $act</td> </tr>
                    
                    <tr><td colspan=2 style='white-space: nowrap; width:50%;'><b>2. Operational Period:<br>From: $logdate</td>
                        <td style='white-space: nowrap;'><b>To: $dateout
                                  
                    <tr><td colspan=2><b>3. Individual Name:<br></b> $fullName </td>     
                        <td><b>4.ICS Section:</b><br>Unknown</td>
                        
                    <tr><td colspan=3><b>5. Assignment/Location:</b> $county, $state</td>
                    
                    <tr><td colspan=3><b>6. Activity Log</b></td>
                    
                    </table>
                
                    <table class='table2'>
                    
                    <tr><th style='text-align:center;'>Date/Time</th>
                        <th style='text-align:center;' colspan=3>Major Events</span></th>
                        
                    $activity
                    
                    <tr><td style='padding-top:20px; padding-bottom:20px;' colspan=3>7. Prepared by $fullName  </td>
                    </table>
                </div>
		       ";
    
   $header = '
        <!doctype html>
        <html lang="en" >
        <head>
            <meta charset = "UTF-8" />
            <title>Amateur Radio Net Control Manager Individual Activity Log</title>
            <script>
                console.log("in the function");
                document.addEventListener("DOMContentLoaded", function () {
                    // Get all elements with the class "highlightMe"
                    var elements = document.getElementsByClassName("highlightMe");
                        console.log("assign elements:"+elements);
                    // Loop through each element and check if it contains the specified string
                    for (var i = 0; i < elements.length; i++) {
                        var tdContent = elements[i].innerHTML;
                console.log("tdContent: "+tdContent);
                        // Check if the content contains the specified string
                        if (tdContent.includes("LOCΔ:APRS")) {
                            // Add the "highlight" class to the current element
                            elements[i].classList.add("highlight");
                        }
                    }
                });
            </script>
            
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                    font-size: 11pt;
                }
                th {
                    font-size: larger;
                    font-weight: bold;
                    background-color: #04AA6D;
                    color: white;
                   }
                tr:hover {
                    background-color: yellow;
                   } 
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                   }
                td:nth-child(1) {
                  /*  width: 40%; */
                   }
                   
            </style>
        </head>
        <body>   
   ';
   
   echo "$header";
   echo "$body 
        <footer>
       <p style='padding:3px; color:a9a9a9; font-size:9pt;'>net-control.us/getStationICS-214.php</p>
        </footer>
        </body>
        </html>";
   //echo "<span>Time</span><span>Major Events</span>";
  // echo "$activity";
  // echo "</ul>";


/*
{
    "country": "US",
    "square": {
        "southwest": {
            "lng": -94.658117,
            "lat": 39.419793
        },
        "northeast": {
            "lng": -94.658082,
            "lat": 39.41982
        }
    },
    "nearestPlace": "Smithville, Missouri",
    "coordinates": {
        "lng": -94.6581,
        "lat": 39.419806
    },
    "words": "hers.parrot.legions",
    "language": "en",
    "map": "https://w3w.co/hers.parrot.legions"
}
*/

?>
