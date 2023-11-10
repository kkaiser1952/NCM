<!doctype html>


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
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 -->
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- ============== My style sheets ============================================= -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >   <!-- Primary style sheet for NCM  -->
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >				<!-- 2018-1-17 -->
    
    <!-- ============== All the @media stuff ======================================== -->
    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css">	
    <link rel="stylesheet" type="text/css" href="css/bubbles.css">
	 
<style>
	
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
        Kansas City: Clear, 33F, wind: N @ 3, humidity: 57%   <!-- from wx.php -->
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
	    
	    <a href="AddRF-HolePOI.php" target="_blank" rel="noopener" id="PoiList" title="Create New RF Hole POI">Add RF Hole POI</a>
	    
	    
	    <a href="#" id="geoDist" onclick="geoDistance()" title="GeoDistance">GeoDistance</a>

	    <a href="#" id="mapIDs" onclick="map2()" title="Map This Net">Map This Net</a>
	    
	    <a href="https://vhf.dxview.org" id="mapdxView" target="_blank">DXView Propagation Map</a>
	    
	    <a href="https://www.swpc.noaa.gov" id="noaaSWX" target="_blank">NOAA Space Weather</a>
	    
	    <a href="https://spaceweather.com" id="SpaceWX" target="_blank">Space Weather</a>
 
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
	
		<p style="margin-bottom:10px;">Please report any issues to NCM@groups.io Thank you.</p>
	
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
            
 <a href='#1;Weekly 2 Meter Voice;146.790MHz, PL107.2Hz;W0KCN;KCNARES' onclick='putInGroupInput(this);'>'W0KCN' ---> KCNARES</a>
