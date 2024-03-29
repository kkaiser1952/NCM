<!doctype html>
<html lang="en">
<head>
	<title>Leaflet Lat/Lon Graticule Demo</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="https://unpkg.com/leaflet@1.0.0/dist/leaflet.css" rel="stylesheet" type="text/css" />
<script src="https://unpkg.com/leaflet@1.0.0/dist/leaflet-src.js"></script>

<script src="../Leaflet.Graticule.js"></script>

	<style>
		html { height: 100%; }
		body { height: 100%; margin: 0; padding: 0;}
		.map { width: 800px; height: 600px; }
	</style>
</head>
<body>
	<div id="map" class="map"></div>

	<div>
	</div>

	<script>
		var map = new L.Map('map',{zoomControl:false}).setView([24.0, 121], 6),

			stamenTerrain = L.tileLayer('http://{s}.tile.stamen.com/terrain/{z}/{x}/{y}.png').addTo(map);

		L.latlngGraticule({
			showLabel: true,
			color: '#222',
			zoomInterval: [
				{start: 2, end: 3, interval: 30},
				{start: 4, end: 4, interval: 10},
				{start: 5, end: 7, interval: 5},
				{start: 8, end: 10, interval: 1}
			]
		}).addTo(map);

// 		console.log(map.options.crs);

	</script>

</body>
</html>