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
    let isEditing = false;
    let updatePending = false;
    let reconnectAttempts = 0;
    
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
        
        try {
            // Create SSE connection
            eventSource = new EventSource(`sse_stream.php?netID=${netID}&t=${Date.now()}`);
            
            // Connection opened
            eventSource.onopen = function() {
                console.log("SSE connection opened successfully");
                $("#update-status")
                    .css('background-color', '#5cb85c')
                    .text("Watching for updates...");
                reconnectAttempts = 0;
            };
            
            // Handle updates
            eventSource.addEventListener('update', function(e) {
                const data = JSON.parse(e.data);
                console.log("SSE Update received:", data);
                
                // Check if this is likely our own update
                const updateTime = data.timestamp * 1000; // Convert to milliseconds
                const now = Date.now();
                const timeSinceUpdate = now - updateTime;
                const isOurUpdate = timeSinceUpdate <= 2000 || updateTime <= lastLocalUpdate;
                
                if (isOurUpdate) {
                    console.log("Ignoring our own update");
                    return;
                }
                
                // If user is currently editing, mark update as pending
                if (isEditing) {
                    updatePending = true;
                    $("#update-status")
                        .css('background-color', '#f39c12')
                        .text("Update pending - finish editing first");
                    console.log("Update pending - waiting for editing to complete");
                } else {
                    // Otherwise, perform the update immediately
                    performUpdate();
                }
            });
            
            // Handle errors
            // Modify the onerror handler for the EventSource
eventSource.onerror = function(e) {
    console.error("SSE connection error:", e);
    
    // Only attempt reconnection if the connection is closed
    if (this.readyState === EventSource.CLOSED) {
        $("#update-status")
            .css('background-color', '#d9534f')
            .text("Connection lost, reconnecting...");
        
        // Close the connection
        eventSource.close();
        
        // Attempt to reconnect after a delay
        setTimeout(function() {
            if (currentNetID) {
                console.log("Attempting to reconnect...");
                startWatching(currentNetID);
            }
        }, 2000);
    }
};
        } catch (e) {
            console.error("Error creating EventSource:", e);
            $("#update-status")
                .css('background-color', '#d9534f')
                .text("Connection error - check console");
        }
    }
    
    function performUpdate() {
        console.log("Performing update");
        $("#update-status")
            .css('background-color', '#d9534f')
            .text("Changes detected! Refreshing...")
            .fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
        
        // Refresh the activity view
        if (typeof originalShowActivities === 'function') {
            originalShowActivities(currentNetID, null);
        } else {
            console.error("originalShowActivities is not a function", originalShowActivities);
            // Fallback - reload the page
            window.location.reload();
        }
        
        // Reset pending flag
        updatePending = false;
        
        // Show success message after a delay
        setTimeout(function() {
            $("#update-status")
                .css('background-color', '#5cb85c')
                .text("Updated successfully!");
        }, 2000);
    }
    
    function stopWatching() {
        if (eventSource) {
            eventSource.close();
            eventSource = null;
            console.log("Stopped watching net");
        }
        
        $("#update-status").fadeOut();
    }
    
    // Track when editing starts
    $(document).on('mouseenter focus', '.editable', function() {
        isEditing = true;
        console.log("Editing active - pausing updates");
        
        if (updatePending) {
            $("#update-status")
                .css('background-color', '#f39c12')
                .text("Update pending - finish editing first");
        } else {
            $("#update-status")
                .css('background-color', '#f39c12')
                .text("Editing active - updates paused");
        }
    });
    
    // Track when editing ends (mouse leaves or focus lost)
    $(document).on('mouseleave blur', '.editable', function() {
        // Short delay before marking editing as complete
        setTimeout(function() {
            // Only mark as not editing if no other element has focus
            if (!$('.editable:focus').length) {
                isEditing = false;
                console.log("Editing complete - resuming updates");
                
                // If an update is pending, perform it now
                if (updatePending) {
                    performUpdate();
                } else {
                    $("#update-status")
                        .css('background-color', '#5cb85c')
                        .text("Watching for updates...");
                }
            }
        }, 1000);
    });
    
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
    
    // Setup heartbeat to keep the connection alive
    setInterval(function() {
        if (!eventSource || eventSource.readyState !== 1) {
            console.log("Connection not open, attempting to reconnect");
            if (currentNetID) {
                startWatching(currentNetID);
            }
        }
    }, 60000); // Check connection every minute
});
</script>
</body>
</html>