<a href='#2;Weekly 2 Meter Voice;146.790MHz, PL107.2Hz;KCABARC;Kansas City Association for the Blind Amateur Radio Club' onclick='putInGroupInput(this);'>'KCABARC' ---> Kansas City Association for the Blind Amateur Radio Club</a>
<a href='#3;Weekly 2 Meter Voice;146.655MHz, PL94.8Hz;CARROLL;Carroll County MO. ARES' onclick='putInGroupInput(this);'>'CARROLL' ---> Carroll County MO. ARES</a>
<a href='#4;Weekly 2 Meter Voice;147.330MHz, PL151.4Hz;CREW2273;CREW 2273' onclick='putInGroupInput(this);'>'CREW2273' ---> CREW 2273</a>
<a href='#5;Missouri;80/40 Meters;FSQCall;FSQCall' onclick='putInGroupInput(this);'>'FSQCall' ---> FSQCall</a>
<a href='#6;Weekly 80 Meter Voice;443.500 MHz PL151.4Hz;KCHEART;Kansas City Hospital Emergency Amateur Radio Team' onclick='putInGroupInput(this);'>'KCHEART' ---> Kansas City Hospital Emergency Amateur Radio Team</a>
<a href='#7;Weekly 80 Meter Voice;3.963MHz LSB;MESN;Missouri Emergency Services' onclick='putInGroupInput(this);'>'MESN' ---> Missouri Emergency Services</a>
<a href='#8;Event;444.550Mhz(+) PL100.0Hz;OTHER;' onclick='putInGroupInput(this);'>'OTHER' ---> </a>
<a href='#9;Weekly 2 Meter Voice;147.225(+), PL 94.8Hz;NCMO;North Central Missouri' onclick='putInGroupInput(this);'>'NCMO' ---> North Central Missouri</a>
<a href='#10;Weekly 2 Meter Voice;147.330MHz, PL151.4Hz;NR0AD;PCARG' onclick='putInGroupInput(this);'>'NR0AD' ---> PCARG</a>
<a href='#11;Weekly 2 Meter Voice;146.790MHz, PL107.2Hz;K0ERC;Platte City Stake' onclick='putInGroupInput(this);'>'K0ERC' ---> Platte City Stake</a>
<a href='#12;Echolink;KD0EAV-R;K2BSA;Radio Scouting' onclick='putInGroupInput(this);'>'K2BSA' ---> Radio Scouting</a>
<a href='#13;HF;7.099MHz, USB;SEMA;SEMA' onclick='putInGroupInput(this);'>'SEMA' ---> SEMA</a>
<a href='#14;Weekly 2 Meter Voice;146.790MHz, PL107.2Hz;TechGuys;TechGuys' onclick='putInGroupInput(this);'>'TechGuys' ---> TechGuys</a>
<a href='#15;Test;444.550Mhz(+) PL100.0Hz;TE0ST;For Testing Only' onclick='putInGroupInput(this);'>'TE0ST' ---> For Testing Only</a>
<a href='#16;Weekly 2 Meter Voice;146.790MHz, PL107.2Hz;W0TE;Clay Co. Amateur Radio Club' onclick='putInGroupInput(this);'>'W0TE' ---> Clay Co. Amateur Radio Club</a>
<a href='#17;Weekly;80 Meters;ORCA;ORCA Digital' onclick='putInGroupInput(this);'>'ORCA' ---> ORCA Digital</a>
<a href='#18;Weekly 2 Meter Voice;146.290MHz, PL151.4Hz;W0ERH;Johnson Co. Radio Amateurs Club' onclick='putInGroupInput(this);'>'W0ERH' ---> Johnson Co. Radio Amateurs Club</a>
<a href='#19;Weekly 2 Meter Voice;145.310(-) No Tone;K0EJC;Eastern Jackson Co. RACES/ECS' onclick='putInGroupInput(this);'>'K0EJC' ---> Eastern Jackson Co. RACES/ECS</a>
<a href='#20;Weekly 2 Meter Voice;146.940MHz;K0HAM;NORTH EAST KANSAS AMATEUR RADIO CLUB' onclick='putInGroupInput(this);'>'K0HAM' ---> NORTH EAST KANSAS AMATEUR RADIO CLUB</a>
<a href='#21;Weekly 2 Meter Voice;146.580MHz, Simplex;KS0JC;Johnson County KS ARES' onclick='putInGroupInput(this);'>'KS0JC' ---> Johnson County KS ARES</a>
<a href='#22;Weekly 2 Meter Voice;147.225(+), PL 94.8Hz;LCARES;Livingston County MO ARES' onclick='putInGroupInput(this);'>'LCARES' ---> Livingston County MO ARES</a>
<a href='#23;Weekly 2 Meter Voice;147.375Mhz PL156.7Hz;K0ESM;Ray-Clay Radio Club' onclick='putInGroupInput(this);'>'K0ESM' ---> Ray-Clay Radio Club</a>
<a href='#24;Meeting;Eyeball;KCMECC;Metropolitan Emergency Communications Commission' onclick='putInGroupInput(this);'>'KCMECC' ---> Metropolitan Emergency Communications Commission</a>
<a href='#25;Weekly 2 Meter Voice;146.880MHz PL 107.2;BCARES;Region A Healthcare' onclick='putInGroupInput(this);'>'BCARES' ---> Region A Healthcare</a>
<a href='#26;Youth Net;146.880MHz PL 107.2;W0AU;WARRENSBURG AREA ARC' onclick='putInGroupInput(this);'>'W0AU' ---> WARRENSBURG AREA ARC</a>
<a href='#27;Weekly 40 Meter Voice;40 Meters;KC0NWS;Kansas City National Weather Service' onclick='putInGroupInput(this);'>'KC0NWS' ---> Kansas City National Weather Service</a>
<a href='#28;NWS Weekly HF;40 Meters;WX9LOT;Chicago National Weather Service' onclick='putInGroupInput(this);'>'WX9LOT' ---> Chicago National Weather Service</a>
<a href='#29;;146.940MHz;HAWK100;Hawk Hundred' onclick='putInGroupInput(this);'>'HAWK100' ---> Hawk Hundred</a>
<a href='#30;NWS Weekly HF;Multiple Bands;NWS;National Weather Service' onclick='putInGroupInput(this);'>'NWS' ---> National Weather Service</a>
<a href='#' onclick='putInGroupInput(this);'>'EVENT' ---> Event</a>
<a href='#32;Bike Ride;147.030MHz+88.5Hz;LBR;Lonestar Bike Ride' onclick='putInGroupInput(this);'>'LBR' ---> Lonestar Bike Ride</a>
<a href='#33;Cider Mill Ride;147.330Mhz, No Tone;CMBR;Cider Mill Ride' onclick='putInGroupInput(this);'>'CMBR' ---> Cider Mill Ride</a>
<a href='#39;Weekly 2 Meter Voice;145.150MHz PL100.0;CCARC;Clay Center Amateur Radio Club' onclick='putInGroupInput(this);'>'CCARC' ---> Clay Center Amateur Radio Club</a>
<a href='#40;Weekly 2 Meter Voice;147.255MHz PL88.5;MAARS;Manhattan Area Amateur Radio Society' onclick='putInGroupInput(this);'>'MAARS' ---> Manhattan Area Amateur Radio Society</a>
<a href='#41;Liberty Hospital Half Marathon;444.550Mhz(+) PL100.0Hz;LHHM;Liberty Hospital Half Marathon' onclick='putInGroupInput(this);'>'LHHM' ---> Liberty Hospital Half Marathon</a>
<a href='#47;Weekly 2 Meter Voice;147.210Mhz Pl 100Hz;W0KCK;Wyandotte County Races' onclick='putInGroupInput(this);'>'W0KCK' ---> Wyandotte County Races</a>
<a href='#48;Weather;146.700(-) PL-107.2Hz;KC0SKY;SkyWarn' onclick='putInGroupInput(this);'>'KC0SKY' ---> SkyWarn</a>
<a href='#50;Weekly 2 Meter Voice;146.820MHz PL 151.4;JCARES;Jackson County ARES' onclick='putInGroupInput(this);'>'JCARES' ---> Jackson County ARES</a>
<a href='#52;Weekly 2 Meter Voice;145.210MHz PL 151.4;SCST;Shawnee Citizen's Support Team' onclick='putInGroupInput(this);'>'SCST' ---> Shawnee Citizen's Support Team</a>
<a href='#53;;146.790MHz, PL107.2Hz;WINKC;Triathlon & Duathlon' onclick='putInGroupInput(this);'>'WINKC' ---> Triathlon & Duathlon</a>
<a href='#54;Scouting;Multiple Bands;NA1WJ;World Jamboree' onclick='putInGroupInput(this);'>'NA1WJ' ---> World Jamboree</a>
<a href='#' onclick='putInGroupInput(this);'>'FOW' ---> FRIENDS OF W1HKJ</a>
<a href='#56;Event;145.390MHz PL88.5;BBCR;Buffalo Bill Century Ride' onclick='putInGroupInput(this);'>'BBCR' ---> Buffalo Bill Century Ride</a>
<a href='#57;Weekly 2 Meter Voice;147.210Mhz Pl 100Hz;W0BU;Twin Cities Repeater Club' onclick='putInGroupInput(this);'>'W0BU' ---> Twin Cities Repeater Club</a>
<a href='#58;Weekly ARES Training Net;146.670-  pl 131.8;WE4EOC;Hall County Georgia ARES' onclick='putInGroupInput(this);'>'WE4EOC' ---> Hall County Georgia ARES</a>
<a href='#59;Weekly ARES Training Net;147.150+ (tone 141.3 Hz, tsql. 141.3 Hz);WB4GQX;Forsyth County ARES' onclick='putInGroupInput(this);'>'WB4GQX' ---> Forsyth County ARES</a>
<a href='#60;Weekly Net;80/40 Meters;MODES;Missouri Digital Emergency Service' onclick='putInGroupInput(this);'>'MODES' ---> Missouri Digital Emergency Service</a>
<a href='#61;Weekly 2 Meter Voice;;KE0POU;ARES Of North IA' onclick='putInGroupInput(this);'>'KE0POU' ---> ARES Of North IA</a>
<a href='#62;ARES;147.150(+) PL141.3;KJ6OUG;Fresno County EmComm' onclick='putInGroupInput(this);'>'KJ6OUG' ---> Fresno County EmComm</a>
<a href='#64;Weekly;145.25000;W4GG;Guilford Triad Rag Chew Net' onclick='putInGroupInput(this);'>'W4GG' ---> Guilford Triad Rag Chew Net</a>
<a href='#65;Meeting;Eyeball;KCMESH;Amateure Radio Emergency Data Network' onclick='putInGroupInput(this);'>'KCMESH' ---> Amateure Radio Emergency Data Network</a>
<a href='#67;Monthly 2M Checkin;145.210MHz PL 151.4;SFD-CST;Shawnee FD CST' onclick='putInGroupInput(this);'>'SFD-CST' ---> Shawnee FD CST</a>
<a href='#69;Weekly Net;145.2500 T88.5;W4GG;GUILFORD AMATEUR SOCIETY' onclick='putInGroupInput(this);'>'W4GG' ---> GUILFORD AMATEUR SOCIETY</a>
<a href='#70;Daily;145.290MHz, T151.4Hz;JCVBC;Virtual Breakfast Club' onclick='putInGroupInput(this);'>'JCVBC' ---> Virtual Breakfast Club</a>
<a href='#72;NBARC NET;147.330Mhz, PL 107.2;K4NBR;North Brevard ARC ' onclick='putInGroupInput(this);'>'K4NBR' ---> North Brevard ARC </a>
<a href='#73;Weekly;145.130MHz, T151.4;WCFNN;Weekly Casual Friday Night Net' onclick='putInGroupInput(this);'>'WCFNN' ---> Weekly Casual Friday Night Net</a>
<a href='#75;ARES;146.670- PL131.8;WX4GMA;Georgia ARES Welfare D-STAR Net' onclick='putInGroupInput(this);'>'WX4GMA' ---> Georgia ARES Welfare D-STAR Net</a>
<a href='#76;ARES;147.135 Mhz , T107.2;K4EOC;Brevard County, FL. ARES' onclick='putInGroupInput(this);'>'K4EOC' ---> Brevard County, FL. ARES</a>
<a href='#77;Weekly 70cm Voice;444.800+ T151.4 FM;JARA;Jarbalo Amateur Radio Association' onclick='putInGroupInput(this);'>'JARA' ---> Jarbalo Amateur Radio Association</a>
<a href='#78;Weekly 2 Meter Voice;147.360, PL107.2Hz;W8VM;West Park Radiops' onclick='putInGroupInput(this);'>'W8VM' ---> West Park Radiops</a>
<a href='#80;Weekly 2 Meter Voice;147.000 MHz T151.4 Hz FM;PKARC;Pilot Knob Amateur Radio Club' onclick='putInGroupInput(this);'>'PKARC' ---> Pilot Knob Amateur Radio Club</a>
<a href='#81;Check-in Net;146.610(-) no tone;PCARS;PCARS' onclick='putInGroupInput(this);'>'PCARS' ---> PCARS</a>
<a href='#82;ARES;146.835MHz, T100.0Hz;LCGA;Lumpkin County GA ARES' onclick='putInGroupInput(this);'>'LCGA' ---> Lumpkin County GA ARES</a>
<a href='#83;2 Meter Digital;147.390MHz, 114.8Hz;W8WKY;Silvercreek Amateur Radio Association' onclick='putInGroupInput(this);'>'W8WKY' ---> Silvercreek Amateur Radio Association</a>
<a href='#84;Check-in Net;146.700(-), PL 123.0;BVS ERT;Bear Valley Springs Emergency Radio Team' onclick='putInGroupInput(this);'>'BVS ERT' ---> Bear Valley Springs Emergency Radio Team</a>
<a href='#85;Weekly 2 Meter Voice;147.000Mhz;LCAITN;Leavenworth County ARES Information & Training Net' onclick='putInGroupInput(this);'>'LCAITN' ---> Leavenworth County ARES Information & Training Net</a>
<a href='#86;Weekly Net;147.345(+),T107.2;AF0S;Pikes Peak Radio Amateur Association' onclick='putInGroupInput(this);'>'AF0S' ---> Pikes Peak Radio Amateur Association</a>
<a href='#87;MARS Traffic Net;75 Meters; 0TX;Region 10 MARS' onclick='putInGroupInput(this);'>' 0TX' ---> Region 10 MARS</a>
<a href='#88;EMERGENCY;147.16(+),T88.5Hz;W7ZA;GHARC SET PARTICIPANTS' onclick='putInGroupInput(this);'>'W7ZA' ---> GHARC SET PARTICIPANTS</a>
<a href='#89;EMERGENCY;147.16(+),T88.5Hz;W7ZA;W7ZA' onclick='putInGroupInput(this);'>'W7ZA' ---> W7ZA</a>
<a href='#90;Weekly;147.18;K6YRC;Yucaipa Valley Amateur Radio Club' onclick='putInGroupInput(this);'>'K6YRC' ---> Yucaipa Valley Amateur Radio Club</a>
<a href='#91;Hurricane;80/40 Meters;WB4RHQ;ARRL Delta Division ARES' onclick='putInGroupInput(this);'>'WB4RHQ' ---> ARRL Delta Division ARES</a>
<a href='#93;MARS Traffic Net;Multiple Bands;0TX1/0TX2;10th Wing USAF MARS' onclick='putInGroupInput(this);'>'0TX1/0TX2' ---> 10th Wing USAF MARS</a>
<a href='#94;Daily;Multiple Bands;W7ARA;Arizona 2100 Net' onclick='putInGroupInput(this);'>'W7ARA' ---> Arizona 2100 Net</a>
<a href='#95;Check-in Net;146.560;CFN;Caughron Family Net' onclick='putInGroupInput(this);'>'CFN' ---> Caughron Family Net</a>
<a href='#96;Event;145.370Mhz T100Hz;GCARA;Gratiot County Amateur Radio Association' onclick='putInGroupInput(this);'>'GCARA' ---> Gratiot County Amateur Radio Association</a>
<a href='#97;Weekly;146.850 (-) T100 Hz;W0NH;Missouri Valley Amateur Radio Club' onclick='putInGroupInput(this);'>'W0NH' ---> Missouri Valley Amateur Radio Club</a>
<a href='#98;Weekly ARES Net;146.76(-) T88.5;DGARES;Douglas County KS ARES' onclick='putInGroupInput(this);'>'DGARES' ---> Douglas County KS ARES</a>
<a href='#99;Weekly Net;146.490 +1.00 131.8;W3TWA;Tamaqua Wireless Association' onclick='putInGroupInput(this);'>'W3TWA' ---> Tamaqua Wireless Association</a>
<a href='#100;Elmer Net;145.170MHz PL 151.4;K0GQ;Elmer Net' onclick='putInGroupInput(this);'>'K0GQ' ---> Elmer Net</a>
<a href='#101;ARES;Multiple Bands;GAARES;Georgia State ARES' onclick='putInGroupInput(this);'>'GAARES' ---> Georgia State ARES</a>
<a href='#103;ARES;146.655+ 192.8;K4GCA;Grant County Amateur Radio Emergency Services' onclick='putInGroupInput(this);'>'K4GCA' ---> Grant County Amateur Radio Emergency Services</a>
<a href='#104;Meeting;145.270Mhz(-)T100.0Hz;CARS;Cherokee Amateur Radio Society' onclick='putInGroupInput(this);'>'CARS' ---> Cherokee Amateur Radio Society</a>
<a href='#105;BCAT - ARES NET;147.135 + PL 107.2 TSQL;N4TDX;Amateur Radio Emergency Services Of Brevard' onclick='putInGroupInput(this);'>'N4TDX' ---> Amateur Radio Emergency Services Of Brevard</a>
<a href='#106;VE Testing;Eyeball;N0JJA;KCNARES ARRL VE Testing' onclick='putInGroupInput(this);'>'N0JJA' ---> KCNARES ARRL VE Testing</a>
<a href='#107;Meeting;Eyeball;MO-KAN;MO-KAN Regional Council Of Amateur Radio Organizations' onclick='putInGroupInput(this);'>'MO-KAN' ---> MO-KAN Regional Council Of Amateur Radio Organizations</a>
<a href='#108;Weekly 70cm Voice;444.625;AD9L;Iroquois County Amateur Radio Club' onclick='putInGroupInput(this);'>'AD9L' ---> Iroquois County Amateur Radio Club</a>
<a href='#109;Georgia AUXCOM Net;60 meters;WX4GMA;Georgia AUXCOMM' onclick='putInGroupInput(this);'>'WX4GMA' ---> Georgia AUXCOMM</a>
<a href='#110;ARES;147.180(+) 74.4;KY9ACS;Kentucky District 9 ARES' onclick='putInGroupInput(this);'>'KY9ACS' ---> Kentucky District 9 ARES</a>
<a href='#111;Weather;Multiple Bands;KY9ACS;Cumberland Valley KY VOIP Weather Net' onclick='putInGroupInput(this);'>'KY9ACS' ---> Cumberland Valley KY VOIP Weather Net</a>
<a href='#112;Weekly CERT Net;442.800;W4ELC;Eastlake CERT' onclick='putInGroupInput(this);'>'W4ELC' ---> Eastlake CERT</a>
<a href='#113;Auxcom Analog 2m;145.370 Mhz -600 KHz PL 103.5;HCA;Humboldt County AuxCom' onclick='putInGroupInput(this);'>'HCA' ---> Humboldt County AuxCom</a>
<a href='#114;2 Meter Weekly;145,430(-) No Tone;SPARC;Sparta Amateur Radio Club' onclick='putInGroupInput(this);'>'SPARC' ---> Sparta Amateur Radio Club</a>
<a href='#115;ARES;147.270;W7DEM;Carson City ARES' onclick='putInGroupInput(this);'>'W7DEM' ---> Carson City ARES</a>
<a href='#117;2 Meter Weekly;145.470Mhz (-) ,Tone 100.0Hz;K5FRC;Fannin County Amateur Radio Club' onclick='putInGroupInput(this);'>'K5FRC' ---> Fannin County Amateur Radio Club</a>
<a href='#118;Weekly ARES Net;146.610 (-) PL 123;MCFLARES;Marion County (FL) ARES' onclick='putInGroupInput(this);'>'MCFLARES' ---> Marion County (FL) ARES</a>
<a href='#119;2 Meter Weekly;146.76(-) T88.5;K5WCO;West Central OK ARC' onclick='putInGroupInput(this);'>'K5WCO' ---> West Central OK ARC</a>
<a href='#120;Meeting;7075MHz, LSB;RSK5Z4;Radio Society Of Kenya' onclick='putInGroupInput(this);'>'RSK5Z4' ---> Radio Society Of Kenya</a>
<a href='#121;ARES;442.750 Mhz T100;DCARES;Davidson County ARES' onclick='putInGroupInput(this);'>'DCARES' ---> Davidson County ARES</a>
<a href='#122;ARES;442.750 Mhz T100;DCARES;Davidson County ARES' onclick='putInGroupInput(this);'>'DCARES' ---> Davidson County ARES</a>
<a href='#123;Weekly 70cm Voice;443.725Mhz,T123Hz;K1EWE;EWEphoria Radio Club' onclick='putInGroupInput(this);'>'K1EWE' ---> EWEphoria Radio Club</a>
<a href='#124;Weekly 2 Meter Voice;146.760MHz, PL88.5;WCOARC;West Central OK Amateur Radio Club' onclick='putInGroupInput(this);'>'WCOARC' ---> West Central OK Amateur Radio Club</a>
<a href='#125;Monthly 2m And 70cm RACES Nets;Multiple Bands;W2SOM;Somerset County, NJ RACES' onclick='putInGroupInput(this);'>'W2SOM' ---> Somerset County, NJ RACES</a>
<a href='#126;2 Meter Weekly;Echolink W7JCR-R;W7JCR;Jefferson County ARES VECOM WA' onclick='putInGroupInput(this);'>'W7JCR' ---> Jefferson County ARES VECOM WA</a>
<a href='#127;VABCH ARES / PST;146.895 (-) T141.3;VABCH-ARES;Virginia Beach ARES / PST Team' onclick='putInGroupInput(this);'>'VABCH-ARES' ---> Virginia Beach ARES / PST Team</a>
<a href='#128;2 Meter Weekly;146.91 (-) T 107.2;W5GWD;Desoto COunty Training & Information Net' onclick='putInGroupInput(this);'>'W5GWD' ---> Desoto COunty Training & Information Net</a>
<a href='#' onclick='putInGroupInput(this);'>'SCKA' ---> South Central Kansas ARES</a>
<a href='#131;2 Meter Weekly;146.760 MHz, T100Hz;W3UU;Harrisburg Radio Amateurs Club' onclick='putInGroupInput(this);'>'W3UU' ---> Harrisburg Radio Amateurs Club</a>
<a href='#132;Weekly 70 Cm Traffic Net;449.000 MHz Tone 136.5;EMCOMMRUM;EMCOMM RUM' onclick='putInGroupInput(this);'>'EMCOMMRUM' ---> EMCOMM RUM</a>
<a href='#133;Weekly 70cm Voice;444.275MHz + PL 151.4;KF0FPF;Liberty Emergency Radio Club' onclick='putInGroupInput(this);'>'KF0FPF' ---> Liberty Emergency Radio Club</a>
<a href='#134;ARES;146.610 (-) MHz PL 127.3;WX0BC;BCARES' onclick='putInGroupInput(this);'>'WX0BC' ---> BCARES</a>
<a href='#135;Weekly 70 Cm Traffic Net;444.625 MHz;AD9L;Iroquois County Amateur Radio Club' onclick='putInGroupInput(this);'>'AD9L' ---> Iroquois County Amateur Radio Club</a>
<a href='#137;Weekly ARES Training Net;145.330 (-) 151.4 Hz FM;KS-LV-ARES;Leavenworth County KS ARES' onclick='putInGroupInput(this);'>'KS-LV-ARES' ---> Leavenworth County KS ARES</a>
<a href='#139;Event;3598 USB;JFK50;JFK50 Comms By W3CWC' onclick='putInGroupInput(this);'>'JFK50' ---> JFK50 Comms By W3CWC</a>
<a href='#140;Echolink;Echolink Conference Server;*K6FN*;Our Coffee Shop' onclick='putInGroupInput(this);'>'*K6FN*' ---> Our Coffee Shop</a>
<a href='#141;ARES;147.075(-) No PL;W0EOC;Region 22 ARES Group' onclick='putInGroupInput(this);'>'W0EOC' ---> Region 22 ARES Group</a>
<a href='#142;2 Meter Weekly;145.310MHz,T131.8Hz;W3SGJ;Beaver Valley Amateur Radio Association' onclick='putInGroupInput(this);'>'W3SGJ' ---> Beaver Valley Amateur Radio Association</a>
<a href='#143;Meeting;Conference Call;ATGP;AT Golden Packet' onclick='putInGroupInput(this);'>'ATGP' ---> AT Golden Packet</a>
<a href='#144;ARES;147.075(+) No pl / 147.00(-)pl 103.5;W0EOC;Region 22 ARES Group' onclick='putInGroupInput(this);'>'W0EOC' ---> Region 22 ARES Group</a>
<a href='#145;Weekly ARES Net;147.345 Mhz PL 156.7;LCARESNV7LC;Lyon County ARES' onclick='putInGroupInput(this);'>'LCARESNV7LC' ---> Lyon County ARES</a>
<a href='#146;Monthly 2M Checkin;145.210MHz PL 151.4;KC1CST;Shawnee FD CST' onclick='putInGroupInput(this);'>'KC1CST' ---> Shawnee FD CST</a>
<a href='#147;ARES;145.110 PL 85.4;HCSA;Horry County SC ARES' onclick='putInGroupInput(this);'>'HCSA' ---> Horry County SC ARES</a>
<a href='#148;Weekly 70cm Voice;440.725(+) 114.8;AA7MI;MIARC' onclick='putInGroupInput(this);'>'AA7MI' ---> MIARC</a>
<a href='#149;Weekly 70cm Voice;440.725(+) 114.8;AA7MI;MIARC' onclick='putInGroupInput(this);'>'AA7MI' ---> MIARC</a>
<a href='#150;Ragchew;147.030, PL 179.9;SPARK;Sedalia Pettis Amateur Radio Klub' onclick='putInGroupInput(this);'>'SPARK' ---> Sedalia Pettis Amateur Radio Klub</a>
<a href='#151;2 Meter Weekly;145.17Mhz(-), PL 127.3Hz;N2TY;Troy Amateur Radio Association' onclick='putInGroupInput(this);'>'N2TY' ---> Troy Amateur Radio Association</a>
<a href='#152;ARES;146.760(-) No Tone;K0KKV NEARES ;Eastern Nebraska 2 Meter ARES Net ' onclick='putInGroupInput(this);'>'K0KKV NEARES ' ---> Eastern Nebraska 2 Meter ARES Net </a>
<a href='#153;ARES;146.895 (-) T-141.3;VABCH ARES;Virginia Beach ARES Net' onclick='putInGroupInput(this);'>'VABCH ARES' ---> Virginia Beach ARES Net</a>
<a href='#154;2 Meter Weekly;147.000Mhz;KC0KWD;Weld Amateur Radio Society' onclick='putInGroupInput(this);'>'KC0KWD' ---> Weld Amateur Radio Society</a>
<a href='#155;Traffic;3963Mhz LSB;MTN;Missouri Traffic Net' onclick='putInGroupInput(this);'>'MTN' ---> Missouri Traffic Net</a>
<a href='#156;Check-in Net;146.700Mhz,T107.2Hz;LSGARC;Lees Summit Greenwood Amateur Radio Club' onclick='putInGroupInput(this);'>'LSGARC' ---> Lees Summit Greenwood Amateur Radio Club</a>
<a href='#157;Tahoe Rim Trail 100 Mi Back Country Runs;146.94 PL123;KR7COM;Tahoe Rim Trail' onclick='putInGroupInput(this);'>'KR7COM' ---> Tahoe Rim Trail</a>
<a href='#158;Check-in Net;147.090 + pl tone 131.8;WB4GNA;Calhoun County Amateur Radio Association' onclick='putInGroupInput(this);'>'WB4GNA' ---> Calhoun County Amateur Radio Association</a>
<a href='#159;Baldwin County ARC;147.090 + 82.5;N4MZ;Baldwin County Amateur Radio Club' onclick='putInGroupInput(this);'>'N4MZ' ---> Baldwin County Amateur Radio Club</a>
<a href='#160;Check-in Net;146.780 - pl tone 100;WX4CAL;Calhoun County ARES' onclick='putInGroupInput(this);'>'WX4CAL' ---> Calhoun County ARES</a>
<a href='#161;Kansas AuxComm Net;Multiple Bands;KANAUXCNET;Kansas AuxComm Net' onclick='putInGroupInput(this);'>'KANAUXCNET' ---> Kansas AuxComm Net</a>
<a href='#162;Bike Ride;147.120+, PL151.4;SBBT2022;Summer Breeze Bicycle Tour' onclick='putInGroupInput(this);'>'SBBT2022' ---> Summer Breeze Bicycle Tour</a>
<a href='#163;Weekly ARES Net;147.015 +   Tone 100Hz;W4EVC;Etowah Valley Amateur Radio Club' onclick='putInGroupInput(this);'>'W4EVC' ---> Etowah Valley Amateur Radio Club</a>
<a href='#164;Weekly;147.030(+), T100.0Hz 444.700(+), T94.8Hz;W6BXN;W6BXN - Turlock Amateur Radio Club' onclick='putInGroupInput(this);'>'W6BXN' ---> W6BXN - Turlock Amateur Radio Club</a>
<a href='#165;Weekly;W7ZA Repeater System;W7ZA;Grays Harbor Amateur Radio Club' onclick='putInGroupInput(this);'>'W7ZA' ---> Grays Harbor Amateur Radio Club</a>
<a href='#166;Weekly 2meter Net;2 meters;WCARPSC;Wayne County Amateur Radio Public Service Corp' onclick='putInGroupInput(this);'>'WCARPSC' ---> Wayne County Amateur Radio Public Service Corp</a>
<a href='#167;Weekly Net;462.625(+),T141.3;SRAGS;Seatac Repeater Assoc. GMRS Social' onclick='putInGroupInput(this);'>'SRAGS' ---> Seatac Repeater Assoc. GMRS Social</a>
<a href='#168;Event;462.625(+), Tx141.3, Rx141.3;PNWGS;Pacific NorthWest GMRS Socialites' onclick='putInGroupInput(this);'>'PNWGS' ---> Pacific NorthWest GMRS Socialites</a>
<a href='#172;Aachen Netz;145.325 MHZ Simplex / 145.425 MHz Simplex;DL0EI-N;Notfunk Distrikt G' onclick='putInGroupInput(this);'>'DL0EI-N' ---> Notfunk Distrikt G</a>
<a href='#173;Aachen Leitstelle;433.500 MHz  430.200 MHz  60 Meter Winlink Vara;DL0EI-L;Notfunk Distrikt G' onclick='putInGroupInput(this);'>'DL0EI-L' ---> Notfunk Distrikt G</a>
<a href='#174;Weekly;448.84 MHz, T131.8;W6PCH;Los Angeles Amateur Radio Club' onclick='putInGroupInput(this);'>'W6PCH' ---> Los Angeles Amateur Radio Club</a>
<a href='#175;Weekly;443.850Mhz,T110.9Hz;NCTC;North Central Texas Connection' onclick='putInGroupInput(this);'>'NCTC' ---> North Central Texas Connection</a>
<a href='#176;ARES;Stateline Linked Repeater System;STATELINEARES;Stateline ARES' onclick='putInGroupInput(this);'>'STATELINEARES' ---> Stateline ARES</a>
<a href='#177;ARES;Stateline Linked Repeater System;STATELINEARES;Stateline ARES' onclick='putInGroupInput(this);'>'STATELINEARES' ---> Stateline ARES</a>
<a href='#178;2 Meter Weekly;146.390 MHz(-), T123Hz, ECHOLink 818372, WIRESx 85;WV DISTRICT 6;WV District 6 ARES/RACES' onclick='putInGroupInput(this);'>'WV DISTRICT 6' ---> WV District 6 ARES/RACES</a>
<a href='#179;Weekly ARES Net;147.030(+), T100.0Hz 444.700(+), T94.8Hz;MCA;Merced County ARES' onclick='putInGroupInput(this);'>'MCA' ---> Merced County ARES</a>
<a href='#' onclick='putInGroupInput(this);'>'MCA' ---> Merced County ARES</a>
<a href='#181;Digital Training;7.099MHz, USB;MODTN;MO HF Digital Training Net' onclick='putInGroupInput(this);'>'MODTN' ---> MO HF Digital Training Net</a>
<a href='#182;ARES;147.030(+), T100.0Hz 444.700(+), T94.8Hz;MCA;Merced County ARES' onclick='putInGroupInput(this);'>'MCA' ---> Merced County ARES</a>
<a href='#183;Daily @ Noon;462.575 MHz, D000;RUGGED575;Rugged575' onclick='putInGroupInput(this);'>'RUGGED575' ---> Rugged575</a>
<a href='#184;2 Meter Weekly;146.70 Mhz T107.2;LSGARC;LSGARC' onclick='putInGroupInput(this);'>'LSGARC' ---> LSGARC</a>
<a href='#185;HF;3.950 MHz LSB;BARC;Bishop Amateur Radio Club' onclick='putInGroupInput(this);'>'BARC' ---> Bishop Amateur Radio Club</a>
<a href='#186;ARES;145.370;KN4EM;Jefferson County Amateur Radio Emergency Services' onclick='putInGroupInput(this);'>'KN4EM' ---> Jefferson County Amateur Radio Emergency Services</a>
<a href='#187;Weekly 2meter Net;147.090 + pl tone 131.8;WB4GNA-GGN;CCARA Golden Gabbers Net' onclick='putInGroupInput(this);'>'WB4GNA-GGN' ---> CCARA Golden Gabbers Net</a>
<a href='#188;SkyWarn;147.195 + 114.8;WX9RLT;Northern IL Skywarn' onclick='putInGroupInput(this);'>'WX9RLT' ---> Northern IL Skywarn</a>
<a href='#189;2 Meter Weekly;147.090 + pl tone 131.8;CCARAGGN;CCARA Golden Gabbers Net In Calhoun County AL' onclick='putInGroupInput(this);'>'CCARAGGN' ---> CCARA Golden Gabbers Net In Calhoun County AL</a>
<a href='#' onclick='putInGroupInput(this);'>'ARHAB' ---> Amateur Radio High Altitude Ballooning</a>
<a href='#191;ARES;145.210Mhz, 118.8Hz;USRA;Upper Savannah River ARES' onclick='putInGroupInput(this);'>'USRA' ---> Upper Savannah River ARES</a>
<a href='#192;2 Meter Weekly;147.165MHz+ PL 127.3Hz;W9WK;Milwaukee/Waukesha Co. ARES/RACES' onclick='putInGroupInput(this);'>'W9WK' ---> Milwaukee/Waukesha Co. ARES/RACES</a>
<a href='#193;Lunch Gathering;GMRS Band;LUNCHMUNCH;LunchMunch' onclick='putInGroupInput(this);'>'LUNCHMUNCH' ---> LunchMunch</a>
<a href='#194;2 Meter Weekly;147.240 T 141.3;KD0QQU;FCARES' onclick='putInGroupInput(this);'>'KD0QQU' ---> FCARES</a>
<a href='#195;2 Meter Weekly;146.67 PL 131.8;W8ZPF;CRES ARC' onclick='putInGroupInput(this);'>'W8ZPF' ---> CRES ARC</a>
<a href='#196;ARES;147.165MHZ(+), 127.3Hz;SALINE COUNTY A;Saline County ARES' onclick='putInGroupInput(this);'>'SALINE COUNTY A' ---> Saline County ARES</a>
<a href='#197;Weekly;146.940MHz;K0TSA;Western Division SATERN' onclick='putInGroupInput(this);'>'K0TSA' ---> Western Division SATERN</a>
    <!-- Created in buildThreeDropdowns.php -->
            
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
        
 <a href='#14;2 Meter Digital' onclick='putInKindInput(this);'>2 Meter Digital</a>
