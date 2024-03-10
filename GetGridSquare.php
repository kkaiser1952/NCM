<?php
/* Function to calculate the grid square based on lat/lng */
function getgridsquare($lat, $lng){

$Mtype = '';
$ychr  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$ynum  = "0123456789";
$y 	   = 0;
$ycalc = array(0,0,0);
$yn    = array(0,0,0,0,0,0,0);

$ycalc[1] = $lng + 180;
$ycalc[2] = $lat +  90;
		
	for ($i = 1; $i < 3; $i++) {
    	for ($k = 1; $k < 4; $k++) {
        	if ($k != 3) {
            	if ($i == 1) {
                	if ($k == 1) $ydiv = 20;
                  	if ($k == 2) $ydiv = 2;
                }
                if ($i == 2) {
                  if ($k == 1) $ydiv = 10;
                  if ($k == 2) $ydiv = 1;
                }

                $yres = $ycalc[$i] / $ydiv;
                $ycalc[$i] = $yres;
                
                if ($ycalc[$i]>0)
                  $ylp = floor($yres);
                else
                  $ylp = ceil($yres);
                  
                $ycalc[$i] = ($ycalc[$i] - $ylp) * $ydiv;
			}else {
                if ($i == 1)
                  $ydiv = 12;
                else
                  $ydiv = 24;

                $yres = $ycalc[$i] * $ydiv;
                $ycalc[$i] = $yres;
                
                if ($ycalc[$i] > 0)
                  $ylp = floor($yres);
                else
                  $ylp = ceil($yres);
			}

            $y++;
            
            $yn[$y] = $ylp;
		}
	} 
  		$yqth = $ychr{$yn[1]} . $ychr{$yn[4]} . $ynum{$yn[2]} . $ynum{$yn[5]} . $ychr{$yn[3]} . $ychr{$yn[6]};
  		
    	return $yqth;
} /* end of the gridsquare function */

?>