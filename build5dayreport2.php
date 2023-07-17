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
    </head>
<body>

<?php
// The purpose of this page/program is to send a daily report of NCM to my messages
// Written: 2023-06-21, first day of summer	
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Access to MySQL

// Your SQL query
$sql = $db_found->prepare("SELECT netID, logdate, netcall, COUNT(*) AS count,
            pb,   /* testnet, */
            (SELECT COUNT(DISTINCT netID)
             FROM NetLog
             WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)) AS netID_count,
             logclosedtime,
             /*SUM(timeonduty) as total_time*/
             CONCAT(
                    LPAD(FLOOR(SUM(timeonduty) / 3600), 2, '0'), ':',
                    LPAD(FLOOR(MOD(SUM(timeonduty), 3600) / 60), 2, '0'), ':',
                    LPAD(MOD(SUM(timeonduty), 60), 2, '0')
                  ) AS Volunteer_Time     
        FROM NetLog
       WHERE logdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
       GROUP BY netID, netcall
       ORDER BY netID DESC
");

$stuff = "stuff here";

// Execute the SQL query and store the result in $result variable
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// JS functions
//$jsFunctions = "<script src='js/NetManager-p2.js'></script>"

// CSS styles for the report table
$cssStyles = "
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
    
    .red-row {
        background-color: #087f47;
        color: white;
        font-weight: bold;
    }
    
    .red-bg {
        background-color: red;
        color: white;
    }
    
    .red-netID {
        background-color: red;
        color: white;
    }
    
    .green-bg {
        background-color: green;
        color: white;
    }
    
    .green-netID {
        background-color: green;
        color: white;
    }
    
    .blue-bg {
        background-color: blue;
        color: white;
        font-weight: bold;
    }
    
    .blue-netID {
        background-color: blue;
        color: white;
        font-weight: bold;
    }
    
    .purple-bg {
        background-color: purple;
        color: white;
        font-weight: bold;
    }
    
    .purple-netID {
        background-color: purple;
        color: white;
        font-weight: bold;
    }
    
    label {
      font-weight: bold;
    }
    
    .date-row {
      font-weight: bold;
      font-size: 14pt;
      color: darkgreen;
    }
    
    .redblue-bg {
      background-color: linear-gradient(to right, red 50%, blue 50%) !important;
    }
    
    .redpurple-bg {
      background-color: linear-gradient(to right, red 50%, purple 50%) !important;
    }
    
    .redgreen-bg {
      background-color: linear-gradient(to right, red 50%, green 50%) !important;
    }


</style>
";

// Print CSS styles
echo $cssStyles;

// Print the title
if (!empty($result)) {
    $title = "Past 5 days NCM Report for " . $result[0]['netID_count'] . " Nets <br> Today is: " . date("l") .", " . date("Y/m/d") . "<br>";
    
    echo '<h1>' . $title . '</h1>
    
     <form>  <!-- This adds a legend to the top of the report -->
        <label for="open_nets">Open Nets:</label>
        <input type="text" id="open_nets" name="open_nets" class="green-bg" value="">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <label for="one_entry">Only One Entry:</label>
        <input type="text" id="one_entry" name="one_entry" class="red-bg" value=""><br>
        
        <label for="prebuilt">Pre-Built:</label>
        <input type="text" id="prebuilt" name="prebuilt" class="blue-bg" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        <label for="test">Test Nets:</label>
        <input type="text" id="test" name="test" class="purple-bg" value=""><br><br>
      </form>
    '
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
        if ($column !== 'netID_count' && $column !== 'pb') {
            echo '<th>' . $column . '</th>';
        }
    }
    echo '</tr>'; // end for Table header

    // Table rows
    $currentDate = null;
    foreach ($result as $rowIndex => $row) {
        // Check if logclosedtime is null or empty
        $isClosed = empty($row['logclosedtime']);
        // Get the row class
        $rowClass = $rowIndex % 2 === 0 ? 'even-row' : 'odd-row';
        
        $rowClass .= $isClosed ? ' red-row' : '';
        // Add red-bg class if count is 1
        if ($row['count'] == 1) {
            $rowClass .= ' red-bg ';
        } 
        
        if ($row['total_time']) {
            $total_time = gmdate('H:i:s', $total_time);
        }
        
        // Pre-built net background
        if ($row['pb'] == 1 && $row['count'] == 1) {
            $rowClass = 'redblue-bg';
        } elseif ($row['pb'] == 1) {
            $rowClass = 'blue-bg';
        }
         
        // Test/TE0ST net background
        $validNetcalls = ['TEST', 'TE0ST', 'TEOST', 'TE0ST'];
        if (in_array(strtolower($row['netcall']), array_map('strtolower', $validNetcalls), true) && $row['count'] == 1) {
            $rowClass = 'redpurple-bg';
        } elseif (in_array(strtolower($row['netcall']), array_map('strtolower', $validNetcalls), true)) {
            $rowClass .= ' purple-bg';
        }
 
        // Output each column value in a table row
            echo '<tr class="' . $rowClass . '">';

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
            if ($column === 'netID_count' OR $column === 'pb') {
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Define the function
  function checkAndSetColor(tdIndex, valueToCheck, bgColor) {
    // Get the value of the specified <td> using .eq()
    var tdValue = $("tr td").eq(tdIndex - 1).text();

    // Check if the value matches the specified value
    if (tdValue.trim() === valueToCheck) {
      // Set the background color of the first <td> to the specified color
      $("tr td").eq(0).css("background-color", bgColor);
      // Set the background color of the entire <tr> to the specified color
      $("tr").css("background-color", bgColor);
    }
  }

  // Call the function with the desired parameters
  //checkAndSetColor(4, "1", "red");
});

</script>

</body>
</html>

