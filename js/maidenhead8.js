// Leaflet.Maidenhead
//
// https://gitlab.com/IvanSanchez/leaflet.maidenhead
//
// "THE BEER-WARE LICENSE":
// <ivan@sanchezortega.es> wrote this file. As long as you retain this notice you
// can do whatever you want with this stuff. If we meet some day, and you think
// this stuff is worth it, you can buy me a beer in return.

L.Maidenhead = L.FeatureGroup.extend({
	options: {
		// A set of Polygon options, used to style each grid square.
		// The default is to enable fill but make it transparent, so that
		// the polygons can trigger mouse/pointer events.
		// (as per https://leafletjs.com/reference-1.5.0.html#polygon)
		polygonStyle: {
			color: "black",
			weight: 1.5,
			fill: true,
			fillColor: "transparent",
			fillOpacity: 0,
		},

		// Callback function for creating markers in the center of the seen
		// squares. Receives two parameter (the latlng of the center of a square,
		// and the current precision) and must return an instance of L.Layer.
		// The default is to create a L.Marker with a L.DivIcon showing
		// the code for the square.
		spawnMarker: function maidenheadSpawnMarker(latlng, precision) {
			return L.marker(latlng, {
				icon: L.divIcon({
					html:
						"<div  style='background:white; border:1px solid #888; position: relative; display: inline-block; left: -0.25em; top: -0.5em; font-size:14; '>" +
						L.Maidenhead.latLngToIndex(latlng.lat, latlng.lng, precision) +
						"</div>",
					iconSize: [0, 0],
				}),
			});
		},

		// Precision of the Maidenhead locators, given in character length
		// of the string to use.
		// 2 = fields (e.g. "IO")
		// 4 = squares  (e.g. "IO43")
		// 6 = subsquares (e.g. "IO43km")
		// 8 = exteded subsquares (e.g. "IO43km18")
		precision: 6,
	},

	initialize: function initialize(options) {
		L.FeatureGroup.prototype.initialize.call(this, options);
		L.Util.setOptions(this, options);

		// Size of the grid, in lat degrees. Lng degrees will always be double.
		if (this.options.precision === 2) {
			this.latDelta = 10;
		} else if (this.options.precision === 4) {
			this.latDelta = 1;
		} else if (this.options.precision === 6) {
			this.latDelta = 2.5 / 60;
		} else if (this.options.precision === 8) {
			this.latDelta = 0.25 / 60;
		} else {
			throw new Error(
				"Precision option passed to L.Maidenhead is invalid (must be 2, 4 6 or 8)"
			);
		}
		this.lngDelta = this.latDelta * 2;

		// Store references to the string locators of the northwestern and south-
		// eastern corners. When they change, then it's time to redraw everything.
		this._nw = "";
		this._se = "";
	},

	onAdd: function onAdd(map) {
		L.FeatureGroup.prototype.onAdd.call(this, map);

		this._map = map;

		map.on("move zoom moveend zoomend", this._update, this);
		this._update();
	},

	onRemove: function onRemove(map) {
		L.FeatureGroup.prototype.onRemove.call(this, map);
		map.off("move zoom moveend zoomend", this._update, this);
	},

	_update: function _update() {
		if (!this._map) {
			return;
		}

		var bounds = this._map.getBounds();
		var n = bounds.getNorth();
		var s = bounds.getSouth();
		var w = bounds.getWest();
		var e = bounds.getEast();
		var nw = L.Maidenhead.latLngToIndex(n, w, this.options.precision);
		var se = L.Maidenhead.latLngToIndex(s, e, this.options.precision);

		if (nw !== this._nw || se !== this._se) {
			this._nw = nw;
			this._se = se;
			this.clearLayers();

			n = Math.ceil(n / this.latDelta) * this.latDelta;
			s = Math.floor(s / this.latDelta) * this.latDelta;
			e = Math.ceil(e / this.lngDelta) * this.lngDelta;
			w = Math.floor(w / this.lngDelta) * this.lngDelta;

			for (var lat = s; lat <= n; lat += this.latDelta) {
				for (var lng = w; lng <= e; lng += this.lngDelta) {
					var bbox = L.latLngBounds([
						[lat, lng],
						[lat + this.latDelta, lng + this.lngDelta],
					]);

					this.addLayer(L.rectangle(bbox, this.options.polygonStyle));

					if (this.options.spawnMarker) {
						var marker = this.options.spawnMarker(
							bbox.getCenter(),
							this.options.precision
						);
						if (marker) {
							this.addLayer(marker);
						}
					}
				}
			}
		}
	},
});

