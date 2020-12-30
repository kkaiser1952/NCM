<!doctype html>

<?php
/*****************************************************************************************************************
 Net Control Manager is a Create, Read, Update, Delete (CRUD) application used by Amateur Radio operators to 
 document various net operations such as weather emergencies, club meetings, bike ride support and any other 
 logging and/or reporting intensive communications support and management needs. 
 A variety of reports can be created including mapping stations locations and other DHS/FEMA needs. Including
 the ICS-214 and ICS-309 reports and access to many others.
 
 No Guarantees or Warranties. EXCEPT AS EXPRESSLY PROVIDED IN THIS AGREEMENT, NO PARTY MAKES ANY GUARANTEES OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WHETHER ARISING BY OPERATION OF LAW OR OTHERWISE. PROVIDER SPECIFICALLY DISCLAIMS ANY IMPLIED WARRANTY OF MERCHANTABILITY AND/OR ANY IMPLIED WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE. 
 
 Extensive help is available by clicking Help in the upper right corner of the primary page.

 First written some time in 2015 and in continous enhancment and upgrade since.
 copyright 2015-2021 by: Keith Kaiser, WA0TJT 
 Written by: Keith Kaiser, WA0TJT, with the help of many others.
 I can be reached at wa0tjt at gmail.com
 
 Revised: The version number. v3.2.13 for example means year 3 of use (2018), 2 means the month, 13 the day.
 
 How this works (for the most part, sorta, kinda):
 If a net is selected from the dropdown
 1) The list of nets is selected from #select1
 2) The selected net information is passed to the showActivities() function in NetManager.js
 3) If this net is for logging custom contacts, the code is in NetManager.js @ showActivities()
 3a) This extra code change the Name field to a custom field for logging purposes
 4) It runs buildUpperRightCorner.php and getactivities.php to build the page
 4a) buildUpperRightCorner.php is used to retrieve data and populate #ourfreqs in #rightCorner
 4b) getactivities.php is used to retrieve the data of the selcted net and populate #actLog
 
 If a new net is created
 1) Each of the dropdowns supplies part of the information needed to start the new net
 2) The callsign of the person starting the net is also ented into the new net
 3) When that data is complete it is passed to the newNet() function in NetManager-p2.js 
 4) NetManager-p2.js runs newNet.php to create, and populate NetLog and TimeLog appropriatly
****************************************************************************************************************/
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "wx.php";			   // Makes the weather information available
    
?>

<html lang="en" >
<head>
    <meta charset = "UTF-8" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167869985-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167869985-1');
</script>

    
    <title>Amateur Radio Net Control Manager</title>
    <!-- Below is all about favicon images https://www.favicon-generator.org -->
    <link rel="apple-touch-icon" sizes="57x57" href="favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="manifest" href="favicons/manifest.json">
  
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- End all about favicon images -->
    
    <!-- The meta tag below sends the user to the help file after 90+ minutes of inactivity. -->
    <meta http-equiv="refresh" content="9200; URL=https://net-control.us/help.php" >
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" > 

    <meta name="description" content="Amateur Radio Net Control Manager" >
    <meta name="author" content="Keith Kaiser, WA0TJT" >
    
    <meta name="Rating" content="General" >
    <meta name="Revisit" content="1 month" >
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager, Net Control Manager, Amateur Radio Net Control, Ham Radio Net Control" >
    
    <!-- https://fonts.google.com -->
    <!--
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Allerta&display=swap" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Stoke&display=swap" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cantora+One&display=swap" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Risque&display=swap" >
    -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
    <!-- =============== All above this should not be editied ====================== -->
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 -->
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

     <!-- ======== My style sheets ======== -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >   <!-- Primary style sheet for NCM  -->
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >				<!-- 2018-1-17 -->
    
    <!-- All the @media stuff -->
    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css">	
	 
<style>
	/* Use this space for experimental CSS */   

