<!doctype html>
<!-- This is the editor for preambles, closings, events, etc -->
<!-- New version: 2022-01-20 fixes display during editing of existing p, c, or e -->

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $id = $_GET["id"];
    //$id = 465; //465;
    
    //echo "$id";
    
	if($id) {           
    	$sql = "SELECT id, title, domain, docType, netkind, description
    	          FROM events 
    	         WHERE id = $id 
    	         LIMIT 1";
    
    	$stmt= $db_found->prepare($sql);
    	$stmt->execute();
    	    $result = $stmt->fetch();
    	        $id          = $result[id];
    	        $title       = $result[title];
    	        $domain      = $result[domain];
    	        $docType     = $result[docType];
    	            // agenda help Preamble Closing and All Groups
    	        $netkind     = $result[netkind];
    	        $description = $result[description];
    	            

	} else {$id = "";}
	
	//echo "<br>$id<br>$title<br> $domain<br> $docType<br> $netkind<br>$description<br>";

?>

<html lang="en">
<head>
    <title>NCM Preambles, Closings &amp; Agenda Items</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" />   
    <link rel="stylesheet" type="text/css" href="css/eventsBuild.css" /> 

	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" />
	
<!--	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script> 
	

	<script   src="js/jquery.table2excel.js"></script>
	<script   src="js/jquery.freezeheader.js"></script>
<!--<script   src="http://www.csvscript.com/dev/html5csv.js"></script> -->
	<script   src="js/jQuery.fn.table2CSV.js"></script>
	<script   src="js/jquery.simpleTab.min.js"></script>
	<script   src="js/jquery.modal.min.js" charset="utf-8"></script>
	

    <script   src="js/jquery.base64.js"></script>
    <script   src="js/jspdf/libs/sprintf.js"></script>
	<script   src="js/jspdf/jspdf.js"></script>
	<script   src="js/jspdf/libs/base64.js"></script>

 
	<!-- Include the plugin's CSS and JS: -->


	<!--<link rel="stylesheet" href="css/timepicker.css" type="text/css"/> -->

    <!-- http://www.appelsiini.net/projects/jeditable -->
	<script   src="js/jeditable.js" charset="utf-8"></script>
	<script   src="js/sortTable.js"></script>
	
	<script   src="js/NetManager.js"></script>
	<!--
	<script src="js/NetManager-p2.js"></script>
	-->
	<script   src="js/hamgridsquare.js"></script>


        
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--  <script src="js/timepicker.js"></script>  -->
  <script src="js/datetimepicker_css.js"></script>


<script>
	
// This function finds the id of the record to delete, asks for the callsign of the person deleteing it
// Then deletes the id (event or agenda or cancel note) from the events table
function deleteEvent() {
	var opensign = prompt("Enter your call sign to close(delete) this event.");
	var str2 = opensign.toUpperCase();
	
	var str1 = "<?php echo $id  ?>" ; //alert(str);
	//var x = "<?php echo $phpvar?>"; 
	//var str2 = "";
	
	var str = str1+";"+str2;
	
	//alert(str);
	
	//return;
		var r = confirm("Delete "+str+" for sure?"); 
			if (r == true) {;
				$.ajax({
				   type: "POST",
				   url: "deleteEvent.php",
				   data: {str : str},
				   cache: false,
				   success: function()
				   {
						alert("The Event or agenda #"+str+", has been closed!");
				   }
				}); 
			} else {
				var txt = "You chose not to close this Event or agenda #"+str+"!";
					alert(txt);
			}
}
	
