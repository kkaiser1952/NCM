<!doctype html>
<?php 
	require_once "NCMStats.php";			
?>

<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->

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
	
</head>
<body>
	
<div id="banner">
    
 <!--   <img id="smtitle" src="images/NCM.png" alt="NCM" > -->

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
	<h3><a href="help.php" >The Program Index</a></h3>
	<h3>Code Index</h3>
	
	 <nav class="topics">
        <a href="#php">PHP & HTML</a><br>
		<a href="#javascript">Javascript</a><br>
		<a href="#css">Style Sheets</a><br>
     </nav> <!-- End topics for topic index -->
	 <br>
	 <div class="javascript">	 
<a id="javascript"></a>
	 <h3>Javascript Code Index</h3>
	 
	 <nav class="topics">
        <a href="#CellEditFunctions">CellEditFunctions.js</a><br>
        <a href="#celleditfunctionStations">CellEditFunctionStations.js</a><br>
        <a href="#circlekoords">circleKoords.js</a><br>
        <a href="#control.w3w">control.w3w.js</a><br>
        <a href="#convertdms">convertDMS.js</a><br>
        <a href="#cookiemanagement">cookieManagement.js</a><br>
        <a href="#getcenterfromdegrees">getCenterFromDegrees.js</a><br>
        
        <a href="#getnetid">getNetID.js</a><br>
        <a href="#grid">grid.js</a><br>
        <a href="#gridsquare">gridsquare.js</a><br>
        <a href="#gridtokoords">gridtocoords.js</a><br>
        <a href="#hamgridsquare">hamgridsquare.js</a><br>
        <a href="#latlongdistance">latlongdistance.js</a><br>
        <a href="#leaflet_numbered_markers">leaflet_numbered_markers.js</a><br>
        
        <a href="#netmanager">NetManager.js</a><br>
        <a href="#netmanager-p2">NetManager-p2.js</a><br>  
        <a href="#sorttable">sortTable.js</a><br>
        <a href="#table2csv.min">table2csv.min.js</a><br>
        <a href="#timepicker">timepicker.js</a><br>
        <a href="#w3wdata">w3wdata.js</a><br>     
     </nav>
<div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
<hr>

