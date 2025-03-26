<?php
// index.php   for  .us
/***********************************************************************************************************
 
 /**
 * Net Control Manager (NCM) - Version 1
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 * 
 * APPLICATION OVERVIEW
 * -------------------
 * NCM is a comprehensive CRUD application designed for Amateur Radio operators to manage
 * and document various network operations including:
 * - Weather emergencies
 * - Club meetings
 * - Bike ride support
 * - General communications logging
 * 
 * KEY FEATURES
 * ------------
 * - Station location mapping
 * - DHS/FEMA compliance
 * - ICS-214 and ICS-309 reporting
 * - Additional ICS report access
 * - Extensive help documentation
 * 
 * CORE WORKFLOWS
 * -------------
 * 1. Existing Net Selection:
 *    - Lists past 10 days of nets in dropdown (#select1)
 *    - Color coding: Green (open), Blue (pre-built), None (closed)
 *    - Processing: showActivities() in NetManager.js
 *    - Data population via buildUpperRightCorner.php and getactivities.php
 * 
 * 2. New Net Creation:
 *    - Data collection through dropdown selections
 *    - Operator callsign logging
 *    - Processing: newNet() in NetManager-p2.js
 *    - Database updates via newNet.php
 * 
 * SYSTEM INFORMATION
 * -----------------
 * Current: PHP Version 5.6.33-0+deb8u1
 * Planned Upgrade: PHP 7.4+76
 * Development Status: Continuous enhancement since 2015
 * 
 * LEGAL NOTICE
 * ------------
 * This software is provided "as is" without warranty of any kind, either expressed
 * or implied, including but not limited to the warranties of merchantability and
 * fitness for a particular purpose.
 */
	
require_once "dependencies.php";
require_once "header.php";
?>

<body>

<!-- Upper left corner of opening page -->
<?php require_once "opening_images.php"; ?>
<?php require_once "datetime.php"; ?>	 
<?php require_once "weather.php"; ?>
<?php require_once "navigation.php"; ?>
<?php require_once "net_choice.php"; ?>
<?php require_once "tipbubbles.php"; ?>

<?php require_once "admin_section.php"; ?>
	
<?php require_once "modals.php"; ?>

    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

<?php require_once "footer.php"; ?>

</body>
</html>