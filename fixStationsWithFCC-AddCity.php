<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');


require_once "dbConnectDtls.php";
require_once "geocode.php";
require_once "GridSquare.php";

$batchSize = 100;

$sql = "SELECT a.fccid, CONCAT(UCASE(LEFT(a.first, 1)), LCASE(SUBSTRING(a.first, 2))) AS Fname,
                CONCAT(UCASE(LEFT(a.last, 1)), LCASE(SUBSTRING(a.last, 2))) AS Lname,
                a.address1 AS address,
                CONCAT(UCASE(LEFT(a.city, 1)), LCASE(SUBSTRING(a.city, 2))) AS City,
                CONCAT(UCASE(LEFT(a.state, 1)), LCASE(SUBSTRING(a.state, 2))) AS State,
                LEFT(a.zip, 5) AS zip,
                a.callsign
        FROM (
            SELECT a.callsign, MAX(a.fccid) AS max_fccid
            FROM fcc_amateur.en a
            GROUP BY a.callsign
        ) AS max_fccids
        INNER JOIN fcc_amateur.en a
        ON max_fccids.callsign = a.callsign
           AND max_fccids.max_fccid = a.fccid
        INNER JOIN ncm.stations s
        ON a.callsign = s.callsign
        WHERE a.city <> s.city
           OR a.state <> s.state
           OR a.first <> s.Fname
           OR a.last <> s.Lname
           OR a.fccid <> s.fccid;";

$totalRecords = $db_found->query($sql)->rowCount();
$numIterations = ceil($totalRecords / $batchSize);
$count = 0;

for ($iteration = 0; $iteration < $numIterations; $iteration++) {
    $offset = $iteration * $batchSize;
    $batchSql = $sql . " LIMIT $batchSize OFFSET $offset";
    $stmt = $db_found->query($batchSql);

    foreach ($stmt as $row) {
        $count++;

        $address = $row['address'];
        $city    = $row['City'];
        $fccid   = $row['fccid'];

        $koords  = geocode("$address");
        $latitude  = $koords[0];
        $longitude = $koords[1];
        $county    = $koords[2];
        $state     = $koords[3];

        if ($state == '') {
            $state = $row['State'];
        }

        $gridd     = gridsquare($latitude, $longitude);
        $grid      = "$gridd[0]$gridd[1]$gridd[2]$gridd[3]$gridd[4]$gridd[5]";

        echo "<br><br>$count ==> {$row['callsign']}: $fccid, $address, $county, $state, $city";
        
        echo "Comparing: a.city = '{$row['city']}' <> s.city = '{$row['City']}'<br>";
        echo "Comparing: a.state = '{$row['state']}' <> s.state = '{$row['State']}'<br>";
        echo "Comparing: a.first = '{$row['first']}' <> s.Fname = '{$row['Fname']}'<br>";
        echo "Comparing: a.last = '{$row['last']}' <> s.Lname = '{$row['Lname']}'<br>";
        echo "Comparing: a.fccid = '{$row['fccid']}' <> s.fccid = '{$row['fccid']}'<br>";

        $sql2 = "UPDATE stations SET 
                     Fname = :first,
                     Lname = :last,
                     grid = :grid,
                     county = :county,
                     state = :state,
                     city = :city,
                     home = :home,
                     fccid = :fccid,
                     dttm = NOW(),
                     latitude = :latitude,
                     longitude = :longitude,
                     latlng = GeomFromText(:latlng),
                     comment = 'Updated via fixStationsWithFCC-AddCity.php'
                  WHERE id = :callsign";
        
        $stmt2 = $db_found->prepare($sql2);
        
        // Close the cursor for the previous query (if there's any)
        if ($stmt !== false) {
            $stmt->closeCursor();
        }

        $stmt2->bindValue(':first', $row['Fname']);
        $stmt2->bindValue(':last', $row['Lname']);
        $stmt2->bindValue(':grid', $grid);
        $stmt2->bindValue(':county', $county);
        $stmt2->bindValue(':state', $state);
        $stmt2->bindValue(':city', $city);
        $stmt2->bindValue(':home', "$latitude,$longitude,$grid,$county,$state,$city");
        $stmt2->bindValue(':fccid', $fccid);
        $stmt2->bindValue(':latitude', $latitude);
        $stmt2->bindValue(':longitude', $longitude);
        $stmt2->bindValue(':latlng', "POINT($latitude $longitude)");
        $stmt2->bindValue(':callsign', $row['callsign']);
    
        if ($stmt2->execute()) {
            echo "<br><br>Update successful for callsign: " . $row['callsign'];
        } else {
            echo "<br><br>Error updating callsign: " . $row['callsign'];
        }
    }
}

echo "<br><br>Done --> Count= $count";
?>
