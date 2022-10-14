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
    } /* End of media css */
</style>
	
	

    
</head>
<body>
	
<div id="banner">
    
    <img id="smtitle" src="images/NCM.png" alt="NCM" >

	<div class="title">
		<p>Net	</p>
		<p>Control  <span style="float: right;">Code Documentation &amp; Help</span></p>
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
				/*echo "As of Today: -->   $netcall Groups, $cscount Unique Stations, $netCnt Nets, $records Entries,
					 <br> $volHours of Volunteer Time<br>Across: 4 Countries, $stateCnt states, $countyCnt counties and $gridCnt grid squares.";
				*/	 
				echo "As of Today: --><br>   $netcall Groups, $cscount Unique Stations, $netCnt Nets, $records Entries,
					 <br> $volHours of Volunteer Time";
			?>
		</div>
		<div class="printIt">
			<button style=" color:#4706f8; font-size: larger" onclick="printfunction()">Print this document</button>
			<br>
			<script>
    			var myDate = new Date(document.lastModified).toLocaleDateString('en-us', { year:"numeric", month:"short", day:"numeric"}) 
    			document.write("<b style=''> Updated: " + myDate +"</b>");
            </script>
		</div>
	</div> <!-- end flex-container -->
</div> <!-- End Banner -->
<br>
<div class="index"> <!-- Changed from div on 2019-10-01 -->
	<a id="index"></a>
	<h3>Code Index</h3>
	
	 <nav class="topics">
        <a href="#php">PHP</a><br>
		<a href="#javascript">Javascript</a><br>
		<a href="#css">Style Sheets</a><br>
     </nav> <!-- End topics for topic index -->
	 <br>
	 <h3>PHP Code Index</h3>

