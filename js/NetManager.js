// changes to mostly use jquery made on 2018-1-25

var strWindowFeatures = "resizable=yes,scrollbars=yes,status=no,left=20px,top=20px,height=800px,width=600px";

// Cache Elements for faster processing 
// use like this:    $lli.addClass('active').show();   drop the $("#lli") from the call
var $lli 			= $("#lli");
var $closelog 		= $("#closelog");
var $time 			= $("#time");
var $multiselect 	= $(".multiselect");
var $primeNav 		= $("#primeNav");
var $netIDs 		= $("#netIDs");
var $cb0 			= $("#cb0");
var $cb1 			= $("#cb1");
var $actLog 		= $("#actLog");
var $thebox 		= $('#theBox');
var $csnm 			= $("#csnm");
var $forcb1 		= $("#forcb1");
var $idofnet		= $("#idofnet");
var $select1		= $("#select1");
var $isopen			= $("#isopen");

function mapWhat3Words(w3w) {  
    if (w3w == '') {alert('No entry or click the blue refresh button first to see this location.');}
    else {
        var w3w = w3w.substring(0, w3w.indexOf("<")); //alert(w3w);
        window.open("https://map.what3words.com/"+w3w);
    }
}

// This function is called by right clicking on the gridsquare, it opens a map in APRS.fi showing the gridsquare
function MapGridsquare(koords2) {
	
	var koords = koords2.split(":"); //alert("2= "+koords2+" 0= "+koords[0]+","+koords[1]);

    var lat = koords[0];
    var lon = koords[1];
    var cs1 = koords[2];
    
    window.open("https://www.qrz.com/hamgrid?lat="+lat+"&lon="+lon+"&sg="+cs1);
}

function MapCounty(cntyst2) {
	var cntyst = cntyst2.split(":");
	
	var county = cntyst[0];
	var state  = cntyst[1];
	
	window.open("https://www.google.com/maps/place/"+county+"+County,"+state);
	//alert("https://www.google.com/maps/place/"+county+"+County,"+state);
}

function whatIstt() {
	$('tr').on('contextmenu', 'th', function(e) { //Get th under tr and invoke on contextmenu	
		alert("you are in the whatIstt function, call= ");
	});
}

function setDfltMode() {
    alert("you are in the setDfltMode() function, in NetManager.js. Soon you will be able to choose a default value for this column.");
    /*
        The List 
        var modeOptions = ["Voice", "CW", "Mob", "HT", "Dig", "FSQ", "D*", "Echo", "DMR", "Fusion", "V&D", "Online", "Relay"];
    */
}

// This function is called when the 'Report by Call Sign' is selected from the hamburger menu
function CallHistoryForWho() {
    var str = prompt("Enter a call sign");
		
	if (str =="") {alert("Sorry no call was selected");}
	
	else {

        var thiscall = [str.trim()];
        //alert("thiscall: "+thiscall);
            var popupWindow = window.open("", thiscall,  strWindowFeatures);
            var id = 0;
          //  e.preventDefault(); //Prevent defaults'
            
            $.ajax({
			type: "GET",
			url: "getCallHistory.php",  
			data: {call : thiscall, id : id},
			success: function(html) {
				
				popupWindow.document.write(html);

			},
			error: function() {
				alert('Last Query Failed, try again.');
			}
		});
      //  alert("in getCallHistory "+cs);  
	} // end of else
}


//This function will find the information about the history of the call right clicked on
//https://stackoverflow.com/questions/23740548/how-to-pass-variables-and-data-from-php-to-javascript
// Function name changed from getLastLogin to getCallHistory on 2018-1-17
function getCallHistory() {
	
	//Get the td under tr and invoke on contextmenu
	$('tr').on('contextmenu', 'td', function(e) { 
    	
    	//e.preventDefault(); //Prevent defaults'
    	
    	// Get the call and clean it up, that was right clicked
		var idparm = $(this).attr('id');
		var arparm = idparm.split(":");
		var id     = arparm[1];
			id 	   = id.replace(/\s+/g, '');
		var call   = $(this).html();            //alert(call);
		    call   = call.replace(/\s+/g, '');  // remove spaces 
		
		    if (call == '' ) {alert("no call");}
		
		var vals = [call].map((item) => item.split(/\W+/,1));
			call = vals[0];
		
		var thisdomain = getDomain();  //alert("@124 in NetManager.js thisdomain= "+thisdomain); 
		// By using _blank it allows multiple popups
		
	  	var popupWindow = window.open(" ", call,  strWindowFeatures);
            
	  	
		e.preventDefault(); //Prevent defaults'

		$.ajax({
			type: "GET",
			url: "getCallHistory.php",  
			data: {call : call, id : id},
			success: function(html) {
				popupWindow.document.write(html);
			},
			error: function() {
				alert('Last Query Failed, try again.');
			}
		});
	});
}

