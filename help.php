<!doctype html>
<?php 
	require_once "NCMStats.php";			
?>

<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167869985-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167869985-1');
</script>
    <title>Amateur Radio Net Control Manager Instructions and Help</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Amateur Radio Net Control Manager Help" >
    <meta name="author" content="Keith Kaiser, WA0TJT" >
    <meta name="Rating" content="General" >
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager" >
    <meta name="robots" content="index" > 
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/help.css" />
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="css/bubbles.css">

<style>
	/* see help.css and print.css */
	.boxTZ{
		width: 80%;
		position: relative;
		display: inline-block; /* Make the width of box same as image */
	}
	.boxTZ .text{
		position: absolute;
		z-index: 999;
		margin: 0 auto;
		left: 65;
	/*	right: 0; */
		top: 25%; /* Adjust this value to move the positioned div up and down */
		/*text-align: center;*/
		width: 80%; /* Set the width of the positioned div */
		color: darkred;
	}
	
	.topBanner {
    	width: 960px;
    	position: relative;
    	margin:0 auto;
    	line-height: 1.4em;
	}
	
	
	
</style>
	
<script>
	function printfunction() {
		window.print();
	}

</script>
    
</head>
<body>
	
<div id="banner">

	<div class="title">
		<p>Net	</p>
		<p>Control  <span style="float: right;">Documentation &amp; Help</span></p>
		<p>Manager</p>
	</div> <!-- End title -->
	
	<div class="flex-container1">
		<div>
			<a href="https://net-control.us">Open Net Control Manager</a>
			<br>
			<a href="https://net-control.us/hamnets.html" target="_blank"> What is a Ham Net?</a>

		</div>
		<div class="topBanner">
			<?php
				echo "As of Today: -->   $netcall Groups, $cscount Unique Stations, $netCnt Nets, $records Logins,
					 <br> $volHours of Volunteer Time<br>Across: 4 Countries, $stateCnt states, $countyCnt counties and $gridCnt grid squares.";
			?>
		</div>
		<div>
			<button style=" color:#4706f8; font-size: larger" onclick="printfunction()">Print this document</button>
			<br>
			<script>document.write("<b style='right: 0;'> Updated: " + document.lastModified +"</b>");</script>
		</div>
	</div> <!-- end flex-container -->
</div> <!-- End Banner -->

<hr>

<div class="index"> <!-- Changed from div on 2019-10-01 -->
	<a id="index"></a>
	<h3>Index</h3>
	
	 <nav class="topics">
		<a href="#assumptions">Assumptions</a><br>
        <a href="#newStuff">Recent Changes</a><br>
		<a href="#homepage">Home Page</a><br>
		<a href="#open">Open an existing Net</a><br>
		<a href="#start">Start a Net</a><br>
		<a href="#rightCorner">Upper right Corner</a><br>
		<a href="#reports">Create Agenda, Preamble, Closing</a><br>
		<a href="#checkins">Enter Check-Ins</a><br>
		<a href="#delete">Delete an Entry</a><br>
		<a href="#misc">Misc. Operations</a><br>
		<a href="#colors">Meaning of the Display Colors</a><br>
		<a href="#columns">Table Columns</a><br>
		<a href="#checkins">Check-in</a><br> 
		<a href="#grid">Updating Grid, Latitude and/or Longitude</a><br>	 
        <a href="#what3words">What3Words</a><br>
		<a href="#misc">About Sorting</a><br>
		<a href="#reports">Reports</a><br>
		<a href="#advanced">Advanced Topics</a><br>
		<a href="#advanced"><b style='color:red'>*</b> Adding General Comments to the Time Log</a><br>
		<a href="#advanced">Using Sub-nets</a><br>
		<a href="#TimeLineLog">How The Time Log Works</a><br>
		<a href="#APRStt">What is <b style="color:#aa7941;">APRStt</b>?</a><br>
		
		<a href="#prebuild">Pre-Build nets for Events</a><br>
		<a href="#Mapping"><b style='color:red'>*</b> Mapping your Net</a><br>
		<a href="#Responsive">Responsive Design</a><br>	 
		<a href="#mars">MARS Operation</a><br>
		<a href="#theend">Copyright, Guarantees and Warranties</a>
	 </nav>
	 <br>
	 <b style='color:red'>*</b> <a href="#newStuff">Recent updates.</a>
</div> <!-- End index -->
	
<hr>
	
<div class="Purpose">
    <h2>Purpose:</h2>
	
	<p>The Net Control Manager (<span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span>) program was designed to make Amateur Radio Net check-ins, management of net resources and net reporting easier and more efficient than using pen and paper. <b>This is not meant however to be a replacement for pen and paper,</b>  which will always be your best backup should something go wrong.
	</p><p> The <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> is designed to make <b style="color:red;">ARES</b>, <b style="color:darkblue;">RACES</b> and other <b style="color:darkred;">EM</b> net logging and reporting as easy and intuitive as possible. But of course works perfectly with your weekly club social net as well. Its many features are aimed squarely at these ideas.
	</p>
	<p><span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> was also designed to be easily usable by the Net Control Operator (<b style="color:green;">NCO</b>) alone, however someone else keeping log while you control the net is always a good idea. I suggest you keep it open on your computer as you call the net. Set the timed refresh to 5 or 10 seconds. If the NCO is also the logger, do NOT set a timed refresh value.
	</p>
	<p>Using <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> like any application of this type should be practiced. Go ahead and create a TE0ST net from the drop down. Add stations, delete stations, sort columns, edit fields, do all the things you would do during a real net. Then when you are complete be sure to close your net. This net will stick around for a while so come back and play with it more, re-open the net (right click the <b style="color:red">'Net Closed'</b> button) add some more calls, etc.
	</p>
	<!-- -->
	<div class="classictemplate template" style="display: block;">
<style type="text/css">
  #groupsio_embed_signup input {border:1px solid #999; -webkit-appearance:none;}
  #groupsio_embed_signup label {display:block; font-size:16px; padding-bottom:10px; font-weight:bold;}
  #groupsio_embed_signup .email {display:block; padding:8px 0; margin:0 4% 10px 0; text-indent:5px; width:58%; min-width:130px;}
  #groupsio_embed_signup {
    background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; 
  }
  #groupsio_embed_signup .button {

      width:25%; margin:0 0 10px 0; min-width:90px;
      background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);
      background-repeat: repeat-x;
      border-color: #245580;
      text-shadow: 0 -1px 0 rgba(0,0,0,.2);
      box-shadow: inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);
      padding: 5px 10px;
      font-size: 12px;
      line-height: 1.5;
      border-radius: 3px;
      color: #fff;
      background-color: #337ab7;
      display: inline-block;
      margin-bottom: 0;
      font-weight: 400;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
    }
</style>
<div id="groupsio_embed_signup">
<form action="https://groups.io/g/NCM/signup?u=5681121157766229570" method="post" id="groupsio-embedded-subscribe-form" name="groupsio-embedded-subscribe-form" target="_blank">
    <div id="groupsio_embed_signup_scroll">
      <label for="email" id="templateformtitle">Subscribe to our group</label>
      <input type="email" value="" name="email" class="email" id="email" placeholder="email address" required="">
    
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5681121157766229570" tabindex="-1" value=""></div>
    <div id="templatearchives"></div>
    <input type="submit" value="Subscribe" name="subscribe" id="groupsio-embedded-subscribe" class="button">
  </div>
</form>
</div>
</div>
	
	
	<!-- -->
</div>	<!-- End Purpose -->

<hr>

<div class="os">
<!-- The margin:0 makes these two >h> tags push together -->
<P style="page-break-before: always">
<h2 style="margin:0;">OS and Browser Considerations for <b><span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span></b>: </h2>
<h5 style="margin:0;">(basically a modern browser is required)</h5>
<div class="flex-container2">
	<div>
		<u>Good</u> <br> Edge
	</div>
	<div>
		<u>Better</u> <br> Safari
	</div>
	<div>
		<u>Best</u> <br> Chrome
	</div>
	<div>
		<u>Usually</u> <br> Firefox
	</div>
</div>
<div style="font-size:18pt; font-weight: bold; color:red;">*Turn on popups for <b><span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span></b></div>
<p>Popups... <b><span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span></b> works best with popups enabled in your browser. Many features require popups to display additional information. There are NO, None, Zero, Zip ads in this application and never will be.</p>
		
<p>Cookies... I don't like them. But in some circumstances (which you as a general user may never see) <b><span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span></b> does set a cookie. Even then its voluntary via a button that says <b style="color:red">"Save as Cookie"</b>. If you never see that button, then a cookie will never be set, if you see it then the choice is yours. Despite what you may have heard, cookies are safe, very small text items added to your computer to assist with web pages. If you choose to see only the County and State optional fields that cookie would only have 5 bytes and would look like this (17,18).</p>
</div> <!-- End OS -->

<hr>