/* The left and right here are the final position of the NCM and Net Control Manager titles */
/* These future features work with the very last javascript at the bottom of this page. */
@keyframes pageOpening {
  /*    from {left:50%; top:50%;  transform:rotate(0deg);}  
        to {left:10px; top:5px; transform:rotate(360deg);} */
        from {left:100%; top:5px; }
        to {left:20px; top:5px;}
}
@keyframes moveRightCorner {
        from {left:20px; top:5px; }
        to {right:5px; top:5px;}
}
.openingImages {
    /*
    position: relative;
    animation: pageOpening 1.0s ;  */
}
#ourfreqs {
  /*  position: relative; 
    animation: moveRightCorner 1.0s ; */
}

.parent {
  display: flex;
  align-items: center;
  justify-content: center; 
  position: absolute;
  left: 50%;
  top: 65%;
  transform: translate(-50%, -50%);
/*  border: 5px solid #FFFF00; */
  padding: 10px;
}

.centernote {
/*  background-color: #FFFF00; */
  width: 100%;
  height: 200px; 
  font-size: 14pt;
}

</style>

</head>
<body>
    
<div class="parent">
 <div class="centernote">
<p>
      Net Control Manager is a Create, Read, Update, Delete (CRUD) application used by Amateur Radio operators to 
 document various net operations such as weather emergencies, club meetings, bike ride support and any other 
 logging and/or reporting intensive communications support and management needs. 
 </p><p>
 A variety of reports can be created including mapping stations locations and other DHS/FEMA/club needs. Including
 the ICS-214 and ICS-309 reports and access to many others.
 </p>
 </div>
</div> <!-- End funBox -->


<div class="openingImages">
<!-- NCM and Net Control Manager images at top of page -->
<img id="smtitle" src="images/NCM.png" alt="NCM" >
<img id="pgtitle2" src="images/NCM3.png" alt="NCM2" >

<span id="version">
	<a href="#cc" rel="modal:open" id="version2">5.12.15</a> <!-- Years in service . Month . day  of last update -->