// The testCookies and refresh functions were here, now near the bottom 


function rightclickundotimeout() {
// 2018-1-25	var netid = document.getElementById("select1").value;

	var netid = $("#select1").val();
	var opensign = prompt("Enter your call sign to re-open log #" + netid);
	var opensign = opensign.toUpperCase();
 
		if (opensign != "" ) {
		$.ajax({
			type: "POST",
			data: {netid : netid, opensign : opensign},
			url: "rightclickundotimeout.php",
			cache: false,
			success: function(response) 
			{
				alert("Closed Log #" + netid + " has been reset.");
				location.reload(true);
				//showActivities(netid);
		  	}
		});
	}
}

function pre() {
	//alert("The pre is working");
	window.open("buildEvents.php");
}

/* Added 12/02/2016 to Call Sign entry CS1 */
function isKeyPressed(event) {
    if (event.altKey) {
	    var str = ' ';
        showHint(str);
    } 
}

// Added 2018-02-09 
// Gets the domain needed to build the preamble, agenda, closing, etc...
function getDomain() {
	// Find initial value for domain
	//if ($("#activity").length === 0 ) {alert("in missing activity");}
	
	// If the length of activity is 0, its actually missing because it never got created. 
	// I'm ussing this to trigger a search in the vaious php programs to display all known versions
	// of that dta... ie. preamble, closing, etc.
	if ($("#activity").length === 0 ) {
			//alert("in missing activity");
			var domain = 'ALL';
			//alert(domain);
	} else {
	
		var domain = $("#activity").html().trim();  //alert(domain);  // KCNARES  Weekly 2 Meter Voice Net
	
		if (domain.startsWith("CREW 2273")) {domain = "Crew2273";}
		if (domain.startsWith("Clay Co.")) {domain = "W0TE";}
		if (domain.startsWith("North Central MO")) {domain = "NCMO";}
		if (domain.startsWith("Carroll County")) {domain = "CARROLL";}   //alert('in js '+domain);
		if (domain.startsWith("Johnson County")) {domain = "KS0JC";}
	}
		
		return domain; 
}

function openPreamble() {
	var domain = getDomain();  //alert("domain in openPreamble= "+domain); 
	//if (!domain) {alert('no domain');}
		document.getElementById("preambledev").href = "buildPreambleListing.php?domain="+domain;
}

function openClosing() {
	var domain = getDomain();
		document.getElementById("closingdev").href = "buildClosingListing.php?domain="+domain;
}
						   
function openAgenda() {
	var domain = getDomain(); alert(domain); // PCARG  Weekly 2 Meter Voice Net
		document.getElementById("agendadiv").href = "buildEventListing.php?domain="+domain;
}

function hideit() {
	$("#makeNewNet").addClass("hidden");
	//$("#select1").removeClass("hidden");
	$("#form-group-1").show();
}

function showit() {
	$("#makeNewNet").removeClass("hidden");

	$("#callsign").focus();
	$("#openNets").addClass("hidden");  // Added 01-31-2017
	
	$("#form-group-1").hide();
}

function showSubNets(str) {
	//var str = $("#select1").val();
	var str = $("#idofnet").html().trim();
	//	str = str.trim();
	//alert(str);   // active net at the time clicked 54, not the subnet we're looking for
	$("#subNets").removeClass("hidden");
	  if (document.getElementById('cb1').checked == false) {
		   document.getElementById("subNets").innerHTML = "";
             	  return;
	  } else {
		  
		  // This change made 2018-08-04
		  $.ajax({
				type: 'GET',
				url: 'getsubnets.php',
				data: {q: str},
				success: function(response) {

					$("#subNets").text(response);
					
				} // end response
		  }); // end ajax reading of table
	  }
}  // End showSubNets

