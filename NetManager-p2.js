/* All of this NetManager-p2 (part 2) file was copied from the top of the index.php and move here on 2018-1-15 */
function showDTTM() {
	if (!document.all&&!document.getElementById)
		return
		thelement=document.getElementById? document.getElementById("dttm2"): document.all.dttm2
	var mydate=new Date()
	var year=mydate.getYear()
		if (year < 1000) year+=1900
	var day=mydate.getDay()
	var month=mydate.getMonth()
	var daym=mydate.getDate()
		if (daym<10) daym="0"+daym
	var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
	var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
	var hours=mydate.getHours()
	var minutes=mydate.getMinutes()
	var seconds=mydate.getSeconds()
	var dn="PM"
		if (hours<12) 	dn="AM"
		if (hours>12) 	hours=hours-12
		if (hours==0) 	hours=12
		if (minutes<=9) minutes="0"+minutes
		if (seconds<=9) seconds="0"+seconds
	var ctime=hours+":"+minutes+":"+seconds+" "+dn
		thelement.innerHTML=dayarray[day]+", "+montharray[month]+" "+daym+", "+year+" "+ctime
		//var currentTimeString = dayarray[day]+","+montharray[month]+" "+daym+", "+year+" "+ctime;
		//setTimeout("showDTTM()",1000)
}

$(document).ready(function() {
	setInterval('showDTTM()', 1000);
	
	$( ".editable_selectACT" ).change(function() {
		alert( "you changed ACT" );
	});
});

// newNet function goes here


/*
$(document).ready(function() {
	$( ".netGroup" ).change(function() {
	  var newnetnm = $('.netGroup option:selected').text();   //alert('newnetnm= '+newnetnm); //KCNARES
	  
		if (newnetnm.startsWith(' Name Your')) {              //alert("in the give name");
			var str = prompt("please enter a call sign or one word name for this net", "K2BSA");
				str = str.toUpperCase(); //alert("str= "+str);
		}else {
			var str = $('.netGroup option:selected').text();  alert('in JQuery str= '+str); //KCNARES
		} 
	});
});
*/


