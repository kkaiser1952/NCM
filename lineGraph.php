<!DOCTYPE html>
<!--
<?php phpinfo(); ?>
-->
<html>
<head>
    <title>Line Graph</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <canvas id="lineChart"></canvas>
    </div>

    <script>
        $(document).ready(function() {
            // Function to render the chart using Chart.js
            function renderChart(data) {
                const dates = data.map(item => item.logdate_date);
                const counts = data.map(item => item.distinct_netID_count);

                const ctx = document.getElementById('lineChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Distinct NetID Count',
                            data: counts,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.2)',
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day' // Display labels by day
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Execute the SQL query using PDO in PHP
            // Execute the SQL query using PDO in PHP
// Execute the SQL query using PDO in PHP
<?php
// Include your database connection script (dbConnectDtls.php)
require_once "dbConnectDtls.php";


// SQL query
$sql = $db_found->prepare("
    SELECT logdate, COUNT(DISTINCT netID) AS distinct_netID_count
    FROM NetLog
    GROUP BY logdate
    ORDER BY logdate
");

$sql->execute();

// Fetch data and format the date in ISO 8601 format in PHP
$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
$data = array();

foreach ($rows as $row) {
    $iso8601Date = date('Y-m-d\TH:i:s', strtotime($row['logdate'])); // Format the date
    $data[] = array(
        'logdate_date' => $iso8601Date,
        'distinct_netID_count' => $row['distinct_netID_count']
    );
}

// Convert data to JSON
$data = json_encode($data);
?>



            // Pass the fetched data to the JavaScript function for chart rendering
            var chartData = <?php echo $data; ?>;
            renderChart(chartData);
        });
    </script>
</body>
</html>
