/*
 * Masked input for Jeditable
 *
 */
 
$.editable.addInputType("masked",{element:function(settings,original){
	var input=$("<input />").mask(settings.mask);
	return $(this).append(input),input}
});
