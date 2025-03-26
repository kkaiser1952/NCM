<?php
/**
 * Net Control Manager (NCM) - New Net Form Component
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */
?>
<div id="makeNewNet" class="hidden" >	
    <div style="color: red;">* Required Field</div>
    <!--
    <label class="Testcontainer" for="testnet">Click if making a test net? &nbsp;&nbsp;&nbsp;
        <input id="testnet" type="checkbox" name="testnet" value="y" >
       
    </label>
    -->
    <br>
            
    <div><b style="color:red">*</b>Enter Your Call Sign:</div>   
    <input onblur="checkCall()" type="text" required id="callsign" maxlength="16" name="callsign" autocomplete="on" title="Enter Your Call Sign" >
					
<?php require_once "buildThreeDropdowns.php"; ?>
			     
    <!-- ==== GROUP ======= -->
    <div><b style="color:red">*</b>Select Group or Call:&nbsp;
        <!-- This is like an alert box but uses no javascript -->
        <a href="#GroupQ" class="Qbutton" tabindex="-1">?</a>
        
        <div class="NewLightbox" id="GroupQ">
            <figure>
                <a href="#" class="Qclose"></a>
                <figcaption>Filter the available group calls by typing the name. <br> For example: <b>MESN</b> <br><br> To create your own net simply type a name. <br> For example: <b>My Birthday</b> <br><br> Then in the Kind of Net selection below <br> consider choosing: <b>Event</b> or <b>Test</b>
    
                </figcaption>
            </figure>
        </div> <!-- End of class: NewLightbox -->
    </div> 
    <div id="GroupDropdown" >
        <!-- showGroupCoices() & filterFunctions() at the bottom of index.php -->
        <input type="text" onfocus="showGroupChoices()" placeholder="Type to filter list.." id="GroupInput" style="background-color:white;"
               class="netGroup"  onkeyup="this.value = removeSpaces(this.value); filterFunction(0);" required />
        <div class='GroupDropdown-content hidden'>
            
<?php echo $groupList;?>    <!-- Created in buildThreeDropdowns.php -->
            
        </div> <!-- End GroupDropdown -->
    </div> <!-- End GroupDropdown-content -->
            
    <!-- ==== KIND ======= -->
    <div><b style="color:red">*</b>Select Kind of Net:&nbsp;&nbsp;&nbsp;
        <!-- This is like an alert box but uses no javascript -->
        <a href="#KindQ" class="Qbutton" tabindex="-1">?</a>
        <div class="NewLightbox" id="KindQ">
            <figure>
                <a href="#" class="Qclose"></a>
                <figcaption>If you typed in your own name in the Group selction above <br> then consider choosing <b>Event</b> or <b>Test</b> here.
                </figcaption>
            </figure>
        </div> <!-- End of class: NewLightbox -->
    </div> <!-- End of first div under KIND -->
    
    <div id="KindDropdown" >
    <!-- showKindChoices() & filterFunctions() are in NetManager-p2.js -->
    <input type="text" onfocus="showKindChoices(); blurGroupChoices();" placeholder="Type to filter list.." id="KindInput" 
           class="netGroup" onkeyup="filterFunction(1)"/>
    <div class='KindDropdown-content hidden'>
        
<?php echo $kindList;?>    <!-- Created in buildThreeDropdowns.php -->
       
    </div> <!-- End KindDropdown -->
    </div> <!-- End KindDropdown-content -->
            
    <!-- ==== FREQ ======= -->  
    <div><b style="color:red">*</b>Select the Frequency:</div>
    <div id="FreqDropdown" >
        <!-- showFreqChoices() & filterFunctions() at the bottom of index.php -->
        <input type="text" onfocus="showFreqChoices(); blurKindChoices(); " placeholder="Type to filter list.." id="FreqInput" 
               class="netGroup" onkeyup="filterFunction(2)"/>
        <div class='FreqDropdown-content hidden'>
            
<?php echo $freqList; ?>    <!-- Created in buildThreeDropdowns.php -->
           
        </div> <!-- End FreqDropdown -->
    </div> <!-- End FreqDropdown-content -->
            
    <div class="last3qs">If this is a Sub Net select the<br>open primary net:</div>

    <!-- If any option is selected make the cb1 span (show linked nets) button appear using function showLinkedButton() -->
     <select class="last3qs" id="satNet" title="Sub Net Selections" onfocus="blurFreqChoices(); ">
    	<option value="0" selected>None</option>

<?php require_once "buildSubNetCandidates.php"; ?>

     </select>
				
    <label class="radio-inline last3qs" for="pb">Click to create a Pre-Build Event &nbsp;&nbsp;&nbsp;
        <!-- doalert() & seecopyPB() in NetManager-p2.js -->
        <input id="pb" type="checkbox" name="pb" class="pb last3qs" onchange="doalert(this); seecopyPB(); " />
    </label>
    
    <div class="last3qs">Complete New Net Creation:</div>
    
    <br>
    <!-- newNet() & hideit() createNetKindView() in NetManager-p2.js -->
    <!-- I removed createNetKindView() on 2023-04-16 don't think we need it -->
    <input id="submit" type="submit" value="Submit" onClick="newNet();" title="Submit The New Net">
    <input class="" type="button" value="Cancel" onclick="hideit();" title="Cancel">
			   
</div>	    <!-- End of makeNewNet -->