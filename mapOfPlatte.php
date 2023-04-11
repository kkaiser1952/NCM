<!DOCTYPE html>
<html>
<head>
	<title>Map of Clay and Platte Counties</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1.3.1/leaflet.css" />
	<script src="https://cdn.jsdelivr.net/leaflet/1.3.1/leaflet.js"></script>
	<style>
		html, body, #mapid {
			height: 100%;
			margin: 0;
			padding: 0;
		}
	</style>
</head>
<body>
	<div id="mapid"></div>
	<script>
		var map = L.map('mapid').setView([39.2463, -94.4191], 10);

		var Stamen_TonerLite = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}{r}.{ext}', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://stamen.com">Stamen</a>',
			subdomains: 'abcd',
			minZoom: 0,
			maxZoom: 20,
			ext: 'png'
		}).addTo(map);

		var platteCounty = L.geoJSON(platteCountyData, {
			style: {
				color: '#00008B',
				fillOpacity: 0,
				weight: 2
			},
			onEachFeature: function (feature, layer) {
				layer.bindTooltip(feature.properties.NAME, {sticky: true}).openTooltip();
			}
		}).addTo(map);

		var clayCounty = L.geoJSON(clayCountyData, {
			style: {
				color: '#00008B',
				fillOpacity: 0,
				weight: 2
			},
			onEachFeature: function (feature, layer) {
				layer.bindTooltip(feature.properties.NAME, {sticky: true}).openTooltip();
			}
		}).addTo(map);

		var markers = [];
		var bounds = L.latLngBounds();

		for (var i = 0; i < 5; i++) {
			var marker = L.marker(getRandomLatLng(platteCounty)).addTo(map);
			marker.bindTooltip('Marker ' + (i+1));
			markers.push(marker);
			bounds.extend(marker.getLatLng());
		}

		map.fitBounds(bounds);

		function getRandomLatLng(layer) {
			var bounds = layer.getBounds();
			var southWest = bounds.getSouthWest();
			var northEast = bounds.getNorthEast();
			var lngSpan = northEast.lng - southWest.lng;
			var latSpan = northEast.lat - southWest.lat;
			return L.latLng(
				southWest.lat + latSpan * Math.random(),
				southWest.lng + lngSpan * Math.random()
			);
		}

	</script>
</body>
</html>
