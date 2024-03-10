<!doctype html>

<?php

    
?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  
  
<style>
    
/* https://www.w3schools.com/howto/howto_css_more_button.asp */
/* Add responsiveness - display the form controls vertically instead of horizontally on screens that are less than 800px wide */
@media (max-width: 800px) {
.form-inline input {
    margin: 10px 0;
}

.form-inline {
    flex-direction: column;
    align-items: stretch;
}

}

/* Style the form - display items horizontally */
.form-inline { 
    display: flex;
    flex-flow: row wrap;
    /*align-items: center; */
}

/* Style the input fields */
.form-inline input {
    width: 7%;
    vertical-align: middle;
    padding: 5px 10px;
    background-color: #fff;
    border: 1px solid #000;
    border-radius: 10px;
    font-size: 12pt;
    
}

/* Style the submit button */
.form-inline button {
    padding: 5px 10px;
    background-color: dodgerblue;
    color: darkblue;
    border-radius: 10px;
    font-size: 12pt;
    border: 1px solid #000;
    width: auto;
}

.form-inline button:hover {
    background-color: royalblue;
    color: darkblue;
}

#primeNav {
    overflow: hidden;
    font-family: Arial;
    background-color: #d1cbf4;
    height: auto;
    font-weight: bold;
    text-align: center;
    border-radius: 10px;
    padding: 5px;
    border: 2px solid #7804fc;
    min-width: 1000px;
    width: 98%;
}

.form-inline .ckin1 {
    background-color:lightgreen;
    float: left;
    margin-left: 10px;
}
.form-inline .ckin1:hover {
    background-color:green;
    color: white;
}

.form-inline .showhideBTN {
    background-color:salmon;
    float: left;
    margin-left: 10px;
}
.form-inline .showhideBTN:hover {
    background-color:#b21605;
    color: white;
}

.form-inline .cs1 {
    float: left;
    margin-left: 10px;
    border: 1px solid #000; 
    
}
.form-inline .cs1:hover {
    float: left;
    margin-left: 10px;
    border: 1px solid #ddd; 
}
.form-inline .Fname {
    float: left;
    margin-left: 10px;
    border: 1px solid #000;
}

.form-inline .Fname:hover {
    float: left;
    margin-left: 10px;
    border: 1px solid #ddd;
}

.primeNav a {
  float: left;
  font-size: 12px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}



/* The dropdown container */
.form-inline .dropdown {
    float: left;
    overflow: hidden;
    
  display: inline-block;
}

/* Dropdown button */
.form-inline .timelineBut {
    background-color: #949191;
    font-size: 12px; 
    border: 1px solid #000;
    float: left;
    margin-left: 10px;
}

.form-inline .primeNav a:hover, .dropdown:hover {
  background-color: red;
}
.form-inline .dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.form-inline .dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.form-inline .dropdown-content a:hover {
  background-color: #ddd;
}

.form-inline .dropdown:hover .dropdown-content {
  display: block;
}


</style>
</head>
<body>

<form class="form-inline" action="">

<div id="primeNav"> 

			<input id="cs1" class="cs1" type="text" placeholder="Call or First Name" maxlength="12" autofocus="autofocus" autocomplete="off" > 
			
			<input type="hidden" id="hints">
			
			<input id="Fname" class="Fname" type="text" placeholder="Name" onblur="checkIn();" autocomplete="off">
			
			<button class="ckin1" onclick="checkIn()">Check In</button>
			
	<!--		<input id="fieldday" class="hidden" style="text-transform: uppercase;" type="text" placeholder="Category"  autocomplete="off">
			<input id="section" class="hidden" style="text-transform: uppercase;" type="text" placeholder="Section" onblur="checkFD(); this.value=''" maxlength="4" size="4"> 
-->
    		    
            <button class="showhideBTN" id="columnPicker">Show/Hide Columns</button>
            
            <div class="dropdown">
              <button class="timelineBut">Time Line</button>
              <div class="dropdown-content">
                <a href="#">Show</a>
                <a href="#">Update</a>
                <a href="#">Close</a>
              </div>
            </div>
            
    		  
    <!--		    <button class=" hidden copyPB hidden" id="copyPB">Copy a Pre-Built</button> -->
    		    <button class="closenet" id="closelog" oncontextmenu="rightclickundotimeout();return false;" >Close Net</button>

</div>	<!-- id="primeNav" class="flashit" -->
	
</form>
</body>
</html>