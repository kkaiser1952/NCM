/* All of this NetManager-p2 (part 2) file was copied from the top of the index.php and moved here on 2018-1-15 */

// This function is used by the latitude & longitude columns from rowDefinitions.php
//function getCrossRoads(lat,lng) {

    //var in = eval('http://www.findu.com/cgi-bin/posit.cgi?call='+aprscall+'&comma=1&time=1&start=24');
    
//} // end getCrossRoads()

// this MIGHT be used to more easily enter W3W values correctly
// currently not being used...
parms = Array();
function getW3W(parms) {
    
    console.log('now in getW3W function');
    const objName = prompt('Enter a W3W address & optional object \n ex: clip.apples.leap green car'); 
    parms = parms.split(',');   
    const recordID = parms[0];
    const netID = $("#idofnet").text().trim();
    
   $("#w3w:"+recordID).text(objName);
    
    console.log('@21 netID '+netID+' recordID= '+recordID+' objName= '+objName);       
}

// Function to reset the dialog box values
  function resetDialogBox() {
    $("input[name='option']").prop("checked", false); // Uncheck all radio buttons
    $("#comment").val(""); // Clear the comment textarea
  }


// This function is used by the aprs_call column from rowDefinitions.php 
// It is processed in the locations_APRS.php program
function getAPRSLocations(parmsString) {
  console.log("parmsString: " + parmsString + " length: " + parmsString.length);
  // parmsString here is:  132082, 39.2028965,-94.602876,WA0TJT,9071 length: 43

  // Function to reset the dialog box values
  function resetDialogBox() {
    $("input[name='option']").prop("checked", false); // Uncheck all radio buttons
    $("#comment").val(""); // Clear the comment textarea
  }

  // Function to create the dialog box
  // In order for the routine to NOT duplicate some of the variable values (objName, lat, lng) we
  // had to create this dialog box code as a seperate function, where before it was built into 
  // thie getAPRSLocations function.
  function createDialogBox() {
    // Create a dialog box with radio buttons and a comment text area
    const dialogBox = $("<div>")
      .attr("id", "APRSDialog")
      .append($("<h3>").text("Choose an option:"))
      .append(
        $("<input>")
          .attr("type", "radio")
          .attr("id", "option1")
          .attr("name", "option")
          .attr("value", "option1")
          
      ) // Set default
      .append($("<label>").attr("for", "option1").text("Comment "))
      .append($("<br>"))
      .append(
        $("<input>")
          .attr("type", "radio")
          .attr("id", "option2")
          .attr("name", "option")
          .attr("value", "option2")
          .prop("checked", true)
      )
      .append($("<label>").attr("for", "option2").text("Object "))
      .append($("<br>"))
      .append($("<h3>").text("Enter a comment:"))
      .append(
        $("<textarea>")
          .attr("id", "comment")
          .attr("rows", "4")
          .attr("cols", "50")
      );

    return dialogBox;
  }

  // Show the dialog box
  const showDialogBox = () => {
    // Recreate the dialog box each time it is opened
    const dialogBox = createDialogBox();

  dialogBox.dialog({
    modal: true,
    buttons: {
      OK: function() {
        // Retrieve the selected option and comment
        const option = $("input[name='option']:checked").val();
        const comment = $("#comment").val();

        console.log(option + " after const comment " + comment);

        // Create a new Date object
        var currentTime = new Date();
        
        // Get the current hour and pad it with leading zero if necessary
        var hours = currentTime.getHours().toString().padStart(2, '0');
        
        // Get the current minute and pad it with leading zero if necessary
        var minutes = currentTime.getMinutes().toString().padStart(2, '0');
        
        // Create the timestamp string
        var timestamp = hours + '' + minutes;
        
        console.log(timestamp); // Output: 09:50


        const parms = parmsString.trim().split(',');
        for (let i = 0; i < parms.length; i++) {
          // list all the parms
          console.log(`parms[${i}] = ${parms[i]}`);
        }

        let aprs_call = parms[0].toUpperCase();
        console.log("aprs_call= " + aprs_call);
        
         // Concatenate the comment with the option prefix
        let objName = "";
        if (option === "option1") {
          objName = "COM::" + timestamp+' '+aprs_call+' : '+comment;
        } else if (option === "option2") {
          objName = "OBJ::" + timestamp+' '+aprs_call+' : '+comment;
        }
        
         
        console.log('option= ' + option + ' comment= ' + comment + ' objName= ' + objName);


        let recordID = parms[1];
        let CurrentLat = parms[2];
        let CurrentLng = parms[3];

        let cs1 = parms[4];
        let nid = parms[5];

        console.log("above ajax " + objName);

        $.ajax({
          type: 'GET',
          url: 'locations_APRS.php',
          data: {
            aprs_call: parms[0],
            recordID: parms[1],
            CurrentLat: parms[2], 
            CurrentLng:parms[3], 
            cs1:parms[4], 
            nid:parms[5], 
            objName:objName 
          },
        success: function(response) {
            //var resp = JSON.stringify(response);
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error in getAPRSLocations ajax: " + errorThrown);
        }       
        },
    );
    
             $(this).dialog("close");
    },
    Cancel: function() {
      // Close the dialog box
      $(this).dialog("close");
    }, // end Cancel function
  }, // end Buttons
  close: function() {
    // Reset the dialog box values
    $(this).dialog("destroy").remove();
  },
});
};
showDialogBox();
} // end of getAPRSLocations function

