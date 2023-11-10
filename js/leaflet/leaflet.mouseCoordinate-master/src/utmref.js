/**
 * Created by Johannes Rudolph <johannes.rudolph@gmx.com> on 01.09.2016.
 */

/**
 *
 * @type {{fromUTM: UTMREF.fromUTM, toUTM: UTMREF.toUTM}}
 */
var UTMREF = {

    /**
     *
     * @param {{zone: string, x: number, y: number}}
     * @returns {{zone, band: string, x: string, y: string}}
     */
    fromUTM: function (utm) {
        // Copyright (c) 2006, HELMUT H. HEIMEIER

        if(utm === undefined){
            return;
        }

        var zone = utm.zone;
        var ew = utm.x;
        var nw = utm.y;

        // Laengenzone zone, Ostwert ew und Nordwert nw im WGS84 Datum
        var z1 = zone.substr(0, 2);
        var z2 = zone.substr(2, 1);
        var ew1 = parseInt(ew.substr(0, 2),10);
        var nw1 = parseInt(nw.substr(0, 2),10);
        var ew2 = ew.substr(2, 5);
        var nw2 = nw.substr(2, 5);

        var m_east = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        var m_north = 'ABCDEFGHJKLMNPQRSTUV';

        /*if (z1 < "01" || z1 > "60" || z2 < "C" || z2 > "X") {
            alert(z1 + z2 + " ist keine gueltige UTM Zonenangabe"); // jshint ignore:line
        }*/

        var m_ce;
        var i = z1 % 3;
        if (i === 1) {
            m_ce = ew1 - 1;
        }
        if (i === 2) {
            m_ce = ew1 + 7;
        }
        if (i === 0) {
            m_ce = ew1 + 15;
        }

        i = z1 % 2;
        var m_cn;
        if (i === 1) {
            m_cn = 0;
        }
        else {
            m_cn = 5;
        }

        i = nw1;
        while (i - 20 >= 0) {
            i = i - 20;
        }

        m_cn = m_cn + i;
        if (m_cn > 19) {
            m_cn = m_cn - 20;
        }

        var band = m_east.charAt(m_ce) + m_north.charAt(m_cn);

        return {zone: zone, band: band, x: ew2, y: nw2};
    },

    /**
     *
     * @param {{zone, band: string, x: string, y: string}}
     * @returns {{zone: string, x: number, y: number}}
     */
    toUTM: function (mgr) {
        // Copyright (c) 2006, HELMUT H. HEIMEIER

        // Laengenzone zone, Ostwert ew und Nordwert nw im WGS84 Datum
        var m_east_0 = "STUVWXYZ";
        var m_east_1 = "ABCDEFGH";
        var m_east_2 = "JKLMNPQR";
        var m_north_0 = "FGHJKLMNPQRSTUVABCDE";
        var m_north_1 = "ABCDEFGHJKLMNPQRSTUV";

        //zone = raster.substr(0,3);
        var zone = mgr.zone;
        var r_east = mgr.band.substr(0, 1);
        var r_north = mgr.band.substr(1, 1);

        var i = parseInt(zone.substr(0, 2),10) % 3;
        var m_ce;
        if (i === 0) {
            m_ce = m_east_0.indexOf(r_east) + 1;
        }
        if (i === 1) {
            m_ce = m_east_1.indexOf(r_east) + 1;
        }
        if (i === 2) {
            m_ce = m_east_2.indexOf(r_east) + 1;
        }
        var ew = "0" + m_ce;

        var m_cn = this._mgr2utm_find_m_cn(zone);

        var nw;
        if (m_cn.length === 1) {
            nw = "0" + m_cn;
        }
        else {
            nw = "" + m_cn;
        }

        return {zone: zone, x: ew, y: nw};
    }

};
