<?php
// The following is used in checkin.php and getactivities.php
    
     $os 	    = array("PRM", "2nd", "3rd", "LSN", "Log", "PIO", "EM", "SEC", "RELAY", "CMD", "TL", "======", "Capt"); // netcontrol
     $digimodes = array("Dig","D*","Echo","V&D","FSQ","DMR","Fusion"); // Mode
     $mobilemode= array("Mob","HT"); // Mode
     $statmodes = array("In-Out","OUT"); // active
     $netTypes  = array('Emergency','Priority','Welfare','Routine','Question','Announcement','Comment','Bulletin',
		    'Pending','Traffic'); // traffic  sent and resolved revert to original color so not listed here
     $band = array("160m","80m","60m","40m","30m","20m","17m","15m","12m","10m","6m","2m","1.25m","70cm","33cm","23cm","FRS/GMRS","CB");
?>