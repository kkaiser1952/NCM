// This javascript works with the columnPicker.php 
// 2020-10-15 Modified to include time zone selection

// These are default values, they get changed in NetManager.js by goLocal() and goUTC()
var tzvalue = new Date().getTimezoneOffset(); //alert(tzvalue);
    setCookie('tzdiff', tzvalue, 2, SameSite='Strict');  // set a cookie with the local time difference from UTC 
    setCookie('tz_domain', 'UTC', 2, SameSite='Strict'); // and a cookie with the default domain of the time zone
    
// These two function are based on right clicking either the facility or onsite  
// This function removes the number (33) from the cookie list  
// And then replaces the cookie 
function clearFacilityCookie() {
    var netcall = $("#domain").html().trim();
    var facilityCookie = (getCookie('columnChoices_'+netcall.trim()));
    
    if (facilityCookie) {  // It found cookies in storage
        var arrayCookies = facilityCookie.split(',');  // create the array called arrayCookies
		}  else {
            facilityCookie = "";
            arrayCookies = facilityCookie.split(',');
    }    
        //alert("1 arrayCookies: "+JSON.stringify(arrayCookies));    
        for( var i = 0; i < arrayCookies.length; i++) {
            if ( arrayCookies[i] === "33") {
                arrayCookies.splice(i, 1);
            }
        }
        //alert("2 arrayCookies: "+JSON.stringify(arrayCookies));
        setCookie('columnChoices_'+netcall.trim(), arrayCookies, 10);
            
} // End clearFacilityCookie()

// This function is to add the facility cookie (33) to the net
function showFacilityColumn() {
    var netcall = $("#domain").html().trim();
    var facilityCookie = (getCookie('columnChoices_'+netcall.trim()));
    // get the cookie for this net
    if (facilityCookie) {  // It found cookies in storage
        var arrayCookies = facilityCookie.split(',');  
    }  else {
        facilityCookie = "";
        var arrayCookies = facilityCookie.split(',');
    } // End if    
        //alert("1 arrayCookies: "+JSON.stringify(arrayCookies));  
        arrayCookies.push("33");  
        //alert("2 arrayCookies: "+JSON.stringify(arrayCookies));
        setCookie('columnChoices_'+netcall.trim(), arrayCookies, 10);
} // End showFacilityColumn()

// End of the facility & On site cookie moves


function setCookie(cname, cvalue, exdays, SameSite) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  var SS = "SameSite=Strict";
  //document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  document.cookie = cname + "=" + cvalue + ";" + expires + ";" + SS + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function eraseCookie(cookieName) {
	setCookie(cookieName, "", -1);
}

function getCurrent() {
	var value = getCookie(cookieName).split(','); //alert("value 0= "+value[0]+" 1= "+value[1]);
			// Call each value one at a time and pass to showChecked(sh) to check the appropriate columns
		value.forEach(showChecked);
}

function showChecked(sh) {
	$('.'+sh).prop('checked', true);
}

//$(document).ready(function(){
function calculate() {
	 //alert("in cal cookieName= "+cookieName);
	
	var numberOfChecked   = $('input:checkbox:checked.intrests').length; //alert("1 noofchecked= "+numberOfChecked); // 0
	var numberOfRadio     = $('input:radio:checked.intrests').length;    //alert("radio checked"+numberOfChecked); // 0
	var totalCheckboxes   = $('input:checkbox').length ;		//alert("2 tot= "+totalCheckboxes);				     // 23
	var totalRadioboxes   = $('input:radio').length ;        //alert("totalradioboxes "+totalRadioboxes);
	var numberNotChecked  = totalCheckboxes - numberOfChecked;	//alert("3 "+numberNotChecked);					     // 23
	var numberNotChecked2 = $('input:checkbox:not(":checked")').length;  //alert("4 "+numberNotChecked2);  		     // 9
		
	 var arr = $.map($('input:checkbox:checked'), function(e, i) { 
        return +e.value;    
	 });  // End arr = 
   
   var cc = getCookie(cookieName);
  // alert("the cookie= "+cc);
   		breakCC = cc.split(',');
   		
   			$.each(breakCC, function (index, value) {
			  $('input[name="intrests[]"][value="' + value.toString() + '"]').prop("checked", true);
			});
    
    var x = arr.join(',');

    $('p').text('The checked values are: ' + arr.join(','));	
        
	return x;
	
}  // End calculate() 


