<!doctype html>

<?php
/***********************************************************************************************************
 
 Net Control Manager is a Create, Read, Update, Delete (CRUD) application used by Amateur Radio operators to document various net operations such as weather emergencies, club meetings, bike ride support and any other logging and/or reporting intensive communications support and management needs. 
  
 A variety of reports can be created such as mapping stations locations and other DHS/FEMA needs. Including the ICS-214 and ICS-309 reports and access to all the many others.
 
 No Guarantees or Warranties. EXCEPT AS EXPRESSLY PROVIDED IN THIS AGREEMENT, NO PARTY MAKES ANY GUARANTEES OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WHETHER ARISING BY OPERATION OF LAW OR OTHERWISE. PROVIDER SPECIFICALLY DISCLAIMS ANY IMPLIED WARRANTY OF MERCHANTABILITY AND/OR ANY IMPLIED WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE. 
 
 Extensive help is available by clicking Help in the upper right corner of the opening page. Or visit https://net-control.us/help.php

 First written some time in early-mid 2015 and in continous enhancment and upgrade since.
 
 copyright 2015-2024 by: Keith Kaiser, WA0TJT 
 Written by: Keith Kaiser, WA0TJT, with the help of many others. See the help file for more details.
 I can be reached at wa0tjt at gmail.com
 
 The version number. v7.03.04 for example means year 7 of use (2022), 03 means the month (March), 04 the day date.
 
 How NCM works (for the most part, sorta, kinda):
 If a net is selected from the dropdown:
     1) The list of nets is selected from #select1, the past 10 days only. Nets highlighted in green are open, blue are pre-built nets, no color are closed nets.
     2) The selected net information is passed to the showActivities() function in NetManager.js
     3) If this net is for logging custom contacts, the code is in NetManager.js @ showActivities()
     3a) This extra code change the Name field to a custom field for logging purposes
     4) It runs buildUpperRightCorner.php and getactivities.php to build the page
     4a) buildUpperRightCorner.php is used to retrieve data and populate #ourfreqs in #rightCorner
     4b) getactivities.php is used to retrieve the data of the selcted net and populate #actLog
 
 If a new net is created:
     1) Each of the dropdowns supplies part of the information needed to start the new net
     2) The callsign of the person starting the net is also ented into the new net
     3) When that data is complete it is passed to the newNet() function in NetManager-p2.js 
     4) NetManager-p2.js runs newNet.php to create, and populate NetLog and TimeLog appropriatly
 
*********************************************************************************************************/

    // phpinfo();
    // PHP Version 5.6.33-0+deb8u1 on v1 as of 2022-12-05
    // Will be PHP version: 7.4+76 soon
    // MySQL v5.5 starting 06/15/2015
	

// Error settings
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Set headers first
header('Content-Type: text/html; charset=UTF-8');
//header('Content-Type: text/event-stream');header('Cache-Control: no-cache');

// Define any potentially missing constants used in included files
if (!defined('otl')) {
    define('otl', 'online'); // Replace with the appropriate value
}

if (!defined('otl')) {
    define('otl', 'online'); 
}

// Then proceed with your regular requires/includes
require_once "dbConnectDtls.php";

require_once "wx.php"; // Weather info
require_once "NCMStats.php"; // Get some stats
include "sidebar.php"; // What columns will show in the UI

require_once "buildThreeDropdowns.php";
    $dropdownBuilder = new DropdownBuilder($db_found, new DatabaseLogger());
    $groupList = $dropdownBuilder->buildGroupList();
    $kindList = $dropdownBuilder->buildKindList();
    $freqList = $dropdownBuilder->buildFreqList();

require_once "buildSubNetCandidates.php";
    $subNets = buildSubNetCandidates($db_found);

require_once "buildOptionsForSelect.php";
    $selectOptions = buildOptionsForSelect($db_found);

    $weatherData = getWeatherInfo();

// Include the header (doctype, meta tags, CSS)
include "header.php";

// Include the page header (logo, time display, weather)
include "page-header.php";

// Include the navigation menu
include "navigation.php";

// Include the main content
include "main-content.php";

// Include the admin section
include "admin-content.php";

// Include the footer
include "footer.php";
?>