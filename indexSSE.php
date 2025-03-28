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

<script>
// Simple SSE implementation
// Add to indexSSE.php
$(document).ready(function() {
    let currentNetID = null;
    let lastUpdate = '';
    let checkInterval = null;
    
    // Add indicator
    $("<div id='update-status'>")
        .css({
            position: 'fixed',
            top: '10px',
            right: '10px',
            background: '#5cb85c',
            color: 'white',
            padding: '5px 10px',
            borderRadius: '5px',
            display: 'none'
        })
        .text("Watching for updates...")
        .appendTo("body");
    
    // Override showActivities
    const originalShowActivities = window.showActivities;
    window.showActivities = function(value, name) {
        originalShowActivities(value, name);
        
        if (value && value !== 'a' && value !== 'z') {
            startWatching(value);
        } else {
            stopWatching();
        }
    };
    
    function startWatching(netID) {
        stopWatching(); // Clear any existing interval
        
        currentNetID = netID;
        lastUpdate = ''; // Reset
        
        // Show indicator
        $("#update-status").fadeIn();
        
        // First check
        checkForUpdates();
        
        // Start checking every 3 seconds
        checkInterval = setInterval(checkForUpdates, 3000);
    }
    
    function stopWatching() {
        if (checkInterval) {
            clearInterval(checkInterval);
            checkInterval = null;
        }
        
        $("#update-status").fadeOut();
    }
    
    function checkForUpdates() {
        if (!currentNetID) return;
        
        $.ajax({
            url: 'check_net_updates.php',
            data: {
                netID: currentNetID,
                lastUpdate: lastUpdate
            },
            success: function(data) {
                // First time, just store the update time
                if (lastUpdate === '') {
                    lastUpdate = data.lastUpdate;
                    return;
                }
                
                // If changes detected
                if (data.hasChanges) {
                    // Flash indicator
                    $("#update-status")
                        .css('background-color', '#d9534f')
                        .text("Changes detected! Refreshing...")
                        .fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
                    
                    // Refresh after a short delay
                    setTimeout(function() {
                        // Refresh just the activity log
                        $.ajax({
                            url: 'getactivities.php',
                            data: { q: currentNetID },
                            success: function(html) {
                                // Extract activity log
                                const tempDiv = document.createElement('div');
                                tempDiv.innerHTML = html;
                                
                                const actLog = tempDiv.querySelector('#actLog');
                                if (actLog) {
                                    $("#actLog").html(actLog.innerHTML);
                                    
                                    // Update timestamp
                                    lastUpdate = data.lastUpdate;
                                    
                                    // Show success message
                                    $("#update-status")
                                        .css('background-color', '#5cb85c')
                                        .text("Updated successfully!");
                                }
                            }
                        });
                    }, 500);
                }
            }
        });
    }
});
</script>
</body>
</html>