function newNet(str) {   //alert('in newNet() str= '+str); // undefined
	$(".newstuff").addClass("hidden");
	$(".theBox").addClass("hidden");  // Hide the 'Start a new Net' button when creating a new net
	$("#refbutton").removeClass("hidden");
	$("#makeNewNet").addClass("hidden");
	//$("#select1").removeClass("hidden");
	$("#form-group-1").show();
	$("#timer").removeClass("hidden");
	//var newnetnm = str;  alert("in newNet newnetnm= "+str);
	
	// Not sure this gets executed anymore
	var newnetnm = $('.netGroup option:selected').text(); //alert('newnetnm= '+newnetnm); //KCNARES
	    newnetnm = newnetnm.split('--->')[1];
		if (newnetnm.startsWith(' Name Your Own')) { //alert("in the give name");
			var newnetnm = prompt("please enter a call sign or one word name for this net", "K2BSA");
				newnetnm = newnetnm.toUpperCase().trim();
				//alert(newnetnm);
		} 
	
	//var callsign = document.getElementById("callsign").value;
	var callsign = $("#callsign").val().toUpperCase();   //alert('callsign= '+callsign); //Call of person who started the net.  WA0TJT
	
	var netcall = $("#netcall option:selected").val();  //alert('1st netcall= '+netcall); //1st netcall= 1:2:2:W0KCN'
	// 1st netcall= 99
		// the net call sign is currently in position 4 not 1
		// Problem: the value of netcall when its the answer to 'Name Your Own' in start a new net
	var parts = netcall.split(':');
			netcall = parts[3].replace(/(\w+).*/,"$1");
			// id of netcall in NetKind
			netkindid = parts[0];
		//	alert("@86 in p2Test.js: "+netkindid);
			//netcall = netcall.replace(/(\w+).*/,"$1");
		//netcall = netcall.replace(/(\w+).*/,"$1"); // Select only the first word   // 1
			//alert('netcall= '+netcall); // W0KCN
		$("#upperRightCorner").load("buildUpperRightCorner.php?call="+netcall);
		$("#urc").load("buildUpperRightCorner.php?call="+netcall);
		
		//fillFreqs(netcall);	// Builds the upper right corner of the window
		
	var selVar = $('#netcall option:selected').val();
	//var	selVar = e.options[e.selectedIndex].value; // if 0 then its an error ;
		if (selVar == 0) {var netcall = prompt("Please enter the call sign for the net you are starting");}
	
		if (netcall == 'Other') {
			var netcall = prompt("Please enter the call sign for the net you are starting");
		}
		
	//filltitle(netcall);  //commented out on 5/8/17
	
	var newnetfreq = $("#newnetfreq option:selected").text();
	
	//var e = document.getElementById("newnetfreq");
	//var newnetfreq = e.options[e.selectedIndex].text;
		if (newnetfreq == 'Other Frequency') {
			var newnetfreq = prompt("please enter the frequency and tone (if any) for this net", "Frequency, Tone");
		}
		
	// Is this being done?
	var newnetkind = $("#newnetkind option:selected").text(); //alert('@93 newnetkind= '+newnetkind);
		if (newnetkind == 'Name Your Own Net') {
			var newnetkind = prompt("What kind of net is it?", "Lazy, Dark Night Net");
				//newnetkind = newnetnm.toUpperCase();
				//alert(newnetnm);  // WA0TJT:W0KCN: KCNARES :444.550Mhz(+), T: 100.0Hz:853:SET Exercise  Net
		}
		if (newnetkind == 'Event Net') {
			var newnetkind = prompt("Enter the name of the event", "WIN for KC Triathlon Net");
				//newnetkind = newnetnm.toUpperCase();
		}
		
	var pb = 0;
		if ( $("#pb").is(':checked')) {var pb = 1}
	
	//alert("@133 in NetManager-p2.js pb= "+pb);
	
	// 2018-1-25 var satNet = document.getElementById("satNet").value; 
	var satNet = $("#satNet").val();
	var str = callsign+":"+netcall+":"+newnetnm+":"+newnetfreq+":"+satNet+":"+newnetkind+":"+pb;  //alert(str);
			//WA0TJT:	   W0KCN:      KCNARES :   146.790MHz, T 107.2Hz:0:   Weekly 2 Meter Voice Net:0  
	        //WA0TJT:      EVENT:      Event   :   146.940MHz:           0:   Liberty Bi-Marathon:1
console.log('str');
      if (window.XMLHttpRequest) {
	  	var xmlhttp = new XMLHttpRequest();
	  } else {
	  	var xmlhttp = new ActivXObject("Microsoft.XMLHTTP");
	  }
	  
	$.ajax({
		type: 'POST',
		url: 'newNet.php',
		data: {q: str},
		success: function(response) {
			var newnetID = response; 			
  			showActivities(response);
  			
  			/* ****************************************************************/
  			/* The var storeselect1 is the new net name */
  			/* This makes the newly created net show up in the dropdown box */
  			var storeselect1 = $("#select1").html();
  				//alert(storeselect1);
  			
  			var strBlank  = " ";
  			var activity  = newnetnm.trim().concat(strBlank,newnetkind.trim());   //alert('activity= '+activity);
  			var newoption = '<option value="'+netcall+'" selected>Net #: '+ newnetID +' --> '+ activity +' '+new Date()+'</option>';
  			var newselect = storeselect1 + newoption;
  		
  				$("#select1").append(newoption);
  				$("#select1").selectpicker("refresh");
			
		} // end response
	}); // end ajax writing of table
}

