function ReadGenComments() {
	var whatitsaid = $('#genComments').html();
		var sendTo = $('#genComments').html().slice(0,4);
}

// This function adds the various edit class' to the column cells
function AddEdits() {
	$('.TT').addClass('editTT');
	$('.cs1').addClass('editCS1');
	$('.Fname').addClass('editFnm');
	
	$('.Lname').addClass('editLnm');
	$('.tactical').addClass('editTAC');
	$('.phone').addClass('editPhone');
	
	$('.email').addClass('editEmail');
	$('.grid').addClass('editGRID');
	$('.latitude').addClass('editLAT');
	
	$('.longitude').addClass('editLON');
	$('.logdate').addClass('editTimeIn');
	$('.timeout').addClass('editTimeOut');
	
	$('.comments').addClass('editC');
	$('.creds').addClass('editCREDS');
	$('.county').addClass('editcnty');
	
	$('.state').addClass('editstate');
	$('.district').addClass('editdist');
	$('.netcontrol').addClass('editable_selectNC');
	
	$('.mode').addClass('editable_selectMode');
	$('.role').addClass('editable_selectACT');
	$('.traffic').addClass('editable_selectTFC');
}

// This function removes the various edit class' from the column cells
function RemoveEdits() {
	$('.TT').removeClass('editTT');
	$('.cs1').removeClass('editCS1');
	$('.Fname').removeClass('editFnm');
	
	$('.Lname').removeClass('editLnm');
	$('.tactical').removeClass('editTAC');
	$('.phone').removeClass('editPhone');
	
	$('.email').removeClass('editEmail');
	$('.grid').removeClass('editGRID');
	$('.latitude').removeClass('editLAT');
	
	$('.longitude').removeClass('editLON');
	$('.logdate').removeClass('editTimeIn');
	$('.timeout').removeClass('editTimeOut');
	
	$('.comments').removeClass('editC');
	$('.creds').removeClass('editCREDS');
	$('.county').removeClass('editcnty');
	
	$('.state').removeClass('editstate');
	$('.district').removeClass('editdist');
	$('.netcontrol').removeClass('editable_selectNC');
	
	$('.mode').removeClass('editable_selectMode');
	$('.role').removeClass('editable_selectACT');
	$('.traffic').removeClass('editable_selectTFC');
}

// Added 2018-02-12 -- replaces the same in the NetManager.js & NetManager-p2.js javascripts
function CellEditFunction( jQuery ) {
	
		 //var refreshnow=$("#idofnet").html().trim();
		 
		 var netid=$("#idofnet").html().trim();				// Picks up the net number

		 $(".editGComms").editable("SaveGenComm.php", {		// genComm	   
	     indicator  : "Saving...",
	     placeholder: "",
	     tooltip	: "Click to add...",
	     style		: "inherit",
	     callback	: function() {ReadGenComments();},
	     id			: netid,
	     name		: "newvalue"
	 	 });

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
		 tooltip    : "Call Sign No edit",
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
		// submit     : "OK"  add the comma after the style setting
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
		 type		: "email", 
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
		 
		 $(".editGRID").editable("save.php", {				// Grid
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Grid Click to edit...",
		 style  	: "inherit",
		 callback : function(result, settings, submitdata, id) {
			$.ajax({
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
			$.ajax({
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
			$.ajax({
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
		 tooltip    : "Comments TT Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editC").editable("save.php", {  				// comments
		 type	   : "text",
		 placement : "top",
		 placeholder: "",
		 indicator : "Saving...",
		 tooltip   : "Comments Click to edit...",
		 style     : "inherit" 
		 });
		 
	 
	 	$(".editable_selectACT").editable("save.php", {  	// status
	    data    : '{"In":"In","Out":"Out","In-Out":"In-Out","BRB":"BRB","MISSING":"MISSING"}',
	    type    : "select",
	    placeholder: "",
	    callback: function() {refresh();},  //changes color of row immeditly
	 //   submit 	: "OK",  // Dropped from here and other dropdowns 2018-03-03
	    tooltip : "Status dropdown",
	    style   : "inherit"
	 	});
	 	
	 	$(".editable_selectTFC").editable("save.php", { 	// traffic
	    data    : '{"":"","Routine":"Routine","Welfare":"Welfare","Priority":"Priority","Emergency":"Emergency","Question":"Question","Announcement":"Announcement","Bulletin":"Bulletin","Comment":"Comment","Pending":"Pending","Resolved":"Resolved","Sent":"Sent"}',
	    type    : "select",
	    placeholder: "",
	    callback: function() {refresh();},   //changes color of row immeditly
	    tooltip : "Traffic dropdown",
	    style   : "inherit"
	 	});
	 	
	 	$(".editable_selectMode").editable("save.php", {	// Mode 
	     data    : '{"":"","Mob":"Mob","HT":"HT","Dig":"Dig","FSQ":"FSQ","D*":"D*","Echo":"Echo","DMR":"DMR","V&D":"V&D"}',
	     type 	 : "select",
	     placeholder: "",
	    
	     callback: function() {refresh();},   //changes color of row immeditly
	     tooltip : "Mode dropdown",
	     style	 : "inherit"
	 	});
	 
	 	$(".editable_selectNC").editable("save.php", { 		// netcontrol aka role on screen
	    data    : '{" ":" ","PRM":"PRM","2nd":"2nd","Log":"Log","LSN":"LSN","EM":"EM","PIO":"PIO"}',
	    type    : "select",
	    placeholder: "",
	    callback: function() {refresh();},   //changes color of row immeditly
	    
	    tooltip : "Role dropdown",
	    style   : "inherit"
	 	});
	
} // end of CellEdityFunction