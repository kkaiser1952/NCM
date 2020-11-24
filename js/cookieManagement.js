// Cache Selector Elements for faster processing 
// use like this:    $lli.addClass('active').show();   drop the $("#lli") from the call

//$(document).ready(function() {
/*
	$c5		= $('.c5');
	$c8		= $('.c8');
	$c10		= $('.c10');
	$c11		= $('.c11');
	$c15		= $('.c15');
	$c16		= $('.c16');
	$c17		= $('.c17');
	$c18		= $('.c18');
	$c19		= $('.c19');
	$c20		= $('.c20');
	$c21		= $('.c21');
	$c22		= $('.c22');
*/
//}); // End ready function a top


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

function eraseCookie(name) {
	setCookie(name, "", -1);
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
	var totalCheckboxes   = $('input:checkbox').length;			//alert("2 tot= "+totalCheckboxes);				     // 23
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
	var spcl = ($('select[name="activities"] :selected').attr('class').trim());  //alert("spcl = "+spcl);
		if (spcl.includes('spcl')) { 	// its an event or meeting
			var array1011 = [10,11]; // for use later in arrayBoth
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
            myCookie = "17,18";
            arrayCookies = myCookie.split(',');
        } 

        // alert("arrayCookies: "+JSON.stringify(arrayCookies));
        		
    // This hides all the extra columns as preperation for showing only the requested ones below
        $(".c5, .c8, .c10, .c11, .c15, .c16, .c17, .c18, .c19, .c20, .c21, .c22").hide();
       
      // alert("array1011= "+JSON.stringify(array1011)+"\narrayCookies= "+JSON.stringify(arrayCookies));
       
        var arrayBoth = array1011.concat(arrayCookies);
        //    alert("arrayBoth= "+JSON.stringify(arrayBoth));
			
    // This called function shows all the required columns
        arrayBoth.forEach(showCol);
}  // End testCookies()
 
// The toggleCol function is called from the popup columnPicker.php
function showCol(sh) {
	//if (!sh) {  
	//	} else {
			if (sh === '5' ) 		 { $(".c5").show();
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
		    } else if (sh === '22' ) { $(".c22").show();}
	//	} // end else
} // End of toggleCol function