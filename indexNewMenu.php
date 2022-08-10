<!doctype html>

<?php
/***********************************************************************************************************
 Net Control Manager is a Create, Read, Update, Delete (CRUD) application used by Amateur Radio operators to 
 document various net operations such as weather emergencies, club meetings, bike ride support and any other 
 logging and/or reporting intensive communications support and management needs. 
 A variety of reports can be created such as mapping stations locations and other DHS/FEMA needs. Including
 the ICS-214 and ICS-309 reports and access to many others.
 
 No Guarantees or Warranties. EXCEPT AS EXPRESSLY PROVIDED IN THIS AGREEMENT, NO PARTY MAKES ANY GUARANTEES OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WHETHER ARISING BY OPERATION OF LAW OR OTHERWISE. PROVIDER SPECIFICALLY DISCLAIMS ANY IMPLIED WARRANTY OF MERCHANTABILITY AND/OR ANY IMPLIED WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE. 
 
 Extensive help is available by clicking Help in the upper right corner of the opening page.

 First written some time in late 2015 and in continous enhancment and upgrade since.
 copyright 2015-2022 by: Keith Kaiser, WA0TJT 
 Written by: Keith Kaiser, WA0TJT, with the help of many others. See the help file for more details.
 I can be reached at wa0tjt at gmail.com
 
 The version number. v7.03.04 for example means year 7 of use (2022), 03 means the month (March), 04 the day date.
 
 How NCM works (for the most part, sorta, kinda):
 If a net is selected from the dropdown
 1) The list of nets is selected from #select1, the past 10 days only. Nets highlighted in green are open, blue are pre-built nets, no color are closed nets.
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
*********************************************************************************************************/
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "wx.php";			   // Makes the weather information available
                                       // Test version is wx2.php
    require_once "NCMStats.php";
?>

<html lang="en" >
<head>
    <meta charset = "UTF-8" />
    
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
    
    <!-- ===============                          ================================== -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
    <!-- =============== All above this should not be editied ====================== -->
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 -->
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.1/themes/smoothness/jquery-ui.css">

    <!-- ============== My style sheets ============================================= -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >   <!-- Primary style sheet for NCM  -->
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >				<!-- 2018-1-17 -->
    
    <!-- ============== All the @media stuff ======================================== -->
    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css">	
    <link rel="stylesheet" type="text/css" href="css/bubbles.css">
	 
<style>
    .ui-menu { width: 200px; }
    .ui-widget-header { padding: 0.2em; }
	/* Use this space for experimental CSS */   
	
	/* jQuery modal css */
	/*
	ui-widget-header,.ui-state-default, ui-button {
            background:#b9cd6d;
            border: 2px solid #b9cd6d;
            color: #03c31d;
            font-weight: bold;
         }
	*/
</style>

</head>

<body>

<!-- Upper left corner of opening page -->
<div class="openingImages">
    <!-- NCM and Net Control Manager images at top of page -->
    <img id="smtitle" src="images/NCM.png" alt="NCM" >
    <img id="pgtitle2" src="images/NCM3.png" alt="NCM2" >
    
    <span id="version">
        <!-- Years in service from 3/2015 . Month . day  of last update -->
    	<a href="#cc" rel="modal:open" id="version2">v7.04.25</a> 
    </span> <!-- End of id version -->
</div> 

<!-- From showDTTM() in NetManager-p2.js -->
<p class="tb1 TipBubbles initiallyHidden" style="width: 200px; margin-bottom: 40px;">
	<a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Choose Your Time Zone</a></p>
	
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
		 
<p class="tb1 TipBubbles initiallyHidden" style="left: 100px; width: 450px;  margin-bottom: 30px;">
    <a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Clickable Weather Report based on your IP Address</a></p>
<div class = "weather-place">
	<img src="images/US-NWS-Logo.png" alt="US-NWS-Logo" width="50" height="50" onclick="newWX()">

	<a href="https://www.weather.gov" target="_blank" rel="noopener">
		<!-- CurrentWX() was developed by Jeremy Geeo, KD0EAV Found it wx.php -->
