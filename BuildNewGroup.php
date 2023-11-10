<?php
	// The purpose of this page/program is to add a new group to the NetKind table
	// This page when submitted calls itself to insert the data into the table  using the PHP below
	// 
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    //require_once "checkForNewCall.php";
    
    //Form submitted
	if(isset($_POST['submit'])) {
    // Find what the next ID will be incase we need it to be the dflt_kind and dflt_freq values
    // This would happen if 'Name Your Own' is chosen
   
    // This SQL is the only way to find the next increment of the ID index in this table
    $sql = "SELECT Auto_increment FROM information_schema.tables 
    					 WHERE table_name='NetKind' 
    					   AND table_schema='ncm'";
    
    	$stmt = $db_found->prepare($sql);
	    $stmt -> execute();
	    
	    $newID = $stmt->fetchColumn(0); //echo "newID will be $newID";

	
		//	echo("Name: " . $_POST['personalName'] . "<br />\n");
		$personalName 	= ucwords($_POST['personalName']); //echo "$personalName";
		$personalCall 	= strtoupper($_POST['personalCall']);
		$personalEmail 	= strtolower($_POST['personalEmail']);
		$groupName 		= ucwords($_POST['groupName']);
		$groupCall 		= strtoupper($_POST['groupCall']);
		$orgType        = strtoupper($_POST['orgType']);

		$netfreqdflt        = $_POST['netfreq']; 
			if ($netfreqdflt == 7 ) {$netfreqdflt = $newID;}
		$netkinddflt		= $_POST['netkind']; 
			if ($netkinddflt == 7 ) {$netkinddflt = $newID;}
		$netfreqval		= $_POST['netfreqval']; //echo "$netfreqval";
		$netkindval		= ucwords($_POST['netkindval']); //echo "$netkindval";
		
		$r1c1 = $_POST['r1c1'];	$r1c2 = $_POST['r1c2']; $r1c3 = $_POST['r1c3']; $r1c4 = $_POST['r1c4'];
		$row1 = ("$r1c1,$r1c2,$r1c3,$r1c4");
		
		$r2c1 = $_POST['r2c1']; $r2c2 = $_POST['r2c2']; $r2c3 = $_POST['r2c3']; $r2c4 = $_POST['r2c4'];
		$row2 = ("$r2c1,$r2c2,$r2c3,$r2c4");
		
		$r3c1 = $_POST['r3c1']; $r3c2 = $_POST['r3c2']; $r3c3 = $_POST['r3c3']; $r3c4 = $_POST['r3c4'];
		$row3 = ("$r3c1,$r3c2,$r3c3,$r3c4");
		
		$r4c1 = $_POST['r4c1']; $r4c2 = $_POST['r4c2']; $r4c3 = $_POST['r4c3']; $r4c4 = $_POST['r4c4'];
		$row4 = ("$r4c1,$r4c2,$r4c3,$r4c4");
		
		$r5c1 = $_POST['r5c1']; $r5c2 = $_POST['r5c2']; $r5c3 = $_POST['r5c3']; $r5c4 = $_POST['r5c4'];
		$row5 = ("$r5c1,$r5c2,$r5c3,$r5c4");
		
		$r6c1 = $_POST['r6c1']; $r6c2 = $_POST['r6c2'];
		$row6 = ("$r6c1,$r6c2");

	// Because its auto increment I don't have to tell it that the next id value is newID from above
	$sql = "INSERT INTO NetKind (
		`call`, org, dflt_kind, kindofnet, dflt_freq, freq, contact_call, contact_name, contact_email,
		orgType, row1, row2, row3, row4, row5, row6, columnViews)
		VALUES ('$groupCall', '$groupName', '$netkinddflt', '$netkindval', '$netfreqdflt', '$netfreqval', 	'$personalCall', '$personalName', '$personalEmail', '$orgType', '$row1', '$row2', '$row3', '$row4',
		        '$row5', '$row6', '17,18')";
echo($sql);
	// Insert the new information to the table NetKind
	$db_found->exec($sql);     
	
	// The below redirects back to the net-control.us 
	echo '<script type="text/javascript">
           window.location = "http://net-control.us/index.php";
           location.reload(forceGet);
		  </script>';

	} // End of isset

