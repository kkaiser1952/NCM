/**
 * Net Control Manager (NCM) - SSE Integration
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */

// Keep track of the current SSE connection
let netUpdateSource = null;
let currentNetID = null;
let sseActive = false;

// Initialize SSE functionality
$(document).ready(function() {
    console.log("SSE functionality initialized");
    
    // Replace the timed refresh dropdown with real-time indicator
    $("#refrate").after('<span id="realtime-indicator" class="hidden" style="background-color: #5cb85c; color: white; padding: 4px 8px; border-radius: 4px; margin-left: 10px;">Real-time updates active</span>');
    
    // Modify the refresh button to use SSE or fall back to manual refresh
    $("#refbutton").on("click", function() {
        if (!sseActive && currentNetID) {
            setupSSE(currentNetID);
        } else {
            // Fallback to standard refresh if SSE isn't active
            refreshActivityLog(currentNetID);
        }
    });
});

// Setup SSE connection for a specific net
function setupSSE(netID) {
    // Store the current net ID
    currentNetID = netID;
    
    // Check if SSE is supported by the browser
    if (typeof(EventSource) === "undefined") {
        console.log("SSE not supported by this browser");
        return false;
    }
    
    // Close any existing SSE connection
    if (netUpdateSource) {
        netUpdateSource.close();
        netUpdateSource = null;
    }
    
    try {
        // Create a new SSE connection
        netUpdateSource = new EventSource("sse_updates.php?netID=" + netID);
        
        // Handler for successful connection
        netUpdateSource.onopen = function() {
            console.log("SSE connection established for net ID: " + netID);
            sseActive = true;
            
            // Hide the timed refresh dropdown and show real-time indicator
            $("#refrate").addClass("hidden");
            $("#realtime-indicator").removeClass("hidden");
        };
        
        // Handler for update events
        netUpdateSource.addEventListener("update", function(event) {
            const data = JSON.parse(event.data);
            console.log("SSE update received for net ID: " + data.netID);
            
            // Refresh the activity log
            refreshActivityLog(data.netID);
        });
        
        // Handler for error events
        netUpdateSource.addEventListener("error", function(event) {
            console.error("SSE connection error");
            
            // Close the connection on error
            if (netUpdateSource) {
                netUpdateSource.close();
                netUpdateSource = null;
            }
            
            sseActive = false;
            
            // Show the timed refresh dropdown again and hide real-time indicator
            $("#refrate").removeClass("hidden");
            $("#realtime-indicator").addClass("hidden");
        });
        
        return true;
    } catch (e) {
        console.error("Error setting up SSE:", e);
        return false;
    }
}

// Function to refresh only the activity log via AJAX
function refreshActivityLog(netID) {
    if (!netID) return;
    
    $.ajax({
        url: "getActivitiesPartial.php",
        type: "GET",
        data: { q: netID },
        success: function(data) {
            // Update the activity log
            $("#actLog").html(data);
            
            // Also update the timeline if it's visible
            if ($("#timeline").is(":visible")) {
                RefreshTimeLine();
            }
        },
        error: function() {
            console.error("Failed to fetch activity log updates");
        }
    });
}

// Function to safely disconnect SSE when leaving the page
function disconnectSSE() {
    if (netUpdateSource) {
        console.log("Closing SSE connection");
        netUpdateSource.close();
        netUpdateSource = null;
        sseActive = false;
    }
}

// Add page unload handler to clean up SSE connection
$(window).on("beforeunload", function() {
    disconnectSSE();
});

// Extend the showActivities function to set up SSE
function initializeSSEForNet(netID, netName) {
    console.log("Initializing SSE for net: " + netName + " (ID: " + netID + ")");
    setupSSE(netID);
}