<?php echo currentWX(); ?>   <!-- wx.php -->
	</a>  
</div> <!-- End of class: weather-place -->
<!-- End of upper-left-corner stuff -->
		
    <br>
    
       <!-- The div below builds the Preamble, Agenda... menu --> 
       <!-- The upperrightcorner.php code was changed 2018-07-10 to point to NetKind instead of meta -->
       <!-- Be sure to look at the NetManager.js and ...-p2.js for upperrightcorner and edit as needed -->
       <!-- The three divs work to allow its position in the upper right corner and proper position of -->
       <!-- each of the other divs within rightCorner -->
       <!-- The upper right corner information can NOT be edited  -->
       
<div id="rightCorner">    
<div id="upperRightCorner" class="upperRightCorner"> </div> <!-- Filled by buildUpperRightCorner.php -->
   <div id="theMenu" class="theMenu">
       <table id="ourfreqs"> <!-- This is a bad name for this id, fix it someday -->
       <tbody>
	     <tr class="trFREQS">
	       <td class="nobg2" > <!-- The CSS: .nobg2 makes it 4 columns -->

               <!-- Selections available below the table -->
               <!-- Open the preamble for the current net -->
               
               <!-- Open tip bubbles -->
               <button class="tbb" title="Tips Button">T</button> 
               
               <!-- Open the preamble for this net -->
		       <a id="preambledev" onclick="openPreamblePopup();" title="Click for the preamble">Preamble &nbsp;||&nbsp;</a>
		       					   
		       <!-- Open the agenda and announcements for the current net -->
			   <a id="agendadiv" onclick="openEventPopup()" title="Click for the agenda">Agenda &nbsp;||&nbsp;</a>
			   
			   <!-- Build a new preamble/closing or agenda items for the current net -->
		       <a href="buildEvents.php" target="_blank" rel="noopener" title="Click to create a new preamble, agenda or announcment" class="colorRed" >New </a>&nbsp;||&nbsp;
		  
               <!-- Open the closing for the current net -->
		  	   <a id="closingdev" onclick="openClosingPopup()"  title="Click for the closing script">Closing &nbsp;||&nbsp;</a>
			       
   <!-- Open reports Dropdown of the available reports -->
   <span class="dropdown"> <!-- reports list dropdown -->
		<span class="dropbtn">Reports &nbsp;||&nbsp;</span>
	  <span class="dropdown-content"> <!-- changed to span from div on 2017-12-23 -->
	  
	    <a href="#" id="buildCallHistoryByNetCall" onclick="buildCallHistoryByNetCall()" title="build a Call History By NetCall">The Usual Suspects</a>
	  
	    <a href="buildGroupList.php" target="_blank" rel="noopener" title="Group List">Groups Information</a>    
	    <a href="groupScoreCard.php" target="_blank" rel="noopener" title="Group Scores">Group Score Card</a>
	    <a href="listNets.php" target="_blank" rel="noopener" title="All the nets">List/Find ALL nets</a>

	    <a href="#" onclick="net_by_number();" title="Net by the Number">Browse a Net by Number</a>
		<a href="NCMreports.php" target="_blank" rel="noopener" title="Stats about NCM">Statistics</a>
	        
	<!--    <a href="#" onclick="AprsFiMap(); return false;" title="APRS FI Map of stations logged into the active net">Show APRS.fi presence</a> -->
	    <a href="listAllPOIs.php" target="_blank" rel="noopener" id="PoiList" title="List all Pois">List all POIs</a>

	    <a href="#" id="mapIDs" onclick="map2()" title="Map This Net">Map This Net</a>
 
	    <a href="#" id="graphtimeline" onclick="graphtimeline()" title="Graphic Time Line of the active net">Graphic Time Line</a>
		<a href="#" id="ics205Abutton" onclick="ics205Abutton()" title="ICS-205A Report of the active net">ICS-205A</a>
		<a href="#" id="ics214button" onclick="ics214button()" title="ICS-214 Report of the active net">ICS-214</a>
		<a href="#" id="ics309button" onclick="ics309button()" title="ICS-309 Report of the active net">ICS-309</a>
		<a rel="noopener" href="http://www.stlares.org/Forms/STL-ARES-radiogram.pdf" id="radiogram" target="_blank"> ARRL Fill &amp; Sign RadioGram </a>
		<a href="https://training.fema.gov/icsresource/icsforms.aspx" id="icsforms" target="_blank" rel="noopener">Addional ICS Forms</a>
        <a href="https://docs.google.com/spreadsheets/d/1eFUfVLfHp8uo58ryFwxncbONJ9TZ1DKGLX8MZJIRZmM/edit#gid=0" target="_blank" rel="noopener" title="The MECC Communications Plan">MECC Comm Plan</a>
		<a href="https://upload.wikimedia.org/wikipedia/commons/e/e7/Timezones2008.png" target="_blank" rel="noopener" title="World Time Zone Map">World Time Zone Map</a>
	  </span> <!-- End of class dropdown-content -->
   </span> <!-- End of class dropdown -->
	
		  	   <!-- Open the NCM help/instructions document -->
		  	   <a id="helpdev" href="help.php" target="_blank" rel="noopener" title="Click for the extended help document">Help</a>&nbsp;||&nbsp;
				
		  	   <!-- Alternate dropdown of the lesser needed reports -->
		  	   <a href="#menu" id="bar-menu" class="gradient-menu"></a>
						  	   		
		  	   <!-- This select only shown if the three bar (hamburger-menu) is selected -->
		  	   <!-- bardropdown is in NetManager-p2.js -->
		  	   <select id="bardropdown" class="bardropdown hidden">
			   		<option value="SelectOne" selected="selected" disabled >Select One</option>
                    <option value="convertToPB" >Convert to a Pre-Built (Roll Call) net.</option>
			   		<option value="CreateGroup">Create a Group Profile</option> 
			   
			   		<option value="HeardList">Create a Heard List</option>
                    <option value="FSQList">Create FSQ Macro List</option>
			   		<option value="findCall">Report by Call Sign</option>
			   		
			   		<option value="allCalls">List all User Call Signs</option>
			   		<option value="DisplayHelp">NCM Documentation</option>
			   		<option value="DisplayKCARES">KCNARES Deployment Manual</option>
			   		
			   		<option value="" disabled >ARES Resources</option>
			   		<option value="ARESELetter" >ARES E-Letter</option>
			   		
			   		<option value="ARESManual">Download the ARES Manual(PDF)</option>
			   		<option value="DisplayARES">Download ARES Field Resources Manual(PDF)</option>
			   		<option value="ARESTaskBook"> ARES Standardized Training Plan Task Book [Fillable PDF]</option>
			   		
			   		<option value="ARESPlan">ARES Plan</option>
			   		<option value="ARESGroup">ARES Group Registration</option>
			   		<option value="ARESEComm">Emergency Communications Training</option>		
		  	   </select>
		  	   
		  	   <ul id="menu">
  <li class="ui-widget-header"><div>Category 1</div></li>
  <li><div>Option 1</div></li>
  <li><div>Option 2</div></li>
  <li><div>Option 3</div></li>
  <li class="ui-widget-header"><div>Category 2</div></li>
  <li><div>Option 4</div></li>
  <li><div>Option 5</div></li>
  <li><div>Option 6</div></li>