<a href='#114;2 Meter Weekly' onclick='putInKindInput(this);'>2 Meter Weekly</a>
<a href='#12;6 Meter Weekly' onclick='putInKindInput(this);'>6 Meter Weekly</a>
<a href='#15;70cm Digital' onclick='putInKindInput(this);'>70cm Digital</a>
<a href='#173;Aachen Leitstelle' onclick='putInKindInput(this);'>Aachen Leitstelle</a>
<a href='#172;Aachen Netz' onclick='putInKindInput(this);'>Aachen Netz</a>
<a href='#9;ARES' onclick='putInKindInput(this);'>ARES</a>
<a href='#113;Auxcom Analog 2m' onclick='putInKindInput(this);'>Auxcom Analog 2m</a>
<a href='#159;Baldwin County ARC' onclick='putInKindInput(this);'>Baldwin County ARC</a>
<a href='#105;BCAT - ARES NET' onclick='putInKindInput(this);'>BCAT - ARES NET</a>
<a href='#32;Bike Ride' onclick='putInKindInput(this);'>Bike Ride</a>
<a href='#81;Check-in Net' onclick='putInKindInput(this);'>Check-in Net</a>
<a href='#33;Cider Mill Ride' onclick='putInKindInput(this);'>Cider Mill Ride</a>
<a href='#162;Cycling Kansas City' onclick='putInKindInput(this);'>Cycling Kansas City</a>
<a href='#70;Daily' onclick='putInKindInput(this);'>Daily</a>
<a href='#31;Daily @ Noon' onclick='putInKindInput(this);'>Daily @ Noon</a>
<a href='#4;Digital' onclick='putInKindInput(this);'>Digital</a>
<a href='#21;Digital Training' onclick='putInKindInput(this);'>Digital Training</a>
<a href='#1;DMR' onclick='putInKindInput(this);'>DMR</a>
<a href='#20;Echolink' onclick='putInKindInput(this);'>Echolink</a>
<a href='#140;Echolink' onclick='putInKindInput(this);'>Echolink</a>
<a href='#100;Elmer Net' onclick='putInKindInput(this);'>Elmer Net</a>
<a href='#11;EMERGENCY' onclick='putInKindInput(this);'>EMERGENCY</a>
<a href='#23;Event' onclick='putInKindInput(this);'>Event</a>
<a href='#51;FACILITY' onclick='putInKindInput(this);'>FACILITY</a>
<a href='#22;Field Day' onclick='putInKindInput(this);'>Field Day</a>
<a href='#28;Fusion' onclick='putInKindInput(this);'>Fusion</a>
<a href='#109;Georgia AUXCOM Net' onclick='putInKindInput(this);'>Georgia AUXCOM Net</a>
<a href='#13;HF' onclick='putInKindInput(this);'>HF</a>
<a href='#75;Hurricane' onclick='putInKindInput(this);'>Hurricane</a>
<a href='#161;Kansas AuxComm Net' onclick='putInKindInput(this);'>Kansas AuxComm Net</a>
<a href='#7;KC Metro ARES Digital Training' onclick='putInKindInput(this);'>KC Metro ARES Digital Training</a>
<a href='#41;Liberty Hospital Half Marathon' onclick='putInKindInput(this);'>Liberty Hospital Half Marathon</a>
<a href='#193;Lunch Gathering' onclick='putInKindInput(this);'>Lunch Gathering</a>
<a href='#87;MARS Traffic Net' onclick='putInKindInput(this);'>MARS Traffic Net</a>
<a href='#10;Meeting' onclick='putInKindInput(this);'>Meeting</a>
<a href='#18;Missouri' onclick='putInKindInput(this);'>Missouri</a>
<a href='#125;Monthly 2m And 70cm RACES Nets' onclick='putInKindInput(this);'>Monthly 2m And 70cm RACES Nets</a>
<a href='#67;Monthly 2M Checkin' onclick='putInKindInput(this);'>Monthly 2M Checkin</a>
<a href='#72;NBARC NET' onclick='putInKindInput(this);'>NBARC NET</a>
<a href='#30;NWS Weekly HF' onclick='putInKindInput(this);'>NWS Weekly HF</a>
<a href='#40;Phone' onclick='putInKindInput(this);'>Phone</a>
<a href='#150;Ragchew' onclick='putInKindInput(this);'>Ragchew</a>
<a href='#54;Scouting' onclick='putInKindInput(this);'>Scouting</a>
<a href='#16;Search & Rescue' onclick='putInKindInput(this);'>Search & Rescue</a>
<a href='#5;SET Exercise ' onclick='putInKindInput(this);'>SET Exercise </a>
<a href='#17;Simplex' onclick='putInKindInput(this);'>Simplex</a>
<a href='#76;SkyWarn' onclick='putInKindInput(this);'>SkyWarn</a>
<a href='#157;Tahoe Rim Trail 100 Mi Back Country Runs' onclick='putInKindInput(this);'>Tahoe Rim Trail 100 Mi Back Country Runs</a>
<a href='#8;Test' onclick='putInKindInput(this);'>Test</a>
<a href='#155;Traffic' onclick='putInKindInput(this);'>Traffic</a>
<a href='#127;VABCH ARES / PST' onclick='putInKindInput(this);'>VABCH ARES / PST</a>
<a href='#106;VE Testing' onclick='putInKindInput(this);'>VE Testing</a>
<a href='#3;Weather' onclick='putInKindInput(this);'>Weather</a>
<a href='#48;Weather' onclick='putInKindInput(this);'>Weather</a>
<a href='#24;Weekly' onclick='putInKindInput(this);'>Weekly</a>
<a href='#37;Weekly 1.25 Meter' onclick='putInKindInput(this);'>Weekly 1.25 Meter</a>
<a href='#34;Weekly 2 Meter Simplex' onclick='putInKindInput(this);'>Weekly 2 Meter Simplex</a>
<a href='#2;Weekly 2 Meter Voice' onclick='putInKindInput(this);'>Weekly 2 Meter Voice</a>
<a href='#166;Weekly 2meter Net' onclick='putInKindInput(this);'>Weekly 2meter Net</a>
<a href='#27;Weekly 40 Meter Voice' onclick='putInKindInput(this);'>Weekly 40 Meter Voice</a>
<a href='#132;Weekly 70 Cm Traffic Net' onclick='putInKindInput(this);'>Weekly 70 Cm Traffic Net</a>
<a href='#6;Weekly 70cm Voice' onclick='putInKindInput(this);'>Weekly 70cm Voice</a>
<a href='#36;Weekly 80 Meter CW' onclick='putInKindInput(this);'>Weekly 80 Meter CW</a>
<a href='#19;Weekly 80 Meter Voice' onclick='putInKindInput(this);'>Weekly 80 Meter Voice</a>
<a href='#98;Weekly ARES Net' onclick='putInKindInput(this);'>Weekly ARES Net</a>
<a href='#179;Weekly ARES Net' onclick='putInKindInput(this);'>Weekly ARES Net</a>
<a href='#58;Weekly ARES Training Net' onclick='putInKindInput(this);'>Weekly ARES Training Net</a>
<a href='#112;Weekly CERT Net' onclick='putInKindInput(this);'>Weekly CERT Net</a>
<a href='#25;Weekly Fusion' onclick='putInKindInput(this);'>Weekly Fusion</a>
<a href='#60;Weekly Net' onclick='putInKindInput(this);'>Weekly Net</a>
<a href='#26;Youth Net' onclick='putInKindInput(this);'>Youth Net</a>
    <!-- Created in buildThreeDropdowns.php -->
       
    </div> <!-- End KindDropdown -->
    </div> <!-- End KindDropdown-content -->
            
    <!-- ==== FREQ ======= -->  
    <div><b style="color:red">*</b>Select the Frequency:</div>
    <div id="FreqDropdown" >
        <!-- showFreqChoices() & filterFunctions() at the bottom of index.php -->
        <input type="text" onfocus="showFreqChoices(); blurKindChoices(); " placeholder="Type to filter list.." id="FreqInput" 
               class="netGroup" onkeyup="filterFunction(2)"/>
        <div class='FreqDropdown-content hidden'>
            
 <a href='#114;145,430(-) No Tone' onclick='putInFreqInput(this);'>145,430(-) No Tone</a>