<div class="abbreviations">
<h2 style="margin:0;">Some abbreviations you might wonder about:</h2>
<div class="twocolrow" style="margin:0; width: 100%;">
  <div class="twocolumn" style="width: 50%;">
	<b><span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span></b> - Net Control Manager<br>
	<b style="color:blue;"><abbr title="Net Control Station">NCS</b></abbr> - Net Control Station (PRM)<br>
	<b style="color:green;">NCO</b> - Net Control Operator<br>
	<b style="color:#aa7941;">EOC</b> - Emergency Operations Center<br>
	
    <b style="color:red;">ARES</b> - Amateur Radio Emergency Service<br>
    <b style="color:darkblue;">RACES</b> - Radio Amateur Civil Emergency Service<br>
   
	<b style="color:black;">CERT</b> - Community Emergency Response Team<br>
	<b style="color:#aa7941;">NWS</b> - National Weather Service<br>	
	<b style="color:#aa7941;">ICS</b> - Incident Command Structure<br>
	<b style="color:#aa7941;">SATERN</b> - Salvation Army Team Emergency Radio Network<br>
	
  </div>
  <div class="twocolumn" style="width: 50%;">
    <b style="color:#aa7941;">APRS</b> - Automatic Packet (Position) Reporting System<br>
	<b style="color:#aa7941;">APRSC</b> - Amateur Radio Public Service Corps<br>
	
	<b style="color:#aa7941;">NTS</b> - National Traffic System<br>
<!--	<b style="color:black;">CERT</b> - Community Emergency Response Team<br> -->
	<b style="color:#aa7941;">SkyWarn</b> - Weather Nets<br>
	
	<b style="color:#aa7941;">DTMF</b> - Dual Tone Multi Frequency (touch tones)<br>
	<b style="color:#aa7941;">APRStt</b> - APRS via DTMF tones<br>
	
	<b style="color:darkred;">EM</b> - Emergency Management<br>
	<b style="color:#aa7941;">FCC</b> - Federal Communications Commission<br>
	
	<b style="color:#aa7941;">MARS</b> - Military Auxiliary Radio system<br>
	<b style="color:#aa7941;">W3W</b> - What3Words
  </div>
</div>
</div> <!-- end abbreviations os -->

<hr>

<div class="assumptions">
	<a id="assumptions"></a>
	<h3>Assumptions:</h3>
	
	<p>For any new net created most columns are filled by values that come from one of two places. Most values are picked up from the 'stations' table. Others default to values based on the FCC data base. The FCC data base is only queried the first time a station logs in, just that once. All other default values are from the stations table of the NCM data base.
	<ul>
		<li>All times are stored as universal time (UTC or GMT). You are able to select the local time zone for display purposes.</li>
		<li>County, State, District, Latitude, logitude and gird: at the beginning of any net will always default to the stations home address. </li>
<!--		<li>County, State and District: will always default to the last edited value on the last net they logged into.</li> -->
		<li>Call sign, First and Last Name, phone number, email address, and Credentials are all stored for the open net only. When changed they will NOT be retained for future nets.</li>
		<li></li>
	</ul>
</div> <!-- End of assumptions -->

 
<div class="changes" style="page-break-before: always">
    <a id="newStuff"></a>
	<h3>Recent Changes:</h3>
	
	    <header>
    	    <p>August 2021 </p>
    	    <p>A few small changes were made to the display of objects in a map. A link to the What3Words location map and an APRS local activity report hi-light these changes.</p>
    	    <p>May 2021 </p>
    	    <p>When creating a test (TE0ST) net please check the box at the top of the new net creation dialog.</p>
    	    <p>New report in the 'Reports' menu called 'The Usual Suspects' creates a list of all stations over time that have checked into the requested net. You must know the group code or callsign to produce this.
    	    </p>
    	    <p>The ICS-309 report has been modified to report only the entries regarding message traffic. Such as W3W object creation or any traffic documentation.
    	    </p>
    	    <p>April 2021 </p>
    	    <p>In response to a debate on the APRS.io email board about the best way to mark the locations of downed telephone poles I've added to mapping a net the ability to do just that. You do not need APRS to do it, all you need is your smart phone and a free app that works offline, no internet needed. </p>
    	    <p>Using the <a href="https://what3words.com/clip.apples.leap" target="_blank">What3Words</a> app locate the location, call it into your net control station, she/he adds it to the NCM column with a comment suggesting what it is. </p>
    	    <p>For example an entry might look like this   'spinach.spaceship.scouts Green Door' (no quotes) What happens in NCM is this; the latitude and longitude of the report is added to the time line log each time a new entry is made. The cross roads (preferred by first responders) is displayed, with the grid square and of course the latitude and longitude. Then when you display the net map, all the extra objects are shown, they are clickable with all the details. </p>
    	    <p> The URL of this map can be given to first responders to use for their attention.<br>
        	    see <a href="https://net-control.us/map.php?NetID=3818" target="_blank"> https://net-control.us/map.php?NetID=3818</a> for an example.
    	    </p>
    	    <br>
    	    <p>February 2021 </p>
    	    <p>Short Cut after the name field for entering check-ins with traffic:<br>This does require an extra tab after an entry without traffic. TAB TAB TAB to enter a call.</p>
    	    <p> This little box helps the logger keep his/her hands on the keyboard while taking check-ins. Your options for entry are T,R,W,P,E,Q,A or C, they represent the action values of the Traffic column. R --> Routine, W --> Welfare, P --> Priority, E --> Emergency, Q --> Question, A --> Announcement, C --> Comment. <br> By entering one of these in that little box the Traffic column for that station will automatically be updated to reflect the value. Be sure to use the dropdown in Traffic to indicate 'Sent' after the traffic is passed.
    	    </p>
    	    <p>January 2021</p>
    	    <p>Right click functionality on the Status column added to speed up change to 'In' or 'OUT'. </p>
    	    <p><a href="#misc">Export to a CSV file</a></p>
    	    <p>Right click functionality added to 'Time Line Comments' column to display station activity for this net.</p>
	    </header>
	    <p>
	    </p>

	    			
</div> <!-- End changes -->

<hr>

<div class="helpfulhints">
    <a id="helpfulhints"></a>
		
		<h3>Quick Start Notes:</h3>
	 
		<p>Reload your screen (page reload): The blue <b style="color:blue">'refresh'</b> 
		button only does a content refresh not a page reload. <b style="color:red;">
			Be sure you have recently reloaded your entire screen if you can't find something or if something doesn't seem to work correctly.</b></p>
		<p>Before starting a new net, be sure someone hasn't already started it. Check the dropdown for a green (open) or blue (pre-built) net.</p>
		
		 <div class="nofirstletter">
    		 
    		 <div class="redimportant">
                <p> If you are monitoring the net, set your refresh to a "Timed" number of seconds.</p>
            	<p> If you are net control and NOT keeping the log, set your refresh to 5 seconds.</p>
            	<p> If you are the logger but NOT net control leave the default (Manual).</p>
            	<p> If you are both leave the default (Refresh or Manual).</p>
        	</div>
  
    	</div>
    	
    	<p>Entering Station call signs (There are a number of possible ways to do this.) All entries can be done with a <b style="color:red">TAB TAB TAB (triple tab)</b> after entering a call sign only. It's never necessary to enter a name for a valid callsign.</p>
		
		<p>If your group is not yet in the dropdown list when creating a new net, choose the hamburger menu in the upper right corner and select 'Create a new Group' from the dropdown. You can build your new group here. Be sure to refresh the page before trying to open a new net using your new group.</p>
		<p>For smaller screens learn to use the Windows commands 'Control +' and 'Control -' or Mac commands 'Command +' and 'Command -' to fit the content to your monitor.</p>
		
		<p>Nets marked with "Net Closed" can not be edited. You must re-open it first.  </p>
		<p>To enter a line break (carridge return) to the 'Comments' field put <b>&lt;br&gt;</b> or simply space twice where you want the break. Then continue to type. Do not use the return on your keyboard. All simple HTML markups are available to use.</p>
		<p>Entering NON-Hams into the system. To do this use the call sign <b style="color:red">NONHAM</b> and put both the first name and last name (if you have them) into the 'Name' box. The system will make an appropriate entry.</p>
		
		<p>Late Check-Ins (after log is closed). The best thing to do is enter them as an 'In-Out' in the 'Status' column. This will assign a one-minute value to TOD. But more importantly it will allow your log to close properly.</p>
		<p>Duplicate calls are not allowed and will be ignored by the system. However if you have chosen 'Multiple Bands' or '80/40 Meters' as  your frequency while building the net, they will be allowed. Its hoped you will indicate which band they checked in from using the 'Band' column. The 'Band' column will be automatically added if you choose one of the above frequencies.</p>
		
		<p style="font-weight: bold;">Have fun!</p>
		
		<p>If you have an idea how to improve Net Control Manager, please send them to <a href="mailto:wa0tjt@gmail.com?Subject=Net-Control-Program" target="_top"> Keith Kaiser</a> my eMail address is wa0tjt@gmail.com</p>
		
</div> <!-- End helpfulhints -->
	
<hr>

<div class="homepage">
	<a id="homepage"></a>
	<h3>Home Page</h3>
	
<!--	<div class="flexcontainer"> -->
		<div class="boxTZ" >
			<img  src="screenshots/opening_page.png" alt="existing" width="800" />
			<!--<div class="text">Choose the Local or UTC timezone</div> -->
		</div>
	<div class="TZdescription" style="padding-left: 20px;">
	 <p>
		This is the first page you see when opening Net Control Manager.
		<br><br>
		Notice the green T button next to 'Preamble', click it to toggle help bubbles.
		<br><br>The version number here is 6.05.03 representing the sixth year of NCM the 5th month, modified on the 03rd.
	</p>

	</div>
<!--	</div>. --> 
	
	<br>
	<a class="gotoindex" href="#index">Back to the Index</a><br><br>
	</div> <!-- End homepage -->
<hr>

