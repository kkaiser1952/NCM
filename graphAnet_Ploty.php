<!DOCTYPE html>
<!-- This set of demos is down with Ploty.js
     First get the data from the NetLog table in MySQL
     Then plot a Linear Relationship between the net number and the number of stations attending.
     
     The second set plots the exact values vs. the week number of the net, you choose scatter or lines
-->
<?PHP
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $netcall = $_POST['netcall']; 
    $netcall = 'mesn';
    
    $sql = ("
        SELECT COUNT(callsign) as yvalue,      
               DATE(logdate) as xvalue
          FROM `NetLog` 
         WHERE netCall = '$netcall'
           AND logdate > DATE_SUB(now(), INTERVAL 12 MONTH)
         GROUP BY netID
    ");
    
    $rowno = 0;
    
    $xvalues = '';  $yvalues = '';
    foreach($db_found->query($sql) as $row) {
        $rowno = $rowno + 1;
        
       // $xvalues .= $row[xvalue].',';
        $yvalues .= $row[yvalue].',';    
        $xvalues .= 'net'.$rowno.','; 
        $x2values .= $rowno.',';
    }
    
    $xvalues  = substr($xvalues, 0, -1)."";
    $yvalues  = substr($yvalues, 0, -1)."";
    $x2values  = substr($x2values, 0, -1)."";
    
?>

<html>

<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<body>
    
    
    <div id="myPlot2" style="width:100%;"></div>

<script>
    var xArray = <?php echo "[$x2values]" ?>;    
    var yArray = <?php echo "[$yvalues]" ?>;
    
    var data = [
      {x:xArray, y:yArray, mode:"markers"},
      {x:[1,20], y:[20,45], mode:"line"},
    ];
    
    var layout = {
      xaxis: {range: [1, 20], title: "Net Count"},
      yaxis: {range: [20, 45], title: "Net Number"},  
      title: "Predicted Net Change"
    };
    
    Plotly.newPlot("myPlot2", data, layout);
</script>


<p>
<label>Enter X and Y Values:</label>

<p>X values:<br>
<input id="xvalues" style="width:95%" type="text" value=" <?php echo $xvalues ?> "></p>

<p>Y values:<br>
<input id="yvalues" style="width:95%" type="text" value="<?php echo $yvalues ?>"></p>

<button onclick='plot("scatter")'>Scatter</button>
<button onclick='plot("lines")'>Draw Lines</button>

<div id="myPlot" style="width:100%;"></div>


<script>
function plot(type) {
var xArray = document.getElementById("xvalues").value.split(',');
var yArray = document.getElementById("yvalues").value.split(',');
var mode = "lines";
if (type == "scatter") {mode = "markers"}
Plotly.newPlot("myPlot", [{x:xArray, y:yArray, mode:mode, type:"scatter"}]);
}
</script>

</body>
</html>