<a href='#147;145.110 PL 85.4' onclick='putInFreqInput(this);'>145.110 PL 85.4</a>
<a href='#5;145.130MHz No Tone' onclick='putInFreqInput(this);'>145.130MHz No Tone</a>
<a href='#73;145.130MHz, T151.4' onclick='putInFreqInput(this);'>145.130MHz, T151.4</a>
<a href='#39;145.150MHz PL100.0' onclick='putInFreqInput(this);'>145.150MHz PL100.0</a>
<a href='#100;145.170MHz PL 151.4' onclick='putInFreqInput(this);'>145.170MHz PL 151.4</a>
<a href='#151;145.17Mhz(-), PL 127.3Hz' onclick='putInFreqInput(this);'>145.17Mhz(-), PL 127.3Hz</a>
<a href='#52;145.210MHz PL 151.4' onclick='putInFreqInput(this);'>145.210MHz PL 151.4</a>
<a href='#191;145.210Mhz, 118.8Hz' onclick='putInFreqInput(this);'>145.210Mhz, 118.8Hz</a>
<a href='#69;145.2500 T88.5' onclick='putInFreqInput(this);'>145.2500 T88.5</a>
<a href='#64;145.25000' onclick='putInFreqInput(this);'>145.25000</a>
<a href='#104;145.270Mhz(-)T100.0Hz' onclick='putInFreqInput(this);'>145.270Mhz(-)T100.0Hz</a>
<a href='#34;145.290MHz' onclick='putInFreqInput(this);'>145.290MHz</a>
<a href='#70;145.290MHz, T151.4Hz' onclick='putInFreqInput(this);'>145.290MHz, T151.4Hz</a>
<a href='#28;145.310(-) No Tone' onclick='putInFreqInput(this);'>145.310(-) No Tone</a>
<a href='#142;145.310MHz,T131.8Hz' onclick='putInFreqInput(this);'>145.310MHz,T131.8Hz</a>
<a href='#172;145.325 MHZ Simplex / 145.425 MHz Simplex' onclick='putInFreqInput(this);'>145.325 MHZ Simplex / 145.425 MHz Simplex</a>
<a href='#137;145.330 (-) 151.4 Hz FM' onclick='putInFreqInput(this);'>145.330 (-) 151.4 Hz FM</a>
<a href='#186;145.370' onclick='putInFreqInput(this);'>145.370</a>
<a href='#113;145.370 Mhz -600 KHz PL 103.5' onclick='putInFreqInput(this);'>145.370 Mhz -600 KHz PL 103.5</a>
<a href='#96;145.370Mhz T100Hz' onclick='putInFreqInput(this);'>145.370Mhz T100Hz</a>
<a href='#56;145.390MHz PL88.5' onclick='putInFreqInput(this);'>145.390MHz PL88.5</a>
<a href='#117;145.470Mhz (-) ,Tone 100.0Hz' onclick='putInFreqInput(this);'>145.470Mhz (-) ,Tone 100.0Hz</a>
<a href='#26;146.290MHz, PL151.4Hz' onclick='putInFreqInput(this);'>146.290MHz, PL151.4Hz</a>
<a href='#57;146.310Mhz(-) PL151.4' onclick='putInFreqInput(this);'>146.310Mhz(-) PL151.4</a>
<a href='#178;146.390 MHz(-), T123Hz, ECHOLink 818372, WIRESx 85' onclick='putInFreqInput(this);'>146.390 MHz(-), T123Hz, ECHOLink 818372, WIRESx 85</a>
<a href='#36;146.450MHz' onclick='putInFreqInput(this);'>146.450MHz</a>
<a href='#99;146.490 +1.00 131.8' onclick='putInFreqInput(this);'>146.490 +1.00 131.8</a>
<a href='#47;146.500 MHz Simplex' onclick='putInFreqInput(this);'>146.500 MHz Simplex</a>
<a href='#17;146.520MHz, Simplex' onclick='putInFreqInput(this);'>146.520MHz, Simplex</a>
<a href='#95;146.560' onclick='putInFreqInput(this);'>146.560</a>
<a href='#3;146.570MHz, Simplex' onclick='putInFreqInput(this);'>146.570MHz, Simplex</a>
<a href='#51;146.580MHz, Simplex' onclick='putInFreqInput(this);'>146.580MHz, Simplex</a>
<a href='#134;146.610 (-) MHz PL 127.3' onclick='putInFreqInput(this);'>146.610 (-) MHz PL 127.3</a>
<a href='#118;146.610 (-) PL 123' onclick='putInFreqInput(this);'>146.610 (-) PL 123</a>
<a href='#81;146.610(-) no tone' onclick='putInFreqInput(this);'>146.610(-) no tone</a>
<a href='#103;146.655+ 192.8' onclick='putInFreqInput(this);'>146.655+ 192.8</a>
<a href='#19;146.655MHz, PL94.8Hz' onclick='putInFreqInput(this);'>146.655MHz, PL94.8Hz</a>
<a href='#195;146.67 PL 131.8' onclick='putInFreqInput(this);'>146.67 PL 131.8</a>
<a href='#58;146.670-  pl 131.8' onclick='putInFreqInput(this);'>146.670-  pl 131.8</a>
<a href='#75;146.670- PL131.8' onclick='putInFreqInput(this);'>146.670- PL131.8</a>
<a href='#184;146.70 Mhz T107.2' onclick='putInFreqInput(this);'>146.70 Mhz T107.2</a>
<a href='#48;146.700(-) PL-107.2Hz' onclick='putInFreqInput(this);'>146.700(-) PL-107.2Hz</a>
<a href='#84;146.700(-), PL 123.0' onclick='putInFreqInput(this);'>146.700(-), PL 123.0</a>
<a href='#14;146.700MHz, PL123.0Hz' onclick='putInFreqInput(this);'>146.700MHz, PL123.0Hz</a>
<a href='#156;146.700Mhz,T107.2Hz' onclick='putInFreqInput(this);'>146.700Mhz,T107.2Hz</a>
<a href='#98;146.76(-) T88.5' onclick='putInFreqInput(this);'>146.76(-) T88.5</a>
<a href='#130;146.760 MHz, T100Hz' onclick='putInFreqInput(this);'>146.760 MHz, T100Hz</a>
<a href='#152;146.760(-) No Tone' onclick='putInFreqInput(this);'>146.760(-) No Tone</a>
<a href='#124;146.760MHz, PL88.5' onclick='putInFreqInput(this);'>146.760MHz, PL88.5</a>
<a href='#160;146.780 - pl tone 100' onclick='putInFreqInput(this);'>146.780 - pl tone 100</a>
<a href='#2;146.790MHz, PL107.2Hz' onclick='putInFreqInput(this);'>146.790MHz, PL107.2Hz</a>
<a href='#16;146.800MHz, Simplex' onclick='putInFreqInput(this);'>146.800MHz, Simplex</a>
<a href='#50;146.820MHz PL 151.4' onclick='putInFreqInput(this);'>146.820MHz PL 151.4</a>
<a href='#82;146.835MHz, T100.0Hz' onclick='putInFreqInput(this);'>146.835MHz, T100.0Hz</a>
<a href='#97;146.850 (-) T100 Hz' onclick='putInFreqInput(this);'>146.850 (-) T100 Hz</a>
<a href='#41;146.880MHz PL 107.2' onclick='putInFreqInput(this);'>146.880MHz PL 107.2</a>
<a href='#153;146.895 (-) T-141.3' onclick='putInFreqInput(this);'>146.895 (-) T-141.3</a>
<a href='#127;146.895 (-) T141.3' onclick='putInFreqInput(this);'>146.895 (-) T141.3</a>
<a href='#128;146.91 (-) T 107.2' onclick='putInFreqInput(this);'>146.91 (-) T 107.2</a>
<a href='#157;146.94 PL123' onclick='putInFreqInput(this);'>146.94 PL123</a>
<a href='#29;146.940MHz' onclick='putInFreqInput(this);'>146.940MHz</a>
<a href='#31;146.940Mhz(-) PL88.5' onclick='putInFreqInput(this);'>146.940Mhz(-) PL88.5</a>
<a href='#9;146.955MHZ, PL ??' onclick='putInFreqInput(this);'>146.955MHZ, PL ??</a>
<a href='#80;147.000 MHz T151.4 Hz FM' onclick='putInFreqInput(this);'>147.000 MHz T151.4 Hz FM</a>
<a href='#85;147.000Mhz' onclick='putInFreqInput(this);'>147.000Mhz</a>
<a href='#163;147.015 +   Tone 100Hz' onclick='putInFreqInput(this);'>147.015 +   Tone 100Hz</a>
<a href='#150;147.030, PL 179.9' onclick='putInFreqInput(this);'>147.030, PL 179.9</a>
<a href='#164;147.030(+), T100.0Hz 444.700(+), T94.8Hz' onclick='putInFreqInput(this);'>147.030(+), T100.0Hz 444.700(+), T94.8Hz</a>
<a href='#46;147.030MHz+88.5Hz' onclick='putInFreqInput(this);'>147.030MHz+88.5Hz</a>
<a href='#141;147.075(-) No PL' onclick='putInFreqInput(this);'>147.075(-) No PL</a>
<a href='#144;147.075(+) No pl / 147.00(-)pl 103.5' onclick='putInFreqInput(this);'>147.075(+) No pl / 147.00(-)pl 103.5</a>
<a href='#159;147.090 + 82.5' onclick='putInFreqInput(this);'>147.090 + 82.5</a>
<a href='#158;147.090 + pl tone 131.8' onclick='putInFreqInput(this);'>147.090 + pl tone 131.8</a>
<a href='#162;147.120+, PL151.4' onclick='putInFreqInput(this);'>147.120+, PL151.4</a>
<a href='#105;147.135 + PL 107.2 TSQL' onclick='putInFreqInput(this);'>147.135 + PL 107.2 TSQL</a>
<a href='#76;147.135 Mhz , T107.2' onclick='putInFreqInput(this);'>147.135 Mhz , T107.2</a>
<a href='#62;147.150(+) PL141.3' onclick='putInFreqInput(this);'>147.150(+) PL141.3</a>
<a href='#59;147.150+ (tone 141.3 Hz, tsql. 141.3 Hz)' onclick='putInFreqInput(this);'>147.150+ (tone 141.3 Hz, tsql. 141.3 Hz)</a>
<a href='#88;147.16(+),T88.5Hz' onclick='putInFreqInput(this);'>147.16(+),T88.5Hz</a>
<a href='#89;147.16(+),T88.5Hz' onclick='putInFreqInput(this);'>147.16(+),T88.5Hz</a>
<a href='#196;147.165MHZ(+), 127.3Hz' onclick='putInFreqInput(this);'>147.165MHZ(+), 127.3Hz</a>
<a href='#192;147.165MHz+ PL 127.3Hz' onclick='putInFreqInput(this);'>147.165MHz+ PL 127.3Hz</a>
<a href='#90;147.18' onclick='putInFreqInput(this);'>147.18</a>
<a href='#110;147.180(+) 74.4' onclick='putInFreqInput(this);'>147.180(+) 74.4</a>
<a href='#188;147.195 + 114.8' onclick='putInFreqInput(this);'>147.195 + 114.8</a>
<a href='#49;147.210Mhz Pl 100Hz' onclick='putInFreqInput(this);'>147.210Mhz Pl 100Hz</a>
<a href='#22;147.225(+), PL 94.8Hz' onclick='putInFreqInput(this);'>147.225(+), PL 94.8Hz</a>
<a href='#20;147.225(+), PL156.7Hz' onclick='putInFreqInput(this);'>147.225(+), PL156.7Hz</a>
<a href='#194;147.240 T 141.3' onclick='putInFreqInput(this);'>147.240 T 141.3</a>
<a href='#40;147.255MHz PL88.5' onclick='putInFreqInput(this);'>147.255MHz PL88.5</a>
<a href='#115;147.270' onclick='putInFreqInput(this);'>147.270</a>
<a href='#33;147.330Mhz, No Tone' onclick='putInFreqInput(this);'>147.330Mhz, No Tone</a>
<a href='#72;147.330Mhz, PL 107.2' onclick='putInFreqInput(this);'>147.330Mhz, PL 107.2</a>
<a href='#4;147.330MHz, PL151.4Hz' onclick='putInFreqInput(this);'>147.330MHz, PL151.4Hz</a>
<a href='#145;147.345 Mhz PL 156.7' onclick='putInFreqInput(this);'>147.345 Mhz PL 156.7</a>
<a href='#86;147.345(+),T107.2' onclick='putInFreqInput(this);'>147.345(+),T107.2</a>
<a href='#78;147.360, PL107.2Hz' onclick='putInFreqInput(this);'>147.360, PL107.2Hz</a>
<a href='#38;147.375Mhz PL156.7Hz' onclick='putInFreqInput(this);'>147.375Mhz PL156.7Hz</a>
<a href='#83;147.390MHz, 114.8Hz' onclick='putInFreqInput(this);'>147.390MHz, 114.8Hz</a>
<a href='#166;2 meters' onclick='putInFreqInput(this);'>2 meters</a>
<a href='#37;224.900MHz' onclick='putInFreqInput(this);'>224.900MHz</a>
<a href='#18;3.598MHz, USB' onclick='putInFreqInput(this);'>3.598MHz, USB</a>
<a href='#185;3.950 MHz LSB' onclick='putInFreqInput(this);'>3.950 MHz LSB</a>
<a href='#45;3.963MHz LSB' onclick='putInFreqInput(this);'>3.963MHz LSB</a>
<a href='#60;3598 USB' onclick='putInFreqInput(this);'>3598 USB</a>
<a href='#155;3963Mhz LSB' onclick='putInFreqInput(this);'>3963Mhz LSB</a>
<a href='#42;40 Meters' onclick='putInFreqInput(this);'>40 Meters</a>
<a href='#173;433.500 MHz  430.200 MHz  60 Meter Winlink Vara' onclick='putInFreqInput(this);'>433.500 MHz  430.200 MHz  60 Meter Winlink Vara</a>
<a href='#148;440.725(+) 114.8' onclick='putInFreqInput(this);'>440.725(+) 114.8</a>
<a href='#15;441.8125MHz' onclick='putInFreqInput(this);'>441.8125MHz</a>
<a href='#35;442.300MHz' onclick='putInFreqInput(this);'>442.300MHz</a>
<a href='#121;442.750 Mhz T100' onclick='putInFreqInput(this);'>442.750 Mhz T100</a>
<a href='#112;442.800' onclick='putInFreqInput(this);'>442.800</a>
<a href='#111;442.900' onclick='putInFreqInput(this);'>442.900</a>
<a href='#30;443.275 MHz' onclick='putInFreqInput(this);'>443.275 MHz</a>
<a href='#32;443.500 MHz PL151.4Hz' onclick='putInFreqInput(this);'>443.500 MHz PL151.4Hz</a>
<a href='#123;443.725Mhz,T123Hz' onclick='putInFreqInput(this);'>443.725Mhz,T123Hz</a>
<a href='#175;443.850Mhz,T110.9Hz' onclick='putInFreqInput(this);'>443.850Mhz,T110.9Hz</a>
<a href='#6;444.025MHz, PL123.0Hz' onclick='putInFreqInput(this);'>444.025MHz, PL123.0Hz</a>
<a href='#133;444.275MHz + PL 151.4' onclick='putInFreqInput(this);'>444.275MHz + PL 151.4</a>
<a href='#1;444.4625MHz, MCI-ARES' onclick='putInFreqInput(this);'>444.4625MHz, MCI-ARES</a>
<a href='#25;444.550Mhz(+) PL100.0Hz' onclick='putInFreqInput(this);'>444.550Mhz(+) PL100.0Hz</a>
<a href='#108;444.625' onclick='putInFreqInput(this);'>444.625</a>
<a href='#135;444.625 MHz' onclick='putInFreqInput(this);'>444.625 MHz</a>
<a href='#77;444.800+ T151.4 FM' onclick='putInFreqInput(this);'>444.800+ T151.4 FM</a>
<a href='#174;448.84 MHz, T131.8' onclick='putInFreqInput(this);'>448.84 MHz, T131.8</a>
<a href='#132;449.000 MHz Tone 136.5' onclick='putInFreqInput(this);'>449.000 MHz Tone 136.5</a>
<a href='#183;462.575 MHz, D000' onclick='putInFreqInput(this);'>462.575 MHz, D000</a>
<a href='#168;462.625(+), Tx141.3, Rx141.3' onclick='putInFreqInput(this);'>462.625(+), Tx141.3, Rx141.3</a>
<a href='#167;462.625(+),T141.3' onclick='putInFreqInput(this);'>462.625(+),T141.3</a>
<a href='#12;52.790MHz' onclick='putInFreqInput(this);'>52.790MHz</a>
<a href='#109;60 meters' onclick='putInFreqInput(this);'>60 meters</a>
<a href='#13;7.099MHz, USB' onclick='putInFreqInput(this);'>7.099MHz, USB</a>
<a href='#7;7.263MHz Simplex' onclick='putInFreqInput(this);'>7.263MHz Simplex</a>
<a href='#120;7075MHz, LSB' onclick='putInFreqInput(this);'>7075MHz, LSB</a>
<a href='#87;75 Meters' onclick='putInFreqInput(this);'>75 Meters</a>
<a href='#23;80 Meters' onclick='putInFreqInput(this);'>80 Meters</a>
<a href='#11;80/40 Meters' onclick='putInFreqInput(this);'>80/40 Meters</a>
<a href='#24;Conference Call' onclick='putInFreqInput(this);'>Conference Call</a>
<a href='#65;DMR Digital' onclick='putInFreqInput(this);'>DMR Digital</a>
<a href='#140;Echolink Conference Server' onclick='putInFreqInput(this);'>Echolink Conference Server</a>
<a href='#126;Echolink W7JCR-R' onclick='putInFreqInput(this);'>Echolink W7JCR-R</a>
<a href='#10;Eyeball' onclick='putInFreqInput(this);'>Eyeball</a>
<a href='#107;Eyeball' onclick='putInFreqInput(this);'>Eyeball</a>
<a href='#27;Fusion Digital' onclick='putInFreqInput(this);'>Fusion Digital</a>
<a href='#193;GMRS Band' onclick='putInFreqInput(this);'>GMRS Band</a>
<a href='#67;Kansas City Room' onclick='putInFreqInput(this);'>Kansas City Room</a>
<a href='#21;KD0EAV-R' onclick='putInFreqInput(this);'>KD0EAV-R</a>
<a href='#43;Multiple Bands' onclick='putInFreqInput(this);'>Multiple Bands</a>
<a href='#106;Nevada 3132' onclick='putInFreqInput(this);'>Nevada 3132</a>
<a href='#176;Stateline Linked Repeater System' onclick='putInFreqInput(this);'>Stateline Linked Repeater System</a>
<a href='#8;Test' onclick='putInFreqInput(this);'>Test</a>
<a href='#165;W7ZA Repeater System' onclick='putInFreqInput(this);'>W7ZA Repeater System</a>
    <!-- Created in buildThreeDropdowns.php -->
           
        </div> <!-- End FreqDropdown -->
    </div> <!-- End FreqDropdown-content -->
            
    <div class="last3qs">If this is a Sub Net select the<br>open primary net:</div>

    <!-- If any option is selected make the cb1 span (show linked nets) button appear using function showLinkedButton() -->
     <select class="last3qs" id="satNet" title="Sub Net Selections" onfocus="blurFreqChoices(); ">
    	<option value="0" selected>None</option>


