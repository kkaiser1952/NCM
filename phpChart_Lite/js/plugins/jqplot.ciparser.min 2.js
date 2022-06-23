/**
 * jqPlot
 * Pure JavaScript plotting plugin using jQuery
 *
 * Version: 1.0.4r1121
 *
 * Copyright (c) 2009-2011 Chris Leonello
 * jqPlot is currently available for use in all personal or commercial projects 
 * under both the MIT (http://www.opensource.org/licenses/mit-license.php) and GPL 
 * version 2.0 (http://www.gnu.org/licenses/gpl-2.0.html) licenses. This means that you can 
 * choose the license that best suits your project and use it accordingly. 
 *
 * Although not required, the author would appreciate an email letting him 
 * know of any substantial use of jqPlot.  You can reach the author at: 
 * chris at jqplot dot com or see http://www.jqplot.com/info.php .
 *
 * If you are feeling kind and generous, consider supporting the project by
 * making a donation at: http://www.jqplot.com/donate.php .
 *
 * sprintf functions contained in jqplot.sprintf.js by Ash Searle:
 *
 *     version 2007.04.27
 *     author Ash Searle
 *     http://hexmen.com/blog/2007/03/printf-sprintf/
 *     http://hexmen.com/js/sprintf.js
 *     The author (Ash Searle) has placed this code in the public domain:
 *     "This code is unrestricted: you are free to use it however you like."
 *
 * included jsDate library by Chris Leonello:
 *
 * Copyright (c) 2010-2011 Chris Leonello
 *
 * jsDate is currently available for use in all personal or commercial projects 
 * under both the MIT and GPL version 2.0 licenses. This means that you can 
 * choose the license that best suits your project and use it accordingly.
 *
 * jsDate borrows many concepts and ideas from the Date Instance 
 * Methods by Ken Snyder along with some parts of Ken's actual code.
 * 
 * Ken's origianl Date Instance Methods and copyright notice:
 * 
 * Ken Snyder (ken d snyder at gmail dot com)
 * 2008-09-10
 * version 2.0.2 (http://kendsnyder.com/sandbox/date/)     
 * Creative Commons Attribution License 3.0 (http://creativecommons.org/licenses/by/3.0/)
 *
 * jqplotToImage function based on Larry Siden's export-jqplot-to-png.js.
 * Larry has generously given permission to adapt his code for inclusion
 * into jqPlot.
 *
 * Larry's original code can be found here:
 *
 * https://github.com/lsiden/export-jqplot-to-png
 * 
 * 
 */
(function(a){a.jqplot.ciParser=function(g,l){var m=[],o,n,h,f,e,c;if(typeof(g)=="string"){g=a.jqplot.JSON.parse(g,d)}else{if(typeof(g)=="object"){for(e in g){for(h=0;h<g[e].length;h++){for(c in g[e][h]){g[e][h][c]=d(c,g[e][h][c])}}}}else{return null}}function d(j,k){var i;if(k!=null){if(k.toString().indexOf("Date")>=0){i=/^\/Date\((-?[0-9]+)\)\/$/.exec(k);if(i){return parseInt(i[1],10)}}return k}}for(var b in g){o=[];n=g[b];switch(b){case"PriceTicks":for(h=0;h<n.length;h++){o.push([n[h]["TickDate"],n[h]["Price"]])}break;case"PriceBars":for(h=0;h<n.length;h++){o.push([n[h]["BarDate"],n[h]["Open"],n[h]["High"],n[h]["Low"],n[h]["Close"]])}break}m.push(o)}return m}})(jQuery);