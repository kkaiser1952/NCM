function gridsquare() {
	if (point) {
		var longDir;
		if (clicklatlng.x < 0) longDir = "W"
		else longDir = "E";
		var latDir;
		if (clicklatlng.y < 0) latDir = "S"
		else latDir = "N";
		var longDeg;
		var longMin;
		if (clicklatlng.x > 0) {
			longDeg = Math.floor(clicklatlng.x);
			longMin = (clicklatlng.x - longDeg) * 100;
		} else {
			longDeg = Math.ceil(clicklatlng.x);
			longMin = (longDeg - clicklatlng.x) * 100;
		}
		var longMin2 = longMin * 60 / 100;
		var longSec = Math.round((longMin2 - Math.floor(longMin2)) * 60);
		var latDeg;
		var latMin;
		if (clicklatlng.y > 0) {
			latDeg = Math.floor(clicklatlng.y);
			latMin = (clicklatlng.y - latDeg) * 100;
		} else {
			latDeg = Math.ceil(clicklatlng.y);
			latMin = (latDeg - clicklatlng.y) * 100;
		}
		var latMin2 = latMin * 60 / 100;
		var latSec = Math.round((latMin2 - Math.floor(latMin2)) * 60);
		var strHtml = "<font face='arial' size='3'>Grid Square Calculator<br />\n";
		strHtml += "Lat : " + Math.round(clicklatlng.y * 10000) / 10000 + " " + latDir;
		strHtml += " (" + latDeg + "&deg; " + Math.floor(latMin2) + "' " + latSec + "'' " + latDir + ")";
		strHtml += "<br />\n";
		strHtml += "Long : " + Math.round(clicklatlng.x * 10000) / 10000 + " " + longDir;
		strHtml += " (" + longDeg + "&deg; " + Math.floor(longMin2) + "' " + longSec + "'' " + longDir + ")";
		strHtml += "<br />\n";
		var ychr = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var ynum = "0123456789";
		var yqth, yi, yk, ydiv, yres, ylp, y;
		var y = 0;
		var ycalc = new Array(0, 0, 0);
		var yn = new Array(0, 0, 0, 0, 0, 0, 0);
		ycalc[1] = clicklatlng.x + 180;
		ycalc[2] = clicklatlng.y + 90;
		for (yi = 1; yi < 3; ++yi) {
			for (yk = 1; yk < 4; ++yk) {
				if (yk != 3) {
					if (yi == 1) {
						if (yk == 1) ydiv = 20;
						if (yk == 2) ydiv = 2;
					}
					if (yi == 2) {
						if (yk == 1) ydiv = 10;
						if (yk == 2) ydiv = 1;
					}
					yres = ycalc[yi] / ydiv;
					ycalc[yi] = yres;
					if (ycalc[yi] > 0) ylp = Math.floor(yres)
					else ylp = Math.ceil(yres);
					ycalc[yi] = (ycalc[yi] - ylp) * ydiv;
				} else {
					if (yi == 1) ydiv = 12
					else ydiv = 24;
					yres = ycalc[yi] * ydiv;
					ycalc[yi] = yres;
					if (ycalc[yi] > 0) ylp = Math.floor(yres)
					else ylp = Math.ceil(yres);
				}++y;
				yn[y] = ylp;
			}
		}
		yqth = ychr.charAt(yn[1]) + ychr.charAt(yn[4]) + ynum.charAt(yn[2]);
		yqth += ynum.charAt(yn[5]) + ychr.charAt(yn[3]) + ychr.charAt(yn[6]);
		strHtml += "Grid Square: " + yqth + "</font>"; //      map.removeOverlay(polygonClick);
		//polygonClick.redraw(true);
		map.openInfoWindowHtml(clicklatlng, strHtml); // Square limits
		var bottomLeftLong = Math.floor(clicklatlng.x / 0.0833333333) * 0.0833333333;
		var bottomLeftLat = Math.floor(clicklatlng.y / 0.0416666666) * 0.0416666666;
		polygonClick = new GPolygon([new GLatLng(bottomLeftLat, bottomLeftLong), new GLatLng(bottomLeftLat, bottomLeftLong + 0.0833333333), new GLatLng(bottomLeftLat + 0.0416666666, bottomLeftLong + 0.0833333333), new GLatLng(bottomLeftLat + 0.0416666666, bottomLeftLong), new GLatLng(bottomLeftLat, bottomLeftLong)], "#FF0000", 4, .25, 'red', .10);
		map.addOverlay(polygonClick);
		contextmenu.style.visibility = "hidden";
	} // if (point)
} // end of gridsquare

alert(gridsquare(39,-94));
