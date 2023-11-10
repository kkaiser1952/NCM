<?php
	// The purpose of this page/program is to allow editing of the Point of Interest (poi) table
	// Written: 2020-08-11
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    
    // This comes from index.php when the 'editPoi' button is clicked
    // Get the netID of this net from the div idofnet
    
    //$netID = 2667;
    
    
  
  echo("@16 in buildrightCorner.php call= $call");
    
	// This becomes the very top of the page
	//echo("<h2 style='color:red;'>Any changes here will be reflected for the:<br> $call $activity</h2>");
	
	$sql = $db_found->prepare("SELECT id, `call`, org, dflt_kind, kindofnet, dflt_freq, freq, contact_call, contact_name,
				   contact_email, org_web, comments, row1, row2, row3, row4, row5, row6, box4, box5
			  FROM NetKind
			 WHERE `call` = '$call'
			 LIMIT 1
	");
	
		$sql->execute();
		
		$result = $sql->fetch();
		
		$id = $result[id];  echo "<br>@32 in buildRightCorner.php the id= $id";
		$contact_email = $result[contact_email]; //echo("<br>email= $contact_email");
		
		$rcols = explode(",","$result[row1]");
			$r1c1 = $rcols[0];
			$r1c2 = $rcols[1];  // echo "<br>r1c2= $r1c2";
    		$r1c3 = $rcols[2];	 //echo "<br>r1c3= $r1c3";
    		$r1c4 = $rcols[3];
    		$r1c5 = $rcols[4];
    		
    	$rcols = explode(",","$result[row2]");
			$r2c1 = $rcols[0];
    		$r2c2 = $rcols[1];
    		$r2c3 = $rcols[2];
    		$r2c4 = $rcols[3];
    		$r2c5 = $rcols[4];
    		
    	$rcols = explode(",","$result[row3]");
			$r3c1 = $rcols[0];
    		$r3c2 = $rcols[1];
    		$r3c3 = $rcols[2];
    		$r3c4 = $rcols[3];
    		$r3c5 = $rcols[4];
    		
    	$rcols = explode(",","$result[row4]");
			$r4c1 = $rcols[0];
    		$r4c2 = $rcols[1];	//echo "<br>r4c2= $r4c2";
    		$r4c3 = $rcols[2];
    		$r4c4 = $rcols[3];
    		$r4c5 = $rcols[4];

		$rcols = explode(",","$result[row5]");
			$r5c1 = $rcols[0];
    		$r5c2 = $rcols[1];
    		$r5c3 = $rcols[2];
    		$r5c4 = $rcols[3];
    		$r5c5 = $rcols[4];
    		
    	$rcols = explode(",","$result[row6]");
			$r6c1 = $rcols[0];
    		$r6c2 = $rcols[1];
    		$r6c3 = $rcols[2];
    		$r6c4 = $rcols[3];
    		$r6c5 = $rcols[4];
    		
    		// echo "<br>r1c2= $r1c2";
?>

<!doctype html>

<html lang="en">
<head>
    <title>Build or Edit the POI's</title>
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



var id = <?php echo "$result[id]" ?>;  //alert("@139 id= "+id);  // this is good
function collectNew() {
	
	var newrow1 = $("input[name=r1c1]").val()+","+$("input[name=r1c2]").val()+","+$("input[name=r1c3]").val()+","+$("input[name=r1c4]").val();  //alert("@221 in buildRightCorner.php newrow1= "+newrow1);
	// @221 in buildRightCorner.php newrow1= XXX,Repeater,Simplex,DMR
	var newrow2 = $("input[name=r2c1]").val()+","+$("input[name=r2c2]").val()+","+$("input[name=r2c3]").val()+","+$("input[name=r2c4]").val();  //alert("@222 in buildRightCorner.php newrow1= "+newrow2);
	// @222 in buildRightCorner.php newrow1= Primary, 147.330+/151.4, 146.790-/107.2, Echolink
	var newrow3 = $("input[name=r3c1]").val()+","+$("input[name=r3c2]").val()+","+$("input[name=r3c3]").val()+","+$("input[name=r3c4]").val();  //alert("@225 in buildRightCorner.php newrow1= "+newrow3);
	// @225 in buildRightCorner.php newrow1= Secondary-XX, 146.570, 147.580, KD0EAV-R
	var newrow4 = $("input[name=r4c1]").val()+","+$("input[name=r4c2]").val()+","+$("input[name=r4c3]").val()+","+$("input[name=r4c4]").val();  //alert("@226 in buildRightCorner.php newrow1= "+newrow4);
	// @226 in buildRightCorner.php newrow1= E O C -YY, Clay EOC, Dispatch, Platte EOC
	var newrow5 = $("input[name=r5c1]").val()+","+$("input[name=r5c2]").val()+","+$("input[name=r5c3]").val()+","+$("input[name=r5c4]").val();  //alert("@227 in buildRightCorner.php newrow1= "+newrow5);
	// @227 in buildRightCorner.php newrow1= Sheriff -ZZ, (816)407-3732, (816)407-3700, (816)858-3521
	var newrow6 = $("input[name=r6c1]").val()+","+$("input[name=r6c2]").val();  
	// newrow1 to newrow6 are all OK
	
		
	runupdate(newrow1, newrow2, newrow3, newrow4, newrow5, newrow6);
	
} // end of collectNew
	
function runupdate(newrow1, newrow2, newrow3, newrow4, newrow5, newrow6) {
	//alert(newrow1);
	//alert(newrow2);
	
	//alert("@161 id= "+id);  // OK here
	var name  = prompt("Please enter your first and last name.");
	var call  = prompt("please enter your call sign.");  //alert("@214 call= "+call);   //OK
	var email = prompt("Please enter your email.");  //alert("@238 name = "+name);  // This is good

//	if (name !== '' && call !== '' && email !== '') {	
		$.ajax({
			type: 'POST',
			url: 'updateCorner.php',
			data: {id: id, row1: newrow1, row2: newrow2, row3: newrow3, row4: newrow4, row5: newrow5, row6: newrow6, name: name, call: call, email: email
				  },
			success: function(response) {
				//alert(response);
				netControl = window.open('https://net-control.us');
				//myWindow.close();
			} // end of success
		}); // end of ajax call
//	} // end of test for non blank name, call and email
//	else {alert('You must enter your name, callsign and email address to proceed. Press submit again.')}
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
		 text-align: center;
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
		 background-color: pink;
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
	 #newGroupBuild {
		 color: blue;
		 width: 80%;
	 }
	 
	 /* ==== Below here is from BuildNewGroup.php ===== */
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
		 text-align: center;
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
		 background-color: pink;
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
</style>

</head>
<body>
	
	<h2>Alpha: Not yet operational!</h2>
	
<div id="newGroupBuild" class="hidden"> <!-- by default this should be hidden -->
	<h3>If you are hoping to edit the information in the upper right corner for your group you must first display the last net your group created. Then select the 'edit' button in the upper right corner.</h3>
	
	<div>
	<p class="opening">This is a <u>one-time setup</u> to customize your request to build a profile for your group.
	</p>
		 
		</div> <!-- End of opening -->

<form name="getInfoForm" class="getInfoForm" action="<?PHP echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="" method="post" novalidate autocomplete="off" >
	
<div class="flex-container">
	
	<div class="secondthird">
				
		<label for="groupName">What is the full name of the Group you are setting up? For example: <br>"Twin Cities Repeater Club".</label>
		<input id="groupName" type="textarea" name="groupName" placeholder="Group/club/org Full Name" size="100" autocomplete="false"  onblur="CreateNewUserID()" />
	</div> <!-- End secondthird personalEmail, groupName, -->
	
	<div class="thirdthird">
		<div id="getGroupCall" class ="">	 
			<label for="groupCall">Please accept this or edit to add your Group callsign:</label>
			<input id="groupCall" class=" groupCall" type="text" name="groupCall" autocomplete="false" />
			<br>
			<input class="hidden donothing" type="button" value="OK">
			
		</div>
	</div> <!-- End fifththird Yes,NO getGroupCall, getGroupAncro-->
</div> <!-- End flex-container -->

<div class="flex-container">
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
		<label for="netkind">Select a default kind of nets, if its not listed<br>select "Name Your Own". </label>
		<select id="netkind" name="netkind" title="Select a Net Type">    
			<option value="0" >Select a Kind of Net</option>
			<option value="7">Name Your Own</option>
				<?php 
					foreach($db_found->query("
						SELECT id, kindofnet
						  FROM NetKind
						 WHERE freq NOT LIKE '%Test%'
						   AND freq NOT LIKE '%Eye%'
						   AND freq NOT LIKE '%KE0%'
						   AND kindofnet <> ''
						 ORDER BY id ")
							as $net) {
						echo ("<option value='$net[id]'> $net[kindofnet] </option> \n ");
			        }     
				?>
		</select>
			<br>
			<label for="netkindval" class="netkindval hidden">Your Named Kind of Net: </label>
			<input  id="netkindval" class="netkindval hidden" type="text" name="netkindval" />
	</div> <!-- End flex-container -->
</div>


	
</div> <!-- End newGroupBuild -->

<div>
	<h2 style='color:red;'>Any changes here will be reflected for the:<br><?php echo "$call $activity" ?></h2>
	<div id="disclaimer"></div>
	<label for="rightCorner">Upper right corner consists of up to 4 columns across and 6 rows.<br>Use of this matirx is optional and customizable for your Group.<br>The information below is your current display, change or blank out as needed.</label>
</div>

<div id="rightCorner">
<div id="upperRightCorner" > 
	
   <table id="ourfreqs" style="margin-bottom:30px;">
	   <tbody>
	   <tr> <th class="r1c1 nobg"><input type="text" name="r1c1" size="10" value="<?php echo "$r1c1"; ?>" /></th> 
			<th class="r1c2 nobg"><input type="text" name="r1c2" size="10" value="<?php echo "$r1c2"; ?>" /></th>
	   		<th class="r1c3 nobg"><input type="text" name="r1c3" size="10" value="<?php echo "$r1c3"; ?>" /></th> 
	   		<th class="r1c4 nobg"><input type="text" name="r1c4" size="10" value="<?php echo "$r1c4"; ?>" /></th> 
	   </tr>
	   <tr> <td class="r2c1 nobg1"><input type="text" name="r2c1" size="10" value="<?php echo "$r2c1"; ?>" /></td> 
			<td class="r2c2 nobg2"><input type="text" name="r2c2" size="10" value="<?php echo "$r2c2"; ?>" /></td>
	   		<td class="r2c3 nobg2"><input type="text" name="r2c3" size="10" value="<?php echo "$r2c3"; ?>" /></td> 
	   		<td class="r2c4 nobg2"><input type="text" name="r2c4" size="10" value="<?php echo "$r2c4"; ?>" /></td> 
	   </tr>
	   <tr> <td class="r3c1 nobg1"><input type="text" name="r3c1" size="10" value="<?php echo "$r3c1"; ?>" /></td> 
			<td class="r3c2 nobg2"><input type="text" name="r3c2" size="10" value="<?php echo "$r3c2"; ?>" /></td>
	   		<td class="r3c3 nobg2"><input type="text" name="r3c3" size="10" value="<?php echo "$r3c3"; ?>" /></td> 
	   		<td class="r3c4 nobg2"><input type="text" name="r3c4" size="10" value="<?php echo "$r3c4"; ?>" /></td> 
	   </tr>
	   <tr> <td class="r4c1 nobg1"><input type="text" name="r4c1" size="10" value="<?php echo "$r4c1"; ?>" /></td> 
			<td class="r4c2 nobg"><input type="text"  name="r4c2" size="10" value="<?php echo "$r4c2"; ?>" /></td>
	   		<td class="r4c3 nobg"><input type="text"  name="r4c3" size="10" value="<?php echo "$r4c3"; ?>" /></td>  
	   		<td class="r4c4 nobg"><input type="text"  name="r4c4" size="10" value="<?php echo "$r4c4"; ?>" /></td> 
	   </tr>
	   <tr> <td class="r5c1 nobg1"><input type="text" name="r5c1" size="10" value="<?php echo "$r5c1"; ?>" /></td> 
			<td class="r5c2 nobg2"><input type="text" name="r5c2" size="10" value="<?php echo "$r5c2"; ?>" /> </td>
	   		<td class="r5c3 nobg2"><input type="text" name="r5c3" size="10" value="<?php echo "$r5c3"; ?>" /> </td> 
	   		<td class="r5c4 nobg2"><input type="text" name="r5c4" size="10" value="<?php echo "$r5c4"; ?>" /> </td> 
	   </tr>
	   <tr> <td class="r6c1 nobg1"><input type="text" name="r6c1" size="10" value="<?php echo "$r6c1"; ?>" /> </td> 
			<td class="r6c2 nobg2" colspan="3"> <input class="url" type="text" name="r6c2" size="100" 
				value="<?php echo "$r6c2"; ?>" /></td> </tr> 
	   </tbody>
   </table>
   
</div> <!-- End upperRightCorner -->
</div> <!-- End div-rightCorner -->
	
<div>
	<label for="submitform">After you submit this form you will be redirected back to the start page.<br>Cancel will take you back to the Net Control page.</label>
	<input id='submitform'  type="submit" name="submit" value="Submit" onclick = "collectNew();">
	<input class="" type="button" value="Cancel" title="Cancel" onClick="window.open('https://net-control.us');">
</div>
	
</form>
	
</body>
</html>
