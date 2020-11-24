// changes to mostly use jquery made on 2018-1-25

var strWindowFeatures = "resizable=yes,scrollbars=yes,status=no,left=20px,top=20px,height=800px,width=600px";

// Cache Elements for faster processing 
// use like this:    $lli.addClass('active').show();   drop the $("#lli") from the call
var $lli 			= $("#lli");
var $closelog 		= $("#closelog");
var $time 			= $("#time");
var $multiselect 	= $(".multiselect");
var $primeNav 		= $("#primeNav");
var $netIDs 			= $("#netIDs");
var $cb0 			= $("#cb0");
var $cb1 			= $("#cb1");
var $actLog 			= $("#actLog");
var $thebox 			= $('#theBox');
var $csnm 			= $("#csnm");
var $forcb1 			= $("#forcb1");
var $idofnet			= $("#idofnet");
var $select1			= $("#select1");
var $isopen			= $("#isopen");

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


//This function will find the information about the history of the call right clicked on
//https://stackoverflow.com/questions/23740548/how-to-pass-variables-and-data-from-php-to-javascript
// Function name changed from getLastLogin to getCallHistory on 2018-1-17
function getCallHistory() {
   // alert("in getcallhistory");
	refresh();   // This prevents the popup from having multiple entries in it. There may be a better way but ???
/*	if (!popupWindow == null) {
        popupWindow.dispose = true;
	    popupWindow.close();
    } */
	
	$('tr').on('contextmenu', 'td', function(e) { //Get td under tr and invoke on contextmenu
		
		var idparm = $(this).attr('id');
		var arparm = idparm.split(":");
		var id     = arparm[1];
			id 	   = id.replace(/\s+/g, '');
		var call   = $(this).html();
		var call   = call.replace(/\s+/g, ''); // remove spaces 
		//alert("call: "+call+"\n"); // call: <fontcolor="black">KA2FNK</font>
		var vals = [call].map((item) => item.split(/\W+/,1));
			var call = vals[0];
		
		var thisdomain = getDomain();  //alert("@98 in NetManager.js thisdomain= "+thisdomain); 
		// By using _blank it allows multiple popups
	  	var popupWindow = window.open("", call,  strWindowFeatures);
	  	
	  	
	  	//alert("idparm: "+idparm+"\narparm: "+arparm+"\nid: "+id+"\ncall: "+call+"\nthisdomain: "+thisdomain);
	  	
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
	var domain = getDomain(); //alert(domain); // PCARG  Weekly 2 Meter Voice Net
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

				$("#closelog").val("Net Closed");
				$(".toggleTOD").toggle(); binaryops=binaryops + 1;  // show the TOD column
				
				$.ajax({
					type: 'POST',
					url: 'closeLog.php',
					data: {q: str},
					success: function(response) {
					//alert("response= "+response);
						$(".toggleTOD").toggle(); binaryops=binaryops + 1;
						$("#actlog").html(response);
						
						showActivities(net2close);
						// the net below opens the ICS-214 report for the current net
						window.open("https://net-control.us/ics214.php?NetID="+net2close);
						
					//	The below code redisplays the current net but does not update the time out values
					//	showActivities(net2close, interval);
						
					} // end response
				}); // end ajax update of table
			} // end if (closesign != "") 
	}); // end closelog click function
}); // end ready function


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

// This little function clears out the field before a new 
// entry is made into it. Mostly used by the comments column
function empty(thisID) {
	//alert("empty  "+thisID);
	if (thisID == 'genComments') {
		//$('#genComments').html("");
		$('#genComments').empty();
	}
	else {
		document.getElementById(thisID).innerHTML = "";
	}
} // End empty()

function HideTimeLine() {
	//$("#timeline").addClass("hidden");  	// the button to hide the timeline
	//$("#timelinehide").addClass("hidden");  // the time line itself
	
	$("#timeline").hide(500);
	$("#timelinehide").hide(500);
	
} // End HideTimeLine()

function TimeLine() {
	//$("#timeline").removeClass("hidden");
	//$("#timelinehide").removeClass("hidden");
	
	// See: https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_eff_toggle_callback for an example
	
	$("#timeline").toggle(500, function() {
    	    $("#timelinehide").toggle(500);
	});
	
	
		var str = $("#idofnet").html();
		//alert(str);
		$.get('getTimeLog.php', {q: str}, function(data) {
			$("#timeline").html(data);	// this once said .TimeLine() as if calling itself again
		}); // end response
} // End TimeLine()