<div class="CellEditFunctions">
    <a id="CellEditFunctions"></a>
    <h3>CellEditFunctions.js</h3>
    <p>This program allows editing of most of the columns and genComm they include:
        <nav class="topics2">
        <a>.editGComms (General Comments)</a><br>
        <a>.c13/.editTimeOut (Time Out & Time on Duty)</a><br>
        <a>.c12/.editTimeIn (Time In & Time on Duty)</a><br>
        <a>.cs1/.c6/.editCS1 (Call Sign)</a><br>
        <a>.c16/.editable (Timeonduty)
        
        <a>.c7/.editFnm (First Name)</a><br>
        <a>.c34/.editonSite (onSite)</a><br>
        <a>.c9/.editTAC (Tactical Call)</a><br>
        <a>.c10/.editPhone (Phone Number)</a><br>
        <a>.c8/.editLnm (Last Name)</a><br>
        
        <a>.c11/.editEMAIL (Email)</a><br>
        <a>.c15/.editCREDS (Credentials)</a><br>
        <a>.c17/.editcnty (County)</a><br>
        <a>.c18/.editstate (State)</a><br>
        <a>.c32/.editntry (Country)</a><br>
        
        <a>.c59/.editdist (District)</a><br>
        <a>.c24/.W3W (What3Words)</a><br>
        <a>.c20/.editGRID (Grid)</a><br>
        <a>.c21/.editLAT (Latitude & Grid)</a><br>
        <a>.c22/.editLON (Longitude & Grid)</a><br>
        
        <a>.c31/.editaprs_call (APRS Call Sign)</a><br>
        <a>.c30/.editteam (Team)</a><br>
        <a>.c5/.editTT (tt value)</a><br>
        <a>.editCAT (Traffic For)</a><br>
        <a>.c51/.editSec (Field Day )</a><br>
        
        <a>.c14/.editC (Comments)</a><br>
        <a>.c3/.editable_selectACT (Status)</a><br>
        <a>.c4/.editable_selectTFC (Traffic)</a><br>
        <a>.c2/.edit_selectMode (Mode)</a><br>
        <a>.c1/.editable_selectNC (Netcontrol aka Role)</a><br>
        
        <a>.c28 (??)</a><br>
        <a>.c33/.editfacility (Facility)</a><br>
        <a>.c23/.editable_editBand (Band)</a><br>
        <a>.c52/.editable (TRFK-FOR)</a><br>
        <a>.c25/.editable (recordID)</a><br>
            
        <a>.c26/.editable (id)</a><br>
        <a>.c27/.editable (status)</a><br>
        <a>.c28/.editable (home)</a><br>
        <a>.c29/.editable (ipaddress)</a><br>
       
       
        </nav>
        
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="celleditfunctionStations">
    <a id="celleditfunctionStations"></a>
    <h3>celleditfunctionStations.js</h3>
    <p>This program allows editing of most of the columns it includes:
        <nav class="topics2">
            <a>.editFnm (First Name)</a><br>  
            <a>.editTAC (Tactical Call)</a><br>
            <a>..editPhone (Phone Number)</a><br>
            <a>.editLnm (Last Name)</a><br>
            
            <a>.editEMAIL (Email)</a><br>
            <a>.editCREDS (Credentials)</a><br>
            <a>.c17/.editcnty (County)</a><br>
            <a>.c18/.editstate (State)</a><br>
            <a>.editdist (District)</a><br>
            
            <a>.editGRID (Grid)</a><br>
            <a>.editLAT (Latitude & Grid)</a><br>
            <a>.editLON (Longitude & Grid)</a><br>
        </nav>
        
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="circlekoords">
    <a id="circlekoords"></a>
    <h3>circlekoords.js</h3>
    <p>This program calculates the number of and distance between circles around the clicked point on the map.

    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="control.w3w">
    <a id="control.w3w"></a>
    <h3>control.w3w.js</h3>
    <p>This program comes from W3W

    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="convertdms">
    <a id="convertdms"></a>
    <h3>convertdms.js</h3>
    <p>Function: convertDMS(lat, lng)
        <br>Converts decimal to degrees, minutes, seconds

    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="cookiemanagement">
    <a id="cookiemanagement"></a>
    <h3>cookiemanagement.js</h3>
    <p>Functions: 
        <a href="clearFacilityCookie">clearFacilityCookie()</a><br>
        <a href="showFacilityColumn">showFacilityColumn()</a><br>
        <a href="setCookie">setCookie(cname, cvalue, exdays, SameSite)</a><br>
        <a href="getCookie">getCookie(cname)</a><br>
        <a href="eraseCookie">eraseCookie(cookieName)</a><br>
        <a href="getCurrent">getCurrent()</a><br>
        <a href="showChecked">showChecked(sh)</a><br>
        <a href="calculate">calculate()</a><br>
        <a href="testCookies">testCookies(nc)</a><br>
        <a href="showCol">showCol(sh)</a><br>

    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="getcenterfromdegrees">
    <a id="getcenterfromdegrees"></a>
    <h3>getcenterfromdegrees.js</h3>
    <p>Functions: <br>
        <a href="GetCenterFromDegrees">GetCenterFromDegrees(data)</a><br>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="getNetID">
    <a id="getNetID"></a>
    <h3>getNetID.js</h3>
    <p>Functions: <br>
        <a href="function">function()</a><br>
        <a href="initMyBookmarklet">initMyBookmarklet()</a><br>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>


<hr>

<div class="grid">
    <a id="grid"></a>
    <h3>grid.js</h3>
    <p>Functions: <br>
        <a href="grid">grid(gs)</a><br>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="gridsquare">
    <a id="gridsquare"></a>
    <h3>gridsquare.js</h3>
    <p>Functions: <br>
        <a href="gridsquare">gridsquare()</a><br>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="gridtokoords">
    <a id="gridtokoords"></a>
    <h3>gridtokoords.js</h3>
    <p>Functions: <br>
        <a href="subdivisor">subdivisor()</a><br>
        <a href="parse_digit">parse_digit(digit)</a><br>
        <a href="get_grid_square">get_grid_square(grid_square_id)</a><br>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="hamgridsquare">
    <a id="hamgridsquare"></a>
    <h3>hamgridsquare.js</h3>
    <p>Functions: <br>
        <a href="latLonToGridSquare">latLonToGridSquare(param1,param2)</a><br>
        <a href="gridSquareToLatLon">gridSquareToLatLon(grid, obj)</a><br>
        <a href="testGridSquare">testGridSquare()</a><br>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="latlongdistance">
    <a id="latlongdistance"></a>
    <h3>latlongdistance.js</h3>
    <p>Functions: <br>
        <a href="distance">distance(lat1, lon1, lat2, lon2, unit)</a><br>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>

