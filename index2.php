<!doctype html>

<?php
/*  index2.php   ****************************************************************
 * Net Control Manager (NCM) - Version 1, @2
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
    require_once "CellRowHeaderDefinitions.php";
    require_once "getGenCommentsReplacement.php";
    $existingComments = getExistingComments($netID);
    
    error_log("NetID: " . $netID);
    error_log("Existing Comments: " . $existingComments);
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
    
    <!-- https://fonts.google.com -->
    <!-- Allerta is used to slash zeros so don't delete -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Allerta&display=swap" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Stoke&display=swap" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cantora+One&display=swap" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Risque&display=swap" >
    
    <!-- ===============                          ================================== -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
    <!-- =============== All above this should not be editied ====================== -->
    
    <!-- ======== -->
    
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 -->
    <link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- ============== My style sheets ============================================= -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >   <!-- Primary style sheet for NCM  -->
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >		<!-- 2018-1-17 -->
    <link rel="stylesheet" type="text/css" href="css/sparkel-text.css">
    
    <!-- ============== All the @media stuff ======================================== -->
    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css">	
    
<style>

</style>

    <!-- Core JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>              <!-- v3.3.2 -->
    <script src="js/jquery.freezeheader.js"></script>                 <!-- v1.0.7 -->
    <script src="js/jquery.simpleTab.min.js"></script>               <!-- v1.0.0 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script>
    <script src="bootstrap/js/bootstrap-select.min.js"></script>      <!-- v1.12.4 -->
    <script src="bootstrap/js/bootstrap-multiselect.js"></script>     <!-- 2.0 -->
    <script src="js/jquery.jeditable.js"></script>                    <!-- 1.8.1 -->
    <script src="js/sortTable.js"></script>
    <script src="js/hamgridsquare.js"></script>
    <script src="js/jquery.countdownTimer.js"></script>
    <script src="js/w3data.js"></script>

    <!-- Column Manager Setup -->
    <script>
        window.columnDefinitions = <?php echo json_encode($columns); ?>;
    </script>
    <script src="js/columnManager.js"></script>

    

</head>

<body>

<!-- Upper left corner of opening page -->
<div class="openingImages">
    <!-- NCM and Net Control Manager images at top of page -->
    <img id="smtitle" src="images/NCM.png" alt="NCM" >
    <img id="pgtitle2" src="images/NCM3.png" alt="NCM2" >
    
    <span id="version">
    	<a href="https://groups.io/g/NCM" target="_blank">About</a> 
    </span> <!-- End of id version -->
</div> <!-- End openingImages -->

	
<div id="dttm"> <!-- flex container for date & time -->
    <div id="dttm1">
        <input type="radio" name="tz" id="theLocal" value="theLocal" size = "60" onclick="goLocal()">
        <br>
        <input type="radio" name="tz" id="theUTC" value="theUTC" onclick="goUTC()" >
    </div>

    <!-- To comment this function: comment setInterval('showDTTM()', 1000); in netManager-p2.js -->
	<div id="dttm2">
	</div>  
</div> <!-- end flex container for date & time  -->
		 

<div class = "weather-place">
	<img src="images/US-NWS-Logo.png" alt="US-NWS-Logo" width="50" height="50" onclick="newWX()">

	<a href="https://www.weather.gov" class="theWX" target="_blank" rel="noopener">
		<!-- CurrentWX() was developed by Jeremy Geeo, KD0EAV Found it wx.php -->
        <?php echo getOpenWX(); ?>   <!-- from wx.php -->
	</a>  
</div> <!-- End of class: weather-place -->
<!-- End of upper-left-corner stuff -->
		
    <br>
       
<?php
    // Upper right corner menus
    require_once "NCMMenus.php";
    $menus = new NCMMenus($db);
    echo $menus->renderUpperRightCorner();
    
?> <!-- End of menu inclusion -->
	      
 	<div id="org" class="hidden"></div> <!-- Used by putInGroupInput() in NetManager-p2.js  -->
    <div id="netchoice">
	<div id="netdata">
    	
    <!-- Use the <p> below to add a short message at the top of NCM. This span is hidden in NetManager.js , It's unhidden in the newnet() current in this file. The <br> adds a space after the upper right corner -->
		<p class="sparkle-text"><br>Please report any issues to NCM@groups.io Thank you.
          <!-- For the running spark effect on text above -->
          <span class="spark1"></span>
          <span class="spark2"></span>
          <span class="spark3"></span>
          <span class="spark4"></span>
          <span class="spark5"></span>
          <span class="spark6"></span>
          <span class="spark7"></span>
          <span class="spark8"></span>
        </p>
        
        <!-- start a new net stuff -->
		<div class="theBox">
    		<!-- showit() in NetManager.js -->
			<button id="newbttn" class="newbttn left-cell tbb2" onclick="showit();" title="Click to start a new net">Start a new net</button>	
        
			<button id="by_number" style="left:25px;" class="newbttn" onclick="net_by_number();" title="Net by the Number">Browse a Net by Number</button>
			<br><br>	
		</div> <!-- End start a new net stuff -->
		
		<div id="makeNewNet" class="hidden" >	
    		<div style="color: red;">* Required Field</div>
    		
            <br>
            
    <div><b style="color:red">*</b>Enter Your Call Sign:</div>   
    	<input onblur="checkCall()" type="text" required id="callsign" maxlength="16" name="callsign" autocomplete="on" title="Enter Your Call Sign" >
					
<!-- Build code for thee dropdown lists -->					
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
		
		<input id="submit" type="submit" value="Submit" onClick="newNet();" title="Submit The New Net">
		<input class="" type="button" value="Cancel" onclick="hideit();" title="Cancel">
				   
	    </div>	    <!-- End of makeNewNet -->
	    
	    <div id="remarks" class="remarks hidden"></div>
	      
        <div class="btn-toolbar" >
        
        <div class="form-group" id="form-group-1" title="form-group" >

    		
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
    
    <!-- This is where general comments are added and displayed -->
    <!-- forcb1 JS is below -->
    <!-- genComments is reloded with getGenCommens.php -->
    <!-- editGComms  is handled in ?? -->
	<div id="forcb1" class="hidden">
    <?php 
    if (empty($existingComments)) { 
        error_log("No existing comments found");
    ?>
        <p class="" style="width:300px; left: 350px; ">
            Click here to add General Comments
        </p>
    <?php } else {
        error_log("Found existing comments");
    } ?>
    <div id="genComments" class="editGComms">
        <?php if (!empty($existingComments)) { 
            echo $existingComments;
            error_log("Displaying existing comments");
        } ?>
    </div>
</div>  <!-- End ID: forcb1 -->
	  
	  
	<div id="admin" class=" admin "> <!-- Ends@ End Admin -->
		<div id="csnm" class="hidden">

	    <div id="primeNav" class="flashit" style="position:sticky; top:0; z-index:1;">  
	    
	    <!-- The cs1 entry or call sign can take the form of a call sign or a name, either will cause -->
	    <!-- the system to filter existing entries on whats entered either fully or partially. -->
		<input id="cs1" type="text" placeholder="Call or First Name" maxlength="16" class="cs1" autofocus="autofocus" autocomplete="off" tabindex=1 > 
		
		<!-- Below input is where the hints from cs1 and Fname go before being selected -->
		<input type="hidden" id="hints">
		
		<!-- Input first name add readonly to prevent editing -->
		<input id="Fname" type="text" placeholder="Name" onblur="" autocomplete="off" tabindex=2>
		
		<input id="TrfkSwitch" type="text" onblur="checkIn(); this.value='' " autocomplete="off" tabindex=3 >
		
		<!-- Some attributes of the below field are controled in NetManager.js -->
		<input id="custom" class="hidden brdrGreen" type="text" placeholder="" autocomplete="off" onblur="checkIn();" >
		
		<!-- DO NOT COMMENT THIS OUT, IT BREAKS THE DISPLAY -->
		<input id="section" class="hidden brdrGreen" type="text" placeholder="" onblur=" this.value=''" maxlength="4" size="4"> 

<!-- https://www.w3schools.com/css/css3_buttons.asp -->
<!-- The job of showing and hiding the time line is done in the TimeLine() in NetManager.js -->

        <!-- Check In button -->
		<!-- checkIN() is in NetManager-p2.js -->
		    <div class = "btn-group2">
    		    <button class="ckin1" onclick="checkIn()">Check In
    		    </button>
    		    
    		    <button class="dropbtn2" id="columnPicker" title="Manage visible columns">Show/Hide Columns
    		    </button> 
    		 
    		    <button class="timelineBut" onClick="TimeLine(); location.href='#timeHead';" >Time Line
    		    </button>
    		    
    		    <button class="timelineBut timelineBut2" onclick="RefreshTimeLine(); location.href='#timeHead';">Update
    		    </button>
    		  
    		    <button class="copyPB hidden" id="copyPB">Copy a Pre-Built
    		    </button>
    		    <button class="closenet" id="closelog" oncontextmenu="rightclickundotimeout();return false;" >Close Net
    		    </button>
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
			<!-- Replace the existing timelinesearch input with this -->
<div id="timelineSearchControls" style="display: none;">
    <input id="timelinesearch" type="text" 
           name="timelinesearch"  
           placeholder="Search TimeLog entries" 
           class="timelinesearch" 
           style="border: 2px solid green;">
    <button class="timelineBut3" 
            type="button" 
            id="runtls" 
            onclick="timelineSearch();"
            style="background-color: #f9e1e1; border-radius: 8px; border: 2px solid black;">
        Search
    </button>
    
    <img src="images/newMarkers/q-mark-in-circle.png" id="QmarkInCircle" class="timelineBut2" 
         alt="q-mark-in-circle" width="15" 
         style="padding-bottom: 25px; margin-left: 1px; background-color: #e0e1e3;" />

    <div id="q-mark-in-circle" class="timelineBut timelineBut2" 
         style="font-size: 14pt; background-color: #f6dbdb; border: 2px solid red;">
        <p style="color:red;"><br>This search function is primarily to find numbers.</p>
        <p style="color:blue;">It was written to help track marathon and bike events where bib numbers are used to track participants. </p>
        <p style="color:blue;">Other searches may or may not return what you are looking for. If a more general search is needed, use your browser Find instead, or right-click the Comments field of the station in the NetLog.</p>
    </div>
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

     
	
<!-- ************************  JAVASCRIPT LIBRARIES  ******************************************** -->	
	
	
	<!-- jquery-modal updated from 0.9.1 to 0.9.2 on 2019-11-14 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script> 
	
<!-- My javascript -->	
    <script src="js/NetManager-W3W-APRS.js"></script> <!-- Added on 2024-02-21 -->
	<script src="js/NetManager.js"></script>          <!-- NCM Primary Javascrip 2018-1-18 -->
	<script src="js/NetManager-p2.js"></script>	      <!-- Part 2 of NCM Primary Javascript 2018-1-18 -->
	
	
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

// This javascript function tests the callsign being used to start a new net as to being in a list of callsigns that did not close a previous net.
function checkCall() {
    const cs = $("#callsign").val().trim().toUpperCase();
    const listOfCalls = new Set( ['ah6ez' ]);
    const isCallInSet = listOfCalls.has($("#callsign").val());
    
    console.log('@755 in index.php cs: '+cs+'  listOfCalls: '+listOfCalls+'  isCallInSet:  '+isCallInSet);
    
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

// This function is used in the DIV GroupDropdown by the input **** DO NOT DELETE ++++
function removeSpaces(str) {
  return str.replace(/\s+/g, '');
}

document.addEventListener('keydown', function(event) {
  if (isTabletDevice() && event.shiftKey && event.key === 'Shift') {
    // Right shift key is being held down on a tablet device
    // Perform the desired action or trigger the right-click event
    event.preventDefault(); // Prevent the default shift key behavior if needed
    
    // Example: Trigger a custom right-click event on the target element
    var targetElement = event.target;
    var customRightClickEvent = new MouseEvent('contextmenu', {
      bubbles: true,
      cancelable: true,
      view: window,
      button: 2,
      buttons: 2,
      clientX: targetElement.getBoundingClientRect().left,
      clientY: targetElement.getBoundingClientRect().top
    });
    targetElement.dispatchEvent(customRightClickEvent);
  }
});

function isTabletDevice() {
  var userAgent = navigator.userAgent.toLowerCase();
  console.log('User Agent:', userAgent); // Log the user agent string
  return /ipad|android|android 3.0|xoom|sch-i800|playbook|tablet|kindle/i.test(userAgent);
}

</script>
<!-- This script should eventually be moved to CellEditFunction.js replacing lines 20 to 28, and in NetManager.js deleting lines 418 to 421 -->
<?php
require_once "getGenCommentsReplacement.php";
$existingComments = getExistingComments($netID);

// Add this debugging
error_log("NetID: " . $netID);
error_log("Existing Comments: " . $existingComments);
?>

<!-- Then modify your div to include debugging -->
<div id="forcb1" class="hidden">
    <?php 
    if (empty($existingComments)) { 
        error_log("No existing comments found");
    ?>
        <p class="" style="width:300px; left: 350px; ">
            Click here to add General Comments
        </p>
    <?php } else {
        error_log("Found existing comments");
    } ?>
    <div id="genComments" class="editGComms">
        <?php if (!empty($existingComments)) { 
            echo $existingComments;
            error_log("Displaying existing comments");
        } ?>
    </div>
</div>

<!-- My JavaScript -->
    <script src="js/NetManager-W3W-APRS.js"></script>
    <script src="js/NetManager.js"></script>
    <script src="js/NetManager-p2.js"></script>
    <script src="js/CellEditFunction.js"></script>
    <script src="js/grid.js"></script>
    <script src="js/gridtokoords.js"></script>
    <script src="js/cookieManagement.js"></script>
    
<!-- And modify your script to include debugging -->
<script>
    /*
$(document).ready(function() {
    var submitdata = function() {
        return {
            id: netID  // Assuming netid is defined elsewhere
        };
    };
    
    // Check for existing comments
    var existingText = $(".editGComms").text().trim();
    console.log("Existing text in editGComms:", existingText);
    
    // Initialize the editable functionality for this field
    $(".editGComms").editable("SaveGenComm.php", {
        indicator: "Saving...",
        placeholder: "",
        tooltip: "Click to add...",
        style: "inherit",
        submitdata: submitdata,
        id: netid,
        onsubmit: function(settings, value) {
            console.log("Submitting value:", value);
            return {
                value: value,
                id: netid
            };
        }
    });

    // Handle clicking in the field
    $('#forcb1').on('click', function() {
        console.log("forcb1 clicked");
        // Hide the "Click here to add..." text if it exists
        $(this).find('p').hide();
        
        // Clear and activate the editable area
        $(".editGComms").empty().trigger('click');
    });

    // If there are existing comments, ensure the default text is hidden
    if (existingText.length > 0) {
        console.log("Hiding default text due to existing content");
        $('#forcb1 p').hide();
    }
});
*/
</script>
    
</body>
</html>