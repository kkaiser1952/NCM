var circfeqcnt = 0; // Sets a variable to count how many times the circleKoords() function is called
function circleKoords(e) {
     
   circfeqcnt = circfeqcnt + 1; //alert(circfeqcnt);
    
   if (circfeqcnt <= 1) { var circolor  = 'blue';  }
   else if (circfeqcnt == 2) { var circolor  = 'red'; }
   else if (circfeqcnt == 3) { var circolor  = 'green'; }
   else if (circfeqcnt == 4) { var circolor  = 'purple'; }
   else if (circfeqcnt == 5) { var circolor  = 'yellow'; }
   else if (circfeqcnt  > 5) { var circolor  = 'black'; }
   
   var LatLng = e.latlng;
   var lat = e.latlng["lat"]; 
   var lng = e.latlng["lng"]; 
   
   var i; var j;
   var r = 1609.34;  // in meters = 1 mile, 4,828.03 meters in 3 miles
   
   //https://jsfiddle.net/3u09g2mf/2/   
   //https://gis.stackexchange.com/questions/240169/leaflet-onclick-add-remove-circles
   var group1 = L.featureGroup(); // Allows us to group the circles for easy removal, but not working
   
   var circleOptions = {
       color: circolor,
       fillOpacity: 0.005 ,
       fillColor: '#69e'
   } // End circleOptions var  
      
   // This routine sets a default number of miles between rings and the number of rings
   // Based on the number of rings selected and marker that was clicked, it calculates 
   // the distance to the furthest corner and returns an appropriate number of rings
   // to draw to reach it, auto magically.
   // Variable dbr is the distance between rings, might be feet or miles
   // Variable maxdist is the calculated distance to the furthest corner marker
   
   var dbr = 5; // Default for miles between circles for general markers
   var maxdist = 0;
   var maxdistr = 0;
   var numberofrings = 1;
   var distancebetween = 0;
   var Lval = 'miles';     
   var marker = lastLayer; 
   
   
   //alert('your in the right place, outside the obj loop');
            // Use this for Objects
            // Much of this code is thanks to Florian at Falke Design without who it was just over my head 4/30/2021
    if(marker.getPopup() && marker.getPopup().getContent().indexOf('OBJ') > -1){  
            // greater then -1 because the substring OBJ is found (if the substring OBJ is found, it returns the index > -1, if not found === -1)
        console.log('@51 content= '+marker.getPopup().getContent());
      //      @51 content= <div class='xx'>OBJ:<br>W0DLK04<br></div><div class='gg'>W3W: posters.sheep.pretty </div><br><div class='cc'>Comment:<br> who know?</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200908,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>
            

            // Object Markers:  Test only the object markers
            // The distanceTo() function calculates in meters
            // 1 mile = 1609.34 meters.        
        // this is test calculation only because the min distance might point to the wrong marker
        var whoArray   = [];
        var markerName = [];
        var ownerCall  = '';
        var maxdist = 0;
        
        if(marker.getPopup() && marker.getPopup().getContent().indexOf('OBJ') > -1){
            // whose marker did we find?  This 3 statements work for the middle and the corners
            markerText = marker.getPopup().getContent();    // Everything in the marker
            whoArray   = markerText.split('<br>');            // add markerText words to an array
            markerName = whoArray[1];                      // Get the callsign (I hope)
            ownerCall  = markerName.slice(0, -2);            // Deletes the number from the call
            padCall    = ownerCall.concat('PAD');
            
                console.log('@72 markerName= '+markerName+' ownerCall= '+ownerCall+' padCall= '+padCall);
     
             maxdist = Math.max(
                 LatLng.distanceTo( window[padCall].getSouthWest() ),
                 LatLng.distanceTo( window[padCall].getSouthEast() ),
                 LatLng.distanceTo( window[padCall].getNorthWest() ),
                 LatLng.distanceTo( window[padCall].getNorthEast() )              
             )/1609.34;
     
                console.log('@82 maxdist= '+maxdist+' from '+markerName+' for '+window[padCall] );
                  
                 
        }    // end of if(marker.getPopup...       
} // end of marker is an object
else if(!marker.getPopup() || marker.getPopup().getContent().indexOf('OBJ') === -1){ 
            // if the marker has NO popup or the marker has not containing OBJ in the popup
            // General Markers:  Test all the general and object markers for the furthest out
            //alert('in G');
                 
     maxdist = Math.max( 
        LatLng.distanceTo( se ), 
        LatLng.distanceTo( ne ), 
        LatLng.distanceTo( nw ), 
        LatLng.distanceTo( sw ))/1609.34;

        console.log('@98 Station maxdist: '+maxdist+' miles Lval= '+Lval);     
} // end of marker is a station   
        
        
         if (maxdist < 1) { 
             Lval = 'feet';
             maxfeet = maxdist*5280;
             if      (maxdist > 0  && maxdist <= .5)    {dbr = .05;}
             else if (maxdist > .5 && maxdist <= 1)     {dbr = .075;}
                console.log('@107 maxdist= '+maxdist+' Lval= '+Lval);     
         } else {        
        // Set the new calculated distance between markers, 5 is the default dbr     
        if (maxdist > 1  && maxdist <= 2)     {dbr = .75;}
        else if (maxdist > 2  && maxdist <= 10)    {dbr = 1;}
        else if (maxdist > 10 && maxdist <= 50)    {dbr = 5;}
        else if (maxdist > 50 && maxdist <= 500)   {dbr = 25;}
        else if (maxdist > 500 && maxdist <= 750)  {dbr = 50;}
        else if (maxdist > 750)                    {dbr = 100;}
        else                                       {dbr = 5;}
                console.log('@117 maxdist= '+maxdist+' Lval= '+Lval);
        }


    distancebetween = prompt('Distance to furthest corner is '+maxdist+" "+Lval+".\n How many "+ Lval+" between circles?", dbr);
   		//if (distancebetween <= 0) {distancebetween = 1;} 
   		//if (distancebetween > 0 && distancebetween <= 10) {distancebetween = 2;}
   		console.log('@124 db: '+distancebetween);
   		
    maxdist = maxdist/distancebetween;
        console.log('@127 distancebetween= '+distancebetween+' maxdist= '+maxdist);
   
    numberofrings = prompt(Math.round(maxdist)+" circles will cover all these objects.\n How many circles do you want to see?", Math.round(maxdist));
   		//if (numberofrings <= 0) {numberofrings = 5;}	
   		
   console.log('@132 numberofrings = '+numberofrings+' round(maxdist): '+Math.round(maxdist,2));	
   		
    
   angle1 = 90;  // mileage boxes going East
   angle2 = 270; // mileage boxes going West
   angle3 = 0;   // degree markers
   
     
    // The actual circles are created here at the var Cname =
    for (i=0 ; i < numberofrings; i++ ) {
         var Cname = 'circle'+i; 
            r = (r * i) + r; 
            r = r*distancebetween;
         var Cname = L.circle([lat, lng], r, circleOptions);
            Cname.addTo(group1); 
          map.addLayer(group1);
          
         // angle1, angle2 puts the mileage markers on the lines p_c1 and p_c2
         angle1 = angle1 + 10;
         angle2 = angle2 + 10;
         
            // i is the number of rings, depending how many have been requested the delta between bears
            // will be adjusted from 15 degrees at the 2nd circle to 5 degrees at the furthest.
            if ( i === 0  ) { //alert(numberofrings);
                for (j=0; j < 360; j+=20) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 20;
                }
            }else if ( i === 5 ) {
                    for (j=0; j < 360; j+=10) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 10;
                }         
            }else if ( i === 2 ) {
                    for (j=0; j < 360; j+=10) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 10;
                }
            }else if ( i === numberofrings-1 ) {
                    for (j=0; j < 360; j+=5) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 5;
                } // End for loop         
            } // end of else if
        
         var p_c1 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle1,r);
         var p_c2 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle2,r);
         //var inMiles = (toFixed(0)/1609.34)*.5;
         var inMiles = Math.round(r.toFixed(0)/1609.34)+' Mi';
         var inFeet  = Math.round((r.toFixed(0)/1609.34)*5280)+' Ft';
         var inKM = Math.round(r.toFixed(0)/1000)+' Km';
         var inM = Math.round((r.toFixed(0)/1000)*1000)+' M';
         
            if(Math.round(r.toFixed(0)/1609.34) < 2) {inMiles = inFeet; inKM = inM;}
        
         // Put mile and km or feet and m on each circle
         var icon = L.divIcon({ className: 'dist-marker-'+circolor, html: inMiles+' <br> '+inKM, iconSize: [60, null] });
         
         var marker = L.marker(p_c1, { title: inMiles+'Miles', icon: icon});
         var marker2 = L.marker(p_c2, { title: inMiles+'Miles', icon: icon});
      
         marker.addTo(map);
         marker2.addTo(map);
         
        // reset r so r calculation above works for each 1 mile step 
        r = 1609.34;     
        var dbr = 1; // Default for miles between circles for general markers
        var maxdist = 1;
    } // end of for loop 
} // end circleKoords function