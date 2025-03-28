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
// Add this to indexSSE.php
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
        console.log("Enhanced showActivities called:", value, name);
        originalShowActivities(value, name);
        
        if (value && value !== 'a' && value !== 'z') {
            console.log("Starting to watch net:", value);
            startWatching(value);
        } else {
            console.log("Not watching net:", value);
            stopWatching();
        }
    };
    
    function startWatching(netID) {
        stopWatching(); // Clear any existing interval
        
        currentNetID = netID;
        lastUpdate = ''; // Reset
        console.log("Started watching net ID:", netID);
        
        // Show indicator
        $("#update-status").fadeIn();
        
        // First check
        checkForUpdates();
        
        // Start checking every 5 seconds
        checkInterval = setInterval(checkForUpdates, 5000);
    }
    
    function stopWatching() {
        if (checkInterval) {
            clearInterval(checkInterval);
            checkInterval = null;
            console.log("Stopped watching net");
        }
        
        $("#update-status").fadeOut();
    }
    
    function checkForUpdates() {
        if (!currentNetID) return;
        
        console.log("Checking for updates on net ID:", currentNetID);
        
        $.ajax({
            url: 'check_net_updates.php',
            data: {
                netID: currentNetID,
                lastUpdate: lastUpdate
            },
            success: function(data) {
                console.log("Update check response:", data);
                
                // First time, just store the update time
                if (lastUpdate === '') {
                    lastUpdate = data.last_update;
                    console.log("First check, stored timestamp:", lastUpdate);
                    return;
                }
                
                // If changes detected
                if (data.hasChanges) {
                    console.log("Changes detected! Old:", lastUpdate, "New:", data.last_update);
                    
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
                                console.log("Activity log refreshed");
                                
                                // Extract activity log
                                const tempDiv = document.createElement('div');
                                tempDiv.innerHTML = html;
                                
                                const actLog = tempDiv.querySelector('#actLog');
                                if (actLog) {
                                    $("#actLog").html(actLog.innerHTML);
                                    console.log("Activity log updated");
                                    
                                    // Update timestamp
                                    lastUpdate = data.last_update;
                                    
                                    // Show success message
                                    $("#update-status")
                                        .css('background-color', '#5cb85c')
                                        .text("Updated successfully!");
                                } else {
                                    console.error("Could not find activity log in response");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error refreshing activity log:", error);
                            }
                        });
                    }, 500);
                } else {
                    console.log("No changes detected");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error checking for updates:", error, xhr.responseText);
                
                // Try to parse the error response
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    console.error("Server error details:", errorResponse);
                } catch (e) {
                    console.error("Could not parse error response");
                }
            }
        });
    }
});
</script>
</body>
</html>