
<?php  
    // This is used in index.php to create a list of sub net candidates for the current open net
    foreach($db_found->query("SELECT netID, activity, netcall
						     FROM NetLog 
						     WHERE (dttm    >= NOW() - INTERVAL 3 DAY AND pb = 1)
                                OR (logdate >= NOW() - INTERVAL 3 DAY AND pb = 0)
							 GROUP BY netID 
							 ORDER BY netID DESC
						  ") as $act){
	echo ("<option title='$act[netID]' value='$act[netID]'>Net #: $act[netID] --> $act[activity]</option>\n");
}

?> 