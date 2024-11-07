<?php
// First, let's test if PHP is running
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting program...<br>";
echo "PHP is working<br>";

// fixRecordsInStations.php
// Written: 2024-11-05
// There is an extensive writeup at the bottom of the code

// Test array handling
$callsign_list = "KQ4FCR  KN4FIQ  WL7BDH W0za w0zb";
echo "Callsign list: " . htmlspecialchars($callsign_list) . "<br>";

$callsigns = preg_split('/\s+/', trim($callsign_list));
echo "Number of callsigns: " . count($callsigns) . "<br>";

// Test database connection
try {
    require_once "dbConnectDtls.php";
    echo "Database connection file loaded<br>";
} catch (Exception $e) {
    echo "Database connection error: " . htmlspecialchars($e->getMessage()) . "<br>";
}

// After the database connection test, add this:
try {
    $test_sql = "SELECT 1 FROM stations LIMIT 1";
    $test_stmt = $db_found->prepare($test_sql);
    $test_stmt->execute();
    echo "Database query test successful<br>";
    
    // Test the other required files
    require_once "config2.php";
    require_once "GridSquare.php";
    require_once "getCrossRoads.php";
    require_once "geocode.php";
    echo "All required files loaded<br>";
    
    echo "<hr>Beginning main processing...<br>";
} catch (Exception $e) {
    echo "Setup error: " . htmlspecialchars($e->getMessage()) . "<br>";
    exit;
}
function processCallsign($callsign) {
    global $db_found, $config;  // Access to database and config
    
    echo "<br>DEBUG: Starting to process callsign: " . htmlspecialchars($callsign) . "<br>";
    
    try {
        echo "DEBUG: Preparing FCC query<br>";
        
        // Step 2-3: Get address, first, last from the FCC en
        $sql = "SELECT e1.fccid, e1.callsign, e1.first, e1.last, e1.city, e1.zip,
            CONCAT(e1.address1, '  ', e1.city, '  ', e1.state, '  ', e1.zip) as address
            FROM fcc_amateur.en e1
            JOIN (
                SELECT MAX(fccid) as max_fccid 
                FROM fcc_amateur.en 
                WHERE callsign = :callsign
            ) e2 ON e1.fccid = e2.max_fccid
            WHERE e1.callsign = :callsign
            LIMIT 1";

        echo "DEBUG: About to prepare statement<br>";
        $stmt = $db_found->prepare($sql);
        
        echo "DEBUG: About to bind parameter<br>";
        $stmt->bindParam(':callsign', $callsign);
        
        echo "DEBUG: About to execute<br>";
        $stmt->execute();
        
        echo "DEBUG: About to fetch<br>";
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
            throw new Exception("No FCC record found");
        }

        // Rest of your function code here...
        
        return true;

    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
} // End of processCallsign function

// Now add the main processing loop
$total = count($callsigns);
$current = 0;
$successful = 0;
$failed = 0;

echo "<h3>Processing $total callsign(s)</h3>";

// Process each callsign
foreach ($callsigns as $callsign) {
    $current++;
    try {
        processCallsign(strtoupper(trim($callsign)));
        $successful++;
        echo "<br>Successfully processed callsign #$current: $callsign";
    } catch (Exception $e) {
        $failed++;
        echo "<br>Error processing callsign #$current ($callsign): " . htmlspecialchars($e->getMessage());
    }
    
    echo "<br>Progress: $current of $total (Success: $successful, Failed: $failed)<br>";
}

// Final summary
echo "<br><hr><br>";
echo "Completed processing $total callsign(s)<br>";
echo "Successful: $successful<br>";
echo "Failed: $failed<br>";

?>