// Static methods

// Given a latin letter A to Z, return its 0-to-24 index
L.Maidenhead.letterIndex = function maideheadLetterIndex(letter) {
	return "ABCDEFGHIJKLMNOPQRSTUVWXYZ".indexOf(letter.toUpperCase());
};

// Given a 0-to-24 numeric index, return the corresponding *uppercase* latin letter A to Z
L.Maidenhead.indexLetter = function maidenheadIndexLetter(idx) {
	return "ABCDEFGHIJKLMNOPQRSTUVWXYZ".charAt(idx);
};

// Given a maidenhead index (as a string), return its bounding box
// (as a [lat, lng, lat, lng] or [y1, x1, y2, x2] array).
L.Maidenhead.indexToBBox = function maidehneadIndexToBBox(str) {
	const strLen = str.length;
	let minLat = -90;
	let minLng = -180;

	// Fields, 18x18 in total, each 20deg lng and 10deg lat
	minLng += 20 * L.Maidenhead.letterIndex(str.substring(0, 1));
	minLat += 10 * L.Maidenhead.letterIndex(str.substring(1, 2));

	if (str.length === 2) {
		return [minLat, minLng, minLat + 10, minLng + 20];
	}

	// Squares, 10x10 per field, each 2deg lng and 1deg lat
	minLng += 2 * Number(str.substring(2, 3));
	minLat += 1 * Number(str.substring(3, 4));

	if (str.length === 4) {
		return [minLat, minLng, minLat + 1, minLng + 2];
	}

	// Subsquares, 24x24 per square, each 5min lng and 2.5min lat
	minLng += (2.5 / 60) * L.Maidenhead.letterIndex(str.substring(4, 5));
	minLat += (5 / 60) * L.Maidenhead.letterIndex(str.substring(5, 6));

	if (str.length === 6) {
		return [minLat, minLng, minLat + 2.5 / 60, minLng + 5 / 60];
	}

	// Extended subsquares, 10x10 per subsquare, each 0.5min lng and 0.25min lat
	minLng += (0.25 / 60) * Number(str.substring(6, 7));
	minLat += (0.5 / 60) * Number(str.substring(7, 8));

	if (str.length === 8) {
		return [minLat, minLng, minLat + 2.5 / 60, minLng + 5 / 60];
	}

	throw new Error("String passed to maidenhead indexToBBox has invalid length");
};

// Given a lat-lng pair and a precision level, returns the index (as a string) of
// the grid it's contained in.
L.Maidenhead.latLngToIndex = function latLngToMaidenheadIndex(lat, lng, precision) {
	let str = "";

	// lat-lng as percentages of the current scope
	let latPct = (lat + 90) / 180;
	let lngPct = (lng + 180) / 360;

	// lat-lng will become multiples of the current scope

	// Fields, 18x18 in total, each 20deg lng and 10deg lat
	lngPct *= 18;
	latPct *= 18;
	str += L.Maidenhead.indexLetter(Math.floor(lngPct));
	str += L.Maidenhead.indexLetter(Math.floor(latPct));

	if (precision === 2) {
		return str;
	}

	// Squares, 10x10 per field, each 2deg lng and 1deg lat
	lngPct = (lngPct - Math.floor(lngPct)) * 10;
	latPct = (latPct - Math.floor(latPct)) * 10;

	str += Number(Math.floor(lngPct));
	str += Number(Math.floor(latPct));

	if (precision === 4) {
		return str;
	}

	// Subsquares, 24x24 per square, each 5min lng and 2.5min lat
	lngPct = (lngPct - Math.floor(lngPct)) * 24;
	latPct = (latPct - Math.floor(latPct)) * 24;

	str += L.Maidenhead.indexLetter(Math.floor(lngPct)).toLowerCase();
	str += L.Maidenhead.indexLetter(Math.floor(latPct)).toLowerCase();

	if (precision === 6) {
		return str;
	}

	// Extended subsquares, 10x10 per subsquare, each 0.5min lng and 0.25min lat
	lngPct = (lngPct - Math.floor(lngPct)) * 10;
	latPct = (latPct - Math.floor(latPct)) * 10;

	str += Number(Math.floor(lngPct));
	str += Number(Math.floor(latPct));

	if (precision === 8) {
		return str;
	}

	throw new Error(
		"Precision level passed to maidenhead latLngToIndex is invalid (must be 2, 4 6 or 8)"
	);
};

L.maidenhead = function maidenhead(opts) {
	return new L.Maidenhead(opts);
};