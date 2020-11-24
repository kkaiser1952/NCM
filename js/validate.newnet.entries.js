// Validate that a call sign was entered and that it is a valid call sign
$(document).ready(function () {
	
	$("#netcall, #newnetkind, #newnetfreq, #satNet").change(function() {
		var callentered = $("#callsign").val();
			if (callentered == "") {
				alert("A call sign is required.");
					$("#callsign").focus();
			}
	});

	
	$("#submit").click(function( event ) {
		var callentered = $("#callsign").val();
			if (callentered == "") {
				event.preventDefault();
					alert("Please enter a call sign first.");
						$("#callsign").focus();
			}
	}); 
});