</span> <!-- End of id version -->
</div>

	<!-- From showDTTM() in NetManager-p2.js -->
    <div id="dttm"> <!-- flex container -->
        <div id="dttm1">
            <input type="radio" name="tz" id="theLocal" value="theLocal" onclick="goLocal()">
            <br>
            <input type="radio" name="tz" id="theUTC" value="theUTC" onclick="goUTC()" >
        </div>
    
        <!-- To comment this function: comment setInterval('showDTTM()', 1000); in netManager-p2.js -->
    	<div id="dttm2">
    	</div>  <!-- Friday, August 24, 2018 1:55:13 PM  -->
    </div> <!-- end flex container -->
		 
	<div class = "weather-place">
		<img src="images/US-NWS-Logo.png" alt="US-NWS-Logo" width="50" height="50" >
		<a href="https://www.weather.gov" target="_blank" rel="noopener">
    		<!-- CurrentWX() was developed by Jeremy Geeo, KD0EAV Found it wx.php -->
			<?php echo currentWX(); ?>   <!-- wx.php -->
		</a>  
	</div> <!-- End of class: weather-place -->
		
    <br>
       <!-- The div below builds the Preamble, Agenda... menu --> 
       <!-- The upperrightcorner.php code was changed 2018-07-10 to point to NetKind instead of meta -->
       <!-- Be sure to look at the NetManager.js and ...-p2.js for upperrightcorner and edit as needed -->
       <!-- The three divs work to allow its position in the upper right corner and proper position of -->
       <!-- each of the other divs within rightCorner -->
       <!-- The upper right corner information can now be edited using buildRightCorner.php -->
    <div id="rightCorner">    
    <div id="upperRightCorner" class="upperRightCorner"> </div> <!-- Filled by buildUpperRightCorner.php -->
       <div id="theMenu" class="theMenu">
	       <table id="ourfreqs"> <!-- This is a bad name for this id, fix it someday -->
	       <tbody>
		     <tr class="trFREQS">
		       <td class="nobg2" > <!-- The CSS: .nobg2 makes it 4 columns -->

                   <!-- Selections available below the table -->
                   <!-- Open the preamble for the current net -->
			       <a id="preambledev" onclick="openPreamblePopup();" title="Click for the preamble">Preamble &nbsp;||&nbsp;</a>
			       					   
			       <!-- Open the agenda and announcements for the current net -->
				   <a id="agendadiv" onclick="openEventPopup()" title="Click for the agenda">Agenda &nbsp;||&nbsp;</a>
				   
				   <!-- Build a new preamble/closing or agenda items for the current net -->
			       <a href="buildEvents.php" target="_blank" rel="noopener" title="Click to create a new preamble, agenda or announcment" class="colorRed" >New </a>&nbsp;||&nbsp;
			  
                   <!-- Open the closing for the current net -->
			  	   <a id="closingdev" onclick="openClosingPopup()"  title="Click for the closing script">Closing &nbsp;||&nbsp;</a>
				       
   <!-- Dropdown of the available reports -->
	   <span class="dropdown"> <!-- reports list dropdown -->
   		<span class="dropbtn">Reports &nbsp;||&nbsp;</span>
		  <span class="dropdown-content"> <!-- changed to span from div on 2017-12-23 -->
		  
		    <a href="buildGroupList.php" target="_blank" rel="noopener" title="Group List">Groups Information</a>
		    
		    <a href="groupScoreCard.php" target="_blank" rel="noopener" title="Group Scores">Group Score Card</a>
		    <a href="listNets.php" target="_blank" rel="noopener" title="All the nets">List/Find ALL nets</a>
	<!--	    <a href="javascript:net_by_number();">Browse a Net by Number</a>  -->
		    <a href="#" onclick="net_by_number();" title="Net by the Number">Browse a Net by Number</a>
			<a href="NCMreports.php" target="_blank" rel="noopener" title="Stats about NCM">Statistics</a>
		    
		    <a href="http://www.arrl.org/ares-el" target="_blank" rel="noopener" title="ARES E-Letter">
		    ARRL ARES E-Letter</a>
		    <a href="#" onclick="AprsFiMap(); return false;" title="APRS FI Map of stations logged into the active net">Show APRS.fi presence</a>
		    <a href="listAllPOIs.php" target="_blank" rel="noopener" id="PoiList" title="List all Pois">List all POIs</a>
		<!--    <a href="#" id="mapIDs" onclick="map1()" title="Map This Net">Map This Net</a> -->
		    <a href="#" id="mapIDs" onclick="map2()" title="Map This Net">Map This Net</a>
        <!--
		    <a href="#" id="printByNetID" onclick="printByNetID()" title="Print Report of the active net">Print</a>
		--> 
			<a href="#" id="ics205Abutton" onclick="ics205Abutton()" title="ICS-205A Report of the active net">ICS-205A</a>
			<a href="#" id="ics214button" onclick="ics214button()" title="ICS-214 Report of the active net">ICS-214</a>
			<a href="#" id="ics309button" onclick="ics309button()" title="ICS-309 Report of the active net">ICS-309</a>
			<a href="http://www.stlares.org/Forms/STL-ARES-radiogram.pdf" id="radiogram" target="_blank"> ARRL Fill &amp; Sign RadioGram </a>
			<a href="https://training.fema.gov/icsresource/icsforms.aspx" id="icsforms" target="_blank" rel="noopener">Addional ICS Forms</a>
            <a href="https://docs.google.com/spreadsheets/d/1eFUfVLfHp8uo58ryFwxncbONJ9TZ1DKGLX8MZJIRZmM/edit#gid=0" target="_blank" rel="noopener" title="The MECC Communications Plan">MECC Comm Plan</a>
			<a href="https://upload.wikimedia.org/wikipedia/commons/e/e7/Timezones2008.png" target="_blank" rel="noopener" title="World Time Zone Map">World Time Zone Map</a>
		  </span> <!-- End of class dropdown-content -->
	   </span> <!-- End of class dropdown -->
		
                    <!-- Open the NCM help/instructions document -->
					<a id="helpdev" href="help.php" target="_blank" rel="noopener" title="Click for the extended help document">Help</a>&nbsp;||&nbsp;
					
					<!-- Alternate dropdown of the lesser needed reports -->
					<a href="#menu" id="bar-menu" class="gradient-menu"></a>
							  	   		
					<!-- This select only shown if the three bar (gradient-menu) is selected -->
					<!-- bardropdown is in NetManager-p2.js -->
			   		<select id="bardropdown" class="bardropdown hidden">
				   		<option value="SelectOne" selected="selected" disabled >Select One</option>
				   <!--	<option value="EditCorner" >Edit This Corner</option> -->
				   		<option value="CreateGroup">Create a Group Profile</option> 
				   <!--	<option value="SelectView" >Select Group Default Columns</option> -->
				   		<option value="HeardList">Create a Heard List</option>
				   <!--	<option value="APRStt">Direwolf APRStt Config List</option> -->
				   		<option value="findCall">Report by Call Sign</option>
				   		<option value="allCalls">List all User Call Signs</option>
				   		<option value="DisplayHelp">NCM Documentation</option>
				   		<option value="DisplayKCARES">KCNARES Deployment Manual</option>
				   		<option value="" disabled >ARES Resources</option>
				   		<option value="ARESManual">Download the ARES Manual(PDF)</option>
				   		<option value="DisplayARES">Download ARES Field Resources Manual(PDF)</option>
				   		<option value="ARESTaskBook"> ARES Standardized Training Plan Task Book [Fillable PDF]</option>
				   		<option value="ARESPlan">ARES Plan</option>
				   		<option value="ARESGroup">ARES Group Registration</option>
				   		<option value="ARESEComm">Emergency Communications Training</option>
				   		
			   		</select>
				       
		       </td> <!-- End div-nobg2 -->
		     </tr> <!-- This closes the only row in the ID: ourfreqs table -->
	       </tbody>
	       </table> <!-- End table-ourfreqs -->
       </div> <!-- End id theMenu -->
    </div> <!-- End id rightCorner -->
	      
	<div id="org" class="hidden"></div> <!-- is this in use? -->
    <div id="netchoice">
	<div id="netdata">
		<!-- Use the span below to add a short message at the top of NCM. This span is hidden in NetManager.js , It's unhidden in the newnet() current in this file -->
	<!--	
		<span class="newstuff"> Effective 3/1/2020 all times will be in UTC, report issues to <a href="mailto:wa0tjt@gmail.com?subject=NCM">WA0TJT</a>
		<br><br>
		</span> 
	-->	
		<div class="theBox">
    		<!-- showit() in NetManager.js -->
			<button id="newbttn" class="newbttn left-cell" onclick="hideTheCenter(); showit();" title="Click to start a new net">Start a new net</button>	
			<button id="by_number" style="left:25px;" class="newbttn" onclick="hideTheCenter(); net_by_number();" title="Net by the Number">Browse a Net by Number</button>
			<br><br>	
		</div>
		
		<div id="makeNewNet" class="hidden" >	
			<div>Enter Your Call Sign:</div>   
				<input type="text" required id="callsign" maxlength="16" name="callsign" autocomplete="on" title="Enter Your Call Sign" >
				
			<!-- tn is found in NetManager-p2.js at the very bottom -->	
            <label class="buildtest" for="tn">Click to build a TE0ST net. &nbsp;&nbsp;&nbsp;
    			<input id="tn" type="checkbox" name="tn" class="tn" />
			</label>
					
            <?php  require_once "buildThreeDropdowns.php"; ?>
			
         
            <!-- ==== GROUP ======= -->
            <div>Select Group or Call:&nbsp;
                <!-- This is like an alert box but uses no javascript -->
                <a href="#GroupQ" class="Qbutton" tabindex="-1">?</a>
                <div class="NewLightbox" id="GroupQ">
                    <figure>
                        <a href="#" class="Qclose"></a>
                        <figcaption>Filter the available group calls by typing the name. <br> For example: <b>MESN</b> <br><br> To create your own net simply type a name. <br> For example: <b>My Birthday</b> <br><br> Then in the Kind of Net selection below <br> consider choosing: <b>Event</b> or <b>Test</b>

                        </figcaption>
                    </figure>
                </div> <!-- End of class: NewLightbox -->
            </div> 
            <div id="GroupDropdown" >
                <!-- showGroupCoices() & filterFunctions() at the bottom of index.php -->
                <input type="text" onfocus="showGroupChoices()" placeholder="Type to filter list.." id="GroupInput" 
                       class="netGroup"  onkeyup="filterFunction(0);"/>
                <div class='GroupDropdown-content hidden'>
                    
                    <?php echo $groupList;?>
                    
                </div> <!-- End GroupDropdown -->
            </div> <!-- End GroupDropdown-content -->
            
             <!-- ==== KIND ======= -->
             <div>Select Kind of Net:&nbsp;&nbsp;&nbsp;
                <!-- This is like an alert box but uses no javascript -->
                <a href="#KindQ" class="Qbutton" tabindex="-1">?</a>
                <div class="NewLightbox" id="KindQ">
                    <figure>
                        <a href="#" class="Qclose"></a>
                        <figcaption>If you typed in your own name in the Group slection above <br> then consider choosing <b>Event</b> or <b>Test</b> here.
                        </figcaption>
                    </figure>
                </div> <!-- End of class: NewLightbox -->
            </div>
            <div id="KindDropdown" >
                <!-- showKindChoices() & filterFunctions() at the bottom of index.php -->
                <input type="text" onfocus="showKindChoices(); blurGroupChoices();" placeholder="Type to filter list.." id="KindInput" 
                       class="netGroup" onkeyup="filterFunction(1)"/>
                <div class='KindDropdown-content hidden'>
                    
                   <?php echo $kindList;?>
                   
                </div> <!-- End KindDropdown -->
            </div> <!-- End KindDropdown-content -->
            
            <!-- ==== FREQ ======= -->  
            <div>Select the Frequency:</div>
            <div id="FreqDropdown" >
                <!-- showFreqChoices() & filterFunctions() at the bottom of index.php -->
                <input type="text" onfocus="showFreqChoices(); blurKindChoices(); " placeholder="Type to filter list.." id="FreqInput" 
                       class="netGroup" onkeyup="filterFunction(2)"/>
                <div class='FreqDropdown-content hidden'>
                    
                   <?php echo $freqList; ?> 
                   
                </div> <!-- End FreqDropdown -->
            </div> <!-- End FreqDropdown-content -->
            
            <div class="last3qs">If this is a Sub Net select the<br>open primary net:</div>

			<!-- If any option is selected make the cb1 span (show linked nets) button appear using function showLinkedButton() -->
			 <select class="last3qs" id="satNet" title="Sub Net Selections" onfocus="blurFreqChoices(); ">
				<option value="0" selected>None</option>
	              <?php
    	              // Limit the nets returned to be within the last 3 days
					foreach($db_found->query("SELECT netID, activity, netcall
											     FROM NetLog 
											     WHERE (dttm    >= NOW() - INTERVAL 3 DAY AND pb = 1)
                                                    OR (logdate >= NOW() - INTERVAL 3 DAY AND pb = 0)
												 GROUP BY netID 
												 ORDER BY netID DESC
											  ") as $act){
						echo ("<option title='$act[netID]' value='$act[netID]'>Net #: $act[netID] --> $act[activity]</option>\n");
                    }
				  ?>    
			 </select>
				
				<label class="radio-inline last3qs" for="pb">Click to create a Pre-Build Event &nbsp;&nbsp;&nbsp;
				    <!-- doalert() & seecopyPB() in NetManager-p2.js -->
					<input id="pb" type="checkbox" name="pb" class="pb last3qs" onchange="doalert(this); seecopyPB(); " />
				</label>
				
				<div class="last3qs">Complete New Net Creation:</div>
				
				<br>
				<!-- newNet() & hideit() in NetManager-p2.js -->
				<input id="submit" type="submit" value="Submit" onClick="hideTheCenter(); newNet();"  title="Submit The New Net">
				<input class="" type="button" value="Cancel" onclick="hideTheCenter(); hideit();" title="Cancel">
				   
	    </div>	    <!-- End of makeNewNet -->
	    
	    <div id="remarks" class="remarks hidden"></div>
    <!-- Building the upper right corner is triggered by: showActivities() in NetManager.js -->
	<div class="btn-toolbar" >
    	
		<div class="form-group" id="form-group-1" title="form-group" >
    		
    		<!-- switchClosed() in NetManager-p2.js -->
    		<!-- The tohide class is used by net_by_num() -->
    		<label for="select1">Or make a selection from this dropdown</label>
        	<select id="select1" data-width='auto' class="tohide form-control selectpicker selectdd" name="activities" 
	        onchange="showActivities(this.value, this.options[this.selectedIndex].innerHTML.trim()); switchClosed();  ">
	        	
	        <option class="tohide pbWhite firstValue" value="a" selected disabled >Or, Make a Selection From These Nets</option>
	        
	        <option class ="tohide opcolors" value="z" disabled>Open Nets are in green =================//================= Pre-built Nets are in blue</option>
 
            <option class="tohide newAfterHere" data-divider="true">&nbsp;</option>
            
        <?php  require_once "buildOptionsForSelect.php"; ?>
        	
        	</select>  	<!-- End of ID: select1 -->
		
		<div class="btn-group">
			<button id="refbutton" class="btn btn-info btn-small hidden" >Refresh</button>
		
		    <button id="refrate" class="btn btn-small btn-info dropdown-toggle hidden" 
		    		data-toggle="dropdown" type="button">
			    Timed
		    	<span class="caret"></span>
		    </button>
		    
		    <!-- Refresh timer selection -->
		    <ul id="refMenu" class="dropdown-menu">
		      <li><a href="#" data-sec="M" >Manual</a></li>
		      <li class="divider"></li>
		      <li><a href="#" data-sec="5" >5s</a></li>
		      <li><a href="#" data-sec="10">10s</a></li>
		      <li><a href="#" data-sec="30">30s</a></li>
		      <li><a href="#" data-sec="60">60s</a></li>
            </ul>
			    
		</div>  <!-- /btn-group -->
		</div> <!-- End div-form-group -->
	</div> <!-- End btn-toolbar -->
	</div>  <!-- End div-netdata -->
        
    <!-- Edited and saved to DB by CellEditFunctions.js and SaveGenComm.php -->
    <!-- A general pupose entry point for text, it's put into the time line table -->
    <!-- This is activated by a jquery on function in netManager.js at about line 391 -->
    
	<div id="forcb1" class="hidden">
		<div id="genComments" class=" editGComms"></div>
<!--		<div id="genComments" class="editGComms" onclick="empty('genComments'); "> </div> -->
	</div>   <!-- End ID: forcb1 -->
	  <!-- End of besticky -->
	
	<div id="admin" class=" admin">   
		<div id="csnm" class="hidden">

	    <div id="primeNav" class="flashit">  <!-- changed to Div from  <nav id=" on 2019-05-02 -->
	    <!-- The cs1 entry or call sign can take the form of a call sign or a name, either will cause -->
	    <!-- the system to filter existing entries on whats entered either fully or partially. -->
			<input id="cs1" type="text" placeholder="Call or First Name" maxlength="16" class="cs1" autofocus="autofocus" autocomplete="off" > <!-- Removed autocomplete="on" 2018-08-12 -->
			
			<!-- Below input is where the hints from cs1 and Fname go before being selected -->
			<input type="hidden" id="hints">
			
			<!-- Input first name add readonly to prevent editing -->
			<!-- autocomplet="on" removed from below on 2018-08-12 -->
			<input id="Fname" type="text" placeholder="Name" onblur="checkIn();" autocomplete="off">
			
			<!-- Some attributes of the below field are controled in NetManager.js -->
			<input id="custom" class="hidden brdrGreen" type="text" placeholder="" autocomplete="off" onblur="checkIn();" >
			
			<!-- DO NOT COMMENT THIS OUT, IT BREAKS THE DISPLAY -->
			<input id="section" class="hidden brdrGreen" type="text" placeholder="" onblur=" this.value=''" maxlength="4" size="4"> 
		
			<!-- Check In button -->
			<!-- checkIN() is in NetManager-p2.js -->

<!-- https://www.w3schools.com/css/css3_buttons.asp -->
<!-- The job of showing and hiding the time line is done in the TimeLine() in NetManager.js -->
		    <div class = "btn-group2">
    		    <button class="ckin1" onclick="checkIn()">Check In</button>
    		    <button class="dropbtn2" id="columnPicker">Show/Hide Columns</button>
    		 
    		    <button class="timelineBut" onClick="TimeLine(); location.href='#timeHead';" >Time Line</button>
    		    
    		    <button class="timelineBut timelineBut2" onclick="RefreshTimeLine(); location.href='#timeHead';">Update</button>
    		  
    		    <button class="copyPB hidden" id="copyPB">Copy a Pre-Built</button>
    		    <button class="closenet" id="closelog" oncontextmenu="rightclickundotimeout();return false;" >Close Net</button>
		    </div> <!-- End btn-group2 -->

			<!-- A normal left click and the log is closed, a right click resets the timeout to empty -->
			<!-- NetManager.js contains the code that tests to show or hide the close net button -->
			<!-- If a pre-built net is not yet open, at least one check-in, then don't show the button -->
			<!-- this should prevent accidental closing of a pre-built in progress of being built -->

	</div>	<!-- End ID: admin -->
		
			<div  id="txtHint"></div> <!-- populated by NetManager.js -->
			<div id="netIDs"></div>			
			<div id="actLog">net goes here</div> <!-- Home for the net table -->
			
			<br>
			<div class="hidden" id="subNets"></div> <!-- Home for the sub-nets -->
			<br>
					
	<!--	The 'Export CSV' button is written by the getactivities.php program --> 
			
			<!-- HideTimeLine() in NetManager.js -->
			<button class="timelineBut timelineBut2" onclick="RefreshTimeLine(); location.href='#timeHead';">Update</button>
			<input id="timelinehide" type="submit" value="Hide TimeLine" class="timelinehide" onClick="HideTimeLine();" />
			<div id="timeline" class="timeline"></div>		
			
		</div>   
	</div> <!-- end admin -->		

	    <div id="status"></div>
	    
	    <div id="modalList" class="hidden">Modal List goes here</div>
	</div> <!-- End id netchoice -->
	
	<div id="cc" style="display:none;">	
		<p>&copy; Copyright 2015-2021, by Keith D. Kaiser, WA0TJT <br> Last Update: <span id="lastup">2020-12-15</span></p>
		<p>Questions, problems, concerns? ....send them to: 
			<a href="mailto:wa0tjt@gmail.com?subject=NCM">Keith D. Kaiser</a><br>
			Or click <a href="help.php" target="_blank" rel="noopener">here for a detailed Help page. </a></p>
			
	    <p> In order to succeed, you must know what you are doing, like what you are doing, and believe in what you are doing. -- Will Rogers
		</p>
		<p><a href="#cc" rel="modal:close">Close</a></p>
	</div> <!-- End id cc -->
	
	<div id="lli" class="modal-dialog" style="display:none;"></div> <!-- End of id lli -->
	
	<div id="pbl" class=" modal hidden"></div> <!-- End of id ppl, Holds the list of pre-built nets created in PBList.php -->
	
	<div id="gcomm" class="gcomm hidden">gcomm</div>
	
	<div id="testEmail" class="testEmail hidden"></div>
	
	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
	
<!-- ************************  JAVASCRIPT LIBRARIES  ******************************************** -->	
	
    <!-- jquery updated from 3.4.1 to 3.5.1 on 2020-09-10 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="bootstrap/js/bootstrap.min.js"></script>		<!-- v3.3.2 --> 
 
	<script src="js/jquery.freezeheader.js"></script>				<!-- v1.0.7 -->
	<script src="js/jquery.simpleTab.min.js"></script>				<!-- v1.0.0 2018-1-18 -->
	
	<!-- jquery-modal updated from 0.9.1 to 0.9.2 on 2019-11-14 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script> 

	<script src="bootstrap/js/bootstrap-select.min.js"></script>				<!-- v1.12.4 2018-1-18 -->
	<script src="bootstrap/js/bootstrap-multiselect.js"></script>				<!-- 2.0 2018-1-18 -->

    <!-- http://www.appelsiini.net/projects/jeditable -->
    <script src="js/jquery.jeditable.js"></script>							<!-- 1.8.1 2018-04-05 -->

	<script src="js/sortTable.js"></script>										<!-- 2 2018-1-18 -->
	<script src="js/hamgridsquare.js"></script>									<!-- Paul Brewer KI6CQ 2014 -->
	<script src="js/jquery.countdownTimer.js"></script>							<!-- 1.0.8 2018-1-18 -->
	
	<script src="js/w3data.js"></script>										<!-- 1.31 2018-1-18 -->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	
<!-- My javascript -->	
	<script src="js/NetManager.js"></script> 	<!-- NCM Primary Javascrip 2018-1-18 -->
	<script src="js/NetManager-p2.js"></script>					<!-- Part 2 of NCM Primary Javascript 2018-1-18 -->
	
	<script src="js/CellEditFunction.js"></script>				<!-- Added 2018-02-12 -->
	
	<script src="js/grid.js"></script>
	<script src="js/gridtokoords.js"></script>
	<script src="js/cookieManagement.js"></script>
	
	
	
	<script>
    $( "#select1").on("click", function(){
        hideTheCenter();
    })
    	
    	
    function hideTheCenter() {
        $('.parent').addClass('hidden');
        $('.centernote').addClass('hidden');
    }
    </script>
	
    <script>
        /*
        $("#netBody").sortable({
        cursor: 'row-resize',
        placeholder: 'ui-state-highlight',
        opacity: '0.55',
        items: 'tbody tr'
        });
        */
/*
       // $("#rightCorner").addClass("hidden");
        $("#version").addClass("hidden");
        $("#dttm").addClass("hidden");
        $(".theBox").addClass("hidden");
        $(".btn-toolbar").addClass("hidden");
        $(".weather-place").addClass("hidden");

        
    setTimeout(function() {
        $("#smtitle").removeClass("hidden");
       // $("#rightCorner").removeClass("hidden");
        $("#version").removeClass("hidden");
        $("#dttm").removeClass("hidden");
        $(".theBox").removeClass("hidden");
        $(".btn-toolbar").removeClass("hidden");
        $(".weather-place").removeClass("hidden");
    }, 1000);
*/
</script>

</body>
</html>