/* created 2018-08-04 combined two function into this one to close a log */
$(document).ready(function() {
    
    $(".timelineBut2").hide(500); // this is the update button for the Time Log. Its hidden here in order to hide it during the initial display of the net. Without it, it shows up and defeats the purpose of it coming and going.
    
	$('#closelog').click(function() {
		//alert("top of click");
		var closesign = prompt("Enter your callsign to confirm closing the log:");
		var closesign = closesign.toUpperCase();
			if (closesign != "") {
				var net2close = $("#idofnet").html();
				var str = net2close+","+closesign;  // replace spaces in string
				var str = str.replace(/\s/g, '');
				//alert("str= "+str);  //str= 760,WA0TJT
				
				//$(this).val() == "Close Net" ? closeLog(closesign) : openLog();

				$("#closelog").html("Net Closed");
				$(".toggleTOD").toggle(); binaryops=binaryops + 1;  // show the TOD column
				
				$.ajax({
					type: 'POST',
					url: 'closeLog.php',
					data: {q: str},
					success: function(response) {
					//alert("response= "+response);
						$(".toggleTOD").toggle(); binaryops=binaryops + 1;
						$("#actlog").html(response);
						$("#closelog").html("Net Closed");
						showActivities(net2close);
						// the call below opens the ICS-214 report for the current net
						window.open("https://net-control.us/ics214.php?NetID="+net2close);
						
					} // end response
				}); // end ajax update of table
			} // end if (closesign != "") 
	}); // end closelog click function
}); // end ready function

function graphtimeline() {
    // str here is NetID 
	if ( $('#idofnet').length ) {
		var str	 = $("#idofnet").html().trim();
	} else {
		var str = prompt("Enter a Log number.");
	}
		
	if (str =="") {alert("Sorry no net was selected");}
	else {
		window.open("HzTimeline.php?NetID="+str);
	}
}


function ics214button() {
	// str here is NetID 
	if ( $('#idofnet').length ) {
		var str	 = $("#idofnet").html().trim();
	} else {
		var str = prompt("Enter a Log number.");
	}
		
	if (str =="") {alert("Sorry no net was selected");}
	else {
		window.open("ics214.php?NetID="+str);
	}
}

function ics309button() {
	// str here is NetID 
	if ( $('#idofnet').length ) {
		var str	 = $("#idofnet").html().trim();
	} else {
		var str = prompt("Enter a Log number.");
	}
		
	if (str =="") {alert("Sorry no net was selected");}
	else {
		window.open("ics309.php?NetID="+str);
	}
}

function ics205Abutton() {
	// str here is NetID 
	if ( $('#idofnet').length ) {
		var str	 = $("#idofnet").html().trim();
	} else {
		var str = prompt("Enter a Log number.");
	}
		
	if (str =="") {alert("Sorry no net was selected");}
	else {
		window.open("ics205A.php?NetID="+str);
	}
}


function map1() {
	if ( $('#idofnet').length ) {
		var str	 = $("#idofnet").html().trim();
	} else {
		var str = prompt("Enter a Log number.");
	}
		
	if (str =="") {alert("Sorry no net was selected");}
	else {
	window.open("map1.php?NetID="+str);
	}
}

function map2() {
	if ( $('#idofnet').length ) {
		var str	 = $("#idofnet").html().trim();
	} else {
		var str = prompt("Enter a Log number.");
	}
		
	if (str =="") {alert("Sorry no net was selected");}
	else {
	window.open("map.php?NetID="+str);
	}
}

function printByNetID() {
	if ( $('#idofnet').length ) {
		var str	 = $("#idofnet").html().trim();
	} else {
		var str = prompt("Enter a Log number.");
	}
		
	if (str =="") {alert("Sorry no net was selected");}
	else {
	window.open("printByNetID.php?NetID="+str);
	}
} // End printByNetID


