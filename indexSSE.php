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
    let checkCounter = 0;
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
    
    console.log("%c=== UPDATE CHECK ===", "background-color: #3498db; color: white; padding: 5px;");
    console.log("Checking for updates on net ID:", currentNetID);
    console.log("Last update timestamp:", lastUpdate);
    
    // Count how many checks we've done
    checkCounter = (checkCounter || 0) + 1;
    
    // Force a refresh every 5 checks (roughly 25 seconds)
    const forceRefresh = (checkCounter % 5 === 0);
    
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
            console.log("Force refresh:", forceRefresh ? "YES" : "NO");
            
            // First time, just store the update time
            if (lastUpdate === '') {
                lastUpdate = data.last_update;
                console.log("%cFirst check, stored timestamp:", "color: green;", lastUpdate);
                return;
            }
            
            // If changes detected by server OR we need to force a refresh
            if (data.hasChanges === true || forceRefresh) {
                if (forceRefresh) {
                    console.log("%cFORCING REFRESH after 5 checks", "background-color: #9b59b6; color: white; padding: 5px;");
                } else {
                    console.log("%cCHANGES DETECTED! Will refresh activity log", "background-color: #e74c3c; color: white; padding: 5px;");
                }
                
                // Flash indicator
                $("#update-status")
                    .css('background-color', '#d9534f')
                    .text(forceRefresh ? "Routine refresh..." : "Changes detected! Refreshing...")
                    .fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
                
                // Refresh after a short delay
                setTimeout(function() {
                    // Instead of whole page reload, just refresh the activity log
                    $.ajax({
                        url: 'getactivities.php',
                        data: { q: currentNetID },
                        success: function(html) {
                            console.log("Activity log refresh requested");
                            
                            // Create a temporary container for the HTML
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = html;
                            
                            // Find the table in the current page
                            const activityTable = document.querySelector('table');
                            if (activityTable) {
                                // Look for the table in the response
                                const newTable = tempDiv.querySelector('table');
                                if (newTable) {
                                    // Replace just the table content
                                    activityTable.innerHTML = newTable.innerHTML;
                                    console.log("Table content updated successfully");
                                } else {
                                    console.error("Could not find table in response");
                                }
                                
                                // Update timestamp
                                lastUpdate = data.last_update;
                                
                                // Show success message
                                $("#update-status")
                                    .css('background-color', '#5cb85c')
                                    .text("Updated successfully!");
                            } else {
                                console.error("Could not find activity table in current page");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error refreshing activity log:", error);
                            console.error("Response:", xhr.responseText);
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