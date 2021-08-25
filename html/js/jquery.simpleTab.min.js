/*
    jQuery simpleTab v1.0.0 - 2013-03-18
    (c) 2013 Yang Zhao - geniuscarrier.com
    license: http://www.opensource.org/licenses/mit-license.php
*/
(function(a){a.fn.simpleTab=function(){return this.each(function(){a("#tabs li").click(function(){a("#tabs li").removeClass("active");a(this).addClass("active");a(".tab_content").hide();var b=a(this).find("a").attr("href");a(b).fadeIn();return!1});a("#tabs li:first").click()})}})(jQuery);