<div class="php">	 
    <a id="php"></a>
	 <nav class="topics">
        <a href="#addemailtostations">addEmailToStations.php</a><br>
        <a href="#adifreadlog">ADIFreadLog.php</a><br>
        <a href="#buildclosinglisting">buildClosingListing.php</a><br>
        <a href="#builddwtt">buildDWtt.php</a><br>
        <a href="#buildeventdb">buildEventListing.php</a><br>
        <a href="#buildevents">buildEvents.php</a><br>
        <a href="#buildfacilitydropdown">buildFacilityDropDown.php</a><br>
        
        <a href="#buildfsqheardlist">buildFSQHeardList.php</a><br>
        <a href="#buildgrouplist">buildGroupList.php</a><br>
        <a href="#buildheardlist">buildHeardList.php</a><br>
        <a href="#buildnewgroup">BuildNewGroup.php</a><br>
        <a href="#buildoptionsforselect">buildOptionsForSelect.php</a><br>
        <a href="#buildourfrequencies">buildourFrequencies.php</a><br>
        <a href="#buildpoi">buildPoi.php</a><br>
        
        <a href="#buildpreamblelisting">buildPreambleListing.php</a><br>
        <a href="#buildrightcorner">buildRightCorner.php</a><br>
        <a href="#buildstationstable">buildStationsTable.php</a><br>
        <a href="#buildsubnetcandidates">buildSubNetCandidates.php</a><br>      
        <a href="#buildthreedropdowns">buildThreeDropdowns.php</a><br>
        <a href="#builduniquecalllist">buildUniqueCallList.php</a><br>
        <a href="#buildupperrightcorner">buildUpperRightCorner.php</a><br>
        
        <a href="#buttonbar">buttonBar.php</a><br>
        <a href="#checkfornewcall">checkForNewCall.php</a><br>
        <a href="#checkin">checkin.php</a><br>
        <a href="#checksection">checkSection.php</a><br>
        <a href="#classlist">classList.php</a><br>
        <a href="#clear_all_tactical">Clear_All_Tactical.php</a><br>
        <a href="#clonepb">closePB.php</a><br>
        
        <a href="#closelog">closeLog.php</a><br>
        <a href="#colcolorassign">colColorAssign.php</a><br>
        <a href="#column_info">column_info.html</a><br>
        <a href="#columnpicker">columnPicker.php</a><br>
        <a href="#config">config.php</a><br>
        <a href="#converttopb">convertToPB.php</a><br>
        
        <a href="#cool-ont-graphics">cool-Font-Graphics.html</a><br>
        <a href="#csvfromnetlog">CSVfromNetLog.php</a><br>
        <a href="#dbconnectdtls">dbConnectDtls.php</a><br>
        <a href="#delete-row">delete-row.php</a><br>
        <a href="#deleteevent">deleteEvent.php</a><br>
        <a href="#dropdowns">dropdowns.php</a><br>
        <a href="#editfccandstations">editFCCandStations.php</a><br>
        
        <a href="#editstationstable">editStationsTable.php</a><br>
        <a href="#env_setup">ENV_SETUP.php</a><br>
        <a href="#fcc_lookup">fcc_lookup.php</a><br>
        <a href="#fielddayreport">fielddayReport.php</a><br>
        <a href="#findreports">findReports.php</a><br>
        <a href="#fixhome">fixHome.php</a><br>
        <a href="#fixlatlongrid">fixLatLonGrid.php</a><br>
        
        <a href="#fixstationwithfcc">fixStationWithFCC.php</a><br>
        <a href="#geocode">geocode.php</a><br>
        <a href="#Geocoder">Geocoder.php</a><br>
        <a href="#getactivities">getactivities.php</a><br>
        <a href="#getcallhistory">getCallHistory.php</a><br>
        <a href="#getcallorderbynet">getCallOrderByNet.php</a><br>
        <a href="#getcenterfromdegrees">getCenterFromDegrees.php</a><br>
        
        <a href="#getcookie">getCookie.php</a><br>
        <a href="#getcrossroads">getCrossRoads.php</a><br>
        <a href="#getdata4dashboard">getData4Dashboard.php</a><br>
        <a href="#getdistancewlatlon">getDistanceWlatlon.php</a><br>
        <a href="#getDXstationInfo">getDXstationInfo.php</a><br>
        <a href="#getfccrecord">getFCCrecord.php</a><br>
        <a href="#getgencomments">getGenComments.php</a><br>
        
        <a href="#getgridcounts">getGridCounts.php</a><br>
        <a href="#getgridlatlnglname">getGridLatLngLname.php</a><br>
        <a href="#gethint">gething.php</a><br>
        <a href="#gethintname">gethintName.php</a><br>
        <a href="#gethingsuspects">gethintSuspects.php</a><br>
        <a href="#getjsonrecord">getJSONrecord.php</a><br>
        <a href="#getkind">getkind.php</a><br>
        
        <a href="#getlatlonfromgrid">getLatLonFromGrid.php</a><br>
        <a href="#getlistoffacilities">getListOfFacilities.php</a><br>
        <a href="#getncmxml">getNCMXML.php</a><br>
        <a href="#getnetemails">getNetEmails.php</a><br>
        <a href="#getnewwx">getNewWX.php</a><br>
        <a href="#getopennets">getOpenNets.php</a><br>
        <a href="#getqrz">getQRZ.php</a><br>
        
        <a href="#getrealipaddr">getRealIpAddr.php</a><br>
        <a href="#getstationics-214a">getStationICS-214A.php</a><br>
        <a href="#getstationtimeline">getStationTimeLine.php</a><br>
        <a href="#getsubnet">getsubnets.php</a><br>
        <a href="#gettimelog">getTimeLog.php</a><br>
        <a href="#getwx">getWX.php</a><br>
        <a href="#googlecharts">googleCharts.php</a><br>
        
        <a href="#graph_attendance">graph_attendance.php</a><br>
        <a href="#graph_by_years">graph_by_years.php</a><br>
        <a href="#graphanet_ploty">graphAnet_Ploty.php</a><br>
        <a href="#gridmap">gridmap.php</a><br>
        <a href="#gridsquare">GridSquare.php</a><br>
        <a href="#groupscorecard">groupScoreCard.php</a><br>
        <a href="#hamnets">hamnets.php</a><br>
        
        <a href="#headerdefinitions">headerDefinitions.php</a><br>
        <a href="#heart">heart.php</a><br>
        <a href="#help">help.php</a><br>
        <a href="#helphtml">help.html</a><br>
        <a href="#help-code">help-code.php</a><br>
        <a href="#hztimeline">HzTimeline.php</a><br>
        <a href="#ics205a">ics205A.php</a><br>
        
        <a href="#ics214">ics214.php</a><br>
        <a href="#ics309">ics309.php</a><br>
        <a href="#index">index.php</a><br>
        <a href="#inserttostations">insertToStations.php</a><br>
        <a href="#joinedbullets">joinedbullets.php</a><br>
        <a href="#latlongdistance">latlongdistance.php</a><br>
        <a href="#listallpois">listAllPOIs.php</a><br>
        
        <a href="#listnets">listNets.php</a><br>
        <a href="#map">map.php</a><br>
        <a href="#map4743pagesource">map4743pagesource.php</a><br>
        <a href="#metaedits">metaEdits.php</a><br>
        <a href="#multilevel">multilevel.html</a><br>
        <a href="#ncmapi">NCMapi.php</a><br>
        <a href="#ncmmaps">NCMMaps.php</a><br>
        
        <a href="#ncmreports">NCMreports.php</a><br>
        <a href="#ncmreportsbuilder">NCMreportsBuilder.php</a><br>
        <a href="#ncmstats">NCMStats.php</a><br>
        <a href="#ncmstatstt">NCMstatsTT.php</a><br>
        <a href="#netcsvdump">netCSVdump.php</a><br>
        <a href="#netXMLdump">netXMLdump.php</a><br>
        <a href="#newnet">newNet.php</a><br>
        
        <a href="#newnetopts">newnetOPTS.php</a><br>
        <a href="#objmarkers">objMarkers.php</a><br>
        <a href="#pblist">PBList.php</a><br>
        <a href="#phpgraph">phpGraph.php</a><br>
        <a href="#pio_news">PIO_News.php</a><br>
        <a href="#plotting_examples">plotting_examples.php</a><br>
        <a href="#poimarkers">poiMarkers.php</a><br>
        
        <a href="#prebuild">preBuild.php</a><br>
        <a href="#printbynetid">printByNetID.php</a><br>
        <a href="#rebuildKind">rebuildKind.php</a><br>
        <a href="#rightclickact">rightClickACT.php</a><br>
        <a href="#rightclickdistrict">rightClickDistrict.php</a><br>
        <a href="#rightclickonsite">rightClickOnSite.php</a><br>
        <a href="#rightclicktrafic">rightClickTraffic.php</a><br>
        
        <a href="#rightclickundotimeout">rightclickundotimeout.php</a><br>
        <a href="#rowdefinitions">rowDeinitions.php</a><br>
        <a href="#save">save.php</a><br>
        <a href="#savefinuupdate">saveFinduUpdate.php</a><br>
        <a href="#savegencomm">SaveGenComm.php</a><br>
        <a href="#savekind">saveKind.php</a><br>
        <a href="#savetimeout">saveTimeOut.php</a><br>
        
        <a href="#speechbubbles">speechBubbles.php</a><br>
        <a href="#stationmarkers">stationMarkers.php</a><br>
        <a href="#stationrollcallbynet">StationRollCallByNet.php</a><br>
        <a href="#stationsave">stationsave.php</a><br>
        <a href="#str_replace_first">str_replace_first.php</a><br>
        <a href="#tablehead">tableHead.html</a><br>
        <a href="#time">time.php</a><br>
        
        <a href="#timelinesearch">timeLineSearch.php</a><br>
        <a href="#timezone">timezone.php</a><br>
        <a href="#updatecorner">updateCorner.php</a><br>
        <a href="#updategrid">updateGRID.php</a><br>
        <a href="#updatelatlon">updateLATLON.php</a><br>
        <a href="#updatelatlonw3w">updateLATLONw3w.php</a><br>
        <a href="#updatestationlocation">updateStationLocation.php</a><br>
        
        <a href="#updatestationlocationwithw3w">updateStationLocationWithW3W.php</a><br>
        <a href="#updatestationinfo">updateStationInfo.php</a><br>
        <a href="#updatetod">updateTOD.php</a><br>
        <a href="#vtimeline">VTimeLine.php</a><br>
        <a href="#w3w">w3w.html</a><br>
        <a href="#wx">wx.php</a><br>
        <a href="#wx2">wx2.php</a><br>
        
        <a href="#wxdisplay">WXdisplay.php</a><br>
        <a href="#wxll2">wxLL2.php.php</a><br>
        <a href="#wxll2withcity">wxLL2WithCity.php</a><br>
        
	 </nav>
