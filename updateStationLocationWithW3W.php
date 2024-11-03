<!doctype html>
<?php 
    /* updateStationLocationWithW3W.php */
    /* Use this program to update the stations table */
    /* Use the callsign to look up the street address from the */
    /* en table in the FCC database. Then add the callsign and */
    /* that address in the fields below.     */
    /* This program uses the W3W address to calculate lat/lon, grid, county, state etc. and update the stations table */
    /* The value for county is from getCountyFromCensus.php using the census API */
    /* REQUIRED: a callsign and the What3Words address
    /* Writte: 2021-10-15 */
    /* Updated: 2024-10-23 */
    /* .us Version */
    


ini_set('display_errors', 1);
error_reporting(E_ALL);

// Path settings and imports
require_once "dbConnectDtls.php";
require_once "GridSquare.php";
require_once "geocode.php";
require_once "config.php";
require_once "/var/www/NCM/getCounty_by_Census.php"; // Ensure this path is correct

// Instantiate W3W API and set callsign
//$api = new Geocode("5WHIM4GD");
$callsign = 'W0DLK';
$w3w = '///guiding.confusion.towards';

// Get coordinates from W3W
$w3wLL = $api->convertToCoordinates($w3w);
$lat = $w3wLL['coordinates']['lat'];
$lng = $w3wLL['coordinates']['lng'];
$country = $w3wLL['country'];

// Get grid square
$grid = gridsquare($lat, $lng);

// Get county and state
$countyResult = getCounty_by_Census($lat, $lng);
if (is_array($countyResult)) {
    $county = $countyResult['county'];
    $state = $countyResult['state'];
    echo "County: $county, State: $state";
} else {
    echo "Error getting county: " . $countyResult;
}  

// FCC database query to get address
try {
    $sql = "
        SELECT last, first, state, city, zip, CONCAT_WS(' ', address1, city, state, zip) AS address, fccid
        FROM fcc_amateur.en e1
        WHERE callsign = :callsign 
        AND e1.fccid = (SELECT MAX(e2.fccid) FROM fcc_amateur.en e2 WHERE e2.callsign = :callsign)
        ORDER BY e1.fccid DESC 
        LIMIT 1";
    $fccsql = $db_found->prepare($sql);
    $fccsql->bindParam(':callsign', $callsign, PDO::PARAM_STR);
    $fccsql->execute();
    $result = $fccsql->fetch(PDO::FETCH_ASSOC);

    $fccid = $result['fccid'];
    $Lname = ucfirst(strtolower($result['last'])); 
    $Fname = ucfirst(strtolower($result['first']));
    $state = $result['state'];
    $city = $result['city'];
    $zip = $result['zip'];
    $address = $result['address'];

    print_r($result);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Prepare the SQL update statement
$sql = "
    UPDATE stations 
    SET latitude = $lat,
        longitude = $lng,
        grid = '$grid',
        county = '$county',
        city = '$city',
        state = '$state',
        home = '$lat,$lng,$grid,$county,$state,$city,$w3w',
        fccid = $fccid,
        active_call = 'y',
        country = '$country',
        dttm = NOW(),
        comment = 'via: updateStationLocationWithW3W',
        zip = '$zip',
        w3w = '$w3w'
    WHERE callsign = '$callsign'
";

echo "SQL that would be executed:<br><pre>$sql</pre>";
// $db_found->exec($sql); Uncomment to execute
?>
