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
$(document).ready(function() {
    let currentNetID = null;
    let eventSource = null;
    let lastLocalUpdate = 0;
    
    // Add update indicator
    $("<div id='update-status'>")
        .css({
            position: 'fixed',
            top: '10px',
            right: '10px',
            background: '#5cb85c',
            color: 'white',
            padding: '5px 10px',
            borderRadius: '5px',
            display: 'none',
            zIndex: 9999
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
        stopWatching(); // Clear any existing connection
        
        currentNetID = netID;
        console.log("Started watching net ID:", netID);
        
        // Show indicator
        $("#update-status").fadeIn();
        
        // Create SSE connection
        eventSource = new EventSource(`sse_stream.php?netID=${netID}`);
        
        // Handle updates
        eventSource.addEventListener('update', function(e) {
            const data = JSON.parse(e.data);
            console.log("SSE Update received:", data);
            
            // Only refresh if this is a new update (and not one we just made)
            const updateTime = data.timestamp * 1000; // Convert to milliseconds
            const now = Date.now();
            const timeSinceUpdate = now - updateTime;
            
            // If the update is more than 2 seconds old, it's probably not one we just made
            if (timeSinceUpdate > 2000 && updateTime > lastLocalUpdate) {
                console.log("Update from another user, refreshing activity view...");
                $("#update-status")
                    .css('background-color', '#d9534f')
                    .text("Changes detected! Refreshing...")
                    .fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
                
                // Simply call the original showActivities function again with the same netID
                // This will refresh the entire activity view without reloading the page
                originalShowActivities(currentNetID, null);
                
                // Update the timestamp
                lastUpdate = data.timestamp;
                
                // Show success message after a delay
                setTimeout(function() {
                    $("#update-status")
                        .css('background-color', '#5cb85c')
                        .text("Updated successfully!");
                }, 2000);
            } else {
                console.log("Ignoring update (likely our own or too recent)");
            }
        });
        
        // Handle errors
        eventSource.onerror = function(e) {
            console.error("SSE connection error:", e);
            $("#update-status")
                .css('background-color', '#d9534f')
                .text("Connection lost, reconnecting...");
            
            // Try to reconnect after a delay
            setTimeout(function() {
                if (currentNetID) {
                    startWatching(currentNetID);
                }
            }, 5000);
        };
    }
    
    function stopWatching() {
        if (eventSource) {
            eventSource.close();
            eventSource = null;
            console.log("Stopped watching net");
        }
        
        $("#update-status").fadeOut();
    }
    
    // Track when we make our own updates
    $(document).ajaxSend(function(event, jqxhr, settings) {
        if (settings.url && (
            settings.url.includes('save_sse.php') || 
            settings.url.includes('save.php')
        )) {
            // Record the time of our own update
            lastLocalUpdate = Date.now();
            console.log("Tracking local update at:", lastLocalUpdate);
        }
    });
});
</script>
</body>
</html>