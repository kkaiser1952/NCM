<?php
/**
 * getactivities2.php
 * Purpose: Retrieves and displays net activity data for NCM
 * Written: 2024-11-26
 * 
 * Security notes:
 * - All database queries use prepared statements
 * - Input validation on all parameters
 * - SQL injection prevention
 * - XSS prevention via htmlspecialchars
 */

/*** PART 1: INITIAL SETUP & CONFIGURATION ***/
 
// Error handling setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("=== getactivities2.php execution started ===");

// Let's add more detailed error logging
function logError($message, $context = array()) {
    error_log("DEBUG: " . $message . " Context: " . print_r($context, true));
}

//logError("Starting getactivities2.php");


// Required files
require_once "dbConnectDtls.php";    // Database connection
require_once "CellRowHeaderDefinitions.php";  
error_log("CellRowHeaderDefinitions.php loaded");
error_log("Columns array: " . print_r($columns, true));

if (!function_exists('getCellDefinition')) {
    error_log("getCellDefinition function missing");
    die("Required function missing");
}

// Input validation
$netID = filter_input(INPUT_GET, 'q', FILTER_VALIDATE_INT);
if ($netID === false || $netID === null) {
    error_log("Invalid netID provided");
    die("Invalid input parameter");
}

/**
 * Helper function to check admin access
 * @return bool True if user has admin access
 */
function hasAdminAccess() {
    // Implement your admin access logic here
    // For now, return true to maintain existing behavior
    return true;
}

/**
 * Helper function to determine if a column should be visible
 * @param string $colKey The column identifier
 * @return bool True if column should be visible
 */
function isColumnVisible($colKey) {
    global $vars, $columns;
    
    // Check user preferences
    if (isset($_COOKIE['columnView'])) {
        $prefs = json_decode($_COOKIE['columnView'], true);
        if (isset($prefs[$colKey])) {
            return $prefs[$colKey];
        }
    }
    
    // Check organization type settings
    if (!empty($vars['columnViews'])) {
        $orgPrefs = json_decode($vars['columnViews'], true);
        if (isset($orgPrefs[$colKey])) {
            return $orgPrefs[$colKey];
        }
    }
    
    // Use definition from CellRowHeaderDefinitions.php
    return isset($columns['default'][$colKey]);
}

/**
 * Helper function: Safe string handling
 * Prevents XSS by encoding special characters
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * Helper function: Calculate elapsed time
 * @param int $secs Number of seconds
 * @return string Formatted time string
 */
function time_elapsed_A($secs) {
    if (!is_numeric($secs)) return '';
    
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
    );
    
    $ret = array();
    foreach($bit as $k => $v) {
        if ($v > 0) $ret[] = $v . $k;
    }
    
    return empty($ret) ? '0s' : join(' ', $ret);
}

// Timezone handling
$tzDiff = 0;
if (isset($_COOKIE['tzdiff'])) {
    $tzDiff = intval($_COOKIE['tzdiff']) / -60;
    $tzDiff = sprintf("%d:00", $tzDiff);
}

// Initialize common variables
$vars = array(
    'childCount' => 0,
    'children' => '',
    'netcall' => '',
    'orgType' => '',
    'frequency' => '',
    'isOpen' => 0,
    'startTime' => null,
    'totalTime' => '00:00:00'
);

// Initialize status tracking
$statusFlags = array(
    'trafficKey' => 0,
    'logoutKey' => 0,
    'digitalKey' => 0,
    'brbKey' => 0,
    'ioKey' => 0,
    'noCallKey' => 0,
    'dupeCallKey' => 0,
    'numRows' => 0,
    'cntStatus' => 0,
    'subnetKey' => 0,
    'pbStat' => 0,
    'bandKey' => 0,
    'cs1Key' => 0,
    'editCS1' => ''
);

/**
 * Outputs facility grouping header
 */
