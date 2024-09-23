K
Please retype the entire PHP portion of this file, I'm confused.

Certainly. I'll rewrite the entire PHP portion of the map.php file, focusing on consistent PDO usage and proper organization. Here's the updated PHP section:
php

Copy
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "dbConnectDtls.php";  // Assumes this file sets up the PDO connection as $db_found
require_once "ENV_SETUP.php";
require_once "GridSquare.php";
require_once "config.php";
require_once "config2.php";

// Value comes from an open net or prompt 
$q = filter_input(INPUT_GET, 'NetID', FILTER_VALIDATE_INT);

if ($q === false || $q === null) {
    die("Invalid NetID");
}

try {
    // Fetch latitude and longitude bounds
    $sql = "SELECT MAX(latitude) as maxlat,
                   MIN(latitude) as minlat,
                   MAX(longitude) as maxlon,
                   MIN(longitude) as minlon
            FROM NetLog 
            WHERE netID = :netID AND latitude <> ''";

    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':netID', $q, PDO::PARAM_INT);
    $stmt->execute();
    $bounds = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bounds === false) {
        throw new Exception("No data found for NetID: $q");
    }

    $maxlat = $bounds['maxlat'];
    $minlat = $bounds['minlat'];
    $maxlon = $bounds['maxlon'];
    $minlon = $bounds['minlon'];

    // Fetch net details
    $sql = "SELECT netcall, netID, activity, logdate 
            FROM NetLog 
            WHERE netID = :netID 
            LIMIT 1";

    $stmt = $db_found->prepare($sql);
    $stmt->bindParam(':netID', $q, PDO::PARAM_INT);
    $stmt->execute();
    $logrow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($logrow === false) {
        throw new Exception("No log details found for NetID: $q");
    }

    $netcall = $logrow['netcall'];

    // Load marker creation scripts
    ob_start();
    include "stationMarkers.php";
    $stationMarkers = ob_get_clean();

    ob_start();
    include "poiMarkers.php";
    $poiMarkers = ob_get_clean();

    ob_start();
    include "objMarkers.php";
    $objMarkers = ob_get_clean();

    // Prepare data for JavaScript
    $fitBounds = json_encode([
        [$minlat, $minlon],
        [$maxlat, $maxlon]
    ]);

    $stationList = isset($stationList) ? $stationList : '';
    $callsignList = isset($callsignList) ? $callsignList : '';

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>NCM Map of Station Locations</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" >
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <!-- Additional Leaflet plugins and custom scripts -->
    <script src="js/leaflet_numbered_markers.js"></script>
    <script src="js/L.Grid.js"></script>
    <script src="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.min.js"></script>
    <script src="js/hamgridsquare.js"></script>
    <script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>
    <script src="js/leaflet/leaflet.contextmenu.min.js"></script>
    <script src="js/leaflet.rotatedMarker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.1/src/leaflet.geometryutil.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
    <script src="https://assets.what3words.com/sdk/v3/what3words.js?key=5WHIM4GD"></script>
    <script src="https://ha8tks.github.io/Leaflet.Maidenhead/src/L.Maidenhead.js"></script>
    
    <!-- ESRI Leaflet -->
    <script src="https://unpkg.com/esri-leaflet@3.0.11/dist/esri-leaflet.js" integrity="sha512-qSE34Lz9JHdaPt3AZsi6L3dcqYHO9nnQEIxfrkgrRqqe+R0DPuAMu+j2vlb92zPka9O+XHZV4+9G5/rHT5ADsQ==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet-vector@4.1.0/dist/esri-leaflet-vector.js" integrity="sha512-o4eWk+0ue3rnRHK50Sp5U3NbbkHZLJ89Ao/nH4f9ayMpasUwHVZfYqJC8hVYB2nriDxK+TFJ0UoAHPIaJn3UGA==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.js" integrity="sha512-ODcrBUbBplqiGXL2S0tWNVYStUTTWYyQcSrCLjIW8vL+CEb758m7Dm0v5vyl8qrT8stBwKaYVWZTGymf7vj9jg==" crossorigin=""></script>
    
    <!-- Custom scripts -->
    <script src="js/control.w3w.js"></script>
    <script src="js/circleKoords.js"></script>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />
    <link rel="stylesheet" href="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.css">
    <link rel="stylesheet" href="css/control.w3w.css" />
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.css" integrity="sha512-BkZKghR9DV2LpDgmb/Uvl8bdoQj9O6OkkgbfXVpFfHTGcrHGqJIk1J5t+ZY5E3peLfTBazzjScnBguwthKvC1g==" crossorigin="" />
    
    <style>
        /* Custom styles */
        .leaflet-control-mouseCoordinate {
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.5);
            top: 80%;
            left: 10px;
            width: auto;
            padding-bottom: 40px;
        }
        
        .leaflet-container {
            line-height: 1;
        }
        
        .leaflet-control-w3w-locationText {
            position: fixed;
            font-size: 14pt;
            top: 93%;
            left: 32px;
            border: none;
            text-decoration: none;
            width: auto;
            background-color: inherit;
            color: rgb(182,7,7);
        }
        
        #extraButtons {
            position: absolute;
            top: 100px;
            right: 10px;
            z-index: 1000;
            font-weight: bold;
        }
        
        #toggleObjectLine {
            background-color: #ff7d78;
            display: none;
        }
        
        #customToggleMaidenhead {
            background-color: #ff7d78;
        }
        
        #Oactivity {
            text-align: center;
            color: red;
            font-weight: bold;
            font-size: 20pt;
            position: absolute;
            top: 10px;
            left: 10px;
            border: 2px solid green;
            background: transparent;
            padding-right: 10px;
            z-index: 1900;
        }
        
        @media only screen and (max-width: 600px) {
            #Oactivity {
                font-size: 18pt;
                padding: 5px;
            }
        }
    </style>
