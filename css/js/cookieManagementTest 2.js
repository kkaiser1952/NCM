// This javascript works with the columnPicker.php 
// 2020-02-29 Modified to include time zone selection

/* +++++++ Column Assignments +++++++++++++++++ Admin +++++++++++++++
 Class  Web Name        DB Name           Class  DB Name  
    c1: Role            netcontrol          c25: recordID
    c2: Mode            Mode                c26: ID
    c3: Status          active              c27: status
    c4: Traffic         traffic             c28: home
    c5: TT              tt                  c29: ipaddress
    c6: Call Sign       callsign
    c7: First Name      Fname               
    c8: Last Name       Lname               ++++ Field Day ++++++++
    c9: Tactical        tactical            c50: cat
    c10: Phone          phone               c51: section
    c11: Email          emial
    c12: Time IN        logdate             ++++ No Class Assignments
    c13: Time Out       timeout                   netID
    c14: Comments       comments                  subNetOfID
    c15: Credentials    creds                     activity
    c16: Time On Duty   timeonduty                frequency
    c17: County         county                    netcall
    c18: State          state                     logclosedtime
    c19: District       district                  firstLogin
    c20: Grid           grid                      pb
    c21: Latitude       latitude                  dttm
    c22: Longitude      longitude           
    c23: Band           band
    c24: W3W            w3w
*/

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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
	var arrayALL = [];
	
	var arrayFD = [];
	
	var thelist = "";
	
	// This sets us up to add the email and phone columns automatically if its a meeting or event
		
    var arrayDefault = ["1","2","3","4","6","7","9","12","13","14"];
		
    // This sets us up to add the email and phone columns automatically if its a meeting or event
    if ( $("#activity").html().includes("Meeting") || $("#activity").html().includes("Event") ) {
        var array1011 = ["10","11"]; // for use later in arrayALL
    } else if ($("#activity").html().includes("Weather Net")) {
        var array1011 = ["17","18","24"];
       // alert("array1011: "+JSON.stringify(array1011));
    } else { array1011 = []; }
    
    if ( $("#activity").html().includes("Field Day")) {
            var arrayFD = ["2","18","20","23","50"] ;
        } else { arrayFD = [] ; }
        
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
		} else {
           // myCookie = $("#cookies").html().trim();
            myCookie = "17,18";
            arrayCookies = myCookie.split(',');
        } 

         alert("arrayCookies: "+JSON.stringify(arrayCookies));
        		
    // This hides all the extra columns as preperation for showing only the requested ones below
        $(".c5, .c8, .c10, .c11, .c15, .c16, .c17, .c18, .c19, .c20, .c21, .c22, .c23, .c24").hide();
        $(".c25, .c26, .c27, .c28, .c29").hide(); // Admin Level
        $(".c3, .c4, .c9, c12, .c50, .51").hide(); // Field Day Level
       
      // alert("array1011= "+JSON.stringify(array1011)+"\narrayCookies= "+JSON.stringify(arrayCookies));
       
        var arrayALL = array1011.concat(arrayCookies);
        //alert("all= "+JSON.stringify(array1011));
            //arrayALL = arrayALL.concat(arrayFD); 
            
            
       
        
            //alert("arrayALL= "+JSON.stringify(arrayALL));
			
    // This called function shows all the required columns
        arrayALL.forEach(showCol);
}  // End testCookies()
 
// The showCol function is called from the popup columnPicker.php
function showCol(sh) {
		if            (sh === '5'  ) { $(".c5").show();
            } else if (sh === '3'  ) { $(".c3").show();
            } else if (sh === '4'  ) { $(".c4").show();
            } else if (sh === '5'  ) { $(".c5").show();
            } else if (sh === '7'  ) { $(".c7").show();
    	    } else if (sh === '8'  ) { $(".c8").show();
    	    } else if (sh === '10' ) { $(".c10").show();
    	    } else if (sh === '11' ) { $(".c11").show();
    	    } else if (sh === '15' ) { $(".c15").show();
    	    } else if (sh === '16' ) { $(".c16").show();
    	    } else if (sh === '17' ) { $(".c17").show();
    	    } else if (sh === '18' ) { $(".c18").show();
    		} else if (sh === '19' ) { $(".c19").show();
    	    } else if (sh === '20' ) { $(".c20").show();
    	    } else if (sh === '21' ) { $(".c21").show();
    	    } else if (sh === '22' ) { $(".c22").show();
            } else if (sh === '23' ) { $(".c23").show();
            } else if (sh === '24' ) { $(".c24").show();
              // Field Day
            } else if (sh === '50' ) { $(".c50").show();  
            } else if (sh === '51' ) { $(".c51").show();
              // Admin Level  
            } else if (sh === '25' ) { $(".c25").show();
            } else if (sh === '26' ) { $(".c26").show();
            } else if (sh === '27' ) { $(".c27").show();
            } else if (sh === '28' ) { $(".c28").show();
            } else if (sh === '29' ) { $(".c29").show();
	    } // end of if 
} // End of showCol function