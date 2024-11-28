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
function getRowDefinitions($format = 'html', $rowData = array()) {
    global $columns;
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
        'c0' => 'Ro',
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
        'c1' => array(
            'class' => 'editable editable_selectNC cent c1',
            'id' => "netcontrol:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'netcontrol',
            'data-role' => safeGet($rowData, 'netcontrol', ''),
            'content' => h(safeGet($rowData, 'netcontrol')),
        ),
        'c2' => array(
            'class' => "editable editable_selectMode cent c2",
            'id' => "mode:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'mode',
            'data-mode' => safeGet($rowData, 'Mode', ''),
            'content' => h(safeGet($rowData, 'Mode')),
        ),
        'c3' => array(
            'class' => "editable editable_selectACT cent c3",
            'id' => "active:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'active',
            'data-status' => safeGet($rowData, 'active', ''),
            'oncontextmenu' => "rightClickACT('" . safeGet($rowData, 'recordID') . "');return false;",
            'content' => h(safeGet($rowData, 'active')),
        ),
        'c4' => array(
            'class' => "editable editable_selectTFC c4",
            'id' => "traffic:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'traffic',
            'data-traffic' => safeGet($rowData, 'traffic'),
            'oncontextmenu' => "rightClickTraffic('" . safeGet($rowData, 'recordID') . "');return false;",
            'content' => h(safeGet($rowData, 'traffic')),
        ),
        'c5' => array(
            'class' => 'editable editTT cent c5 TT',
            'id' => "tt:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'tt',
            'title' => "TT No. " . safeGet($rowData, 'tt') . " no edit",
            'content' => h(safeGet($rowData, 'tt')),
        ),
        'c23' => array(
            'class' => 'editable editBand c23',
            'id' => "band:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'band',
            'title' => safeGet($rowData, 'band') . " Band",
            'content' => h(safeGet($rowData, 'band')),   
        ),
        'c33' => array(
            'class' => 'editable editfacility c33',
            'id' => "facility:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'facility',
            'onclick' => "empty('facility:" . safeGet($rowData, 'recordID') . "');",
            'content' => h(safeGet($rowData, 'facility')),
        ),
        'c34' => array(
            'class' => 'editable editonSite c34',
            'id' => "onsite:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'onsite',
            'data-onsite' => safeGet($rowData, 'onsite', ''),
            'oncontextmenu' => "rightClickOnSite('" . safeGet($rowData, 'recordID') . "');return false;",
            'content' => h(safeGet($rowData, 'onSite', '')),
        ),
        'c6' => array(
            'class' => "editable cs1 " . safeGet($rowData, 'editCS1', '') . " c6",
            'id' => "callsign:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'callsign',
            'oncontextmenu' => "getCallHistory('" . h(safeGet($rowData, 'callsign')) . "');return false;",
            'ondblclick' => "doubleClickCall('" . safeGet($rowData, 'recordID') . "', '" . h(safeGet($rowData, 'callsign')) . "', '" . safeGet($rowData, 'netID') . "');return false;",
            'title' => "Call Sign " . h(safeGet($rowData, 'callsign')) . " no edit",
            'content' => h(safeGet($rowData, 'callsign')),
        ),
        'c7' => array(
            'class' => 'editable editFnm c7',
            'id' => "Fname:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'Fname',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('Fname:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($rowData, 'Fname')) . '</div>',
        ),
        'c8' => array(
            'class' => 'editable editLnm c8',
            'id' => "Lname:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'Lname',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('Lname:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($rowData, 'Lname')) . '</div>',
        ),
        'c9' => array(
            'class' => 'editable editTAC cent c9',
            'id' => "tactical:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'tactical',
            'onclick' => "empty('tactical:" . safeGet($rowData, 'recordID') . "');",
            'numsort' => safeGet($rowData, 'numsort', ''),
            'content' => "<div>" . h(safeGet($rowData, 'tactical')) . '</div>',
        ),
        'c10' => array(
            'class' => 'editable editPhone c10 cent',
            'id' => "phone:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'phone',
            'content' => h(safeGet($rowData, 'phone')),
        ),
        'c11' => array(
            'class' => 'editable editEMAIL c11',
            'id' => "email:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'email',
            'oncontextmenu' => "sendEMAIL('" . h(safeGet($rowData, 'email')) . "','" . safeGet($rowData, 'netID') . "');return false;",
            'content' => h(safeGet($rowData, 'email')),
        ),
        'c20' => array(
            'class' => 'editable editGRID c20',
            'id' => "grid:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'grid',
            'style' => 'text-transform:uppercase',
            'oncontextmenu' => "MapGridsquare('" . h(safeGet($rowData, 'latitude')) . ":" . h(safeGet($rowData, 'longitude')) . ":" . h(safeGet($rowData, 'callsign')) . "');return false;",
            'onclick' => "empty('grid:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($rowData, 'grid')) . '</div>',
        ),
        'c21' => array(
            'class' => 'editable editLAT c21',
            'id' => "latitude:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'latitude',
            'oncontextmenu' => "getCrossRoads('" . h(safeGet($rowData, 'latitude')) . "," . h(safeGet($rowData, 'longitude')) . "');return false;",
            'onclick' => "empty('latitude:" . safeGet($rowData, 'recordID') . "');",
            'content' => h(safeGet($rowData, 'latitude')),
        ),
        'c22' => array(
            'class' => 'editable editLON c22',
            'id' => "longitude:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'longitude',
            'oncontextmenu' => "getCrossRoads('" . h(safeGet($rowData, 'latitude')) . "," . h(safeGet($rowData, 'longitude')) . "');return false;",
            'onclick' => "empty('longitude:" . safeGet($rowData, 'recordID') . "');",
            'content' => h(safeGet($rowData, 'longitude')),
        ),
        'c12' => array(
            'class' => 'editable editTimeIn cent c12',
            'id' => "logdate:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'logdate',
            'content' => "<span class='tzld'>" . h(safeGet($rowData, 'logdate')) . "</span><span class='tzlld hidden'>" . h(safeGet($rowData, 'locallogdate', '')) . "</span>",
        ),
        'c13' => array(
            'class' => 'editable editTimeOut cent c13',
            'id' => "timeout:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'timeout',
            'content' => "<span class='tzto'>" . h(safeGet($rowData, 'timeout')) . "</span><span class='tzlto hidden'>" . h(safeGet($rowData, 'localtimeout', '')) . "</span>",
        ),
        'c14' => array(
            'class' => 'editable editC c14',
            'id' => "comments:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'comments',
            'oncontextmenu' => "stationTimeLineList('" . h(safeGet($rowData, 'callsign')) . ":" . safeGet($rowData, 'netID') . "');return false;",
            'onclick' => "empty('comments:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($rowData, 'comments')) . '</div>',
        ),
        'c15' => array(
            'class' => 'editable editCREDS c15',
            'id' => "creds:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'creds',
            'content' => h(safeGet($rowData, 'creds')),
        ),
        'c16' => array(
            'class' => 'editable c16 cent',
            'id' => "timeonduty:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'timeonduty',
            'content' => h(safeGet($rowData, 'time')),
        ),
        'c17' => array(
            'class' => 'editable editcnty c17 cent',
            'id' => "county:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'county',
            'style' => 'text-transform:capitalize',
            'oncontextmenu' => "MapCounty('" . h(safeGet($rowData, 'county')) . ":" . h(safeGet($rowData, 'state')) . "');return false;",
            'onclick' => "empty('county:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($rowData, 'county')) . '</div>',
        ),
        'c35' => array(
            'class' => 'editable editcity c35 cent',
            'id' => "city:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'city',
            'onclick' => "empty('city:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($rowData, 'city')) . '</div>',
        ),
        'c18' => array(
            'class' => 'editable editstate c18 cent',
            'id' => "state:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'city',
            'onclick' => "empty('state:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($rowData, 'state')) . '</div>',
        ),
        'c59' => array(
            'class' => 'editable editdist c59 cent',
            'id' => "district:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'district',
            'style' => 'text-transform:uppercase;',
            'sorttable_customkey' => safeGet($rowData, 'district') . " " . safeGet($rowData, 'county') . " " . safeGet($rowData, 'state'),
            'oncontextmenu' => "rightClickDistrict('" . safeGet($rowData, 'recordID') . ", " . safeGet($rowData, 'state') . ", " . safeGet($rowData, 'county') . "');return false;",
            'onclick' => "empty('district:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div class='" . safeGet($rowData, 'class', '') . "'>" . h(safeGet($rowData, 'district')) . "</div>",
        ),
        'c24' => array(
            'class' => 'readonly W3W c24 cent',
            'id' => "w3w:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'w3w',
            'oncontextmenu' => "mapWhat3Words('" . safeGet($rowData, 'w3w') . "');return false;",
            'onclick' => "empty('w3w:" . safeGet($rowData, 'recordID') . "'); getAPRSLocations('NOTUSED, " . safeGet($rowData, 'recordID') . ", " . safeGet($rowData, 'latitude') . "," . safeGet($rowData, 'longitude') . "," . safeGet($rowData, 'callsign') . "," . safeGet($rowData, 'netID') . ", W3W');",
            'style' => 'cursor: pointer;',
            'content' => "<div class='" . safeGet($rowData, 'class', '') . "' readonly>" . h(safeGet($rowData, 'w3w')) . "</div>",
        ),
        'c30' => array(
            'class' => 'editable editteam c30 cent',
            'id' => "team:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'team',
            'onclick' => "empty('team:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div class='" . safeGet($rowData, 'class', '') . "'>" . h(safeGet($rowData, 'team')) . "</div>",
        ),
        'c31' => array(
            'class' => 'editable editaprs_call c31 cent',
            'id' => "aprs_call:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'aprs_call',
            'style' => 'text-transform:uppercase',
            'oncontextmenu' => "getAPRSLocations('" . safeGet($rowData, 'aprs_call') . ", " . safeGet($rowData, 'recordID') . ", " . safeGet($rowData, 'latitude') . "," . safeGet($rowData, 'longitude') . "," . safeGet($rowData, 'callsign') . "," . safeGet($rowData, 'netID') . ", APRS');return false;",
            'onclick' => "empty('aprs_call:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div class='" . safeGet($rowData, 'class', '') . "'>" . h(safeGet($rowData, 'aprs_call')) . "</div>",
        ),
        'c32' => array(
            'class' => 'editable editcntry c32 cent',
            'id' => "country:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'country',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('country:" . safeGet($rowData, 'recordID') . "');",
            'content' => "<div class='" . safeGet($rowData, 'class', '') . "'>" . h(safeGet($rowData, 'country')) . "</div>",
        ),
        'c25' => array(
            'class' => 'editable c25 cent',
            'id' => "recordID:" . safeGet($rowData, 'recordID'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'recordID',
            'content' => h(safeGet($rowData, 'recordID')),
        ),
        'c26' => array(
            'class' => 'editable c26 cent',
            'id' => "id:" . safeGet($rowData, 'id'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'id',
            'content' => h(safeGet($rowData, 'id')),
        ),
        'c27' => array(
            'class' => 'editable c27 cent',
            'id' => "status:" . safeGet($rowData, 'status'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'status',
            'content' => "'" . h(safeGet($rowData, 'status')) . "'",
        ),
        'c28' => array(
            'class' => 'editable c28 cent',
            'id' => "home:" . safeGet($rowData, 'home'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'home',
            'content' => "'" . h(safeGet($rowData, 'home')) . "'",
        ),
        'c29' => array(
            'class' => 'editable c29 cent',
            'id' => "ipaddress:" . safeGet($rowData, 'ipaddress'),
            'data-record-id' => safeGet($rowData, 'recordID'),
            'data-column' => 'ipaddress',
            'content' => h(safeGet($rowData, 'ipaddress')),
        )
        
    ); // End $cells arry
    
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
     /*   [
            'title' => 'Row No.', 
            'class' => 'besticky c0', 
            'content' => '#',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c0">'
        ], */
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