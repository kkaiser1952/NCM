<?php
/**
 * Net Control Manager (NCM) - Dependencies File
 * Copyright 2015-2025 Keith Kaiser, WA0TJT
 * Contact: wa0tjt@gmail.com
 */
	
// Error settings
ini_set('display_errors', 1); 
error_reporting(E_ALL ^ E_NOTICE);

// Database and dependency includes
require_once "dbConnectDtls.php";  // Access to MySQL
require_once "wx.php";             // Makes the weather information available
require_once "NCMStats.php";       // Get some stats
?>