</ul>
			       
	       </td> <!-- End div-nobg2 -->
	     </tr> <!-- This closes the only row in the ID: ourfreqs table -->
       </tbody>
       </table> <!-- End table-ourfreqs -->
   </div> <!-- End id theMenu -->
</div> <!-- End id rightCorner -->
	      
 	<div id="org" class="hidden"></div> <!-- Used by putInGroupInput() in NetManager-p2.js  -->
    <div id="netchoice">
	<div id="netdata">
    	
    <!-- Use the <p> below to add a short message at the top of NCM. This span is hidden in NetManager.js , It's unhidden in the newnet() current in this file -->
	
		<p style="margin-bottom:10px;">Please report any issues to wa0tjt@gmail.com Thank you.</p>
	
	    <p class="tb1 TipBubbles initiallyHidden" style="left: 100px; width: 450px;  margin-bottom: 50px;">
            <a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Click to start a new net or display an active or closed net.</a>
        </p> <!-- End TipBubbles -->
        
		<div class="theBox">
    		<!-- showit() in NetManager.js -->
			<button id="newbttn" class="newbttn left-cell tbb2" onclick="showit();" title="Click to start a new net">Start a new net</button>	
        
			<button id="by_number" style="left:25px;" class="newbttn" onclick="net_by_number();" title="Net by the Number">Browse a Net by Number</button>
			<br><br>	
		</div>
		
		<div id="makeNewNet" class="hidden" >	
            <label class="Testcontainer" for="testnet">Click if making a test net? &nbsp;&nbsp;&nbsp;
    		    <input id="testnet" type="checkbox" name="testnet" value="y" >
    		   
            </label>
            <br>
            
    <div>Enter Your Call Sign:</div>   
    	<input onblur="checkCall()" type="text" required id="callsign" maxlength="16" name="callsign" autocomplete="on" title="Enter Your Call Sign" >
					
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
            
