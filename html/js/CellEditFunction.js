
// Added 2018-02-12 -- replaces the same in the NetManager.js &amp; NetManager-p2.js javascripts
function CellEditFunction( jQuery ) {
    
 // This tests if the net is closed and then prevents any editing. if open it allows it. The close of the { is second from the bottom of the function.
 var dothework = $(".closenet").html().trim(); //alert(dothework);  // Net Closed  or  Close Net
   if ( dothework == "Close Net") {
	
		 var netid=$("#idofnet").eq(0).html().trim();
		 
		 var submitdata = {}; 
		    console.log(submitdata); //alert(submitdata);
		 var call = '';

		 $(".editGComms").editable("SaveGenComm.php", {		// genComm	   
    	     indicator  : "Saving...",
    	     placeholder: "",
    	     tooltip	: "Click to add...",
    	     style		: "inherit",
             onsubmit   : function() { submitdata[''] = prompt('Enter Your Call'); },
             submitdata : submitdata, 
             id			: netid
	 	 }); // End of editGComms

		 $(".editTimeOut").editable("save.php", {			// Time Out
    		 indicator 	: "",
    		 placeholder: "",
    		 tooltip    : "Time Out, double click to edit. 2018-04-12 19:25:00",
    		 event		: "dblclick",
    		 style  	: "inherit",
    		 callback	: function(result, settings, submitdata, id) { // update the Time On Duty column
    			 $.ajax({
    				type: "GET",
    				url: "updateTOD.php",  
    				data: {recordID:this.id.split(":").pop()},
    				success: function(response) {
    				},
    				error: function() {
    					alert('Update of TOD Query Failed, try again.');
    				}
    			});  // end ajax
		 } // end callback
		 }); // end editTimeOut
		 
		 $(".editTimeIn").editable("save.php", {			// Time In
		 indicator 	: "",
		 placeholder: "",
		 tooltip    : "Time In, double click to edit. 2018-04-12 19:25:00",
		 event		: "dblclick",
		 style  	: "inherit",
		 callback	: function(result, settings, submitdata, id) { // update the Time On Duty column
			 $.ajax({
				type: "GET",
				url: "updateTOD.php",  
				data: {recordID:this.id.split(":").pop()},
				success: function(response) {
				},
				error: function() {
					alert('Update of TOD Query Failed, try again.');
				}
			});  // end ajax
		 } // end callback
		 }); // end editTimeIn
	 
		 $(".editCS1").editable("save.php", {				// Call sign
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Call Sign No edit, except when Pre-Built",
		 style  	: "inherit"
		 }); 
	
		 $(".editFnm").editable("save.php", {				// First name
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "First Name Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editTAC").editable("save.php", {				// Tactical call
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Tactical Call Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editPhone").editable("save.php", {				// Phone Number
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Phone Number Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editLnm").editable("save.php", {				// Last name
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Last Name Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editEMAIL").editable("save.php", {				// Email
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Enter a valid email address",
		 style  	: "inherit"
		 });
	 
		 $(".editCREDS").editable("save.php", {				// Credentials
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Credentials Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editcnty").editable("save.php", {				// County
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "County Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editstate").editable("save.php", {				// State
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "State Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editdist").editable("save.php", {				// District
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "District Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".W3W").editable("save.php", {				// What3Words
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "what3words Click to edit...",
		 style  	: "inherit",
		 callback : function(result, settings, submitdata, id) {
			$.ajax({ // Calculates a new lat/lon when W3W changes
				type: "GET",
				url:	 "updateLATLONw3w.php",
				data: {recordID:this.id.split(":").pop()},
				success: function(response) {
    				//alert(response);
				}, // end success
				error: function() {
					alert("Update to Lat and Lon failed!, \nInvalid what3words, please re-enter.");
				} // end error
			}); // end ajax
			refresh();
		 } // end call back 
		 }); // end editLAT
		 
		 $(".editGRID").editable("save.php", {				// Grid
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Grid Click to edit...",
		 style  	: "inherit",
		 callback : function(result, settings, submitdata, id) {
			$.ajax({ // Calculates a new lat/lon when GRID changes
				type: "GET",
				url:	 "updateLATLON.php",
				data: {recordID:this.id.split(":").pop()},
				success: function(response) {
				}, // end success
				error: function() {
					alert('Update to Lat &amp; Lon failed!');
				} // end error
			}); // end ajax
			refresh();
		 } // end call back 
		 }); // end editLAT
		 
		 $(".editLAT").editable("save.php", {				// Latitude
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Latitude Click to edit...",
		 style  	: "inherit",
		 callback : function(result, settings, submitdata, id) {
			$.ajax({ // Calculates a new GRID when latitude changes
				type: "GET",
				url:	 "updateGRID.php",
				data: {recordID:this.id.split(":").pop()},
				success: function(response) {
				}, // end success
				error: function() {
					alert('Update to GRID failed!');
				} // end error
			}); // end ajax
			refresh();
		 } // end call back 
		 }); // end editLAT
		 
		 $(".editLON").editable("save.php", {				// Longitude
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Longitude Click to edit...",
		 style  	: "inherit",
		 callback : function(result, settings, submitdata, id) {
			$.ajax({ // Calculates a new GRID when longitude changes
				type: "GET",
				url:	 "updateGRID.php",
				data: {recordID:this.id.split(":").pop()},
				success: function(response) {
				}, // end success
				error: function() {
					alert('Update to GRID failed!');
				} // end error
			}); // end ajax
			refresh();
		 } // end call back 
		 }); // end editLON
		 
		 $(".editTT").editable("save.php", {				// tt  added here 2018-12-26
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "TT Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editCat").editable("save.php", {				// added 2020-04-01, Who is getting the traffic
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Trfk-For Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editSec").editable("save.php", {				// fd  added here 2020-04-01
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "FD Click to edit...",
		 style  	: "inherit"
		 });

		 $(".editC").editable("save.php", {  				// comments
		 type	   : "text",
		 onblur: "submit",
		 placement : "top",
		 placeholder: "",
		 indicator : "Saving...",
		 tooltip   : "Comments Click to edit...",
		 style     : "inherit" 
		 });
 
	 
	 	$(".editable_selectACT").editable("save.php", {  	// status
	    data    : '{"In":"In","OUT":"OUT","In-Out":"In-Out","Leave?":"Leave?","Moved":"Moved","BRB":"BRB","Enroute":"Enroute","Assigned":"Assigned","MISSING":"MISSING"}',
	    type    : "select",
	    placeholder: "",
	        onblur: 'submit',
	        submit:"OK",
	    callback: function() {refresh();},  //changes color of row immeditly
	    tooltip : "Status dropdown",
	    style   : "inherit"
	 	});
	 	
	 	$(".editable_selectTFC").editable("save.php", { 	// traffic
	    data: '{"":"","Traffic":"Traffic","Routine":"Routine","Welfare":"Welfare","Priority":"Priority","Emergency":"Emergency","Question":"Question","Announcement":"Announcement","Bulletin":"Bulletin","Comment":"Comment","Pending":"Pending","Resolved":"Resolved","Sent":"Sent"}',
	    type    : "select",
	    placeholder: "",
	     onblur: "submit",
	    callback: function() {refresh();},   //changes color of row immeditly
	    tooltip : "Traffic dropdown",
	    style   : "inherit"
	 	});
	 	
	 	
	 	// the onedit option. If it returns false, it won't send data.
	 	$(".editable_selectMode").editable("save.php", {	// Mode 
data    : '{"":"","Voice":"Voice","CW":"CW","Mob":"Mob","HT":"HT","Dig":"Dig","FSQ":"FSQ","D*":"D*","Echo":"Echo","DMR":"DMR","Fusion":"Fusion","Winlink":"Winlink","V&D":"V&D","Online":"Online","Relay":"Relay"}',
	     type: "select",
	/*     
    	// This code was to prevent submitting to the server, it purpose was to prevent dupe entries in TimeLog
    	// The dupes happen when someone touches Mode or Status or ??? but doesn't make a change to its value.
    	// I don't like the mess it makes in the ICS-214 or in displaying the TimeLog on screen
    	// Other options here were onedit: but couldn't get that working either. 
    	
	     onsubmit: function(settings, original) {
          // const oldmode = original.innerText;            console.log('om  '+ oldmode );
          // const oldmode2 = $(".Mode46924").data("mode"); console.log('om2 '+ oldmode2 );
           const oldmode3 = $(this).data("mode");         console.log('om3 '+ oldmode3 );
          // const newmode = $(".Mode46924").text();        console.log('nm  '+ newmode );
           const newmode2 = $(this)[0][0].value;          console.log('nm2 '+ newmode2 );
           
          // return newmode2 !== oldmode2;
          // Using the above works but it freezes the cell (Mode, etc) until a selection is made, not an option
         },
  */  
	     placeholder: "",
	     onblur: "submit",
	     submit:"OK",
	     callback: function() {refresh();},   //changes color of row immeditly
	     tooltip : "Mode dropdown",
	     style	 : "inherit"
	 	});
	 		
	 
	 	$(".editable_selectNC").editable("save.php", { 		// netcontrol aka role on screen
	    data    : '{" ":" ","PRM":"PRM","2nd":"2nd","Log":"Log","LSN":"LSN","EM":"EM","PIO":"PIO","SEC":"SEC","RELAY":"RELAY"}',
	    type    : "select",
	     onblur: "submit",
	    placeholder: "",
	    callback: function() {refresh();},   //changes color of row immeditly
	    tooltip : "Role dropdown",
	    style   : "inherit"
	 	});
	 	
	 	$(".editBand").editable("save.php", { 		// Band
	    data    : '{" ":" ","Rptr 1":"Rptr 1","Rptr 2":"Rptr 2","160m":"160m","80m":"80m","60m":"60m","40m":"40m","30m":"30m","20m":"20m","17m":"17m","15m":"15m","12m":"12m","10m":"10m","6m":"6m","2m":"2m","1,25m":"1.25m","70cm":"70cm","33cm":"33cm","23cm":"23cm","2.4GHz":"2.4GHz"}',
	    type    : "select",
	     onblur: "submit",
	    placeholder: "",
	//    callback: function() {refresh();},   //changes color of row immeditly
	    tooltip : "Band dropdown",
	    style   : "inherit"
	 	});
	 	
	 	// Admin Level
	 	/*
	 	$(".c25").editable("save.php", {				
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "recordID Do Not Edit...",
		 style  	: "inherit"
		 });
		 
		 $(".c26").editable("save.php", {				
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "ID Do Not Edit...",
		 style  	: "inherit"
		 });
		 
		 $(".c27").editable("save.php", {				
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "status  Do Not Edit...",
		 style  	: "inherit"
		 });
	    */	 
		 $(".c28").editable("save.php", {				
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "home, Concatination of lat/lon, grid, county &amp; state..",
		 style  	: "inherit"
		 });
		 /*
		 $(".c29").editable("save.php", {				
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "ipaddress Do Not Edit...",
		 style  	: "inherit"
		 });
		 */
   } // End of dothework Close Net test
} // end of CellEditFunction