<div class="homepage">
	<a id="homepage"></a>
	<h3>A Populated Home Page</h3>
	
<!--	<div class="flexcontainer"> -->
		<div class="boxTZ" >
			<img  src="screenshots/AnOpenNetExample.png" alt="existing" width="800" />

		</div>
	<div style="padding-left: 20px;">
	 <p>
		A closed net open for viewing. Notice the extra columns like; tactical, credentials and tt#. Several more are available as well, by using the orange 'Show/Hide Columns' button.
		<br><br>Notice the "Refresh", "Timed" and "'NetClosed" buttons, the MODES ==> ... Closed under the button bar and that all Time Out values are present.
		<br><br>The Local timezone is selected and the upper right corner is populated with net information. Create your own by selecting the 'Create a Group Profile' under the hamburger menu next to 'Help'.
	</p>

	</div>
<!--	</div> -->
	
	<br>
	<a class="gotoindex" href="#index">Back to the Index</a><br><br>
	</div> <!-- End homepage -->
<hr>
<div class="openanet">
    <a id="open"></a>
    <h3>HOW TO OPEN AN EXISTING NET</h3>

<div class="flexcontainer">
	<div style="width: 80%;">
<img  src="screenshots/existingNets.png" alt="existing" width="600"  />
	</div>
<div style="padding-left: 20px;">
 <p>
	Before clicking the <b style="color:red">'Start A New Net'</b> button check to see that someone else has not already started the net for you. To do this, 
		</p>
			<p>Reload your web page</p>
			<p> Then check the dropdown list for the net, the open ones are in green.</p>

		<p>The net should open.</p>
		<p>A net with a green background (second one in this example) is an open net (it's still in use).</p>
		<p>A net with a blue background (not shown in this example) is a pre-built net. See below for more information.</p>
		<p>Nets for the past 10 days will be listed by day of week and date of that net.</p>
</div>
</div>
<br>
<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End openanet -->

<hr>
	
<div class="startanet">
	
<a id="start"></a>
<h3>START A NET</h3>

<div class="flexcontainer">
	<div style="width: 40%;">
<img style="float:left; padding-right: 10px; border-radius: 10px;" src="screenshots/startnewnet.png" alt="startnewnet" width="341" height="615" />
<img style="float:left; padding-right: 10px; border-radius: 10px;" src="screenshots/startnewnetTest.png" alt="startnewnet" width="341" height="615" />
	</div>
	<div style="padding-left: 20px;">
 <p>
	Before clicking the <b style="color:red">'Start A New Net'</b> button check to see that someone else has not already started the net for you. To do this, 
		</p>
			<p>Reload your web page</p>
			<p> Then check the dropdown list for the net, open nets are in green.<br>Pre-built and Roll Call nets are in blue.</p>
			<p> If not already created then...</p>

		<p>Click the blue <b style="color:red">'Start A New Net'</b> Button at the top of the page.</p>
		
		<p style="color:blue;">Be sure click the "test net" select box at the top if you are creating a TEST net.</p>

	
	   <p><b>Enter your call sign</b> in the top most box, this is your personal call sign, issued by the FCC NOT the club call sign.</p>
	   <p>Select the club call sign or name from the next dropdown box, or type your own into the box.<br>This can be a short name like 'SUMMER' (no quotes) or descriptive like 'My Birthday'.</p>
	   <p>Select the type of net. If you created your own (above) then consider choosing EVENT or Test here.<br> Otherwise select from the dropdown.</p>
	   <p>If not already showing, select a frequency from the next dropdown box. As above you can also type in your own frequency. DO NOT PUT a colon (:) anywhere in this box.</p>
	   
	   <p>If the net you are creating is meant to be associated with another net (making this a sub-net), the next dropdown has a list of the all the possible parent net selections. </p>
	   
	   <p>Click 'Click to create a Pre-Build Event' if you are pre building a net for a future event. <br>
          See: <a href="#prebuild">Pre-Build nets for Events</a> for more details. 
	   </p>
       <hr>
    	
    	<p>Click on <b style="color:red">Submit</b>.</p>
	
	   <p>At this point a new net page should be displayed, listing you as having opened it.</p>
	</div>
</div>

<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End startanet -->

<hr>

<div class="rightCorner">
<a id="rightCorner"></a>
<h3>Upper Right Corner</h3>

    <div class="flexcontainer">
    	<div style="width: 40%;">	
        	<b style="color:blue;">Default:	</b><br>
        	<img src="screenshots/upperRightCorner-default.png" alt="upperRightCorner-default" width="90%">
        	<br><br>
        	<b style="color:blue;">Open Net:</b><br>
    	    <img src="screenshots/upper-right-corner.png" alt="upperRightCorner" width="400" style="vertical-align:middle">
    	</div>
    		  <div style="padding-left: 20px;"> 
    			  <p>This information panel in the upper corner contains repeater and simplex frequencies and other information relevant to the group of the net that is currently open. By clicking the hamburger menu icon (three bars) an option menu will be displayed. Choose what part of this menu you want to change, create a new group, or display this document.</p> 
    			  <p>The <b style='color:red;'>New</b> is used to edit or create Preamble, Agendas and Closing documents.</p>
    			  <p>Each of the Preamble, Agendas and Closing documents can be individually edited from there individual displays.</p>
    			  <p>Notice the small green button, left of the Preamble. Click this to display positioned tips to help navigate the page.</p>
    			  <p>See the section on <a href="#reports"> reports</a> below for information about the reports menu.</p>
    		  </div> <!-- end style -->
    </div> <!-- end class flexcontainer -->
</div> <!-- end class rightCorner -->

<hr>

<div class="checkins">
<a id="checkins"></a>
<h3>ENTERING CHECK-INs  <button style="left:50px;" class="tipsbutton" title="Tips Button"> Tips!</button><br>
    (Button Bar) </h3>


<p class=" HelpBubbles initiallyHidden" style="">Short Cut Entry for Traffic</p>

<img src="screenshots/purpleBanner.png" alt="purpleBanner" width="1100"  />
<br>
<img src="screenshots/redBanner.png" alt="redBanner" width="1100"  />

	
	<p>The background color of this menu bar will change from <b style="color:#c992d3">purple</b> to <b style="color:red">red</b> over the course of 10 minutes. Use this as a visual reminder to do a station identification.</p>
	<p>Entering Station call signs (There are a number of possible ways to do this.) All entries can be done with a <b style="color:red">TAB TAB TAB (triple tab)</b> after entering a partial or full call sign only.</p>
	
	<p>1) Type the call sign  (or any portion of it) and wait for the hints to reveal the correct station. Then single click or arrow down on that station followed by <b style="color:red">TAB TAB TAB (triple tab)</b>. It will populate the call, the name and other fields into the appropriate locations. If it is an unknown call you MUST click <b style="color:green">Check In</b>.</p>
	
	
	<p style="font-weight: bold;">2) Perhaps the best way is to enter the call sign then tab three times. The system will automatically enter the names, and additional information. If it can't find it in our DB already it will go to the <b style="color:#aa7941;">FCC</b> data base and pull the needed information. If the call sign can not be found in the <b style="color:#aa7941;">FCC</b> DB a comment is entered and both the call sign and comment will be highlighted in a yellow color.
	</p>
	
	 <p style="color:blue;">As a short cut to entering check-ins with traffic a new smaller input field (box) has been added to the button banner, after the name field.<br>This will require an extra tab after an entry without traffic. One more TAB to enter a call.</p>
    	    <p> This little box helps the logger keep his/her hands on the keyboard while taking check-ins. Your options for entry are T,R,W,P,E,Q,A or C, they represent the action values of the Traffic column. </p>
    	    
    	    <div style="width: 500px; color:red;">
    	    <ul style="column-count: 2; column-gap: 20px; ">
        	    <li>R --> Routine</li>   <li>W --> Welfare</li>       <li>P --> Priority</li>  
        	    <li>E --> Emergency</li> <li>T --> Traffic <li>
        	    <li>Q --> Question</li>  <li>A --> Announcement</li>  <li>C --> Comment</li>
    	    </ul>
    	    </div>
    	    
            <p>By entering one of these in that little box the Traffic column for that station will automatically be updated to reflect the value. Be sure to use the dropdown in Traffic to indicate 'Sent' after the traffic is passed.
    	    </p>
    <a id="refreshtimed"></a>
	<p>The <b style="color:red">'Refresh|Timed'</b> button is used to set the automatic refresh time for the data on the page. Clicking the 'Timed' half gives you a dropdown of choices. Manual is the default, you have to click it each time you want a refresh. The rest should be understandable as is, every 5 seconds, etc.<br><b> Suggested Usage:</b>
		 
	<div class="redimportant">
    	<p> If you are net control and NOT keeping the log, set your refresh to 5 seconds.</p>
    	<p> If you are the logger but NOT net control leave the default (Manual).</p>
    	<p> If you are both leave the default (Refresh or Manual).</p>
	</div>
		 
	<p>When a new station checks into one of the nets for the first time an entry will also be made to the TimeLine Log.
	</p>
</div> <!-- End checkins -->

<hr>