var binaryops = 0;
function checkIn() {
	var numbers 	= /^[0-9]+$/;
  
	var id 		= $("#hideme").val();  
		//alert('id= '+id);
	var netID 	= $("#select1").val();
		// the fix below is for the new version as of 2018-07-10
		if(!netID.match(numbers)) {
	  		var netID = $("#idofnet").text().trim();
		}
  	
	var cs1   	= $("#cs1").val().toUpperCase().trim();
	var Fname	= $("#Fname").val();
	var therest	= $("#hidestuff").val();
	
	var netcall	= $("#domain").html().replace(/\s+/g, '').toUpperCase(); //added: 2016-12-08
	var mode		= $("#dfltmode").val();  //alert("mode= "+mode);	
//	var cs1 		= cs1.toUpperCase();
  	  
  /* The next few lines test the validity of the callsign cs1 and exits if not good */
  	if (cs1.trim() == "NONHAM") {
      // This is an allowed entry... so no problems
  	} else {   // anything else needs to be processed
      firstDigit = cs1.match(/\d/);
	  
	  // All callsigns require at least one number 
	  if (firstDigit == null && cs1.trim() != "NONHAM" ) {
    	
		  var cs1 = prompt(cs1+" is an invalid callsign! \n Callsigns worldwide requie at least one number. \n Please enter a correct callsign, or the word NONHAM for non amateurs.");
		  
			  if (cs1 === "" || (cs1.match(/\d/) == null)) {
			  	return;
			  } 
	  } // End if @195
  	} // End else @191

	var str =     id+":"+netID+":"+cs1+":"+Fname+":"+therest+":"+binaryops+":"+netcall.toUpperCase(); 
	//alert("@206 str= "+str); // @206 str= :1208:W0DLK:Deb::0:TE0ST
  
	// Decloratoin for these variables       
	id = netId = cs1 = Fname = therest = {};
  
	// Adjust these fields after the new str is created
  	document.getElementById("cs1").value = "";
	document.getElementById("Fname").value = "";
	  
	document.getElementById("txtHint").style.color = "black";
	document.getElementById("cs1").focus();

	// Add to the DB new as of 2018-08-04
	  $.ajax({
		type: 'POST',
		url: 'checkIn.php',
		data: {q: str},
		success: function(response) {
			$( "thead" ).remove();

			$("#netBody").html(response);
			testCookies();
		//	setTimeout(function() {
    		     setTimeout( () => {
			    sorttable.makeSortable(document.getElementById("thisNet"));
			    
			    // This gives me the ability to edit each cell
			     $( document ).ready( CellEditFunction );
			  }, 100); //end setTimeout function 
		//	});
			
		} // end response
	  }); // end ajax reading of table

 	$('#cs1').focus();
} // End of checkin function

function ShowGenComm() {
	var newContent = $("#forcb1 #genComments").html(); //alert(newContent);
}

function fillFreqs() {
	//alert("in fillFreqs()");
	var netcall = $('#netcall option:selected').text();
	//var e = document.getElementById("netcall");  2018-05-20
	//var netcall = e.options[e.selectedIndex].text; 
		netcall = netcall.replace(/(\w+).*/,"$1");
			
	$(document).ready(function() {
		//$("#ourFrequencies").load("buildourFrequencies.php?call="+netcall); 
		//alert(netcall);
		$("#upperRightCorner").load("buildUpperRightCorner.php?call="+netcall);
		$("#urc").load("buildUpperRightCorner.php?call="+netcall);
	});
}

function fillURC() {
	var netcall = $('#netcall option:selected').text();
	//var e = document.getElementById("netcall");  2018-05-20
	//var netcall = e.options[e.selectedIndex].text; 
		netcall = netcall.replace(/(\w+).*/,"$1");
			
	$(document).ready(function() {
		$("#urc").load("buildUpperRightCorner.php?call="+netcall);
	});
}

$(document).ready(function () {
    $('#ckin1').on('keyup', function (e) {
        var keyCode = e.keyCode || e.which; 

  if (keyCode == 9 && !e.shiftKey) { 
    e.preventDefault();
    $('#cs1').focus();
    return false;
  } 

    });
});

$('.remember-selection').each(function(r) {
    var thisSelection = $(this);
    var thisId = thisSelection.attr('id');
    var storageId = 'remember-selection-' + thisId;
    var storedInfo = localStorage.getItem(storageId);
    if( storedInfo ) {
    	var rememberedOptions = storedInfo.split(',');
        thisSelection.val( rememberedOptions );
        
        alert(thisSelection.val( rememberedOptions ));
    };
    thisSelection.on('change', function(e) {
        var selectedOptions = [];
        thisSelection.find(':selected').each(function(i) {
            var thisOption = $(this);
            selectedOptions.push(thisOption.val());
        });
        localStorage.setItem(storageId, selectedOptions.join(','));
    });
}); // end of fillFreqs() function

// This function changes the onscreen button from Close Net to Net Closed as is appropriate base on the net
// that was selected from the dropdown of previous nets (id = select1)
// And it hides the 'Start a new net' button when a net is selected from the dropdown
// 0 means the net is still open
// 1 means the net is closed
function switchClosed() {
	$(".theBox").addClass("hidden");
	var status = $("#select1").find(":selected").attr("data-net-status");
	
	if ( status == 0 ) { 
		$("#closelog").val("Close Net"); 
	} else {
		$("#closelog").val("Net Closed");
	} 
}