// Note: The closing `</div>` in the dialogBox is not explicitly included in the code snippet because it is automatically added by the jQuery `.dialog()` function when creating the dialog box.


// ======================================================================================
// End of Contribution by Louis Gamor programer of extrodinary talents from Ghana, Africa
// ======================================================================================

function doubleClickComments(rID, cs1, netID) {
    console.log("@136 You did it");
}

// This function will run doubleClickCall.php, it has two jobs, one is to update the stations table
// with the information about this DX call and two is to update the NetLog table at the appropriate
// recordID with pretty much the same information. 
// Two birds with one stone kind of thing.
function doubleClickCall(rID, cs1, netID) {
   var rID = rID;
   var cs1 = cs1;
   var netID = netID;
   // var str = rID+','+ cs1;
   // alert('In the doubleClickCall function \n recordID:'+rID+',  cs1:'+cs1);
     //var fst = cs1.charAt(0);
   
   if ( cs1.charAt(0) == 'A' || cs1.charAt(0) == 'N' || cs1.charAt(0) == 'K' || cs1.charAt(0) == 'W' ) 
        { alert("DX calls only on double click"); }
        else {
            $.ajax({
        		type: 'GET',
        		url: 'getDXstationInfo.php',
        		data: { rID:rID, cs1:cs1, netID:netID},
        		success: function(response) {
            		alert('The records have been updated for DX station '+cs1);				
        		} // end response
        	}); // end ajax writing of table
        }
}

function whoAreYou() {
    var WRU = prompt("Your Call?");
}

function openW3W() {
    window.open("https://what3words.com");
}

function showDTTM() {
	if (!document.all&&!document.getElementById)
		return
		thelement=document.getElementById? document.getElementById("dttm2"): document.all.dttm2
		
        var mydate  = new Date();
		var lcldate = Math.floor(Date.now() / 1000); 
		    lcldate = Date(lcldate * 1000);
		    lcldate = lcldate.substring(0, lcldate.length-15); // removes the GMG offset on the end
        var utcdate = mydate.toUTCString();   
            utcdate = utcdate.substring(0, utcdate.length-3);  // removes the GMT from the end

        thelement.innerHTML='Local: '+lcldate+'<br><span style="color:red; ">UTC: '+utcdate+'</span>'; 
}

$(document).ready(function() {
	setInterval('showDTTM()', 1000);
	
	$( ".editable_selectACT" ).change(function() {
		alert( "you changed ACT" );
	});
});


function newNet(str) {   
    // All callsigns require at least one number 
    // The callsign div must have a value
    var firstDigit = $( '#callsign' ).val().match(/\d/); //alert(firstDigit);
    if (!$( '#callsign' ).val() || firstDigit == null ) {
        var usedCS = prompt("What is your FCC call sign?");
           if (!$( '#callsign' ).val() || firstDigit == null ) {
                location.reload(); 
           } else { $("#callsign").val(usedCS.trim()); }
    } else { // the end is at the end of the newNet() function ... way below
       
	$(".newstuff").addClass("hidden");
	$(".theBox").addClass("hidden"); 
	$("#refbutton").removeClass("hidden");
	$("#makeNewNet").addClass("hidden");
	$("#form-group-1").show();
	$("#timer").removeClass("hidden");
	
	var newnetnm = $("#GroupInput").val().trim(); //alert('newnetnm= '+newnetnm); // newnetnm= W0KCN
	    console.log("@216 newnetnm in NetManager-p2.js "+newnetnm);
	
	var netcall  = $("#GroupInput").val().trim(); // this should be org
	//var netview  = $("#GroupInput").val().trim();
	    console.log("@219 netcall in NetManager-p2.js "+netcall);

    var newnetfreq = $("#FreqInput").val();
        if (newnetfreq == '' ) {newnetfreq = '144.520MHz'; }
    
	var newnetkind = $("#KindInput").val();    //alert('newnetkind= '+newnetkind); // newnetkind= MARS Traffic Net
	
	var callsign = $("#callsign").val().trim().toUpperCase(); 
	    // Test to not allow empty group call or kind of net information 
    	if (netcall == '' ) {
        	var netcall = prompt("What should I use as a the net call? ex: NARES ");
        	    if (netcall == '' ) { netcall = callsign; }
    	}
    	if ( newnetkind == '' ) {
        	var newnetkind = prompt("What should I use as a group name or call? ex: North ARES");
        	    if ( newnetkind == '' ) { newnetkind = callsign; }	
    	}
		
	    if (callsign == 'TEST' ) {var callsign = prompt('Please enter your FCC call sign', );}
	    //alert(callsign); // WA0TJT 
	
	    if ( newnetkind.includes("MARS" )) {  // Currently not in use but i didn't want to comment it out for testing
    	    setCookie('custom', '50, 51', 5);
    	    custom_setup(); //hides Fname, shows custom and section
    	    $('#custom').prop('type','text');
            $('#custom').removeClass("hidden");
            $('#custom').attr('placeholder', 'Comment');
	    }
	var org = $("#org").html();  
	   // alert(org);
	
	// was building a pre-built requested
    var pb = 0;
		if ( $("#pb").is(':checked')) {var pb = 1}
    //alert('pb= '+pb); //pb= 0
    
    var testnet = 'n';
        if ( $("#testnet").is(':checked')) {var testnet = 'y'}

       // alert('testnet: '+testnet);
     
    var satNet = $("#satNet").val();
    var testEmail = $("#testEmail").html();
    // Switched to using simi-colon (;) instead of colon (:) on 2019-10-23, both here and in newNet.php @ $parts
	var str = callsign+":"+netcall+":"+org+":"+newnetfreq+":"+satNet+":"+newnetkind+":"+pb+":"+testEmail+":"+testnet;
	//alert(str);
	// WA0TJT:TE0ST:For Testing Only:444.550Mhz(+) PL100.0Hz:0:Test:0::y
	// W0GPS;W0KCN;KCNARES;146.790MHz, PL107.2Hz;0;Weekly 2 Meter Voice;0;;y
	
	
	
	// Build the upper right corner
	$("#upperRightCorner").load("buildUpperRightCorner.php?call="+newnetnm); // was netcall
    $("#urc").load("buildUpperRightCorner.php?call="+newnetnm);  // was netcall	    
    
    $.ajax({
		type: 'POST',
		url: 'newNet.php',
		data: {q: str},
		success: function(response) {
			var newnetID = response.trim(); 		//alert(newnetID);
  			  showActivities(response);
  			
  			var strBlank  = " ";
  			var activity  = org.trim().concat(strBlank,newnetkind.trim());
  			     
  			var newoption = '<option class="green" value="'+netcall+'" selected>'+netcall+' Net #: '+ newnetID +' --> '+ activity +' for '+new Date()+'</option>';
              
                // insertAfter puts the newest net built in the dropdown and displays it
  				$(newoption).insertAfter("option.newAfterHere");
  				$("#select1").selectpicker("refresh");
  				
  				hideCloseButton(pb);
  				//apprently making the hidding of the close net button with a function (below) and putting
  				// the call to it here causes enough delay to make it work
			
		} // end response
	}); // end ajax writing of table
/*	
	$.ajax({
    	type: 'POST',
    	url:  'view4hints.php',
    	data: {q: netcall},
    	success: function(response) {console.log('view created')}
	}
*/
}}

