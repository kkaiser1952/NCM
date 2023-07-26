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
            
            /*
            .red-row {
                background-color: #087f47;
                color: white;
                font-weight: bold;
            } */
            
            /* Style for nets with 1 entry */
            .red-bg {
                background-color: red;
                color: white;
            }
            
            /*
            .red-netID {
                background-color: red;
                color: white;
            } */
            
            /* Style for Open nets */
            .green-bg {
                background-color: green;
                color: white;
            }
            
            /*
            .green-netID {
                background-color: green;
                color: white;
            } */
            
            /* Style for Pre-Built nets */
            .blue-bg {
                background-color: blue;
                color: white;
                font-weight: bold;
            }
            
            /*
            .blue-netID {
                background-color: blue;
                color: white;
                font-weight: bold;
            } */
            
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
            
            
            /* ALL BELOW ARE WORKING */
           
            /* Style for 1 record and pre-built net */
            /* Style for the first two columns (red) */
            .redblue-bg {
              background-color: red;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .redblue-bg td:nth-child(3) {
              background-image: linear-gradient(to right, red, blue);
              color: white;
            }
            
            /* Style for the last three columns (purple) */
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
           
            /* Style for 1 record and closed net */
            /* Style for the first two columns (red) */
            .redclear-bg td:nth-child(-n + 2) {
              background-color: red;
              color: white;
            }
            
            /* Style for the third column (gradient) */
            .redclear-bg td:nth-child(3) {
              background-image: linear-gradient(to right, red, transparent);
              color: white;
            }
            
            /* Style for the last three columns (green) */
            .redclear-bg td:nth-last-child(-n + 3) {
              background-color: transparent;
              color: white;
            }
            /* END: Style for 1 record and open net */
            
            /* ---- */
            
            /* Style for open, test net */
            /* Style for the first two columns (green) */
   /*        .greenputple-bg td:nth-child(-n + 2) {
              background-color: green;
              color: white;
            }
    */        
            /* Style for the third column (gradient) */
    /*        .greenpurple-bg td:nth-child(3) {
              background-image: linear-gradient(to right, green, purple);
              color: white;
            }
    */       
            /* Style for the last three columns (green) */
    /*        .greenpurple-bg td:nth-last-child(-n + 3) {
              background-color: purple;
              color: white;
            } 
    */       /* END: Style for open/test net net */
            
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
$sql = $db_found->prepare("SELECT netID, logdate, netcall, count, pb, logclosedtime, testnet,
       (CASE
       	  WHEN pb = '0' THEN ''
          WHEN pb = '1' THEN 'blue-bg'
          ELSE ''
       END) AS PBcss,

       (CASE
          WHEN logclosedtime IS NOT NULL THEN ''
          WHEN logclosedtime IS NULL THEN 'green-bg'
          ELSE ''
       END) AS LCTcss,

       (CASE
	       WHEN netcall in('TEST', 'TE0ST', 'TEOST', 'TE0ST') THEN 'purple-bg'
          ELSE ''
       END) AS TNcss,

       (SELECT COUNT(DISTINCT netID)
        FROM NetLog
        WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)) AS netID_count,

       CONCAT(
            LPAD(FLOOR(SUM(timeonduty) / 3600), 2, '0'), ':',
            LPAD(FLOOR(MOD(SUM(timeonduty), 3600) / 60), 2, '0'), ':',
            LPAD(MOD(SUM(timeonduty), 60), 2, '0')
       ) AS Volunteer_Time,

       (CASE
          WHEN count = 1 THEN 'red-bg'
          ELSE ''
       END) AS ccss

FROM (
   SELECT netID, logdate, netcall, COUNT(*) AS count, pb, logclosedtime, testnet, timeonduty
   FROM NetLog
   WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
   GROUP BY netID  -- Only group by netID in the subquery
) AS Subquery
GROUP BY netID
ORDER BY netID DESC;
");

$sql->execute();
$resultRows = $sql->fetchAll(PDO::FETCH_ASSOC);

// Create a variable to hold the final value
$THEcss = '';

foreach ($resultRows as $row) {
    $PBcss = $row['PBcss'];
    $LCTcss = $row['LCTcss'];
    $TNcss = $row['TNcss'];
    $ccss = $row['ccss'];

    // Check the values of PBcss, LCTcss, TNcss, and ccss
    if (!empty($PBcss) && !empty($TNcss) && !empty($ccss)) {
        // ALL LCTcss and TNcss and ccss are set
        $THEcss = 'combo-bg';
    } elseif (!empty($PBcss) && !empty($ccss)) {
        // Both PBcss and ccss are set
        $THEcss = 'redblue-bg';
    } elseif (!empty($LCTcss) && !empty($ccss)) {
        // Both LCTcss and ccss are set
        $THEcss = 'redgreen-bg';
    } elseif (!empty($TNcss) && !empty($ccss)) {
        // Both TNcss and ccss are set
        $THEcss = 'redpurple-bg';
    } elseif (!empty($LCTcss) && !empty($TNcss)) {
        // Both LCTcss and TNcss are set
        $THEcss = 'greenpurple-bg';
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
    } elseif (!empty($ccss)) {
        // Only ccss is set
        $THEcss = $ccss;
    } else {
        // None of the combinations are set, so take the value of whichever column is set
        if (!empty($PBcss)) {
            $THEcss = $PBcss;
        } elseif (!empty($LCTcss)) {
            $THEcss = $LCTcss;
        } elseif (!empty($TNcss)) {
            $THEcss = $TNcss;
        } elseif (!empty($ccss)) {
            $THEcss = $ccss;
        } else {
            // If none of the columns have a value, you may set a default value here if needed
            $THEcss = 'x';
        }
    }

    //$rowClass =  $THEcss ;
    $THEcss = $THEcss;
    
    // Now $THEcss will hold the desired value based on the conditions above for each row in the $resultRows array
    if (!empty($THEcss)) {
    echo "THEcss for netID: " . $row['netID'] . " is: $THEcss <br>" . PHP_EOL;
}}


//$stuff = "stuff here";

// Execute the SQL query and store the result in $result variable
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report for " . $result[0]['netID_count'] . " Nets <br>
     Today is: " . date("l") .", " . date("Y/m/d") . "<br>";
    
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
}

