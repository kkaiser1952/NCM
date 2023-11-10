<!doctype html>
<?php

			ini_set('display_errors',1); 
			error_reporting (E_ALL ^ E_NOTICE);
		
		    require_once "dbConnectDtls.php";
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Registered Groups using NCM </title>
    <meta name="author" content="Kaiser" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
    <link rel="stylesheet" type="text/css" media="all" href="css/listNets.css">
    <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet' type='text/css'>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    <script src="js/sortTable.js"></script>
    
    <script>
	
	</script>
	
	<style>
		.red {
			color: red;
		}
	</style>
	
</head>

<body>
	
<!--	<p class="listtitle">Click the Net ID for the ICS-214 report or Map</p>  -->
    <h2>Registered Ham Groups that use NCM</h2>
	<p class="instruct">Click any column head to sort</p>
    <table class="sortable">
	    <tr>
    	    <th>Net Call</th>
    	    <th>Organization</th>
    	    <th>Type</th>
    	    <th>Default Kind</th>
    	    <th>Default Freq</th>
    	    <th>Contact</th>
    	    <th>Web or Facebook</th>
	    </tr>  
	    <?php
    	    //   DATE(logdate) as netDate,
		/*	$sql1 = ("SELECT `call`, org, orgType, org_web,
			                  CONCAT(contact_name,', ',contact_call,' ',contact_email) as contact
			            FROM NetKind
			           WHERE `call` <> '' 
			           ORDER BY `call` 
                      "); */
            $sql1 = ("SELECT t1.id, 
                             t1.`call`, 
                             t1.orgType, 
                             t1.org, 
                             t1.freq, 
                             t1.kindofnet,
                             t1.org_web,
                             CONCAT(t1.contact_name,', ',t1.contact_call,' ',t1.contact_email)          AS contact,
                             t2.kindofnet                                                               AS dfltKon, 
                             t3.freq                                                                    AS dfltFreq,
                    	     char_length(t1.orgType)                                                    AS otl,
                             CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.`call`,';',t1.org)        AS id2,
                             CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.`kindofnet`) 	            AS id3,
                    	     REPLACE(CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.`freq`),' ','')   AS id4            
                      FROM NetKind t1

                      LEFT JOIN NetKind t2 
                        ON t1.dflt_kind = t2.id 
                      LEFT JOIN NetKind t3 
                        ON t1.dflt_freq = t3.id 
                    ORDER BY t1.call");
					
		    foreach($db_found->query($sql1) as $row) {
			   if ('$row[call]' <> '' AND '$row[call]' <> 'OTHER' AND '$row[call]' <> 'EVENT' AND '$row[call]' <> 'TE0ST') {
    			   echo"
    			   <tr>
    			        <td>$row[call]</td>		
    			        <td>$row[org]</td>	
    			        <td>$row[orgType]</td>
    			        <td>$row[dfltKon]</td>
    			        <td>$row[dfltFreq]</td>
    			        <td>$row[contact]</td>
    			        <td>$row[org_web]</td>
    			   </tr>
    			   ";
			   }
		    }
		?>
        
    </table>
    <p>buildGroupList.php</p>
     <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
   
    
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


</script> <!-- The scrollFunction to move to the top of the page -->
</body>
</html>