// https://stackoverflow.com/questions/7697936/jquery-show-hide-options-from-one-select-drop-down-when-option-on-other-select
// These two functions control what will be seen in the newnetnm dropdown after the organization is chosen
// The close is after the filterSelectOptions function at about line 533
function filterSelectOptions(selectElement, attributeName, attributeValue) {
	if (selectElement.data("currentFilter") != attributeValue) {
	    selectElement.data("currentFilter", attributeValue);
	    var originalHTML = selectElement.data("originalHTML");
	    if (originalHTML)
	        selectElement.html(originalHTML)
	    else {
	        var clone = selectElement.clone();
	        clone.children("option[selected]").removeAttr("selected");
	        selectElement.data("originalHTML", clone.html());
	    }
	    if (attributeValue) {
	        selectElement.children("option:not([" + attributeName + "='" + attributeValue + "'],:not([" + attributeName + "]))").remove();
		}
}}
		
//$(document).ready(function () {
	$("#netcall").change( function() {
		var selected_org = $("#netcall option:selected").text();
			//alert('selected org= '+selected_org);
			if (selected_org == " Name Your Own ") { //alert("IN NYO");
				
		/*		var newnetorg = prompt("Enter a one word, short group name for this net.", "PCARG");
	    			if (newnetorg === null) {location.reload(); return;}
	    			$("#netcall").append($("<option selected></option>").val("997").html(newnetorg));
	    			
	    		var newnetkind = prompt("Enter a short type of this net.", "Personal");
	    			//if (newnettype === null) {location.reload(); return;}
	    			$("#newnetkind").append($("<option selected></option>").val("998").html(newnetkind));
	    			
	    		var newnetfreq = prompt("Enter a frequency for this net.", "145.520MHz No Tone");
	    			//if (newnettype === null) {location.reload(); return;}
	    			$("#newnetfreq").append($("<option selected></option>").val("998").html(newnetfreq));
	    */
	    	};
	});
//});			

// This controls the refresh rate selection
 $(document).ready(function () {
	var interval = 6000000000;
	var autoRefId = null;
	
	$("#refMenu a").click(function(e){
    	e.preventDefault(); // cancel the link behaviour
			var selText = $(this).text();  
				$("#refrate").text(selText);
				clearInterval(autoRefId);    //https://www.w3schools.com/jsref/met_win_clearinterval.asp

			    interval = $(this).attr('data-sec'); // get the interval in seconds
					if (interval == 'M') {interval = 60000000;}
						interval = interval * 1000;

				autoRefId = setInterval(function() {
	        		// set the automatic refresh for the interval selected above 
	        		//	alert(refreshThisNet);
	        		showActivities($("#idofnet").html().trim());  // this is the netID, number 
	        		//showActivities(document.getElementById("select1").value.trim());
	        	}, interval);		
	});
});
	

/* https://www.tutorialspoint.com/jqueryui/jqueryui_autocomplete */
/* https://api.jqueryui.com/autocomplete/ */
$(document).ready(function () {
	
	//$("#Fname").attr("readonly", true);
	
	$( "#cs1" ).autocomplete({
		autoFocus: true,
		minLength: 2,
		source: "gethint.php",
	/*	focus: function( event, ui ) {
                  $( "#cs1" ).val( ui.item.label );
                     return false;
               }, */
        select: function( event, ui ) {
	        	// This if undes the readonly on the Fname input field below
	        	if ( ui.item.label == 'NONHAM' ) {$('#Fname').prop('readonly', false);}
                  $( "#cs1" ).val( ui.item.label ); 
                  $( "#hints" ).val( ui.item.value );
                  $( "#Fname" ).val( ui.item.desc );
                  	 //return false;
                  	
                 }
	})
	
	.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
               return $( "<li>" )
               .append( "<a>" + item.label + " --->  " + item.desc + "</a>" )
               .appendTo( ul );
            };
});

$(document).ready(function () {
	// if the value of isopen is 1 then the net is still open
	//var isopen = $("#isopen").val(); //alert(isopen);
});

