<!DOCTYPE html>
<!-- Graph net attendance over the past year
-->

<?PHP
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $netcall = $_POST['netcall']; 
    $netcall = strtoupper('n6hew');
        
    $sql = ("SELECT COUNT(distinct(callsign)) as Y_stations, 
                    DATE_FORMAT(dttm,'%b %y') AS X_months
               FROM `NetLog` 
              WHERE netcall LIKE '$netcall'
                AND logdate > DATE_SUB(now(), INTERVAL 12 MONTH)
              GROUP BY X_months
              ORDER BY dttm ASC
           ");
           
           //echo "$sql";
    
    $rowno = 0;
    
    $X_months    = ''; 
    $Y_stations  = '';
    
    foreach($db_found->query($sql) as $row) {
        $rowno   = $rowno + 1;
        
          $X_months    .= "'".$row[X_months]."',";
          $Y_stations  .= $row[Y_stations].',';    
          
          // Arrays of both X and Y values combined (not used here)
          $xY_stations .= "{x:$rowno, y:$row[Y_stations]},";
    }
    
?>

<html>

<script 
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

<body>

    <canvas id="myChart" style="width:100px;"></canvas>

<script>
    // Bar Chart
    var barColors   = ["Red", "Blue", "Yellow", "Green", "Tan", "Orange", "Purple", "Brown", "Red", "Blue", "Yellow", "Green", "Tan", "Orange"];
    
    var X_monthss   = <?php echo "[$X_months]" ?>;   
    
    var Y_stations  = <?php echo "[$Y_stations]" ?>;
    
    //var netcall     = ",";
    var thecall     = <?php echo "'$netcall'" ?>;
    
    var optionsText = "12 Months Attendance for "+ thecall ;
    
    new Chart("myChart", {
        type: 'bar',
        data: {
            labels: X_monthss,
            datasets: [{
               //   label: "Number of Stations",
                  type: "line",
                  yAxesGroup: "2",
               //   backgroundColor: ["lightgreen"],
                  borderColor: ["red"],
                   pointBackgroundColor: "#55bae7",
                   pointBorderColor: "#55bae7",
                   pointHoverBackgroundColor: "#55bae7",
                   pointHoverBorderColor: "#55bae7",
                   radius: 15,
                   
                  data: Y_stations 
              }, {
            /*      label: "Unique Stations",
                  type: "bar",
                  yAxesGroup: "1",
                  backgroundColor: barColors,
                  hoverBackgroundColor: barColors,
                  borderColor: ["Black"],
                  borderWidth: 2,
                  data: Y_stations */
              }] // End datasets
        }, // End data     
        options: {
            title: {
              display: true,
              text: optionsText ,
              fontSize: 30, 
              fontColor: "darkblue",
            }, // end title
            
          //  plugins: {
                legend: {
                    display: false,
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