<div class="deleteentry" style="page-break-before: always">
<a id="delete"></a>
<h3>DELETE AN ENTRY</h3>

	<p>
		To delete an entry, locate the <b style="color:red">red X</b> at the end of the row. Click on it, or on the words (Click to delete). <br>A dialog box will open asking you to confirm. 
			Choose your option.<br> Another method if the above doesn't work is to type in the 'Tactical' column the word <b>'DELETE'</b> in all caps. Be sure its the only thing in the cell and not adding to a tactical call. You'll know if this worked because <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> will respond with a "DELETED successfully", the row will be deleted on the next data refresh.<br>A delete is not undoable, if needed just add the call again.
	</p>
	<p>
		In both cases this action is recorded in the TimeLine Log to document the deletion.
	</p>
	
	<h4>Mis-typed Call Sign</h4>
	<p style="color:green;">If you mis-typed a call, delete it, then simply reenter the correct call sign.
	</p>
	
	
	<a class="gotoindex" href="#index">Back to the Index</a>
	 
</div> <!-- End deleteentry -->

<hr>

<div class="misc">
<a id="misc"></a>
<h3>MISCELLANEOUS OPERATIONS</h3>
 
	   <p><b>Sort Columns</b> - Most columns can be sorted simply by clicking on the column header (name). Click once and it sorts in one direction, click again and it reverses. Any kind of refresh (page or content) returns all columns to their original order.<br>An exception to this is sorting by District. When you sort by District it also sorts the County and State fields to keep them in alphabetical order as well.</p>
	   
	   <p>You can always return to the default sort order by clicking the blue 'Refresh' button.</p>
	   <p>The <b>default sort</b> is a somewhat complex algorithm that took a while to figure out. Basically its sorted first by the control stations, starting with the primary net control station, followed by the logging station. It seemed logical to keep them at the top. At the same time it seemed logical to move the checked-out stations to the bottom. The exception to this is a control station that has checked-out. I left them with the other control stations in case its status was in question. All others are then sorted by the time of check-in. They are recorded to the second but only displayed to the minute.</p>
	   
	   <p><b style="color:red">Close Net</b> - Clicking this button should be the last thing the NCO or logger does at the end of a net. After asking who (enter your call sign) is closeing the net it populates the Time Out fields and calculates the Total Volunteer Hours at the bottom of the table. It does not reset any log out times that may already be indicated. Total Volunteer Hours are calculated to the second from log-in to log-out times. You are automatically taken to the ICS-214 report after closing a net.</p>
	   <p><b>To re-open a closed log,</b> where the time out is showing, RIGHT click the <b style="color:red">'Net Closed'</b> button and confirm. Be advised however that <u>this resets all entries (except those already checked out) for timeout to NULL</u>. There is no current method to reset the time out by station. I'm working on it. Contact me if you have an issue or need help.</p>
	   <p>If you are just looking at a past log or the current log, you may just leave the page, or close the page. <b style="color:red;">But please DO NOT use the <b style="color:red">Close Net</b> button again.</b></p>
	   
	   <p><b style="color:red">Browse a Net by Number</b> - This function is in the 'Reports' menu in the upper right corner of the main page. </p>
	   
	   <p><b style="color:red">Export CSV</b> - A link to this feature is at the bottom of every net displayed on the screen, both open and closed, new and old nets.</p>
	   

	 <br><br>

<a class="gotoindex" href="#index">Back to the Index</a><br><br>

</div> <!-- End misc -->

<hr>

<div class="displays">
<a id="colors"></a>
<h3>DISPLAYS - ROW &amp; COLUMN INFORMATION</h3>

<img style=" border-radius: 10px;" src="screenshots/colors.png" alt="colors" width="1144" height="400" />

    <p>In general rows will appear in alternating white and light green, in ledger style..</p>
		
	<p style="font-weight:bold; font-size:14pt">Row Colors Based on ROLE</p>
	
	<ul>
		<li style="color:blue;"><p><b>LIGHT BLUE</b> - These are the control station(s) for the net, based on Role. </p>
		
		</li></ul> 
	<p style="font-weight:bold; font-size:14pt">Row Colors Based on MODE</p>
	<ul>	 
		<li style="color:salmon;"><b>SALMON</b> - All digital station, unless it is a digital net. Then they appear in the default colors (green/white).<br> The Mobile and HT options appear in the ledger mode.
		</li></ul>
	<p style="font-weight:bold; font-size:14pt">Row Colors Based on STATUS</p>
		<ul> 
		<li style="color:grey;"><b>GREY</b> - These are the station that have already checked out of the net, or they were In-Out at check-in.
		<li style="color:red;"><b>Red (Missing) - Any station that fails to come back to a roll call should be marked this way. This is a nemonic to double check your people and be sure they are safe.</b> During and after a net.
		<li style="color:#156d5f;">BRB, <b>army green - Be Right Back... Any station that is temporarily leaving the net.</b> 
		<li style="color:grey;">In-Out, <b>Grey - Any station that wishes to only check in then immediately check out again. His Time On Duty will be set to one minute.</b>
        </li>
        <li style="color:;">Enroute, <b>No color - Station is headed to a location/assignment.</b>
        </li>
        <li style="color:;">Assigned, <b>No color - Station is given assignment but not yet enroute.</b>
        </li>
        
        </ul>
	<p style="font-weight:bold; font-size:14pt">Row Colors Based on TRAFFIC</p>
		<ul> 
		<li style="color:red;"><b>RED</b> - Any station with pending traffic is shown in red, after the traffic is passed change the dropdown to 'Sent' to indicate the traffic has been passed. The red color highlighting will go away. Be sure to select from the dropdown the appropriate category of traffic (Priority to Routine, &amp; Question).
		
	</ul>
	<p style="font-weight:bold; font-size:14pt">Row Colors Based on entry ERRORS are shown in Red</p>
		
		 <br>
	<a class="gotoindex" href="#index">Back to the Index</a><br><br>
	
</div> <!-- End displays -->

<hr>

<a id="columns"></a>
<h3>TABLE COLUMNS &amp; HOW TO EDIT THEM</h3>
 
<h4>All columns can be sorted by clicking on the column header</h4>

<div Class="role"> 
<h3>ROLE</h3>
<h4>Role has the following dropdown options</h4>

    <div class= "redimportant" style=" padding-right: 40px; padding-bottom: 20px">
        Editable: Yes<br>
        Splitable Field: No<br>
        Required Column: Yes<br>
        Edit Type: Dropdown<br>
        Right Clickable: No<br>
        DB Variable: netcontrol<br>
    </div> <!-- End redimportant -->
    
<div class="flexcontainer">
    <div>
		<img src="screenshots/Role.png" alt="role"   />
	</div> <!-- End screenshot -->
	 
    <ul style="list-style-type:none">
	<li><b>blank</b> - This is the default indicating no specific role for this station</li>
   	<li><b>PRM</b> - This designates the primary net control operator</li>
   	<li><b>2nd</b> - The backup net control operator</li>
   	
   	<li><b>LSN</b> - Liaison to anther group/net/facility etc. You might want to use the TACTICAL column to indicate who the liaison is for. (i.e. SEMA)</li>
   	<li><b>Log</b> - The person keeping the Log if not the PRM </li>
   	<li><b>EM</b>  - Emergency Manager</li>
   	<li><b>PIO</b> - Public Information Officer</li>
    </ul>
   	
</div> <!-- End flexcontainer -->
	
    <br>
    <a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End Roll -->

<hr>
   
<div class="mode">
<h3>MODE</h3>
<h4>The Mode dropdown indicates the type of operation the station has logged in with</h4>
		
	<div class="redimportant" style=" padding-left: 20px; padding-bottom: 20px">
        Editable: Yes<br>
        Splitable Field: No<br>
        Required Column: Yes<br>
        Edit Type: Dropdown<br>
        Right Clickable: No<br>
        DB Variable: Mode<br>
    </div>  <!-- End redimoortant -->
    
<div class="flexcontainer">
    <div>
	    <img src="screenshots/Mode.png" alt="mode"   />
    </div>  <!-- End screenshot -->

	  <ul style="list-style-type:none">
		<li><b>blank</b> - This is the default</li>
		<li><b>Mob</b>  - Mobile</li>
		<li><b>HT</b>  - Hand Held device</li>
	   	<li><b>Dig</b> - This person is using or is the digital station</li>
	   	<li><b>D*</b>  - D-Star station</li>
	   	<li><b>Echo</b>  - EchoLink station</li>
	   	<li><b>FSQ</b>  - FSQ or FSQCall Operation</li>
	   	<li><b>DMR</b>  - Digital Voice</li>
	   	<li><b>V&amp;D</b>  - Checked in with both Voice &amp; Digital. Somewhat specialized for nets doing both voice and digital operations, such as a digital training net.</li>
	  </ul>
</div> <!-- End mode -->

<hr>
	
<div class="status">
<h3>STATUS</h3>
<h4>Status is an indicator of the stations immediate availability</h4>

	<div class="redimportant" style=" padding-left: 40px; width:40%;">
        Editable: Yes<br>
        Splitable Field: No<br>
        Required Column: Yes<br>
        Edit Type: Dropdown<br>
        Right Clickable: Yes A right click changes any value to 'In' and any 'In' to 'Out'<br>
        DB Variable: active<br>
    </div>  <!-- End redimoortant -->