// Check if there are any rows in the result set
if (!empty($result)) {
    // Start the table
    echo '<table>';

    // Table header
    echo '<tr>';
    
    // Add the headers 
    foreach (array_keys($result[0]) as $column) {
        if ($column !== 'netID_count' && $column !== 'pb' && $column !== 'testnet' && $column !== 'PBcss' && $column !== 'LCTcss' && $column !== 'TNcss' && $column != 'ccss') {
            echo '<th>' . $column . '</th>';
        }
    }
    echo '</tr>'; // end for Table header

    // Table rows
    $currentDate = null;
    foreach ($result as $rowIndex => $row) {
        
        //$rowClass =  '$THEcss' ;
        
        if ($row['total_time']) {
            $total_time = gmdate('H:i:s', $total_time);
        }
 
        // Output each column value in a table row
            echo '<tr class="' . $THEcss . '">';

        // Output the date and day of the week in a separate row for the start of a new day
        $date = substr($row['logdate'], 0, 10);
        $dayOfWeek = date('l', strtotime($date));
        
        if ($currentDate !== $date) {
            echo '<tr class="date-row">';
            echo '<td colspan="' . (count($row) + 1) . '">' . $date . ' (' . $dayOfWeek . ')</td>';
            echo '</tr>';
            $currentDate = $date;
        }
        
        // Column data you don't want to see
        foreach ($row as $column => $columnValue) {
            if ($column === 'netID_count' OR $column === 'pb' OR $column === 'testnet' OR $column === 'PBcss' OR $column === 'LCTcss' OR $column === 'TNcss' OR $column === 'ccss') {
                continue;
            }

            // If logclosedtime is null or empty, leave the column entry empty
            if ($isClosed && $column === 'logclosedtime') {
                echo '<td></td>';
            } else {
                echo '<td>' . $columnValue . '</td>';
            }
        }

        echo '</tr>'; 
    }

    // End the table
    echo '</table>';
} else {
    echo 'No results found.';
}
?>

<script>
$(document).ready(function() {
    // Adding a word to one of the header <th> values
    // Find the second <th> element using :eq(1) selector (index starts from 0)
    var secondHeader = $("th:eq(1)");
    var fourthHeader = $("th:eq(4)");

    // Append the word using .append() method
    secondHeader.append(" UTC");
    fourthHeader.append(" UTC");
});

</script>

</body>
</html>