<?php echo $groupList;?>    <!-- Created in buildThreeDropdowns.php -->
            
        </div> <!-- End GroupDropdown -->
    </div> <!-- End GroupDropdown-content -->
            
    <!-- ==== KIND ======= -->
    <div>Select Kind of Net:&nbsp;&nbsp;&nbsp;
        <!-- This is like an alert box but uses no javascript -->
        <a href="#KindQ" class="Qbutton" tabindex="-1">?</a>
        <div class="NewLightbox" id="KindQ">
            <figure>
                <a href="#" class="Qclose"></a>
                <figcaption>If you typed in your own name in the Group selction above <br> then consider choosing <b>Event</b> or <b>Test</b> here.
                </figcaption>
            </figure>
        </div> <!-- End of class: NewLightbox -->
    </div> <!-- End of first div under KIND -->
    
    <div id="KindDropdown" >
    <!-- showKindChoices() & filterFunctions() are in NetManager-p2.js -->
    <input type="text" onfocus="showKindChoices(); blurGroupChoices();" placeholder="Type to filter list.." id="KindInput" 
           class="netGroup" onkeyup="filterFunction(1)"/>
    <div class='KindDropdown-content hidden'>
        
<?php echo $kindList;?>    <!-- Created in buildThreeDropdowns.php -->
       
    </div> <!-- End KindDropdown -->
    </div> <!-- End KindDropdown-content -->
            
    <!-- ==== FREQ ======= -->  
    <div>Select the Frequency:</div>
    <div id="FreqDropdown" >
        <!-- showFreqChoices() & filterFunctions() at the bottom of index.php -->
        <input type="text" onfocus="showFreqChoices(); blurKindChoices(); " placeholder="Type to filter list.." id="FreqInput" 
               class="netGroup" onkeyup="filterFunction(2)"/>
        <div class='FreqDropdown-content hidden'>
            
<?php echo $freqList; ?>    <!-- Created in buildThreeDropdowns.php -->
           
        </div> <!-- End FreqDropdown -->
    </div> <!-- End FreqDropdown-content -->
            
    <div class="last3qs">If this is a Sub Net select the<br>open primary net:</div>

    <!-- If any option is selected make the cb1 span (show linked nets) button appear using function showLinkedButton() -->
     <select class="last3qs" id="satNet" title="Sub Net Selections" onfocus="blurFreqChoices(); ">
    	<option value="0" selected>None</option>