// This empty looking function is actually run by CellEditFunction() in CellEditFunction.js
$('.editGComms').on("click", function(){
    $('.editGComms').empty(); 
});


// This function empties the contents of other fields
// For some reason it doesn't work properly in jQuery
function empty(thisID) {
    document.getElementById(thisID).innerHTML = "";
} // End empty()



// ========================================================================================================
// This function populates and shows the Time Line 
// See: https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_eff_toggle_callback for an example
// An additonal setting of timelineBut2 is done at line 263 to control its visibility at initial load of the table
function TimeLine() {
	$("#timeline").toggle(500, function() {
        $(".timelinehide").toggle(500);
        $(".timelineBut2").toggle(500); // this is the update button
	});
	
		var str = $("#idofnet").html();
		//alert(str);
		$.get('getTimeLog.php', {q: str}, function(data) {
			$("#timeline").html(data);	// this once said .TimeLine() as if calling itself again
		}); // end response
} // End TimeLine()

function RefreshTimeLine() {
    var str = $("#idofnet").html();
		//alert(str);
		$.get('getTimeLog.php', {q: str}, function(data) {
			$(".timeline").html(data);	// this once said .TimeLine() as if calling itself again
		}); // end response
}

function HideTimeLine() { 	
	$(".timelineBut2").hide(500); // this is the update button
		
	$("#timeline").hide(500);
	$(".timelinehide").hide(500);
} // End HideTimeLine()
// ========================================================================================================


