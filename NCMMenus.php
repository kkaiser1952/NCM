<?php
/**
 * NCM Menu System - Upper Right Corner Menu Structure
 * Contains all menu-related structures that appear in the upper right corner of NCM
 */

class NCMMenus {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    } // End of __construct function
    
    public function renderUpperRightCorner() {
        return <<<HTML
        <div id="rightCorner">    
            <div id="upperRightCorner" class="upperRightCorner"></div> <!-- Filled by buildUpperRightCorner.php -->
            <div id="theMenu" class="theMenu">
                <!-- Legacy ID 'ourfreqs' maintained for compatibility with existing codebase. 
                     Use 'upperRightMenu' class for new development. -->
                <table id="ourfreqs" class="upperRightMenu">
                    <tbody>
                        <tr class="trFREQS">
                            <td class="nobg2">
                                <!-- Core Menu Items -->
                                <a id="preambledev" onclick="openPreamblePopup();" title="Click for the preamble">Preamble &nbsp;||&nbsp;</a>
                                <a id="agendadiv" onclick="openEventPopup()" title="Click for the agenda">Agenda &nbsp;||&nbsp;</a>
                                <a href="buildEvents.php" target="_blank" rel="noopener" title="Create new preamble/agenda" class="colorRed">New </a>&nbsp;||&nbsp;
                                <a id="closingdev" onclick="openClosingPopup()" title="Click for the closing script">Closing &nbsp;||&nbsp;</a>
                                
                                <!-- Reports Dropdown -->
                                {$this->renderReportsDropdown()}
                                
                                <!-- Help Link -->
                                <a id="helpdev" href="https://net-control.us/help.php" target="_blank" rel="noopener" title="Extended help">Help</a>&nbsp;||&nbsp;
                                
                                <!-- Three-bar (hamburger) menu -->
                                <a href="#menu" id="bar-menu" class="gradient-menu"></a>
                                
                                <!-- Additional Options Menu -->
                                {$this->renderAdditionalOptions()}
                            </td> <!-- End of nobg2 td -->
                        </tr> <!-- End of trFREQS row -->
                    </tbody>
                </table> <!-- End of ourfreqs/upperRightMenu table -->
            </div> <!-- End of theMenu div -->
        </div> <!-- End of rightCorner div -->
HTML;
    } // End of renderUpperRightCorner function
    
    private function renderReportsDropdown() {
        return <<<HTML
        <span class="dropdown">
            <span class="dropbtn">Reports &nbsp;||&nbsp;</span>
            <span class="dropdown-content">
                <a href="#" id="buildCallHistoryByNetCall" onclick="buildCallHistoryByNetCall()" title="build a Call History By NetCall">The Usual Suspects</a>
                <a href="buildGroupList.php" target="_blank" rel="noopener" title="Group List">Groups Information</a>
                <a href="groupScoreCard.php" target="_blank" rel="noopener" title="Group Scores">Group Score Card</a>
                <a href="listNets.php" target="_blank" rel="noopener" title="All the nets">List/Find ALL nets</a>
                <a href="#" onclick="net_by_number();" title="Net by the Number">Browse a Net by Number</a>
                <a href="NCMreports.php" target="_blank" rel="noopener" title="Stats about NCM">Statistics</a>
                <a href="listAllPOIs.php" target="_blank" rel="noopener" id="PoiList" title="List all Pois">List all POIs</a>
                <a href="AddRF-HolePOI.php" target="_blank" rel="noopener" id="PoiList" title="Create New RF Hole POI">Add RF Hole POI</a>
                <a href="#" id="geoDist" onclick="geoDistance()" title="GeoDistance">GeoDistance</a>
                <a href="#" id="mapIDs" onclick="map2()" title="Map This Net">Map This Net</a>
                <a href="https://vhf.dxview.org" id="mapdxView" target="_blank">DXView Propagation Map</a>
                <a href="https://www.swpc.noaa.gov" id="noaaSWX" target="_blank">NOAA Space Weather</a>
                <a href="https://spaceweather.com" id="SpaceWX" target="_blank">Space Weather</a>
                <a href="#" id="graphtimeline" onclick="graphtimeline()" title="Graphic Time Line of the active net">Graphic Time Line</a>
                <a href="#" id="ics205Abutton" onclick="ics205Abutton()" title="ICS-205A Report">ICS-205A</a>
                <a href="#" id="ics214button" onclick="ics214button()" title="ICS-214 Report">ICS-214</a>
                <a href="#" id="ics309button" onclick="ics309button()" title="ICS-309 Report">ICS-309</a>
                <a href="https://training.fema.gov/icsresource/icsforms.aspx" id="icsforms" target="_blank" rel="noopener">Additional ICS Forms</a>
                <a href="https://docs.google.com/spreadsheets/d/1eFUfVLfHp8uo58ryFwxncbONJ9TZ1DKGLX8MZJIRZmM/edit#gid=0" target="_blank" rel="noopener" title="The MECC Communications Plan">MECC Comm Plan</a>
                <a href="https://upload.wikimedia.org/wikipedia/commons/e/e7/Timezones2008.png" target="_blank" rel="noopener" title="World Time Zone Map">World Time Zone Map</a>
            </span> <!-- End of dropdown-content span -->
        </span> <!-- End of dropdown span -->
HTML;
    } // End of renderReportsDropdown function
    
    private function renderAdditionalOptions() {
        return <<<HTML
        <select id="bardropdown" class="bardropdown hidden">
            <option value="SelectOne" selected="selected" disabled>Select One</option>
            <option value="convertToPB">Convert to Pre-Built (Roll Call) net</option>
            <option value="CreateGroup">Create a Group Profile</option>
            <option value="HeardList">Create a Heard List</option>
            <option value="FSQList">Create FSQ Macro List</option>
            <option value="findCall">Report by Call Sign</option>
            <option value="allCalls">List all User Call Signs</option>
            <option value="DisplayHelp">NCM Documentation</option>
            <option value="DisplayKCARES">KCNARES Deployment Manual</option>
            <option value="" disabled>ARES Resources</option>
            <option value="ARESELetter">ARES E-Letter</option>
            <option value="ARESManual">Download the ARES Manual(PDF)</option>
            <option value="DisplayARES">Download ARES Field Resources Manual(PDF)</option>
            <option value="ARESTaskBook">ARES Standardized Training Plan Task Book [Fillable PDF]</option>
            <option value="ARESPlan">ARES Plan</option>
            <option value="ARESGroup">ARES Group Registration</option>
            <option value="ARESEComm">Emergency Communications Training</option>
        </select> <!-- End of bardropdown select -->
HTML;
    } // End of renderAdditionalOptions function
    
} // End of NCMMenus class
?> <!-- End of NCMMenus.php -->