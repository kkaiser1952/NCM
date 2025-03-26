<?php
// index.php   for  .us
/***********************************************************************************************************
 
 /**
 * Net Control Manager (NCM) - Version 1
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 * 
 * APPLICATION OVERVIEW
 * -------------------
 * NCM is a comprehensive CRUD application designed for Amateur Radio operators to manage
 * and document various network operations including:
 * - Weather emergencies
 * - Club meetings
 * - Bike ride support
 * - General communications logging
 * 
 * KEY FEATURES
 * ------------
 * - Station location mapping
 * - DHS/FEMA compliance
 * - ICS-214 and ICS-309 reporting
 * - Additional ICS report access
 * - Extensive help documentation
 * 
 * CORE WORKFLOWS
 * -------------
 * 1. Existing Net Selection:
 *    - Lists past 10 days of nets in dropdown (#select1)
 *    - Color coding: Green (open), Blue (pre-built), None (closed)
 *    - Processing: showActivities() in NetManager.js
 *    - Data population via buildUpperRightCorner.php and getactivities.php
 * 
 * 2. New Net Creation:
 *    - Data collection through dropdown selections
 *    - Operator callsign logging
 *    - Processing: newNet() in NetManager-p2.js
 *    - Database updates via newNet.php
 * 
 * SYSTEM INFORMATION
 * -----------------
 * Current: PHP Version 5.6.33-0+deb8u1
 * Planned Upgrade: PHP 7.4+76
 * Development Status: Continuous enhancement since 2015
 * 
 * LEGAL NOTICE
 * ------------
 * This software is provided "as is" without warranty of any kind, either expressed
 * or implied, including but not limited to the warranties of merchantability and
 * fitness for a particular purpose.
 */
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "wx.php";			   // Makes the weather information available
    require_once "NCMStats.php";       // Get some stats

require_once "header.php";
?>

<body>

<!-- Upper left corner of opening page -->
<div class="openingImages">
    <!-- NCM and Net Control Manager images at top of page -->
    <img id="smtitle" src="images/NCM.png" alt="NCM" >
    <img id="pgtitle2" src="images/NCM3.png" alt="NCM2" >
    
    <span id="version">
        <!-- Years in service from 3/2015 . Month . day  of last update -->
    	<!-- <a href="#cc" rel="modal:open" id="version2">v8.03.11 -->
    	<a href="https://groups.io/g/NCM" target="_blank">About</a> 
    	<!--
    	window.open("", "version2",  strWindowFeatures);
    	var popupWindow = window.open("", "Preamble",  strWindowFeatures);
        -->
    </span> <!-- End of id version -->
</div> 

<!-- From showDTTM() in NetManager-p2.js -->
<p class="tb1 TipBubbles initiallyHidden" style="width: 200px; margin-bottom: 40px;">
	<a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Choose Your Time Zone</a></p>
	
<div id="dttm"> <!-- flex container -->
    <div id="dttm1">
        <input type="radio" name="tz" id="theLocal" value="theLocal" size = "60" onclick="goLocal()">
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

	<a href="https://www.weather.gov" class="theWX" target="_blank" rel="noopener">
		<!-- CurrentWX() was developed by Jeremy Geeo, KD0EAV Found it wx.php -->
        <?php echo getOpenWX(); ?>   <!-- from wx.php -->
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
       <!-- Added buy me a coffee button -->
       
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
	    
	    <a href="AddRF-HolePOI.php" target="_blank" rel="noopener" id="PoiList" title="Create New RF Hole POI">Add RF Hole POI</a>
	    
	    
	    <a href="#" id="geoDist" onclick="geoDistance()" title="GeoDistance">GeoDistance</a>

	    <a href="#" id="mapIDs" onclick="map2()" title="Map This Net">Map This Net</a>
	    
	    <a href="https://vhf.dxview.org" id="mapdxView" target="_blank">DXView Propagation Map</a>
	    
	    <a href="https://www.swpc.noaa.gov" id="noaaSWX" target="_blank">NOAA Space Weather</a>
	    
	    <a href="https://spaceweather.com" id="SpaceWX" target="_blank">Space Weather</a>
 
	    <a href="#" id="graphtimeline" onclick="graphtimeline()" title="Graphic Time Line of the active net">Graphic Time Line</a>
		<a href="#" id="ics205Abutton" onclick="ics205Abutton()" title="ICS-205A Report of the active net">ICS-205A</a>
		<a href="#" id="ics214button" onclick="ics214button()" title="ICS-214 Report of the active net">ICS-214</a>
		<a href="#" id="ics309button" onclick="ics309button()" title="ICS-309 Report of the
    		active net">ICS-309</a>
		<a href="https://training.fema.gov/icsresource/icsforms.aspx" id="icsforms" target="_blank" rel="noopener">Addional ICS Forms</a>
        <a href="https://docs.google.com/spreadsheets/d/1eFUfVLfHp8uo58ryFwxncbONJ9TZ1DKGLX8MZJIRZmM/edit#gid=0" target="_blank" rel="noopener" title="The MECC Communications Plan">MECC Comm Plan</a>
		<a href="https://upload.wikimedia.org/wikipedia/commons/e/e7/Timezones2008.png" target="_blank" rel="noopener" title="World Time Zone Map">World Time Zone Map</a>
	  </span> <!-- End of class dropdown-content -->
   </span> <!-- End of class dropdown -->
	
		  	   <!-- Open the NCM help/instructions document -->
		  	   <a id="helpdev" href="https://net-control.us/help.php" target="_blank" rel="noopener" title="Click for the extended help document">Help</a>&nbsp;||&nbsp;
				
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
       </a>
            
         
