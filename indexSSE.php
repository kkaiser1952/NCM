<?php
// index.php for .us - SSE Version
/***********************************************************************************************************
 
 /**
 * Net Control Manager (NCM) - Version 1 - SSE Enhanced
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 * 
 * This is the SSE-enhanced version of the Net Control Manager
 * providing real-time updates without page refreshes.
 */
	
require_once "dependencies.php";
require_once "header.php";
?>

<body>

<?php 
// Main components
require_once "opening_images.php";
require_once "datetime.php";
require_once "weather.php";
require_once "navigation.php";
require_once "net_choice.php";
require_once "tipbubbles.php";
require_once "admin_section.php";
require_once "modals.php";

// Standard footer
require_once "footer.php";
?>

<!-- Add the SSE-specific JavaScript after the main scripts -->
<script src="js/NetManagerSSE.js"></script>

<!-- Initialize SSE functionality -->
<script>
$(document).ready(function() {
    // Override the showActivities function to initialize SSE
    const originalShowActivities = window.showActivities;
    
    window.showActivities = function(value, name) {
        // Call the original function first
        originalShowActivities(value, name);
        
        // Then initialize SSE if this is a valid net
        if (value && value !== 'a' && value !== 'z') {
            initializeSSEForNet(value, name);
        }
    };
});
</script>

</body>
</html>