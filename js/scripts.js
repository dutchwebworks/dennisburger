// MediaQuery breakpoints
var mqbreakpoint02 = 500;
var thumbsLoaded = false; // mobile first

Modernizr.load([
    {
    	// test if mediaqueries are supported, mostly old Win/IE, and load polyfill
        test: window.matchMedia && Modernizr.mq('only all and (min-width: 1px)'),
        nope: "/js/libs/respond.1.1.0.min.js"
    },
    {
    	load: "/js/libs/enquire.min.js",

	    complete: function () {
			enquire.register("(max-width:" + mqbreakpoint02 + "px)", {
			    match : function() {},
			    unmatch : function() {
			    	$('#navigation').removeAttr('style');
			    },
			    // Fire once when ready
			    setup : function() {
					$('#showMenu').click(function() {
						$('#navigation').toggle();
					});
			    }
			}).register("(min-width:" + mqbreakpoint02 + "px)", {
			    match : function() {
			    	if (!thumbsLoaded) {
			    		// Grab the 'data-src' attribute and add it as an image
			    		$('#cvWebsites .site').each(function(){
			    			if($(this).attr('data-src')) {
			    				$(this).prepend('<div class="thumb"><a href="' + $(this).attr('data-src') + '"><img src="' + $(this).attr('data-src') + '" alt="' + $('h3', this).text() + '"></a></div>');
			    			}
			    		});
			    		thumbsLoaded = true;
			    	}

			    	// Add the Photoswipe gallery to the thumbnails above
			    	$("#cvWebsites .thumb a").photoSwipe({ 
			    		enableMouseWheel: false, 
			    		enableKeyboard: true
			    	});			    	
			    }
			}).listen();		
	    }
	}
]);