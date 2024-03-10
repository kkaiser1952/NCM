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
(function(e){e.jqplot.FunnelRenderer=function(){e.jqplot.LineRenderer.call(this)};e.jqplot.FunnelRenderer.prototype=new e.jqplot.LineRenderer();e.jqplot.FunnelRenderer.prototype.constructor=e.jqplot.FunnelRenderer;e.jqplot.FunnelRenderer.prototype.init=function(p,t){this.padding={top:20,right:20,bottom:20,left:20};this.sectionMargin=6;this.fill=true;this.shadowOffset=2;this.shadowAlpha=0.07;this.shadowDepth=5;this.highlightMouseOver=true;this.highlightMouseDown=false;this.highlightColors=[];this.widthRatio=0.2;this.lineWidth=2;this.dataLabels="percent";this.showDataLabels=false;this.dataLabelFormatString=null;this.dataLabelThreshold=3;this._type="funnel";this.tickRenderer=e.jqplot.FunnelTickRenderer;if(p.highlightMouseDown&&p.highlightMouseOver==null){p.highlightMouseOver=false}e.extend(true,this,p);this._highlightedPoint=null;this._bases=[];this._atot;this._areas=[];this._lengths=[];this._angle;this._dataIndices=[];this._unorderedData=e.extend(true,[],this.data);var o=e.extend(true,[],this.data);for(var r=0;r<o.length;r++){o[r].push(r)}this.data.sort(function(v,u){return u[1]-v[1]});o.sort(function(v,u){return u[1]-v[1]});for(var r=0;r<o.length;r++){this._dataIndices.push(o[r][2])}if(this.highlightColors.length==0){for(var r=0;r<this.seriesColors.length;r++){var q=e.jqplot.getColorComponents(this.seriesColors[r]);var m=[q[0],q[1],q[2]];var s=m[0]+m[1]+m[2];for(var n=0;n<3;n++){m[n]=(s>570)?m[n]*0.8:m[n]+0.4*(255-m[n]);m[n]=parseInt(m[n],10)}this.highlightColors.push("rgb("+m[0]+","+m[1]+","+m[2]+")")}}t.postParseOptionsHooks.addOnce(k);t.postInitHooks.addOnce(g);t.eventListenerHooks.addOnce("jqplotMouseMove",a);t.eventListenerHooks.addOnce("jqplotMouseDown",b);t.eventListenerHooks.addOnce("jqplotMouseUp",j);t.eventListenerHooks.addOnce("jqplotClick",f);t.eventListenerHooks.addOnce("jqplotRightClick",l);t.postDrawHooks.addOnce(h)};e.jqplot.FunnelRenderer.prototype.setGridData=function(o){var n=0;var p=[];for(var m=0;m<this.data.length;m++){n+=this.data[m][1];p.push([this.data[m][0],this.data[m][1]])}for(var m=0;m<p.length;m++){p[m][1]=p[m][1]/n}this._bases=new Array(p.length+1);this._lengths=new Array(p.length);this.gridData=p};e.jqplot.FunnelRenderer.prototype.makeGridData=function(o,p){var n=0;var q=[];for(var m=0;m<this.data.length;m++){n+=this.data[m][1];q.push([this.data[m][0],this.data[m][1]])}for(var m=0;m<q.length;m++){q[m][1]=q[m][1]/n}this._bases=new Array(q.length+1);this._lengths=new Array(q.length);return q};e.jqplot.FunnelRenderer.prototype.drawSection=function(n,p,o,s){var t=this.fill;var m=this.lineWidth;n.save();if(s){for(var r=0;r<this.shadowDepth;r++){n.save();n.translate(this.shadowOffset*Math.cos(this.shadowAngle/180*Math.PI),this.shadowOffset*Math.sin(this.shadowAngle/180*Math.PI));q()}}else{q()}function q(){n.beginPath();n.fillStyle=o;n.strokeStyle=o;n.lineWidth=m;n.moveTo(p[0][0],p[0][1]);for(var u=1;u<4;u++){n.lineTo(p[u][0],p[u][1])}n.closePath();if(t){n.fill()}else{n.stroke()}}if(s){for(var r=0;r<this.shadowDepth;r++){n.restore()}}n.restore()};e.jqplot.FunnelRenderer.prototype.draw=function(G,B,J,p){var Y;var L=(J!=undefined)?J:{};var w=0;var u=0;var R=1;this._areas=[];if(J.legendInfo&&J.legendInfo.placement=="insideGrid"){var O=J.legendInfo;switch(O.location){case"nw":w=O.width+O.xoffset;break;case"w":w=O.width+O.xoffset;break;case"sw":w=O.width+O.xoffset;break;case"ne":w=O.width+O.xoffset;R=-1;break;case"e":w=O.width+O.xoffset;R=-1;break;case"se":w=O.width+O.xoffset;R=-1;break;case"n":u=O.height+O.yoffset;break;case"s":u=O.height+O.yoffset;R=-1;break;default:break}}var t=(R==1)?this.padding.left+w:this.padding.left;var F=(R==1)?this.padding.top+u:this.padding.top;var M=(R==-1)?this.padding.right+w:this.padding.right;var o=(R==-1)?this.padding.bottom+u:this.padding.bottom;var P=(L.shadow!=undefined)?L.shadow:this.shadow;var q=(L.showLine!=undefined)?L.showLine:this.showLine;var C=(L.fill!=undefined)?L.fill:this.fill;var H=G.canvas.width;var N=G.canvas.height;this._bases[0]=H-t-M;var I=this._length=N-F-o;var r=this._bases[0]*this.widthRatio;this._atot=I/2*(this._bases[0]+this._bases[0]*this.widthRatio);this._angle=Math.atan((this._bases[0]-r)/2/I);for(Y=0;Y<B.length;Y++){this._areas.push(B[Y][1]*this._atot)}var E,aa,W,Q=0;var n=0.0001;for(Y=0;Y<this._areas.length;Y++){E=this._areas[Y]/this._bases[Y];aa=999999;this._lengths[Y]=E;W=0;while(aa>this._lengths[Y]*n&&W<100){this._lengths[Y]=this._areas[Y]/(this._bases[Y]-this._lengths[Y]*Math.tan(this._angle));aa=Math.abs(this._lengths[Y]-E);this._bases[Y+1]=this._bases[Y]-(2*this._lengths[Y]*Math.tan(this._angle));E=this._lengths[Y];W++}Q+=this._lengths[Y]}this._vertices=new Array(B.length);var ae=[t,F],ad=[t+this._bases[0],F],ac=[t+(this._bases[0]-this._bases[this._bases.length-1])/2,F+this._length],ab=[ac[0]+this._bases[this._bases.length-1],ac[1]];function V(ag){var x=(ae[1]-ac[1])/(ae[0]-ac[0]);var v=ae[1]-x*ae[0];var ah=ag+ae[1];return[(ah-v)/x,ah]}function D(ag){var x=(ad[1]-ab[1])/(ad[0]-ab[0]);var v=ad[1]-x*ad[0];var ah=ag+ad[1];return[(ah-v)/x,ah]}var T=w,S=u;var Z=0,m=0;for(Y=0;Y<B.length;Y++){this._vertices[Y]=new Array();var U=this._vertices[Y];var A=this.sectionMargin;if(Y==0){m=0}if(Y==1){m=A/3}else{if(Y>0&&Y<B.length-1){m=A/2}else{if(Y==B.length-1){m=2*A/3}}}U.push(V(Z+m));U.push(D(Z+m));Z+=this._lengths[Y];if(Y==0){m=-2*A/3}else{if(Y>0&&Y<B.length-1){m=-A/2}else{if(Y==B.length-1){m=0}}}U.push(D(Z+m));U.push(V(Z+m))}if(this.shadow){var af="rgba(0,0,0,"+this.shadowAlpha+")";for(var Y=0;Y<B.length;Y++){this.renderer.drawSection.call(this,G,this._vertices[Y],af,true)}}for(var Y=0;Y<B.length;Y++){var U=this._vertices[Y];this.renderer.drawSection.call(this,G,U,this.seriesColors[Y]);if(this.showDataLabels&&B[Y][1]*100>=this.dataLabelThreshold){var K,X;if(this.dataLabels=="label"){K=this.dataLabelFormatString||"%s";X=e.jqplot.sprintf(K,B[Y][0])}else{if(this.dataLabels=="value"){K=this.dataLabelFormatString||"%d";X=e.jqplot.sprintf(K,this.data[Y][1])}else{if(this.dataLabels=="percent"){K=this.dataLabelFormatString||"%d%%";X=e.jqplot.sprintf(K,B[Y][1]*100)}else{if(this.dataLabels.constructor==Array){K=this.dataLabelFormatString||"%s";X=e.jqplot.sprintf(K,this.dataLabels[this._dataIndices[Y]])}}}}var s=(this._radius)*this.dataLabelPositionFactor+this.sliceMargin+this.dataLabelNudge;var T=(U[0][0]+U[1][0])/2+this.canvas._offsets.left;var S=(U[1][1]+U[2][1])/2+this.canvas._offsets.top;var z=e('<span class="jqplot-funnel-series jqplot-data-label" style="position:absolute;">'+X+"</span>").insertBefore(p.eventCanvas._elem);T-=z.width()/2;S-=z.height()/2;T=Math.round(T);S=Math.round(S);z.css({left:T,top:S})}}};e.jqplot.FunnelAxisRenderer=function(){e.jqplot.LinearAxisRenderer.call(this)};e.jqplot.FunnelAxisRenderer.prototype=new e.jqplot.LinearAxisRenderer();e.jqplot.FunnelAxisRenderer.prototype.constructor=e.jqplot.FunnelAxisRenderer;e.jqplot.FunnelAxisRenderer.prototype.init=function(m){this.tickRenderer=e.jqplot.FunnelTickRenderer;e.extend(true,this,m);this._dataBounds={min:0,max:100};this.min=0;this.max=100;this.showTicks=false;this.ticks=[];this.showMark=false;this.show=false};e.jqplot.FunnelLegendRenderer=function(){e.jqplot.TableLegendRenderer.call(this)};e.jqplot.FunnelLegendRenderer.prototype=new e.jqplot.TableLegendRenderer();e.jqplot.FunnelLegendRenderer.prototype.constructor=e.jqplot.FunnelLegendRenderer;e.jqplot.FunnelLegendRenderer.prototype.init=function(m){this.numberRows=null;this.numberColumns=null;e.extend(true,this,m)};e.jqplot.FunnelLegendRenderer.prototype.draw=function(){var p=this;if(this.show){var x=this._series;var A="position:absolute;";A+=(this.background)?"background:"+this.background+";":"";A+=(this.border)?"border:"+this.border+";":"";A+=(this.fontSize)?"font-size:"+this.fontSize+";":"";A+=(this.fontFamily)?"font-family:"+this.fontFamily+";":"";A+=(this.textColor)?"color:"+this.textColor+";":"";A+=(this.marginTop!=null)?"margin-top:"+this.marginTop+";":"";A+=(this.marginBottom!=null)?"margin-bottom:"+this.marginBottom+";":"";A+=(this.marginLeft!=null)?"margin-left:"+this.marginLeft+";":"";A+=(this.marginRight!=null)?"margin-right:"+this.marginRight+";":"";this._elem=e('<table class="jqplot-table-legend" style="'+A+'"></table>');var E=false,w=false,m,u;var y=x[0];var n=new e.jqplot.ColorGenerator(y.seriesColors);if(y.show){var F=y.data;if(this.numberRows){m=this.numberRows;if(!this.numberColumns){u=Math.ceil(F.length/m)}else{u=this.numberColumns}}else{if(this.numberColumns){u=this.numberColumns;m=Math.ceil(F.length/this.numberColumns)}else{m=F.length;u=1}}var D,C,o,r,q,t,v,B;var z=0;for(D=0;D<m;D++){if(w){o=e('<tr class="jqplot-table-legend"></tr>').prependTo(this._elem)}else{o=e('<tr class="jqplot-table-legend"></tr>').appendTo(this._elem)}for(C=0;C<u;C++){if(z<F.length){t=this.labels[z]||F[z][0].toString();B=n.next();if(!w){if(D>0){E=true}else{E=false}}else{if(D==m-1){E=false}else{E=true}}v=(E)?this.rowSpacing:"0";r=e('<td class="jqplot-table-legend" style="text-align:center;padding-top:'+v+';"><div><div class="jqplot-table-legend-swatch" style="border-color:'+B+';"></div></div></td>');q=e('<td class="jqplot-table-legend" style="padding-top:'+v+';"></td>');if(this.escapeHtml){q.text(t)}else{q.html(t)}if(w){q.prependTo(o);r.prependTo(o)}else{r.appendTo(o);q.appendTo(o)}E=true}z++}}}}return this._elem};function c(q,p,n){n=n||{};n.axesDefaults=n.axesDefaults||{};n.legend=n.legend||{};n.seriesDefaults=n.seriesDefaults||{};var m=false;if(n.seriesDefaults.renderer==e.jqplot.FunnelRenderer){m=true}else{if(n.series){for(var o=0;o<n.series.length;o++){if(n.series[o].renderer==e.jqplot.FunnelRenderer){m=true}}}}if(m){n.axesDefaults.renderer=e.jqplot.FunnelAxisRenderer;n.legend.renderer=e.jqplot.FunnelLegendRenderer;n.legend.preDraw=true;n.sortData=false;n.seriesDefaults.pointLabels={show:false}}}function g(p,o,m){for(var n=0;n<this.series.length;n++){if(this.series[n].renderer.constructor==e.jqplot.FunnelRenderer){if(this.series[n].highlightMouseOver){this.series[n].highlightMouseDown=false}}}}function k(m){for(var n=0;n<this.series.length;n++){this.series[n].seriesColors=this.seriesColors;this.series[n].colorGenerator=e.jqplot.colorGenerator}}function d(q,p,o){var n=q.series[p];var m=q.plugins.funnelRenderer.highlightCanvas;m._ctx.clearRect(0,0,m._ctx.canvas.width,m._ctx.canvas.height);n._highlightedPoint=o;q.plugins.funnelRenderer.highlightedSeriesIndex=p;n.renderer.drawSection.call(n,m._ctx,n._vertices[o],n.highlightColors[o],false)}function i(o){var m=o.plugins.funnelRenderer.highlightCanvas;m._ctx.clearRect(0,0,m._ctx.canvas.width,m._ctx.canvas.height);for(var n=0;n<o.series.length;n++){o.series[n]._highlightedPoint=null}o.plugins.funnelRenderer.highlightedSeriesIndex=null;o.target.trigger("jqplotDataUnhighlight")}function a(q,p,t,s,r){if(s){var o=[s.seriesIndex,s.pointIndex,s.data];var n=jQuery.Event("jqplotDataMouseOver");n.pageX=q.pageX;n.pageY=q.pageY;r.target.trigger(n,o);if(r.series[o[0]].highlightMouseOver&&!(o[0]==r.plugins.funnelRenderer.highlightedSeriesIndex&&o[1]==r.series[o[0]]._highlightedPoint)){var m=jQuery.Event("jqplotDataHighlight");m.which=q.which;m.pageX=q.pageX;m.pageY=q.pageY;r.target.trigger(m,o);d(r,o[0],o[1])}}else{if(s==null){i(r)}}}function b(p,o,s,r,q){if(r){var n=[r.seriesIndex,r.pointIndex,r.data];if(q.series[n[0]].highlightMouseDown&&!(n[0]==q.plugins.funnelRenderer.highlightedSeriesIndex&&n[1]==q.series[n[0]]._highlightedPoint)){var m=jQuery.Event("jqplotDataHighlight");m.which=p.which;m.pageX=p.pageX;m.pageY=p.pageY;q.target.trigger(m,n);d(q,n[0],n[1])}}else{if(r==null){i(q)}}}function j(o,n,r,q,p){var m=p.plugins.funnelRenderer.highlightedSeriesIndex;if(m!=null&&p.series[m].highlightMouseDown){i(p)}}function f(p,o,s,r,q){if(r){var n=[r.seriesIndex,r.pointIndex,r.data];var m=jQuery.Event("jqplotDataClick");m.which=p.which;m.pageX=p.pageX;m.pageY=p.pageY;q.target.trigger(m,n)}}function l(q,p,t,s,r){if(s){var o=[s.seriesIndex,s.pointIndex,s.data];var m=r.plugins.funnelRenderer.highlightedSeriesIndex;if(m!=null&&r.series[m].highlightMouseDown){i(r)}var n=jQuery.Event("jqplotDataRightClick");n.which=q.which;n.pageX=q.pageX;n.pageY=q.pageY;r.target.trigger(n,o)}}function h(){if(this.plugins.funnelRenderer&&this.plugins.funnelRenderer.highlightCanvas){this.plugins.funnelRenderer.highlightCanvas.resetCanvas();this.plugins.funnelRenderer.highlightCanvas=null}this.plugins.funnelRenderer={};this.plugins.funnelRenderer.highlightCanvas=new e.jqplot.GenericCanvas();var n=e(this.targetId+" .jqplot-data-label");if(n.length){e(n[0]).before(this.plugins.funnelRenderer.highlightCanvas.createElement(this._gridPadding,"jqplot-funnelRenderer-highlight-canvas",this._plotDimensions,this))}else{this.eventCanvas._elem.before(this.plugins.funnelRenderer.highlightCanvas.createElement(this._gridPadding,"jqplot-funnelRenderer-highlight-canvas",this._plotDimensions,this))}var m=this.plugins.funnelRenderer.highlightCanvas.setContext();this.eventCanvas._elem.bind("mouseleave",{plot:this},function(o){i(o.data.plot)})}e.jqplot.preInitHooks.push(c);e.jqplot.FunnelTickRenderer=function(){e.jqplot.AxisTickRenderer.call(this)};e.jqplot.FunnelTickRenderer.prototype=new e.jqplot.AxisTickRenderer();e.jqplot.FunnelTickRenderer.prototype.constructor=e.jqplot.FunnelTickRenderer})(jQuery);