function hideCloseButton(pb) {
    //alert('pb '+pb);
    console.log("@298 in hidCloseButton function "+pb);
    if (pb == 1) {$("#closelog").addClass("hidden");}
}  


// https://www.itsolutionstuff.com/post/simple-php-ajax-form-validation-example-from-scratchexample.html 

var binaryops = 0;
function checkIn() {
    // Dont allow new entries if net is closed.
    var testCloseStatus = $(".closenet").html(); //alert(testCloseStatus);
        if (testCloseStatus == 'Net Closed') {
            alert("Net is Closed, please open again before adding more records by right clicking on 'Net Closed' \n Or better yet, start a new net.");
                return;
        }
    
    var mBands      = 0; // Multiple Bands indicator
	var numbers 	= /^[0-9]+$/;
 // alert("in checkin function");
    // Is this a Multiple Bands net?
    var bands   = $("#add2pgtitle").html();        
    // alert(bands); 
    // #1255/TE0ST/146.570MHz, Simplex&nbsp;&nbsp;<span style="background-color: #befdfc">Control</span>&nbsp;&nbsp;
        if ((bands.indexOf("Multiple Bands") > 0) || (bands.indexOf("80/40 Meters") > 0)) {mBands = 1;}
         //  alert("bands= "+bands+" mBands= "+mBands);
            
	var id 		= $("#hideme").val();  

    var netID = $("#idofnet").text().trim();
  	
	var cs1   	= $("#cs1").val().toUpperCase().trim(); //alert("cs1: "+cs1);
	var fdcat   = $("#custom").val().toUpperCase().trim(); // Custom Category
	var fdsec   = $("#section").val().toUpperCase().trim(); // Custom Section
	   //alert(" fdcat: "+fdcat);
	var Fname	= $("#Fname").val();
	
	// TrfkSwitch is the short cut to enter a traffic type while checing in this station 
	//var TSvalue = '';
	var TrfkSwitch = $("#TrfkSwitch").val();    //alert(TrfkSwitch);
	var posValues = "TRWPEQACtrwpeqac ";   // valid values for the traffic short cut field
	        if (posValues.includes( TrfkSwitch ) ) {
    	        var TSvalue = TrfkSwitch.toUpperCase(); 
    	    }else { var TSvalue = ""; } 
	    
	var ispb	= $("#ispb").html(); //alert("ispb= "+ispb);
	//var therest = $pbspot;
	
	var netcall	= $("#domain").html().replace(/\s+/g, '').toUpperCase(); //added: 2016-12-08
	var mode		= $("#dfltmode").val();  //alert("mode= "+mode);	
//	var cs1 		= cs1.toUpperCase();

    // All callsigns require at least one number except these
    var goodcalls = ["NONHAM","HCALPHA","HCBRAVO","HCCHARLIE","HCDELTA","HCECHO","HCFOXTROT","HCGOLF","HCHOTEL","HCINDIA","HCJULIETT","HCKILO","HCLIMA","HCMIKE","HCNOVEMBER","HCOSCAR","HCPAPA","HCQUEBEC","HCROMEO","HCSIERRA","HCTANGO","HCUNIFORM","HCVICTOR","HCWHISKEY","HCX-RAY","YANKEE","HCZULU","NETCONTROL", "EMCOMM"];	  
  	  
  /* The next few lines test the validity of the callsign cs1 and exits if not good */
  	//if (cs1.trim() == "NONHAM") {
    if (cs1.trim() in(goodcalls) ) {
      // This is an allowed entry... so no problems
  	} else {   // anything else needs to be processed
      firstDigit = cs1.match(/\d/);
	  
	  
	 // if (firstDigit == null && cs1.trim() != "NONHAM" ) {
      if (firstDigit == null && goodcalls.indexOf(cs1.trim()) < 0 ) {
    	
		  var cs1 = prompt(cs1+" is an invalid callsign! \n Callsigns worldwide requie at least one number. \n Please enter a correct callsign, or the appropriate word ex. 'NONHAM', 'EMCOMM' for non amateur participants.");
		  
			  if (cs1 === "" || (cs1.match(/\d/) == null)) {
			  	return;
			  } 
	  } // End if @355
  	} // End else @357
  	
  //	alert(TSvalue);

	var str =     id+":"+netID+":"+cs1+":"+Fname+":"+ispb+":"+binaryops+":"+netcall.toUpperCase()+":"+mBands+":"+fdcat+":"+fdsec+":"+TSvalue; 
	//alert("str= "+str); // str= undefined:1679:N0RL:David:undefined:0:TE0ST:1
  
	// Decloratoin for these variables       
	id = netId = cs1 = Fname = therest = {};
  
	// Adjust these fields after the new str is created
  	document.getElementById("cs1").value = "";
	document.getElementById("Fname").value = "";
	document.getElementById("custom").value = "";
	document.getElementById("section").value = "";
	  
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
    		     setTimeout( () => {
    			    sorttable.makeSortable(document.getElementById("thisNet"));
        			    // This gives me the ability to edit each cell
        			     $( document ).ready( CellEditFunction );
    			  }, 100); //end setTimeout function 
		} // end success response
	  }); // end ajax reading of table
    
 	$('#cs1').focus();
} // End of checkin function


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
        
     //   alert(thisSelection.val( rememberedOptions ));
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

