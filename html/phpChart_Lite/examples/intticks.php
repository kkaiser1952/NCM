<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
<style type="text/css">
.jqplot-target {
    margin-bottom: 30px;
}
</style>
    </head>
    <body>
        <div><span> </span><span id="info1b"></span></div>

<?php
    
    $s1 = array(3,1.5,2,0.5,2,1,2.5);


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 1 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $pc = new C_PhpChartX(array($s1),'chart7');
    $pc->add_plugins(array('canvasTextRenderer'),true);
    

    $pc->set_axes(array(
        'yaxis' => array('min'=>0,'tickOptions'=>array('formatString'=>'%d','numberTicks'=>6))
    ));
    $pc->draw(500,300);
/*
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 2 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $pc = new C_PhpChartX(array($s1),'chart8');
    $pc->add_plugins(array('canvasTextRenderer'),true);
    

    $pc->set_axes(array(
        'yaxis' => array('min'=>0,'max'=>6,'tickOptions'=>array('formatString'=>'%d'))
    ));
    $pc->draw(500,300);
*/
    ?>

    </body>
</html>