[![GitHub version](https://badge.fury.io/gh/PowerPan%2Fleaflet.mouseCoordinate.svg)](http://badge.fury.io/gh/PowerPan%2Fleaflet.mouseCoordinate) [![Code Climate](https://codeclimate.com/github/PowerPan/leaflet.mouseCoordinate/badges/gpa.svg)](https://codeclimate.com/github/PowerPan/leaflet.mouseCoordinate) [![Build Status](https://travis-ci.org/PowerPan/leaflet.mouseCoordinate.svg?branch=master)](https://travis-ci.org/PowerPan/leaflet.mouseCoordinate)

Installation
====
Manuell
---
Download the Source and add it into your Project Folder 

Bower
----
```
bower install --save leaflet.mouseCoordinate
```
[![get this with bower](http://benschwarz.github.io/bower-badges/badge@2x.png)](http://bower.io/ "get this with bower")

Usage
====
```
L.control.mouseCoordinate({utm:true,utmref:true}).addTo(map);
```

Options
====
| Option | Type    | Default | Description |
|--------|---------|---------|-------------|
| gps    | Boolean | true    | Show GPS Coordinates in 1 Form:  ddd.ddddd                             |
| gpsLong| Boolean | true    | Show GPS Coordinates in 3 Forms:  ddd.ddddd / ddd mm.mmm / ddd mm ss.s |
| utm    | Boolean | false   | Show [UTM Coordinates] (https://en.wikipedia.org/wiki/Universal_Transverse_Mercator_coordinate_system)            |
| utmref | Boolean | false   | Show [UTMREF/MGRS/USNG Coordinates] (https://en.wikipedia.org/wiki/Military_grid_reference_system)            |
| qth    | Boolean | false   | Show [QTH/Maidenhead Locator] (https://en.wikipedia.org/wiki/Maidenhead_Locator_System)            |
| nac    | Boolean | false   | Show [Natural Area Code] (https://en.wikipedia.org/wiki/Natural_Area_Code)           |
| position | String | 'bottomright'   | The initial position of the control (one of the map corners). See [control positions](http://leafletjs.com/reference.html#control-positions).     |
