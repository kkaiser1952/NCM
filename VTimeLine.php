<!doctype html>
<!-- Time for daylight time is fixed in dbConnectDtls.php-->
<!— Look in downloads for: jquery-2.timeline-master  a newer version —> 

<html lang="en">
<head>
    <meta charset = "UTF-8" />
    
    <title>Amateur Radio Net Control Manager</title>
    <!-- Below is all about favicon images https://www.favicon-generator.org -->
    <link rel="apple-touch-icon" sizes="57x57" href="favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="manifest" href="favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- End all about favicon images -->

    
 <!--   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" > -->
    
    <!-- The meta tag below sends the user to the help file after 90 minutes of inactivity. -->
    <meta http-equiv="refresh" content="5400; URL=https://net-control.us/help.php" >
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" > 

    <meta name="description" content="Amateur Radio Net Control Manager" >
    <meta name="author" content="Keith Kaiser, WA0TJT" >
    
    <meta name="Rating" content="General" >
    <meta name="Revisit" content="1 month" >
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager" >
    
    <!-- https://fonts.google.com -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Allerta" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Stoke" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cantora+One" >
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Risque" >
    
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    
    <!-- =============== All above this should not be editied ====================== -->
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"  media="screen">	<!-- v3.3.7 -->
	
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.min.css" >		<!-- v0.9.1 -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-select.min.css" > 	<!-- v1.12.4 -->
	<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1/jquery-ui.min.css" >	

     <!-- ======== My style sheets ======== -->
    <link rel="stylesheet" type="text/css" href="css/NetManager.css" >   <!-- Primary style sheet for NCM  -->
    
    <link rel="stylesheet" type="text/css" href="css/tabs.css" >				<!-- 2018-1-17 -->
    
    <!-- All the @media stuff -->
    <link rel="stylesheet" type="text/css" href="css/NetManager-media.css">	
    
    <!-- ============ Time Line Project =========== -->
    <link rel="stylesheet" href="js/jquery-2.timeline-master/dist/jquery.timeline.min.css">
    
	 
<style>
	/* Use this space for experimental CSS */
    
</style>

</head>
<body>
    
<div id="VTimeLine"></div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="bootstrap/js/bootstrap.min.js"></script>			<!-- v3.3.2 -->
	<script src="js/jquery.freezeheader.js"></script>				<!-- v1.0.7 -->
	<script src="js/jquery.simpleTab.min.js"></script>				<!-- v1.0.0 2018-1-18 -->
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<!--
	<script src="js/jquery.modal.min.js"></script> -->
	<script src="bootstrap/js/bootstrap-select.min.js"></script>				<!-- v1.12.4 2018-1-18 -->
	<script src="bootstrap/js/bootstrap-multiselect.js"></script>				<!-- 2.0 2018-1-18 -->

    <!-- http://www.appelsiini.net/projects/jeditable -->
    <script src="js/jquery.jeditable.js"></script>							<!-- 1.8.1 2018-04-05 -->

	<!-- http://www.kryogenix.org/code/browser/sorttable/ -->
	<script src="js/sortTable.js"></script>										<!-- 2 2018-1-18 -->
	<script src="js/hamgridsquare.js"></script>									<!-- Paul Brewer KI6CQ 2014 -->
	<script src="js/jquery.countdownTimer.js"></script>							<!-- 1.0.8 2018-1-18 -->
	
	<script src="js/w3data.js"></script>										<!-- 1.31 2018-1-18 -->
	
	<!-- My javascript -->
	
	<script src="js/NetManager.js"></script> 	
<!--	<script src="js/NetManager.js"></script> -->				<!-- NCM Primary Javascrip 2018-1-18 -->
	
	<script src="js/NetManager-p2.js"></script>					<!-- Part 2 of NCM Primary Javascript 2018-1-18 -->
	<script src="js/CellEditFunction.js"></script>				<!-- Added 2018-02-12 -->
	<script src="js/validate.newnet.entries.js"></script>	    <!-- Added 2018-07-13 -->
	<!-- End My javascript -->
	
	<script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	
	<script src="js/grid.js"></script>
	<script src="js/gridtokoords.js"></script>
	<script src="js/cookieManagement.js"></script>
	
	<!-- ============ Time Line Project =========== -->
	<script src="js/jquery-2.timeline-master/dist/jquery.timeline.min.js"></script>
	
<script>	


var str = 1628;
//alert(str);
$.get('getVTimeLog.php', {q: str}, function(data) {
	$("#VTimeLine").html(data);	
}); // end response


$("#VTimeLine").timeline({
  type: "bar",
 // startDatetime: "2019-11-10 19:00",
  scale: "day",
  rows: "auto",
})

</script>

</body>
</html>