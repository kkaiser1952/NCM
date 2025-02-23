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
</div>