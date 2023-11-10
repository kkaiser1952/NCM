<!DOCTYPE html>
<html>
<head>
    <title>Line Graph with Google Charts</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <div class="container">
        <div id="lineChart"></div>
    </div>

    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Embed PHP data directly into JavaScript
            var chartData = [
                ['logdate_date', 'distinct_netID_count'],
                <?php
// Include your database connection script (dbConnectDtls.php)
require_once "dbConnectDtls.php";

// SQL query with a condition to exclude '0000-00-00'
$sql = $db_found->prepare("
    SELECT logdate_date, netID_count
    FROM (
        SELECT DATE(logdate) AS logdate_date, 
            COUNT(DISTINCT netID) AS netID_count
        FROM NetLog
        WHERE netID <> 0
        GROUP BY DATE(logdate)
        HAVING logdate_date <> '0000-00-00'
    ) AS filtered_data
    ORDER BY logdate_date;
");

// Execute the prepared query
$sql->execute();

// Fetch data and format it as JavaScript array
$data = array();
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $date = date('Y-m-d', strtotime($row['logdate_date'])); // Format the date as 'YYYY-MM-DD'
    echo "['" . $date . "', " . $row['netID_count'] . "],";
}
?>

            ];

            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
                title: 'Distinct NetID Count Over Time',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'Log Date',
                    ticks: calculateCustomTicks(chartData) // Set custom tick values
                },
                vAxis: { 
                    title: 'Distinct NetID Count',
                    viewWindow: {
                        min: 0,
                        max: 20
                    }
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('lineChart'));

            chart.draw(data, options);
        }

        // Function to calculate custom tick values
        function calculateCustomTicks(chartData) {
            var customTicks = [];
            var numRows = chartData.length;
                console.log('numRows: '+numRows);

            // Extract years from the data and calculate the tick interval
            var minYear = parseInt(chartData[0][0].split('-')[0]);
            var maxYear = parseInt(chartData[numRows - 1][0].split('-')[0]);
                console.log("minyear: " + minYear + " maxYear: " + maxYear);

            if (maxYear - minYear < 9) {
                // Show tick every year if the range is less than 9 years
                for (var year = minYear; year <= maxYear; year++) {
                    customTicks.push(year.toString());
                }
            } else {
                // Calculate the tick interval for a range of 9 years
                var tickInterval = Math.ceil((maxYear - minYear) / 9); 
                    console.log(tickInterval);
                
                for (var year = minYear; year <= maxYear; year += tickInterval) {
                    customTicks.push(year.toString());
                }
            }

            return customTicks;
        }
    </script>
</body>
</html>