// This is the biggie, it runs the php extracting from MySQL to populate the grid
function showActivities(str, str2) { 
    var str = str.trim();
	RefreshGenComm();

	// This little loop builds the upper right corner information.
	if (str2) {
    	//alert(str2);  // TE0ST, Net #: 2768 --&gt; TE0ST For Testing Only MARS Traffic Net of 2020-08-28
		var netcall = str2.slice(0, str2.indexOf(","));   
			$("#upperRightCorner").load("buildUpperRightCorner.php?call="+str2.split(",",2)[0]);
					
		 // This routine determins if this net is a Custom net, 
		 // if it is the Name field is swapped for a Category field	
         if ( str2.indexOf("MARS") >= 0 ) { 
             $('#Fname').prop('type','hidden');
             $('#custom').prop('type','text');
             $('#custom').removeClass("hidden");
             $('#custom').attr('placeholder', 'Traffic For:');
            // $('#section').prop('type','text');
         } else { 
             $('#Fname').prop('type','text');
             $('#custom').prop('type','hidden');  
             $('#section').prop('type','hidden');
         }          
	}
	
	// This is the div to update, it changes depending on whose turn it is
	    var thisDiv = 'actLog';
	
	// Hides some div's shows others
	$("#refbutton").removeClass("hidden");
	$("#refrate").removeClass("hidden");   // Added 2018-03-05
	$("#openNets").addClass("hidden");
	$("#time").removeClass("hidden");
	$("#subNets").addClass("hidden");
	$(".newstuff").addClass("hidden");  // Hides the span about this being a new net on indes.php'
	
	// These two don't do anything currently. They were created for the indexPlay.php and control the new
	// class by these names.
	$(".makeaselection").addClass("hidden");
	$("#grad1").addClass("hidden");
	
	
	// Change which bubbles are shown based on if a net is shown or not
	$("#tb").removeClass("tipsbutton");
    $("#tb").addClass("tipsbutton2");
   


	
	// Show or hide some DIV's depending on value of str 
	if (str == '0') {  // Added 2016-12-05  won't ever happen again... i hope
    	console.log(str); 
			$("#closelog").addClass("hidden");
			$("#time").addClass("hidden");
			$(".multiselect").addClass("hidden");
			$("#primeNav").addClass("hidden");
			$("#cb1span").addClass("hidden");
			$("#refbutton").addClass("hidden");
			$("#refrate").addClass("hidden");
	} else {
			$("#closelog").removeClass("hidden");
			$("#time").removeClass("hidden");
			$(".multiselect").removeClass("hidden");
			$("#primeNav").removeClass("hidden");
			
	//		$("#cb1span").removeClass("hidden");
	} // End of else @382
	
	  // Create a new net if requested
      if (str == "newNet()") {
      	newNet(); 	// Is in NetManager-p2.js
      }
      
      // I don't know if this if applies to anything as of 2019-03-22 but the else does...
      if (str == "") {

	      	$("#actLog").html("");
	      	$("#netIDs").html("");
	      	$("#closelog").html("");
	      	$("#cb1").prop("checked",false);
	      
            	return;
      } else { 
         //alert('in an else of showActivities()');
		 	$("#netIDs").html("");
		 	$("#cb1").prop("checked",false);
           
            $.ajax({
               type: "GET",
               url:  "getactivities.php",
               data: {q:str},
               success: function(response) {
                   $('#actLog').html(response);
                   //alert(remarks);
                   
                   if ($('#thenetCallsign').length) { // This just tests if it exists
					//dont put anything here
				} else {
    				
    				// Removed on 2019-09-12
				  	// This jQUERY puts the freq div from getactivities.php into freq2 
				//  	$('#theBox').append('<div id="freq">'+'Primary Freq: '+document.getElementById("freq2").innerHTML+'</div>');
				//  	$('#theBox').append('<div id="netCallsign">'+document.getElementById("netcall").value+'</div>');
				} 
				
				    sorttable.makeSortable(document.getElementById("thisNet"));
						$( document ).ready( CellEditFunction );
						
						 testCookies(netcall);
						 
                         var tz_domain = getCookie("tz_domain"); //alert('@453 '+tz_domain);
                         if ( tz_domain == 'Local' ) { goLocal(); } else { goUTC(); }
               },
               error: function() {
                   alert('Sorry somethings wrong in NetManager.js @468, try again');
               }
            });
                 
            // This routine checks to see if there are any checked-in stations by looking at the logdate values.
			// If its 0 then its a pre-built yet to be opened
			// Any other value means its open and running
			var ispbStat = $('#pbStat').html();
			 //alert('@570 NM.js ispbStat= '+ispbStat);
			 
            // if (ispbStat == 0) { $("#closelog").addClass('hidden');}
            
            $("#makeNewNet").addClass("hidden");
            $("#csnm").removeClass("hidden");
            $("#cb0").removeClass("hidden");
            $("#forcb1").removeClass("hidden");
            
            if (str == 0) {
	            $(".c1, .c2, .c3").hide();
            }
		            	            		            
      } // End str == "" @577 the else part (I think)    
      
      
     //var tz_domain = sessionStorage.getItem("tz_domain"); console.log(tz_domain);
        //if(tz_domain == 'local') { goLocal(); } else { goUTC(); }
} // end of showactivites function


// re-wrote these two function 2018-02-12
function showHint(str) {
    // var nc = $( "#thenetcallsign" ).html(); alert('val= '+nc);
   // alert(str);
	if (str.length == 0) {
  		$("#txtHint").html(""); // set to empty
  			return;
  	} else {
	  	$.ajax({
		  	type: 	 "GET",
		  	url:	 "gethint.php",
		  	data:	 {q : str},
		  	success: function(response) {
			  	$("#txtHint").html(response);
		  	},
		  	error:	 function() {
			  	alert('Sorry no hints.');
		  	}
	  	})
}} 

function nameHint(str) {
	if (str.length == 0) {

		$("#txtHint").html("");
		return;
	} else {
		$.ajax({
			type:	"GET",
			url:	"gethintName.php",
			data:	{q : str},
			success: function(response) {
				$("#txtHint").html(response);
			},
			error: function() {
				alert('Sorry no hints.');
			}
		})
}}

function set_cs1(item) { 	 	//Load up the call sign and name from the selection  list
  	$('#cs1').val(item);
  	$('#Fname').focus();
  	$('#txtHint').show();
}

function set_Fname(item) { 	 	//Load up the call sign and name from the selection  list
  	$('#Fname').val(item);
  	$("#txtHint").html("");
  	$('#txtHint').show();
}

function set_hidden(item) {  	//Load up the call sign and name from the selection  list
  	$('#hideme').val(item);
  	$('#txtHint').show();
}

