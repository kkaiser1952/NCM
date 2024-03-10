function convertDMS( lat, lng ) {
 
        var convertLat = Math.abs(lat);
        var LatDeg = Math.floor(convertLat);
        var LatMin = (Math.floor((convertLat - LatDeg) * 60));
        var LatCardinal = ((lat > 0) ? "N" : "S");
         
        var convertLng = Math.abs(lng);
        var LngDeg = Math.floor(convertLng);
        var LngMin = (Math.floor((convertLng - LngDeg) * 60));
        var LngCardinal = ((lng > 0) ? "E" : "W");
         
        return LatDeg + LatMin + LatCardinal + "<br />" + LngDeg + LngMin + LngCardinal;
}

var lat = 39.202;
var lon = -94.602;
var dms = convertDMS( 39.202, -94.602);
alert(dms);