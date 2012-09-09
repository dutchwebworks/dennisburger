// MediaQuery breakpoints
var mqbreakpoint02 = 500;

Modernizr.load([
    {
        test: window.matchMedia,
        nope: "/js/libs/matchMedia.js"
    },
    {
    	load: "/js/libs/enquire.1.1.0.min.js",

	    complete: function () {
			enquire.register("(max-width:" + mqbreakpoint02 + "px)", {
				// Narrower than breakpoint
			    match : function() {

			    },
			    // Wider than breakpoint
			    unmatch : function() {
			    	$('#navigation').removeAttr('style');
			    },
			    // Fire once when ready
			    setup : function() {
					$('#showMenu').click(function() {
						$('#navigation').toggle();
					});
			    }
			}).listen();

			enquire.register("(min-width:" + mqbreakpoint02 + "px)", {
				match : function(){},
				// When viewport is wider than breakpoint
				// 'setup' is triggert once
			    setup : function() {
					$('#cvWebsites li').each(function(){
						$(this).prepend('<img src="' + $(this).attr('data-src') + '" alt="' + $('h3', this).text() + '">');
					});
			    },
			    // only trigger when breakpoints matches
			    deferSetup : true
			});			
	    }
	}
]);

