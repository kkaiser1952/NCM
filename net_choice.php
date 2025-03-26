<?php
/**
 * Net Control Manager (NCM) - Net Choice Component
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */
?>
<div id="org" class="hidden"></div> <!-- Used by putInGroupInput() in NetManager-p2.js  -->
<div id="netchoice">
    <div id="netdata">
        
    <!-- Use the <p> below to add a short message at the top of NCM. This span is hidden in NetManager.js , It's unhidden in the newnet() current in this file -->
    
        <p class="sparkle-text">Please report any issues to NCM@groups.io Thank you.
          <span class="spark1"></span>
          <span class="spark2"></span>
          <span class="spark3"></span>
          <span class="spark4"></span>
          <span class="spark5"></span>
          <span class="spark6"></span>
          <span class="spark7"></span>
          <span class="spark8"></span>
        </p>
    
        <p class="tb1 TipBubbles initiallyHidden" style="left: 100px; width: 450px;  margin-bottom: 50px;">
            <a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Click to start a new net or display an active or closed net.</a>
        </p> <!-- End TipBubbles -->
        
        <div class="theBox">
            <!-- showit() in NetManager.js -->
            <button id="newbttn" class="newbttn left-cell tbb2" onclick="showit();" title="Click to start a new net">Start a new net</button>    
        
            <button id="by_number" style="left:25px;" class="newbttn" onclick="net_by_number();" title="Net by the Number">Browse a Net by Number</button>
            <br><br>    
        </div>
        
        <?php require_once "new_net_form.php"; ?>
        
        <div id="remarks" class="remarks hidden"></div>
        
    <!-- Building the upper right corner is triggered by: showActivities() in NetManager.js -->
    <p class="tb2 TipBubbles initiallyHidden" style="width: 400px; left: 200px; margin-bottom: -40px;">
        <a class="tipimage" href="https://net-control.us/help.php#open" target="_blank">Dropdown of nets and/or current net being displayed.</a></p>
        
    <p class="tb2 TipBubbles initiallyHidden" style="width: 300px; left: 775px; margin-bottom: 40px;">
        <a class="tipimage" href="https://net-control.us/help.php#refreshtimed" target="_blank">Immediate and Timed Data Refresh</a></p>
    
    <p class="tb1 TipBubbles initiallyHidden" style="left: 200px; width: 450px;  margin-bottom: 50px;">
        <a class="tipimage" href="https://net-control.us/help.php#assumptions" target="_blank">Select to display an active or closed net.</a></p>
        
        <div class="btn-toolbar" >
        
            <div class="form-group" id="form-group-1" title="form-group" >
            
            <!-- switchClosed() in NetManager-p2.js -->
            <!-- The tohide class is used by net_by_num() -->
            
        <!--    <label for="select1">Or make a selection from this dropdown</label>  -->
        
        <select id="select1" data-width='auto' class="tohide form-control selectpicker selectdd" name="activities" 
            onchange="showActivities(this.value, this.options[this.selectedIndex].innerHTML.trim()); switchClosed();  ">
                
            <option class="tohide pbWhite firstValue" value="a" selected disabled >Or Select From Past 10 Days Nets</option>
            
            <option class ="tohide opcolors" value="z" disabled>Open Nets are in green =================//================= Pre-built Nets are in blue</option>
 
            <option class="tohide newAfterHere" data-divider="true">&nbsp;</option>
            
<!-- PHP to build the list of nets from the last 10 days -->
<?php require_once "buildOptionsForSelect.php"; ?>
            
        </select>     <!-- End of ID: select1 -->
        
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
        
        <button class="btn btn-warning" style="float: right; margin-left: 10px; border-radius: 20px; background-color: #f8e58c; color: #000;" onclick="toggleExpand()">Buy Me a Coffee</button>
        
        </div> <!-- End div-form-group -->
        
        <!-- Add the donation popup content -->
        <div class="donation-content" style="display: none; position: absolute; z-index: 1000; right: 10px; top: 120px; background: white; border: 1px solid #ccc; padding: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
            <div style="text-align: right; margin-bottom: 5px;">
                <button style="background: none; border: none; cursor: pointer; font-size: 16px;" onclick="toggleExpand()">✕</button>
            </div>
            <div class="amount-buttons">
                <button class="amount-btn" data-amount="3">$3</button>
                <button class="amount-btn selected" data-amount="5">$5</button>
                <button class="amount-btn" data-amount="10">$10</button>
            </div>

            <div class="payment-methods">
                <button class="payment-btn" data-method="paypal" data-link="https://paypal.me/KeithKaiser/">PayPal</button>
                <button class="payment-btn" data-method="venmo" data-link="https://venmo.com/KeithKaiser">Venmo</button>
            </div>

            <button class="donate-btn" onclick="handleDonate()">Donate $5</button>
        </div>
    </div> <!-- End btn-toolbar -->

    <div id="forcb1" class="hidden">
        <p class="tb2 TipBubShort initiallyHidden" style="width:300px; left: 350px; margin-bottom: 25px;">
            <a class="tipimage" href="https://net-control.us/help.php#advanced" target="_blank">Hover/Click here to add General Comments</a></p>
            
        <div id="genComments" class=" editGComms"></div>

    </div>   <!-- End ID: forcb1 -->
      <!-- End of besticky -->
      
      <!-- Tip Bubbles -->
     <p class="tb2 TipBubbles initiallyHidden" style="width:300px; left: 50px; margin-bottom: -40px;">
         <a class="tipimage" href="https://net-control.us/help.php#checkins" target="_blank">Enter Callsign or name displays hints</a></p>
     <p class="tb2 TipBubbles initiallyHidden" style="width:150px; left: 455px; margin-bottom: -40px;">
         <a class="tipimage" href="https://net-control.us/help.php#checkins" target="_blank">Traffic Short Cut</a></p>
     <p class="tb2 TipBubbles initiallyHidden" style="width:250px; left: 655px; margin-bottom: -40px;">
         <a class="tipimage" href="https://net-control.us/help.php#additionalColumns" target="_blank"> Select Columns for display</a></p>
     <p class="tb2 TipBubbles initiallyHidden" style="width:350px; left: 950px; margin-bottom: 40px;">
         <a class="tipimage" href="https://net-control.us/help.php#timeline" target="_blank">Command Bar with Time Line and Net Status buttons</a></p>
    </div>  <!-- End div-netdata -->