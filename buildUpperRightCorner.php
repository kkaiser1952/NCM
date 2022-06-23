<!doctype html>

<?php

	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";

    $call = trim($_GET["call"]);   //$call = 'NR0AD'; 
   // $netid = $_GET["netid"];

	
	// get only one record for a return */
	$sql = ("SELECT row1, row2, row3, row4, row5, row6, id
			  FROM `NetKind`
			  WHERE `call` LIKE '%$call%'
			  ORDER BY `call` LIMIT 1
		   "); 
			  
			foreach($db_found->query($sql) as $row) {
				++$num_rows;
				$rcols = explode(",","$row[row1]");
					$r1c1 = $rcols[0];
					$r1c2 = $rcols[1];
		    		$r1c3 = $rcols[2];
		    		$r1c4 = $rcols[3];
		    		$r1c5 = $rcols[4];
		    		
		    	$rcols = explode(",","$row[row2]");
					$r2c1 = $rcols[0];
		    		$r2c2 = $rcols[1];
		    		$r2c3 = $rcols[2];
		    		$r2c4 = $rcols[3];
		    		$r2c5 = $rcols[4];
		    		
		    	$rcols = explode(",","$row[row3]");
					$r3c1 = $rcols[0];
		    		$r3c2 = $rcols[1];
		    		$r3c3 = $rcols[2];
		    		$r3c4 = $rcols[3];
		    		$r3c5 = $rcols[4];
		    		
		    	$rcols = explode(",","$row[row4]");
					$r4c1 = $rcols[0];
		    		$r4c2 = $rcols[1];
		    		$r4c3 = $rcols[2];
		    		$r4c4 = $rcols[3];
		    		$r4c5 = $rcols[4];

				$rcols = explode(",","$row[row5]");
					$r5c1 = $rcols[0];
		    		$r5c2 = $rcols[1];
		    		$r5c3 = $rcols[2];
		    		$r5c4 = $rcols[3];
		    		$r5c5 = $rcols[4];
		    		
		    	$rcols = explode(",","$row[row6]");
					$r6c1 = $rcols[0];
		    		$r6c2 = $rcols[1];  
		    		$r6c3 = $rcols[2];  //echo "$r6c1 $r6c2 $r6c3 $r6c4 ";
		    		$r6c4 = $rcols[3];
		    		$r6c5 = $rcols[4];
		}		
 
	    		
		echo(" <table id='ourfreqs'> ");
		
		echo(" <tr> <th class='edit_r1c1 r1c1 nobg'>$r1c1</th> 
					<th class='edit_r1c2 r1c2 nobg'>$r1c2</th>
			   		<th class='edit_r1c3 r1c3 nobg'>$r1c3</th> 
			   		<th class='edit_r1c4 r1c4 nobg'>$r1c4</th> </tr> ");
			   		
		echo(" <tr> <td class='edit_r2c1 r2c1 nobg1'>$r2c1</td> 
					<td class='edit_r2c2 r2c2 nobg2' id='r2c2:$row[id]'>$r2c2</td>
			   		<td class='edit_r2c3 r2c3 nobg2'>$r2c3</td> 
			   		<td class='edit_r2c4 r2c4 nobg2'>$r2c4</td> </tr> ");
			   		
		echo(" <tr> <td class='edit_r3c1 r3c1 nobg1'>$r3c1</td> 
					<td class='edit_r3c2 r3c2 nobg2'>$r3c2</td>
			   		<td class='edit_r3c3 r3c3 nobg2'>$r3c3</td> 
			   		<td class='edit_r3c4 r3c4 nobg2'>$r3c4</td> </tr> ");
			   		
		echo(" <tr> <td class='edit_r4c1 r4c1 nobg1'>$r4c1</td> 
					<td class='edit_r4c2 r4c2 nobg'>$r4c2</td>
			   		<td class='edit_r4c3 r4c3 nobg'>$r4c3</td>  
			   		<td class='edit_r4c4 r4c4 nobg'>$r4c4</td> </tr> ");
			   		
		echo(" <tr> <td class='edit_r5c1 r5c1 nobg1'>$r5c1</td> 
					<td class='edit_r5c2 r5c2 nobg2'>$r5c2</td>
			   		<td class='edit_r5c3 r5c3 nobg2'>$r5c3</td> 
			   		<td class='edit_r5c4 r5c4 nobg2'>$r5c4</td> </tr> ");
		if ($call != 'DMR'){
		echo(" <tr> <td class='edit_r6c1 r6c1 nobg1'>$r6c1</td> 
					<td class='edit_r6c2 r6c2 nobg2' colspan=3> 
					<a href=\"$r6c2\" target=\"_blank\"> $r6c2 </a><br>
					<a href=\"$r6c3\" target=\"_blank\"> $r6c3 </a></td> ");
					
		} else if ($call == 'DMR'){
		echo(" <tr> <td class='edit_r6c1 r6c1 nobg1'>$r6c1</td> 
					<td class='edit_r6c2 r6c2 nobg2'>$r6c2</td>
					<td class='edit_r6c3 r6c3 nobg2'>$r6c3</td> 
					<td class='edit_r6c4 r6c4 nobg2'>$r6c4</td> </tr> ");
		}   		

		echo("</table>");
	
?>