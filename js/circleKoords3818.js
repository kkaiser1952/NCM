var circfeqcnt = 0; // Sets a variable to count how many times the circleKoords() function is called
function circleKoords(e) {
     
   circfeqcnt = circfeqcnt + 1; //alert(circfeqcnt);
    
   if (circfeqcnt <= 1) { var circolor  = 'blue';  }
   else if (circfeqcnt == 2) { var circolor  = 'red'; }
   else if (circfeqcnt == 3) { var circolor  = 'green'; }
   else if (circfeqcnt == 4) { var circolor  = 'purple'; }
   else if (circfeqcnt == 5) { var circolor  = 'yellow'; }
   else if (circfeqcnt > 5) { var circolor  = 'black'; }
   
   var LatLng = e.latlng;
   var lat = e.latlng["lat"]; 
   var lng = e.latlng["lng"]; 
   
   var i; var j;
   var r = 1609.34;  // in meters = 1 mile, 4,828.03 meters in 3 miles
   
   //https://jsfiddle.net/3u09g2mf/2/   
   //https://gis.stackexchange.com/questions/240169/leaflet-onclick-add-remove-circles
   var group1 = L.featureGroup(); // Allows us to group the circles for easy removal
   
   var circleOptions = {
       color: circolor,
       fillOpacity: 0.005 ,
       fillColor: '#69e'
   } // End circleOptions var  
      
   // This routine sets a default number of miles between ringles and the number of rings
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
   
            // Use this for Objects
            // Much of this code is thanks to Florian at Falke Design without who it was just over my head 4/30/2021
        if(marker.getPopup() && marker.getPopup().getContent().indexOf('OBJ') > -1){  
            // greater then -1 because the substring OBJ is found (if the substring OBJ is found, it returns the index > -1, if not found === -1)
            
            // Object Markers:  Test only the object markers
            // The distanceTo() function calculates in meters
            // 1 mile = 1609.34 meters.        
        // this is test calculation only because the min distance might point to the wrong marker
        var whoArray = [];
        var whoMarker = [];
        
        if(marker.getPopup() && marker.getPopup().getContent().indexOf('OBJ') > -1){
            // whose marker did we find?  This 3 statements work for the middle and the corners
            markerText = marker.getPopup().getContent();    // Everything in the marker
            whoArray = markerText.split('<br>');            // add markerText words to an array
            whoMarker =  whoArray[1];                       // Get the callsign (I hope)
                console.log('@62 whoMarker= '+whoMarker);
        
            
                 mindist = Math.min(LatLng.distanceTo( padit.getSouthEast() ))/1609.34; 
                    //console.log('@62 mindist= '+'  '+LatLng+'  '+mindist);
                    
                 maxdist = Math.max( 
                    LatLng.distanceTo( padit.getSouthEast() ), 
                    LatLng.distanceTo( padit.getNorthEast() ), 
                    LatLng.distanceTo( padit.getNorthWest() ), 
                    LatLng.distanceTo( padit.getSouthWest() ))/1609.34;   
                    
            // if the maxdist and mindist values are the same, then this distance to a corner is confirmed
            // otherwise one or the other is pulling the wrong SE corner marker
            // find a way to get the correct one
            console.log('@77 maxdist= '+'  '+LatLng+'  '+maxdist);
            console.log('@78 mindist= '+'  '+LatLng+'  '+mindist);
                    
                    /*
                    console.log('@71 se= '+LatLng.distanceTo(Ose)*3.28084+
                                   ' ne= '+LatLng.distanceTo(One)*3.28084+
                                   ' nw= '+LatLng.distanceTo(Onw)*3.28084+
                                   ' sw= '+LatLng.distanceTo(Osw)*3.28084+' in feet');
                                   
                    console.log('@76  Object maxdist: '+maxdist+' miles '+maxdist/5280+' feet');
                    */
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

                    console.log('@90 Station maxdist: '+maxdist+' miles');     
        } // end of marker is a station   
        
            
            
           
        
         if (maxdist < 1) {maxdist = Math.round((maxdist*3.28084),2); Lval = 'feet';}          
        // Set the new calculated distance between markers, 5 is the default dbr     
        if      (maxdist > 0  && maxdist <= .05)    {dbr = .025;}
        else if (maxdist > .05 && maxdist <= 2)     {dbr = .05;}
    /*    else if (maxdist > 1  && maxdist <= 2)    {dbr = .75;} */
        else if (maxdist > 2  && maxdist <= 10)     {dbr = 1;}
        else if (maxdist > 10 && maxdist <= 50)     {dbr = 5;}
        else if (maxdist > 50 && maxdist <= 500)    {dbr = 25;}
        else if (maxdist > 500 && maxdist <= 750)   {dbr = 50;}
        else if (maxdist > 750)                     {dbr = 100;}
        else                                        {dbr = 5;}
        
        
        console.log('@111 maxdist= '+maxdist+' Lval= '+Lval);     
        Lval = '';
    

    distancebetween = prompt('Distance to furthest corner is '+maxdist+" "+Lval+".\n How many "+ Lval+" between circles?", dbr);
   		//if (distancebetween <= 0) {distancebetween = 1;} 
   		//if (distancebetween > 0 && distancebetween <= 10) {distancebetween = 2;}
   		console.log('@118 db: '+distancebetween);
   		
    maxdist = maxdist/distancebetween;
        console.log('@121 distancebetween= '+distancebetween+' maxdist= '+maxdist);
   
    numberofrings = prompt(Math.round(maxdist)+" circles will cover all these objects.\n How many circles do you want to see?", Math.round(maxdist));
   		//if (numberofrings <= 0) {numberofrings = 5;}	
   		
   console.log('@126 numberofrings = '+numberofrings+' round(maxdist): '+Math.round(maxdist,2));	
   		
    
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
          
          
          //alert(r);
         //90° from top
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
            }   else if ( i === 5 ) {
                    for (j=0; j < 360; j+=10) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 10;
                }         
            }   else if ( i === 2 ) {
                    for (j=0; j < 360; j+=10) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 10;
                }
            }   else if ( i === numberofrings-1 ) {
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
      
         //$(".dist-marker").css("color", circolor);
         marker.addTo(map);
         marker2.addTo(map);
         //$(".dist-marker").css("color", circolor);
         
        // reset r so r calculation above works for each 1 mile step 
        r = 1609.34;     
        var dbr = 1; // Default for miles between circles for general markers
        var maxdist = 1;
    } 
    
    // This part allows us to delete the circles by simply clicking anywhere in the circles.
   // group1.on('click', function() {
    //    if(map.hasLayer(group1)) {map.removeLayer(group1);}
    //});
} // end circleKoords function