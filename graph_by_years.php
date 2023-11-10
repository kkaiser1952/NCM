<!DOCTYPE html>
<!-- https://www.chartjs.org/docs/latest/
     
     Reports via bar graph and line graph showing unique netIDs vs. unique callsigns by year
-->

<?PHP
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
        
    $sql = ("SELECT COUNT(distinct(netID))      as Y_netID, 
                    COUNT(distinct(callsign))   as Y_stations,
                    COUNT(distinct(netcall))    as Y_netCall,
                    COUNT(distinct(grid))       as Y_grid,
                    COUNT(distinct(state))      as Y_state,
                    YEAR(dttm) as X_years 
               FROM `NetLog` 
              WHERE netID <> 0 
                AND YEAR(dttm) <> 0 
             GROUP BY X_years
           ");
    
    $rowno      = 0;
    
    $X_years    = ''; 
    
    $Y_netIDs   = '';
    $Y_stations = '';
    $Y_netCall  = '';
    $Y_grid     = '';
    $Y_state    = '';
    
    foreach($db_found->query($sql) as $row) {
        $rowno      = $rowno + 1;
        
        $X_years    .= $row[X_years].',';
        
        $Y_netID    .= $row[Y_netID].',';    
        $Y_stations .= $row[Y_stations].',';
        $Y_netCall  .= $row[Y_netCall].',';
        $Y_grid     .= $row[Y_grid].',';
        $Y_state    .= $row[Y_state].',';

        // Arrays of both X and Y values combined (not used here)
        $xY_netID    .= "{x:$rowno, y:$row[Y_netID]},";
        $xY_stations .= "{x:$rowno, y:$row[Y_stations]},";
        $xY_netCall  .= "{x:$rowno, y:$row[Y_netCall]},";
        $xY_grid     .= "{x:$rowno, y:$row[Y_grid]},";
        $xY_state    .= "{x:$rowno, y:$row[Y_state]},";
    }
   
?>

<html>

<script 
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

<body>
    
    <canvas id="myChart" style="width:100px; height: 50px;"></canvas>
    
<script>
    // Bar Chart
    var barColors = ["Red", "Blue", "Yellow", "Green", "Tan", "Orange", "Purple", "Brown"];
    
    var X_yearss = <?php echo "[$X_years]" ?>; 
    var Y_netIDs = <?php echo "[$Y_netID]" ?>;
    var Y_stations = <?php echo "[$Y_stations]" ?>;
    
    new Chart("myChart", {
        type: 'bar',
        data: {
            labels: X_yearss,
            datasets: [{
                  label: "Number of Nets",
                  type: "line",
                  yAxesGroup: "2",
                  backgroundColor: ["lightgreen"],
                  data: Y_netIDs,
                  pointBackgroundColor: "#55bae7",
                   pointBorderColor: "#55bae7",
                   pointHoverBackgroundColor: "#55bae7",
                   pointHoverBorderColor: "#55bae7",
                  pointHoverRadius: 15,
                  radius: 15,
              }, {
                  label: "Unique Stations",
                  type: "bar",
                  yAxesGroup: "1",
                  backgroundColor: barColors,
                  hoverBackgroundColor: barColors,
                  borderColor: ["Black"],
                  borderWidth: 2,
                  data: Y_stations
              }] // End datasets
        }, // End data     
        options: {
            title: {
              display: true,
              text: "Net Control Manager Year by Year Chart",
              fontSize: 30, 
              fontColor: "darkblue",
            }, // end title
            
          //  plugins: {
                legend: {
                    display: true,
                    labels: {
                        fontSize: 24
                    }
                }, // end legend
                
                scales: {
                    xAxes: [{
                        ticks: {
                            fontSize: 20
                        }
                    }], // end xAsex
                    yAxes: [{
                        ticks: {
                            fontSize: 20
                        }
                    }] // end yAxes
                } // end scales
         //   } // end plugins:
        } // end options   
    });
    
 </script>

</body>
</html>