<?php  require_once "buildSubNetCandidates.php"; ?>

     </select>
				
		<label class="radio-inline last3qs" for="pb">Click to create a Pre-Build Event &nbsp;&nbsp;&nbsp;
		    <!-- doalert() & seecopyPB() in NetManager-p2.js -->
			<input id="pb" type="checkbox" name="pb" class="pb last3qs" onchange="doalert(this); seecopyPB(); " />
		</label>
		
		<div class="last3qs">Complete New Net Creation:</div>
		
		<br>
		<!-- newNet() & hideit() in NetManager-p2.js -->
		<input id="submit" type="submit" value="Submit" onClick="newNet();"  title="Submit The New Net">
		<input class="" type="button" value="Cancel" onclick="hideit();" title="Cancel">
				   
	    </div>	    <!-- End of makeNewNet -->
	    
	    <div id="remarks" class="remarks hidden"></div>
	    
    <!-- Building the upper right corner is triggered by: showActivities() in NetManager.js -->
    <p class="tb2 TipBubbles initiallyHidden" style="width: 400px; left: 200px; margin-bottom: -40px;">
        <a class="tipimage" href="https://net-control.us/help.php#open" target="_blank">Dropdown of nets and/or current net being displayed.</a></p>
        
    <p class="tb2 TipBubbles initiallyHidden" style="width: 300px; left: 775px; margin-bottom: 40px;">
        <a class="tipimage" href="https://net-control.us/help.php#refreshtimed" target="_blank">Immediate and Timed Data Refresh</a></p>
	
   	<p class="tb1 TipBubbles initiallyHidden" style="left: 200px; width: 450px;  margin-bottom: 50px;">
        <a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Select to display an active or closed net.</a></p>
        
        <div class="btn-toolbar" >
        
		    <div class="form-group" id="form-group-1" title="form-group" >
    		
    		<!-- switchClosed() in NetManager-p2.js -->
    		<!-- The tohide class is used by net_by_num() -->
    		
    	<!--	<label for="select1">Or make a selection from this dropdown</label>  -->
    	
        <select id="select1" data-width='auto' class="tohide form-control selectpicker selectdd" name="activities" 
	        onchange="showActivities(this.value, this.options[this.selectedIndex].innerHTML.trim()); switchClosed();  ">
	        	
	        <option class="tohide pbWhite firstValue" value="a" selected disabled >Or Select From Past 10 Days Nets</option>
	        
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
		      <li><a href="#" data-sec="10" >5s</a></li>
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
    	<p class="tb2 TipBubShort initiallyHidden" style="width:300px; left: 350px; margin-bottom: 25px;">
        	<a class="tipimage" href="https://net-control.us/help.php#advanced" target="_blank">Hover/Click here to add General Comments</a></p>
        	
		<div id="genComments" class=" editGComms"></div>

	</div>   <!-- End ID: forcb1 -->
	  <!-- End of besticky -->
	  
	  <!-- Tip Bubbles -->
	 <p class="tb2 TipBubbles initiallyHidden" style="width:300px; left: 50px; margin-bottom: -40px;">
    	 <a class="tipimage" href="https://net-control.us/help.php#checkins" target="_blank">Enter Callsign or name displays hints</a></p>
	 <p class="tb2 TipBubbles initiallyHidden" style="width:150px; left: 455px; margin-bottom: -40px;">
    	 <a class="tipimage" href="https://net-control.us/help.php#checkins" target="_blank">Traffic Short Cut</a></p>
	 <p class="tb2 TipBubbles initiallyHidden" style="width:250px; left: 655px; margin-bottom: -40px;">
    	 <a class="tipimage" href="https://net-control.us/help.php#additionalColumns" target="_blank"> Select Columns for display</a></p>
	 <p class="tb2 TipBubbles initiallyHidden" style="width:350px; left: 950px; margin-bottom: 40px;">
    	 <a class="tipimage" href="https://net-control.us/help.php#timeline" target="_blank">Button Bar with Time Line and Net Status buttons</a></p>
	<div id="admin" class=" admin ">   <!-- End is @645 -->
		<div id="csnm" class="hidden">

	    <div id="primeNav" class="flashit" style="position:sticky; top:0; z-index:1;">  <!-- changed to Div from  <nav id=" on 2019-05-02 -->
	    
	    <!-- The cs1 entry or call sign can take the form of a call sign or a name, either will cause -->
	    <!-- the system to filter existing entries on whats entered either fully or partially. -->
		<input id="cs1" type="text" placeholder="Call or First Name" maxlength="16" class="cs1" autofocus="autofocus" autocomplete="off" tabindex=1 > 
		
		<!-- Below input is where the hints from cs1 and Fname go before being selected -->
		<input type="hidden" id="hints">
		
		<!-- Input first name add readonly to prevent editing -->
		<!-- autocomplet="on" removed from below on 2018-08-12 -->
		<input id="Fname" type="text" placeholder="Name" onblur="" autocomplete="off" tabindex=2>
		
		<input id="TrfkSwitch" type="text" onblur="checkIn(); this.value='' " autocomplete="off" tabindex=3 >
		
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

	</div>	<!-- End ID: csnm @467 -->
		
			<div  id="txtHint"></div> <!-- populated by NetManager.js -->
			<div id="netIDs"></div>			
			<div id="actLog">net goes here</div> <!-- Home for the net table -->
			
			<br>
			<div class="hidden" id="subNets"></div> <!-- Home for the sub-nets -->
			<br>
					
	<!--	The 'Export CSV' & 'Map This Net' buttons are written by the getactivities.php program --> 
			
			<!-- HideTimeLine() in NetManager.js -->
			<button class="timelineBut timelineBut2" onclick="RefreshTimeLine(); location.href='#timeHead';">Update</button>
			
			<input id="timelinehide" type="submit" value="Hide TimeLine" class="timelinehide" onClick="HideTimeLine();" />
			
			<input id="timelinesearch" type="text" name="timelinesearch"  placeholder="Search Comments: Search for numbers only" class="timelinesearch" style="border: 2px solid green;" >
			
			<button class="timelineBut3" type="button" id="runtls" 
			style="background-color: #f9e1e1; border-radius: 8px; border: 2px solid black; "
			onclick="timelinesearch();">Search</button>
			
			<img src="images/newMarkers/q-mark-in-circle.png" id="QmarkInCircle" class="timelineBut2" alt="q-mark-in-circle" width="15" style="padding-bottom: 25px; margin-left: 1px; background-color: #e0e1e3;" />
			
			<div id="q-mark-in-circle" class="timelineBut timelineBut2" style="font-size: 14pt; background-color: #f6dbdb; border: 2px solid red;  ">
    			<p style="color:red;"><br>This search function is primarily to find numbers.</p><p style="color:blue;">It was written to help track marathon and bike events where bib numbers are used to track participants. </p><p style="color:blue;">Other searches may or may not return what you are looking for. If a more general search is needed, use your browser Find instead, or right-click the Comments field of the station in the NetLog.
    			</p>
			</div>
			
			<div id="timeline" class="timeline"></div>		
			
		</div>   
	</div> <!-- end admin @466 -->		

        <!-- only reference to #status is in netmanager.css, but what does this div do? -->
        <!-- commented 04/25/22
	    <div id="status"></div>
	    -->
	    <!--
	    <div id="modalList" class="hidden">Modal List goes here</div>
	    -->
	</div> <!-- End id netchoice -->
	
	<!-- https://jquerymodal.com -->
	<div id="#cc" class="modal" style="display:none;">	
		<p>&copy; Copyright 2015-2022, by Keith D. Kaiser, WA0TJT <br> Last Update: <span id="lastup">2022-04-25</span></p>
		<p>Questions, problems, concerns? ....send them to: 
			<a href="mailto:wa0tjt@gmail.com?subject=NCM">Keith D. Kaiser</a><br>
			Or click <a href="help.php" target="_blank" rel="noopener">here for a detailed Help page. </a></p>
			
	    <p> In order to succeed, you must know what you are doing, like what you are doing, and believe in what you are doing. -- Will Rogers
		</p>
		<p><a href="#" rel="modal:close">Close</a></p>
	</div> <!-- End id cc -->
	
	<div id="lli" class="modal-dialog" style="display:none; "></div> <!-- End of id lli -->
	
	<div id="pbl" class=" modal hidden"></div> <!-- End of id ppl, Holds the list of pre-built nets created in PBList.php -->
	
	<div id="gcomm" class="gcomm hidden">gcomm</div>
	
	<div id="testEmail" class="testEmail hidden"></div>
	
	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

     <!-- All the quotes go here -->
