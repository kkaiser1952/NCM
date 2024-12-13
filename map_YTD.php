<?php
// map_YTD.php 
// Purpose: Map every station that has started a NCM net.
// Written: 2024-12-11

ini_set('display_errors', 1); 
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";
require_once "ENV_SETUP.php";

$sql = "SELECT 
    n.callsign, 
    CONCAT(s.Fname, ' ', s.Lname) as name,
    s.latitude, 
    s.longitude, 
    CONCAT(s.city, ', ', s.state) as CityState,
    s.county,
    s.w3w,
    s.state,
    s.grid,
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
        'state' => $row['state'],
        'grid' => $row['grid']
    );
    
    // Build state data
    if (!isset($stateData[$row['state']])) {
        $stateData[$row['state']] = array();
    }
    $stateData[$row['state']][] = array(
        'callsign' => $row['callsign'],
        'name' => $row['name'],
        'city' => explode(',', $row['CityState'])[0],
        'count' => $row['call_count'],
        'grid' => $row['grid']
    );
    
    $bounds[] = array($row['latitude'], $row['longitude']);
}

// Sort states alphabetically
ksort($stateData);

// Calculate totals for header
$totalStates = count($stateData);
$totalStations = count($markers);
?>

<!-- PART 2 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Station Location Map</title>
    
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="css/L.Grid_YY.css" />
    
    <style>
        body { margin:0; padding:0; }
        #container { display:flex; height:100vh; }
        #sidebar {
            width:5%;
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
        .station-item { margin-bottom:5px; padding:5px; border-bottom:1px solid #eee; cursor:pointer; }
        .station-item:hover { background:#f8f9fa; }
        .station-count { float:right; color:#666; }
        .info-box { padding:6px 8px; background:white; background:rgba(255,255,255,0.8); box-shadow:0 0 15px rgba(0,0,0,0.2); border-radius:5px; }
        .info-box h4 { margin:0 0 5px; color:#777; }
        .leaflet-popup-content { margin:13px; line-height:1.5; }
        .station-popup { min-width:200px; }
        .station-popup h3 { margin:0 0 10px 0; color:#333; border-bottom:1px solid #ccc; padding-bottom:5px; }
        .station-popup p { margin:5px 0; }
        .station-popup .label { font-weight:bold; color:#666; }
        .active-state { background:#007bff !important; color:white; }
        .marker-radio {
            background:#3388ff;
            color:white;
            border-radius:50%;
            padding:8px;
            font-weight:bold;
            box-shadow:0 0 0 2px white, 0 2px 4px rgba(0,0,0,0.3);
            text-align:center;
            min-width:20px;
            line-height:1.2;
        }
        .grid-control {
            background:white;
            padding:6px 10px;
            border:2px solid rgba(0,0,0,0.2);
            border-radius:4px;
            cursor:pointer;
        }
        .grid-control:hover { background:#f4f4f4; }
        .maidenhead-label {
            background: transparent;
            color: #ff7d78;
            font-size: 12px;
            text-align: center;
            text-shadow: 1px 1px 0 #fff, -1px -1px 0 #fff;
            white-space: nowrap;
        }
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
                    
                    <!-- Station list items -->
<div class="station-item" data-callsign="<?php echo $station['callsign']; ?>" data-grid="<?php echo $station['grid']; ?>">
    <span class="station-count"><?php echo $station['count']; ?></span>
    <strong><?php echo $station['callsign']; ?></strong><br>
    <?php echo $station['name']; ?><br>
    <?php echo $station['city']; ?><br>
    Grid: <?php echo $station['grid']; ?>
</div>
                    
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div id="map"></div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <script src="js/L.Grid_YY.js"></script>
<!-- PART 3 -->

<script>
   // Initialize map
   var map = L.map('map', {
       wheelDebounceTime: 150,
       wheelPxPerZoomLevel: 120,
       zoomSnap: 1,
       zoomDelta: 1
   });
   
   // Add OpenStreetMap tile layer
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
       attribution: '&copy; OpenStreetMap contributors'
   }).addTo(map);
   
   // Initialize single grid layer
   var grid = L.maidenheadGrid().addTo(map);

   // Add grid control button
   var gridControl = L.Control.extend({
       options: {
           position: 'topright'
       },
       onAdd: function (map) {
           var container = L.DomUtil.create('div', 'grid-control');
           container.innerHTML = 'Toggle Grid';
           container.onclick = function(){
               if (map.hasLayer(grid)) {
                   map.removeLayer(grid);
                   container.style.backgroundColor = '#f4f4f4';
               } else {
                   map.addLayer(grid);
                   container.style.backgroundColor = 'white';
               }
           }
           return container;
       }
   });

   map.addControl(new gridControl());

   // Parse PHP data
   var markers = <?php echo json_encode($markers); ?>;
   var bounds = <?php echo json_encode($bounds); ?>;
   var totalOpens = <?php echo $totalOpens; ?>;

   // Initialize marker cluster group
   var markerClusterGroup = L.markerClusterGroup({
       spiderfyOnMaxZoom: true,
       showCoverageOnHover: false,
       zoomToBoundsOnClick: true,
       spiderLegPolylineOptions: { weight: 1.5, color: '#222', opacity: 0.5 },
       spiderfyDistanceMultiplier: 1.5,
       singleMarkerMode: false,
       disableClusteringAtZoom: 19,
       maxClusterRadius: 1
   });

   // Store markers by callsign for easy access
   var markersByCallsign = {};
   
   function createPopupContent(station) {
       return '<div class="station-popup">' +
           '<h3>' + station.callsign + (station.name ? ' - ' + station.name : '') + '</h3>' +
           '<p><span class="label">Location:</span> ' + station.cityState + '</p>' +
           '<p><span class="label">County:</span> ' + station.county + '</p>' +
           '<p><span class="label">Grid Square:</span> ' + station.grid + '</p>' +
           '<p><span class="label">Coordinates:</span> ' + 
               station.lat.toFixed(6) + ', ' + station.lng.toFixed(6) + '</p>' +
           '<p><span class="label">what3words:</span> ' + 
               (station.w3w ? station.w3w : 'Not available') + '</p>' +
           '<p><span class="label">Net Opens:</span> ' + station.count + '</p>' +
           '</div>';
   }

   // Create and add markers
   markers.forEach(function(station) {
       var customIcon = L.divIcon({
           className: 'marker-radio',
           html: station.callsign,
           iconSize: null,
           iconAnchor: [25, 12]
       });

       var marker = L.marker([station.lat, station.lng], {
           icon: customIcon
       })
       .bindPopup(createPopupContent(station));
       
       markerClusterGroup.addLayer(marker);
       markersByCallsign[station.callsign] = marker;
   });

   // Add the marker cluster group to the map
   map.addLayer(markerClusterGroup);

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

   // Group markers by state
   var markersByState = {};
   markers.forEach(function(station) {
       if (!markersByState[station.state]) {
           markersByState[station.state] = [];
       }
       markersByState[station.state].push([station.lat, station.lng]);
   });

   function getGridSquareBounds(grid4) {
       // Convert 4-char grid to lat/lon bounds
       var lon = (grid4.charCodeAt(0) - 65) * 20 - 180 + 
                 (parseInt(grid4[2]) * 2);
       var lat = (grid4.charCodeAt(1) - 65) * 10 - 90 + 
                 parseInt(grid4[3]);
       
       // Add padding for surrounding squares
       return L.latLngBounds(
           [lat - 1, lon - 2],  // SW corner with padding
           [lat + 2, lon + 4]   // NE corner with padding
       );
   }

   document.addEventListener('DOMContentLoaded', function() {
       const stationItems = document.querySelectorAll('.station-item');
       console.log('Found station items:', stationItems.length);
       console.log('Markers available:', Object.keys(markersByCallsign).length);

       stationItems.forEach(item => {
           item.style.cursor = 'pointer';
           item.onclick = function(e) {
               e.stopPropagation();
               e.preventDefault();
               
               console.log('Click detected on:', this.dataset.callsign);
               
               const callsign = this.dataset.callsign;
               const gridSquare = this.dataset.grid;
               const marker = markersByCallsign[callsign];
               
               document.getElementById('sidebar').classList.remove('show-stations');
               document.getElementById('sidebar').classList.add('expanded');

               if (marker && gridSquare) {
                   const baseGrid = gridSquare.substring(0, 4);
                   const gridBounds = getGridSquareBounds(baseGrid);
                   
                   if (markerClusterGroup.getVisibleParent(marker)) {
                       markerClusterGroup.zoomToShowLayer(marker, () => {
                           marker.openPopup();
                           map.fitBounds(gridBounds, { padding: [50, 50], maxZoom: 12 });
                       });
                   } else {
                       map.fitBounds(gridBounds, { padding: [50, 50], maxZoom: 12 });
                       marker.openPopup();
                   }
               }
           };
       });
   });

   // Add click handlers for state headers
   document.querySelectorAll('.state-header').forEach(function(header) {
       header.addEventListener('click', function() {
           var sidebar = document.getElementById('sidebar');
           var stateList = this.nextElementSibling;
           var wasHidden = stateList.style.display === 'none' || stateList.style.display === '';
           var state = this.dataset.state;
           
           document.querySelectorAll('.station-list').forEach(function(list) {
               list.style.display = 'none';
           });
           
           document.querySelectorAll('.state-header').forEach(function(h) {
               h.classList.remove('active-state');
           });

           sidebar.classList.remove('expanded', 'show-stations');

           if (wasHidden) {
               stateList.style.display = 'block';
               this.classList.add('active-state');
               sidebar.classList.add('show-stations');

               if (markersByState[state] && markersByState[state].length > 0) {
                   var stateBounds = L.latLngBounds(markersByState[state]);
                   grid.options.isStateSelected = true;
                   map.fitBounds(stateBounds, {
                       padding: [50, 50],
                       maxZoom: 12
                   });
               }
           }
       });
   });

   // Add zoom end handler to reset state selection
   map.on('zoomend', function() {
       if (grid.options.isStateSelected && map.getZoom() > 12) {
           grid.options.isStateSelected = false;
           grid._draw();
       }
   });
</script>
</body>
</html>