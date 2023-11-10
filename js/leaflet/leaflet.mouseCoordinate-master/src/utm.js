/**
 * Created by Johannes Rudolph <johannes.rudolph@gmx.com> on 01.09.2016.
 */

/**
 *
 * @type {{fromLatLng: UTM.fromLatLng, toLatLng: UTM.toLatLng}}
 */
var UTM = {

    /**
     *
     * @param {{lat: number, lng: number}}
     * @returns {{zone: string, x: number, y: number}}
     */
    fromLatLng: function (latlng) {
        //Copyright (c) 2006, HELMUT H. HEIMEIER

        /*
         * Okay, this just gives the wrong result:
         * `UTMREF.fromUTM(UTM.fromLatLng({lat: 0, lng: -179.9999999999999}))`
         * Results in
         * `Object {zone: "02N", band: "HF", x: "50564", y: "00000"}`
         * but should be in zone `01N`...
         **/
        var lw = latlng.lng;
        var bw = latlng.lat;
        if(lw === -180)
            lw += 1e-13;//Number.MIN_VALUE;
        if(lw === 180)
            lw -= 1e-13;//umber.MIN_VALUE;
        if(bw === -90)  bw += 1e-13;//umber.MIN_VALUE;
        if(bw === 90)   bw -= 1e-13;//umber.MIN_VALUE;
        // Geographische Laenge lw und Breite bw im WGS84 Datum
        if (lw <= -180 || lw >= 180 || bw <= -80 || bw >= 84){
            console.error("Out of lw <= -180 || lw >= 180 || bw <= -80 || bw >= 84 bounds, which is kinda similar to UTM bounds, if you ignore the poles");
            //alert("Werte nicht im Bereich des UTM Systems\n -180 <= LW < +180, -80 < BW < 84 N"); // jshint ignore:line
            return;
        }
        lw = parseFloat(lw);
        bw = parseFloat(bw);

        // WGS84 Datum
        // Grosse Halbachse a und Abplattung f
        var a = 6378137.000;
        var f = 3.35281068e-3;
        var pi = Math.PI;
        var b_sel = 'CDEFGHJKLMNPQRSTUVWXX';

        // Polkruemmungshalbmesser c
        var c = a/(1-f);

        // Quadrat der zweiten numerischen Exzentrizitaet
        var ex2 = (2*f-f*f)/((1-f)*(1-f));
        var ex4 = ex2*ex2;
        var ex6 = ex4*ex2;
        var ex8 = ex4*ex4;

        // Koeffizienten zur Berechnung der Meridianbogenlaenge
        var e0 = c*(pi/180)*(1 - 3*ex2/4 + 45*ex4/64 - 175*ex6/256 + 11025*ex8/16384);
        var e2 = c*( - 3*ex2/8 + 15*ex4/32 - 525*ex6/1024 +  2205*ex8/4096);
        var e4 = c*(15*ex4/256 - 105*ex6/1024 + 2205*ex8/16384);
        var e6 = c*( - 35*ex6/3072 + 315*ex8/12288);

        // Laengenzone lz und Breitenzone (Band) bz
        var lzn = parseInt((lw+180)/6,10) + 1;
        var lz = lzn;
        if (lzn < 10){
            lz = "0" + lzn;
        }

        //Chunk of code from  https://github.com/proj4js/mgrs/blob/e43d7d644564c09831587a5f01c911caae991d8c/mgrs.js#L128-L147
        //MIT License
        //Copyright (c) 2012, Mike Adair, Richard Greenwood, Didier Richard, Stephen Irons, Olivier Terral, Calvin Metcalf
        //
        //Portions of this software are based on a port of components from the OpenMap com.bbn.openmap.proj.coords Java package. An initial port was initially created by Patrice G. Cappelaere and included in Community Mapbuilder (http://svn.codehaus.org/mapbuilder/), which is licensed under the LGPL license as per http://www.gnu.org/copyleft/lesser.html. OpenMap is licensed under the following license agreement:

        // Special zone for Norway
        if (bw >= 56.0 && bw < 64.0 && lw >= 3.0 && lw < 12.0) {
            lz = 32;
        }

        // Special zones for Svalbard
        if (bw >= 72.0 && bw < 84.0) {
            if (lw >= 0.0 && lw < 9.0) {
                lz = 31;
            }
            else if (lw >= 9.0 && lw < 21.0) {
                lz = 33;
            }
            else if (lw >= 21.0 && lw < 33.0) {
                lz = 35;
            }
            else if (lw >= 33.0 && lw < 42.0) {
                lz = 37;
            }
        }
        //End part of code from proj4js/mgrs


        var bd = parseInt(1 + (bw + 80)/8,10);
        var bz = b_sel.substr(bd-1,1);

        // Geographische Breite in Radianten br
        var br = bw * pi/180;

        var tan1 = Math.tan(br);
        var tan2 = tan1*tan1;
        var tan4 = tan2*tan2;

        var cos1 = Math.cos(br);
        var cos2 = cos1*cos1;
        var cos4 = cos2*cos2;
        var cos3 = cos2*cos1;
        var cos5 = cos4*cos1;

        var etasq = ex2*cos2;

        // Querkruemmungshalbmesser nd
        var nd = c/Math.sqrt(1 + etasq);

        // Meridianbogenlaenge g aus gegebener geographischer Breite bw
        var g = (e0*bw) + (e2*Math.sin(2*br)) + (e4*Math.sin(4*br)) + (e6*Math.sin(6*br));

        // Laengendifferenz dl zum Bezugsmeridian lh
        var lh = (lzn - 30)*6 - 3;
        var dl = (lw - lh)*pi/180;
        var dl2 = dl*dl;
        var dl4 = dl2*dl2;
        var dl3 = dl2*dl;
        var dl5 = dl4*dl;

        // Masstabsfaktor auf dem Bezugsmeridian bei UTM Koordinaten m = 0.9996
        // Nordwert nw und Ostwert ew als Funktion von geographischer Breite und Laenge
        var nw;
        if ( bw < 0 ) {
            nw = 10e6 + 0.9996*(g + nd*cos2*tan1*dl2/2 + nd*cos4*tan1*(5-tan2+9*etasq)*dl4/24);
        }
        else {
            nw = 0.9996*(g + nd*cos2*tan1*dl2/2 + nd*cos4*tan1*(5-tan2+9*etasq)*dl4/24);
        }
        var ew = 0.9996*( nd*cos1*dl + nd*cos3*(1-tan2+etasq)*dl3/6 + nd*cos5 *(5-18*tan2+tan4)*dl5/120) + 500000;

        var zone = lz+bz;

        var nk = nw - parseInt(nw,10);
        if (nk < 0.5) {
            nw = "" + parseInt(nw,10);
        }
        else{
            nw = "" + (parseInt(nw,10) + 1);
        }

        while (nw.length < 7) {
            nw = "0" + nw;
        }

        nk = ew - parseInt(ew,10);
        if (nk < 0.5) {
            ew = "0" + parseInt(ew,10);
        }
        else {
            ew = "0" + parseInt(ew+1,10);
        }

        return {zone: zone, x: ew, y: nw};
    },

    /**
     *
     * @param {{zone: string, x: number, y: number}}
     * @returns {{lat: number, lng: number}}
     */
    toLatLng: function (utm){
        // Copyright (c) 2006, HELMUT H. HEIMEIER

        var zone = utm.zone;
        var ew = utm.x;
        var nw = utm.y;
        // Laengenzone zone, Ostwert ew und Nordwert nw im WGS84 Datum
        if (zone === "" || ew === "" || nw === ""){
            zone = "";
            ew = "";
            nw = "";
            return;
        }
        var band = zone.substr(2,1);
        zone = parseFloat(zone);
        ew = parseFloat(ew);
        nw = parseFloat(nw);

        // WGS84 Datum
        // Grosse Halbachse a und Abplattung f
        var a = 6378137.000;
        var f = 3.35281068e-3;
        var pi = Math.PI;

        // Polkruemmungshalbmesser c
        var c = a/(1-f);

        // Quadrat der zweiten numerischen Exzentrizitaet
        var ex2 = (2*f-f*f)/((1-f)*(1-f));
        var ex4 = ex2*ex2;
        var ex6 = ex4*ex2;
        var ex8 = ex4*ex4;

        // Koeffizienten zur Berechnung der geographischen Breite aus gegebener
        // Meridianbogenlaenge
        var e0 = c*(pi/180)*(1 - 3*ex2/4 + 45*ex4/64 - 175*ex6/256 + 11025*ex8/16384);
        var f2 =   (180/pi)*(    3*ex2/8 - 3*ex4/16  + 213*ex6/2048 -  255*ex8/4096);
        var f4 =              (180/pi)*(  21*ex4/256 -  21*ex6/256  +  533*ex8/8192);
        var f6 =                           (180/pi)*(  151*ex6/6144 -  453*ex8/12288);

        // Entscheidung Nord-/Sued Halbkugel
        var m_nw;
        if (band >= "N"|| band === ""){
            m_nw = nw;
        }
        else{
            m_nw = nw - 10e6;
        }

        // Geographische Breite bf zur Meridianbogenlaenge gf = m_nw
        var sigma = (m_nw/0.9996)/e0;
        var sigmr = sigma*pi/180;
        var bf = sigma + f2*Math.sin(2*sigmr) + f4*Math.sin(4*sigmr) + f6*Math.sin(6*sigmr);

        // Breite bf in Radianten
        var br = bf * pi/180;
        var tan1 = Math.tan(br);
        var tan2 = tan1*tan1;
        var tan4 = tan2*tan2;

        var cos1 = Math.cos(br);
        var cos2 = cos1*cos1;

        var etasq = ex2*cos2;

        // Querkruemmungshalbmesser nd
        var nd = c/Math.sqrt(1 + etasq);
        var nd2 = nd*nd;
        var nd4 = nd2*nd2;
        var nd6 = nd4*nd2;
        var nd3 = nd2*nd;
        var nd5 = nd4*nd;

        // Laengendifferenz dl zum Bezugsmeridian lh
        var lh = (zone - 30)*6 - 3;
        var dy = (ew-500000)/0.9996;
        var dy2 = dy*dy;
        var dy4 = dy2*dy2;
        var dy3 = dy2*dy;
        var dy5 = dy3*dy2;
        var dy6 = dy3*dy3;

        var b2 = - tan1*(1+etasq)/(2*nd2);
        var b4 =   tan1*(5+3*tan2+6*etasq*(1-tan2))/(24*nd4);
        var b6 = - tan1*(61+90*tan2+45*tan4)/(720*nd6);

        var l1 =   1/(nd*cos1);
        var l3 = - (1+2*tan2+etasq)/(6*nd3*cos1);
        var l5 =   (5+28*tan2+24*tan4)/(120*nd5*cos1);

        // Geographische Breite bw und Laenge lw als Funktion von Ostwert ew
        // und Nordwert nw
        var bw = bf + (180/pi) * (b2*dy2 + b4*dy4 + b6*dy6);
        var lw = lh + (180/pi) * (l1*dy  + l3*dy3 + l5*dy5);

        return {lat: bw, lng: lw};
    }
};