<!--
        <h3 class="preQuote">Click anywhere to stop animation</h3>
    	<h2 class="quotes">
        	<p style="font-size: larger ; color:blue;">https://net-control.us</p>
        	<!- - https://www.developerdrive.com/responsive-image-gallery-flexbox/ - ->
        	<div class="image-container">	
           
            <img class="myimg" src="images/mars.png" alt="mars" width="100" height="" >      	 
            
            <img class="myimg" src="images/skywarn.png" alt="skywarn" width="100" height="" >
            
            <img class="myimg" src="images/nts.png" alt="nts" width="100" height="" >
           
        	<img class="myimg" src="images/ARES.png" alt="ARES" width="100" height="" >
        	
        	<img class="myimg" src="images/RACES.png" alt="RACES" width="100" height="" >
        	
            <img class="myimg" src="images/satern.png" alt="satern" width="100" height="" >
        	
            <img class="myimg" src="images/QSOTodayEXPOSPEAKERBadge.png" alt="QSOTodayEXPOSPEAKERBadge" width="120" height="" >
        	<br> 
        	<img src="images/century21.png" alt="century21" width="225" height="" >
           
        	<img src="images/redcross.png" alt="redcross" width="225" height="" >
        	
        	<img src="images/cert.png" alt="cert" width="225" height="" >
        	
        	<img src="images/waefar.png" alt="waefar" width="225" height="" >
        
        	 <!- - Morse code source:  https://fontmeme.com/morse-code/. - ->
        	</div>        
        	 <u style="color:green;">Net Control Manager is NOT a QSO logger!</u>
        <br> 

    	    NCM was designed to make Amateur Radio Net check-ins, management of net resources and net 
    	    reporting easier and more efficient than using pen and paper. 
        <br>
            <img src="https://fontmeme.com/permalink/210504/f0ecbecf17e599b921b90be7131d1d45.png" alt="morse" width="100%">
                
        </h2>  <!- - End of H2 - ->
        
        <h2 class="quotes"><b style="color:red">HINT:</b><br> Not Logging the Net: <b style="color:green"> Put yourself in 5sec Refresh Mode...</b><b style="color:blue"> Use The Blue 'Timed' Button</b><br>
             <img src="https://fontmeme.com/permalink/210512/65b1605a04f69309d96103ced85f1754.png" alt="NCM" width="25%"></h2>
    	
        <h2 class="quotes">NCM is not a replacement for pen and paper, which will always be your 
            best backup should something go wrong.<br>
             <img src="https://fontmeme.com/permalink/210512/65b1605a04f69309d96103ced85f1754.png" alt="NCM" width="25%">
        </h2>
        <h2 class="quotes">NCM was designed to be easily usable by the Net Control Operator alone, however someone else keeping log while you control the net is always a good idea.<br>
             <img src="https://fontmeme.com/permalink/210512/65b1605a04f69309d96103ced85f1754.png" alt="NCM" width="25%">
        </h2>
        <?php
				echo "<h2 class='quotes'>
				    As of Today: <br>  $netcall Groups, <br> $cscount Unique Stations, <br> $netCnt Nets, <br> $records Logins <br>
				    <img src='https://fontmeme.com/permalink/210514/469ac0e73fe5e79d55c4c332c794fa07.png' alt='K'></h2>"?>