<div class="leaflet_numbered_markers">
    <a id="leaflet_numbered_markers"></a>
    <h3>leaflet_numbered_markers.js</h3>
    <p>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>

<hr>
<div class="netmanager">
    <a id="netmanager"></a>
    <h3>NetManager.js</h3>
    <p>Functions: <br>
        <nav class="topics2">
        <a href="mapwhat3words">mapWhat3Words(w3w)</a><br>
        <a href="mapgridsquare">MapGridsquare(koords2)</a><br>
        <a href="mapcounty">MapCounty(cntyst2)</a><br>
        
        <a href="whatIstt">whatIstt()</a><br>
        <a href="setDfltMode">setDfltMode()</a><br>
        <a href="CallHistoryForWho">CallHistoryForWho()</a><br>
        
        <a href="getCallHistory">getCallHistory()</a><br>
        <a href="rightclickundotimeout">rightclickundotimeout()</a><br>
        <a href="pre">pre()</a><br>
        
        <a href="isKeyPressed">isKeyPressed(event)</a><br>
        <a href="getDomain">getDomain()</a><br>
        <a href="openPreamble">openPreamble()</a><br>
        
        <a href="openClosing">openClosing()</a><br>
        <a href="openAgenda">openAgenda()</a><br>
        <a href="hideit">hideit()</a><br>
        
        <a href="showit">showit()</a><br>
        <a href="showSubNets">showSubNets(str)</a><br>
        <a href="timelineBut2">timelineBut2.hide(500)</a><br>
        
        <a href="closelog">closelog.click(function()</a><br>
        <a href="graphtimeline">graphtimeline()</a><br>
        <a href="ics214button">ics214button()</a><br>
        
        <a href="ics309button">ics309button())</a><br>
        <a href="ics205Abutton">ics205Abutton()</a><br>
        <a href="map1">map1()</a><br>
        
        <a href="map2">map2()</a><br>
        <a href="printByNetID">printByNetID()</a><br>
        <a href="editGComms">editGComms.on("click", function()</a><br>
         
        <a href="empty">empty(thisID)</a><br>
        <a href="TimeLine">TimeLine()</a><br>
        <a href="timelinesearch">timelinesearch()</a><br>
         
        <a href="RefreshTimeLine">RefreshTimeLine()</a><br>
        <a href="HideTimeLine">HideTimeLine()</a><br>
        <a href="showActivities">showActivities(str, str2)</a><br>
         
        <a href="showHint">showHint(str)</a><br>
        <a href="nameHint">nameHint(str)</a><br>
        <a href="set_cs1">set_cs1(item)</a><br>
         
        <a href="set_Fname">set_Fname(item)</a><br>
        <a href="set_hidden">set_hidden(str)</a><br>
        <a href="set_hidestuff">set_hidestuff(item)</a><br>
         
        <a href="loadsorttable">loadsorttable()</a><br>
        <a href="selectDomain">selectDomain(thisdom)</a><br>
        <a href="AprsFiMap">AprsFiMap()</a><br>
         
        <a href="RefreshGenComm">RefreshGenComm()</a><br>
        <a href="ready(function">ready(function ()</a><br>
        <a href="refresh">refresh()</a><br>
         
        <a href="refbutton">refbutton').click(function()</a><br>
        <a href="showColumns">showColumns()</a><br>
        <a href="goLocal">goLocal()</a><br>
         
        <a href="goUTC">goUTC()</a><br>
        </nav>
    </p>
    <p>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>

<hr>

<div class="netmanager-p2">
    <a id="netmanager-p2"></a>
    <h3>NetManager-p2.js</h3>
    <p>Functions: <br>
        <nav class="topics2">
        <a href="stuffatthetop">see const at the top</a><br>
        <a href="doubleClickComments">doubleClickComments(rID, cs1, netID)</a><br>
        <a href="doubleClickCall">doubleClickCall(rID, cs1, netID)</a><br>
        
        <a href="whoAreYou">whoAreYou()</a><br>
        <a href="openW3W">openW3W()</a><br>
        <a href="showDTTM">showDTTM()</a><br>
        
        <a href="setInterval">setInterval('showDTTM()', 1000)</a><br>
        <a href="newNet">newNet(str)</a><br>
        <a href="hideCloseButton">hideCloseButton(pb)</a><br>
        
        <a href="checkIn">checkIn()</a><br>
        <a href="fillFreqs">fillFreqs()</a><br>
        <a href="fillURC">fillURC()</a><br>
        
        <a href="remember-selection">remember-selection').each(function(r)</a><br>
        <a href="switchClosed">switchClosed()</a><br>
        <a href="filterSelectOptions">filterSelectOptions(selectElement, attributeName, attributeValue)</a><br>
        
        <a href="netcall">netcall change function()</a><br>
        <a href="fillFreqs">fillFreqs()</a><br>
        <a href="netGroup">netGroup change function()</a><br>
         
        <a href="fillaclone">fillaclone()</a><br>
        <a href="doalert">doalert(checkboxElem)</a><br>
        <a href="openPreamblePopup">openPreamblePopup()</a><br>
         
        <a href="openEventPopup">openEventPopup()</a><br>
        <a href="openClosingPopup">openClosingPopup()</a><br>
        <a href="buildDWtt">buildDWtt()</a><br>
         
        <a href="openColumnPopup">openColumnPopup()</a><br>
        <a href="convertToPB">convertToPB()</a><br>
        <a href="heardlist">heardlist()</a><br>
         
        <a href="buildFSQHeardList">buildFSQHeardList()</a><br>
        <a href="buildCallHistoryByNetCall">buildCallHistoryByNetCall()</a><br>
        <a href="buildRightCorner">buildRightCorner()</a><br>
         
        <a href="scrollFunction">scrollFunction()</a><br>
        <a href="topFunction">topFunction()</a><br>
        <a href="Clear_All_Tactical">Clear_All_Tactical()</a><br>
         
        <a href="filterFunction">filterFunction(x)</a><br>
        <a href="putInGroupInput">putInGroupInput(pidi)</a><br>
        <a href="putInKindInput">putInKindInput(pidi)</a><br>
         
        <a href="putInFreqInput">putInFreqInput(pidi)</a><br>
        <a href="showGroupChoices">showGroupChoices()</a><br>
        <a href="showKindChoices">showKindChoices()</a><br>
         
        <a href="showFreqChoices">showFreqChoices()</a><br>
        <a href="blurGroupChoices">blurGroupChoices()</a><br>
        <a href="blurKindChoices">blurKindChoices()</a><br>
         
        <a href="blurFreqChoices">blurFreqChoices()</a><br>
        <a href="custom_setup">custom_setup()</a><br>
        <a href="checkFD">checkFD()</a><br>
         
        <a href="net_by_number">net_by_number()</a><br>
        <a href="dl">dl click(function()</a><br>
        <a href="thisNet">thisNet").table2csv('download', options)</a><br>
         
        <a href="toCVS">toCVS()</a><br>
        <a href="sendEMAIL">sendEMAIL(adr,netid)</a><br>
        <a href="sendGroupEMAIL">sendGroupEMAIL()</a><br>
         
        <a href="stationTimeLineList">stationTimeLineList(info)</a><br>
        <a href="rightClickTraffic">rightClickTraffic(recordID)</a><br>
        <a href="rightClickOnSite">rightClickOnSite(recordID)</a><br>
         
        <a href="rightClickDistrict">rightClickDistrict(str)</a><br>
        <a href="rightClickACT">rightClickACT(recordID)</a><br>
        <a href="newWX">newWX()</a><br>
        
        <a href="tbb">tbb click(function()</a><br>
        
        </nav>
    <p>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>

</div>


<hr>
<div class="sorttable">
    <a id="sorttable"></a>
    <h3>sortTable.js</h3>
    <p>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>

<hr>
<div class="table2csv.min">
    <a id="table2csv.min"></a>
    <h3>table2csv.min.js</h3>
    <p>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>

<hr>
<div class="timeicker">
    <a id="timeicker"></a>
    <h3>timeicker.js</h3>
    <p>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>

<hr>
<div class="w3wdata">
    <a id="w3wdata"></a>
    <h3>w3wdata.js</h3>
    <p>
    </p>
    <div>
    <a class="gotoindex" href="#index"><br>Back to the Index</a>
</div>
<br>
</div>

<!-- End of javascript code indes -->


<hr>
	 <h3>PHP/HTML Code Index</h3>

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
        <a href="#gethint">gethint.php</a><br>
        <a href="#gethintname">gethintName.php</a><br>
        <a href="#gethintsuspects">gethintSuspects.php</a><br>
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
            <li></li>
        </ul>
        Purpose: Creates a dropdown list of all facility entries in the DB.<br>
        Future Development: Not currently part of any other program in NCM.
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

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167869985-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167869985-1');
</script>

</body>
</html>