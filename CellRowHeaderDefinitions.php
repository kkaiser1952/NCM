<?php
// CellRowHeaderDefinitions.php
// The ' c ' values in this file are used to place the correct data values in the cells in each row of data. The ' c ' values are also used to match the rowDefinitions correctly.
// Written: 2019-04-04
// Update: 2024-09-20

// You can now use these arrays to populate the sidebar options or manage column visibility
// Helper functions
if (!function_exists('h')) {
    function h($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('safeGet')) {
    function safeGet($array, $key, $default = '') {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}


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

    
function getRowDefinitions($format = 'html') {
    $cells = [
        // Row Number - Optional
        [
            'class' => 'editable c0 cent',
            'id' => "rowno:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'rowno',
            'content' => h(safeGet($row, 'rowno')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c0">'
        ],
        // Role - Default
        [
            'class' => 'editable editable_selectNC cent c1',
            'id' => "netcontrol:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'netcontrol',
            'data-role' => safeGet($row, 'netcontrol', ''),
            'content' => h(safeGet($row, 'netcontrol')),
            'checkbox' => ''
        ],
        // Mode - Default
        [
            'class' => "editable editable_selectMode cent c2",
            'id' => "mode:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'mode',
            'data-mode' => safeGet($row, 'Mode', ''),
            'content' => h(safeGet($row, 'Mode')),
            'checkbox' => ''
        ],
        // Status - Default
        [
            'class' => "editable editable_selectACT cent c3",
            'id' => "active:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'active',
            'data-status' => safeGet($row, 'active', ''),
            'oncontextmenu' => "rightClickACT('" . safeGet($row, 'recordID') . "');return false;",
            'content' => h(safeGet($row, 'active')),
            'checkbox' => ''
        ],
        // Traffic - Default
        [
            'class' => "editable editable_selectTFC c4",
            'id' => "traffic:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'traffic',
            'data-traffic' => safeGet($row, 'traffic'),
            'oncontextmenu' => "rightClickTraffic('" . safeGet($row, 'recordID') . "');return false;",
            'content' => h(safeGet($row, 'traffic')),
            'checkbox' => ''
        ],
        // TT No. - Optional
        [
            'class' => 'editable editTT cent c5 TT',
            'id' => "tt:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'tt',
            'title' => "TT No. " . safeGet($row, 'tt') . " no edit",
            'content' => h(safeGet($row, 'tt')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c5">'
        ],
        // Callsign - Default
        [
            'class' => "editable cs1 " . safeGet($row, 'editCS1', '') . " c6",
            'id' => "callsign:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'callsign',
            'oncontextmenu' => "getCallHistory('" . h(safeGet($row, 'callsign')) . "');return false;",
            'ondblclick' => "doubleClickCall('" . safeGet($row, 'recordID') . "', '" . h(safeGet($row, 'callsign')) . "', '" . safeGet($row, 'netID') . "');return false;",
            'title' => "Call Sign " . h(safeGet($row, 'callsign')) . " no edit",
            'content' => h(safeGet($row, 'callsign')),
            'checkbox' => ''
        ],
        // First Name - Default
        [
            'class' => 'editable editFnm c7',
            'id' => "Fname:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'Fname',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('Fname:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'Fname')) . '</div>',
            'checkbox' => ''
        ],
        // Last Name - Optional
        [
            'class' => 'editable editLnm c8',
            'id' => "Lname:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'Lname',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('Lname:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'Lname')) . '</div>',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c8">'
        ],
        // Tactical - Default
        [
            'class' => 'editable editTAC cent c9',
            'id' => "tactical:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'tactical',
            'onclick' => "empty('tactical:" . safeGet($row, 'recordID') . "');",
            'numsort' => safeGet($row, 'numsort', ''),
            'content' => "<div>" . h(safeGet($row, 'tactical')) . '</div>',
            'checkbox' => ''
        ],
        // Phone - Optional
        [
            'class' => 'editable editPhone c10 cent',
            'id' => "phone:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'phone',
            'content' => h(safeGet($row, 'phone')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c10">'
        ],
        // Email - Optional
        [
            'class' => 'editable editEMAIL c11',
            'id' => "email:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'email',
            'oncontextmenu' => "sendEMAIL('" . h(safeGet($row, 'email')) . "','" . safeGet($row, 'netID') . "');return false;",
            'content' => h(safeGet($row, 'email')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c11">'
        ],
        // Time In - Default
        [
            'class' => 'editable editTimeIn cent c12',
            'id' => "logdate:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'logdate',
            'content' => "<span class='tzld'>" . h(safeGet($row, 'logdate')) . "</span><span class='tzlld hidden'>" . h(safeGet($row, 'locallogdate', '')) . "</span>",
            'checkbox' => ''
        ],
        // Time Out - Default
        [
            'class' => 'editable editTimeOut cent c13',
            'id' => "timeout:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'timeout',
            'content' => "<span class='tzto'>" . h(safeGet($row, 'timeout')) . "</span><span class='tzlto hidden'>" . h(safeGet($row, 'localtimeout', '')) . "</span>",
            'checkbox' => ''
        ],
        // Comments - Default
        [
            'class' => 'editable editC c14',
            'id' => "comments:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'comments',
            'oncontextmenu' => "stationTimeLineList('" . h(safeGet($row, 'callsign')) . ":" . safeGet($row, 'netID') . "');return false;",
            'onclick' => "empty('comments:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'comments')) . '</div>',
            'checkbox' => ''
        ],
        // Credentials - Optional
        [
            'class' => 'editable editCREDS c15',
            'id' => "creds:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'creds',
            'content' => h(safeGet($row, 'creds')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c15">'
        ],
        // Time On Duty - Optional
        [
            'class' => 'editable c16 cent',
            'id' => "timeonduty:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'timeonduty',
            'content' => h(safeGet($row, 'time')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c16">'
        ],
        // County - Default
        [
            'class' => 'editable editcnty c17 cent',
            'id' => "county:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'county',
            'style' => 'text-transform:capitalize',
            'oncontextmenu' => "MapCounty('" . h(safeGet($row, 'county')) . ":" . h(safeGet($row, 'state')) . "');return false;",
            'onclick' => "empty('county:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'county')) . '</div>',
            'checkbox' => ''
        ],
        // State - Default
        [
            'class' => 'editable editstate c18 cent',
            'id' => "state:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'state',
            'onclick' => "empty('state:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'state')) . '</div>',
            'checkbox' => ''
        ],
        // Grid - Default
        [
            'class' => 'editable editGRID c20',
            'id' => "grid:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'grid',
            'style' => 'text-transform:uppercase',
            'oncontextmenu' => "MapGridsquare('" . h(safeGet($row, 'latitude')) . ":" . h(safeGet($row, 'longitude')) . ":" . h(safeGet($row, 'callsign')) . "');return false;",
            'onclick' => "empty('grid:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'grid')) . '</div>',
            'checkbox' => ''
        ],
        // Latitude - Optional
        [
            'class' => 'editable editLAT c21',
            'id' => "latitude:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'latitude',
            'oncontextmenu' => "getCrossRoads('" . h(safeGet($row, 'latitude')) . "," . h(safeGet($row, 'longitude')) . "');return false;",
            'onclick' => "empty('latitude:" . safeGet($row, 'recordID') . "');",
            'content' => h(safeGet($row, 'latitude')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c21">'
        ],
        // Longitude - Optional
        [
            'class' => 'editable editLON c22',
            'id' => "longitude:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'longitude',
            'oncontextmenu' => "getCrossRoads('" . h(safeGet($row, 'latitude')) . "," . h(safeGet($row, 'longitude')) . "');return false;",
            'onclick' => "empty('longitude:" . safeGet($row, 'recordID') . "');",
            'content' => h(safeGet($row, 'longitude')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c22">'
        ],
        // Band - Optional
        // W3W - Optional (completing c24)
        [
            'class' => 'readonly W3W c24 cent',
            'id' => "w3w:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'w3w',
            'oncontextmenu' => "mapWhat3Words('" . safeGet($row, 'w3w') . "');return false;",
            'onclick' => "empty('w3w:" . safeGet($row, 'recordID') . "'); getAPRSLocations('NOTUSED, " . safeGet($row, 'recordID') . ", " . safeGet($row, 'latitude') . "," . safeGet($row, 'longitude') . "," . safeGet($row, 'callsign') . "," . safeGet($row, 'netID') . ", W3W');",
            'style' => 'cursor: pointer;',
            'content' => "<div class='" . safeGet($row, 'class', '') . "' readonly>" . h(safeGet($row, 'w3w')) . "</div>",
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c24">'
        ],
        // recordID - Admin
        [
            'class' => 'editable c25 cent',
            'id' => "recordID:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'recordID',
            'content' => h(safeGet($row, 'recordID')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c25">'
        ],
        // ID - Admin
        [
            'class' => 'editable c26 cent',
            'id' => "id:" . safeGet($row, 'id'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'id',
            'content' => h(safeGet($row, 'id')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c26">'
        ],
        // status - Admin
        [
            'class' => 'editable c27 cent',
            'id' => "status:" . safeGet($row, 'status'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'status',
            'content' => "'" . h(safeGet($row, 'status')) . "'",
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c27">'
        ],
        // home - Admin
        [
            'class' => 'editable c28 cent',
            'id' => "home:" . safeGet($row, 'home'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'home',
            'content' => "'" . h(safeGet($row, 'home')) . "'",
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c28">'
        ],
        // ipaddress - Admin
        [
            'class' => 'editable c29 cent',
            'id' => "ipaddress:" . safeGet($row, 'ipaddress'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'ipaddress',
            'content' => h(safeGet($row, 'ipaddress')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c29">'
        ],
        // Team - Optional
        [
            'class' => 'editable editteam c30 cent',
            'id' => "team:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'team',
            'onclick' => "empty('team:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'team')) . "</div>",
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c30">'
        ],
        // APRS_CALL - Optional
        [
            'class' => 'editable editaprs_call c31 cent',
            'id' => "aprs_call:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'aprs_call',
            'style' => 'text-transform:uppercase',
            'oncontextmenu' => "getAPRSLocations('" . safeGet($row, 'aprs_call') . ", " . safeGet($row, 'recordID') . ", " . safeGet($row, 'latitude') . "," . safeGet($row, 'longitude') . "," . safeGet($row, 'callsign') . "," . safeGet($row, 'netID') . ", APRS');return false;",
            'onclick' => "empty('aprs_call:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'aprs_call')) . "</div>",
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c31">'
        ],
        // Country - Optional
        [
            'class' => 'editable editcntry c32 cent',
            'id' => "country:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'country',
            'style' => 'text-transform:capitalize',
            'onclick' => "empty('country:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'country')) . "</div>",
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c32">'
        ],
        // Facility - Optional
        [
            'class' => 'editable editfacility c33',
            'id' => "facility:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'facility',
            'onclick' => "empty('facility:" . safeGet($row, 'recordID') . "');",
            'content' => h(safeGet($row, 'facility')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c33">'
        ],
        // On Site - Optional
        [
            'class' => 'editable editonSite c34',
            'id' => "onsite:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'onsite',
            'data-onsite' => safeGet($row, 'onsite', ''),
            'oncontextmenu' => "rightClickOnSite('" . safeGet($row, 'recordID') . "');return false;",
            'content' => h(safeGet($row, 'onSite', '')),
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c34">'
        ],
        // City - Optional
        [
            'class' => 'editable editcity c35 cent',
            'id' => "city:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'city',
            'onclick' => "empty('city:" . safeGet($row, 'recordID') . "');",
            'content' => "<div>" . h(safeGet($row, 'city')) . '</div>',
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c35">'
        ],
        // District - Optional
        [
            'class' => 'editable editdist c59 cent',
            'id' => "district:" . safeGet($row, 'recordID'),
            'data-record-id' => safeGet($row, 'recordID'),
            'data-column' => 'district',
            'style' => 'text-transform:uppercase;',
            'sorttable_customkey' => safeGet($row, 'district') . " " . safeGet($row, 'county') . " " . safeGet($row, 'state'),
            'oncontextmenu' => "rightClickDistrict('" . safeGet($row, 'recordID') . ", " . safeGet($row, 'state') . ", " . safeGet($row, 'county') . "');return false;",
            'onclick' => "empty('district:" . safeGet($row, 'recordID') . "');",
            'content' => "<div class='" . safeGet($row, 'class', '') . "'>" . h(safeGet($row, 'district')) . "</div>",
            'checkbox' => '<input type="checkbox" class="hidden column-toggle" data-column="c59">'
        ]
    ];

    if ($format === 'raw') {
        return $cells;
    }

    $output = '';
    foreach ($cells as $cell) {
        $output .= '<td';
        foreach ($cell as $attribute => $value) {
            if ($attribute !== 'content' && $attribute !== 'checkbox') {
                $output .= ' ' . $attribute . '="' . htmlspecialchars($value) . '"';
            }
        }
        $output .= '>' . $cell['content'] . $cell['checkbox'] . '</td>';
    }

    return $output;
} // End getRowDefinitions()
 
function getHeaderDefinitions() {
    return [
        ['title' => 'Row No.', 'class' => 'besticky c0', 'content' => '#'],
        ['title' => 'Role', 'class' => 'besticky c1', 'content' => 'Role'],
        ['title' => 'Mode', 'class' => 'besticky DfltMode cent c2', 'id' => 'dfltmode', 'oncontextmenu' => "setDfltMode();return false;", 'content' => 'Mode'],
        ['title' => 'Status', 'class' => 'besticky c3', 'content' => 'Status'],
        ['title' => 'Traffic', 'class' => 'besticky c4', 'content' => 'Traffic'],
        ['title' => 'TT No. The assigned APRS TT number.', 'class' => 'besticky c5', 'width' => '5%', 'oncontextmenu' => "whatIstt();return false;", 'content' => 'tt#'],
        ['title' => 'Band', 'class' => 'besticky c23', 'width' => '5%', 'content' => 'Band'],
        ['title' => 'Facility', 'class' => 'besticky cent c33', 'oncontextmenu' => "clearFacilityCookie();return false;", 'content' => 'Facility'],
        ['title' => 'onsite', 'class' => 'besticky c34', 'oncontextmenu' => "showFacilityColumn();return false;", 'content' => 'On Site'],
        ['title' => 'Call Sign', 'class' => 'besticky c6', 'oncontextmenu' => "heardlist()", 'content' => 'Callsign'],
        ['title' => 'First Name', 'class' => 'besticky c7', 'content' => 'First Name'],
        ['title' => 'Last Name', 'class' => 'besticky c8', 'content' => 'Last Name'],
        ['title' => 'Tactical Call, Click to change. Or type DELETE to delete entire row.', 'class' => 'besticky c9', 'oncontextmenu' => "Clear_All_Tactical()", 'content' => 'Tactical'],
        ['title' => 'Phone, Enter phone number.', 'class' => 'besticky c10', 'content' => 'Phone'],
        ['title' => 'email, Enter email address.', 'class' => 'besticky c11', 'oncontextmenu' => "sendGroupEMAIL()", 'content' => 'eMail'],
        ['title' => 'Grid, Maidenhead grid square location.', 'class' => 'besticky c20', 'content' => 'Grid'],
        ['title' => 'Latitude', 'class' => 'besticky c21', 'content' => 'Latitude'],
        ['title' => 'Longitude', 'class' => 'besticky c22', 'content' => 'Longitude'],
        ['title' => 'Time In, Not for edit.', 'class' => 'besticky c12', 'content' => 'Time In'],
        ['title' => 'Time Out, Not for edit.', 'class' => 'besticky c13', 'content' => 'Time Out'],
        ['title' => 'Comments, All comments are saved.', 'class' => 'besticky c14', 'content' => 'Time Line<br>Comments'],
        ['title' => 'Credentials', 'class' => 'besticky c15', 'content' => 'Credentials'],
        ['title' => 'Time On Duty', 'class' => 'besticky c16', 'content' => 'Time On Duty'],
        ['title' => 'County', 'class' => 'besticky c17', 'content' => 'County'],
        ['title' => 'City', 'class' => 'besticky c35', 'content' => 'City'],
        ['title' => 'State', 'class' => 'besticky c18', 'content' => 'State'],
        ['title' => 'District', 'class' => 'besticky c59', 'content' => 'Dist'],
        ['title' => 'W3W, Enter a What 3 Words location.', 'class' => 'besticky c24', 'oncontextmenu' => "openW3W();", 'content' => 'W3W'],
        ['title' => 'Team', 'class' => 'besticky c30', 'content' => 'Team'],
        ['title' => 'APRS_CALL', 'class' => 'besticky c31', 'content' => 'APRS CALL'],
        ['title' => 'Country', 'class' => 'besticky c32', 'content' => 'Country'],
        ['title' => 'recordID', 'class' => 'besticky c25', 'content' => 'recordID'],
        ['title' => 'ID', 'class' => 'besticky c26', 'content' => 'ID'],
        ['title' => 'status', 'class' => 'besticky c27', 'content' => 'status'],
        ['title' => 'home', 'class' => 'besticky c28', 'content' => 'home'],
        ['title' => 'ipaddress', 'class' => 'besticky c29', 'content' => 'ipaddress']
    ];
} // END getHeaderDefinitions()

// New function to create the entire table structure
function createTableStructure() {
    $headers = getHeaderDefinitions();
    
    $tableHtml = '<table id="thisNet">' . "\n";
    $tableHtml .= '  <thead id="thead" class="forNums" style="text-align: center;">' . "\n";
    $tableHtml .= '    <tr>' . "\n";
    
    foreach ($headers as $header) {
        $tableHtml .= '      <th';
        foreach ($header as $attr => $value) {
            if ($attr !== 'content') {
                $tableHtml .= ' ' . $attr . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        $tableHtml .= '>' . $header['content'] . '</th>' . "\n";
    }
    
    $tableHtml .= '    </tr>' . "\n";
    $tableHtml .= '  </thead>' . "\n";
    $tableHtml .= '  <tbody id="netBody">' . "\n";
    $tableHtml .= '    <!-- Rows will be dynamically added here -->' . "\n";
    $tableHtml .= '  </tbody>' . "\n";
    $tableHtml .= '</table>' . "\n";
    
    return $tableHtml;
} // End createTableStructure()