// This function uses the net callsign to either read a cookie if it exists or it reads the NetKind table to get
// the columnViews column which indicates the default additional columns to show
function testCookies(nc) {
	// Initialize the three arrays
	var array1011 = [];
	var arrayCookies = [];
	var arrayBoth = [];
	
	var thelist = "";
	
	// This sets us up to add the email and phone columns automatically if its a meeting or event
/*	var spcl = ($('select[name="activities"] :selected').attr('class').trim());  //alert("spcl = "+spcl);
		if (spcl.includes('spcl')) { 	// its an event or meeting
			var array1011 = [10,11]; // for use later in arrayBoth
		} */
		
    //var arrayDefault = ["1","2","3","4","6","7","12","13","14","17","18"];
    
    // This test was added because the MARS groups don't want to see the county and state.
    // Removed 17 & 18 the county and state from the default on 2021-09-14
    if ( $("#activity").html().includes("MARS")) {
        var arrayDefault = ["1","2","3","4","6","7","12","13","14","50"]; 
    } else {var arrayDefault = ["1","2","3","4","6","7","9","12","13","14","18"];}
		
    // This sets us up to add the email and phone columns automatically if its a meeting or event
    if ( $("#activity").html().includes("Meeting") /*|| $("#activity").html().includes("Event") */ ) {
        var array1011 = ["10","11"]; // for use later in arrayBoth
    } else if ($("#activity").html().includes("Weather Net")) {
        var array1011 = ["10","11","17","18","24"];
       // alert("array1011: "+JSON.stringify(array1011));
    } else { array1011 = []; }
    
    /*
    if ( $("thenetcallsign").html().includes("JFK50")) {
        var { array1011 = []; }
    } */
    
    if ( $("#activity").html().includes("MARS")) {
        var arrayFD = ["2","50"] ;
    } else { arrayFD = arrayDefault ; }
    
    // This adds the Band column by default if the frequency is set to Multiple Bands
    if ( $("#add2pgtitle").html().includes("Multiple Bands") || $("#add2pgtitle").html().includes("80/40 Meters")) {
        var array1011 = array1011.concat("23");
    }
		
    // NC is the netcall, if it doesn't exits go get it
	if (nc == null) {  // test if nc is empty or undefined
		var netcall = $("#domain").html().trim(); 
	}else{
		var netcall = nc; 
	}
	
	// Go get the cookies as stored in cookies (storage) this overrides what is found above
	var myCookie = (getCookie('columnChoices_'+netcall.trim())); 
		if (myCookie) {  // It found cookies in storage
			arrayCookies = myCookie.split(',');  // create the array called arrayCookies
		}  else {
           // myCookie = $("#cookies").html().trim();
           // myCookie = "17,18";
            myCookie = "";
            arrayCookies = myCookie.split(',');
        } 

        // alert("arrayCookies: "+JSON.stringify(arrayCookies));
        		
    // This hides all the extra columns as preperation for showing only the requested ones below
        $(".c5, .c8, .c9, .c10, .c11, .c15, .c16, .c17, .c18, .c59, .c20, .c21, .c22, .c23, .c24, .c30, .c31, .c32, .c33, .c34, .c35 ").hide();
        $(".c25, .c26, .c27, .c28, .c29").hide(); // Admin Level
        $(" .c50, .c51").hide(); // Custom Level
       
      // alert("array1011= "+JSON.stringify(array1011)+"\narrayCookies= "+JSON.stringify(arrayCookies));
       
        var arrayBoth = array1011.concat(arrayCookies).concat(arrayFD);
           // alert("arrayBoth= "+JSON.stringify(arrayBoth));
			
    // This called function shows all the required columns
        arrayBoth.forEach(showCol);
}  // End testCookies()
 
// The showCol function is called from the popup columnPicker.php
function showCol(sh) {
		if            (sh === '5'  ) { $(".c5").show();     // tt No.
    	    } else if (sh === '8'  ) { $(".c8").show();     // Last Name
            } else if (sh === '9'  ) { $(".c9").show();     // Tactical
    	    } else if (sh === '10' ) { $(".c10").show();    // Phone Number
    	    } else if (sh === '11' ) { $(".c11").show();    // eMail Address
    	    } else if (sh === '15' ) { $(".c15").show();    // Credentials
    	    } else if (sh === '16' ) { $(".c16").show();    // Time On Duty
    	    } else if (sh === '17' ) { $(".c17").show();    // County
    	    } else if (sh === '18' ) { $(".c18").show();    // State
    		} else if (sh === '19' ) { $(".c59").show();    // District 
    	    } else if (sh === '20' ) { $(".c20").show();    // Grid
    	    } else if (sh === '21' ) { $(".c21").show();    // Latitude
    	    } else if (sh === '22' ) { $(".c22").show();    // Longitued
            } else if (sh === '23' ) { $(".c23").show();    // Band
            } else if (sh === '24' ) { $(".c24").show();    // W3W
            } else if (sh === '30' ) { $(".c30").show();    // team
            } else if (sh === '31' ) { $(".c31").show();    // aprs_call
            } else if (sh === '32' ) { $(".c32").show();    // Country
            } else if (sh === '33' ) { $(".c33").show();    // facility
            } else if (sh === '34' ) { $(".c34").show();    // onSite    
            } else if (sh === '35' ) { $(".c35").show();    // City     
              // Custom
            } else if (sh === '50' ) { $(".c50").show();    // Cat (Custom)
            } else if (sh === '51' ) { $(".c51").show();    // Section (Custom)
              // Admin Level  
            } else if (sh === '25' ) { $(".c25").show();    // recordID
            } else if (sh === '26' ) { $(".c26").show();    // ID
            } else if (sh === '27' ) { $(".c27").show();    // status
            } else if (sh === '28' ) { $(".c28").show();    // home
            } else if (sh === '29' ) { $(".c29").show();    // ipaddress
	    } // end of if 
} // End of showCol function