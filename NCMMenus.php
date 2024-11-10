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
            <div id="upperRightCorner" class="upperRightCorner"></div> <!-- End of upperRightCorner div -->
            <div id="theMenu" class="theMenu">
                <table id="upperRightMenu"> <!-- Renamed from 'ourfreqs' for clarity -->
                    <tbody>
                        <tr class="trFREQS">
                            <td class="nobg2">
                                <!-- Tip bubbles button -->
                                <button class="tbb" title="Tips Button">T</button>
                                
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
                </table> <!-- End of upperRightMenu table -->
            </div> <!-- End of theMenu div -->
        </div> <!-- End of rightCorner div -->
HTML;
    } // End of renderUpperRightCorner function
    
    private function renderReportsDropdown() {
        return <<<HTML
        <span class="dropdown">
            <span class="dropbtn">Reports &nbsp;||&nbsp;</span>
            <span class="dropdown-content">
                <!-- Reports menu items... -->
                [Previous reports menu content]
            </span> <!-- End of dropdown-content span -->
        </span> <!-- End of dropdown span -->
HTML;
    } // End of renderReportsDropdown function
    
    private function renderAdditionalOptions() {
        return <<<HTML
        <select id="bardropdown" class="bardropdown hidden">
            <option value="SelectOne" selected="selected" disabled>Select One</option>
            <!-- Additional options... -->
            [Previous additional options content]
        </select> <!-- End of bardropdown select -->
HTML;
    } // End of renderAdditionalOptions function
    
} // End of NCMMenus class
?> <!-- End of NCMMenus.php -->