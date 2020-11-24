			function editColumns() {
			$(document).ready(function() {
					  	 $('.editTimeOut').editable('save.php', {			// Time Out
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editTimeIn').editable('save.php', {			// Time In
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 
					     $('.editCS1').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editFnm').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editTAC').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editGRID').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editLnm').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editEMAIL').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editCREDS').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editcnty').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editstate').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editdist').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editLAT').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
					 	 $('.editLON').editable('save.php', {
							 indicator 	: 'Saving...',
							 tooltip    : 'Click to edit...',
							 style  	: 'inherit'
					 	 });
						 $('.editC').editable('save.php', {  				// comments
							 indicator : 'Saving...',
							 tooltip   : 'Click to edit...',
							 style     : 'inherit' 
					 	 });
					 	 $('.edit_area').editable('save.php', {
					         type      : 'textarea',
					         cancel    : 'Cancel',
					         submit    : 'OK',
					         indicator : '<img src="img/indicator.gif">',
					         tooltip   : 'Click to edit...',
					         style     : 'inherit'
					     });
					     $('.editable_selectACT').editable('save.php', {  	// active
						    data    : "{'In':'In','Out':'Out','In-Out':'In-Out','BRB':'BRB','In-EOC':'In-EOC','MSSING':'MSSING'}",
						    type    : 'select',
						    submit 	: 'OK',
						    tooltip : 'Click to edit...',
						    style   : 'inherit'
					     });
					     $('.editable_selectTFC').editable('save.php', { 	// traffic
						    data    : "{'':'','Yes':'Yes','Snt':'Snt'}",
						    type    : 'select',
						    submit  : 'OK',
						    tooltip : 'Click to edit...',
						    style   : 'inherit'
					     });
					     $('.editable_selectMode').editable('', {
						     data   : "{'':'','Dig':'Dig','FSQ':'FSQ','Mob':'Mob','HF':'HF','V/U':'V/U','VHF':'VHF','UHF':'UHF','6m':'6m','D*':'D*','Echo':'Echo','DMR':'DMR'}",
						     type 	: 'select',
						     submit : 'OK',
						     tooltip : 'Click to edit...',
						     style	: 'inherit'
					     });
					     
					     // This editor causes all of the check-ins for the selected net to by default show the selected  mode. Its not quite working yet....
					/*     $('.DfltMode').editable('dfltVals.php', {
						     data   : "{'':'','Dig':'Dig','FSQ':'FSQ','Mob':'Mob','HF':'HF','V/U':'V/U','VHF':'VHF','UHF':'UHF','6m':'6m','D*':'D*','Echo':'Echo','DMR':'DMR'}",
						     type 	: 'select',
						     event	: 'dblclick',
						     submit : 'OK',
						     tooltip : 'Doubleclick to edit...',
						     style	: 'inherit'
					     }); */
					     
					     $('.editable_selectNC').editable('save.php', { 	// netcontrol
						    data    : "{'':'','PRM':'PRM','2nd':'2nd','3rd':'3rd','LSN':'LSN','Log':'Log','EM':'EM','PIO':'PIO'}",
						    type    : 'select',
						    submit  : 'OK',
						    tooltip : 'Click to edit...',
						    style   : 'inherit'
					     });
					 });	
					 			
				}, 500); //end document ready function 
			}