-->
     <!-- All the quotes end here -->
	
<!-- ************************  JAVASCRIPT LIBRARIES  ******************************************** -->	
	
    <!-- jquery updated from 3.4.1 to 3.5.1 on 2020-09-10 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
	
	<!-- Updated from 1.12.1 on 3/21/22 -->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.1/jquery-ui.min.js"></script>
	
<!-- My javascript -->	
	<script src="js/NetManager.js"></script>         <!-- NCM Primary Javascrip 2018-1-18 -->
	<script src="js/NetManager-p2.js"></script>	     <!-- Part 2 of NCM Primary Javascript 2018-1-18 -->
	
	<script src="js/CellEditFunction.js"></script>	 <!-- Added 2018-02-12 -->
	
	<script src="js/grid.js"></script>
	<script src="js/gridtokoords.js"></script>
	<script src="js/cookieManagement.js"></script>
	
    <script>
        
    	
// function to handled dialog modal for the question mark in circle at time line & other places
// https://www.tutorialspoint.com/jqueryui/jqueryui_dialog.htm
$ ( function() {
    $( "#q-mark-in-circle" ).dialog({
        autoOpen:false, 
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
               title: "Search Advisory:",
               position: {
                  my: "center",
                  at: "center"
               }
    });
                                     
    $( "#QmarkInCircle" ).click(function() {
        $( "#q-mark-in-circle" ).dialog( "open" );
    });
}); // end click @ #q-mark-in-circle()



