<?php  
    // This program moved here on 2020-06-23 from index.php
		
		$groupList= ' ';
		$kindList = ' ';
		$freqList = ' ';
  
        /* 
		The SQL pulls from NetKind all the information to create the tHree dropdowns. The value from
		id2 of the selected GroupDropdown-content DIV is the default for the kindofnet. It also has 
		the default for the frequency. These values are the id numbers of the answers.
	    */
         // The left join of NetKind to itself is used to pick up the row of the default kind
         // and freq for each id. This is very cool code!
		foreach($db_found->query("
			SELECT t1.id, 
			       t1.`call`, 
			       t1.`orgType`, 
			       t1.`org`, 
			       t1.freq,
			       t1.`kindofnet`,
            	   t2.`kindofnet`            AS dfltKon, 
            	   t3.freq                 AS dfltFreq,
            	   char_length(t1.`orgType`) AS otl,
               CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.`call`,';',t1.`org`)	   AS id2,
               CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.`kindofnet`) 	           AS id3,
               REPLACE(CONCAT(t1.id,';',t2.kindofnet,';',t3.freq,';',t1.`freq`),' ','')  AS id4  
               
            	      
              FROM NetKind t1
              LEFT JOIN NetKind t2 
                ON t1.dflt_kind = t2.id
              LEFT JOIN NetKind t3 
                ON t1.dflt_freq = t3.id
            ORDER BY 'orgType', 'org'
			 ") as $net ) {
				 
		
		/* ==== GROUP ======= */
		if ($net['call'] <> '' ) {        
			$l = (52 - $net[otl])/2;  // how long each leg of equal signs should be
            $e = str_repeat("=", $l); // set e to make the option value 
           
           $groupList = "$groupList<a href='#$net[id2]' onclick='putInGroupInput(this);'>'$net[call]' ---> $net[org]</a>\n";
           
        } // END THE CALL A.K.A.; GROUP LOOP
			$thisOrgType = '$net[orgType]';	
		} // End of SQL      
		
		 //echo $groupList;
		// echo "$net[myid] thisOrgType= $thisOrgType ===> net OrgType=  $net[orgType] <br> $groupList <br><br>" ;
		
		/* ==== KIND ======= */
        foreach($db_found->query("
            SELECT CONCAT(MIN(t2.id),';',t2.kindofnet) as id3, kindofnet           
            FROM NetKind t2  
            WHERE t2.kindofnet <> ''
            GROUP BY kindofnet
            
            UNION
            
            SELECT '0;Monthly Meeting' as id3,
                   'Monthly Meeting' as kindofnet
            
            UNION
            
            SELECT '0;C4FM' as id3,
                   'C4FM' as kindofnet
            
            ORDER BY kindofnet 


            
        ") as $net ) {
		    $kindList = "$kindList<a href='#$net[id3]' onclick='putInKindInput(this);'>$net[kindofnet]</a>\n";
		} // End of KIND 
		
		/* ==== FREQ ======= */
        foreach($db_found->query("
            SELECT  CONCAT(t1.id,';',t1.`freq`) as id4,
                    freq            
              FROM NetKind t1  
             WHERE t1.freq <> ''
            GROUP BY freq
            
            UNION
            
            SELECT '0;7.263Mhz LSB' as id3,
                   '7.263Mhz LSB' as freq
                 
            ORDER BY freq
           
        ") as $net2 ) {
		    $freqList = "$freqList<a href='#$net2[id4]' onclick='putInFreqInput(this);'>$net2[freq]</a>\n";
		} // End of FREQ 
?> 