<div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>
<div class="javascript">	 
<a id="javascript"></a>
	 <h3>Javascript Code Index</h3>
	 
	 <nav class="topics">
        <a href="#celleditfunctions">CellEditFunctions.js</a><br>
        <a href="#celleditfunctionStations">CellEditFunctionStations.js</a><br>
        <a href="#circlekoords">circleKoords.js</a><br>
        <a href="#control.w3w">control.w3w.js</a><br>
        <a href="#convertdms">convertDMS.js</a><br>
        <a href="#cookiemanagement">cookieManagement.js</a><br>
        <a href="#getcenterfromdegrees">getCenterFromDegrees.js</a><br>
        
        <a href="#getnetid.w3w">getNetID.js</a><br>
        <a href="#grid">grid.js</a><br>
        <a href="#gridsquare">gridsquare.js</a><br>
        <a href="#gridtokoords">gridtocoords.js</a><br>
        <a href="#hamgridsquare">hamgridsquare.js</a><br>
        <a href="#latlongdistance">latlongdistance.js</a><br>
        <a href="#leaflet_numbered_markers">leaflet_numbered_markers.js</a><br>
        
        <a href="#netmanager-p2">NetManager-p2.js</a><br>
        <a href="#netmanager">NetManager.js</a><br>
        <a href="#sorttable">sortTable.js</a><br>
        <a href="#table2csv.min">table2csv.min.js</a><br>
        <a href="#timepicker">timepicker.js</a><br>
        <a href="#w3wdata">w3wdata.js</a><br>
   
        
     </nav>
