/*! jquery-jeditable https://github.com/NicolasCARPi/jquery_jeditable#readme */

$.editable.addInputType("datepicker",{element:function(settings,original){var input=$("<input>");return $(this).append(input),input},plugin:function(settings,original){var form=this;settings.onblur="cancel",$("input",this).datePicker({createButton:!1}).bind("click",function(){return $(this).dpDisplay(),!1}).bind("dateSelected",function(e,selectedDate,$td){$(form).submit()}).bind("dpClosed",function(e,selected){}).trigger("change").click()}});