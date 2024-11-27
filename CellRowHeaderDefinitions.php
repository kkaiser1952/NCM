<?php
// CellRowHeaderDefinitions.php
/**
 * Single source of truth for table structure and column definitions in NCM
 * This file defines all possible columns, their attributes, visibility rules,
 * and how they should be displayed in both headers and data rows.
 * 
 * Key Components:
 * - Column categories (default, optional, admin)
 * - Cell definitions with all attributes and event handlers
 * - Header definitions with titles and toggle controls
 * - Table structure creation
 * 
 * Usage:
 * Required in getactivities2.php and other table-generating files
 * 
 * Written: 2019-04-04
 * Updated: 2024-09-20
 */
 
// Helper functions
if (!function_exists('h')) {
    function h($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
} // End h()

if (!function_exists('safeGet')) {
    function safeGet($array, $key, $default = '') {
        return isset($array[$key]) ? $array[$key] : $default;
    }
} // End safeGet()


// Function that uses cell definitions to build complete rows
function getRowDefinitions($format = 'html') {
    if ($format === 'raw') {
        return array_keys($columns['default']);
    }
    
    $output = '';
    foreach ($columns['default'] as $colKey => $colName) {
        $cellDef = getCellDefinition($colKey, $rowData);
        $output .= createCell($cellDef);
    }
    
    return $output;
} // End getRowDefinitions()

function createCell($cellDef) {
    if (!$cellDef) return '';
    
    $output = '<td';
    foreach ($cellDef as $attr => $value) {
        if ($attr !== 'content') {
            $output .= ' ' . $attr . '="' . h($value) . '"';
        }
    }
    $output .= '>' . (isset($cellDef['content']) ? $cellDef['content'] : '') . '</td>';
    return $output;
} // End createCell()


// Define arrays for each category of columns
$columns = [
    'default' => [    
        'c1' => 'Role',
        'c2' => 'Mode',
        'c3' => 'Status',
        'c4' => 'Traffic',
        'c6' => 'Callsign',
        'c7' => 'First Name',
        'c9' => 'Tactical',
        'c20' => 'Grid',
        'c12' => 'Time In',
        'c13' => 'Time Out',
        'c14' => 'Comments',
        'c17' => 'County',
        'c18' => 'State'
    ],
    'optional' => [
        'c0' => 'Row No.',
        'c5' => 'TT No.',
        'c8' => 'Last Name',
        'c10' => 'Phone',
        'c11' => 'eMail',
        'c15' => 'Credentials',
        'c16' => 'Time On Duty',     
        'c21' => 'Latitude',
        'c22' => 'Longitude',
        'c23' => 'Band',
        'c24' => 'W3W',
        'c30' => 'Team',
        'c31' => 'APRS_CALL',
        'c32' => 'Country',
        'c33' => 'Facility',
        'c34' => 'On Site',
        'c35' => 'City',
        'c59' => 'Dist'
    ],
    'admin' => [
        'c25' => 'recordID',
        'c26' => 'ID',
        'c27' => 'status',
        'c28' => 'home',
        'c29' => 'ipaddress'
    ]
];

    
function getCellDefinition($colKey, $rowData) {
// This is our single source of truth for cell definitions   
    $cells = array(
        'c1' => array
        (
            'class' => 'editable editable_selectNC cent c1',
            'id' => "netcontrol:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'netcontrol',
            'data-role' => safeGet($row, 'netcontrol', ''),
            'content' => h(safeGet($row, 'netcontrol')),
        ),
        'c2' => array(
            'class' => "editable editable_selectMode cent c2",
            'id' => "mode:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'mode',
            'data-mode' => safeGet($row, 'Mode', ''),
            'content' => h(safeGet($row, 'Mode')),
        ),
        'c3' => array(
            'class' => "editable editable_selectACT cent c3",
            'id' => "active:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'active',
            'data-status' => safeGet($row, 'active', ''),
            'oncontextmenu' => "rightClickACT('" . safeGet($row, 'recordID') . "');return false;",
            'content' => h(safeGet($row, 'active')),
        ),
        'c4' => array(
            'class' => "editable editable_selectTFC c4",
            'id' => "traffic:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'traffic',
            'data-traffic' => safeGet($row, 'traffic'),
            'oncontextmenu' => "rightClickTraffic('" . safeGet($row, 'recordID') . "');return false;",
            'content' => h(safeGet($row, 'traffic')),
        ),
        'c5' => array(
            'class' => 'editable editTT cent c5 TT',
            'id' => "tt:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'tt',
            'title' => "TT No. " . safeGet($row, 'tt') . " no edit",
            'content' => h(safeGet($row, 'tt')),
        ),
        'c23' => array(
            'class' => 'editable editBand c23',
            'id' => "band:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'band',
            'title' => safeGet($row, 'band') . " Band",
            'content' => h(safeGet($row, 'band')),   
        ),
        'c33' => array(
            'class' => 'editable editfacility c33',
            'id' => "facility:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'facility',
            'onclick' => "empty('facility:" . safeGet($row, 'recordID') . "');",
            'content' => h(safeGet($row, 'facility')),
        ),
        'c34' => array(
            'class' => 'editable editonSite c34',
            'id' => "onsite:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'onsite',
            'data-onsite' => safeGet($row, 'onsite', ''),
            'oncontextmenu' => "rightClickOnSite('" . safeGet($row, 'recordID') . "');return false;",
            'content' => h(safeGet($row, 'onSite', '')),
        ),
        'c6' => array(
            'class' => "editable cs1 " . safeGet($row, 'editCS1', '') . " c6",
            'id' => "callsign:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'callsign',
            'oncontextmenu' => "getCallHistory('" . h(safeGet($row, 'callsign')) . "');return false;",
            'ondblclick' => "doubleClickCall('" . safeGet($row, 'recordID') . "', '" . h(safeGet($row, 'callsign')) . "', '" . safeGet($row, 'netID') . "');return false;",
            'title' => "Call Sign " . h(safeGet($row, 'callsign')) . " no edit",
            'content' => h(safeGet($row, 'callsign')),
        ),
        'c7' => array(
            'class' => 'editable editFnm c7',
            'id' => "Fname:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'Fname',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('Fname:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'Fname')) . '</div>',
        ),
        'c8' => array(
            'class' => 'editable editLnm c8',
            'id' => "Lname:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'Lname',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('Lname:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'Lname')) . '</div>',
        ),
        'c9' => array(
            'class' => 'editable editTAC cent c9',
            'id' => "tactical:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'tactical',
            'onclick' => "empty('tactical:" . safeGet($row, 'recordID') . "');",
            'numsort' => safeGet($row, 'numsort', ''),
            'content' => "<div>" . h(safeGet($row, 'tactical')) . '</div>',
        ),
        'c10' => array(
            'class' => 'editable editPhone c10 cent',
            'id' => "phone:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'phone',
            'content' => h(safeGet($row, 'phone')),
        ),
        'c11' => array(
            'class' => 'editable editEMAIL c11',
            'id' => "email:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'email',
            'oncontextmenu' => "sendEMAIL('" . h(safeGet($row, 'email')) . "','" . safeGet($row, 'netID') . "');return false;",
            'content' => h(safeGet($row, 'email')),
        ),
        'c20' => array(
            'class' => 'editable editGRID c20',
            'id' => "grid:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'grid',
            'style' => 'text-transform:uppercase',
            'oncontextmenu' => "MapGridsquare('" . h(safeGet($row, 'latitude')) . ":" . h(safeGet($row, 'longitude')) . ":" . h(safeGet($row, 'callsign')) . "');return false;",
            'onclick' => "empty('grid:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'grid')) . '</div>',
        ),
        'c21' => array(
            'class' => 'editable editLAT c21',
            'id' => "latitude:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'latitude',
            'oncontextmenu' => "getCrossRoads('" . h(safeGet($row, 'latitude')) . "," . h(safeGet($row, 'longitude')) . "');return false;",
            'onclick' => "empty('latitude:" . safeGet($row, 'recordID') . "');",
            'content' => h(safeGet($row, 'latitude')),
        ),
        'c22' => array(
            'class' => 'editable editLON c22',
            'id' => "longitude:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'longitude',
            'oncontextmenu' => "getCrossRoads('" . h(safeGet($row, 'latitude')) . "," . h(safeGet($row, 'longitude')) . "');return false;",
            'onclick' => "empty('longitude:" . safeGet($row, 'recordID') . "');",
            'content' => h(safeGet($row, 'longitude')),
        ),
        'c12' => array(
            'class' => 'editable editTimeIn cent c12',
            'id' => "logdate:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'logdate',
            'content' => "<span class='tzld'>" . h(safeGet($row, 'logdate')) . "</span><span class='tzlld hidden'>" . h(safeGet($row, 'locallogdate', '')) . "</span>",
        ),
        'c13' => array(
            'class' => 'editable editTimeOut cent c13',
            'id' => "timeout:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'timeout',
            'content' => "<span class='tzto'>" . h(safeGet($row, 'timeout')) . "</span><span class='tzlto hidden'>" . h(safeGet($row, 'localtimeout', '')) . "</span>",
        ),
        'c14' => array(
            'class' => 'editable editC c14',
            'id' => "comments:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'comments',
            'oncontextmenu' => "stationTimeLineList('" . h(safeGet($row, 'callsign')) . ":" . safeGet($row, 'netID') . "');return false;",
            'onclick' => "empty('comments:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'comments')) . '</div>',
        ),
        'c15' => array(
            'class' => 'editable editCREDS c15',
            'id' => "creds:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'creds',
            'content' => h(safeGet($row, 'creds')),
        ),
        'c16' => array(
            'class' => 'editable c16 cent',
            'id' => "timeonduty:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'timeonduty',
            'content' => h(safeGet($row, 'time')),
        ),
        'c17' => array(
            'class' => 'editable editcnty c17 cent',
            'id' => "county:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'county',
            'style' => 'text-transform:capitalize',
            'oncontextmenu' => "MapCounty('" . h(safeGet($row, 'county')) . ":" . h(safeGet($row, 'state')) . "');return false;",
            'onclick' => "empty('county:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'county')) . '</div>',
        ),
        'c35' => array(
            'class' => 'editable editcity c35 cent',
            'id' => "city:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'city',
            'onclick' => "empty('city:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'city')) . '</div>',
        ),
        'c18' => array(
            'class' => 'editable editstate c18 cent',
            'id' => "state:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'city',
            'onclick' => "empty('state:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'state')) . '</div>',
        ),
        'c59' => array(
            'class' => 'editable editdist c59 cent',
            'id' => "district:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'district',
            'style' => 'text-transform:uppercase;',
            'sorttable_customkey' => safeGet($row, 'district') . " " . safeGet($row, 'county') . " " . safeGet($row, 'state'),
            'oncontextmenu' => "rightClickDistrict('" . safeGet($row, 'recordID') . ", " . safeGet($row, 'state') . ", " . safeGet($row, 'county') . "');return false;",
            'onclick' => "empty('district:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'district')) . "</div>",
        ),
        'c24' => array(
            'class' => 'readonly W3W c24 cent',
            'id' => "w3w:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'w3w',
            'oncontextmenu' => "mapWhat3Words('" . safeGet($row, 'w3w') . "');return false;",
            'onclick' => "empty('w3w:" . safeGet($row, 'recordID') . "'); getAPRSLocations('NOTUSED, " . safeGet($row, 'recordID') . ", " . safeGet($row, 'latitude') . "," . safeGet($row, 'longitude') . "," . safeGet($row, 'callsign') . "," . safeGet($row, 'netID') . ", W3W');",
            'style' => 'cursor: pointer;',
            'content' => "<div class='" . safeGet($row, 'class', '') . "' readonly>" . h(safeGet($row, 'w3w')) . "</div>",
        ),
        'c30' => array(
            'class' => 'editable editteam c30 cent',
            'id' => "team:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'team',
            'onclick' => "empty('team:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'team')) . "</div>",
        ),
        'c31' => array(
            'class' => 'editable editaprs_call c31 cent',
            'id' => "aprs_call:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'aprs_call',
            'style' => 'text-transform:uppercase',
            'oncontextmenu' => "getAPRSLocations('" . safeGet($row, 'aprs_call') . ", " . safeGet($row, 'recordID') . ", " . safeGet($row, 'latitude') . "," . safeGet($row, 'longitude') . "," . safeGet($row, 'callsign') . "," . safeGet($row, 'netID') . ", APRS');return false;",
            'onclick' => "empty('aprs_call:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'aprs_call')) . "</div>",
        ),
        'c32' => array(
            'class' => 'editable editcntry c32 cent',
            'id' => "country:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'country',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('country:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'country')) . "</div>",
        ),
        'c25' => array(
            'class' => 'editable c25 cent',
            'id' => "recordID:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'recordID',
            'content' => h(safeGet($row, 'recordID')),
        ),
        'c26' => array(
            'class' => 'editable c26 cent',
            'id' => "id:" . safeGet($row, 'id'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'id',
            'content' => h(safeGet($row, 'id')),
        ),
        'c27' => array(
            'class' => 'editable c27 cent',
            'id' => "status:" . safeGet($row, 'status'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'status',
            'content' => "'" . h(safeGet($row, 'status')) . "'",
        ),
        'c28' => array(
            'class' => 'editable c28 cent',
            'id' => "home:" . safeGet($row, 'home'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'home',
            'content' => "'" . h(safeGet($row, 'home')) . "'",
        ),
        'c29' => array(
            'class' => 'editable c29 cent',
            'id' => "ipaddress:" . safeGet($row, 'ipaddress'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'ipaddress',
            'content' => h(safeGet($row, 'ipaddress')),
        
    ) // End $cells arry
    
    return isset($cells[$colKey]) ? $cells[$colKey] : array();
} // End getCellDefinition()
    
 /*    if ($format === 'raw') {
            return $cells;
        }
    
        $output = '';
        foreach ($cells as $cell) {
            $output .= '<td';
            foreach ($cell as $attribute => $value) {
                if ($attribute !== 'content') {
                    $output .= ' ' . $attribute . '="' . h($value) . '"';
                }
            }
            $output .= '>' . $cell['content'] . '</td>';
        }
    
        return $output;
} // End getRowDefinitions()
*/
 
// Replaces headerdefinitions.php
function getHeaderDefinitions() {
    return [
        // Row No. - Optional
        [
            'title' => 'Row No.', 
            'class' => 'besticky c0', 
            'content' => '#',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c0">'
        ],
        // Role - Default
        [
            'title' => 'Role', 
            'class' => 'besticky c1', 
            'content' => 'Role',
            'checkbox' => '' // No checkbox means always visible
        ],
        // Mode - Default
        [
            'title' => 'Mode', 
            'class' => 'besticky DfltMode cent c2', 
            'id' => 'dfltmode', 
            'oncontextmenu' => "setDfltMode();return false;", 
            'content' => 'Mode',
            'checkbox' => ''
        ],
        // Status - Default
        [
            'title' => 'Status', 
            'class' => 'besticky c3', 
            'content' => 'Status',
            'checkbox' => ''
        ],
        // Traffic - Default
        [
            'title' => 'Traffic', 
            'class' => 'besticky c4', 
            'content' => 'Traffic',
            'checkbox' => ''
        ],
        // TT No. - Optional
        [
            'title' => 'TT No. The assigned APRS TT number.', 
            'class' => 'besticky c5', 
            'width' => '5%', 
            'oncontextmenu' => "whatIstt();return false;", 
            'content' => 'tt#',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c5">'
        ],
        // Callsign - Default
        [
            'title' => 'Call Sign', 
            'class' => 'besticky c6', 
            'oncontextmenu' => "heardlist()", 
            'content' => 'Callsign',
            'checkbox' => ''
        ],
        // First Name - Default
        [
            'title' => 'First Name', 
            'class' => 'besticky c7', 
            'content' => 'First Name',
            'checkbox' => ''
        ],
        // Last Name - Optional
        [
            'title' => 'Last Name', 
            'class' => 'besticky c8', 
            'content' => 'Last Name',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c8">'
        ],
        // Tactical - Default
        [
            'title' => 'Tactical Call, Click to change. Or type DELETE to delete entire row.', 
            'class' => 'besticky c9', 
            'oncontextmenu' => "Clear_All_Tactical()", 
            'content' => 'Tactical',
            'checkbox' => ''
        ],
        // Phone - Optional
        [
            'title' => 'Phone, Enter phone number.', 
            'class' => 'besticky c10', 
            'content' => 'Phone',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c10">'
        ],
        // Email - Optional
        [
            'title' => 'email, Enter email address.', 
            'class' => 'besticky c11', 
            'oncontextmenu' => "sendGroupEMAIL()", 
            'content' => 'eMail',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c11">'
        ],
        // Time In - Default
        [
            'title' => 'Time In, Not for edit.', 
            'class' => 'besticky c12', 
            'content' => 'Time In',
            'checkbox' => ''
        ],
        // Time Out - Default
        [
            'title' => 'Time Out, Not for edit.', 
            'class' => 'besticky c13', 
            'content' => 'Time Out',
            'checkbox' => ''
        ],
        // Comments - Default
        [
            'title' => 'Comments, All comments are saved.', 
            'class' => 'besticky c14', 
            'content' => 'Time Line<br>Comments',
            'checkbox' => ''
        ],
        // Credentials - Optional
        [
            'title' => 'Credentials', 
            'class' => 'besticky c15', 
            'content' => 'Credentials',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c15">'
        ],
        // Time On Duty - Optional
        [
            'title' => 'Time On Duty', 
            'class' => 'besticky c16', 
            'content' => 'Time On Duty',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c16">'
        ],
        // County - Default
        [
            'title' => 'County', 
            'class' => 'besticky c17', 
            'content' => 'County',
            'checkbox' => ''
        ],
        // State - Default
        [
            'title' => 'State', 
            'class' => 'besticky c18', 
            'content' => 'State',
            'checkbox' => ''
        ],
        // Grid - Default
        [
            'title' => 'Grid, Maidenhead grid square location.', 
            'class' => 'besticky c20', 
            'content' => 'Grid',
            'checkbox' => ''
        ],
        // Latitude - Optional
        [
            'title' => 'Latitude', 
            'class' => 'besticky c21', 
            'content' => 'Latitude',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c21">'
        ],
        // Longitude - Optional
        [
            'title' => 'Longitude', 
            'class' => 'besticky c22', 
            'content' => 'Longitude',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c22">'
        ],
        // Band - Optional
        [
            'title' => 'Band', 
            'class' => 'besticky c23', 
            'width' => '5%', 
            'content' => 'Band',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c23">'
        ],
        // W3W - Optional
        [
            'title' => 'W3W, Enter a What 3 Words location.', 
            'class' => 'besticky c24', 
            'oncontextmenu' => "openW3W();", 
            'content' => 'W3W',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c24">'
        ],
        // recordID - Admin
        [
            'title' => 'recordID', 
            'class' => 'besticky c25', 
            'content' => 'recordID',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c25">'
        ],
        // ID - Admin
        [
            'title' => 'ID', 
            'class' => 'besticky c26', 
            'content' => 'ID',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c26">'
        ],
        // status - Admin
        [
            'title' => 'status', 
            'class' => 'besticky c27', 
            'content' => 'status',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c27">'
        ],
        // home - Admin
        [
            'title' => 'home', 
            'class' => 'besticky c28', 
            'content' => 'home',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c28">'
        ],
        // ipaddress - Admin
        [
            'title' => 'ipaddress', 
            'class' => 'besticky c29', 
            'content' => 'ipaddress',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c29">'
        ],
        // Team - Optional
        [
            'title' => 'Team', 
            'class' => 'besticky c30', 
            'content' => 'Team',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c30">'
        ],
        // APRS_CALL - Optional
        [
            'title' => 'APRS_CALL', 
            'class' => 'besticky c31', 
            'content' => 'APRS CALL',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c31">'
        ],
        // Country - Optional
        [
            'title' => 'Country', 
            'class' => 'besticky c32', 
            'content' => 'Country',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c32">'
        ],
        // Facility - Optional
        [
            'title' => 'Facility', 
            'class' => 'besticky cent c33', 
            'oncontextmenu' => "clearFacilityCookie();return false;", 
            'content' => 'Facility',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c33">'
        ],
        // On Site - Optional
        [
            'title' => 'onsite', 
            'class' => 'besticky c34', 
            'oncontextmenu' => "showFacilityColumn();return false;", 
            'content' => 'On Site',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c34">'
        ],
        // City - Optional
        [
            'title' => 'City', 
            'class' => 'besticky c35', 
            'content' => 'City',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c35">'
        ],
        // District - Optional
        [
            'title' => 'District', 
            'class' => 'besticky c59', 
            'content' => 'Dist',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c59">'
        ]
    ];
} // END getHeaderDefinitions()

// Function to create the complete table structure
function createTableStructure() {
    $headers = getHeaderDefinitions();
    
    $tableHtml = '<table id="thisNet">' . "\n";
    $tableHtml .= '  <thead id="thead" class="forNums" style="text-align: center;">' . "\n";
    $tableHtml .= '    <tr>' . "\n";
    
    foreach ($headers as $header) {
        $tableHtml .= '      <th';
        foreach ($header as $attr => $value) {
            if ($attr !== 'content' && $attr !== 'checkbox') {
                $tableHtml .= ' ' . $attr . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        $tableHtml .= '>';
        $tableHtml .= $header['content'];
        if (isset($header['checkbox']) && !empty($header['checkbox'])) {
            $tableHtml .= $header['checkbox'];
        }
        $tableHtml .= '</th>' . "\n";
    }
    
    $tableHtml .= '    </tr>' . "\n";
    $tableHtml .= '  </thead>' . "\n";
    
    return $tableHtml;
} // End createTableStructure()