(function() {

    var quotes = $(".quotes"); //variables
    var quoteIndex = -1;
    
    function showNextQuote() {
        ++quoteIndex;  //increasing index
        quotes.eq(quoteIndex % quotes.length) //items ito animate?
            .fadeIn(6500) //fade in time
            .delay(250) //time until fade out
            .fadeOut(5800, showNextQuote); //fade out time, recall function
    }
    showNextQuote();  
})();

$("body").click(function(){
    $(".quotes").addClass("hidden");
    $(".preQuote").addClass("hidden");
});


// This javascript function tests the callsign being used to start a new net as to being in a list of callsigns that did not close a previous net.
function checkCall() {
    const cs = $("#callsign").val().trim().toUpperCase();
    const listOfCalls = new Set( ['ah6ez', 'kc1oiz', 'w0erh', 'ad0im', 'k4flm', 'k0wtf', 'wb4ftu', 'k0bcf', 'w1jku', 'kn4krz', 'ke0kxz', 'w5ola' ]);
    const isCallInSet = listOfCalls.has($("#callsign").val());
    
    console.log('@727 in index.php cs: '+cs+'  listOfCalls: '+listOfCalls+'  isCallInSet:  '+isCallInSet);
    
    // If the callsign starting this net is in the above list then ask for his email to send him a message
    if (!isCallInSet == '') {
        var mail = prompt('Please enter your email address.');
            if (mail == '' || mail == null) {
                alert("Please be sure to close your net when finished. Thank you!");
            } else {

                var str = cs+":"+mail;  //alert(str);
                console.log('@737 str= '+str);
            
                $.ajax({
                    type: 'GET',
                    url: 'addEmailToStations.php',
                    data: {q: str},
                    success: function(response) { 
                        //alert(response);
                } // end success
                }) // end ajax
                } // else 
        // Possible ways to send an email
        // Javascript:  https://smtpjs.com
        // PHP:         https://www.w3schools.com/php/func_mail_mail.asp
        // AJAX:        Put the collected email into his record in the stations table.
    } // End if
} // end checkCall function


// require_once "wx2.php";	at line 45 
// This function uses the clickers callsign to look up their lat/lon from the stations table. 
// That lat/lon is passed on to the wx2.php program to get the appropriate counties wx for display.
function newWX() {
    var str = prompt('What is your callsign?');
        if (str =="") { alert("OK no valid call was entered");
        }else { var thiscall = [str.trim()]; 
               console.log('@759 This call is '+thiscall);
                        
                  $.ajax({
			                type: "GET",
			                url: "getNewWX.php",  
			                data: {str : str},
			                success: function(response) {
                        console.log(response);
			            },  // end success
			                error: function() {
				                alert('Last Query Failed, try again.');
			                } // End error
		              }); // End ajax
	      } // end of else
} // end newWX function

$( function() {
    $( "#menu" ).menu({
      items: "> :not(.ui-widget-header)"
    });
  } );


</script>

</body>
</html>