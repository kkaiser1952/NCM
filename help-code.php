<!doctype html>
<?php 
	require_once "NCMStats.php";			
?>

<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167869985-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167869985-1');
</script>
    <title>Amateur Radio Net Control Manager Instructions and Help</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Amateur Radio Net Control Manager Help" >
    <meta name="author" content="Keith Kaiser, WA0TJT" >
    <meta name="Rating" content="General" >
    <meta name="keywords" content="Amateur Radio Net, Ham Net, Net Control, Call Sign, NCM, Emergency Management Net, Net Control Manager" >
    <meta name="robots" content="index" > 
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/help.css" />
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="css/bubbles.css">

<style>
    } /* End of media css */
</style>
	
	

    
</head>
<body>
	
<div id="banner">
    
    <img id="smtitle" src="images/NCM.png" alt="NCM" >

	<div class="title">
		<p>Net	</p>
		<p>Control  <span style="float: right;">Code Documentation &amp; Help</span></p>
		<p>Manager</p>
	</div> <!-- End title -->
	
	<div class="flex-container1">
		<div>
			<a href="https://net-control.us">Open Net Control Manager</a>
			<br>
			<a href="https://net-control.us/hamnets.html" target="_blank"> What is a Ham Net?</a>

		</div>
		<div class="topBanner">
			<?php
				/*echo "As of Today: -->   $netcall Groups, $cscount Unique Stations, $netCnt Nets, $records Entries,
					 <br> $volHours of Volunteer Time<br>Across: 4 Countries, $stateCnt states, $countyCnt counties and $gridCnt grid squares.";
				*/	 
				echo "As of Today: --><br>   $netcall Groups, $cscount Unique Stations, $netCnt Nets, $records Entries,
					 <br> $volHours of Volunteer Time";
			?>
		</div>
		<div class="printIt">
			<button style=" color:#4706f8; font-size: larger" onclick="printfunction()">Print this document</button>
			<br>
			<script>
    			var myDate = new Date(document.lastModified).toLocaleDateString('en-us', { year:"numeric", month:"short", day:"numeric"}) 
    			document.write("<b style=''> Updated: " + myDate +"</b>");
            </script>
		</div>
	</div> <!-- end flex-container -->
</div> <!-- End Banner -->
<br>
<div class="index"> <!-- Changed from div on 2019-10-01 -->
	<a id="index"></a>
	<h3>Topic Index</h3>
	
	 <nav class="topics">
		<a href="#javascript">Javascript</a><br>
		<a href="#javascript">Style Sheets</a><br>
		<a href="#javascript">PHP</a><br>
		<a href="#javascript">jQuery</a><br>
     </nav> <!-- End topics for topic index -->
	 <br>
<div>
    <a class="gotoindex" href="#index">Back to the Index</a>
</div>

<hr><hr><hr>
<p style="page-break-before: always"></p>
<div class="title">
		<p>Net	</p>
		<p>Control 
		<p>Manager</p>
</div> <!-- End title -->

<!-- Start topics here -->
<hr>

<div class="assumptions">
	<a id="assumptions"></a>
	<h3>Assumptions:</h3>
</div>
<hr>


<div class="theend">
    <a id="theend"></a>
    <div>
<p>&copy; Copyright 2015-<?php echo date("Y");?>, by Keith D. Kaiser, WA0TJT <br>
Written by: Keith D. Kaiser, WA0TJT with the invaluable assistance, understanding and love of Deb Kaiser, W0DLK. <br>
Additonal Authors, advisers, resources and mentors include: Jeremy Geeo (KD0EAV) who is also our server host, Sila Kissuu (AK0SK), Nicolas Carpi for his jeditable, Mathew Bishop (KF0CJM), Louis Gamor, Members of Kansas City Northland ARES, The Platte County Amateur Radio Group, and the many members of <a href="https://stackoverflow.com" target="_blank"> Stack Overflow.</a>
</p>
    </div>
    
<span  style="text-align: center; display: inline-block; vertical-align: middle;">

        <img src="BRKMarkers/plum_man.svg" alt="plum_man" style="float:left; padding: 0px; border: 0;" />

    Map Markers courtesy of Bridget R. Kaiser

        <img src="BRKMarkers/plum_flag.svg" alt="plum_flag" style="float:right; padding: 0px; border: 0;" />

</span>

<p>
<div>
 <img src="images/backgroundantenna328x72.png"  alt="backgroundantenna328x72" width="250" >
    International (DX) station information compliments of Daniel Bateman, KK4FOS with Buckmaster International, LLC
</div>
</p>
<p> 
Guarantees or Warranties:<br>
     No Guarantees or Warranties. EXCEPT AS EXPRESSLY PROVIDED IN THIS AGREEMENT, NO PARTY MAKES ANY GUARANTEES OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WHETHER ARISING BY OPERATION OF LAW OR OTHERWISE. PROVIDER SPECIFICALLY DISCLAIMS ANY IMPLIED WARRANTY OF MERCHANTABILITY AND/OR ANY IMPLIED WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE. 
</p>
<div class="classictemplate template" style="display: block;"></div>

<div id="groupsio_embed_signup2">
<form action="https://groups.io/g/NCM/signup?u=5681121157766229570" method="post" id="groupsio-embedded-subscribe-form2" name="groupsio-embedded-subscribe-form" target="_blank">
    <div id="groupsio_embed_signup_scroll2">
      <label for="email" id="templateformtitle">Subscribe to the NCM groups.io! </label>
      <input type="email" value="" name="email" class="email" id="email" placeholder="email address" required="">
    
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5681121157766229570" tabindex="-1" value=""></div>
    <div id="templatearchives"></div>
    <input type="submit" value="Subscribe" name="subscribe" id="groupsio-embedded-subscribe" class="button">
    <br><br>
  </div>
</form>
</div>
</div> <!-- End theend -->

<div title="Knowing where you can find something is, after all, the most important part of learning"><I style="color:blue;">Scire ubi aliquid invenire possis ea demum maxima pars eruditionis est,</I>
    <br><br>
</div>

<a class="gotoindex" href="#index">Back to the Index</a>
</div> <!-- End of theend -->

<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>


<script   src="https://code.jquery.com/jquery-3.5.1.min.js"   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="   crossorigin="anonymous"></script>

<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
        
        $(document).ready(function(){
          $(".tipsbutton").click(function(){
            $(".HelpBubbles").toggle();
          });
        });
        

function printfunction() {
	window.print();
}

</script> <!-- The scrollFunction to move to the top of the page -->

</body>
</html>