<div class="flexcontainer">	
    <div>
		<img src="screenshots/Status.png" alt="griddisplay"   />
	</div>

    
	  <ul style="list-style-type:none">
	   	<li> <b>IN</b> - Checked in and available, the default</li>
	   	<li> <b>OUT</b> - Station has checked out of the net</li>
	   	<li> <b>IN-OUT</b> - Station is checking in and immediately checking out. One minute is recorded in TOD.</li>
	   	<li> <b>BRB</b> - Be Right Back, out for a short time, i.e. a bio-break.</li>
	   	<li> <b style="color:red">MSSING</b> - This person failed to respond to the last roll call</li>
	   	<li> <b>Enroute</b> - This operator is on their way to a location.</li>
	   	<li> <b>Assigned</b> - The station is assigned to something, NCS decide.</li>
	   	<li> <b>Moved</b> - The station has moved to another frequency or net, NCS decide.</li>
	   	<li> <b>Leave?</b> - Want to leave the net? Ask permission by selecting this value.</li>
	   </ul>
	</div>
</div>

<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End status -->

<hr>

<div class="traffic" style="page-break-before: always">
<h3>TRAFFIC</h3>
<h4>Traffic Indicates the station has traffic, and what kind</h4>

   <div class="flexcontainer">
		<div class="redimportant" style=" padding-right: 40px;">
            Editable: Yes<br>
            Splitable Field: No<br>
            Required Column: Yes<br>
            Edit Type: Dropdown & Short Cut from the button bar<br>
            Right Clickable: No<br>
            DB Variable: traffic<br>
        </div>
        <div>
		    <img src="screenshots/Traffic.png" alt="traffic"   />
        </div>
   </div>
            

	 <div class="">		
		  <ul style="list-style-type:none; width:20%; padding-right:15px;">
			<li><b>blank the default for no traffic</b></li>
			<li><b>Routine</b></li>
			<li><b>Welfare</b></li>
			<li><b>Priority</b></li>
		
			<li><b style="color:red">Emergency</b></li>
				
			<li><b>Question</b></li>
			<li><b>Announcement</b></li>
			<li><b>Bulletin</b></li>
			<li><b>Comment</b></li>
			<li><b>Pending</b> - Waiting on something from Net Control</li>
			<li><b>Resolved</b> - Waiting is over</li>
			<li><b>Sent</b></li>
		  </ul>	
 <!--   <div style="width: 75%;">  -->
		 <p>
			 Use Routine if in doubt. Blank indicates no traffic, change choice to 'Sent' after traffic has been sent.</p>
        <p>As a short cut to entering check-ins with traffic a new smaller input field (box) has been added to the button banner, after the name field.<br><br>This does require an extra tab after an entry without traffic. TAB TAB TAB to enter a call.</p>
    	    <p> This little box helps the logger keep his/her hands on the keyboard while taking check-ins. Your options for entry are T,R,W,P,E,Q,A or C, they represent the action values of the Traffic column. R --> Routine, W --> Welfare, P --> Priority, E --> Emergency, Q --> Question, A --> Announcement, C --> Comment. <br> By entering one of these in that little box the Traffic column for that station will automatically be updated to reflect the value. Be sure to use the dropdown in Traffic to indicate 'Sent' after the traffic is passed.
    	    </p>
<!--</div>-->
	
</div>
<br>
<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End traffic -->

<hr>

<div class="tt" style="page-break-before: always">
<h3>tt</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: click <br>
    Right Clickable: No<br>
    
</div>
<p># This is the <b style="color:#aa7941;">APRStt</b> number assigned to this station on this net. Only 0-99 are APRStt usable. More details on use coming...
	<br>
	<br>
</p>
</div> <!-- End tt -->

<hr>

<div class="band">
<h3>Band</h3>
<h4>Band this station has checked in from.</h4>
  
    <div class="redimportant" style=" padding-bottom: 20px;">
        Editable: Yes<br>
        Splitable Field: No<br>
        Required Column: *No<br>&nbsp;&nbsp;&nbsp;&nbsp;* Except for 'Multiple Bands' and '80/40 Meters' frequency choices.<br>
        Edit Type: dropdown <br>
        Right Clickable: No<br>
    </div>
    <div style="padding-bottom: 25px">	
		<img src="screenshots/bands.png" alt="heardlist" height="300"   />
	</div>
	
</div>

<br>
<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End band -->

<hr>

<div class="callsign" style="page-break-before: always">
<h3>Call Sign</h3>
<h4>Call Sign Column Header Right Click</h4>

<div class="redimportant" style=" padding-bottom: 20px; padding-bottom: 20px">

    Editable: *No<br>&nbsp;&nbsp;&nbsp;&nbsp;* Except for pre-built/roll call nets.<br>
    Splitable Field: No<br>
    Required Column: Yes<br>
    Edit Type: *N/A<br>&nbsp;&nbsp;&nbsp;&nbsp;* In pre-built/roll call nets, click to edit.<br>
    Right Clickable: Yes on header, and individual cells<br>
    
</div>

    <div class="flexcontainer">
		<div style="padding-bottom: 25px; padding-right: 20px">	
		    <img src="screenshots/heardlist.png" alt="heardlist" height="300"   />
		</div>
        <div>
		<p>Right clicking on the column head 'Call Sign' creates a heard list of this net.<br>This same functionality is available by selecting the hamburger menu (right of Help in upper corner) and selecting 'Create a heard list'.<br>A variety of different formats is created. Copy/Paste the one you want.</p>
        </div>
	</div>
	
</div> <!-- End flexcontainer -->

<div class="flexcontainer">
	<div style="width: 50%; padding-right: 20px">
		<h4>Individual Call Sign Right Click</h4>
		<p>Right clicking on the call sign displays a floating, modal report showing details of this stations net operations. </p>	
		<p>The use of a head-shot picture is optional, let me know via email if you want it.</p>
	</div>
	<div style="padding-bottom: 25px">
		<img src="screenshots/callhistory.png" alt="callhistory" height="300" />
	</div>
</div> <!-- End flexcontainer -->
<br>
<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End callsign -->

<hr>

<div class="FandLnames">
<h3>First Name &amp; Last Name</h3>

<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: No<br>
    Required Column: First: Yes, Last: No<br>
    Edit Type: click <br>
    Right Clickable: No<br>
    
</div>

<p>First Name is the operator's first name. Last Name is a separate column.</p>
</div> <!-- End FandLnames -->

<hr>

<div class="tactical">
<h3>TACTICAL</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: Yes with two spaces<br>
    Required Column: Yes<br>
    Edit Type: click <br>
    Right Clickable: No<br>
    DB Variable: tactical<br>
</div>

<img style="float:right; padding-left: 20px; border-radius: 10px;" src="screenshots/tactical.png" alt="tactical" width="430" height="274" />
	
	    <dev style="padding-right: 20px;">
		<p>	The use of Tactical Calls at Public Service Events is becoming more and more common place and it is legal. The use of tactical calls can and does increase the efficiency and speed in identifying a specific function or person. They also eliminate confusion when working with other agencies that have no idea what amateur radio call signs are or mean. Using “ Rest Stop 1 from Net Control” is a lot easier and to the point than “WA0TJT this is KC0BS.” The assignment of a tactical call should, if possible, relate to the amateurs function at the event. Tactical calls such as “Sag 1, Aid Station 4, Police 2, First Aid, Logistics” and so on provide a verbal “picture” of the function.			
		</p><p>
			Sometimes a tactical call by location is not the best solution, 'West end of parking lot B' for example. In this case its easier to just use the call sign default suffix such as 'TJT'. But for the <b style="color:blue;">NCS</b> to remember where 'TJT' is located becomes more difficult. Putting that information in the comments line is problematic because you may need to use that field for a report from 'TJT. Which would then blank out the tactical postion information.
		</p><p>
			
			For the best of both worlds <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> allows for multiple lines within the Tactical field. Any thing entered after the initial tactical call 'TJT' followed by <b style="color:red;">two spaces</b> becomes a second line in the Tactical field. Now you can have a tactical of 'TJT' and below it in the same box it might say 'West end of parking lot B'. <b>You might find it advantageous to put the job title first, for example 'SAG 1', then the 'TJT'.</b> Just don't forget the <b style="color:red;">two spaces</b>.
		</p>	
	    </dev>

<br>
<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End tactical -->

<hr>
	
<div class="phone">
<h3>Phone</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: click <br>
    Right Clickable: No<br>
    DB Variable: phone<br>
</div>
<p>Phone number including country code (optional) and the area code, any readable format is acceptable.</p>
</div> <!-- End phone -->

<hr>

<div class="email">
<h3>eMail</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: click <br>
    Right Clickable: No<br>
    DB Variable: email<br>
</div>
<p>eMail address of this station.</p>

<a class="gotoindex" href="#index">Back to the Index</a>

</div> <!-- End email -->

<hr>

<div class="grid">
<a id="grid"></a>
<h3>GRID</h3>
<div class="redimportant">
    Editable: *Yes<br>&nbsp;&nbsp;&nbsp;&nbsp;* Also changes latitude and longitude.<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: click <br>
    Right Clickable: Yes on individual cells<br>
    DB Variable: grid<br>
</div>
<p>This is the Maidenhead Grid Sqare location of the operators home station and will be added automatically by the system.<br>Any changes made to this field will also result in an update to the latitude and longitude fields.
</p>
	<img style="float:left; padding-left: 10px; padding-right: 10px; border-radius: 10px; margin-right: 15px;" src="screenshots/grids.png" alt="grids" width="432" height="368"  />

	<div style=""> 
		<p style=""><br>
		A Maidenhead locator compresses latitude and longitude into a short string of characters. The position information is presented in a limited level of precision to limit the amount of characters needed for its transmission using voice, Morse code, or any other operating mode. 
		The chosen coding uses alternating pairs of letters and digits, like so:
		</p>
		<h4>EM29qe78</h4>
		<p>
		In each pair, the first character encodes longitude and the second character encodes latitude. These character pairs also have traditional names (see diagram), and in the case of letters, the range of characters (or "encoding base number") used in each pair does vary.
		</p><p>More information is available <a href="http://www.arrl.org/grid-squares" target="_blank">here.</a>
		</p>
		
        <div class="flexcontainer">
	<div style="width: 50%;">
		<h4>Right Click on Grid</h4>
		<p>Right clicking a grid field will take you to a QRZ map showing that grid and all the other hams in it.</p>
	</div>
	<div style="padding-bottom: 25px">	
		<img src="screenshots/griddisplay.png" alt="griddisplay"   />
	</div>