</head>
<body>
    <div id="extraButtons">
        <button id="customToggleMaidenhead">Toggle Maidenhead Grid</button>
        <br>
        <button id="toggleObjectLine">Toggle Object Line</button>
    </div>

    <div id="map"></div>
    
    <div id="stations">
        <b style="color:red; text-decoration: underline;">
            <?php echo "<b>$logrow[netcall]</b><br>$stationList";?>
        </b>
    </div>

    <div id="Oactivity" class="Oactivity">
        <img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
        <?php echo "$netcall Net #$logrow[netID] $logrow[activity] $logrow[logdate]" ?>
    </div>

    <script>
        // Map initialization and configuration
        var map = L.map('map', {
            drawControl: true,
            zoom: 13,
            zoomAnimation: false,
            zoomOptions: { animate: false }
        });

        var maidenheadLayer = L.maidenhead({
            color: '#ff7d78'
        });

        document.getElementById('customToggleMaidenhead').addEventListener('click', function () {
            if (map.hasLayer(maidenheadLayer)) {
                map.removeLayer(maidenheadLayer);
            } else {
                maidenheadLayer.addTo(map);
            }
        });

        var stationMarkers = [];
        var fg = new L.featureGroup();

        // Define icons
        const iconDefinitions = {
            blackmarkername: "BRKMarkers/black_flag.svg",
            bluemarkername: "BRKMarkers/blue_flag.svg",
            // ... (other icon definitions)
        };

        // Define basemap layers
        const baseMaps = {
            "<span style='color: blue; font-weight: bold;'>Community": L.esri.Vector.vectorBasemapLayer('ArcGIS:Community', { apikey: esriapi }),
            "<span style='color: blue; font-weight: bold;'>Streets": L.esri.Vector.vectorBasemapLayer('OSM:Streets', { apikey: esriapi }),
            // ... (other basemap definitions)
        };

        // Add map controls and features
        L.control.mouseCoordinate({gpsLong:false,utm:true,qth:true,position:'bottomleft'}).addTo(map);
        L.control.polylineMeasure({position:'topright', unit:'landmiles', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true}).addTo(map);
        map.zoomControl.setPosition('topright');
        map.scrollWheelZoom.disable();
        L.control.scale({position: 'bottomright'}).addTo(map);

        // Popup for click events
        var popup = L.popup();
        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at:<br>" + e.latlng.toString())
                .openOn(map);
        }
        map.on('click', onMapClick);

        // Add grid lines
        L.grid().addTo(map);

        // Define POI icons
        var poiIcons = {
            firstaidicon: new L.Icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 37]}),
            eocicon: new L.Icon({iconUrl: 'images/markers/eoc.png', iconSize: [32, 37]}),
            // ... (other POI icon definitions)
        };

        // Add station markers
        <?php echo $stationMarkers; ?>

        // Add POI markers
        <?php echo $poiMarkers; ?>

        // Create layer groups
        var Stations = L.layerGroup([<?php echo $callsignList; ?>]);
        Stations.addTo(map);

        // Fit map to bounds
        var bounds = L.latLngBounds([<?php echo $fitBounds; ?>]);
        map.fitBounds(bounds);

        // Add corner markers
        var cornerMarkers = [
            L.marker(bounds.getSouthWest(), {icon: L.icon({iconUrl: iconDefinitions.blackmarkername, iconSize: [50,50]}), title:'mk1'}).addTo(map).bindPopup('MK1<br>The SW Corner<br>' + bounds.getSouthWest()),
            // ... (other corner markers)
        ];

        // Create overlay maps for layer control
        var overlayMaps = {
            "<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations,
            // ... (other overlay definitions)
        };

        // Add layer control
        L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:true}).addTo(map);

        // Helper functions
        function markerFunction(id) {
            stationMarkers.forEach(function(marker) {
                if (marker.options.title === id) {
                    marker.openPopup();
                }
            });
        }

        $("a").click(function(){
            markerFunction($(this)[0].id);
        });

        function connectTheDots(data) {
            return Object.values(data._layers).map(layer => [layer._latlng.lat, layer._latlng.lng]);
        }

        // Object line toggle functionality
        var objectLine;
        function toggleObjectLine() {
            if (objectKoords.length > 0) {
                if (objectLine) {
                    objectLine.removeFrom(map);
                    objectLine = null;
                } else {
                    objectLine = L.polyline(objectKoords, { color: colorwheel[1], weight: 4 }).addTo(map);
                }
            }
        }

        document.getElementById('toggleObjectLine').addEventListener('click', toggleObjectLine);

        // Update button state
        function updateButtonState() {
            var button = document.getElementById("toggleObjectLine");
            button.disabled = OBJMarkerList.getLayers().length === 0;
            button.style.display = OBJMarkerList.getLayers().length === 0 ? 'none' : 'block';
        }

        updateButtonState();

        // Hide attribution
        $('.leaflet-control-attribution').hide();

    </script>
</body>
</html>