?>

<!doctype html>

<html lang="en">
<head>
    <title>Build New Groups Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    
    <!-- The meta tag below sends the user to the help file after two hours -->
    <meta http-equiv="refresh" content="7200; URL=https://net-control.us/help.php" >
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="Amateur Radio Net Control Manager" >
    <meta name="author" content="Keith Kaiser, WA0TJT" >
    
    <meta name="Rating" content="General" >
    <meta name="Revisit" content="1 month" >
    
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager" >
    <meta name="robots" content="noindex" > 
    
    <!-- https://fonts.google.com -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Allerta" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Stoke" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cantora+One" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Risque" >
    
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 2018-03-04 -->
	
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 2018-1-18 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 2018-1-18 -->
	<link rel="stylesheet" type="text/css" href="css/tabs.css" >					<!-- 2018-1-17 2018-1-18 -->
	
	<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1/jquery-ui.min.css" >	
	
	<link rel="stylesheet" type="text/css" href="css/NetManager.css" > 
		
		
	<!--Below:  https://css-tricks.com/snippets/jquery/fallback-for-cdn-hosted-jquery/. -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		if (typeof jQuery == 'undefined') {
			document.write(unescape("%3Cscript src=\"js/jquery.min.js\"%3E%3C/script%3E"));
		}
	</script>		<!-- v3.3.1. 2018-3-01 -->
	
	<script src="js/validate.newnet.entries.js"></script>	    <!-- Added 2018-07-13 -->
	<!-- End My javascript -->
	
	<!-- http://www.appelsiini.net/projects/jeditable -->
	<script src="js/jquery.jeditable.js"></script>								<!-- 1.8.1 2018-04-05 -->

	
<script>	
// Put test scripts here
$(document).ready(function () {
	$('#groupName').blur(function() {
	    var str = $('#groupName').val(); //alert(str);
		var matches = str.match(/\b(\w)/g); 
		var acronym = matches.join('').toUpperCase(); // usese each letter to create name i.e. TCRC
			// if the acronym is too short, use the full name minus any spaces i.e. Crew2273
			if (acronym.length < 3) {
				acronym = str.replace(/ /g,'');
			}
			
			$('#groupCall').val(acronym);
			
			$("#getGroupCall").removeClass("hidden");
			$(".donothing").removeClass("hidden");  //The button this refrences has no action, its just there to make the user feel good about the entry in the box.
	});
	
	$("#netfreq").change(function(){ 
		//alert("hello");
		var svalue = $('#netfreq').val(); //alert (svalue);
			if (svalue == 7 ) {//alert("it worked");
				var netfreqval = prompt("Enter a frequency like one of these:\n 146.790Mhz,T107.2Hz\n443.275 MHz Simplex\n145.310(-) No Tone\nEcholink KE0EAV-R\n20 Meters \nDO NOT USE A COLON!", "Enter a frequency or band");
				$(".netfreqval").removeClass("hidden");
			}
			$('.netfreqval').val(netfreqval);
	});
	$("#netkind").change(function(){ 
		//alert("hello");
		var svalue = $('#netkind').val(); //alert (svalue);
			if (svalue == 7 ) {//alert("it worked");
			var netkindval = prompt("Enter a short description to represent the kind of then.\nFor example:\nHF Digital\nWeekly HF Voice\nYouth Weekend\nBut keep in mind 'EVENT' gives you things like:\nBike Race\nBirthday Party, etc", "Enter the kind of net");
			$(".netkindval").removeClass("hidden");
			}
			$('#netkindval').val(netkindval);
	});
}); // End Document Ready function

// This function is called after the user enters a groupcall
function CreateNewUserID() {
	//alert("Now in CreateNewUserID Function");
	var thiscall  = $("#personalCall").val();
			thiscall = thiscall.toUpperCase();
	var thisemail = $("#personalEmail").val();
	var thisname  = $("#personalName").val();
	
		var q = thiscall+","+thisemail+","+thisname;
			//alert (q);
		
			$.ajax({
				type: 'POST',
				url: 'checkForNewCall.php',
				data: {q: q},
				success: function(response) {
					//alert(response);
				},
				error:	 function() {
			  		alert('Sorry no success in checkForNewCall.php.');
		  		}
			});
} // End of CreateNewUserID() function 