</div>

	</div>
</div> <!-- End grid -->

<hr>

<div class="latitude">
<h3>Latitude</h3>
<div class="redimportant">
    Editable: *Yes<br>&nbsp;&nbsp;&nbsp;&nbsp;* Also changes the GRID.<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: click <br>
    Right Clickable: No<br>
    DB Variable: latitude<br>
</div>
<p>Latitude of this station.</p>
</div> <!-- End latitude -->

<hr>

<div class="longitude">
<h3>Longitude</h3>
<div class="redimportant">
    Editable: *Yes<br>&nbsp;&nbsp;&nbsp;&nbsp;* Also changes the GRID.<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: click <br>
    Right Clickable: No<br>
    DB Variable: longitude<br>
</div>
<p>Longitude of this station.</p>
</div> <!-- End longitude -->

<hr>

<div class="timeInOut">
<h3>Time In, Time Out</h3>
<div class="redimportant">
    Editable: No<br>
    Splitable Field: No<br>
    Required Column: Yes<br>
    Edit Type: Automatic <br>
    Right Clickable: No<br>
    DB Variable - Time In: logdate<br>
    DB Variable = Time Out: timeout<br>
</div>

<p><b>Time In -</b> The time the station was added to the data base and is not editable. </p>

<p><b>Time Out -</b> The time the station was shown 'OUT' of the net. This would also reflect any In/Out or BRB out times as well. This value is editable but you'll have to ask me for the how.</p>
</div> <!-- End timeInOut -->

<hr>

<a id="timeline"></a>
<div class="TimeLineLog">
<h3>Time Line Comments</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: Yes with two spaces or use the <b>&lt;br&gt;</b> HTML tag<br>
    Required Column: Yes<br>
    Edit Type: click <br>
    Right Clickable: Yes<br>
    DB Variable: comments<br>
</div>
<p>Time Line is used to enter any comments or reports made by this station. They are then populated into the TimeLine Log table. Each comment is individually entered into the timeline log for reporting in the ICS reports. Each click in this field clears the previous entry, but it has been saved. Changes to several of the column values are also logged here.
</p>
<p>Right clicking in one of the cells will produce a chronological listing of all the entries for this station.
</p>
</div> <!-- End TimeLine Log -->

<hr>

<div class="tod">
<h3>Time On Duty</h3>
<div class="redimportant">
    Editable: No<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: Calculated at station log out and end of net<br>
    Right Clickable: No<br>
    DB Variable: timeonduty<br>
</div>
<p>Total volunteer hours, and minutes on this net.</p>
</div> <!-- End tod -->

<hr>

<div class="creds">
<h3>CREDS</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: Yes with two spaces<br>
    Required Column: No<br>
    Edit Type: Click <br>
    Right Clickable: No<br>
    DB Variable: creds<br>
</div>
<p>CREDS or Credentials - Shows this station operators credentials (if known),i.e. <b style="color:red;">ARES</b>, <b style="color:darkblue;">RACES</b>, etc.
	</p><p>
			For the best of both worlds <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> now allows for multiple lines within the Credentials field. Any thing entered after the initial credential i.e. 'KCHEART' followed by <b style="color:red;">two spaces</b> becomes a second line in the Creds field. Now you can have a credential of 'KCHEART' and below it in the same box it might say 'St. Lukes Northland'. More lines are possible if needed, simple use <b style="color:red;">two spaces</b> for the next line.
		</p>
</div><!-- End creds -->

<hr>

<div class="CSD">
<h3>County, State, Dist.</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: Click <br>
    Right Clickable: County Yes, State No, District No<br>
    DB Variable - County: county<br>
    DB Variable - State: state<br>
    DB Variable - Dist: district<br>
</div>
<p>Shows the County, State and Highway Patrol District or ARRL District -- For some Nets these are already shown.
	<br><br>
</p>
<div class="flexcontainer">
	<div style="width: 50%;">
		<h4>Right Click County</h4>
		<p>Right clicking on the county name will display a Google map of that county.</p>
	</div>
	<div style="padding-bottom: 25px;">
		<img src="screenshots/county.png" alt="countydisplay" width="267" />		
	</div>
</div>

<br>
<a class="gotoindex" href="#index">Back to the Index</a>

</div> <!-- End CSD County, State, District -->

<hr>


<div class="what3words" style="page-break-before: always;">
<a id="what3words"></a>
<h3><b>///</b> W3W<br>
 What 3 Words for locations</h3>
<div class="redimportant">
    Editable: Yes<br>
    Splitable Field: No<br>
    Required Column: No<br>
    Edit Type: Click <br>
    Right Clickable: Yes<br>
    DB Variable: w3w<br>
</div>
   
<p>what3words is an easy way to talk about any precise location in the world. It gives every 3m x 3m square (10 sq/ft) a unique combination of three words: a what3words address.
</p><p>A what3words address is more precise than a street address, and many people find three words easier to remember and say than GPS coordinates, grid references or latitude and  longitude.

</p>
<p>The station profile accessed by right clicking a call sign now shows the what3words address based on the latitude and longitude of the record clicked. The what3word address will change based on that lat/lon combination.</p>
<p>Adding or changing this field also changes the latitude, longitude and grid columns. Additionally the nearest cross roads will be added to the W3W column and documented in the Time Log.</p>

<p>
    The W3W field also allows for an additonal comment to be added after the three words. For example you might enter 'spray.shudder.opting Telephone pole in yard' (no quotes). The field in the net log after a data update would then reflect;<p style="color:blue">spray.shudder.optiong <br>N Ames Ave & NW 57 Ct'</p> with the nearest crossroads. But in the Time Line you would see this; <p style="color:blue;">LOCΔ:W3W:OBJ: spray.shudder.opting -> Cross Roads: N Ames Ave & NW 57 Ct (39.198159,-94.601576) Telephone pole in yard</p>
    <p>
    Basically, it treats the entry similar to an APRS object, multiples entries for the same reporting station can then be reported as a neighborhood or a much more local area.
</p>

             <p>See <a href="https://what3words.com" target="_blank">https://what3words.com</a> for more general information about What 3 Words.</p>
</div> <!-- End what3words -->

<hr>

<div class="additional" style="page-break-before: always">
<a id="additionalColumns"></a>

<h3>Optional TABLE COLUMNS Available for display</h3>

<div class="flexcontainer">
	<div style="width: 80%;">
<img src="screenshots/add_columns.png" alt="add_columns" width="400" />
</div>
	<div style="padding-left: 20px;">
		<p>NCM is equipped with 23 unique columns of information that make up its primary table. Thirteen of these are optional and may not be showing by default. Each group (KCNARES, PCARG, CARROLL, etc.) has a default display that may include one or more of these optional columns. But it is also possible for each user (like you) to see part or all of the optional columns by simply clicking the orange <b style="color:red">SHOW/HIDE Columns</b> button in the menu bar. Click the box next to each column you want to see or un-click any you don't want to see. Then click the <b style="color:red">'Save to Cookies'</b> button, on the next table refresh your optional columns will be displayed or hidden depending on your selection.
	    </p><p>
        If your group would like to have a different set of defaults than what currently comes up, please email me with your selections, or take a screenshot of the above referenced box, and I'll set them up for you. In the future this will be an optional setting your group can make itself. </p>

	</div> <!-- End padding-left -->
</div>
<br><br>
<a class="gotoindex" href="#index">Back to the Index</a>

</div> <!-- End additional -->

<hr>  

<div class="reports">
<a id="reports"></a>
<h3>PREAMBLES, AGENDAS, REPORTS and more...</h3>
<div class="flexcontainer">
    <div style="width: 60%;">
        <img style="float:left; padding-right: 10px;" src="screenshots/Reports.png" alt="startnewnet" height="615" />
        <br>
    </div>
		<div class="redimportant" style="padding-left: 20px;">
			<b style="color:blue">Preamble</b> -  selected Net, displays a modal box.<br>
			<b style="color:blue">Agenda</b> -  selected Net and any indicated as ALL, displays a modal box.<br>
			<b style="color:red">New</b> - Displays the editor for creating the Preamble, Agenda and Closings.<br>
			<b style="color:blue">Closing</b> - Specific to the selected Net, displays a modal box. <br>
			
			<b style="color:blue">Reports</b> - Select one of the following from this dropdown<br>
			<b style="color:blue">List/Find All Nets</b> - List every net, with an option to print the ICS-214, ICS-309 or to map the stations.<br>
			<b style="color:blue">Statistics</b> - Another manual is needed for this. Try it out...<br>
			<b style="color:blue">MECC Comm Plan</b>
			<b style="color:blue">Show APRS.fi presence</b>
			<b style="color:blue">Map This Net</b>
			<b style="color:blue">Print</b> - Is the better print report option. It will be displayed as a web page. Use your browser to email it, create a PDF, or print the page.<br>
			<b style="color:blue">ICS-205A</b>
			<b style="color:blue">ICS-214</b> - Is the official ICS-214 report form. It will be displayed as a web page. Use your browser to email it, create a PDF or both.<br>
			<b style="color:blue">ICS-309</b>
			<b style="color:red">Addional ICS Forms</b> <br>
			
			<b style="color:blue">Hamburger</b> -A dropdown with additonal functionality.
			<img style="float:right; padding-right: 10px; border-radius: 10px;" src="screenshots/hamburger.png" alt="hamburger" height="170" />
			   
    			    <div class="redimportant" style="padding-left: 10px;">
        			    Create A New Group<br>
        			    Select Group Default Columns<br>
        			    Create A Heard List<br>
        			    Direwolf APRStt Config List<br>
        			    Documentation<br>
			        </div>
		</div> <!-- End redimportant -->