function makeEvent() {
//	var oldID = 		<?php echo $id; ?>; 
	var eventDisc = 	$("#eventDisc").val();
	var callsign = 		$("#callsign").val();
	var contact = 		$("#contact").val();
	//var domain =		$("#domain").html(); alert(domain);
	var domain = 		$('#netDomain').find(":selected").val();
	//alert ('1 domain= '+domain);
		if (domain == 'W0KCN') {var domain = 'KCNARES';};
		if (domain == 'NR0AD') {var domain = 'PCARG';};
	//alert ('2 domain= '+domain);
	//return;
	var netkind =		$("#netkind").val();  
	var docType =		$("#docType").val();
	
	var email = 		$("#email").val();
	var eventTitle = 	$("#eventTitle").val();
	var eventURL = 		$("#eventURL").val();
	var eventLocation = $("#eventLocation").val();

	var startDate = $("#startDate").val();
	var endDate   = $("#endDate").val();
	var eventDate = $("#eventDate").val();
		//alert(endDate);
		
	var str = eventDisc + "|" + callsign +  "|" + contact + "|" + email +  "|" + eventTitle + "|" + eventURL + "|" + eventLocation + "|" + startDate + "|" + endDate + "|" + domain + "|" + docType + "|" + netkind + "|" + eventDate;
	
	//alert(str);
	// This is a test preamble for the TechGuys.|wa0tjt|Keith Kaiser|wa0tjt@gmail.com|Preamble|||Jul-18-2018 09:25AM|Jul-19-2018 09:25PM|TechGuys|Preamble|2 Meter Digital
	//alert("eventDisc = "+eventDisc+" domain = "+domain+" netkind= "+netkind);
	
	// Dates must look like this 2016-10-15 09:00:00
	
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("eventList").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("POST","buildEventDB.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("q="+str);
  
  	alert("Created!   Scroll down to see your new document");
}


function fillTitle(val) {
	$("#eventURL").addClass("hidden");
	$("#eventURLLabel").addClass("hidden");
	
	$("#eventLocation").addClass("hidden");
	$("#eventLocationLabel").addClass("hidden");
	
	if (val == 'Preamble') {
		$("#eventTitle").val(val);
	} else if (val == 'Closing') {
		$("#eventTitle").val(val);
	} else if (val == 'agenda') {
		$("#eventURL").removeClass("hidden");
		$("#eventURLLabel").removeClass("hidden");
		
		$("#endDate").removeClass("hidden");
		$("#endDateLabel").removeClass("hidden");
		
		$("#eventLocation").removeClass("hidden");
		$("#eventLocationLabel").removeClass("hidden");
	}
	
} // End fillTitle() 

$( function() {
    $( "#startDate" ).datepicker();
    $( "#endDate" ).datepicker();
    
    // The below jQuery puts the current values into the dropdowns 2022-01-20
    $("#docType").val('<?php echo $docType ?>').attr("selected", true);
    $("#netDomain").val('<?php echo $domain ?>').attr("selected", true);
    $("#netkind").val('<?php echo $netkind ?>').attr("selected", true);
  } );
  
</script>

<style>
	#submit {
		color: Green;
	}
	#deletebutton {
		float: right;
		color: red;
	}
	#eventDate{
		width: 100px;
	}
	#startDate{
		width: 100px;
	}
	#endDate{
		width: 100px;
	}
</style>

</head>
<body>
	
