<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "ENV_SETUP.php";
require_once "GridSquare.php";
require_once "config.php";
require_once "config2.php";

// Query to get station locations
$sql = "SELECT 
    n.callsign, 
    CONCAT(s.Fname, ' ', s.Lname) as name,
    s.latitude, 
    s.longitude, 
    COUNT(n.callsign) AS call_count
FROM NetLog n
JOIN stations s ON n.callsign = s.callsign
WHERE n.comments LIKE '%Opened the net%'
      AND s.latitude IS NOT NULL 
      AND s.latitude != '' 
      AND s.longitude IS NOT NULL 
      AND s.longitude != ''
GROUP BY n.callsign, s.latitude, s.longitude  
ORDER BY call_count DESC";

$stmt = $db_found->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build marker data array
$markers = array();
$bounds = array();
foreach ($results as $row) {
    $markers[] = array(
        'callsign' => $row['callsign'],
        'name' => $row['name'],
        'lat' => floatval($row['latitude']),
        'lng' => floatval($row['longitude']),
        'count' => $row['call_count']
    );
    $bounds[] = array($row['latitude'], $row['longitude']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Station Location Map</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        #map { 
            height: 100vh;
            width: 100%;
        }
        .info-box {
            padding: 6px 8px;
            background: white;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-radius: 5px;
        }
        .legend {
            line-height: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize map
        var map = L.map('map');
        
        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Parse PHP data
        var markers = <?php echo json_encode($markers); ?>;
        var bounds = <?php echo json_encode($bounds); ?>;

        // Add markers
        markers.forEach(function(station) {
            var marker = L.marker([station.lat, station.lng])
                .bindPopup(
                    '<b>Callsign:</b> ' + station.callsign + '<br>' +
                    '<b>Name:</b> ' + station.name + '<br>' +
                    '<b>Net Opens:</b> ' + station.count
                )
                .addTo(map);
        });

        // Fit map to bounds
        if (bounds.length > 0) {
            var latlngs = bounds.map(function(coord) {
                return L.latLng(coord[0], coord[1]);
            });
            map.fitBounds(L.latLngBounds(latlngs));
        } else {
            // Default center if no markers
            map.setView([39.8283, -98.5795], 4); // Center of USA
        }

        // Add scale control
        L.control.scale({
            imperial: true,
            metric: true
        }).addTo(map);

        // Add custom info control
        var info = L.control();
        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info-box');
            this.update();
            return this._div;
        };
        
        info.update = function() {
            this._div.innerHTML = '<h4>Station Information</h4>' +
                '<b>Total Stations:</b> ' + markers.length;
        };
        info.addTo(map);
    </script>
</body>
</html>