/* Go get the needed stuff to populate the dropdowns to create a new net */
/* https://www.codexworld.com/dynamic-dependent-select-box-using-jquery-ajax-php/ */
//$(document).ready(function () {
	$('#netcall').on('change',function() {
		var callID = $(this).val(); //alert(callID); //31:31:18:RSKC
		if(callID) {
			$.ajax({
				type: 'POST',
				url: 'newnetOPTS.php', 
				data: {call_id: callID},
				success: function(html) {
					$('#newnetkind').html(html);
					//$('#newnetfreq').html('<option value="">Select a net Frequency</option>');
				}
			});
		}else {
			$('#newnetkind').html('<option value="">Select call first</option>');
            $('#newnetfreq').html('<option value="">Select call first</option>');
		}
	});   // End of netcall
	
	// This does the same thing for the frequency at the same time
	$('#netcall').on('change',function() {
		var kindID = $(this).val(); //alert(kindID);
		if(kindID) {
			$.ajax({
				type: 'POST',
				url: 'newnetOPTS.php',
				data: {kind_id: kindID},
				success: function(html) {
					$('#newnetfreq').html(html);
				}
			});
		}
	});  // End of newnetkind
	
	// This does the same thing for the frequency if the kind changed
	$('#newnetkind').on('change',function() {
		var kindID = $(this).val();  //alert(kindID);
		if(kindID) {
			$.ajax({
				type: 'POST',
				url: 'newnetOPTS.php',
				data: {kind_id: kindID},
				success: function(html) {
					$('#newnetfreq').html(html);
				}
			});
		}
	});  // End of newnetkind
//});

// All Below Copied from index.php on 2019-01-09

//$(document).ready(function() {
	$( ".netGroup" ).change(function() {
		var newnetnm = $('.netGroup option:selected').val(); 
			if (newnetnm == 7 ) {    
				//alert(" @ 67 "+newnetnm); should be a 7
				window.open("BuildNewGroup.php");	
			};
			if (newnetnm == '29:23:29:EVENT' ){
				$(".last3qs").addClass("hidden");
			}
	});
	
	// This detects the click of the 'Copy a Pre-Built' button when building a new Pre-Built
	$( "#copyPB").click(function() {
		var netID = $("#idofnet").text().trim();
	//	var oldPB = prompt("Enter the log No. to clone.");
		var newKind = $("#activity").text().trim();
		
		$.ajax({
			type: 	'POST',
			url:	'PBList.php',
			data:	{newPB:netID}
		})
		.done(function(html) {  // .done is kind of line success: with more options
				$('#pbl').html(html);  // put output of ajax in the ID=pbl
				$('#pbl').modal();	   // display the modal made from pbl
				$('#pbl').removeClass('hidden');   // unhide the modal
				$('#copyPB').addClass('hidden');   // hide the button copyPB
			}
		);
	}); // End of click function for copyPB
	

	$('#columnPicker').mousedown(function(event) {
		switch (event.which) {
			case 1:
				//alert('Left');
				openColumnPopup();
				break;
			case 2:
				//alert('Middle');
				break;
			case 3:
				//alert('Right');
				openColumnPopup();
				break;
			default:
				alert('You have a strange Mouse!');
		}
	});
	
//}); // End of ready function



// This function runs clonePB.php to clone oldPB into newPB, its called the selectCloneBTN button in PBList.php
function fillaclone() {
		var netcalltoclone 	= $('#netcalltoclone option:selected').text();
		var netIDtoclone	= $('#netcalltoclone option:selected').val();
		var netID = $("#idofnet").text().trim();
	//	var oldPB = prompt("Enter the log No. to clone.");
		var newKind = $("#activity").text().trim();
	//	alert('stand alone= '+netcalltoclone+' val= '+netIDtoclone);
			$.ajax({
				type: 'POST',
				url: 'clonePB.php',
				data: {oldPB:netIDtoclone, newPB:netID, newKind:newKind},
				success: function() {	
		//			alert("Out: Clone "+netIDtoclone+" into "+netID+" for "+newKind);
					refresh();
				} // end success
			}); // End of ajax
} // End of fillaclone() function

// This function is used to set the Pre-Built column in NetLog, and to display the cloning button on the main page.
function doalert(checkboxElem) {
  if (checkboxElem.checked) {
	//var txt;
	var r = confirm("Click OK to confirm you want to create a Pre-Built Net. Cancel will take you back to the usual menu.")
		if (r == true) {
			//alert ("you preseed OK");
			//var oldPB = prompt("Enter the log No. to clone.");
		} else {
			//alert ("you pressed cancel");
			$('#pb').prop('checked', false); // Unchecks it
			$('.last3qs').removeClass('hidden');
			$('.radio-inline').addClass('hidden');  // hides the Click to create a pre-build event. I do this only
													// on the selection of 'cancel' from the alert box asking for
													// confirmation of the pre-built idea. My thinking is its not needed now.
		}
}}


// Below takes the place of openPreamble() in the NetManager.js
	//var windowObjectReference;
	var strWindowFeatures = "resizable=yes,scrollbars=yes,status=no,left=20px,top=20px,height=800px,width=600px";
		
