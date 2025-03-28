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

<!-- Add the AJAX polling JavaScript -->
<script src="js/NetManagerPolling.js"></script>

<!-- Initialize polling functionality -->
<script>
$(document).ready(function() {
    console.log("Setting up polling override");
    
    // Properly handle the showActivities override
    if (typeof showActivities === 'function') {
        const originalShowActivities = showActivities;
        
        window.showActivities = function(value, name) {
            console.log("Polling-enhanced showActivities called:", value, name);
            // Call the original function first
            originalShowActivities(value, name);
            
            // Then initialize polling if this is a valid net
            if (value && value !== 'a' && value !== 'z') {
                if (typeof initializeSSEForNet === 'function') {
                    initializeSSEForNet(value, name);
                } else {
                    console.error("initializeSSEForNet function not found");
                }
            }
        };
        console.log("showActivities function overridden for real-time updates");
    } else {
        console.error("Original showActivities function not found");
    }
});
</script>

<!-- Add debug button -->
<div style="position: fixed; bottom: 10px; left: 10px; z-index: 9999; background: #f0f0f0; padding: 10px; border: 1px solid #ccc;">
    <button id="polling-debug-btn" style="padding: 5px;">Force Update Check</button>
    <div id="polling-debug-log" style="font-family: monospace; margin-top: 5px;"></div>
</div>

<script>
$(document).ready(function() {
    $('#polling-debug-btn').on('click', function() {
        const netID = currentNetID || '14266'; // Use the current net ID or default
        const debugLog = document.getElementById('polling-debug-log');
        
        debugLog.innerHTML = 'Forcing update...';
        
        // Make an AJAX call to trigger a test update
        $.ajax({
            url: 'force_update.php',
            data: { netID: netID },
            success: function(response) {
                debugLog.innerHTML = 'Update forced: ' + response;
                console.log('Update force response:', response);
                
                // Manually trigger an update check
                if (typeof checkForUpdates === 'function') {
                    setTimeout(checkForUpdates, 500);
                }
            },
            error: function(xhr, status, error) {
                debugLog.innerHTML = 'Error: ' + error;
                console.error('Update force error:', error);
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    // Log the save_sse.php override
    console.log("Save URL overridden to use save_sse.php");
});
</script>

<script>
$(document).ready(function() {
    // Override AJAX calls to save.php
    (function(origOpen) {
        XMLHttpRequest.prototype.open = function(method, url, async, user, pass) {
            // Substitute save_sse.php for save.php
            if (url === 'save.php') {
                console.log('Intercepted request to save.php, redirecting to save_sse.php');
                url = 'save_sse.php';
            }
            origOpen.call(this, method, url, async, user, pass);
        };
    })(XMLHttpRequest.prototype.open);
    
    console.log('XMLHttpRequest.open method overridden for real-time updates');
});
</script>

</body>
</html>