<div id="banner"><h2>Editor for:<br> Events, Announcements, Agenda items,<br> Preambles &amp; Closings</h2></div>
<b>*</b> Required  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div id="theEvent">

	<b>*</b>
	<label for="docType">Create a: (Select one from the dropdown list)</label>
	<select id="docType" name="docType" onchange="fillTitle(this.value);">
	  <option value="agenda">Announcement or Agenda item</option>
	  <option value="Preamble" onselect="fillTitle(this.value)">Preamble</option>
	  <option value="Closing">Closing</option>
	</select>
	<br><br>
	
	<b>*</b>
	<label for="netcall">Domain (who is this for, Select from the dropdown list)</label>
	
	<!-- this.value is the number of the org in the NetKind table -->
	<select id="netDomain" class="" name="netDomain">
		<option value="All Groups" selected>All Groups</option>
			<?php  
    		/*	if ( $result[domain] <> '' ) { 
        			//$addAND = "AND `call` = '$result[domain]';" 
        			$addAND = 'selected';
    			} else { $addAND = ''; } */
            	foreach($db_found->query("SELECT `call`, org
											  FROM NetKind
											 WHERE `call` <> 'OTHER'
											   AND `call` <> ''
											   
											 ORDER BY `call`")
										as $net) {
					echo ("<option value='$net[call]' >$net[call] </option>");
            	}    
			?>
					
	</select>
	
	<label for="netkind">What kind of net is this for</label>
	<select id="netkind" class="" name="netkind">
		<option value="All Groups" selected>All Kinds</option>
			<?php  
            	foreach($db_found->query("SELECT kindofnet
											  FROM NetKind
											  
											 ORDER BY kindofnet")
										as $net) {
                    if ($net[kindofnet] <> '' ) {
					echo ("<option value='$net[kindofnet]'>$net[kindofnet] </option>");
					}
            	}    
			?>
					
	</select>
	<!-- This div is hidden because its value comes from the above select by way of the selectDomain function -->
	<div id='domain' class='hidden'><?php echo $net[name]?></div> 
	<br><br>

	<label for="eventTitle">Title</label>
	<input type="text" id="eventTitle" 	  class="editEventTitle"     name="eventTitle"	  autofocus   		placeholder="Title"
	value="<?php echo $result[title]?>"/><br>
	
	<label for="eventLocation" id="eventLocationLabel">Location</label>
	<input type="text" id="eventLocation" class="editEventLocation"  name="eventLocation"  		placeholder="Location" value="<?php echo $result[location]?>"/>
	<br><br>
	
	<label for="eventDate" id="eventDateLabel"><b>*</b> Date of Event</label>
		&nbsp;&nbsp;&nbsp;
	<img src="images2/cal.gif" onclick="javascript:NewCssCal ('eventDate','MMMddyyyy','dropdown',true,'12',false,'future')"/>
	
	<input type="text" id="eventDate" maxlength="25" size="25" value="<?php echo $result[eventDate]?>"/>
	
	
	
	<br><br>
	<b>*</b>
	<label for="eventDisc">Description </label>
	<textarea id="eventDisc" 		  	  class="editEventDisc" 	 name="eventDisc"			rows="10" cols="100" placeholder="Describe the item." ><?php echo trim( $result[description] )?></textarea>
	</textarea>
	
	<br><br>
	
	<b>*</b>
	<label for="contact">Your full name</label>
	<input type="text" id="contact"    	  class="editContact" 	  	 name="contact" 	  maxlength="60"	placeholder="First and Last Name" value="<?php echo $result[contact]?>"/>
	
	<label for="callsign">Your callsign</label>
	<input type="text" id="callsign"   	  class="editCallsign"       name="callsign"	  maxlength="7" 	      placeholder="Callsign"    		  minlength="3" value="
	<?php echo $result[callsign]?>"/>
	
	<label for="email">Your email</label>
	<input type="text" id="email"      	  class="editEmail" 		 name="email" 		  maxlength="255"		           placeholder="eMail Address" value="<?php echo $result[email]?>"/>
	
	<label for="eventURL" id="eventURLLabel">URL of event</label>
	<input type="text" id="eventURL"   	  class="editEventURL"   	 name="eventURL"	  maxlength="255"   		placeholder="URL" value="<?php echo $result[url]?>"/>
	
	<b>*</b>
	<!-- These date picers are from:  http://www.rainforestnet.com/index.htm -->
	<label for="startDate" id="startDateLabelx">Show This Event Starting: (Click to Select a date &amp; time)</label>
	&nbsp;&nbsp;&nbsp;
	<!--
	<img src="images2/cal.gif" onclick="javascript:NewCssCal ('startDate','MMMddyyyy','dropdown',true,'12',false,'future')"/>
	-->
	<input type="text" id="startDate">
	
	<!--
	<input type="Text" id="startDate" maxlength="25" size="25" value="<?php echo $result[start]?>" onclick="javascript:NewCssCal ('startDate','MMMddyyyy','dropdown',true,'12',false,'future')"/>
     -->   
<!--	<input type="text" id="startDate" placeholder="Start or only date, time not required" value="<?php echo $result[start]?>"/> -->

	<br><br>
	<label for="endDate" id="endDateLabelx">Stop Showing Event: (Click to Select a date &amp; time)</label>
	&nbsp;&nbsp;&nbsp;
	<!--
	<img src="images2/cal.gif" onclick="javascript:NewCssCal ('endDate','MMMddyyyy','dropdown',true,'12',false,'future')"/>
	-->
	<input type="text" id="endDate">
	
	<!--

	<input type="Text" id="endDate" maxlength="25" size="25" value="<?php echo $result[end]?>" onclick="javascript:NewCssCal ('endDate','MMMddyyyy','dropdown',true,'12',false,'future')"/>
    -->
<!--	<input type="text" id="endDate" placeholder="End date if needed" value="<?php echo $result[end]?>"/> -->
	<br><br>
	<button id="cancelbutton" onclick="location.href = 'http://net-control.us';" >Cancel</button>
	<button type="submit" id="submit" onclick= "makeEvent();" >Submit</button>
	<button id="deletebutton" onclick="deleteEvent();">Delete This Event</button>
	<!-- The deletebutton actually sets a delete date in the evens table which closes the item not deletes it. -->
</div>

<div id="eventList"></div>
<p>buildEvents.php</p>

</body>
</html>