<option title='10289' value='10289'>Net #: 10289 -->  Event</option>
<option title='10288' value='10288'>Net #: 10288 --> Fresno County EmComm ARES</option>
<option title='10287' value='10287'>Net #: 10287 --> Calhoun County Amateur Radio Association Check-in Net</option>
<option title='10286' value='10286'>Net #: 10286 --> Ray-Clay Radio Club Weekly 2 Meter Voice</option>
<option title='10285' value='10285'>Net #: 10285 --> Saline County ARES ARES</option>
<option title='10284' value='10284'>Net #: 10284 -->  2 Meter Weekly</option>
<option title='10283' value='10283'>Net #: 10283 --> Calhoun County ARES Check-in Net</option>
<option title='10282' value='10282'>Net #: 10282 --> Carroll County MO. ARES Weekly 2 Meter Voice</option>
<option title='10281' value='10281'>Net #: 10281 -->  AM 80m Test Net</option>
<option title='10280' value='10280'>Net #: 10280 -->  2 Meter Weekly</option>
<option title='10279' value='10279'>Net #: 10279 --> Douglas County KS ARES Weekly ARES Net</option>
<option title='10278' value='10278'>Net #: 10278 --> KCNARES Digital Training</option>
<option title='10277' value='10277'>Net #: 10277 -->  2 Meter Weekly</option>
<option title='10276' value='10276'>Net #: 10276 --> Leavenworth County KS ARES Weekly ARES Training Net</option>
<option title='10275' value='10275'>Net #: 10275 --> Jarbalo Amateur Radio Association Weekly Fusion Training Net</option>
<option title='10274' value='10274'>Net #: 10274 --> North Central Missouri Weekly 2 Meter Voice</option>
<option title='10273' value='10273'>Net #: 10273 --> Ray-Clay Radio Club Weekly 70cm Voice</option>
<option title='10272' value='10272'>Net #: 10272 --> Amateur Radio Emergency Services Of Brevard BCAT - ARES NET</option>
<option title='10271' value='10271'>Net #: 10271 --> Missouri Emergency Services Weekly 40 Meter Voice</option>
<option title='10270' value='10270'>Net #: 10270 --> For Testing Only Test</option>
<option title='10269' value='10269'>Net #: 10269 --> Los Angeles Amateur Radio Club Weekly</option>
 
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
<option disabled style='color:blue; font-weight:bold'>
            --------------- Tuesday ---==========--- 2023-10-31 ----------------------</option>