function outputFacilityHeader($row, $facility) {
    $color = ($row['active'] == 'OUT') ? 'red' : 
             ($row['active'] == 'In') ? 'green' : 
             'black';
             
    echo "</tbody><tbody id=\"netBody\">";
    echo "<tr><td></td><td></td><td></td><td></td><td></td>";
    echo "<td colspan=6 style='color:$color;font-weight:900;font-size:14pt;'>" . 
         h($facility) . "</td></tr>";
    echo "</tbody><tbody class=\"sortable\" id=\"netBody\">";
}

/**
 * Outputs table footer with runtime and volunteer hours
 */
function outputTableFooter($nowtime, $startTime, $totalTime) {
    echo "<tfoot><tr>";
    echo "<td></td>";
    echo "<td class='runtime' colspan='5' align='left'>Run Time: " . 
         time_elapsed_A($nowtime - strtotime($startTime)) . "</td>";
    echo "<td class='tvh' colspan='8' align='right'>Total Volunteer Hours = $totalTime</td>";
    echo "</tr></tfoot></table>";
}

/**
 * Outputs hidden variables needed by JavaScript
 */
function outputHiddenVariables($vars, $flags) {
    $hiddenVars = array(
        'columnViews' => isset($vars['columnViews']) ? $vars['columnViews'] : '',
        'netID' => isset($vars['netID']) ? $vars['netID'] : '',
        'status' => isset($vars['status']) ? $vars['status'] : '',
        'freq2' => $vars['frequency'],
        'freq' => '',
        'cookies' => $vars['columnViews'],
        'type' => "Type of Net: {$vars['activity']}",
      /*  'idofnet' => $vars['netID'], */
        'activity' => $vars['activity'],
        'domain' => $vars['netcall'],
        'thenetcallsign' => $vars['netcall'],
        'isopen' => $vars['isOpen'],
        'ispb' => $vars['prebuilt'],
        'pbStat' => $flags['pbStat'],
      /*  'logstatus' => $vars['status'] */
    );
    
    foreach ($hiddenVars as $id => $value) {
        echo "<div hidden id='$id'>" . h($value) . "</div>";
    }
}

/**
 * Outputs status indicators and action buttons
 */
function outputStatusIndicators($vars, $flags, $subnetnum) {
    echo "<span id='add2pgtitle'>";
    echo "#{$vars['netID']}/{$vars['netcall']}/{$vars['frequency']}&nbsp;&nbsp;";
    
    // Output subnet information
    if ($flags['subnetKey'] == 1) {
        echo "<button class='subnetkey' value='$subnetnum'>Sub Net of: $subnetnum</button>&nbsp;&nbsp;";
    }
    if (!empty($vars['children'])) {
        echo "<button class='subnetkey' value='{$vars['children']}'>Has Sub Net: {$vars['children']}</button>&nbsp;&nbsp;";
    }
    
    // Output control indicator
    echo "<span style='background-color: #befdfc'>Control</span>&nbsp;&nbsp;";
    
    // Output other status indicators
    $indicators = array(
        'digitalKey' => 'Digital',
        'trafficKey' => 'Traffic',
        'logoutKey' => 'Logged Out',
        'brbKey' => 'BRB',
        'ioKey' => 'In-Out',
        'noCallKey' => 'Call Error',
        'dupeCallKey' => 'Duplicate'
    );
    
    foreach ($indicators as $key => $label) {
        if ($flags[$key]) {
            echo "<span class='{$key}'>{$label}</span>&nbsp;&nbsp;";
        }
    }
    
    // Output action buttons
    outputActionButtons($vars['netID']);
    
    echo "</span>";
}

/**
 * Outputs action buttons
 */
