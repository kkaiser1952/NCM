<html>
<head>
<script>
function(param1,param2){
  var lat=-100.0;
  var lon=0.0;
  var adjLat,adjLon,GLat,GLon,nLat,nLon,gLat,gLon,rLat,rLon;
  var U = 'ABCDEFGHIJKLMNOPQRSTUVWX'
  var L = U.toLowerCase();
  // support Chris Veness 2002-2012 LatLon library and
  // other objects with lat/lon properties
  // properties could be numbers, or strings
  function toNum(x){
    if (typeof(x) === 'number') return x;
    if (typeof(x) === 'string') return parseFloat(x);
    // dont call a function property here because of binding issue
    throw "HamGridSquare -- toNum -- can not convert input: "+x;
  }
  if (typeof(param1)==='object'){
    if (param1.length === 2){
      lat = toNum(param1[0]);
      lon = toNum(param1[1]);
    } else if (('lat' in param1) && ('lon' in param1)){
      lat = (typeof(param1.lat)==='function')? toNum(param1.lat()): toNum(param1.lat);
      lon = (typeof(param1.lon)==='function')? toNum(param1.lon()): toNum(param1.lon);
    } else if (('latitude' in param1) && ('longitude' in param1)){
      lat = (typeof(param1.latitude)==='function')? toNum(param1.latitude()): toNum(param1.latitude);
      lon = (typeof(param1.longitude)==='function')? toNum(param1.longitude()): toNum(param1.longitude);
    } else {
      throw "HamGridSquare -- can not convert object -- "+param1;
    }
  } else {
    lat = toNum(param1);
    lon = toNum(param2);
  }
  if (isNaN(lat)) throw "lat is NaN";
  if (isNaN(lon)) throw "lon is NaN";
  if (Math.abs(lat) === 90.0) throw "grid squares invalid at N/S poles";
  if (Math.abs(lat) > 90) throw "invalid latitude: "+lat;
  if (Math.abs(lon) > 180) throw "invalid longitude: "+lon;
  adjLat = lat + 90;
  adjLon = lon + 180;
  GLat = U[Math.trunc(adjLat/10)];
  GLon = U[Math.trunc(adjLon/20)];
  nLat = ''+Math.trunc(adjLat % 10);
  nLon = ''+Math.trunc((adjLon/2) % 10);
  rLat = (adjLat - Math.trunc(adjLat)) * 60;
  rLon = (adjLon - 2*Math.trunc(adjLon/2)) *60;
  gLat = L[Math.trunc(rLat/2.5)];
  gLon = L[Math.trunc(rLon/5)];
  return GLon+GLat+nLon+nLat+gLon+gLat;
  alert(latLonToGridSquare(39.2,-94.6));
}
</script>
<head>

</html>