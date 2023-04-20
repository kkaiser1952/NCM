/**
 * Created by Johannes Rudolph <johannes.rudolph@gmx.com> on 01.09.2016.
 */

/**
 *
 * @type {{fromLatLng: QTH.fromLatLng}}
 */
var QTH = {

    /**
     *
     * @param {{lat: number, lng: number}}
     * @returns {string}
     */
    fromLatLng: function(latlng){
        /* Long/Lat to QTH locator conversion largely       */
        /* inspired from the DL4MFM code found here :       */
        /* http://members.aol.com/mfietz/ham/calcloce.html */

        var ychr = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var ynum = "0123456789";
        var yqth, yi, yk, ydiv, yres, ylp;
        var y = 0;
        var ycalc = [0,0,0];
        var yn = [0,0,0,0,0,0,0];

        ycalc[1] = latlng.lng+ 180;
        ycalc[2] = latlng.lat +  90;

        for (yi = 1; yi < 3; ++yi) {
            for (yk = 1; yk < 4; ++yk) {
                if (yk !== 3) {
                    if (yi === 1) {
                        if (yk === 1) ydiv = 20;
                        if (yk === 2) ydiv = 2;
                    }
                    if (yi === 2) {
                        if (yk === 1) ydiv = 10;
                        if (yk === 2) ydiv = 1;
                    }

                    yres = ycalc[yi] / ydiv;
                    ycalc[yi] = yres;
                    if (ycalc[yi]>0)
                        ylp = Math.floor(yres);
                    else
                        ylp = Math.ceil(yres);
                    ycalc[yi] = (ycalc[yi] - ylp) * ydiv;
                }
                else {
                    if (yi === 1)
                        ydiv = 12;
                    else
                        ydiv = 24;

                    yres = ycalc[yi] * ydiv;
                    ycalc[yi] = yres;
                    if (ycalc[yi] > 0)
                        ylp = Math.floor(yres);
                    else
                        ylp = Math.ceil(yres);
                }

                ++y;
                yn[y] = ylp;
            }
        }

        yqth = ychr.charAt(yn[1]) + ychr.charAt(yn[4]) + ynum.charAt(yn[2]);
        yqth += ynum.charAt(yn[5]) + ychr.charAt(yn[3])+ ychr.charAt(yn[6]);
        return yqth;
    }

};