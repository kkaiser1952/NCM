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
    let refreshCounter = 0;
    console.log("%c=== UPDATE CHECK ===", "background-color: #3498db; color: white; padding: 5px;");
    console.log("Checking for updates on net ID:", currentNetID);
    console.log("Last update timestamp:", lastUpdate);
    
    $.ajax({
        url: 'check_net_updates.php',
        data: {
            netID: currentNetID,
            lastUpdate: lastUpdate
        },
        success: function(data) {
            console.log("Net ID:", currentNetID);
            console.log("Client timestamp:", lastUpdate);
            console.log("Server timestamp:", data.last_update);
            console.log("Comparison:", data.comparison);
            console.log("Changes detected:", data.hasChanges ? "YES" : "NO");
            
            // First time, just store the update time
            if (lastUpdate === '') {
                lastUpdate = data.last_update;
                console.log("%cFirst check, stored timestamp:", "color: green;", lastUpdate);
                return;
            }
            
            // If changes detected by server
            if (data.hasChanges === true) {
                console.log("%cCHANGES DETECTED! Will refresh activity log", "background-color: #e74c3c; color: white; padding: 5px;");
                
                // Flash indicator
                $("#update-status")
                    .css('background-color', '#d9534f')
                    .text("Changes detected! Refreshing...")
                    .fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
                
                // Refresh after a short delay
                setTimeout(function() {
                    // Use the SSE-specific version of getactivities
                    $.ajax({
                        url: 'getactivities_sse.php',
                        data: { q: currentNetID },
                        success: function(html) {
                            console.log("Activity log refresh requested");
                            
                            // Find the main content area
                            const actLog = document.getElementById('actLog');
                            
                            if (actLog) {
                                // Try to parse the HTML properly
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                
                                // Find the updated table
                                const newTable = doc.querySelector('#actLog');
                                
                                if (newTable) {
                                    // Replace the table content
                                    actLog.innerHTML = newTable.innerHTML;
                                    console.log("Table content replaced successfully");
                                } else {
                                    // Fallback: just use the entire response
                                    console.log("Fallback: using entire response");
                                    actLog.innerHTML = html;
                                }
                                
                                // Update timestamp
                                lastUpdate = data.last_update;
                                
                                // Show success message
                                $("#update-status")
                                    .css('background-color', '#5cb85c')
                                    .text("Updated successfully!");
                                    
                                // Log successful update
                                console.log("%cTable updated successfully!", "background-color: #2ecc71; color: white; padding: 5px;");
                            } else {
                                console.error("Could not find activity log table in DOM");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error refreshing activity log:", error);
                            console.error("Response text:", xhr.responseText);
                            
                            // Show error to user
                            $("#update-status")
                                .css('background-color', '#f39c12')
                                .text("Update failed - check console");
                        }
                    });
                }, 500);
            } else {
                console.log("%cNo changes detected", "color: gray;");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error checking for updates:", error, xhr.responseText);
        }
    });
}
});
</script>
</body>
</html>