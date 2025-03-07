<?php
/**
 * main-content.php - Main content area with net selection and display
 */
?>
<main>
        
 	<div id="org" class="hidden"></div> <!-- Used by putInGroupInput() in NetManager-p2.js  -->
    <div id="netchoice">
	<div id="netdata">
    	
    <!-- Use the <p> below to add a short message at the top of NCM. This span is hidden in NetManager.js , It's unhidden in the newnet() current in this file -->
	
	<p style="margin-bottom:20px; font-size: 14pt;">**This is a work in progress, this upgrade to NCM not yet ready for use.<br>Please click here for a working verson; <a href="https://net-control.space">https://net-control.space</p>
    	
            
    <!-- Start a new net or look at an old net -->        
	<div class="theBox">
		<!-- showit() in NetManager.js -->
		<button id="newbttn" class="newbttn left-cell tbb2" onclick="showit();" title="Click to start a new net">Start a new net</button>	
    
		<button id="by_number" style="left:25px;" class="newbttn" onclick="net_by_number();" title="Net by the Number">Browse a Net by Number</button>
		<br><br>	
	</div>
		
    <!-- New net form - included separately -->
    <?php include 'new-net-form.php'; ?>
	    
	    <div id="remarks" class="remarks hidden"></div> 
        
        <div class="btn-toolbar" >
        
		    <div class="form-group" id="form-group-1" title="form-group" >
    	
    	<!-- When a net is selected from this dropdown, showActivities() is triggered.
         This function fetches the net data, populates the UI with net information,
         and sets up interactive features including real-time updates via SSE.
         It's the central function that prepares the entire interface for managing the selected net. -->
        <select id="select1" data-width='auto' class="tohide form-control selectpicker selectdd" name="activities" 
	        onchange="showActivities(this.value, this.options[this.selectedIndex].innerHTML.trim()); switchClosed();  ">
	        	
	        <option class="tohide pbWhite firstValue" value="a" selected disabled >Or Select From Past 10 Days Nets</option>
	        
	        <option class ="tohide opcolors" value="z" disabled>Open Nets are in green =================//================= Pre-built Nets are in blue</option>
 
            <option class="tohide newAfterHere" data-divider="true">&nbsp;</option>
            
            <?php echo $selectOptions ?> <!-- Last 10 Days only -->
        	
        </select>  	<!-- End of ID: select1 -->
		
<! this may go away or at lest the timed part will -->
<div class="btn-group">	
    <button id="refbutton" class="btn btn-info btn-small hidden" >Refresh</button>
    
    <button id="refrate" class="btn btn-small btn-info dropdown-toggle hidden" 
    		data-toggle="dropdown" type="button">
        Timed
    	<span class="caret"></span>
    </button>
    	    
    <!-- Refresh timer selection -->
    <ul id="refMenu" class="dropdown-menu">
      <li><a href="#" data-sec="M" >Manual</a></li>
      <li class="divider"></li>
      <li><a href="#" data-sec="10" >5s</a></li>
      <li><a href="#" data-sec="10">10s</a></li>
      <li><a href="#" data-sec="30">30s</a></li>
      <li><a href="#" data-sec="60">60s</a></li>
    </ul>	    
</div>  <!-- /btn-group -->

		    </div> <!-- End div-form-group -->
        </div> <!-- End btn-toolbar -->
	</div>  <!-- End div-netdata -->
        
        
    <!-- General Comments control here -->    
    <!-- Edited and saved to DB by CellEditFunctions.js and SaveGenComm.php -->
    <!-- A general pupose entry point for text, it's put into the time line table -->
    <!-- This is activated by a jquery on function in netManager.js at about line 391 -->
    
	<div id="forcb1" class="hidden">
        	
		<div id="genComments" class=" editGComms"></div>

	</div>   <!-- End ID: forcb1 -->