<!doctype html>
<?php
    /* This program uses adds the email address given by someone who forgets to close a net, the next time he opens a net */
    
    ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";
    
    $q = strip_tags(substr($_GET["q"],0, 100)); 
        
        $parts		= explode(":",$q);
        $callsign	= strtoupper($parts[0]);  // The NCS call sign
        $email  	= ($parts[1]);

$sql = ("
    UPDATE stations
       SET email = '$email',
           dttm  = CURRENT_TIMESTAMP,
           comment = 'Captured email of those who started nets, then left open'
     WHERE callsign = '$callsign';
");

    //echo "$sql";
    $db_found->exec($sql);
                 
?>