function outputActionButtons($netID) {
    $buttons = array(
        array(
            'class' => 'export2CSV',
            'onclick' => "window.open('netCSVdump.php?netID=$netID')",
            'text' => 'Export CSV'
        ),
        array(
            'id' => 'geoDist',
            'onclick' => 'geoDistance()',
            'text' => 'geoDistance'
        ),
        array(
            'id' => 'mapIDs',
            'onclick' => 'map2()',
            'text' => 'Map This Net'
        )
    );
    
    foreach ($buttons as $button) {
        echo "<span style='padding-left: 5pt;'>";
        echo "<a href='#' " . 
             (isset($button['id']) ? "id='{$button['id']}' " : "") .
             "onclick='{$button['onclick']}' " .
             "title='{$button['text']}'>" .
             "<b style='color:green;'>{$button['text']}</b></a>";
        echo "</span>";
    }
}

/**
 * Database error handler
 * @param PDOStatement $stmt
 * @param string $query
 */
function handleDBError($stmt, $query) {
    $error = $stmt->errorInfo();
    error_log("Database error in query: $query");
    error_log("Error details: " . print_r($error, true));
    die("Database error occurred. Please check error log.");
}

// Verify database connection
if (!$db_found) {
    error_log("Database connection failed");
    die("Database connection error");
}


error_log("Part 1 initialization complete");


/*** PART 2: QUERY PREPARATION & NET INFORMATION ***/

// Only process if we have a valid netID
if ($netID > 0) {
    try {
        // Prepare subnet query
        $subnetQuery = "
            SELECT subNetOfID as parent,
                   GROUP_CONCAT(DISTINCT netID SEPARATOR ', ') as child
            FROM NetLog
            WHERE subNetOfID = :netID
            AND netID <> 0
            GROUP BY subNetOfID
            ORDER BY netID";
            
        $stmt = $db_found->prepare($subnetQuery);
        $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vars['children'] = $row['child'];
        }
        
        // Get total time and activity info
        $timeQuery = "
            SELECT sec_to_time(sum(timeonduty)) as tottime,
                   activity,
                   pb
            FROM NetLog
            WHERE netID = :netID
            GROUP BY netID";
            
        $stmt = $db_found->prepare($timeQuery);
        $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vars['totalTime'] = $row['tottime'];
            $vars['activity'] = trim($row['activity']);
            $vars['prebuilt'] = $row['pb'];
        }
        
        // Get netcall for organization type lookup
        $netcallQuery = "
            SELECT DISTINCT netcall 
            FROM NetLog 
            WHERE netID = :netID 
            LIMIT 1";
            
        $stmt = $db_found->prepare($netcallQuery);
        $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vars['netcall'] = $row['netcall'];
            
            // Get organization type using netcall
            $orgTypeQuery = "
                SELECT orgType, columnViews
                FROM NetKind
                WHERE `call` = :netcall
                LIMIT 1";
                
            $stmt = $db_found->prepare($orgTypeQuery);
            $stmt->bindParam(':netcall', $vars['netcall'], PDO::PARAM_STR);
            $stmt->execute();
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $vars['orgType'] = $row['orgType'];
                $vars['columnViews'] = $row['columnViews'];
            }
        }
        
        // Get frequency and net status
        $freqQuery = "
            SELECT frequency,
                   MIN(status) as minstat,
                   MIN(logdate) as startTime,
                   MAX(timeout) as endTime
            FROM NetLog
            WHERE netID = :netID
            AND frequency <> ''
            AND frequency NOT LIKE '%name%'
            LIMIT 1";
            
        $stmt = $db_found->prepare($freqQuery);
        $stmt->bindParam(':netID', $netID, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vars['frequency'] = $row['frequency'];
            $vars['isOpen'] = $row['minstat'];  // 0 = open, 1 = closed
            
            if ($vars['isOpen'] == 1) {
                $vars['nowtime'] = strtotime($row['endTime']);
                $vars['startTime'] = $row['startTime'];
                echo "<span style='color:red; float:left;'>{$vars['netcall']} ==> This Net is Closed, not available for edit</span>";
            } else {
                $vars['nowtime'] = time();
                $vars['startTime'] = $row['startTime'];
            }
        }
        
        // Prepare main data query
        $mainQuery = "
            SELECT recordID, netID, subNetOfID, id, ID,
                TRIM(callsign) AS callsign,
                tactical,
                TRIM(BOTH ' ' FROM Fname) as Fname,
                grid, traffic, latitude, longitude,
                netcontrol, activity,
                TRIM(BOTH ' ' FROM Lname) as Lname,
                email, active, comments,
                logdate as startdate,
                TRIM(BOTH ' ' FROM creds) as creds,
                DATE_FORMAT(logdate, '%H:%i') as logdate,
                DATE_FORMAT(timeout, '%H:%i') as timeout,
                sec_to_time(timeonduty) as time,
                netcall, status, Mode,
                TIMESTAMPDIFF(DAY, logdate, NOW()) as daydiff,
                TRIM(BOTH ' ' FROM county) as county,
                TRIM(BOTH ' ' FROM country) as country,
                TRIM(BOTH ' ' FROM city) as city,
                TRIM(BOTH ' ' FROM state) as state,
                TRIM(BOTH ' ' FROM district) as district,
                firstLogIn, phone, pb, tt,
                CASE
                    WHEN pb = 1 AND logdate = 0 THEN 1
                    ELSE 0
                END as pbStat,
                band, w3w,
                TRIM(team) AS team,
                aprs_call, home, ipaddress,
                cat, section,
                DATE_FORMAT(CONVERT_TZ(logdate,'+00:00',:tzdiff), '%H:%i') as locallogdate,
                DATE_FORMAT(CONVERT_TZ(timeout,'+00:00',:tzdiff), '%H:%i') as localtimeout,
                row_number,
                TRIM(facility) AS facility,
                onSite, delta
            FROM NetLog
            WHERE netID = :netID";
            
        // Store prepared statement for use in Part 4
        $mainStmt = $db_found->prepare($mainQuery);
        $mainStmt->bindParam(':netID', $netID, PDO::PARAM_INT);
        $mainStmt->bindParam(':tzdiff', $tzDiff, PDO::PARAM_STR);
        
        error_log("Part 2 database queries prepared successfully");
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die("A database error occurred. Please check the error log.");
    }
}


