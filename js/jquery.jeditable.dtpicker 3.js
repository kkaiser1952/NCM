/*
 * Masked input for Jeditable
 *
 * Copyright (c) 2018 Keith Kaiser
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 * 
 *
 */
 
$.editable.addInputType('dtpicker', {
    element : function(settings, original) {
        /* Create an input. Mask it using masked input plugin. Settings  */
        /* for mask can be passed with Jeditable settings hash.          */
        var input = $('<input type=\"text\" name=\"value\" />');
        $(this).append(input);
        return(input);
    }
    plugin: function(settings, original) {
	    var form = this;
	    $("input", this).filter(":text").dtpicker({
		    onselect: function(dateText) { $(this).hide(); $(form).trigger("submit");}
	    });
    }
});
