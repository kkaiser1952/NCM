<!doctype html>

<?php
	// This page gives a user the ability to choose which columns he sees and which he doesn't
	// It also allows a user to set a time zone for viewing
	// Written: 2018-12-18, timezone added 2020-02-29
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);
	
	require_once "dbConnectDtls.php";
	//phpinfo();
	$netcall = $_GET["netcall"];
	echo($netcall);
	
	// If columnViews is empty in the NetKind table then a default is set
	$sql = "SELECT columnViews
			  FROM NetKind 
			 WHERE `call` = '$netcall'
			"; 

		$stmt = $db_found->prepare($sql);
		$stmt -> execute();
	
		$columnViews = $stmt->fetchColumn(0); 
		//echo("<br>$columnViews");
		if (!$columnViews) { $columnViews = '17,18,24'; }
		
		echo("<br>$columnViews");
		//for ($i=1; $i <= strlen($columnViews); $i++) {}
?>

<html lang="en">
	
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Net Control Manager</title>
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >    

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/cookieManagement.js"></script>
	<script src="js/NetManager.js"></script>
    
<script>
var netcall = <?php echo "'$netcall'"; ?>;
var cookieName = "columnChoices_"+netcall;
var columnViews = <?php echo "'$columnViews'"; ?>;
	
// Here we check if there is a cookie, if there is not we use the defaults from above in the SQL
$(document).ready(function() {
	if (getCookie(cookieName)) {
		getCurrent();
	} else {
	// Check all the boxes coming in from either the cookie or from the default
		var testem = columnViews.split(',');  // Split the list into its number and run them with testem.forEach
		testem.forEach(showChecked);  // Show it on first pass
	}
	
	$( "#admincols").click(function() {
            $('.admincolumns').removeClass('hidden');
    });
});


</script>
	
<style>
	body {
/*		counter-reset: my-counter; */  /* uncomment these and those in label:before if you want numbers for each box */
	}
	
	label:before {
/*		counter-increment: my-counter;
		content: counter(my-counter) ". "; */
	}
	
	* {
	  box-sizing: border-box;
	}
	
	.row {
	  display: flex;
	}
			
			/* Create two equal columns that floats next to each other */
	.column {
	  flex: 25%;
	  padding: 10px;
	}
	
	/* Clear floats after the columns */
	.row:after {
	  content: "";
	  display: table;
	  clear: both;
	}
			/* The container */
	.container {
	  display: block;
	  position: relative;
	  padding-left: 35px;
	  margin-bottom: 12px;
	  cursor: pointer;
	  font-size: 22px;
	  -webkit-user-select: none;
	  -moz-user-select: none;
	  -ms-user-select: none;
	  user-select: none;
	}
	
	/* Hide the browser's default checkbox */
	.container input {
	  position: absolute;
	  opacity: 0;
	  cursor: pointer;
	  height: 0;
	  width: 0;
	}
	
	/* Create a custom checkbox */
	.checkmark {
	  position: absolute;
	  top: 0;
	  left: 0;
	  height: 25px;
	  width: 25px;
	  background-color: #eee;
	  border: 1px solid green;
	}
	
	/* On mouse-over, add a grey background color */
	.container:hover input ~ .checkmark {
	  background-color: #ccc;
	}
	
	/* When the checkbox is checked, add a blue background */
	.container input:checked ~ .checkmark {
	  background-color: #2196F3;
	}
	
	/* Create the checkmark/indicator (hidden when not checked) */
	.checkmark:after {
	  content: "";
	  position: absolute;
	  display: none;
	}
	
	/* Show the checkmark when checked */
	.container input:checked ~ .checkmark:after {
	  display: block;
	}
	
	/* Style the checkmark/indicator */
	.container .checkmark:after {
	  left: 9px;
	  top: 5px;
	  width: 5px;
	  height: 10px;
	  border: solid white;
	  border-width: 0 3px 3px 0;
	  -webkit-transform: rotate(45deg);
	  -ms-transform: rotate(45deg);
	  transform: rotate(45deg);
	}
	.red {
		color:red;
	}
	
	.myButtons {
		width: 80%;
	}
	
	.saveascookie {
    	font-size: 24pt;
    	font-weight: bold;
    	background: none !important;
        color: blue;
        border-radius: 15px;
        border: 2px solid #999;
        padding: 8px !important;
        font: inherit;
        cursor: pointer;
	}
	
</style>
	
</head>

<body>
	<h1>These options will write a persistent, first-party cookie to your system.<br>Cookies will expire after 10 days or whenever you decide.</h1>
	
	        <!-- disable the javascript.window.close before a Zoom presentation -->
    <form onsubmit="setCookie(cookieName, calculate(), 365); javascript:window.close();">
        <p style="font-size: 14pt; font-weight: bold;">Choose a time zone to use, the default is UTC
    	
    	    <label class="container">UTC (46)
				<input type="radio" name="intrests[]" checked onclick="tz_adj(0);" value="46" class="46" > 
				<span class="checkmark"></span>
			</label>

	
	<p style="font-size: 14pt; font-weight: bold;">Columns selected or deselected will appear on the next table refresh.</p>
	
		
	<div class="row">
    	
    	
		<div class="column" >
    		<!--
    		<label class="container">Row Number (0)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(0)" value="0" class="0">
				<span class="checkmark"></span>
			</label>
	-->
