<?php
    //require_once "dbConnectDtls.php";  // Access to MySQL
    //require_once "wx.php";			   // Makes the weather information available
    //require_once "NCMStats.php";       // Get some stats
    // 2023-09-26
    
    if (!$db_found) { require_once "dbConnectDtls.php";
    //die("Error: Database connection is not established. Check database credentials. <-- From buildOptionsForSelect_Proposed.php");
    }

try {
    //$db_found = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    //$db_found->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $groupList = '';
    $kindList = '';
    $freqList = '';

    // Query to retrieve data for the first dropdown
    $query = $db_found->prepare("
        SELECT t1.id, t1.call, t1.orgType, t1.org, t1.freq, t1.kindofnet,
               t2.kindofnet AS dfltKon, t3.freq AS dfltFreq,
               CHAR_LENGTH(t1.orgType) AS otl,
               CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.call,';',t1.org) AS id2,
               CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.kindofnet) AS id3,
               REPLACE(CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.freq),' ','') AS id4  
        FROM NetKind t1
        LEFT JOIN NetKind t2 ON t1.dflt_kind = t2.id
        LEFT JOIN NetKind t3 ON t1.dflt_freq = t3.id
        ORDER BY orgType, org
    ");
    
    $query->execute();
    $netResults = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($netResults as $net) {
        if ($net['call'] !== '') {
            $l = (52 - $net['otl']) / 2;
            $e = str_repeat("=", $l);
            $groupList .= "<a href='#{$net['id2']}' onclick='putInGroupInput(this);'>{$net['call']} ---> {$net['org']}</a>\n";
        }
        $thisOrgType = $net['orgType'];
    }

    // Query to retrieve data for the second dropdown
    $query = $db_found->prepare("
        SELECT CONCAT(t2.id,';',t2.kindofnet) as id3, kindofnet
        FROM NetKind t2
        WHERE t2.kindofnet <> ''
        ORDER BY kindofnet
    ");
    $query->execute();
    $kindResults = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($kindResults as $net) {
        $kindList .= "<a href='#{$net['id3']}' onclick='putInKindInput(this);'>{$net['kindofnet']}</a>\n";
    }

    // Query to retrieve data for the third dropdown
    $query = $db_found->prepare("
        SELECT CONCAT(t1.id,';',t1.freq) as id4, freq
        FROM NetKind t1
        WHERE t1.freq <> ''
        ORDER BY freq
    ");
    $query->execute();
    $freqResults = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($freqResults as $net2) {
        $freqList .= "<a href='#{$net2['id4']}' onclick='putInFreqInput(this);'>{$net2['freq']}</a>\n";
    }

    // Close the database connection
    $db_found = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Test the output 
/*
//echo "<h2>Group Dropdown:</h2>";
echo "<div>$groupList</div>";

//echo "<h2>Kind Dropdown:</h2>";
echo "<div>$kindList</div>";

//echo "<h2>Frequency Dropdown:</h2>";
echo "<div>$freqList</div>";
*/

?>
