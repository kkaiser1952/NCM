<!doctype html>
<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    //require_once "dbConnectFCC.php";
    
    
    //This control what is displayed in the dropdown of existing nets around line 612 
    // $str = $_GET["str"]; //echo("str= $str<br>");
     
    // if ($str == '') {$andLine = "AND netcall = 'w0kcn' ";} 
    // else if ($str <> '' ){$andLine = "AND netCall = $str ";}
    
?>

<html lang="en">
<head>
    <title>emComm Log DB</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" />    
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	
<!--	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.table2excel.js"></script>
	<script type="text/javascript" src="js/jquery.freezeheader.js"></script>
<!--<script type="text/javascript" src="http://www.csvscript.com/dev/html5csv.js"></script> -->
	<script type="text/javascript" src="js/jQuery.fn.table2CSV.js"></script>
	<script type="text/javascript" src="js/jquery.simpleTab.min.js"></script>
	
<!-- Needed for Tableexport.jquery.plugin -->	
	<script type="text/javascript" src="js/tableExport.js"></script>
    <script type="text/javascript" src="js/jquery.base64.js"></script>
    <script type="text/javascript" src="js/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/jspdf/libs/base64.js"></script>

 
	<!-- Include the plugin's CSS and JS: -->
	<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
	<link rel="stylesheet" href="css/tabs.css" type="text/css"/>

    <!-- applesiini.net/projects/jeditable -->
	<script type="text/javascript" src="js/jeditable.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/sortTable.js"></script>
<!--	<script type="text/javascript" src="js/NetManagernew.js"></script> -->
	
	<script type="text/javascript" src="js/hamgridsquare.js"></script>

<script type="text/javascript">
	
function buildReport() {
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var dttm = d.getFullYear() + '/' +
	
    (month<10 ? '0' : '') + month + '/' +
    (day<10 ? '0' : '') + day;
	var grp 	= $("#grp").val(); 
	var rptType = $("input[name='rptType']:checked").val(); 
	var rptFetr = $("input[name='rptFetr']:checked").val(); 
	var rptHist = $("input[name='rptHist']").val();
	var rptSort = $("input[name='rptSort']:checked").val(); 
	
	$('#rptTitle').html(dttm+"<br>"+grp+" Activity Report for Past "+rptHist+" Months ");  
//	<span style=\"float:right;\">"+dttm+"</span>"
	
	$.post("NCMreportsBuilder.php", {grp : grp , rptType : rptType , rptFetr : rptFetr , rptHist : rptHist , rptSort : rptSort })
		.done(function( data ) {
			$('#theRpt').html( data );
	});
	
	
}

function findall() {
	//$("#rptFeature").removeClass("hidden");
}

function hidothers() {
	//$("#rptFeature").addClass("hidden");
}
	


</script>

<style>
body {
	 margin: 10px;
}
table {
	width: 75%;
}
#rptTitle {
	width: 25%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
th {
    text-align: center;
}
.h3size {
	font-size: 18pt; 
	font-weight: bold;
	color: #075400;
}
.smaller {
	font-weight: bold;
	color: #0030fc;
}
#rptTitle {
	width: 90%;
	font-size: 18pt;
	color:#060ef4;
}

.myclass {
	color:red; 
	font-weight:bold; 
    border-top:2px solid black;  
    border-bottom:2px solid black; 
    background-color:#dbf3f5;    
    font-size:12pt; 
}
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}
</style>

</head>
<body>
	
	<!-- https://stackoverflow.com/questions/10570904/use-jquery-to-change-a-second-select-list-based-on-the-first-select-list-option 
		
		
		
https://stackoverflow.com/questions/10698192/populating-multiple-dependent-drop-downs-from-database
		
	-->
 		
<div id="pgtitle"> Net Control Find Manager</div> 

<div id="rptTitle"></div>
<div id="theRpt"></div> 

	<h2>Select the find options below</h2>
	<br>
	
	
	<select id="try1" name="try1">    
            <option value="All" selected>Select one</option>
	<?php       	            	   	
        foreach($db_found->query("
        	select distinct netcall, county, state,
				concat_ws(' ', netcall, county, state) as val1,
				concat_ws(' ', netcall, county) as val2,
				concat_ws(' ', county, state) as val3
				from NetLog
				where netcall != ''
				  and county != ''
				order by val3
        	") as $row){
	        echo ("<option value='$row[val3]'>$row[val3]");

        }            
	?>
        </select>
	
	
	
	<br>
	<span class="group">Select the group
	
        <select id="grp" name="grp">    
            <option value="All" selected>Select all</option>
	<?php       	            	   	
        foreach($db_found->query("
        	SELECT distinct netcall 
			  FROM `NetLog` 
			 WHERE netID <> '0'
			   AND netcall <> '0'
			   AND netcall <> ''
			   AND netcall <> 'TE0ST'
        	") as $act){
            echo ("<option value='$act[netcall]'>$act[netcall]</option>");
        }            
	?>
        </select>
        
</span>    
    <!-- County -->

	<span class="county">&nbsp;&nbsp;&nbsp;Select the county
	
        <select id="grp" name="grp">    
            <option value="All" selected>Select all</option>
	<?php       	            	   	
        foreach($db_found->query("
        	SELECT distinct county, state
			  FROM `NetLog` 
			  where county <> ''
			  ORDER BY county
			 
        	") as $act){
            echo ("<option value='$act[county]'>$act[county], $act[state]</option>");
        }            
	?>
        </select>
     </span>
   <!-- Select the state -->
	<span class="state">&nbsp;&nbsp;&nbsp;Select the state
	
        <select id="grp" name="grp">    
            <option value="All" selected>Select all</option>
	<?php       	            	   	
        foreach($db_found->query("
        	SELECT distinct state 
			  FROM `NetLog` 
			  ORDER BY state
			 
        	") as $act){
            echo ("<option value='$act[state]'>$act[state]</option>");
        }            
	?>
        </select>
        </span>
    

    

</body>
</html>