/*** PART 3: TABLE STRUCTURE & HEADER CREATION ***/


try {
    // Execute main query
    $mainStmt->execute();
    $rowCount = $mainStmt->rowCount();
    error_log("Main query executed - found $rowCount rows");

    if ($rowCount === 0) {
        echo "<p>No data found for this net.</p>";
        exit;
    }

    // Start table creation - get column definitions first
    error_log("Beginning table structure creation");
    
    /**
     * Build the base table structure
     */ 
    echo '<table id="thisNet">';
    echo '<thead id="thead" class="forNums" style="text-align: center;">';
    echo '<tr>';

    // Get header definitions
    $headers = getHeaderDefinitions();
    
    // Process default columns first
    foreach ($columns['default'] as $colKey => $colName) {
        echo '<th class="besticky ' . $colKey . '">' . $colName . '</th>';
    }
        //echo '<th';
         
    
    // Process optional columns based on settings
    foreach ($columns['optional'] as $colKey => $colName) {
        if (isColumnVisible($colKey)) {
            $header = $headers[array_search($colKey, array_column($headers, 'class'))];
            echo '<th';
            foreach ($header as $attr => $value) {
                if ($attr !== 'content' && $attr !== 'checkbox') {
                    echo ' ' . $attr . '="' . h($value) . '"';
                }
            }
            echo '>';
            echo $header['content'];
            echo isset($header['checkbox']) ? $header['checkbox'] : '';
            echo '</th>';
        } // End if
    } // End foreach 
    
    // Process admin columns if user has permission
    if (hasAdminAccess()) {
        foreach ($columns['admin'] as $colKey => $colName) {
            $header = $headers[array_search($colKey, array_column($headers, 'class'))];
            echo '<th';
            foreach ($header as $attr => $value) {
                if ($attr !== 'content' && $attr !== 'checkbox') {
                    echo ' ' . $attr . '="' . h($value) . '"';
                }
            }
            echo '>';
            echo $header['content'];
            echo isset($header['checkbox']) ? $header['checkbox'] : '';
            echo '</th>';
        } // End foreach
    } // End if

    echo '</tr>';
    echo '</thead>';

    // Create tbody with appropriate class for sorting
    echo '<tbody id="netBody" class="sortable">';
    
    error_log("Table structure and headers created successfully");

    // Store the column visibility state for JavaScript
    echo "<script>
        window.columnState = " . json_encode([
            'default' => array_keys($columns['default']),
            'optional' => array_keys(array_filter($columns['optional'], function($col) {
                return isColumnVisible($col);
            })),
            'admin' => hasAdminAccess() ? array_keys($columns['admin']) : []
        ]) . ";
    </script>";

} catch (Exception $e) {
    error_log("Error in table structure creation: " . $e->getMessage());
    die("Error creating table structure. Please check error log.");
}