// This function changes the onscreen button from Close Net to Net Closed as is appropriate based on the net
// that was selected from the dropdown of previous nets (id = select1)
// And it hides the 'Start a new net' button when a net is selected from the dropdown
// 0 means the net is still open
// 1 means the net is closed
function switchClosed() {
	$(".theBox").addClass("hidden");
	var status = $("#select1").find(":selected").attr("data-net-status");
	
	    console.log("@482 status = "+status);
	    
	if ( status == 0 ) { 
		$("#closelog").html("Close Net"); 
	} else {
		$("#closelog").html("Net Closed");
	} 
	
	   var ispb = $("#ispb").html();    // Is this a pre-built? 1=yes, 0=no
       var pbStat = $("#pbStat").html();    // may not be working correctly
       var isopen = $("#isopen").html();    // Is this open? 1=yes, 0=no
       
	    console.log("@494 status = "+status+" ispb = "+ispb+" pbStat= "+pbStat+" isopen= "+isopen);
       
    // Test if its a new PB being built, if so hide the 'close net' button
   // if ( $("#isopen").html() != "undefined") 
     //   { hideCloseButton(1); }
      
} // End of switchClosed function

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
				
	    	};
	});   
    
    var nc = $("#thenetcallsign").text();
        console.log('@575 nc= '+nc);        
    
        $("#cs1").autocomplete({
            autoFocus: true,
            minLength: 3,
            source: "gethintSuspects.php",
            extraParams: {
              nc: nc
            },
            select: function(event, ui) {
              // This is under the readonly on the Fname input field below
              if (ui.item.label == 'NONHAM') {
                $('#Fname').prop('readonly', false);
              }
              $("#cs1").val(ui.item.label);
              $("#hints").val(ui.item.value);
              $("#Fname").val(ui.item.desc);
              var nc = $("#thenetcallsign").html();
              //return false;
            }
          }) // end autocomplete
          
          .data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
              .append("<a>" + item.label + " --->  " + item.desc + "</a>")
              .appendTo(ul);
          };
        
        
                   
//});

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
				//alert(" @ 441 "+newnetnm); //should be a 7
				window.open('BuildNewGroup.php');	
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
		var oldCall = $(".cs1").text();
		console.log('@663 stand alone= '+netcalltoclone+' val= '+netIDtoclone+' oldCall= '+oldCall);
			$.ajax({
				type: 'POST',
				url: 'clonePB.php',
				data: {oldPB:netIDtoclone, newPB:netID, newKind:newKind, oldCall:oldCall},
				success: function() {	
		//			alert("Out: Clone "+netIDtoclone+" into "+netID+" for "+newKind);
					//refresh();
					
				} // end success
			}); // End of ajax
			showActivities(netID);
} // End of fillaclone() function

