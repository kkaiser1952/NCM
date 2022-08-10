// Specifically for the stations table and editStationsTable.php

function CellEditFunctionStations( jQuery ) {

		 $(".editFnm").editable("stationsave.php", {				// First name
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "First Name Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editTAC").editable("stationsave.php", {				// Tactical call
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Tactical Call Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editPhone").editable("stationsave.php", {				// Phone Number
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Phone Number Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editLnm").editable("stationsave.php", {				// Last name
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Last Name Click to edit...",
		 style  	: "inherit"
		 });	 
		 
		 $(".editEMAIL").editable("stationsave.php", {				// Email
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Enter a valid email address",
		 style  	: "inherit"
		 });

		 $(".editCREDS").editable("stationsave.php", {				// Credentials
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "Credentials Click to edit...",
		 style  	: "inherit"
		 })z
	  		 
		 $(".editcnty").editable("stationsave.php", {				// County
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "County Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editstate").editable("stationsave.php", {				// State
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "State Click to edit...",
		 style  	: "inherit"
		 });
		 
		 $(".editdist").editable("stationsave.php", {				// District
		 indicator 	: "Saving...",
		 placeholder: "",
		 tooltip    : "District Click to edit...",
		 style  	: "inherit"
		 });
			 
		 $(".editGRID").editable("stationsave.php", {				// Grid
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
		 
		 $(".editLAT").editable("stationsave.php", {				// Latitude
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
		 
		 $(".editLON").editable("stationsave.php", {				// Longitude
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
        	
} // end of CellEdityFunction