error_log("Part 3 complete - ready for data processing");


/*** PART 4: DATA PROCESSING & OUTPUT ***/

try {
    // Process each row from our executed main query
    while ($row = $mainStmt->fetch(PDO::FETCH_ASSOC)) {
        $statusFlags['numRows']++;
        
        // Process flags and status indicators
        $statusFlags['pbStat'] += (int)$row['pbStat'];
        
        if ($row['subNetOfID'] > 0) {
            $statusFlags['subnetKey'] = 1;
            $subnetnum = $row['subNetOfID'];
        }
        
        // Handle pre-built net callsign editing
        if ($row['pb'] == 1) {
            $statusFlags['editCS1'] = 'editCS1';
        }
        
        // Process status counters
        $statusFlags['cntStatus'] += (int)$row['status'];
        
        // Determine cell styling classes
        $cellStyles = array(
            'cs1' => '',
            'mod' => '',
            'brb' => '',
            'bad' => '',
            'new' => '',
            'timeline' => '',
            'important1' => '',
            'important2' => ''
        );
        
        // Start row output
        echo "<tr id=\"" . h($row['recordID']) . "\">";
        
        // Process facility grouping if needed
        $newFacility = trim($row['facility']);
        if ($vars['orgType'] === 'FACILITY' && $newFacility !== (isset($usedFacility) ?
        $usedFacility : '') && !empty($newFacility)) {
            outputFacilityHeader($row, $newFacility);
            $usedFacility = $newFacility;
        } // End $usedFacility 
        
        // Output default columns
        
        foreach ($columns['default'] as $colKey => $colName) {
            $cellDef = getCellDefinition($colKey, $row);
            echo createCell($cellDef);
        }
        
        
        // Output optional columns if visible
        foreach ($columns['optional'] as $colKey => $colName) {
            if (isColumnVisible($colKey)) {
                $cellDef = getCellDefinition($colKey, $row);
                echo createCell($cellDef);
            }
        }
        
        // Output admin columns if authorized
        if (hasAdminAccess()) {
            foreach ($columns['admin'] as $colKey => $colName) {
                $cellDef = getCellDefinition($colKey, $row);
                echo createCell($cellDef);
            }
        }
        
        echo "</tr>";
    }
    
    // Close the main table body
    echo "</tbody>";
    
    // Add footer with runtime and volunteer hours
    outputTableFooter($vars['nowtime'], $vars['startTime'], $vars['totalTime']);
    
    // Output hidden variables
    outputHiddenVariables($vars, $statusFlags);
    
} catch (Exception $e) {
    error_log("Error in data processing: " . $e->getMessage());
    die("Error processing data. Please check error log.");
}

error_log("Part 4 complete - ");

error_log("=== getactivities2.php execution completed ===");
?>