<div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>
<div class="css">
    <a id="css"></a>
      <h3>CSS Code Index</h3>
	 
	 <nav class="css">
        <a href="#bubbles">bubbles.css</a><br>
        <a href="#closing">closing.css</a><br>
        <a href="#commplan">commplan.css</a><br>
        <a href="#events">events.css</a><br>
        <a href="#eventsbuild">eventsBuild.css</a><br>
        <a href="#help">help.css</a><br>
        <a href="#ics205">ics205.css</a><br>
        
        <a href="#ics214">ics214.css</a><br>
        <a href="#ics309">ics309.css</a><br>
        <a href="#listnets">listNets.css</a><br>
        <a href="#maps">maps.css</a><br>
        <a href="#meccstyle">MeccStyle.css</a><br>
        <a href="#ncmstyle">NCMstyle.css</a><br>
        <a href="#netmanager-media">NetManager-media.css</a><br>
        
        <a href="#netmanager">NetManager.css</a><br>
        <a href="#preamble">preamble.css</a><br>
        <a href="#prebuild">preBuild.css</a><br>
        <a href="#print">print.css</a><br>
        <a href="#printbynetid">printbyNetID.css</a><br>
        <a href="#tabs">tabs.css</a><br>
        <a href="#timelinejs-local">timelineJS-local.css</a><br>
        
	 </nav>
<div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>

<hr>

<div class="addemailtostations">
    <a id="addemailtostations"></a>
    <h3>addMailToStations.php</h3>
    <p>This program adds the email address given by someone who forgets to close a net, the next time he opens a net.
        <br>
        Not currently in use by NCM.
    </p>
</div>

<hr>

<div class="adifreadlog">
    <a id="adifreadlog"></a>
    <h3>ADIFreadLog.php</h3>
    <p>Not currently in use by NCM.
    </p>
</div>

<hr>

<div class="adiftomysql">
    <a id="adiftomysql"></a>
    <h3>ADIFtoMySQL.php</h3>
    <p>Not currently in use by NCM.
    </p>
</div>

<hr>

<div class="buildclosinglisting">
    <a id="buildclosinglisting"></a>
    <h3>buildClosingListing.php</h3>
    <p>Used/Called in:
        <ul>
            <li>NetManager-p2.js</li>
            <li>NetManager.js</li>
        </ul>
    </p>
</div>

<hr>

<div class="builddwtt">
    <a id="builddwtt"></a>
    <h3>buildDWtt.php</h3>
    <p>Used/Called in:
        <ul>
            <li>NetManager-p2.js</li>
        </ul>
        Purpose: Build an APRStt config file from the current net.
    </p>
</div>

<hr>

<div class="buildeventdb">
    <a id="buildeventdb"></a>
    <h3>buildEventDB.php</h3>
    <p>Used/Called in:
        <ul>
            <li>buildEvents.php</li>
        </ul>
        Purpose: Helps build a new event listing.
    </p>
</div>

<hr>

<div class="buildeventlisting">
    <a id="buildeventlisting"></a>
    <h3>buildEventListing.php</h3>
    <p>Used/Called in:
        <ul>
            <li>NetManager-p2.js</li>
            <li>NetManager.js</li>
        </ul>
        Purpose: Helps build a new event listing.
    </p>
