/*
	Demo alert text
*/
;(function($) {
	$.fn.setAlertText = function(options) {	
		var settings = {
			alerttext: 'default error text',
			myNumber1: 23,
			myNumber2: 6
		};		
		if(options) $.extend(settings, options);

		var calc = function(arg1, arg2) {
			return arg1 + arg2;
		}

		return this.each(function() {
			$(this).html(options.alerttext + ': ' + calc(options.myNumber1, options.myNumber2));
		});
	};
})(jQuery);