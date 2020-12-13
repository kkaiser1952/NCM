<?php 
    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "phpChart_Lite/conf.php";
 
?> 
<!DOCTYPE html> 
<html> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
    </head> 
    <body> 
        <?php
            $pc = new C_PhpChartX(array(array(11, 9, 5, 12, 14, 12, 5)),'basic_chart');
            //$pc->set_animate(true);
            $pc->set_title(array('text'=>'My First Basic Chart'));
            $pc->add_plugins(array('highlighter', 'cursor'));
            $pc->draw();
        ?>
    </body> 
</html> 