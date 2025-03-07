<?php
/**
 * header.php - Main header for Net Control Manager
 * Contains document head, meta tags, and CSS includes
 */
?>
<!doctype html>
<html lang="en" >
<head>
    
<!-- Preload some JS for quicker/easier access -->    
<link rel="preload" href="js/NetManager.js" as="script">
<link rel="preload" href="js/showActivities.js" as="script">
<link rel="preload" href="js/CellEditFunctions.js" as="script">
<link rel="preload" href="js/handleSSE.js" as="script">

    <meta charset = "UTF-8" />
    
<title>Amateur Radio Net Control Manager</title>

    <?php include "favicon-tags.php"; ?>
    
    <!-- Meta Tags -->
    <!-- Refresh the page every 9200 seconds (a bit over 2.5 hours) -->
    <meta http-equiv="refresh" content="9200; URL=https://net-control.space/help.php">
    
    <!-- Set the viewport for responsive design across all device sizes -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Description for SEO and social media previews -->
    <meta name="description" content="Amateur Radio Net Control Manager - A comprehensive tool for managing amateur radio nets.">
    
    <!-- Author information -->
    <meta name="author" content="Keith Kaiser, WA0TJT">
    
    <!-- Content rating, indicating the general audience suitability -->
    <meta name="rating" content="General">
    
    <!-- Sets the revisit frequency for search engine crawlers -->
    <meta name="revisit-after" content="1 month">
    
    <!-- Keywords for SEO -->
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Amateur Radio, Ham Radio">

    <!-- =============== All The CSS Goes Here ================================= -->
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allerta|Stoke|Cantora+One|Risque&display=swap">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon-32x32.png">
    
    <!-- =============== All above this should not be editied ================== -->
    
    <!-- All Update: 2024-11-09 -->
      
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen">
	<!-- consider this update 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    -->		
    
	<!-- jQuery Modal (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css">
    
    <!-- Bootstrap Select (local) -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap-select.min.css">
    
    <!-- jQuery UI (CDN) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    
    <!-- ============== My style sheets ============================================ -->
    
    <!-- Primary style sheet for NCM  -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" > 
    <!-- Updated: 2018-1-17 -->  
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >				
    
    <!-- ============== All the @media CSS stuff =================================== -->

    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css">	
    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
	 
<style>
/* Test CSS Here */
</style>

</head>

<body>