<option data-net-status="1" value="10289" class="  spcl">
            OTHER, Net #: 10289 -->  Event of 2023-10-31 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Monday ---==========--- 2023/10/30 ----------------------</option>
<option data-net-status="0" value="10288" class="  ">
            KJ6OUG, Net #: 10288 --> Fresno County EmComm ARES For 2023-10-30 21:26:46 </option>
<option data-net-status="1" value="10287" class="  ">
            WB4GNA, Net #: 10287 --> Calhoun County Amateur Radio Association Check-in Net of 2023-10-30 </option>
<option data-net-status="1" value="10286" class="  ">
            K0ESM, Net #: 10286 --> Ray-Clay Radio Club Weekly 2 Meter Voice of 2023-10-30 </option>
<option data-net-status="0" value="10285" class="  ">
            SALINE COUNTY A, Net #: 10285 --> Saline County ARES ARES of 2023-10-30 </option>
<option data-net-status="1" value="10284" class="  ">
            FCARESFRANKLINCOUNTYARES, Net #: 10284 -->  2 Meter Weekly of 2023-10-30 </option>
<option data-net-status="1" value="10283" class="  ">
            WX4CAL, Net #: 10283 --> Calhoun County ARES Check-in Net of 2023-10-30 </option>
<option data-net-status="1" value="10282" class="  ">
            CARROLL, Net #: 10282 --> Carroll County MO. ARES Weekly 2 Meter Voice of 2023-10-30 </option>
