	<?php 
	//require_once "NCMStats.php";		
	//echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";	
?>		
</DOCTYPE html>
<html>
    <head>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
          $(document).ready(function() {
              $('tr td:first-child').click(function() {
                var value = $(this).text(); // Get the text value of the clicked <td>
                net_by_number(value); // Call your function with the retrieved value
              });
          });
          
          function net_by_number(value) {
            //alert("You clicked the first table cell with value: " + value);
            // Perform any other desired actions using the value
          }

        </script>
        
        <style>
            table {
                border-collapse: collapse;
            }
            
            th, td {
                padding: 8px;
                border: 1px solid #000000;
            }
            
            .odd-row {
                background-color: #F0F0F0;
            }
            
            .even-row {
                background-color: #FFFFFF;
            }
                        
            /* Style for nets with 1 entry */
            .red-bg {
                background-color: red;
                color: white;
            }
            
            /* Style for Open nets */
            .green-bg {
                background-color: green;
                color: white;
            }
            
            /* Style for Pre-Built nets */
            .blue-bg {
                background-color: blue;
                color: white;
                font-weight: bold;
            }
                        
            /* Style for Test nets */
            .purple-bg {
                background-color: purple;
                color: white;
                font-weight: bold;
            }
            
            /* Style for Facility Nets */
            .yellow-bg {
              background-color: yellow;
              color: blue;
            }
            
            .cayenne-bg {
                background-color: #941100;
                color: white;
                font-weight: bold;
            }
            
            label {
              font-weight: bold;
            }
            
            .date-row {
              font-weight: bold;
              font-size: 18pt;
              color: darkgreen;
            }
                  
            /* Style for 1 record and pre-built net */
            /* Style for the first two columns (red) */
            .redblue-bg {
              background-color: red;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .redblue-bg td:nth-child(4) {
              background-image: linear-gradient(to right, red, blue);
              color: white;
            }
            
            /* Style for the last three columns (blue) */
            .redblue-bg td:nth-last-child(-n + 4) {
              background-color: blue;
              color: white;
            }
            
            .bluegreen-bg td:nth-child(4) {
              background-image: linear-gradient(to right, blue, green);
              color: white;
            }
            
            .bluegreen-bg td:nth-last-child(-n + 4) {
              background-color: blue;
              color: white;
            }
            
            /* Style for 1 record and pre-built net */
            /* Style for the first column (blue) */
            .blueyellow-bg td:nth-child(-n + 4) {
              background-color: blue;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .blueyellow-bg td:nth-child(4) {
              background-image: linear-gradient(to right, blue, yellow);
              color: white;
            }
            
            /* Style for the last three columns (green) */
            .blueyellow-bg td:nth-last-child(-n + 4) {
              background-color: yellow;
              color: white;
            }

          
             /* ---- */
            
           
            /* Style for the first two columns (red) */
            .redpurple-bg {
              background-color: red;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .redpurple-bg td:nth-child(4) {
              background-image: linear-gradient(to right, red, purple);
              color: white;
            }
            
            /* Style for the last three columns (purple) */
            .redpurple-bg td:nth-last-child(-n + 4) {
              background-color: purple;
              color: white;
            }
            /* END: Style for 1 record and test net */
            
            /* Style for an open test net */
            .greenpurple-bg td:nth-child(-n + 4) {
              background-color: green;
              color: white;
            }
            
            .greenpurple-bg td:nth-child(4) {
              background-image: linear-gradient(to right, green, purple);
              color: white;
            }
            
            .greenpurple-bg td:nth-last-child(-n + 4) {
              background-color: purple;
              color: white;
            }
            
            /* Style for an pre-built test net */
            .bluepurple-bg td:nth-child(-n + 4) {
              background-color: blue;
              color: white;
            }
            
            .bluepurple-bg td:nth-child(4) {
              background-image: linear-gradient(to right, blue, purple);
              color: white;
            }
            
            .bluepurple-bg td:nth-last-child(-n + 4) {
              background-color: purple;
              color: white;
            }
            
            /* ---- */
           
            /* Style for the first two columns (red) */
            .redgreen-bg td:nth-child(-n + 4) {
              background-color: red;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .redgreen-bg td:nth-child(4) {
              background-image: linear-gradient(to right, red, green);
              color: white;
            }
            
            /* Style for the last three columns (green) */
            .redgreen-bg td:nth-last-child(-n + 4) {
              background-color: green;
              color: white;
            }
            
            .reportTitle {
                font-size: 18pt;
                margin-left: 100px;
            }
            
            /* ---- */
            
            /* Style for combination label */
            .combo-bg {
              background-image: linear-gradient(to right, red, yellow, green, purple, blue, #941100 );
              width: 300px;
              color: white;
            }
            
            /* Apply some general styling to the form rows and columns */
            .report-container {
              max-width: 600px; /* Adjust the width as needed */
              margin-left: 100px;
            }
            
            /* Apply some general styling to the form rows and columns */
            .form-row {
              display: flex;
              align-items: baseline; /* Vertically align based on the baseline */
              justify-content: flex-start; /* Align form rows to the left */
              margin-bottom: 10px;
            }
            
            .form-column {
              flex: 1;
              margin-right: 20px;
            }
            
            /* Set a fixed width for labels to make them the same length */
            .form-row label {
              flex-basis: 120px; /* Adjust the width as needed */
            }
            
            /* Set a fixed width for the last input (field5) to make it the same length */
            .form-row:last-child input {
              max-width: calc(100% - 120px); /* 100% minus the label width */
            }
            
            /* Define the CSS rules for centering the content */
            .centered {
                text-align: center;
            }
            
            /* Style for the new sum row */
            .sum-row {
                background-color: lightgray;
                color:blue;
                font-weight: bold;
                font-size: 16pt;
                text-align: center;
            }
            
            tr:first-child {
              border-bottom: 2px solid red;
            }
            

        </style>
    </head>
<body>

<?php
require_once "NCMStats.php";		
	//echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer	
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

//require_once "dbConnectDtls.php";  // Access to MySQL is in the NCMStats.php 

// Grand totals SQL
$sql = $db_found->prepare("
SELECT count(callsign) as all_callsigns, 
       sum(firstLogIn) as ttl_1st_logins,
       CONCAT(
        FLOOR(SUM(`timeonduty`) / 86400), ' days ',
        LPAD(FLOOR((SUM(`timeonduty`) % 86400) / 3600), 2, '0'), ':',
        LPAD(FLOOR((SUM(`timeonduty`) % 3600) / 60), 2, '0'), ':',
        LPAD(SUM(`timeonduty`) % 60, 2, '0')
    ) AS time_on_duty
   FROM NetLog
  WHERE (DATE(logdate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)); 
");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $ttl_callsigns = $result[0]['all_callsigns'];
    $ttl_first_logins = $result[0]['ttl_1st_logins'];
    $time_on_duty = $result[0]['time_on_duty'];
    
        
        //echo ('<br>' . $ttl_callsigns . '<br>' . $ttl_first_logins . '<br>' . $time_on_duty);
/*
    // This snipit of code can pick up the personwho opened the Net on NCM
    SELECT netID, callsign , `comment`
      FROM TimeLog 
     WHERE comment like '%Opened the%' 
       AND netID >= 9800  
     ORDER BY `TimeLog`.`netID`  DESC
    */

// Your SQL query
$sql = $db_found->prepare("
SELECT 
    CASE WHEN nl.subNetOfID <> 0 THEN CONCAT(nl.subNetOfID, '/', nl.netID) 
            ELSE nl.netID END AS netID,
    nl.logdate,
    nl.netcall,
    nl.stations,
    nl.pb,
    nl.testnet,
    CASE WHEN nl.logclosedtime IS NULL THEN DATE_ADD((SELECT MAX(dttm) FROM NetLog), INTERVAL 30 MINUTE)
         WHEN nl.logclosedtime = '' THEN DATE_ADD((SELECT MAX(dttm) FROM NetLog), INTERVAL 30 MINUTE)
            ELSE nl.logclosedtime END AS logclosedtime, 
    CASE WHEN nl.pb = '0' THEN '' WHEN nl.pb = '1' THEN 'blue-bg' 
            ELSE '' END AS PBcss,
    CASE WHEN nl.logclosedtime IS NOT NULL THEN '' 
         WHEN nl.logclosedtime IS NULL THEN 'green-bg' 
            ELSE '' END AS LCTcss,
    CASE WHEN nl.netcall IN ('TEST', 'TE0ST', 'TEOST', 'TE0ST') OR nl.netcall LIKE '%test%' THEN 'purple-bg' 
            ELSE '' END AS TNcss,
    CASE WHEN nl.stations = 1 THEN 'red-bg' 
            ELSE '' END AS CCss,
    CASE WHEN nl.facility <> '' THEN 'yellow-bg' 
            ELSE '' END as FNcss,
    CASE WHEN nl.subNetOfID <> 0 THEN 'cayenne-bg' 
            ELSE '' END AS SNcss,
    subquery.First_Login,
        (SELECT COUNT(DISTINCT netID) 
           FROM NetLog 
          WHERE (DATE(logdate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))) AS netID_count,
            SEC_TO_TIME(SUM(TIME_TO_SEC(nl.timeonduty))) AS Volunteer_Time,
            SEC_TO_TIME(subquery.total_timeonduty_sum) AS Total_Time
FROM (
    SELECT netID, subNetOfID, logdate, netcall, COUNT(*) AS stations, pb, logclosedtime, testnet, timeonduty, facility
      FROM NetLog
     WHERE (DATE(logdate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
     GROUP BY netID
) AS nl
LEFT JOIN (
    SELECT netID, SUM(firstLogin) AS First_Login, IFNULL(SUM(timeonduty), 0) AS total_timeonduty_sum
      FROM NetLog
     WHERE (DATE(logdate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
     GROUP BY netID
) AS subquery ON nl.netID = subquery.netID
GROUP BY netID
ORDER BY netID DESC;

");

// Execute the SQL query and store the result in $result variable
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Print the title
if (!empty($result)) {
            	 
    // top of the report, before the day 7 stuff 
   // echo "$cscount Stations, $netCnt Nets, $records Logins, $volHours of Volunteer Time";
 
	//echo '<div class="reportTitle">' . 'Today is: ' . date('l') . ', ' . date('Y/m/d') . '<br>' .
    echo '<div class=\'reportTitle\';>' . $netcall . ' Groups, ' . $cscount . ' Unique Stations, ' . $netCnt . ' Nets, ' . $records . ' Entries, <br>' . $volHours . ' of Volunteer Time</div>';
		 
    $title = "Today is: " . date("l") . ', ' . date('Y/m/d') .
    "<br>Past 7 DAYs NCM Report for " . $result[0]['netID_count'] . " Nets <br>";		
    
    echo '<h1 style="margin-left:100;">' . $title . '</h1>
        <div class="report-container">     
        <form>
          <!-- First line -->
          <div class="form-row">
            <div class="form-column">
              <label for="open_nets">Open Nets:</label>
              <input type="text" id="open_nets" name="open_nets" class="green-bg" value="">
            </div>
            <div class="form-column">
              <label for="one_entry">One Entry:</label>
              <input type="text" id="one_entry" name="one_entry" class="red-bg" value="">
            </div>
          </div>
          
          <!-- Second line -->
          <div class="form-row">
            <div class="form-column">
              <label for="prebuilt">Pre-Built:</label>
              <input type="text" id="prebuilt" name="prebuilt" class="blue-bg" value="">
            </div>
            <div class="form-column">
              <label for="test">Test Nets:</label>
              <input type="text" id="test" name="test" class="purple-bg" value="">
            </div>
          </div>
          
          <!-- Third line -->
          <div class="form-row">
            <div class="form-column">
              <label for="facility">Facility Nets:</label>
              <input type="text" id="facility" name="facility" class="yellow-bg" value="">
            </div>
          <div class="form-column">
              <label for="test">Sub Nets:</label>
              <input type="text" id="test" name="test" class="cayenne-bg" value="">
            </div>
          </div>
          
          <!-- Fourth line -->
          <div class="form-row">
            <label for="combo">Combo Nets:</label>
            <input type="text" id="combo" name="combo" class="combo-bg" value="" style="width: 300px;">
          </div>
        </form>
        </div>
    ' // this tick closes the echo at the $title line 
    ;
} else {
    echo 'No results found.';
} // overall end of IF after Print the title

// Check if there are any rows in the result set
if (!empty($result)) {
    // Start the table
    echo '<table>';

    
    // Create the grand total row over the headers
    echo '<tr class="sum-row">';
    echo '<td class="" >' . $result[0]['netID_count'] . '</td>';
    echo '<td class="" > All Days are UTC' . '</td>';
    echo '<td colspan="1" style="text-align: right;">Grand Totals:</td>';
    echo '<td class="" >' . $ttl_callsigns . '</td>';
    echo '<td colspan="1" style="text-align: right;">Total First Logins:</td>';
    echo '<td class="" >' . $ttl_first_logins . '</td>';
    echo '<td class="" >' . $time_on_duty . '</td>';
    echo '</tr>';
    echo '<tr>';
    
    // Start the Table header
    // Add the headers 
    foreach (array_keys($result[0]) as $column) {
        if ($column !== 'netID_count' && $column !== 'pb' && $column !== 'testnet' && $column !== 'PBcss' && $column !== 'LCTcss' && $column !== 'TNcss' && $column !== 'CCss' && $column !== 'Volunteer_Time' && $column !== 'FNcss' && $column !== 'SNcss') {
        
            echo '<th>' . $column . '</th>';
        }
    }
    
    echo '</tr>'; // end for Table header

    // Table rows
    $currentDate = null;
    foreach ($result as $rowIndex => $row) {
        // Calculate the value of $THEcss for this specific row based on the conditions
        $PBcss  = $row['PBcss'];     // Blue:    Prebuilt
        $LCTcss = $row['LCTcss'];    // Green:   Log Closed Time (its an open net) 
        $TNcss  = $row['TNcss'];     // Purple:  Test Nets
        $CCss   = $row['CCss'];      // Closed
        $FNcss  = $row['FNcss'];     // Yellow:  Facility Nets
        $SNcss  = $row['SNcss'];     // Ceyenne: Sub Nets
        
        // style every other row
        $THEcss = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
    
        if (!empty($LCTcss) && !empty($TNcss) && !empty($CCss)) {
            // ALL LCTcss and TNcss and CCss are set
            $THEcss = 'combo-bg';
        } elseif (!empty($FNcss) && !empty($PBcss)) {
            // Both FNcss and PBcss are set
            $THEcss = 'blueyellow-bg';
        } elseif (!empty($LCTcss) && !empty($TNcss)) {
            // Both LCTcss and TNcss are set
            $THEcss = 'greenpurple-bg';
        } elseif (!empty($LCTcss) && !empty($CCss)) {
            // Both LCTcss and CCss are set
            $THEcss = 'redgreen-bg';
        } elseif (!empty($TNcss) && !empty($CCss)) {
            // Both TNcss and CCss are set
            $THEcss = 'redpurple-bg';
        } elseif (!empty($PBcss) && !empty($CCss)) {
            // Both PBcss and CCss are set
            $THEcss = 'redblue-bg';
        } elseif (!empty($TNcss) && !empty($PBcss)) {
            // Both TNcss and PBcss are set
            $THEcss = 'bluepurple-bg';
        } elseif (!empty($LCTcss) && !empty($PBcss)) {
            // Both LCTcss and PBcss are set
            $THEcss = 'greenblue-bg';
        } elseif (!empty($LCTcss)) {
            // Only LCTcss is set
            $THEcss = $LCTcss;
        } elseif (!empty($TNcss)) {
            // Only TNcss is set
            $THEcss = $TNcss;
        } elseif (!empty($CCss)) {
            // Only CCss is set
            $THEcss = $CCss;
        } elseif (!empty($PBcss)) {
            // Only PBcss is set
            $THEcss = $PBcss;
        } elseif (!empty($FNcss)) {
            // Only FNcss is set
            $THEcss = $FNcss;
        } elseif (!empty($SNcss)) {
            // Only FNcss is set
            $THEcss = $SNcss;
        }
        
        
        // The Test for a netID and its CSS settings
      //  if ($row[netID] == 9685 ) { echo $row[netID] . ': LCTcss: ' . $LCTcss . ' CCss: ' . $CCss . ' FNcss: ' . $FNcss . ' THEcss: ' . $THEcss ;}        
    
        // Output the date and day of the week in a separate row for the start of a new day
        $date = substr($row['logdate'], 0, 10);
        $dayOfWeek = date('l', strtotime($date));        
             
            if ($currentDate !== $date) {
                echo '<tr class="date-row ">';
                echo '<td colspan="' . (count($row) + 1) . '">' . $date . ' (' . $dayOfWeek . ') </td>';
                //echo '<td colspan="' . (count($row) + 1) . '"> cnt here </td>'; 
            
                echo '</tr>';
                $currentDate = $date;
            }
            
            // The row color if there is one
            echo '<tr class="' . $THEcss . '">'; 
            
            // Column data you don't want to see
            foreach ($row as $column => $columnValue) {
                if ($column === 'netID_count' OR $column === 'pb' OR $column === 'testnet' OR $column === 'PBcss' OR $column === 'LCTcss' OR $column === 'TNcss' OR $column === 'CCss' OR $column === 'Volunteer_Time' OR $column === 'FNcss' OR $column === 'SNcss') {
                    continue;
                }
                   
                    //echo '<td class="centered">' . $columnValue . '</td>';
                    echo '<td class="centered">';
                    if ($column === 'netID') {
                        $netID = $columnValue;
                        echo '<a href="https://net-control.us/map.php?NetID=' . $netID . '" target="_blank" rel="noopener noreferrer">' . $netID . '</a>';
                    } else {
                        echo $columnValue;
                    }
            } // End foreach
    
                echo '</tr>'; 
                
} // End foreach
        // End the table
        echo '</table>';     
    } else {
        echo 'No results found.';
    } 
?>

<script>
/* The following function put UTC after logdate and logclosedtime column names in the title */
$(document).ready(function() {
    // Adding a word to one of the header <th> values
    // Find the second <th> element using :eq(1) selector (index starts from 0)
    var firstHeader    = $("th:eq(0)"); // netID
    var secondHeader   = $("th:eq(1)"); // logdate
    var thirdHeader    = $("th:eq(2)"); // netcall
    var fourthHeader   = $("th:eq(3)"); // station count
    var fifthhHeader   = $("th:eq(4)"); // logclosedtime
    var sixthHeader    = $("th:eq(5)"); // first login count
    var seventhHeader  = $("th:eq(6)");

    // Append the word using .append() method
    //secondHeader.append(" UTC");
    //fourthHeader.append(" UTC");
    //sixthHeader.append(" H:M:S");
    
    firstHeader.text("Net ID");
    secondHeader.text("Log Date UTC");
    thirdHeader.text("Net Call");
    fourthHeader.text("Stations");
    fifthhHeader.text("Closed Time UTC");
    sixthHeader.text("1st Logins");
    seventhHeader.text("H:M:S");

        $('tr').each(function () {
            var $row = $(this);
            var backgroundColor = $row.css('background-color');
            var netIDCell = $row.find('td:first-child');

            if (backgroundColor !== 'rgb(255, 255, 255)' && backgroundColor !== 'rgb(240, 240, 240)' && netIDCell.find('a').length > 0) {
                // Check if the row's background color is not white or off-white and the netID cell contains a link
                netIDCell.find('a').css('color', 'white');
            }
        });
});
</script>

</body>
</html>
