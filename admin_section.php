<?php
/**
 * Net Control Manager (NCM) - Admin Section Component
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */
?>
<div id="admin" class="admin">   <!-- End is @645 -->
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

    </div>	<!-- End ID: primeNav -->
    
        <div id="txtHint"></div> <!-- populated by NetManager.js ==> gethintSuspects.php-->
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
        
    </div> <!-- End ID: csnm -->
</div> <!-- end admin -->