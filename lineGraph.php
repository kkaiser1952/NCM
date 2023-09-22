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
                   SELECT DATE(logdate) AS logdate_date, 
       COUNT(DISTINCT netID) AS distinct_netID_count
FROM NetLog
WHERE netID <> 0
GROUP BY DATE(logdate)  
HAVING logdate_date <> '0000-00-00'
ORDER BY logdate_date;
                ");

                // Execute the prepared query
                $sql->execute();

                // Fetch data and format it as JavaScript array
                $data = array();
                while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo "['" . $row['logdate_date'] . "', " . $row['distinct_netID_count'] . "],";
                }
                ?>
            ];

            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
                title: 'Distinct NetID Count Over Time',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: { title: 'Log Date' },
                vAxis: { title: 'Distinct NetID Count' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('lineChart'));

            chart.draw(data, options);
        }
    </script>
</body>
</html>