</div> <!-- End flexcontainer -->



<br><br>

<a class="gotoindex" href="#index">Back to the Index</a><br><br>

</div> <!-- End reports -->

<hr><hr>

<div class="advancedtopics">
<a id="advanced"></a>
<h3>ADVANCED TOPICS</h3>

<h4>ADDING GENERAL NET COMMENTS TO THE TIME LOG</h4>
<p>Between the list of nets dropdown and the Call Sign entry box is a General Comments field. To make it visible hover your cursor over the open space between these two fields. A yellow box will be displayed capable of any amount of text you paste or type into it. Anything entered in this field is timestamped and put into the Time Log table for this log. It only remains visible in this box to the person who entered it.
</p>
<p>Why would you want this?<br>Suppose you open a 'Stand By' net for weather. After opening the net add a remark in this field indicating it is stand by only. When the net goes official (NWS asked for a net) add another note that says it is now an official weather net. Both entries will appear in the Time Log and will indicate exactly when it switched between stand by and official. This way moving from a stand by to official net will not require starting a new net.
</p>

<h4>USING Sub NETS</h4>
<p>Suppose you open an emergency net for a large tornado or maybe a seismic event. Because of the number of jurisdictions it might become difficult for one net control operator to support the entire group of stations, or for message handling purposes he/she may ask one or more stations to break off and start a new net for their jurisdiction or a specific need.
</p>
<p>It would be nice however if the nets were connected, reportable as one after the event. In this case while creating the new net the additional net control operator can select in the procedures to <b style="color:red">link</b> this net to the original. The dropdown box (at the bottom of the new net dialog) for this will only indicate the eligible nets to link with. Select the parent of the net being created.
</p><p>
	At the bottom of all nets is a reference line, similar to this <img style=" border-radius: 10px; vertical-align: middle;" src="screenshots/subnetinfo.png" alt="referenceLine" />. Studying this you'll see that the first item is the net number the second is the call sign of the currently open net (#795/TE0ST). Followed immediately by ether "Has S/N: 797, 798" if it is the parent net. Or "S/N of: 795" if it is one of the child (sub) nets.
	<br>All nets created in this manner are stand alone nets with their own net control operator (<b style="color:green;">NCO</b>), however they can all be opened in separate tabs of your browser. 
	<br>If you just want a peek at one of the other nets, parent (if you are the child) or child (if you are the parent) simply click this list and they will display at the bottom of your net. They are NOT editable.
	<br>This may seem very confusing until you try it.

	 <br>Another more common variation of this sub menu is: <img style=" border-radius: 10px; vertical-align: middle;" alt="submenu" src="screenshots/submenu.png">
</p>

<hr>

<div class="TimeLineLog">
<a id="TimeLineLog"></a>
<h3>How The Timeline Log Works</h3>
<h4>This is the primary source for the ICS-214 &amp; ICS-309 Reports</h4>
<p>
	The TimeLine Log table is not directly editable by the user. It is used as a log of the activities that take place on the primary net control table. Information is logged with a timestamp of when it happened, who posted or what station was affected and the action taken.
	Examples of logged actions include any time the Role, Mode, Status, or Band is changed, the action is logged in the Time Log table. This makes it possible to track who was running the net at the any given time. This might be important if authorities need additional information about something that happened at a certain time.
</p><p>The Timeline Log is also updated anytime a comment or report is added to the 'Time Line / Comments' field on the primary net control page. This makes it very simple to record incoming information from a specific station.
</p><p>Additionally the TimeLine Log reports any change of location of the subject station. The 'Report' field of the log might begin like this "LOCΔ:" this means 'Location Change (delta)' the next field after the colon would tell you where the change was made i.e. COM for comments, W3W for the What3Words column, LAT for latitude and LON for longitude, G for grid. 
</p><p>Use Time Line Comments to indicate that Message #xx was sent. No need to put the entire message in, just reference its number. Now a record exists showing when the message arrived and when it was sent and what message it was. But if it is more appropriate for the situation, you can copy the entire message into the Comments field or the general comment field.</p><p>Time Log also records any information added to the General comment area of the net control panel. If the net goes on for a significant time (hours) it might be appropriate to copy the weather information to this location occasionaly.  </p>
</div> <!-- End TimeLine Log -->

<hr>

<div class="fema">

<h3>FEMA, NIMS, Emergency Management Institute, ARRL</h3>

<p>
	Most <b style="color:red;">ARES/RACES</b> type groups require ICS 100 and ICS 700 certification for credentialing. Click <a href="https://training.fema.gov/emiweb/is/icsresource/assets/nims_training_program.pdf" target="_blank">National Incident Management System</a> for more information.</p>
	<p>You might also want to check out the ARRL courses at <a href="http://www.arrl.org/online-courses" target="_blank">ARRL Courses &amp; Training</a>
	</p>
</div> <!-- End fema -->

<hr>

<div class="aprstt">
<a id="APRStt"></a>
<h3>What is <b style="color:#aa7941;">APRStt</b>?</h3>

<h4><b style="color:#aa7941;">APRS</b> tt (Touch Tone) </h4>
<p>Suppose you open an emergency net for a large tornado or maybe a seismic event. Because of the number of stations wanting to check into the net it sometimes becomes impossible to know where everyone is located. Wouldn't it be nice if you could put each stations location on a map? Well now you can. </p>
<p>One method would be to use the APRStt system using a Direwolf TNC by WB2OSZ, and based on work by WB4ABR </p>
<p>See <a href="http://www.aprs.org/aprstt.html" target="_blank">http://www.aprs.org/aprstt.html</a> for more information about APRStt.</p>
<p>Another newer method would be to use What 3 Words covered <a href="#what3words">here in this document</a>.</p>

<a class="gotoindex" href="#index">Back to the Index</a><br><br>

</div> <!-- End aprstt -->

<hr>

<div class="prebuild">
<a id="prebuild"></a>
<h3>How to Pre-Build a Net for use at a future Event</h3>

<ol style="list-style-type: decimal; column-count: 1;">
	<li>Select <b style="color:red">'Start a new net'</b></li>
	<li>Enter your call sign</li>
	<li>Select "Event" from the 'Select Group by Name' dropdown</li>
	<li>Click the "Check to create a Pre-Build Event" checkbox</li>
	<li>Click <b style="color:red">"OK"</b> on the dialog box</li>
	<li>Click <b style="color:red">"Submit"</b></li>
	<li>Name the Event... i.e. 2019 Liberty Half-Marathon</li>
	<li>Click <b style="color:red">"OK"</b></li>
	<li>At this point a new net matrix should appear</li>
	<li>Click the <b style="color:red">"Copy a Pre-Built"</b> net to clone an older pre-built net. Or start to build your new one.</li>
	<li>
		<ol style="list-style-type: decimal; column-count: 1;">
			<li>After clicking <b style="color:red">"Copy a Pre-Built"</b> select the net you wish to clone.</li>
			<li>The cloning will be automatic, you can then edit like usual.</li>
		</ol>
	</li>
	<li>When you are ready to start the check-in operation, click the "Out" under 'Status' and change it to 'In'.</li>
	<li><b>TOD begins when the 'Out' is changed to 'In', so don't forget this important part.</b></li>
	<li>When the net is over, I recommend you delete any stations that did not check-in. But thats your call and not required.</li>
</ol>
<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End prebuild -->
    
<hr>

<div class="mapping">
<a id="Mapping"></a>
<h3>Mapping Your Net </h3>

<p>In the 'Reports' dropdown in the upper right corner you can select 'Map This Net'. When selected a map will appear with markers for each station logged into the net. In the lower right corner is a list of Points of Interest that will optionally display various public location that may be of interest to your net. The POIs must first be added to the system, to do this requires a CSV file which will be detailed below.
</p><p>In addition to the POI's it is also possible to use any marker on the map as a center point to a series of expanding circles with bearing markers for distance and direction needs. To activate this right-click on any marker, two dialog boxes will open asking for the distance between circles and then how many. I suggest you accept the defaults, and adjust only if you don't like the results. See below for an example.
</p>
     <img style="float:left; padding-left: 10px; padding-right: 10px; border-radius: 10px; margin-right: 15px;"  src="screenshots/map.png" alt="map" width="" height="" />
     
