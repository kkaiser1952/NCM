<?php
/* Function to calculate the grid square based on lat/lng */
/* Function to calculate the 8-place grid square based on lat/lng */
function gridsquare8($lat, $lng) {
    $ychr = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ynum = "0123456789";
    $y = 0;
    $ycalc = array(0, 0, 0);
    $yn = array(0, 0, 0, 0, 0, 0, 0, 0);

    $ycalc[1] = $lng + 180;
    $ycalc[2] = $lat + 90;

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

                if ($ycalc[$i] > 0)
                    $ylp = floor($yres);
                else
                    $ylp = ceil($yres);

                $ycalc[$i] = ($ycalc[$i] - $ylp) * $ydiv;
            } else {
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

                $yn[7] = floor(($yres * 24) % 10); // Calculate 7th place (subsquares)
                $yn[8] = floor(($yres * 24 * 10) % 10); // Calculate 8th place (subsquares)
            }

            $y++;

            $yn[$y] = $ylp;
        }
    }

    $yqth = $ychr{$yn[1]} . $ychr{$yn[4]} . $ynum{$yn[2]} . $ynum{$yn[5]} . $ychr{$yn[3]} . $ychr{$yn[6]} . $ynum{$yn[7]} . $ynum{$yn[8]};

    return $yqth;
} /* end of the gridsquare function */


//print_r ("$yqth<br>");

$gs = gridsquare8(39.202927861, -94.60288754);
echo "$gs<br>";
echo "$gs[0], $gs[1]...$gs[5]<br>";
print_r("$gs");

/*
    Let's go through the calculation step-by-step with the new coordinates:

Initial values:
$ychr = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
$ynum = "0123456789"
$ycalc = [0, 0, 0]
$yn = [0, 0, 0, 0, 0, 0, 0, 0]
Calculate $ycalc[1] and $ycalc[2]:
$ycalc[1] = -94.60288754 + 180 = 85.39711246
$ycalc[2] = 39.202927861 + 90 = 129.202927861
Loop for $i = 1:
For $k = 1:
$ydiv = 20
$yres = 85.39711246 / 20 ≈ 4.269855623
$ylp = floor(4.269855623) = 4
$ycalc[1] = (85.39711246 - 4) * 20 = 1.9422491999995
For $k = 2:
$ydiv = 2
$yres = 1.9422491999995 / 2 ≈ 0.97112459999975
$ylp = floor(0.97112459999975) = 0
$ycalc[1] = (1.9422491999995 - 0) * 2 = 3.884498399999
Loop for $i = 2:
For $k = 1:
$ydiv = 10
$yres = 129.202927861 / 10 ≈ 12.9202927861
$ylp = floor(12.9202927861) = 12
$ycalc[2] = (129.202927861 - 12) * 10 = 117.202927861
For $k = 2:
$ydiv = 1
$yres = 117.202927861 / 1 = 117.202927861
$ylp = floor(117.202927861) = 117
$ycalc[2] = (117.202927861 - 117) * 1 = 0.20292786100006
For the last loop ($k = 3):
For $i = 1:
$ydiv = 12
$yres = 3.884498399999 * 12 ≈ 46.613980799988
$ylp = floor(46.613980799988) = 46
$yn[7] = floor((46.613980799988 * 24) % 10) ≈ 9
$yn[8] = floor((46.613980799988 * 24 * 10) % 10) ≈ 2
Convert the calculated values to grid square:
$yqth = "E" . "M" . "2" . "9" . "q" . "e" . "9" . "2"
    */

?>