function set_hidestuff(item) { 	//Other needed values
	$('#hidestuff').val(item);
}

function loadsorttable() {
	var newTableObject = document.getElementById("thisNet");
    	sorttable.makeSortable(newTableObject); 
 // 2018-1-25   document.getElementById("csnm").style.visibility="hidden";
    	$("#csnm").addClass("hidden");
}

//This function is used in the buildEvents.php program
function selectDomain(thisdom) {
	//alert("thisdom "+thisdom);
	var domain = $('#netDomain').find(":selected").text(); 
	alert("from netDomain "+domain+" and "+thisdom); 
	//from netDomain CREW2273  and CREW2273
}


function AprsFiMap() {
	var q = $("#select1").val();
	
	$.ajax({
		type:	"GET",
		url:	"AprsFiMap.php",
		data:	{q : q},
		success: function(response) {
			//alert(response);
			window.open(response);
		}
	})
}

// Function to delete a row
// You can NOT delete a row that shows 'OUT'
$(document).on('click', '#thisNet td a.delete', function()  {
	$("#thisNet td a.delete").click(function() {
		if (confirm("Are you sure you want to delete this row?")) {
		
			var id = $(this).parent().parent().attr('id'); 
			var parent = $(this).parent().parent();
			
			$.ajax({
				   type: "POST",
				   url: "delete-row.php",
				   data: {id : id},  // this is the recordID not the tt#
				   cache: false,
				   success: function()
				   {
						parent.fadeOut('slow', function() {$(this).remove();});
				   }
			 });				
		}
	});
});


function RefreshGenComm() {
    var str = $("#idofnet").html();
		$.get('getGenComments.php', {q: str}, function(data) {
			$(".editGComms").html(unescape(data));
		}); // end response
}

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
	        		showActivities($("#idofnet").html().trim());  // this is the netID, number 
	        	}, interval);		    	 
	});


/* This function is called by the button named refresh to refresh the screen */
function refresh() {
   // var tz_domain = getCookie("tz_domain"); //alert('@730 '+tz_domain);
    //        if ( tz_domain == 'Local' ) { goLocal(); } else { goUTC(); }
	var refreshnet=$("#idofnet").html().trim();   //alert("in refresh()= "+refreshnet);
	    // refreshnet is the netID of the open net
		showActivities(refreshnet); // showActivities function is in this file
		//RefreshGenComm(refreshnet);
}

$('#refbutton').click(function() {
     //   var tz_domain = getCookie("tz_domain"); //alert('@739 '+tz_domain);
     //       if ( tz_domain == 'Local' ) { goLocal(); } else { goUTC(); }
		// refreshnet is the netID of the open net
		var refreshnet=$("#idofnet").html().trim();   //alert("in refresh()= "+refreshnet);
			showActivities(refreshnet); // showActivities function is in this file		
	});
	
}); // end document ready

function showColumns() {
	var netcall   = $("#thenetcallsign").html().replace(/\s+/g, '');
	var myCookie = (getCookie('columnChoices_'+netcall));  //alert("refresh @625 myCookie = "+myCookie);
	
	if (myCookie) {
		var testem = myCookie.split(",");  //alert("testem= "+testem);
		testem.forEach(toggleCol); // The function here is showCol() in cookieManagement.js
	} // End if myCookie
}

function goLocal() {
    //alert('In goLocal');
    setCookie('tz_domain', 'Local', 2);
    $("#theLocal").prop('checked','checked');
    $(".tzld").addClass("hidden"); // tzld = timezone localdate (time in)
    $(".tzto").addClass("hidden"); // tzto = timezone timeout (out time)
    $(".tzlld").removeClass("hidden");
    $(".tzlto").removeClass("hidden");
}

function goUTC() {
    //alert('In goUTC');
    setCookie('tz_domain', 'UTC', 2);
    $("#theUTC").prop('checked','checked');
    $(".tzld").removeClass("hidden"); // tzld = timezone localdate (time in)
    $(".tzto").removeClass("hidden"); // tzto = timezone timeout (out time)
    $(".tzlld").addClass("hidden");
    $(".tzlto").addClass("hidden");
}
