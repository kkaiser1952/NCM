<!-- ************************  JAVASCRIPT LIBRARIES  ******************************************** -->	
	
    <!-- jquery updated from 3.4.1 to 3.5.1 on 2020-09-10 3.5.1 to 3.6.0 on 2022-06-04-->
    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<script src="bootstrap/js/bootstrap.min.js"></script>		    <!-- v3.3.2 --> 
 
	<script src="js/jquery.freezeheader.js"></script>				<!-- v1.0.7 -->
	<script src="js/jquery.simpleTab.min.js"></script>				<!-- v1.0.0 2018-1-18 -->
	
	<!-- jquery-modal updated from 0.9.1 to 0.9.2 on 2019-11-14 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script> 

	<script src="bootstrap/js/bootstrap-select.min.js"></script>				<!-- v1.12.4 2018-1-18 -->
	<script src="bootstrap/js/bootstrap-multiselect.js"></script>				<!-- 2.0 2018-1-18 -->

    <!-- http://www.appelsiini.net/projects/jeditable -->
    <script src="js/jquery.jeditable.js"></script>							    <!-- 1.8.1 2018-04-05 -->

	<script src="js/sortTable.js"></script>										<!-- 2 2018-1-18 -->
	<script src="js/hamgridsquare.js"></script>									<!-- Paul Brewer KI6CQ 2014 -->
	<script src="js/jquery.countdownTimer.js"></script>							<!-- 1.0.8 2018-1-18 -->
	
	<script src="js/w3data.js"></script>										<!-- 1.31 2018-1-18 -->
	
	<!-- Updated from 1.12.1 on 3/21/22 -->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.1/jquery-ui.min.js"></script>
	
<!-- My javascript -->	
<!--    <script src="js/showActivities.js"></script> -->
    <script src="js/NetManager-W3W-APRS.js"></script> <!-- Added on 2024-02-21 -->
	<script src="js/NetManager.js"></script>          <!-- NCM Primary Javascrip 2018-1-18 -->
	<script src="js/NetManager-p2.js"></script>	      <!-- Part 2 of NCM Primary Javascript 2018-1-18 -->
	
	
	<script src="js/CellEditFunction.js"></script>	 <!-- Added 2018-02-12 -->
	
	<script src="js/grid.js"></script>
	<script src="js/gridtokoords.js"></script>
	<script src="js/cookieManagement.js"></script>
	
	<script src="js/coffee.js"></script>
    <script>
// function to handled dialog modal for the question mark in circle at time line & other places
// https://www.tutorialspoint.com/jqueryui/jqueryui_dialog.htm
$ ( function() {
    $( "#q-mark-in-circle" ).dialog({
        autoOpen:false, 
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
               title: "Search Advisory:",
               position: {
                  my: "center",
                  at: "center"
               }
    });
                                     
    $( "#QmarkInCircle" ).click(function() {
        $( "#q-mark-in-circle" ).dialog( "open" );
    });
}); // end click @ #q-mark-in-circle()



(function() {

    var quotes = $(".quotes"); //variables
    var quoteIndex = -1;
    
    function showNextQuote() {
        ++quoteIndex;  //increasing index
        quotes.eq(quoteIndex % quotes.length) //items ito animate?
            .fadeIn(6500) //fade in time
            .delay(250) //time until fade out
            .fadeOut(5800, showNextQuote); //fade out time, recall function
    }
    showNextQuote();  
})();

$("body").click(function(){
    $(".quotes").addClass("hidden");
    $(".preQuote").addClass("hidden");
});


// This javascript function tests the callsign being used to start a new net as to being in a list of callsigns that did not close a previous net.
function checkCall() {
    const cs = $("#callsign").val().trim().toUpperCase();
    const listOfCalls = new Set( ['ah6ez' ]);
    const isCallInSet = listOfCalls.has($("#callsign").val());
    
    console.log('@755 in index.php cs: '+cs+'  listOfCalls: '+listOfCalls+'  isCallInSet:  '+isCallInSet);
    
    // If the callsign starting this net is in the above list then ask for his email to send him a message
    if (!isCallInSet == '') {
        var mail = prompt('Please enter your email address.');
            if (mail == '' || mail == null) {
                alert("Please be sure to close your net when finished. Thank you!");
            } else {

                var str = cs+":"+mail;  //alert(str);
                console.log('@737 str= '+str);
            
                $.ajax({
                    type: 'GET',
                    url: 'addEmailToStations.php',
                    data: {q: str},
                    success: function(response) { 
                        //alert(response);
                } // end success
                }) // end ajax
                } // else 
        // Possible ways to send an email
        // Javascript:  https://smtpjs.com
        // PHP:         https://www.w3schools.com/php/func_mail_mail.asp
        // AJAX:        Put the collected email into his record in the stations table.
    } // End if
} // end checkCall function

// This function is used in the DIV GroupDropdown by the input **** DO NOT DELETE ++++
function removeSpaces(str) {
  return str.replace(/\s+/g, '');
}

document.addEventListener('keydown', function(event) {
  if (isTabletDevice() && event.shiftKey && event.key === 'Shift') {
    // Right shift key is being held down on a tablet device
    // Perform the desired action or trigger the right-click event
    event.preventDefault(); // Prevent the default shift key behavior if needed
    
    // Example: Trigger a custom right-click event on the target element
    var targetElement = event.target;
    var customRightClickEvent = new MouseEvent('contextmenu', {
      bubbles: true,
      cancelable: true,
      view: window,
      button: 2,
      buttons: 2,
      clientX: targetElement.getBoundingClientRect().left,
      clientY: targetElement.getBoundingClientRect().top
    });
    targetElement.dispatchEvent(customRightClickEvent);
  }
});

function isTabletDevice() {
  var userAgent = navigator.userAgent.toLowerCase();
  console.log('User Agent:', userAgent); // Log the user agent string
  return /ipad|android|android 3.0|xoom|sch-i800|playbook|tablet|kindle/i.test(userAgent);
}

function toggleExpand() {
    var content = document.querySelector('.donation-content');
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
    } else {
        content.style.display = 'none';
    }
}
</script>