<!--			<label class="container red">Role (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled"  onclick="window.opener.toggleCol(1)" value="1" class="1" checked="checked">
				<span class="checkmark"></span>
			</label>
			
			<label class="container red">Mode (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(2)" value="2" class="2" checked="checked">
				<span class="checkmark"></span>
			</label>
			
			<label class="container red">Status (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(3)" value="3" class="3" checked="checked">
				<span class="checkmark"></span>
			</label>
			<label class="container red">Traffic (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(4)" value="4" class="4" checked="checked">
				<span class="checkmark"></span>
			</label>
-->	
			<label class="container">tt No. (5)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(5)" value="5" class="5" > 
				<span class="checkmark"></span>
			</label>
<!--			
			<label class="container red">Callsign (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(6)" value="6" class="6" checked="checked">
				<span class="checkmark"></span>
			</label>
			<label class="container red">First Name (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(7)" value="7" class="7" checked="checked">
				<span class="checkmark"></span>
			</label>
-->	
			<label class="container">Last Name (8)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(8)" value="8" class="8">
				<span class="checkmark"></span>
			</label>
	
			<label class="container">Tactical (9)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(9)" value="9" class="9">
				<span class="checkmark"></span>
			</label>
	
			<label class="container">Phone Number (10)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(10)" value="10" class="10">
				<span class="checkmark"></span>
			</label>
			<label class="container">eMail Address (11)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(11)" value="11" class="11">
				<span class="checkmark"></span>
			</label>
	
			<label class="container">Credentials (15)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(15)" value="15" class="15">
				<span class="checkmark"></span>
			</label>
				
			<label class="container">Time On Duty (16)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(16)" value="16" class="16">
				<span class="checkmark"></span>
			</label>
		
            <label class="container">Band (23)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(23)" value="23" class="23">
				<span class="checkmark"></span>
			</label> 
			<label class="container">Team (30)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(30)" value="30" class="30">
				<span class="checkmark"></span>
			</label>
        </div>
		<div class="column" >		
        
<!--
			<label class="container red">Time In (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(12)" value="12" class="12" checked="checked">
				<span class="checkmark"></span>
			</label>

			<label class="container red">Time Out (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(13)" value="13" class="13" checked="checked">
				<span class="checkmark"></span>
			</label>

			<label class="container red">Time Line Comments (required)
				<input type="checkbox" name="intrests[]"  disabled="disabled" onclick="window.opener.toggleCol(14)" value="14" class="14" checked="checked">
				<span class="checkmark"></span>
			</label>
-->	
						
			<label class="container">County (17)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(17)" value="17" class="17">
				<span class="checkmark"></span>
			</label>
			<label class="container">City (35)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(35)" value="35" class="35">
				<span class="checkmark"></span>
			</label>
			<label class="container">State (18)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(18)" value="18" class="18">
				<span class="checkmark"></span>
			</label>
			<label class="container">District (19)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(19)" value="19" class="19">
				<span class="checkmark"></span>
			</label>
			<label class="container">Grid (20)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(20)" value="20" class="20" >
				<span class="checkmark"></span>
			</label>
			<label class="container">Latitude (21)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(21)" value="21" class="21" >
				<span class="checkmark"></span>
			</label>
			<label class="container">Longitude (22)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(22)" value="22" class="22">
				<span class="checkmark"></span>
			</label> 
			
			<label class="container">W3W (24)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(24)" value="24" class="24">
				<span class="checkmark"></span>
			</label> 
			
			<!-- added 2021-09-03 -->
			<label class="container">APRS_CALL (31)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(31)" value="31" class="31">
				<span class="checkmark"></span>
			</label>
			<!-- added 2021-12-07 -->
			<label class="container">Country (32)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(32)" value="32" class="32">
				<span class="checkmark"></span>
			</label>
			<label class="container">Facility (33)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(30)" value="33" class="33">
				<span class="checkmark"></span>
			</label>
			<label class="container">onSite (34)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(30)" value="34" class="34">
				<span class="checkmark"></span>
			</label>

<!--
			<label class="container">TRFK-OPS (50) (Custom)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(50)" value="50" class="50">
				<span class="checkmark"></span>
			</label> 
			<label class="container">Section (51) (Section)
				<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(51)" value="51" class="51">
				<span class="checkmark"></span>
			</label>
-->
		</div>
	</div>
	
		
	<div class="myButtons">
		<input class="saveascookie" type="submit" value="Save as Cookie"> 

		<input type="button" onclick="javascript:window.close()" value="Close" style="float:right; padding-left: 20px;">
        <br><br>
            
	</div>
	
	<span></span>
	<div style="color:red; font-size: 18pt;">
		<p><?php echo("<br>Group selected default colums: $columnViews"); ?></p>
		<p>To delete this cookie from your computer, un-click any selected columns and click the 'Save as Cookie' button.</p>
		
		 <br><br>
		<input id="admincols" type="button" value="Admin"></button>
		 <br><br>
       
	</div>

	
	<div class="admincolumns hidden">
    	<label class="container">recordID (25)
			<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(25)" value="25" class="25" > 
			<span class="checkmark"></span>
		</label>
		<label class="container">ID (26)
			<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(26)" value="26" class="26" > 
			<span class="checkmark"></span>
		</label>
    	<label class="container">status (27)
			<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(27)" value="27" class="27" > 
			<span class="checkmark"></span>
		</label>
    	<label class="container">home (28)
			<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(28)" value="28" class="28" > 
			<span class="checkmark"></span>
		</label>
	    <label class="container">ipaddress (29)
			<input type="checkbox" name="intrests[]"  onclick="window.opener.toggleCol(29)" value="29" class="29" > 
			<span class="checkmark"></span>
		</label>
    </div> <!-- End admincolumns -->
	</form>
	
		<div> columnPicker.php </div>
<script>
    // This function controls the values of the time in and time out columns based on the time zone 
    function tz_adj(tz_amt) {
       // alert("in it");
        alert("Cookies for time display is not ready yet, come back again soon. Your selected offset is: "+tz_amt);
    }
    
</script>

</body>
</html>