<div class="donation-container">
    <button class="coffee-button" onclick="toggleExpand()">Buy Me a Coffee</button>
    
    <div class="donation-content">
        <div class="amount-buttons">
            <button class="amount-btn" data-amount="3">$3</button>
            <button class="amount-btn selected" data-amount="5">$5</button>
            <button class="amount-btn" data-amount="10">$10</button>
        </div>

        <div class="payment-methods">
            <button class="payment-btn" data-method="paypal" data-link="https://paypal.me/KeithKaiser/">PayPal</button>
            <button class="payment-btn" data-method="venmo" data-link="https://venmo.com/KeithKaiser">Venmo</button>
        </div>

        <button class="donate-btn" onclick="handleDonate()">Donate $5</button>
    </div>
</div> <!-- End of class: donation-container -->
			       
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
	
		<p class="sparkle-text">Please report any issues to NCM@groups.io Thank you.
          <span class="spark1"></span>
          <span class="spark2"></span>
          <span class="spark3"></span>
          <span class="spark4"></span>
          <span class="spark5"></span>
          <span class="spark6"></span>
          <span class="spark7"></span>
          <span class="spark8"></span>
        </p>
	
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
    		<div style="color: red;">* Required Field</div>
    		<!--
            <label class="Testcontainer" for="testnet">Click if making a test net? &nbsp;&nbsp;&nbsp;
    		    <input id="testnet" type="checkbox" name="testnet" value="y" >
    		   
            </label>
            -->
            <br>
            
    <div><b style="color:red">*</b>Enter Your Call Sign:</div>   
    	<input onblur="checkCall()" type="text" required id="callsign" maxlength="16" name="callsign" autocomplete="on" title="Enter Your Call Sign" >
					
<?php  require_once "buildThreeDropdowns.php"; ?>
			     
    <!-- ==== GROUP ======= -->
    <div><b style="color:red">*</b>Select Group or Call:&nbsp;
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
        <input type="text" onfocus="showGroupChoices()" placeholder="Type to filter list.." id="GroupInput" style="background-color:white;"
               class="netGroup"  onkeyup="this.value = removeSpaces(this.value); filterFunction(0);" required />
        <div class='GroupDropdown-content hidden'>
            
<?php echo $groupList;?>    <!-- Created in buildThreeDropdowns.php -->
            
        </div> <!-- End GroupDropdown -->
    </div> <!-- End GroupDropdown-content -->
            
    <!-- ==== KIND ======= -->
    <div><b style="color:red">*</b>Select Kind of Net:&nbsp;&nbsp;&nbsp;
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
    <div><b style="color:red">*</b>Select the Frequency:</div>
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
		<!-- newNet() & hideit() createNetKindView() in NetManager-p2.js -->
		<!-- I removed createNetKindView() on 2023-04-16 don't think we need it -->
		<input id="submit" type="submit" value="Submit" onClick="newNet();" title="Submit The New Net">
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
            
<!-- PHP to build the list of nets from the last 10 days -->
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
    	 <a class="tipimage" href="https://net-control.us/help.php#timeline" target="_blank">Command Bar with Time Line and Net Status buttons</a></p>
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
		
			<div  id="txtHint"></div> <!-- populated by NetManager.js ==> gethintSuspects.php-->
			<div id="netIDs"></div>			
			<div id="actLog">net goes here</div> <!-- Home for the net table -->
			
			<br>
			<div class="hidden" id="subNets"></div> <!-- Home for the sub-nets -->
			<br>
					
	<!--	The 'Export CSV' & 'Map This Net' buttons are written by the getactivities.php program --> 
			
			<!-- HideTimeLine() in NetManager.js -->
			<button class="timelineBut timelineBut2" onclick="RefreshTimeLine(); location.href='#timeHead';">Update</button>
			
			<input id="timelinehide" type="submit" value="Hide TimeLine" class="timelinehide" onClick="HideTimeLine();" />
			
			<!-- When the time line shows this is a specific search or numbers -->
			<input id="timelinesearch" type="text" name="timelinesearch"  placeholder="Search Comments: Search for numbers only" class="timelinesearch" style="border: 2px solid green;" />
			
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
		<p>&copy; Copyright 2015-2023, by Keith D. Kaiser, WA0TJT <br> Last Update: <span id="lastup">2023-03-11</span></p>
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

    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

<?php require_once "footer.php"; ?>

</body>
</html>