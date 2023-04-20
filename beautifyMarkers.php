<?php
    $stationMarkers .= "
			var $callsign = new L.marker(new L.latLng($logrow[koords]),{ 
			    rotationAngle: $dup,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.{$logrow[iconColor]}({number: '$rowno' }),
				title:`marker_$rowno` }).addTo(fg).bindPopup(`
				$div1<br><br>
				$div5<br><br>
                `).openPopup();
				
				$(`$callsign`._icon).addClass(`$logrow[classColor]`);
                stationMarkers.push($callsign);
				";
?>