// This is the biggie, it runs the php extracting from MySQL to populate the grid
function showActivities(str, str2) { 
	
	//alert("str= "+str+"\nstr2= "+str2);
	// str= 1218
    // str2= TE0ST, Net #: 1218 --&gt; TE0ST Test Net of 2019-04-05 14:07:04
	
	// This little loop builds the upper right corner information.
	if (str2) {
		var netcall = str2.slice(0, str2.indexOf(","));   
			$("#upperRightCorner").load("buildUpperRightCorner.php?call="+str2.split(",",2)[0]);
	}
	
	// This is the div to update, it changes depending on whose turn it is
	    var thisDiv = 'actLog';
	 //   var ix = $(this).index();
	    
	 //   $("#actLog").toggle(ix === 0);
	  //  $("#actLog2").toggle(ix === 1);
	
	// Hides some div's shows others
	$("#refbutton").removeClass("hidden");
	$("#refrate").removeClass("hidden");   // Added 2018-03-05
	$("#openNets").addClass("hidden");
	$("#time").removeClass("hidden");
	$("#subNets").addClass("hidden");
	$(".newstuff").addClass("hidden");  // Hides the span about this being a new net on indes.php
	
	
	// Show or hide some DIV's depending on value of str 
	if (str == '0') {  // Added 2016-12-05
			$("#closelog").addClass("hidden");
			$("#time").addClass("hidden");
			$(".multiselect").addClass("hidden");
			$("#primeNav").addClass("hidden");
			$("#cb1span").addClass("hidden");
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
	      /* Changed 2018-1-25 */
	      	$("#actLog").html("");
	      	$("#netIDs").html("");
	      	$("#closelog").html("");
	      	$("#cb1").prop("checked",false);
	      
            	return;
      } else { 

		 	$("#netIDs").html("");
		 	$("#cb1").prop("checked",false);
				 	
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
           
            $.ajax({
               type: "GET",
               url:  "getactivities.php",
               data: {q:str},
               success: function(response) {
                   $('#actLog').html(response);
                   
                   if ($('#thenetCallsign').length) { // This just tests if it exists
					//dont put anything here
				} else {
				  	// This jQUERY puts the freq div from getactivities.php into freq2 
				  	$('#theBox').append('<div id="freq">'+'Primary Freq: '+document.getElementById("freq2").innerHTML+'</div>');
				  	$('#theBox').append('<div id="netCallsign">'+document.getElementById("netcall").value+'</div>');
				} 
				
				    sorttable.makeSortable(document.getElementById("thisNet"));
						$( document ).ready( CellEditFunction );
						
						 testCookies(netcall);
               },
               error: function() {
                   alert('Sorry somethings wrong, try again');
               }
            });
         
          
          /*  
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(thisDiv).innerHTML = xmlhttp.responseText;
                    
				if ($('#thenetCallsign').length) { // This just tests if it exists
					//dont put anything here
				} else {
				  	// This jQUERY puts the freq div from getactivities.php into freq2 
				  	$('#theBox').append('<div id="freq">'+'Primary Freq: '+document.getElementById("freq2").innerHTML+'</div>');
				  	$('#theBox').append('<div id="netCallsign">'+document.getElementById("netcall").value+'</div>');
				} 
                    
                } // End of if (xmlhttp.readyState == 4
            } // End of xmlhttp.onreadystatechange = function()   		
            
		            xmlhttp.open("GET","getactivities.php?q="+str,true);
		            xmlhttp.send();
		               		         
    		         // thisNet is the id of the table created above.
    		            setTimeout( () => {
                        sorttable.makeSortable(document.getElementById("thisNet"));
						$( document ).ready( CellEditFunction );
						
						 testCookies(netcall);
                    }, 200); //end setTimeout function 
           */         
		            // This routine checks to see if there are any checked-in stations by looking at the logdate values.
					// If its 0 then its a pre-built yet to be opened
					// Any other value means its open and running
					var ispbStat = $('#pbStat').html();
					//alert(ispbStat);
					if (ispbStat == 0) { $("#closelog").addClass('hidden');}
		            
		            $("#makeNewNet").addClass("hidden");
		            $("#csnm").removeClass("hidden");
		            $("#cb0").removeClass("hidden");
		            $("#forcb1").removeClass("hidden");
		            
		        		//testCookies(netcall);  // Set the columns to display
		            	            		            
      } // End str == "" @395 the else part (I think)          
      
     // testCookies(netcall);  // Set the columns to display
} // end of showactivites function


// re-wrote these two function 2018-02-12
function showHint(str) {
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
				alert('Sorry no hings.');
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
  // 2018-1-25	document.getElementById("txtHint").innerHTML = "";
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


/* This function is called by the button named refresh to refresh the screen */

function refresh() {
	// Test if the 'Refresh' button was clicked
	//$('#refbutton').click(function() {
		// refreshnow is the netID of the open net
		var refreshnow=$("#idofnet").html().trim();   //alert("in refresh()= "+refreshnow);
			showActivities(refreshnow); // showActivities function is in this file
	//testCookies();  // In cookieManagement.js  // commented 2019-03-19 @11:35am to test it use @436
	//});
}



function showColumns() {
	var netcall   = $("#thenetcallsign").html().replace(/\s+/g, '');
	var myCookie = (getCookie('columnChoices_'+netcall));  //alert("refresh @625 myCookie = "+myCookie);
	
	if (myCookie) {
		var testem = myCookie.split(",");  //alert("testem= "+testem);
		testem.forEach(toggleCol); // The function here is showCol() in cookieManagement.js
	} // End if myCookie
}