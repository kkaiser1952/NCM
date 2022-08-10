<?php
// timeLineSearch.php
// This program produces a report of the time line for this callsign, it opens as a time line replacement
// Written: 2022-03-11
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    // This is for what3words usage
    /* https://developer.what3words.com/public-api/docs#convert-to-3wa */
    require_once "Geocoder.php";
        use What3words\Geocoder\Geocoder;
        use What3words\Geocoder\AutoSuggestOption;
            $api = new Geocoder("5WHIM4GD");
    
    // PHP Function to convert tod in seconds to days, hours, min, seconds		
function secondsToDHMS($seconds) {
	$s = (int)$seconds;
		return sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

$tbody = "<tbody style=\"counter-reset: sortabletablescope $maxCount;\">";

$header = '<table class="sortable2" id="pretimeline" style="width:100%;">
		<thead> 
			<tr>
				<th>Date Time</th>
				<th>ID</th>
				<th>Callsign</th>
				<th style="width:1400px; max-width:1400px;">Report</th>
			</tr>
		</thead> ';
    
// Pull the data from MySQL and re-build the time line display
$q = strip_tags($_POST["q"]);
    $q1 = explode(",",$q);
        $netID  = $q1[0];
        $findit = $q1[1];
        
        //echo "$netID $findit";
        
    $sql = ("
        SELECT netID, callsign, timestamp, comment, 
               (SELECT tactical FROM NetLog b 
                 WHERE netID = $netID AND b.recordID = a.recordID 
                   AND a.recordID <> 0) AS location
          FROM `TimeLog` a
         WHERE netID = $netID
            AND
               ( comment LIKE '%$findit' 
            OR comment LIKE '%$findit,'
            OR comment LIKE '%,$findit'
            OR comment LIKE '% $findit'
            OR comment LIKE '%$findit ')
            
         ORDER by timestamp DESC
    ");
    
    echo "$sql";
    
    echo ("$header");  
	echo ("$tbody");
	
	foreach($db_found->query($sql) as $row) {

?>