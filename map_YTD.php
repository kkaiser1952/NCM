<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "ENV_SETUP.php";
require_once "GridSquare.php";
require_once "config.php";
require_once "config2.php";

$sql = "SELECT 
    n.callsign, 
    CONCAT(s.Fname, ' ', s.Lname) as name,
    s.latitude, 
    s.longitude, 
    CONCAT(s.city, ', ', s.state) as CityState,
    s.county,
    s.w3w,
    s.state,
    COUNT(n.callsign) AS call_count
FROM NetLog n
JOIN stations s ON n.callsign = s.callsign
WHERE n.comments LIKE '%Opened the net%'
      AND s.latitude IS NOT NULL 
      AND s.latitude != '' 
      AND s.longitude IS NOT NULL 
      AND s.longitude != ''
GROUP BY n.callsign, s.latitude, s.longitude  
ORDER BY s.state, call_count DESC";

$stmt = $db_found->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build marker data array and state data
$markers = array();
$bounds = array();
$stateData = array();
$totalOpens = 0;

foreach ($results as $row) {
    $totalOpens += intval($row['call_count']);
    
    // Build marker data
    $markers[] = array(
        'callsign' => $row['callsign'],
        'name' => $row['name'],
        'lat' => floatval($row['latitude']),
        'lng' => floatval($row['longitude']),
        'cityState' => $row['CityState'],
        'county' => $row['county'],
        'w3w' => $row['w3w'],
        'count' => intval($row['call_count']),
        'state' => $row['state']
    );
    
    // Build state data
    if (!isset($stateData[$row['state']])) {
        $stateData[$row['state']] = array();
    }
    $stateData[$row['state']][] = array(
        'callsign' => $row['callsign'],
        'name' => $row['name'],
        'city' => explode(',', $row['CityState'])[0],
        'count' => $row['call_count']
    );
    
    $bounds[] = array($row['latitude'], $row['longitude']);
}

