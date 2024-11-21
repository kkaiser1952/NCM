<?php
// This PHP is called by NetManager-p2.js

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log'); // Set to a writable path
error_reporting(E_ALL);

require_once "dbConnectDtls.php";
require_once "WXdisplay.php";
require_once "wx.php";

$q = strip_tags(substr($_POST["q"], 0, 100));             
$parts = explode(":", $q);
$cs1 = strtoupper($parts[0]);
$netcall = strtoupper($parts[1]);
$newnetnm = $parts[2];
$frequency = $parts[3];
$subNetOfID = $parts[4];
$netKind = $parts[5];
$pb = $parts[6];
$testEmail = $parts[7];
$testnet = $parts[8];
$activity = ltrim($newnetnm) . " " . ltrim($netKind);

$pbspot = ($pb == 1) ? 'PB' : '';

// Get next netID
$stmt = $db_found->prepare("SELECT max(netID) FROM NetLog LIMIT 1");
$stmt->execute();
$newNetID = $stmt->fetchColumn() + 1;

// Get station details
$stmt = $db_found->prepare("
    SELECT MAX(recordID) AS maxID, MAX(id) as newid, id, Fname, Lname, 
           creds, email, latitude, longitude, grid, county, state, 
           district, home, phone, tactical, city
    FROM stations 
    WHERE callsign = :callsign
    LIMIT 0,1
");
$stmt->execute(['callsign' => $cs1]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$maxID = $result['maxID'];
$id = $result['id'];
$newid = $result['newid'];
$latitude = $result['latitude'];
$longitude = $result['longitude'];
$Fname = ucwords(strtolower($result['Fname']));
$Lname = ucwords(strtolower($result['Lname']));
$state = $result['state'];
$grid = $result['grid'];
$county = ucwords(strtolower($result['county']));
$creds = $result['creds'];
$district = $result['district'];
$email = $result['email'] == ' ' ? $testEmail : $result['email'];
$home = $result['home'];
$phone = ' ';
$city = $result['city'];
$firstLogIn = 0;

if (is_null($maxID)) {
    $stmt = $db_found->prepare("SELECT MAX(ID)+1 AS newid FROM stations LIMIT 0,1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $result['newid'];
    $from = 'FCC';
}

// Handle pre-built status
$statusValue = $pb == 1 ? 'OUT' : 'In';
$timeLogIn = $pb == 1 ? 0 : $open;

if ($pb == 1) {
    $PBcomment = 'Pre-Build Template Net for use at a later date';
    $stmt = $db_found->prepare("
        INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp) 
        VALUES (:recordID, :ID, :netID, 'GENCOMM', :comment, :timestamp)
    ");
    $stmt->execute([
        'recordID' => $maxID,
        'ID' => $id,
        'netID' => $newNetID,
        'comment' => $PBcomment,
        'timestamp' => $open
    ]);
}

// Insert into NetLog
// Insert into NetLog
$stmt = $db_found->prepare("
    INSERT INTO NetLog (
        netcontrol, active, callsign, Fname, Lname, activity, tactical, 
        id, netID, grid, latitude, longitude, creds, email, comments, 
        frequency, subNetOfID, logdate, netcall, state, county, city,
        district, pb, tt, firstLogin, home, testnet, phone
    ) VALUES (
        :netcontrol, :statusValue, :cs1, :Fname, :Lname, :activity, :tactical,
        :id, :netID, :grid, :latitude, :longitude, :creds, :email, :comments,
        :frequency, :subNetOfID, :timeLogIn, :netcall, :state, :county, :city,
        :district, :pb, :tt, :firstLogIn, :home, :testnet, :phone
    )
");

$params = [
    'netcontrol' => 'PRM',
    'statusValue' => $statusValue,
    'cs1' => $cs1,
    'Fname' => $Fname,
    'Lname' => $Lname,
    'activity' => $activity,
    'tactical' => 'Net',
    'id' => $id,
    'netID' => $newNetID,
    'grid' => $grid,
    'latitude' => $latitude,
    'longitude' => $longitude,
    'creds' => $creds,
    'email' => $email,
    'comments' => 'Opened NCM',
    'frequency' => $frequency,
    'subNetOfID' => $subNetOfID,
    'timeLogIn' => $timeLogIn,
    'netcall' => $netcall,
    'state' => $state,
    'county' => $county,
    'city' => $city,
    'district' => $district,
    'pb' => $pb,
    'tt' => '00',
    'firstLogIn' => $firstLogIn,
    'home' => $home,
    'testnet' => $testnet,
    'phone' => $phone
];

try {
    $stmt->execute($params);
} catch (PDOException $e) {
    error_log("Error with callsign: " . $cs1);
    error_log("SQL Error: " . $e->getMessage());
    error_log("Parameters: " . print_r($params, true));
    throw $e;
}

// Insert creation time and weather
$wxNOW = currentWX();
$ipaddress = getRealIpAddr();

$comment = "$Fname $Lname Opened the $pbspot net from $ipaddress on $frequency by: $testEmail";
if ($subNetOfID > 0) {
    $comment .= ". Opened as a subnet of #$subNetOfID.";
}

$stmt = $db_found->prepare("
    INSERT INTO TimeLog (recordID, ID, netID, callsign, comment, timestamp, ipaddress)
    VALUES (:recordID, :ID, :netID, :callsign, :comment, :timestamp, :ipaddress)
");
$stmt->execute([
    'recordID' => $maxID,
    'ID' => $id,
    'netID' => $newNetID,
    'callsign' => $cs1,
    'comment' => $comment,
    'timestamp' => $open,
    'ipaddress' => $ipaddress
]);

$stmt->execute([
    'recordID' => $maxID,
    'ID' => '0',
    'netID' => $newNetID,
    'callsign' => 'WEATHER',
    'comment' => $wxNOW,
    'timestamp' => $open,
    'ipaddress' => $ipaddress
]);

// Handle subnet relationships
if ($subNetOfID > 0) {
    $stmt = $db_found->prepare("SELECT subNetOfID FROM NetLog WHERE netID = :netID");
    $stmt->execute(['netID' => $subNetOfID]);
    $curr_sub_nets = $stmt->fetchColumn();
    $newList = $curr_sub_nets . "+" . $newNetID;
}

echo $newNetID;
?>