function processGroup() {
	var group = $("#selectGroup option:selected").val();
		alert(group); // 3:2:19
			
}

</script>
	 
<style>
	 /* Put test CSS here */
	 .hidden {
	     visibility: hidden;
	     width: 0px;
	     height: 0px;
	     display:none;
	 }

	 body {
		 background-color: white;
		 padding: 10px;
	 }
	 
	 .getInfoForm {
		 padding: 10px;
	 }
	 
	 #yesGroupCall {
		
	 }
	 
	 #noGroupCall {
		 margin-left: 25px;
	 }
	 
	 .groupCall {
		 text-transform: uppercase;
	 }
	 
	 #personalCall {
	 	text-transform:uppercase;
	 }
	 
	 #rightCorner {   /* Enclosing box */
		position: relative;
		bottom: 5px;
		left: 5px;
		width: 450px;
		padding-right: 10px;
	 }
	 	 
	 .flex-container {
		 width: 100%;
	 	 display: flex;
	 	 flex-wrap: nowrap;
	 }
	 
	 .flex-container > div {
		  margin: 10px;
		  text-align: center;
		  line-height: 75px;
		  font-size: 30px;
		  background-color: #d5f1f0;
		  border: solid 1px black;
	 }
	 .thirdthird {
		/* text-align: center; */
	 }
	 .opening {
		 width: 90%;
		 font-size: 18pt;
		 color: #3806fd;
	 }
	 label {
		 font-size: 18pt;
		 color: #3806fd;
		 padding: 10px;
	 }
	 #personalName, groupName {
		 text-transform: capitalize;
	 }
	 #personalCall {
		 text-transform: uppercase;
	 }
	 #getGroupCall {
		 text-transform: uppercase;
	 }
	 #personalEmail {
		 text-transform: lowercase;
	 }
	 .firstthird {
		 background-color: white;
	 }
	 tr th td,input {
		 opacity: 0.7;
	 }
	 input[type=button], input[type=submit] {
		 background-color: green;
		 border: none;
		 color: white;
		 padding: 10px 20px;
		 text-decoration: none;
		 margin: 4px 2px;
		 cursor: pointer;
	 }
	 .url {
		 width:100%;
		 text-align: center;

	 }
	 #selectGroup {
		 width: 150px;
		 margin: 10px;
	 }
	 #selectGroup:focus {
		 min-width: 150px;
		 width: auto;
	 }
	 /* ourfreqs is needed for browsers like Chrome & FireFox to properly display the Upper Right Corner table in here. */
	 #ourfreqs {
    	 float: inherit;
	 }
</style>

</head>
<body>

<div>
	<p class="opening">This is a <u>one-time setup</u> to create a new Group. From then on that group will appear in the dropdown 'Select Group or Call' when starting a new net.<br><br>
 <!--   	<font color="red">And still in BETA</font> -->
	</p>
		 
</div> <!-- End of opening -->

