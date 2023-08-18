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
            alert("You clicked the first table cell with value: " + value);
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
            
            
            label {
              font-weight: bold;
            }
            
            .date-row {
              font-weight: bold;
              font-size: 16pt;
              color: darkgreen;
            }
            
           
            /* Style for 1 record and pre-built net */
            /* Style for the first two columns (red) */
            .redblue-bg {
              background-color: red;
              color: white;
            }
            
            /* Style for a net with at least one first time stations */
            .yellow-bg {
              background-color: yellow;
              color: blue;
            }
            
            /* Style for the third column (gradient) */
            .redblue-bg td:nth-child(3) {
              background-image: linear-gradient(to right, red, blue);
              color: white;
            }
            
            /* Style for the last three columns (blue) */
            .redblue-bg td:nth-last-child(-n + 3) {
              background-color: blue;
              color: white;
            }
            
             /* ---- */
            
            /* Style for 1 record and test net */
            /* Style for the first two columns (red) */
            .redpurple-bg {
              background-color: red;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .redpurple-bg td:nth-child(3) {
              background-image: linear-gradient(to right, red, purple);
              color: white;
            }
            
            /* Style for the last three columns (purple) */
            .redpurple-bg td:nth-last-child(-n + 3) {
              background-color: purple;
              color: white;
            }
            /* END: Style for 1 record and test net */
            
            /* ---- */
           
            /* Style for 1 record and open net */
            /* Style for the first two columns (red) */
            .redgreen-bg td:nth-child(-n + 2) {
              background-color: red;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .redgreen-bg td:nth-child(3) {
              background-image: linear-gradient(to right, red, green);
              color: white;
            }
            
            /* Style for the last three columns (green) */
            .redgreen-bg td:nth-last-child(-n + 3) {
              background-color: green;
              color: white;
            }
            /* END: Style for 1 record and open net */
            
            /* ---- */
            
            /* Style for combination label */
            .combo-bg {
              background-image: linear-gradient(to right, red 0%, green 25%, blue 60%, purple 75%);
              width: 300px;
            }
            
            /* Apply some general styling to the form rows and columns */
            .report-container {
              max-width: 600px; /* Adjust the width as needed */
              margin-left: 100;
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
        </style>
    </head>
<body>

<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer	
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("
SELECT 
    nl.netID,
    nl.logdate,
    nl.netcall,
    nl.stations,
    nl.pb,
    
    CASE
        WHEN nl.logclosedtime IS NULL THEN DATE_ADD((SELECT MAX(dttm) FROM NetLog), INTERVAL 30 MINUTE)
        WHEN nl.logclosedtime = '' THEN DATE_ADD((SELECT MAX(dttm) FROM NetLog), INTERVAL 30 MINUTE)
        ELSE nl.logclosedtime
    END AS logclosedtime,
    
    nl.testnet,
    
    CASE
        WHEN nl.pb = '0' THEN ''
        WHEN nl.pb = '1' THEN 'blue-bg'
        ELSE ''
    END AS PBcss,
    
    CASE
        WHEN nl.logclosedtime IS NOT NULL THEN ''
        WHEN nl.logclosedtime IS NULL THEN 'green-bg'
        ELSE ''
    END AS LCTcss,
    
    CASE
        WHEN nl.netcall IN ('TEST', 'TE0ST', 'TEOST', 'TE0ST') 
          OR nl.netcall LIKE '%test%' THEN 'purple-bg'
        ELSE ''
    END AS TNcss,
    
    CASE
        WHEN nl.stations = 1 THEN 'red-bg'
        ELSE ''
    END AS CCss,
    
    subquery.First_Login,
    
    (
        SELECT 
            COUNT(DISTINCT netID) 
        FROM NetLog 
        WHERE (
            DATE(logdate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        )
    ) AS netID_count,
    
    SEC_TO_TIME(SUM(TIME_TO_SEC(nl.timeonduty))) AS Volunteer_Time,
    SEC_TO_TIME(subquery.total_timeonduty_sum) AS Total_Time
FROM (
    SELECT 
        netID,
        logdate,
        netcall,
        COUNT(*) AS stations, 
        pb,
        logclosedtime,
        testnet,
        timeonduty
    FROM NetLog
    WHERE (DATE(logdate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
    GROUP BY netID
) AS nl
LEFT JOIN (
    SELECT
        netID,
        SUM(firstLogin) AS First_Login,
        IFNULL(SUM(timeonduty), 0) AS total_timeonduty_sum
    FROM NetLog
    WHERE (DATE(logdate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
    GROUP BY netID
) AS subquery ON nl.netID = subquery.netID
GROUP BY nl.netID
ORDER BY nl.netID DESC;

");

// Execute the SQL query and store the result in $result variable
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Print the title
if (!empty($result)) {
  //  $title = "Past 7 days NCM Report for " . $result[0]['netID_count'] . " Nets <br>
  //   Today is: " . date("l") .", " . date("Y/m/d") . "<br>";
     
    $title = "Past 7 days NCM Report for " . $result[0]['netID_count'] . " Nets <br>"
        . "Today is: " . date("l") . ", " . date("Y/m/d") . "<br>";
    
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

    // Start the Table header
    echo '<tr>';
    
    // Add the headers 
    foreach (array_keys($result[0]) as $column) {
        if ($column !== 'netID_count' && $column !== 'pb' && $column !== 'testnet' && $column !== 'PBcss' && $column !== 'LCTcss' && $column !== 'TNcss' && $column != 'CCss' && $column !== 'Total_Time') {
            echo '<th>' . $column . '</th>';
        }
    }
    echo '</tr>'; // end for Table header

    // Table rows
    $currentDate = null;
    foreach ($result as $rowIndex => $row) {
        // Calculate the value of $THEcss for this specific row based on the conditions
        $PBcss = $row['PBcss'];
        $LCTcss = $row['LCTcss'];
        $TNcss = $row['TNcss'];
        $CCss = $row['CCss'];
        
        // style every other row
        $THEcss = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
    
        if (!empty($PBcss) && !empty($TNcss) && !empty($CCss)) {
            // ALL LCTcss and TNcss and CCss are set
            $THEcss = 'combo-bg';
        } elseif (!empty($PBcss) && !empty($CCss)) {
            // Both PBcss and CCss are set
            $THEcss = 'redblue-bg';
        } elseif (!empty($LCTcss) && !empty($CCss)) {
            // Both LCTcss and CCss are set
            $THEcss = 'redgreen-bg';
        } elseif (!empty($TNcss) && !empty($CCss)) {
            // Both TNcss and CCss are set
            $THEcss = 'redpurple-bg';
        } elseif (!empty($LCTcss) && !empty($TNcss)) {
            // Both LCTcss and TNcss are set
            $THEcss = 'greenpurple-bg';
            
         } elseif (!empty($LCTcss) && !empty($PBcss)) {
            // Both LCTcss and TNcss are set
            $THEcss = 'greenblue-bg';
            
        } elseif (!empty($PBcss) && !empty($TNcss)) {
            // Both LCTcss and TNcss are set
            $THEcss = 'bluepurple-bg';
        } elseif (!empty($PBcss)) {
            // Only PBcss is set
            $THEcss = $PBcss;
        } elseif (!empty($LCTcss)) {
            // Only LCTcss is set
            $THEcss = $LCTcss;
        } elseif (!empty($TNcss)) {
            // Only TNcss is set
            $THEcss = $TNcss;
        } elseif (!empty($CCss)) {
            // Only CCss is set
            $THEcss = $CCss;
        } 
        
        //echo ($netcall, $CCss, $THEcss);
        
        // The Test for a netID and its CSS settings
        //if ($row[netID] == 9735 ) { echo $row[netID] . ': LCTcss: ' . $LCTcss . ' THEcss: ' . $THEcss . ' CCss: ' . $CCss;}
    
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
                if ($column === 'netID_count' OR $column === 'pb' OR $column === 'testnet' OR $column === 'PBcss' OR $column === 'LCTcss' OR $column === 'TNcss' OR $column === 'CCss' OR $column === 'Total_Time') {
                    continue;
                }
                    //echo '<td>' . $columnValue . '</td>';
                    echo '<td class="centered">' . $columnValue . '</td>';
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
    var secondHeader = $("th:eq(1)");
    var fourthHeader = $("th:eq(4)");
    var sixthHeader  = $("th:eq(6)");

    // Append the word using .append() method
    secondHeader.append(" UTC");
    fourthHeader.append(" UTC");
});

</script>

</body>
</html>