<div class="flexcontainer">
	<div style="">
    	<p>Features Include:
        	<ol>
            	<li>List of stations, clicking a marker will display the information box above it.</li>
            	<li>W3W: A click anywhere on the map will display the What3Words address for that location</li>
            	<li>Mouse activity will change the latitude/longitude and grid location</li>
            	<li>Mileage between points can be determined via the 3 blue boxes on the right, click to explore.</li>
            	<li>The + and - zoom the map.
            	<li>Select Imagery (satellite) or street maps.</li>
            	<li>The station markers can be hiddent by clicking off the Stations list. Control operator station markers are in Blue, the rest in green.</li>
            	<li>Points of Interest are available. See below for more details. Click to activate your choices. Detail information about the POI will appear when you click the POI marker.</li>
            	<li>Clicking anywhere within the circles will hide the circles but leave in place the bearing and distance markers.</li>
            	<li>Simplex capabilities example on YouTube: <a href="https://www.youtube.com/watch?v=nsA9Hv6K_00" target="_blank">https://www.youtube.com/watch?v=nsA9Hv6K_00 </li>
            </ol>
    	</p> <!-- End Features Include paragraph -->
	</div> <!-- End  -->	
</div>	<!-- End of flexcontainer -->
</div> <!-- End mapping -->
<br><br>
<br><br>
<br><br>
<br><br><br><br><br><br><br><br><br><br>
    <a class="gotoindex" href="#index">Back to the Index</a><br><br>    
	

    <hr>
    
<div class="mapping">
<a id="Mapping"></a>
<h3>Creating POIs For Mapping </h3>
<p>To add points of interest create a CSV file with the headers in the below example. There is no limit to the number you can have but try and be reasonable, even a couple hundred would be OK if you have need.
    <br><br>
    Example...
    <br><br>
class, Type, name, county, address, city, latitude, longitude, grid, tactical, callsign, DGID, mode, Notes<br>
Sheriff,,"Northmoor Police Department", Platte, "2039 NW 49th Terrace", "Northmoor MO 64151", 39.183487, -94.605311,,NRTPD,,,,
<br><br>
    End Example...
</p>
<p>
    <dl>
        <dt>Column 1 - class:</dt>
        <dd>Class: Your options are Hospital, Repeater, EOC, Sheriff, SkyWarn, Fire. If you need something else go ahead and use it but keep it to one word. 'Sheriff' should be used for any law enforcement agency. </dd>
        <dt>Column 2 - Type:</dt>
        <dd>type: If the class is repeater please indicate what kind of repeater i.e. AWS, Fusion, DMR, Analog.</dd>
        <dt>Column 3 - name:</dt>
        <dd>name: "Northland ARES Platte Co. EOC" for example and be sure to enclose it with double quotes  ( " " ).</dd>
        <dt>Column 4 - county:</dt>
        <dd>county: The county it's in.</dd>
        <dt>Column 5 - address:</dt>
        <dd>address: This should be the street address without the city or zip. Be sure to enclose in double quotes.</dd>
        <dt>Column 6 - city:</dt>
        <dd>city: The city name, state and zip code. Be sure to enclose in double quotes.</dd>
        <dt>Column 7 - latitude:</dt>
        <dd>latitude: This MUST be in dd.ddddd (digital) mode 39.12345. Use Google Maps if you need.</dd>
        <dt>Column 8 - longitude:</dt>
        <dd>longitude: This MUST be in dd.ddddd (digital) mode -094.12345. Use Google Maps if you need.</dd>
        <dt>Column 9 - grid:</dt>
        <dd>grid: The maidenhead gridsquare location of the point. You may leave this blank.</dd>
        <dt>Column 10 - tactical:</dt>
        <dd>tactical: Use something simple, consider the callsign (if the location has one).</dd>
        <dt>Column 11 - callsign:</dt>
        <dd>callsign: The ham callsign, if there is one. May be left blank.</dd>
        <dt>Column 12 - DGID:</dt>
        <dd>This is the Yaesu Digital Group ID number for Fusion. However if you use DMR you might consider using your Code Plug name instead.</dd>
        <dt>Column 13 - mode</dt>
        <dd>mode: Is the repeater Digital, AMS on Demand, or Analog. Be sure to enclose in double quotes. May be left blank.</dd>
        <dt>Column 14 - Notes:</dt>
        <dd>notes: Anything you want them to say. Be sure to enclose in double quotes. May be left blank</dd>

    </dl>
</p>

    <a class="gotoindex" href="#index">Back to the Index</a><br><br> 
<hr>

<div class="responsive">
<a id="Responsive"></a>
<h3>Responsive Design aka Mobile First</h3>

<p>Responsive Web Design makes your web page look good on all devices (desktops, tablets, and smart phones).</p>
<p>
Responsive Web Design is about using HTML and CSS to resize, hide, shrink, enlarge, or move the content to make it look good on any screen:</p>
<p>
	I have chosen to build <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> in this way. This means if you look at <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> on a iPad it might look different (slightly) than it does on your 22 inch monitor. It for sure will look different on your Android or iPhone. But there is only so much I can do to make <span class="firstword">N</span><span class="secondword">C</span><span class="thirdword">M</span> a usable application on your iPhone. I see it more as a reference app because doing any real editing will be tricky. But it can be done.
	</p>
	<p>Give it a look on your favorite smaller device. Or just grab the corner of your browser and shrink the window until you notice the differences.
</p>

</div> <!-- End responsive -->

</div><!-- End advancedtopics -->


<div class="mars">
<a id="mars"></a>
<h3>MARS Net Differences</h3>
<p>NCM was modified slightly to better support the MARS or Military Auxiliary Radio System. Some default columns, not needed by typical MARS nets were hidden, while new columns were added. Most notably a TRFK-FOR column was added. This value is meant to be used to indicate the station checking in has traffic for the TRFK-FOR station.</p>
<p>To make check in processing even quicker, the 'Name' field on the button bar is changed to 'Traffic For:', values added here at check in are added to that field. In addition the 'Status' column will be changed to show 'Routine' traffic.
</p>
<p>If your non-MARS group thinks it would like to utilize this functionality let me know via groups.io and we can talk.</p>

<hr><hr><hr>

<div class="title">
		<p>Net	</p>
		<p>Control 
		<p>Manager</p>
</div> <!-- End title -->

<a class="gotoindex" href="#index">Back to the Index</a><br><br> 
<hr>


<div class="theend">
    <a id="theend"></a>
<p>&copy; Copyright 2015-<?php echo date("Y");?>, by Keith D. Kaiser, WA0TJT <br>
Written by: Keith D. Kaiser, WA0TJT with the invaluable assistance, understanding and love of Deb Kaiser, W0DLK. <br>
Additonal Authors, advisers, resources and mentors include: Jeremy Geeo (KD0EAV) who is also our server host, Sila Kissuu (AK0SK), Nicolas Carpi for his jeditable, Mathew Bishop (KF0CJM), Members of Kansas City Northland ARES, The Platte County Amateur Radio Group, and the many members of <a href="https://stackoverflow.com" target="_blank"> Stack Overflow.</a>
</p>
<p>
Guarantees or Warranties:<br>
     No Guarantees or Warranties. EXCEPT AS EXPRESSLY PROVIDED IN THIS AGREEMENT, NO PARTY MAKES ANY GUARANTEES OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WHETHER ARISING BY OPERATION OF LAW OR OTHERWISE. PROVIDER SPECIFICALLY DISCLAIMS ANY IMPLIED WARRANTY OF MERCHANTABILITY AND/OR ANY IMPLIED WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE. 
</p>
<div class="classictemplate template" style="display: block;">
<style type="text/css">
  #groupsio_embed_signup input {border:1px solid #999; -webkit-appearance:none;}
  #groupsio_embed_signup label {display:block; font-size:16px; padding-bottom:10px; font-weight:bold;}
  #groupsio_embed_signup .email {display:block; padding:8px 0; margin:0 4% 10px 0; text-indent:5px; width:58%; min-width:130px;}
  #groupsio_embed_signup {
    background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; 
  }
  #groupsio_embed_signup .button {

      width:25%; margin:0 0 10px 0; min-width:90px;
      background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);
      background-repeat: repeat-x;
      border-color: #245580;
      text-shadow: 0 -1px 0 rgba(0,0,0,.2);
      box-shadow: inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);
      padding: 5px 10px;
      font-size: 12px;
      line-height: 1.5;
      border-radius: 3px;
      color: #fff;
      background-color: #337ab7;
      display: inline-block;
      margin-bottom: 0;
      font-weight: 400;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
    }
</style>
<div id="groupsio_embed_signup">
<form action="https://groups.io/g/NCM/signup?u=5681121157766229570" method="post" id="groupsio-embedded-subscribe-form" name="groupsio-embedded-subscribe-form" target="_blank">
    <div id="groupsio_embed_signup_scroll">
      <label for="email" id="templateformtitle">Subscribe to the NCM groups.io! </label>
      <input type="email" value="" name="email" class="email" id="email" placeholder="email address" required="">
    
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5681121157766229570" tabindex="-1" value=""></div>
    <div id="templatearchives"></div>
    <input type="submit" value="Subscribe" name="subscribe" id="groupsio-embedded-subscribe" class="button">
  </div>
</form>
</div>
</div>

<a class="gotoindex" href="#index">Back to the Index</a><br><br>
</div> <!-- End of theend -->

<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>


<script   src="https://code.jquery.com/jquery-3.5.1.min.js"   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="   crossorigin="anonymous"></script>

<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
        
        $(document).ready(function(){
          $(".tipsbutton").click(function(){
            $(".HelpBubbles").toggle();
          });
        });
</script> <!-- The scrollFunction to move to the top of the page -->

</body>
</html>