<option data-net-status="0" value="10281" class=" green ">
            TM79GOLD, Net #: 10281 -->  AM 80m Test Net of 2023-10-30 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Sunday ---==========--- 2023-10-29 ----------------------</option>
<option data-net-status="1" value="10280" class="  ">
            W0AU, Net #: 10280 -->  2 Meter Weekly of 2023-10-29 </option>
<option data-net-status="1" value="10279" class="  ">
            DGARES, Net #: 10279 --> Douglas County KS ARES Weekly ARES Net of 2023-10-29 </option>
<option data-net-status="1" value="10278" class="  ">
            W0KCN, Net #: 10278 --> KCNARES Digital Training of 2023-10-29 </option>
<option data-net-status="1" value="10277" class="  ">
            W0UK, Net #: 10277 -->  2 Meter Weekly of 2023-10-29 </option>
<option data-net-status="1" value="10276" class="  ">
            KS-LV-ARES, Net #: 10276 --> Leavenworth County KS ARES Weekly ARES Training Net of 2023-10-29 </option>
<option data-net-status="1" value="10275" class="  ">
            JARA, Net #: 10275 --> Jarbalo Amateur Radio Association Weekly Fusion Training Net of 2023-10-29 </option>
<option data-net-status="1" value="10274" class="  ">
            NCMO, Net #: 10274 --> North Central Missouri Weekly 2 Meter Voice of 2023-10-29 </option>
<option data-net-status="1" value="10273" class="  ">
            K0ESM, Net #: 10273 --> Ray-Clay Radio Club Weekly 70cm Voice of 2023-10-29 </option>
<option data-net-status="1" value="10272" class="  ">
            N4TDX, Net #: 10272 --> Amateur Radio Emergency Services Of Brevard BCAT - ARES NET of 2023-10-29 </option>
<option data-net-status="1" value="10271" class="  ">
            MESN, Net #: 10271 --> Missouri Emergency Services Weekly 40 Meter Voice of 2023-10-29 </option>
<option data-net-status="1" value="10270" class="  ">
            TE0ST, Net #: 10270 --> For Testing Only Test of 2023-10-29 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Saturday ---==========--- 2023-10-28 ----------------------</option>
<option data-net-status="1" value="10269" class="  ">
            W6PCH, Net #: 10269 --> Los Angeles Amateur Radio Club Weekly of 2023-10-28 </option>
<option data-net-status="0" value="10268" class=" green ">
            JCARES, Net #: 10268 -->  Weekly Fusion of 2023-10-28 </option>
<option data-net-status="1" value="10267" class="  spcl">
            NR0AD, Net #: 10267 --> PCARG Monthly Meeting of 2023-10-28 </option>
<option data-net-status="1" value="10266" class="  ">
            JCARES, Net #: 10266 -->  2 Meter Weekly of 2023-10-28 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Friday ---==========--- 2023-10-27 ----------------------</option>
<option data-net-status="1" value="10265" class="  ">
            WCFNN, Net #: 10265 --> Weekly Casual Friday Night Net Weekly of 2023-10-27 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Thursday ---==========--- 2023-10-26 ----------------------</option>
<option data-net-status="1" value="10264" class="  ">
            W0NH, Net #: 10264 --> Missouri Valley Amateur Radio Club Weekly of 2023-10-26 </option>
<option data-net-status="0" value="10263" class="  ">
            MADCOARES, Net #: 10263 -->  2 Meter Weekly Training of 2023-10-26 </option>
<option data-net-status="1" value="10262" class="  ">
            KS-LV-ARES, Net #: 10262 --> Leavenworth County KS ARES Weekly ARES Training Net of 2023-10-26 </option>
<option data-net-status="1" value="10260" class="  ">
            SPARC, Net #: 10260 --> Sparta Amateur Radio Club 2 Meter Weekly of 2023-10-26 </option>
<option data-net-status="1" value="10259" class="  ">
            N2TY, Net #: 10259 --> Troy Amateur Radio Association 2 Meter Weekly of 2023-10-26 </option>
<option data-net-status="1" value="10258" class="  spcl">
            W0KCN, Net #: 10258 --> KCNARES Monthly Meeting of 2023-10-26 </option>
<option data-net-status="1" value="10257" class="  ">
            TEOST, Net #: 10257 -->  Test of 2023-10-26 </option>
<option data-net-status="0" value="10256" class=" green ">
            TE0ST, Net #: 10256 -->  teost of 2023-10-26 </option>
<option data-net-status="1" value="10255" class="  ">
            MODES, Net #: 10255 --> Missouri Digital Emergency Service Weekly Digital Net For 2023-10-26 09:59:16 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Wednesday ---==========--- 2023-10-25 ----------------------</option>
<option data-net-status="1" value="10254" class="  ">
            K0EJC, Net #: 10254 --> Eastern Jackson Co. RACES/ECS Weekly 2 Meter Voice of 2023-10-25 </option>
<option data-net-status="1" value="10253" class="  ">
            K0EJC, Net #: 10253 --> Eastern Jackson Co. RACES/ECS Weekly 2 Meter Voice of 2023-10-25 </option>
<option data-net-status="1" value="10252" class="  ">
            JCARES, Net #: 10252 -->  KC Metro ARES Digital Training of 2023-10-25 </option>
<option data-net-status="0" value="10251" class="  ">
            W0EOC, Net #: 10251 --> Region 22 ARES Group ARES For 2023-10-25 19:49:15 </option>
<option data-net-status="1" value="10250" class="  ">
            WE4EOC, Net #: 10250 -->  Weekly ARES Training Net of 2023-10-25 </option>
<option data-net-status="1" value="10249" class="  ">
            HCSC, Net #: 10249 -->  ARES of 2023-10-25 </option>