<form name="getInfoForm" class="getInfoForm" action="<?PHP echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="" method="post" novalidate autocomplete="off" >
	

	<div class="firstthird">
		<label for="personalName">Please enter <u>your</u> full name:</label>
		<input id="personalName" type="text" name="personalName" size="50" placeholder="Full Name" autofocus autocomplete="false" />
		<span class="error hidden">Full name is </span>
	
		<label for="personalCall">Please enter <u>your</u> personal callsign:</label>
		<input id="personalCall" type="text" name="personalCall" size="10" pattern="\d?[a-zA-Z]{1,2}\d{1,4}[a-zA-Z]{1,4}$" placeholder="WA0TJT" autocomplete="false" />
		<span class="error hidden">Your call sign is </span>
		
		<label for="personalEmail">Enter an email address where I can reach you:</label>
		<input id="personalEmail" type="email" name="personalEmail" placeholder="Email Address" size="60" autocomplete="false"  />
		<span class="error hidden">eMail is </span>

	</div> <!-- End firstthird personalName, personalCall-->
	<div class="secondthird">
						
		<label for="groupName">What is the full name of the Group you are setting up? For example: "Twin Cities Repeater Club"</label>
		<input id="groupName" type="textarea" name="groupName" placeholder="Group/club/org Full Name" size="150" autocomplete="false"  onblur="CreateNewUserID()" />
		
		<label for="orgType">What kind of group is this?</label>
		<input type="radio" name="orgType" value="CLUB">Club
		<input type="radio" name="orgType" value="SOCIAL">Social
		<input type="radio" name="orgType" value="ARES">ARES/RACES
		<input type="radio" name="orgType" value="ZEVENT">Event
		<input type="radio" name="orgType" value="SCOUTS">Scouts
		<input type="radio" name="orgType" value="MARS">Mars
		<input type="radio" name="orgType" value="OTHER">FACILITY
		<img src="images/newMarkers/q-mark-in-circle.png" id="QmarkInCircle" class="Qfacility" alt="q-mark-in-circle" width="15px" height="" style="padding-bottom: 25px; margin-left: 1px; background-color: #e0e1e3;" onclick="location.href='https://net-control.us/help.php#facility'" />
		<input type="radio" name="orgType" value="OTHER">Other
		
		<label for="groupCall">What is your groups call sign, or make one up</label>
		<input id="groupCall" class=" groupCall" type="text" name="groupCall" autocomplete="false" placeholder="Group Call Sign"/>
		<input class="hidden donothing" type="button" value="OK">
			
	</div> <!-- End secondthird -->


	<div>
		<label for="netfreq">Select a default frequency for your nets, if its not listed select "Name Your Own". </label>
		<select id="netfreq" name="netfreq" class="netfreq" title="Select Freq">
			<option value="0">Select Your Group Default Frequency</option>
			<option value="7">Name Your Own</option>
				<?php 
					foreach($db_found->query("
						SELECT id, freq,
					    	CASE WHEN CONVERT(SUBSTRING(freq,1,3),UNSIGNED INTEGER) > 400.0 THEN '70cm'
							     WHEN CONVERT(SUBSTRING(freq,1,3),UNSIGNED INTEGER) > 140.0 THEN '2m'			     
							     WHEN CONVERT(SUBSTRING(freq,1,3),UNSIGNED INTEGER) < 140.0 THEN 'HF'
							     ELSE 'Unknown'
							END AS 'band'
						  FROM NetKind
						 WHERE freq NOT LIKE '%Test%'
						   AND freq NOT LIKE '%Eye%'
						   AND freq NOT LIKE '%KE0%'
						   AND kindofnet NOT LIKE '%Name Your Own%'
						   AND freq <> 'Name Your Own '
						 ORDER BY id ")
							as $net) {
						echo ("<option value='$net[id]'> $net[freq] </option> \n ");
			        }     
				?>
		</select>
			<br>
			<label for="netfreqval" class="netfreqval hidden">Your Named Frequency: </label>
			<input  id="netfreqval" class="netfreqval hidden" type="text" name="netfreqval" />
	</div>
	
	<div>
		<label for="netkind">Select a default type of net, if its not listed<br>select "Name Your Own". </label>
		<select id="netkind" name="netkind" title="Select a Net Type">    
			<option value="0" >Select a type of Net</option>
			<option value="7">Name Your Own</option>
				<?php 
					foreach($db_found->query("
						SELECT id, kindofnet
						  FROM NetKind
						 WHERE freq NOT LIKE '%Test%'
					/*	   AND freq NOT LIKE '%Eye%' */
						   AND freq NOT LIKE '%KE0%'
						   AND kindofnet <> ''
						 ORDER BY kindofnet ")
							as $net) {
						echo ("<option value='$net[id]'> $net[kindofnet] </option> \n ");
			        }     
				?>
		</select>
			<br>
			<label for="netkindval" class="netkindval hidden">Your Named Kind of Net: </label>
			<input  id="netkindval" class="netkindval hidden" type="text" name="netkindval" />

</div>

<hr style="border: 5px solid green; border-radius: 3px;">

<div>
	<label for="rightCorner">Upper right corner consists of up to 4 columns across and 6 rows.<br>Use of this matirx is optional and customizable for your Group.<br>The information below is just an example.<br>Delete what you don't need.</label>
</div>

<div id="rightCorner">
<div id="upperRightCorner" > 
	
   <table id="ourfreqs" style="margin-bottom:30px;">
	   <tbody>
	   <tr> <th class="r1c1 nobg"><input type="text" name="r1c1" size="10" value="Type" /></th> 
			<th class="r1c2 nobg"><input type="text" name="r1c2" size="10" value="Primary" /></th>
	   		<th class="r1c3 nobg"><input type="text" name="r1c3" size="10" value="Secondary" /></th> 
	   		<th class="r1c4 nobg"><input type="text" name="r1c4" size="10" value="DMR" /></th> 
	   </tr>
	   <tr> <td class="r2c1 nobg1"><input type="text" name="r2c1" size="10" value="Repeater" /></td> 
			<td class="r2c2 nobg2"><input type="text" name="r2c2" size="10" value="146.790-/107.2" /></td>
	   		<td class="r2c3 nobg2"><input type="text" name="r2c3" size="10" value="147.330+" /></td> 
	   		<td class="r2c4 nobg2"><input type="text" name="r2c4" size="10" value="MCI-ARES" /></td> 
	   </tr>
	   <tr> <td class="r3c1 nobg1"><input type="text" name="r3c1" size="10" value="Simplex" /></td> 
			<td class="r3c2 nobg2"><input type="text" name="r3c2" size="10" value="146.570" /></td>
	   		<td class="r3c3 nobg2"><input type="text" name="r3c3" size="10" value="146.580" /></td> 
	   		<td class="r3c4 nobg2"><input type="text" name="r3c4" size="10" value="444.4625" /></td> 
	   </tr>
	   <tr> <td class="r4c1 nobg1"><input type="text" name="r4c1" size="10" value="E O C" /></td> 
			<td class="r4c2 nobg"><input type="text"  name="r4c2" size="10" value="Clay EOC" /></td>
	   		<td class="r4c3 nobg"><input type="text"  name="r4c3" size="10" value="Dispatch" /></td>  
	   		<td class="r4c4 nobg"><input type="text"  name="r4c4" size="10" value="Platte EOC" /></td> 
	   </tr>
	   <tr> <td class="r5c1 nobg1"><input type="text" name="r5c1" size="10" value="Sheriff" /></td> 
			<td class="r5c2 nobg2"><input type="text" name="r5c2" size="10" value="(816)407-3732" /> </td>
	   		<td class="r5c3 nobg2"><input type="text" name="r5c3" size="10" value="(816)407-3732" /> </td> 
	   		<td class="r5c4 nobg2"><input type="text" name="r5c4" size="10" value="(816)407-3732" /> </td> 
	   </tr>
	   <tr> <td class="r6c1 nobg1"><input type="text" name="r6c1" size="10" value="URL" /> </td> 
			<td class="r6c2 nobg2" colspan="3"> <input class="url" type="text" name="r6c2" size="100" value="http://www.kcnorthares.org" /></td> </tr> 
	   </tbody>
   </table>
   
</div> <!-- End upperRightCorner -->
</div> <!-- End div-rightCorner -->
	
<div>
	<label for="submitform"><p>A net preamble and closing can be created anytime from the start page using the <span style="color: red;">'New'</span> button in the upper left corner.</p><p>After you submit this form you will be redirected back to the start page. Refresh the page then select 'Start A New Net' again and this time your group should be in the dropdown.</p>
	</label>
	<input id='submitform'  type="submit" name="submit" value="Submit" >
	<input class="" type="button" value="Cancel" title="Cancel" onClick="window.location.href=window.location.href">
</div>
	
</form>
	<p>BuildNewGroup.php</p>
</body>
</html>