function openPreamblePopup() {
	//var thisdomain = getDomain(); // alert("domain in openPreamble= "+thisdomain); //KCNARES  Weekly 2 Meter Voice Net
	  // domain in openPreamble= Johnson County ARES  Weekly 2 Meter Voice Net
	var thisdomain = $('#domain').html().trim();
	var popupWindow = window.open("", "Preamble",  strWindowFeatures);
	
	//alert("thisdomain= "+thisdomain);
	
	$.ajax({
		type: 'GET',
		url: 'buildPreambleListing.php',
		data: {domain: thisdomain},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
}
function openEventPopup() {
	//var thisdomain = getDomain();  //alert("domain in openPreamble= "+thisdomain); //KCNARES  Weekly 2 Meter Voice Net
	var thisdomain = $('#domain').html().trim();
	var popupWindow = window.open("", "Events",  strWindowFeatures);
	
	$.ajax({
		type: 'GET',
		url: 'buildEventListing.php',
		data: {domain: thisdomain},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
}
function openClosingPopup() {
	//var thisdomain = getDomain();  //alert("domain in openPreamble= "+thisdomain); //KCNARES  Weekly 2 Meter Voice Net
	var thisdomain = $('#domain').html().trim();
	var popupWindow = window.open("", "Closing",  strWindowFeatures);
	
	//alert("thisdomain= "+thisdomain);
	//thisdomain= Kansas City National Weather Service Weekly 40 Meter Voice Net
	
	$.ajax({
		type: 'GET',
		url: 'buildClosingListing.php',
		data: {domain: thisdomain},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
}

// Build an APRStt config file from the current net
function buildDWtt() {
	var netID = $("#idofnet").text().trim();
	var popupWindow = window.open("buildDWtt.php?q="+netID, "APRStt",  strWindowFeatures);
}

function openColumnPopup() {
	var netcall = $("#domain").html().trim();
	var popupWindow = window.open("columnPicker.php?netcall="+netcall, "Columns",  strWindowFeatures);
}

function seecopyPB() {
	$("#copyPB").removeClass("hidden");
}

/*
function buildRightCorner() {
	//var thisdomain = getDomain(); //alert(thisdomain);  // KCNARES  Digital Training Net
	var thisdomain = $("#domain").text().trim(); alert("@626 in -p2.js= "+thisdomain);  // @626 in -p2.js= CREW2273
	var thisactivity = $("#activity").text().trim(); alert("@627 in -p2.js= "+thisactivity);  // @627 in -p2.js= CREW 2273  Weekly 2 Meter Voice Net
	myWindow = window.open("buildRightCorner.php?domain="+thisdomain+"&act="+thisactivity);
}
*/

//$(document).ready(function () {
  $("#bar-menu").click(function(e){
	  $("#bardropdown").removeClass('hidden');
  });
  
  // Which option was selected?
  $("select.bardropdown").change(function() {
	  var selectedOption = $(this).children("option:selected").val();
	  	//alert(selectedOption);
	  	if (selectedOption == 'EditCorner') {alert("Opton comming soon") /*buildRightCorner();*/ }
	  	if (selectedOption == 'CreateGroup') {window.open("BuildNewGroup.php"); /*buildRightCorner();*/}
	  	if (selectedOption == 'SelectView') {alert("Opton comming soon")}
	  	if (selectedOption == 'HeardList') {heardlist();}
	  	if (selectedOption == 'APRStt') {buildDWtt();}
	  	if (selectedOption == 'DisplayHelp') {window.open("help.php");}

	  // hides the dropdown again	
	  $("#bardropdown").addClass('hidden');
	  $('select').prop('selectedIndex', 0);   // resets the select/options to 'Select One' the first option
  })
//})  // End ready function

function heardlist() {
	var netID 	= $("#idofnet").html().trim();
	var popupWindow = window.open("", "_blank",  strWindowFeatures);
	//var popupWindow = window.open("columnPicker.php?netcall="+netcall, "Columns",  strWindowFeatures);
	//alert("coming soon "+netID);
	
	$.ajax({
		type: 'POST',
		url: 'buildHeardList.php',
		data: {q: netID},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
	
}

function sendEMAIL(adr,netid) {
    var link = "mailto:"+adr+"?subject=NCM Net# "+netid;
        window.location.href = link;
}
function sendGroupEMAIL() {
    var netID = $("#idofnet").text().trim();
        if(netID) {
            $.ajax({
                type: "GET",
                url: "getNetEmails.php",
                data: {netID: netID},
                success: function(response) {
                    sendEMAIL(response,netID);
                }
            });
        }
}