<option data-net-status="0" value="10248" class=" green ">
            HCSA, Net #: 10248 --> Horry County SC ARES ARES of 2023-10-25 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Tuesday ---==========--- 2023-10-24 ----------------------</option>
<option data-net-status="1" value="10247" class="  ">
            WB4GQX, Net #: 10247 --> Forsyth County ARES Weekly ARES Training Ne of 2023-10-24 </option>
<option data-net-status="1" value="10246" class="  ">
            NR0AD, Net #: 10246 --> PCARG Weekly 2 Meter Voice of 2023-10-24 </option>
<option data-net-status="1" value="10245" class="  ">
            W0KCN, Net #: 10245 --> KCNARES Weekly 2 Meter Voice of 2023-10-24 </option>
<option data-net-status="1" value="10244" class="  ">
            LSGARC, Net #: 10244 --> LSGARC 2 Meter Weekly of 2023-10-24 </option>
<option data-net-status="1" value="10243" class="  ">
            KF0FPF, Net #: 10243 -->  ARES of 2023-10-24 </option>
<option data-net-status="0" value="10242" class=" green ">
            TE0ST, Net #: 10242 --> For Testing Only Test of 2023-10-24 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Monday ---==========--- 2023-10-23 ----------------------</option>
<option data-net-status="1" value="10241" class="  ">
            KJ6OUG, Net #: 10241 --> Fresno County EmComm ARES of 2023-10-23 </option>
<option data-net-status="1" value="10240" class="  ">
            WB4GNA, Net #: 10240 --> Calhoun County Amateur Radio Association Check-in Net of 2023-10-23 </option>
<option data-net-status="1" value="10239" class="  ">
            K0ESM, Net #: 10239 --> Ray-Clay Radio Club Weekly 2 Meter Voice of 2023-10-23 </option>
<option data-net-status="1" value="10238" class="  ">
            WB4GNA, Net #: 10238 --> Calhoun County Amateur Radio Association Check-in Net of 2023-10-23 </option>
<option data-net-status="1" value="10237" class="  ">
            SALINE COUNTY A, Net #: 10237 --> Saline County ARES ARES of 2023-10-23 </option>
<option data-net-status="1" value="10236" class="  ">
            WX4CAL, Net #: 10236 --> Calhoun County ARES Check-in Net of 2023-10-23 </option>
<option data-net-status="1" value="10235" class="  ">
            WX4CAL, Net #: 10235 --> Calhoun County ARES Check-in Net of 2023-10-23 </option>
<option data-net-status="1" value="10234" class="  ">
            CARROLL, Net #: 10234 --> Carroll County MO. ARES Weekly 2 Meter Voice of 2023-10-23 </option>
<option data-net-status="1" value="10233" class="  ">
            USRA, Net #: 10233 --> Upper Savannah River ARES ARES of 2023-10-23 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Sunday ---==========--- 2023-10-22 ----------------------</option>
<option data-net-status="1" value="10232" class="  ">
            DGARES, Net #: 10232 --> Douglas County KS ARES Weekly ARES Net of 2023-10-22 </option>
<option data-net-status="1" value="10231" class="  ">
            W0KCN, Net #: 10231 --> KCNARES Digital Training of 2023-10-22 </option>
<option data-net-status="1" value="10230" class="  ">
            W0UK, Net #: 10230 -->  2 Meter Weekly of 2023-10-22 </option>
<option data-net-status="1" value="10229" class="  ">
            KS-LV-ARES, Net #: 10229 --> Leavenworth County KS ARES Weekly ARES Training Net of 2023-10-22 </option>
<option data-net-status="1" value="10228" class="  ">
            JARA, Net #: 10228 --> Jarbalo Amateur Radio Association Weekly Fusion Training Net of 2023-10-22 </option>
<option data-net-status="1" value="10227" class="  ">
            K0ESM, Net #: 10227 --> Ray-Clay Radio Club Weekly 70cm Voice of 2023-10-22 </option>
<option data-net-status="1" value="10226" class="  ">
            NCMO, Net #: 10226 --> North Central Missouri Weekly 2 Meter Voice of 2023-10-22 </option>
<option data-net-status="1" value="10225" class="  ">
            N4TDX, Net #: 10225 --> Amateur Radio Emergency Services Of Brevard BCAT - ARES NET of 2023-10-22 </option>
<option data-net-status="1" value="10224" class="  ">
            MESN, Net #: 10224 --> Missouri Emergency Services Weekly 40 Meter Voice of 2023-10-22 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Wednesday ---==========--- 2023/10/18 ----------------------</option>
<option data-net-status="0" value="10213" class="  ">
            W0EOC, Net #: 10213 --> Region 22 ARES Group ARES For 2023-10-18 19:57:31 </option>
<option data-net-status="0" value="10212" class=" pbBlue ">
            W0EOC, Net #: 10212 --> Region 22 ARES Group ARES For  </option>
<option data-net-status="0" value="10211" class=" pbBlue ">
            W0EOC, Net #: 10211 --> Region 22 ARES Group ARES For  </option>
<option data-net-status="0" value="10209" class=" pbBlue ">
            WE4EOC, Net #: 10209 --> Hall County Georgia ARES Weekly ARES Training Net For  </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Monday ---==========--- 2023/10/16 ----------------------</option>
<option data-net-status="0" value="10200" class="  ">
            W9WK, Net #: 10200 --> Milwaukee/Waukesha Co. ARES/RACES 2 Meter Weekly For 2023-10-16 20:25:30 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Thursday ---==========--- 2023/10/12 ----------------------</option>
<option data-net-status="1" value="10172" class="  ">
            MODES, Net #: 10172 --> Missouri Digital Emergency Service Weekly Net For 2023-10-12 10:00:21 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Saturday ---==========--- 2023/10/07 ----------------------</option>
<option data-net-status="1" value="10139" class="  ">
            K0USA, Net #: 10139 -->  Market To Market Relay For 2023-10-07 04:09:16 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Sunday ---==========--- 2023/10/08 ----------------------</option>
<option data-net-status="0" value="10138" class=" pbBlue ">
            K0TSA, Net #: 10138 --> Western Division SATERN M2M Relay For 2023-10-08 22:25:25 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Friday ---==========--- 1970/01/01 ----------------------</option>
<option data-net-status="0" value="10137" class="  spcl">
            N0TRK, Net #: 10137 -->   For  </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Thursday ---==========--- 1970/01/01 ----------------------</option>
<option data-net-status="0" value="10131" class=" pbBlue spcl">
            MARKET-TO-MARKET-RELAY, Net #: 10131 -->   For  </option>
<option data-net-status="1" value="10129" class="  ">
            MODES, Net #: 10129 --> Missouri Digital Emergency Service Weekly Net For 2023-10-05 09:51:57 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Wednesday ---==========--- 1970/01/01 ----------------------</option>
<option data-net-status="0" value="10128" class=" pbBlue ">
            K0TSA, Net #: 10128 --> Western Division SATERN Weekly For  </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Thursday ---==========--- 2023/10/05 ----------------------</option>
<option data-net-status="0" value="10127" class=" pbBlue spcl">
            MARKET-TO-MARKET-RELAY, Net #: 10127 -->   For 2023-10-05 16:43:48 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Wednesday ---==========--- 2023/10/04 ----------------------</option>
<option data-net-status="0" value="10124" class="  ">
            W0EOC, Net #: 10124 --> Region 22 ARES Group ARES For 2023-10-04 20:01:13 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Monday ---==========--- 2023/10/02 ----------------------</option>
<option data-net-status="0" value="10109" class="  ">
            W9WK, Net #: 10109 --> Milwaukee/Waukesha Co. ARES/RACES 2 Meter Weekly For 2023-10-02 20:26:44 </option>
<option data-net-status="1" value="10105" class="  ">
            PMC/KCHEART, Net #: 10105 -->  Monthly Test For 2023-10-02 11:38:07 </option>
<option data-net-status="1" value="10104" class="  ">
            KS-LV-ARES, Net #: 10104 --> Leavenworth County KS ARES Exercise 2023 SET For  </option>
<option data-net-status="1" value="10103" class="  ">
            SHARC-SAINTJOHNAMATEURRADIOCLUB, Net #: 10103 -->  Monthly Test For 2023-10-02 18:59:01 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Thursday ---==========--- 2023/09/28 ----------------------</option>
<option data-net-status="1" value="10078" class="  ">
            MODES, Net #: 10078 --> Missouri Digital Emergency Service Weekly Net For 2023-09-28 09:59:04 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Wednesday ---==========--- 2023/09/27 ----------------------</option>
<option data-net-status="0" value="10073" class="  ">
            W0EOC, Net #: 10073 --> Region 22 ARES Group ARES For 2023-09-27 20:01:08 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Monday ---==========--- 2023/09/25 ----------------------</option>
<option data-net-status="1" value="10054" class="  ">
            SALINE COUNTY A, Net #: 10054 --> Saline County ARES ARES For 2023-09-25 19:26:00 </option>
<option data-net-status="1" value="10049" class="  ">
            MCA, Net #: 10049 --> Merced County ARES Weekly ARES Net For 2023-09-25 17:11:30 </option>
<option disabled style='color:blue; font-weight:bold'>
            --------------- Pre-Built Net(s) For: Sunday ---==========--- 1970/01/01 ----------------------</option>
<option data-net-status="0" value="10047" class=" pbBlue ">
            K0TSA, Net #: 10047 -->  Market To Market Relay For  </option>
        	
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
        <h2 class='quotes'>
				    As of Today: <br>  704 Groups, <br> 9184 Unique Stations, <br> 9495 Nets, <br> 148,179 Logins <br>
				    <img src='https://fontmeme.com/permalink/210514/469ac0e73fe5e79d55c4c332c794fa07.png' alt='K'></h2>-->
     <!-- All the quotes end here -->
	
<!-- ************************  JAVASCRIPT LIBRARIES  ******************************************** -->	
	
    <!-- jquery updated from 3.4.1 to 3.5.1 on 2020-09-10 3.5.1 to 3.6.0 on 2022-06-04-->
    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<script src="bootstrap/js/bootstrap.min.js"></script>		    <!-- v3.3.2 --> 
 
	<script src="js/jquery.freezeheader.js"></script>				<!-- v1.0.7 -->
	<script src="js/jquery.simpleTab.min.js"></script>				<!-- v1.0.0 2018-1-18 -->
	
	<!-- jquery-modal updated from 0.9.1 to 0.9.2 on 2019-11-14 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script> 

	<script src="bootstrap/js/bootstrap-select.min.js"></script>				<!-- v1.12.4 2018-1-18 -->
	<script src="bootstrap/js/bootstrap-multiselect.js"></script>				<!-- 2.0 2018-1-18 -->

    <!-- http://www.appelsiini.net/projects/jeditable -->
    <script src="js/jquery.jeditable.js"></script>							    <!-- 1.8.1 2018-04-05 -->

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


</script>

</body>
</html>