<!doctype html>

<?php
    // TimelineJS JSON data format
    // https://timeline.knightlab.com/docs/json-format.html
    
	require_once "dbConnectDtls.php";	    
	
	//$q = intval($_GET['q']); 
	$q = 2797;
	

	$sql = "SELECT 
	           (CASE 
                    WHEN callsign = ' ' THEN 'GENCOMM'
                    ELSE callsign
                END)             AS callsign,
           
	           YEAR(timestamp)   AS yr,
	           MONTH(timestamp)  AS mo,
	           DAY(timestamp)    AS day,
	           HOUR(timestamp)   AS hour,
               MINUTE(timestamp) AS min,
               SECOND(timestamp) AS sec,
	           comment           AS text    
	          FROM TimeLog 
	         WHERE netID = '$q'
	         ORDER BY timestamp, FIELD(callsign, 'GENCOMM') DESC
	        
	       ";

  foreach ($db_found->query($sql) as $row) {
// This creates the events in timelineJS
    $events
    ["events"][]  = 
    ['start_date' => 
        ['second' => $row['sec'],
         'minute' => $row['min'],
         'hour'   => $row['hour'],
         'month'  => $row['mo'],
         'day'    => $row['day'],
         'year'   => $row['yr']
        ],
         'group'  => $row['callsign'],
         'text'   => 
        ['text'   => $row['text']
        ],
    ];
  }
  
$mytitle ["title"] =  [ text =>  [text => "Net id: $q"  ]];   // <div class="tl-text-content"><p>Net id: 1650</p></div>

// The merge puts the two arrays into one
$data = array_merge($mytitle, $events);
//echo json_encode($data);
              
?>

<html lang="en">
    
<head>
<title>Amateur Radio Net Control Manager Net Visual Time Line</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0" > 

<meta name="description" content="Amateur Radio Net Control Manager" >
<meta name="author" content="Keith Kaiser, WA0TJT" >

<meta name="Rating" content="General" >
<meta name="Revisit" content="1 month" >
<meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager, Time Line" >

    <!-- ============ Time Line Project =========== -->
    <link title="timeline-styles" rel="stylesheet" href="css/timelineJS-local.css">
<!--
<link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">

<link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/fonts/font.abril-droidsans.css">
-->
<!-- ============ Time Line Project =========== -->
<script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script> 

<style>
      .tl-text-content {
          color:red;
      }
</style>


</head>

<body>

<div id='timeline-embed' style="width: 100%; height: 600px"></div>

<script type="text/javascript">
    
    var mytitle = '{"title" : {' + '"text"' + ':' + '{' + '"text"' + ':' + '"Net id: 1650"' + "}},"; 
        
    var timeline_json =  <?php echo json_encode($data); ?>;  

          // two arguments: the id of the Timeline container (no '#')
          // and the JSON object or an instance of TL.TimelineConfig created from
          // a suitable JSON object
          window.timeline = new TL.Timeline('timeline-embed', timeline_json);
</script>

</body>
</html>