// This function is used to set the Pre-Built column in NetLog, and to display the cloning button on the main page.
function doalert(checkboxElem) {
  if (checkboxElem.checked) {
	//var txt;
	var r = confirm("Click OK to confirm you want to create a Pre-Built Net.")
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
   // alert("in the openPreamblePopup js");
	//var thisdomain = getDomain(); // alert("domain in openPreamble= "+thisdomain); //KCNARES  Weekly 2 Meter Voice Net
	  // domain in openPreamble= Johnson County ARES  Weekly 2 Meter Voice Net
    //var netid = $("#select1").val(); alert(netid);
	var thisdomain = $('#domain').html().trim();  //alert(thisdomain);
	var thisactivity = $('#activity').html().trim();
	//alert(thisactivity);
	var popupWindow = window.open("", "Preamble",  strWindowFeatures);
	
	$.ajax({
		type: 'GET',
		url: 'buildPreambleListing.php',
		data: {domain: thisdomain, activity: thisactivity},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
}
function openEventPopup() {
	//var thisdomain = getDomain();  //alert("domain in openPreamble= "+thisdomain); //KCNARES  Weekly 2 Meter Voice Net
	var thisdomain = $('#domain').html().trim();   // alert(thisdomain);
	var popupWindow = window.open("", "Events",  strWindowFeatures);
	    console.log('@616 NM-p2.js thisdomain= '+thisdomain);
	
	//alert(thisdomain);
	
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

//$(document).ready(function () {
  $("#bar-menu").click(function(e){
	  $("#bardropdown").removeClass('hidden');
  });
  
  // Which option was selected?
  $("select.bardropdown").change(function() {
	  var selectedOption = $(this).children("option:selected").val();
	  	//alert(selectedOption);
	  	if (selectedOption == 'EditCorner') {alert("Opton comming soon");}
	  	if (selectedOption == 'CreateGroup') {window.open("https://net-control.us/BuildNewGroup.php");}
	  	if (selectedOption == 'convertToPB') {convertToPB();}
	  	if (selectedOption == 'SelectView') {alert("Opton comming soon");}
	  	if (selectedOption == 'HeardList') {heardlist();}
	  	if (selectedOption == 'FSQList') {buildFSQHeardList();}
	  	if (selectedOption == 'APRStt') {buildDWtt();}
	  	if (selectedOption == 'findCall') {CallHistoryForWho();}
	  	if (selectedOption == 'DisplayHelp') {window.open("help.php");}
	  	if (selectedOption == 'allCalls') {window.open("https://net-control.us/buildUniqueCallList.php");}
	  	if (selectedOption == 'DisplayKCARES') {window.open("http://www.kcnorthares.org/policys-procedures/");}
	  	if (selectedOption == 'DisplayARES') {window.open("http://www.arrl.org/files/file/ARESFieldResourcesManual.pdf");}
	  	if (selectedOption == 'ARESManual') {window.open("http://www.arrl.org/files/file/Public%20Service/ARES/ARESmanual2015.pdf");}
	  	if (selectedOption == 'ARESELetter') {window.open("http://www.arrl.org/ares-el");}
	  	if (selectedOption == 'ARESTaskBook') {window.open("http://www.arrl.org/files/file/Public%20Service/ARES/ARRL-ARES-FILLABLE-TRAINING-TASK-BOOK-V2_1_1.pdf");}
	  	if (selectedOption == 'ARESPlan') {window.open("http://www.arrl.org/ares-plan");}
	  	if (selectedOption == 'ARESGroup') {window.open("http://www.arrl.org/ares-group-id-request-form");}
	  	if (selectedOption == 'ARESEComm') {window.open("http://www.arrl.org/emergency-communications-training");}
	  	

	  // hides the dropdown again	
	  $("#bardropdown").addClass('hidden');
	  $('select').prop('selectedIndex', 0);   // resets the select/options to 'Select One' the first option
  })
//})  // End ready function

function convertToPB() {	
    if ( typeof netID === 'undefined' || netID === null ) {
        var netID = prompt("Enter a Net Number to convert.");  //alert(netID);
    
        if (netID == "") {
            alert("Sorry no net number was given"); return; }
    }
    
    var popupWindow = window.open("", "_blank",  smallWindowFeatures);
	
	$.ajax({
		type: 'POST',
		url: 'convertToPB.php',
		data: {q: netID.trim()},
		success: function(resp) {	
            var diditwork = '<span style="color:blue"><h2>SUCCESS:<br>Net No. '+netID+'<br> Has successfully been converted to a Pre-Build net.</h2></span>';
            popupWindow.document.write(diditwork);
		} // end success
	});
}

function heardlist() {
	var netID 	= $("#idofnet").html();
	
	    if ( typeof netID === 'undefined' || netID === null ) {
    	    var netID = prompt("Enter a Net Number sign");  //alert(netID);
		
            if (netID =="") {alert("Sorry no net number was selected"); return;}
	    }

	var popupWindow = window.open("", "_blank",  strWindowFeatures);
	
	$.ajax({
		type: 'POST',
		url: 'buildHeardList.php',
		data: {q: netID.trim()},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
}

function buildFSQHeardList() {
    var netID 	= $("#idofnet").html();
        if ( typeof netID === 'undefined' || netID === null ) {
    	    var netID = prompt("Enter a Net Number sign");  //alert(netID);
		
            if (netID =="") {alert("Sorry no net number was selected"); return;}
	    }
	    
    var popupWindow = window.open("", "_blank",  strWindowFeatures);
    
    $.ajax({
		type: 'POST',
		url: 'buildFSQHeardList.php',
		data: {q: netID.trim()},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
    
}


function buildCallHistoryByNetCall() {
    //var netcall 	= $("#idofnet").html();
    var netcall = '';
    var numofmo = 0;
        if ( typeof netcall === 'undefined' || netcall === null || netcall == '' ) {
    	    var netcall = prompt("Enter a Net call sign i.e. MODES, MESN, KCNARES");  //alert(netcall);
    	    var numofmo = prompt("How many months back? i.e. 3, 5, 12");
		
            if (netcall =="") {alert("Sorry no net was selected"); return;}
	    }
	    
    var popupWindow = window.open("", "_blank",  strWindowFeatures);
    
    var runurl = 'getCallsHistoryByNetCall.php'; // default
        if (netcall == 'KCHEART' | netcall == 'kcheart') {runurl = 'getCallsHistoryByNetCall-FACILITY.php';} // KCHEART, etc.
        
        //alert(runurl);
    
    $.ajax({
		type: 'POST',
		url: runurl,
		data: {netcall: netcall.trim(), nomo: numofmo},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
    
}

//const netID = $("#idofnet").text().trim();
function geoDistance() {
    if ( $('#idofnet').length ) {
		var netID	 = $("#idofnet").html().trim();
	} else {
		var netID = prompt("Enter a Log number.");
	}
        	    
    //var popupWindow = window.open("", "_blank",  strWindowFeatures);
    
    window.open("geoDistance.php?NetID="+netID,"_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
    //var runurl = 'geoDistance.php'; // default
    
/*    $.ajax({
		type: 'GET',
		url: 'geoDistance.php',
		data: {q: netID},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
	*/
}

// ===================================== put here from index.php at the bottom ------------------------------

// This is the setup for the popup windows
var strWindowFeatures = "resizable=yes,scrollbars=yes,status=no,left=20px,top=20px,height=800px,width=600px";
var smallWindowFeatures = "resizable=yes,scrollbars=yes,status=no,left=20px,top=20px,height=400px,width=600px";
// Put test scripts here
// All the script files here were copied to NetManager-p2.js on 2019-01-09
function buildRightCorner() {
	//var thisdomain = getDomain(); //alert(thisdomain);  // KCNARES  Digital Training Net
	var thisdomain = $("#domain").text().trim(); //alert("@626 in -p2.js= "+thisdomain);  // @626 in -p2.js= CREW2273
	var thisactivity = $("#activity").text().trim(); 
	//alert("@146 in index.php thisactivity= "+thisactivity);  // @627 in -p2.js= CREW 2273  Weekly 2 Meter Voice Net
	myWindow = window.open("buildRightCorner.php?domain="+thisdomain+"&act="+thisactivity);
}


// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
};

// Hide the initial 'Hide Timeline' button
$("#timelinehide").hide();
$("#timelinesearch").hide();
$(".timelineBut3").hide();


// 2018-08-16 This script is used to show the subnets of any given net. It also shows the parent
// of any given net and can even show the parent and child of a net if it has one. Its been tested
// on up to 3 nets. I'm not sure what happens after that.
	$(document).on('click', '.subnetkey', function(event) {
    	
    	$(".timelineBut2").addClass("hidden");
    	
    	
		$("#subNets").html("");				  // Clears any previous entries
		var strr   = $(".subnetkey").val();   // The string of net numbers like 789, 790
		var netnos = strr.split(",");         // The string made into an array of nets
		
		$("#subNets").removeClass("hidden");  // Remove the hidden from the subNets div
		
			netnos.forEach(nets => {				// Loop through the list, usually only one 
				$.ajax({
				  	type: 	 "GET",
				  	url:	 "getactivities.php",
				  	data:	 {q : nets},
				  	success: function(response) {
					  	var thelist = "#"+nets+"<br>"+response+"<br><br>";
					  	$("#subNets").append(thelist);
				  	},
				  	error:	 function() {
					  	alert('Sorry no nets.');
				  	}
			  	}); // End of ajax
			}); // End netnos.forEach
	}); // End on(click
	
function Clear_All_Tactical() {
    if (confirm("This process sets all Tactical Calls to blank.\r\n Are you sure this is what you want to do?\r\nIt can not be undone.")) {
        // if Yes
        var netID = $("#idofnet").text().trim(); 
        alert('apprently yes for net: '+netID);
            $.ajax({
        		type: 'GET',
        		url: 'Clear_All_Tactical.php',
        		data: {q: netID},
        		success: function(response) {		
          			//showActivities(netID);
          		}
            });
    } else {
        // if cancel
        alert('apprently no');
    }
}
	

// BELOW IS THE FILTERFUNCTION, PUTINGROUPINPUT FUNCTIONS
function filterFunction(x) { 
  var input, filter, ul, li, a, i;
    if (x == 0 ) {
        input = document.getElementById("GroupInput");
    }else if (x == 1 ) {
        input = document.getElementById("KindInput");
    }else if (x == 2 ) {
        input = document.getElementById("FreqInput");
    }
  filter = input.value.toUpperCase();  // alert(filter);
    if (x == 0 ) {
        div = document.getElementById("GroupDropdown");
    }else if (x == 1 ) {
        div = document.getElementById("KindDropdown");
    }else if (x == 2 ) {
        div = document.getElementById("FreqDropdown");
    } 
  a = div.getElementsByTagName("a");  
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText; // alert(txtValue); //dont run it loops
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

// These three function put the data into there respective dropdown-content DIV's
function putInGroupInput(pidi) {
    var hrefContent = pidi.getAttribute("href"); 
      //  alert(hrefContent); // #1:Weekly 2 Meter Voice:146.790MHz, T 107.2Hz:W0KCN:KCNARES
    var pidi2 = hrefContent.split(";")[3].trim();
    var org = hrefContent.split(";")[4].trim(); //alert(org); // KCNARES
    $("#org").html(org);
    
    // Get the defaults for the selected group from the pidi value
    var konID = hrefContent.split(";")[1].trim(); //alert('konID= '+konID);  // Find kindofnet id number
    var frqID = hrefContent.split(";")[2].trim(); //alert(frqID);  // Find frequency id number

    // Put the defaults for the selected group into the dropdowns
    $("#KindInput").val(konID);
    $("#FreqInput").val(frqID);

    $("#GroupInput").val(pidi2);
    $(".GroupDropdown-content").addClass("hidden");
}

function putInKindInput(pidi) {
   // alert("pidi= "+pidi);  // pidi= https://net-control.us/#23;Event
    var hrefContent = pidi.getAttribute("href");
    var pidi3 = (hrefContent.split(";")[1]);
     //   alert(pidi3);

    $("#KindInput").val(pidi3);
    $(".KindDropdown-content").addClass("hidden");
}

function putInFreqInput(pidi) {
   // alert("pidi= "+pidi);  // pidi= https://net-control.us/index.php#9:146.955MHZ,NoTone
    var hrefContent = pidi.getAttribute("href");
    var pidi4 = (hrefContent.split(";")[1]);
  //  alert(pidi4);

    $("#FreqInput").val(pidi4);
    $(".FreqDropdown-content").addClass("hidden");
}


// All the dropdowns are hidden by default, here we show them again as needed by the app.
// They are shown one at a time because they contain a lot of data, show when needed only.
function showGroupChoices() {
    $(".GroupDropdown-content").removeClass("hidden");
}

function showKindChoices() {
    $(".KindDropdown-content").removeClass("hidden");
}

function showFreqChoices() {
    $(".FreqDropdown-content").removeClass("hidden");
}

function blurGroupChoices() {
    $(".GroupDropdown-content").addClass("hidden");
}

function blurKindChoices() {
    $(".KindDropdown-content").addClass("hidden");
}

function blurFreqChoices() {
    $(".FreqDropdown-content").addClass("hidden");
}

function custom_setup() {
    $('#Fname').prop('type','hidden');
    $('#custom').prop('type','text');
    $('#section').prop('type','text');
}
    
    // This function is used to test the entered values of custom (category) and ARRL section
    // Test No. for 1 to 22
    // Test Letter for A, B, C, D, E, F
function checkFD() {
    var str = $("#custom").val().trim().toUpperCase();
    var letterNumber = /^(?:[1-9]|1[0-9]|2[0-2])[A-F]$/;
        if (letterNumber.test(str)) {
            var sec = $("#section").val().trim().toUpperCase();
            //alert("sec: "+sec);
            checkIn();
          //  return true;
        } else { 
            alert("Bad Category, please reenter"); 
            return false; 
        }
}


// This function creates a test net from the checkbox 
$(".tn").click(function() {
    var testEmail = prompt("What is your email address?\nOptional but helpful.");
    $('.testEmail').html(testEmail);
    
    if(!$( '#callsign' ).val()) {
        alert("Mandatory: Please provide your FCC call sign,\nnot TE0ST.");
        $( '#callsign' ).focus();
        //document.getElementById("callsign").focus();
    } else {   
    $('.last3qs').addClass('hidden');
    $('#GroupInput').val('TE0ST');
    $('#KindInput').val('Test Net');
    $('#FreqInput').val('Multiple');
}});

// This functin is used to show a net by its number and hide most of the controls
//$(document).ready(function() { do something here  });

function net_by_number() {
    var s = prompt("net ID?"); // get the net number
      if(s) {
            $.ajax({
				type: "GET",
				url: "getkind.php",  
				data: {q: s},
				success: function(html) {
    				var remarks = 'Net No: '+s+', '+html;
    				    $("#remarks").html(remarks);
				},
				error: function() {
					alert('Last Query Failed, try again.');
				}
            });  // end ajax */
                
      } // end if(s)
    
    showActivities(s);
    
        // Hide some elements to prevent play
        $(".ckin1").addClass("hidden");
        $("#closelog").addClass("hidden");
        $("#cs1").addClass("hidden");
        $("#Fname").addClass("hidden");
        $("#newbttn").addClass("hidden");
        $(".tohide").addClass("hidden");
        
        $("#remarks").removeClass("hidden");
        //$("#remarks").html('You are browsing Net No.: '+s+' ');
                      
        // Set this value before the MySQL get the data to prevent editing
        $(".closenet").html('Net Closed');
}   


// Creates a CSV output file of the currently displayed net. It only uses the fields showing on screen
    // If additional fields are needed, add them to the screen first with the show/hide button   
    // https://www.jqueryscript.net/table/jQuery-Plugin-To-Export-Table-Data-To-CSV-File-table2csv.html     

$("#dl").click(function(){

    var idofnet = $("#idofnet").html();
        idofnet = 'netID'+idofnet+'.csv';
        idofnet = idofnet.replace(/\s/g,'');
            //alert(idofnet);
    let options = {
        "filename": idofnet
    }
    
$("#thisNet").table2csv('download', options);
});

function toCVS() {
// http://johnculviner.com/jquery-file-download-plugin-for-ajax-like-feature-rich-file-downloads/
// https://github.com/johnculviner/jquery.fileDownload/blob/master/src/Scripts/jquery.fileDownload.js
// or https://stackoverflow.com/questions/3346072/download-csv-file-using-ajax
    var netID = $("#idofnet").text().trim(); 
        if(netID) {
            //alert(netID); // 2825
            $.ajax({
    			type: "GET",
    			url: "netCSVdump.php",  
    			data: {netID: netID},
    			success: function() {}	
            });  
        }
}


function sendEMAIL(adr,netid) {
    //alert(adr+'  '+netid);
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

function stationTimeLineList(info) {
    var info = info.split(":");
	
	var callsign = info[0];
	var netID    = info[1];
	
	//alert(netID+'  '+callsign); // 3317  WA0TJT
	
	var popupWindow = window.open("", "_blank",  strWindowFeatures);
		
		// was using getStationsTimeLine.php, replaced 2021-12-10
		
	$.ajax({
		type: 'POST',
		url: 'getStationICS-214A.php',
		data: {netid:netID, call:callsign},
		success: function(html) {	
			popupWindow.document.write(html);		
		} // end success
	});
}

// A right click on this field changes it to 'STANDBY' or 'STANDBY' gets changed to 'Resolved'
function rightClickTraffic(recordID) {
    //alert(recordID+" in rightClickTraffic()");
		if(recordID) {
    		//alert(recordID+" in rightClickTraffic()");
			$.ajax({
				type: 'POST',
				url: 'rightClickTraffic.php',
				data: {q: recordID},
				success: function(html) {
					//refresh();
				},
				error: function (data, status, e) {
    			alert(e);
			} // end error
			});
		}
		var netID = $("#idofnet").html().trim();
		showActivities( netID );
};

// This function changes a blank or no to yes, part of facility handling
function rightClickOnSite(recordID) {
    //if(recordID) {
        //console.log("@1313 recordID= "+recordID+" in rightClickOnSite()");
        // The "Click to edit" is coming from jquery.jeditable.js but i don't know why
        $.ajax({
			type: 'POST',
			url: 'rightClickOnSite.php',
			data: {q: recordID},
			success: function(data, status) {
    			//console.log(alert(data));
			},
			error: function (data, status, e) {
    			alert(e);
			} // end error
        });
    //}
    var netID = $("#idofnet").html().trim();
	showActivities( netID );
};

// A right click on this field looks up the distrct from the HPD table and updates it in the NetLog
function rightClickDistrict(str) {
	if(str) {
    	var split    = str.split(",");
        var recordID = split[0];
        var state    = split[1];
        var county   = split[2];

		console.log('@1280 str:'+str+'\n recordID:'+recordID+', state:'+state+', county:'+county);
		
		$.ajax({
			type: 'POST',
			url: 'rightClickDistrict.php',
			data: {q: recordID, st: state, co: county},
			success: function(html) {
			}
		});
	}
	var netID = $("#idofnet").html().trim();
	showActivities( netID );
};

// A right click on 'In' changes it to 'Out' and v.v.
function rightClickACT(recordID) {
    //alert(recordID+" in rightClickACT()");
		if(recordID) {
    		//console.log(recordID+" in rightClickACT()");
			$.ajax({
				type: 'POST',
				url: 'rightClickACT.php',
				data: {q: recordID},
				success: function(html) {
					//refresh();
				}
			});
		}
		var netID = $("#idofnet").html().trim();
		showActivities( netID );
};

// require_once "wxLL2.php";	at line 45 
// This function uses the clickers callsign to look up their lat/lon from the stations table. 
function newWX() {
    var str = prompt('What is your callsign?');
        if (str =="") { alert("OK no valid call was entered");
        }else { var thiscall = [str.trim()]; 
               console.log('@773 in index.php, The requested call is '+thiscall);
                  $.ajax({
		                type: "GET",
		                url:  "getNewWX.php",  
		                data: {str : str},
		                success: function(response) {
                            //console.log(response);
                            $(".theWX").html(response);
		                },  // end success
		                error: function() {
			                alert('Last Query Failed, try again.');
		                } // End error
                  }); // End ajax
	      } // end of else
}; // end newWX function



// This controls the where and when of the tip bubbles at <button class="tbb" in index.php
$(document).ready(function(){
    $(".tbb").click(function(){
        if ($("#refbutton").hasClass("hidden") ) {
            $(".tb1").toggle();
        }else {
            $(".tb2").toggle();
            
        }
    });
}); 

// this function creates a table view of the net call in the NetKind table if it doesn't already exist
function createNetKindView() { 
    var viewnm = $("#GroupInput").val().trim();
    //console.log("@1450 createNetKindView() in NetManager-p2.js viewnm= "+viewnm);
        if(viewnm) {
            $.ajax({
                type: "GET",
                url: "buildView4netcall.php",
                data: {viewnm: viewnm},
                success: function(response) {
                    console.log("@1457 createNetKindView in NetManager-p2.js viewnm= "+viewnm);
                }
            });
        }

} // end createNetKindView()
