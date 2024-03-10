    // This code is called by the map.php program 
    // its used to map the object markers created with APRS or W3W
    // These are neded to determine the corners and centers
    <?php   
           echo "$objBounds" ;
           echo "$objMiddle" ;
           echo "$objPadit";
    ?>

    // Object markers here
    <?php echo "$objMarkers"; ?>
    
    // Corner and center flags for the object markers, 5 for each callsign that has objects
    <?php echo "$cornerMarkers"; ?>
    
    // <?php echo "$allnameBounds"; ?>

    // Object Marker List starts here
    <?php echo "$OBJMarkerList"; ?>
    
    // Add the OBJMarkerList to the map
    OBJMarkerList.addTo(map);
            
    // color wheel for the lines
    const colorwheel = ["green","blue","orange","plum","lightblue","gray","gold","black","red"];
       
    <?php echo "$uniqueCallList"; ?>
        console.log('@417 length= '+uniqueCallList.length+' uniqueCallList[1]= '+uniqueCallList[1]);
                  

  // ========= All seems good to here, newKoords below does not get expanded ============
  
         
    for (z = 0; z < uniqueCallList.length; z++) {
            console.log('@430 value= '+uniqueCallList[z]);
            // WA0TJTlatlngs  
                            
        newKoords = uniqueCallList[z].slice(0); 
            console.log('@434 '+newKoords);  // output is correct,
       
        newcolor = colorwheel[z]; // sets the color in the var objectLine below
            console.log('@437 newcolor= '+newcolor); // green
    
         
        objectLine = L.polyline(newKoords,{color: newcolor, weight: 4}).addTo(map);
             
        
            // Add connecting lines between the corners of the objects
           //<?php echo "$KornerList"; ?>
           //objectKornerKoords = connectTheDots(KornerList);
           //var objectKornerLine = L.polyline(objectKornerKoords,{color: newcolor, weight: 3}).addTo(map);    

    } // end for loop