"use strict";

let [MAX_LAT, MIN_LAT] = [ 90,  -90];
let [MAX_LON, MIN_LON] = [180, -180];

let LAT_DISTANCE = Math.abs(MIN_LAT) + MAX_LAT;
let LON_DISTANCE = Math.abs(MIN_LON) + MAX_LON;


function subdivisor() {
	var last = [18, 10, 24, 10];
	var i = 0;
	return function () {
		// The fifth and subsequent pairs are not formally defined, but recycling the third and fourth pair algorithms is one possible definition
		if (i >= last.length) i = 2;
		return last[i++];
	};
}

function parse_digit(digit) {
	var alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var value = alphabet.indexOf(digit.toUpperCase());

	if (value == -1)
		value = parseInt(digit);

	return value;
}

function get_grid_square(grid_square_id) {
	if (grid_square_id.length % 2 !== 0)
		return [null, null, null, null];

	grid_square_id = grid_square_id.toUpperCase();

	var lat = MIN_LAT, lon = MIN_LON;
	var lat_div = LAT_DISTANCE, lon_div = LON_DISTANCE;
	var base_calculator = subdivisor();


	for (var base = base_calculator(); grid_square_id.length; base = base_calculator()) {

		let [lon_id, lat_id] = grid_square_id.toUpperCase().substring(0, 2);

		lat_div /= base;
		lon_div /= base;

		lat += parse_digit(lat_id) * lat_div;
		lon += parse_digit(lon_id) * lon_div;

		grid_square_id = grid_square_id.substring(2);
	}

	return [lat, lon, lat_div, lon_div];
}
//get_grid_square("Em29qe");

//console.log(get_grid_square("Em29qe"));