</div>

<hr>

<div class="buildevents">
    <a id="buildevents"></a>
    <h3>buildEvents.php</h3>
    <p>Used/Called in:
        <ul>
            <li>NetManager.js</li>
            <li>buildClosingListing.php</li>
            <li>buildEventListing.php</li>
            <li>index.php</li>
            <li>buildourFrequencies.php</li>
            <li>buildPreambleListing.php</li>
        </ul>
        Purpose: Helps build a new event listing.
    </p>
</div>

<hr>

<div class="buildfacilitydropdown">
    <a id="buildfacilitydropdown"></a>
    <h3>buildFacilityDropDown.php</h3>
    <p>Used/Called in:
        <ul>
            <li>NetManager.js</li>
            <li>buildClosingListing.php</li>
            <li>buildEventListing.php</li>
            <li>index.php</li>
            <li>buildourFrequencies.php</li>
            <li>buildPreambleListing.php</li>
        </ul>
        Purpose: Helps build a new facility listing.
    </p>
</div>

<hr>

<hr><hr><hr>
<p style="page-break-before: always"></p>
<div class="title">
		<p>Net	</p>
		<p>Control 
		<p>Manager</p>
</div> <!-- End title -->

<hr>


<div class="theend">
    <a id="theend"></a>
    <div>
<p>&copy; Copyright 2015-<?php echo date("Y");?>, by Keith D. Kaiser, WA0TJT <br>
Written by: Keith D. Kaiser, WA0TJT with the invaluable assistance, understanding and love of Deb Kaiser, W0DLK. <br>
Additonal Authors, advisers, resources and mentors include: Jeremy Geeo (KD0EAV) who is also our server host, Sila Kissuu (AK0SK), Nicolas Carpi for his jeditable, Mathew Bishop (KF0CJM), Louis Gamor, Members of Kansas City Northland ARES, The Platte County Amateur Radio Group, and the many members of <a href="https://stackoverflow.com" target="_blank"> Stack Overflow.</a>
</p>
    </div>
    
<span  style="text-align: center; display: inline-block; vertical-align: middle;">

        <img src="BRKMarkers/plum_man.svg" alt="plum_man" style="float:left; padding: 0px; border: 0;" />

    Map Markers courtesy of Bridget R. Kaiser

        <img src="BRKMarkers/plum_flag.svg" alt="plum_flag" style="float:right; padding: 0px; border: 0;" />

</span>

<p>
<div>
 <img src="images/backgroundantenna328x72.png"  alt="backgroundantenna328x72" width="250" >
    International (DX) station information compliments of Daniel Bateman, KK4FOS with Buckmaster International, LLC
</div>
</p>
<p> 
Guarantees or Warranties:<br>
     No Guarantees or Warranties. EXCEPT AS EXPRESSLY PROVIDED IN THIS AGREEMENT, NO PARTY MAKES ANY GUARANTEES OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WHETHER ARISING BY OPERATION OF LAW OR OTHERWISE. PROVIDER SPECIFICALLY DISCLAIMS ANY IMPLIED WARRANTY OF MERCHANTABILITY AND/OR ANY IMPLIED WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE. 
</p>
<div class="classictemplate template" style="display: block;"></div>

<div id="groupsio_embed_signup2">
<form action="https://groups.io/g/NCM/signup?u=5681121157766229570" method="post" id="groupsio-embedded-subscribe-form2" name="groupsio-embedded-subscribe-form" target="_blank">
    <div id="groupsio_embed_signup_scroll2">
      <label for="email" id="templateformtitle">Subscribe to the NCM groups.io! </label>
      <input type="email" value="" name="email" class="email" id="email" placeholder="email address" required="">
    
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5681121157766229570" tabindex="-1" value=""></div>
    <div id="templatearchives"></div>
    <input type="submit" value="Subscribe" name="subscribe" id="groupsio-embedded-subscribe" class="button">
    <br><br>
  </div>
</form>
</div>
</div> <!-- End theend -->

<div title="Knowing where you can find something is, after all, the most important part of learning"><I style="color:blue;">Scire ubi aliquid invenire possis ea demum maxima pars eruditionis est,</I>
    <br><br>
</div>

<a class="gotoindex" href="#index">Back to the Index</a>
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
        

function printfunction() {
	window.print();
}

</script> <!-- The scrollFunction to move to the top of the page -->

</body>
</html>