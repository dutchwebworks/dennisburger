// MediaQuery breakpoints
var mqbreakpoint01 = 500;

Modernizr.load([
    {
        test: window.matchMedia,
        nope: "/js/libs/matchMedia.js"
    },
    {
    	load: "/js/libs/enquire.1.1.0.min.js",

	    complete: function () {
			enquire.register("(max-width:" + mqbreakpoint01 + "px)", {
				// Narrower than breakpoint
			    match : function() {
					$('body').removeClass('largeScreen').toggleClass('smallScreen');
			    },
			    // Wider than breakpoint
			    unmatch : function() {
			    	$('body').removeClass('smallScreen').toggleClass('largeScreen');
			    	$('#navigation').removeAttr('style');
			    },
			    // Fire once when ready
			    setup : function() {
					$('#showMenu').click(function() {
						$('#navigation').toggle();
					});
			    }
			}).listen();    	
	    }
	}
]);