// Sort states alphabetically
ksort($stateData);
$totalStates = count($stateData);
$totalStations = count($markers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Station Location Map</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        body { margin:0; padding:0; }
        #container { display:flex; height:100vh; }
        #sidebar {
            width:6%;
            height:100%;
            overflow-y:auto;
            background:#f8f9fa;
            padding:10px;
            box-shadow:2px 0 5px rgba(0,0,0,0.1);
            transition:width 0.3s ease;
        }
        #sidebar.expanded { width:10%; }
        #sidebar.show-stations { width:300px; }
        #map { flex-grow:1; height:100%; }
        .state-item { margin-bottom:10px; border:1px solid #ddd; border-radius:4px; overflow:hidden; }
        .state-header { background:#e9ecef; padding:10px; cursor:pointer; font-weight:bold; }
        .state-header:hover { background:#dee2e6; }
        .station-list { display:none; padding:10px; background:white; }
        .station-item { 
            margin-bottom:5px; 
            padding:5px; 
            border-bottom:1px solid #eee;
            cursor:pointer;
        }
        .station-item:hover { background:#f8f9fa; }
</style>
</head>
<body>
    <div id="container">
        <div id="sidebar">
           
            <h3>States (<?php echo $totalStations; ?>/<?php echo $totalStates; ?>)</h3>
            <?php foreach ($stateData as $state => $stations): ?>
            <div class="state-item">
                <div class="state-header" data-state="<?php echo $state; ?>">
                    <?php echo $state; ?> (<?php echo count($stations); ?>)
                </div>
                <div class="station-list" id="state-<?php echo $state; ?>">
                    <?php foreach ($stations as $station): ?>
                    <div class="station-item" data-callsign="<?php echo $station['callsign']; ?>">
                        <span class="station-count"><?php echo $station['count']; ?></span>
                        <strong><?php echo $station['callsign']; ?></strong><br>
                        <?php echo $station['name']; ?><br>
                        <?php echo $station['city']; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div id="map"></div>
    </div>

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
        var totalOpens = <?php echo $totalOpens; ?>;

        // Store markers by callsign for easy access
        var markersByCallsign = {};
        
        // Function to create popup content
        function createPopupContent(station) {
            return '<div class="station-popup">' +
                '<h3>' + station.callsign + '</h3>' +
                '<p><span class="label">Operator:</span> ' + station.name + '</p>' +
                '<p><span class="label">Location:</span> ' + station.cityState + '</p>' +
                '<p><span class="label">County:</span> ' + station.county + '</p>' +
                '<p><span class="label">Coordinates:</span> ' + 
                    station.lat.toFixed(6) + ', ' + station.lng.toFixed(6) + '</p>' +
                '<p><span class="label">what3words:</span> ' + 
                    (station.w3w ? station.w3w : 'Not available') + '</p>' +
                '<p><span class="label">Net Opens:</span> ' + station.count + '</p>' +
                '</div>';
        }

        // Add markers
        markers.forEach(function(station) {
            var marker = L.marker([station.lat, station.lng])
                .bindPopup(createPopupContent(station))
                .addTo(map);
            markersByCallsign[station.callsign] = marker;
        });

        // Fit map to bounds
        if (bounds.length > 0) {
            var latlngs = bounds.map(function(coord) {
                return L.latLng(coord[0], coord[1]);
            });
            map.fitBounds(L.latLngBounds(latlngs));
        } else {
            map.setView([39.8283, -98.5795], 4);
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
                '<div><b>Total Stations:</b> ' + markers.length.toLocaleString() + '</div>' +
                '<div><b>Total Net Opens:</b> ' + totalOpens.toLocaleString() + '</div>';
        };
        info.addTo(map);
        
        //
        // Add this after the markers are created but before the click handlers
// Group markers by state
var markersByState = {};
markers.forEach(function(station) {
    if (!markersByState[station.state]) {
        markersByState[station.state] = [];
    }
    markersByState[station.state].push([station.lat, station.lng]);
});

// Modify the state header click handler
document.querySelectorAll('.state-header').forEach(function(header) {
    header.addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        var stateList = this.nextElementSibling;
        var wasHidden = stateList.style.display === 'none' || stateList.style.display === '';
        var state = this.dataset.state;
        
        // Hide all station lists first
        document.querySelectorAll('.station-list').forEach(function(list) {
            list.style.display = 'none';
        });
        
        // Remove active class from all headers
        document.querySelectorAll('.state-header').forEach(function(h) {
            h.classList.remove('active-state');
        });

        // Remove expanded classes from sidebar
        sidebar.classList.remove('expanded', 'show-stations');

        if (wasHidden) {
            // Show this state's list and mark as active
            stateList.style.display = 'block';
            this.classList.add('active-state');
            sidebar.classList.add('show-stations');

            // Center map on state
            if (markersByState[state] && markersByState[state].length > 0) {
                var stateBounds = L.latLngBounds(markersByState[state]);
                map.fitBounds(stateBounds, {
                    padding: [50, 50],
                    maxZoom: 12
                });
            }
        }

        // Update map size after sidebar change
        if (map) {
            setTimeout(function() {
                map.invalidateSize();
            }, 300);
        }
    });
});
        //

        // Add click handlers for state headers
        // Modified click handlers for state headers
    document.querySelectorAll('.state-header').forEach(function(header) {
        header.addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            var stateList = this.nextElementSibling;
            var wasHidden = stateList.style.display === 'none' || stateList.style.display === '';
            
            // Hide all station lists first
            document.querySelectorAll('.station-list').forEach(function(list) {
                list.style.display = 'none';
            });
            
            // Remove active class from all headers
            document.querySelectorAll('.state-header').forEach(function(h) {
                h.classList.remove('active-state');
            });

            // Remove expanded classes from sidebar
            sidebar.classList.remove('expanded', 'show-stations');

            if (wasHidden) {
                // Show this state's list and mark as active
                stateList.style.display = 'block';
                this.classList.add('active-state');
                sidebar.classList.add('show-stations');
            }

            // Update map size after sidebar change
            if (map) {
                setTimeout(function() {
                    map.invalidateSize();
                }, 300);
            }
        });
    });

    // Modified click handlers for station items
    document.querySelectorAll('.station-item').forEach(function(item) {
        item.addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            var callsign = this.dataset.callsign;
            var marker = markersByCallsign[callsign];

            // Reduce sidebar width when station is selected
            sidebar.classList.remove('show-stations');
            sidebar.classList.add('expanded');

            if (marker) {
                map.setView(marker.getLatLng(), 12);
                marker.openPopup();
            }

            // Update map size after sidebar change
            if (map) {
                setTimeout(function() {
                    map.invalidateSize();
                }, 300);
            }
        });
    });
    </script>
</body>
</html>