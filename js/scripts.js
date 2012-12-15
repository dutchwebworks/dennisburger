/* jQuery que loader
================================================ */

$(document).ready(function(){
	// modernizrPNGfallback();	// Swap inline image .svg with HTML5 data-src attribute .png fallback in unsupported browsers
});

/* Vars
================================================ */

// MediaQuery breakpoints
var mqbreakpoint02 = 600; // SASS var $site-max-width
var thumbsLoaded = false; // mobile first

/* Modernizr load enquire.js
================================================ */

Modernizr.load([
    {
    	// test if mediaqueries are supported, mostly old Win/IE, and load polyfill
        test: window.matchMedia && Modernizr.mq('only all and (min-width: 1px)'),
        nope: "/js/libs/respond.1.1.0.min.js"
    },
    {
    	load: "/js/libs/enquire.min.js",

	    complete: function () {
	    	/*
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
			}, true).register("(min-width:" + mqbreakpoint02 + "px)", {
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
			}, true).listen();
			*/

			// Add a event listner to check for CSS body:after generated 'content'
			// to match imaginary device 'keyword', see below
			$(window).resize(function() { checkDeviceCategory(); });
			checkDeviceCategory();
	    }
	}
]);

// FUNCTIONS

/*	modernizrPNGfallback, Swap inline .svg image with HTML5 data-png-fallback attribute .png fallback in unsupported browsers
============================================================= */

function modernizrPNGfallback(){
	if(!Modernizr.svg) {
	    var images = $('img[data-png-fallback]');
	    images.each(function(i) {
	      $(this).attr('src', $(this).data('png-fallback'));
	    });
	}
}

/* Load in additional HTML fragments based on device category 'keyword', set by CSS3 MediaQuery viewport width
============================================================= */

// A CSS3 MediaQuery sets the body:after CSS generated 'content' to an imaginary 
// device category 'keyword' like 'device-smartphone', 'device-tablet', 'device-desktop' or 'device-wide'
// based custom CSS 'breakpoints'. Javasript then reads that 'keyword' onLoad() (see above) and uses a 
// window.resize() eventhandler to load in additional HTML fragments (using Ajax) based on the URL in a 
// HTML5 data-attribute div, like so: <div data-device-desktop="/fragments/social-media.html"></div>
// the contents of the URL is appended to the div mathing the 'keyword' when CSS applies this keyword
// to the body:after generated 'content'

// Set vars and a list of device category names matching CSS's body:after CSS generated 'content:' list
var deviceCategory, deviceCategorySequence = ['device-smartphone', 'device-tablet', 'device-desktop', 'device-wide'];

// Device related content is not loaded in (once) by default, 'mobile-first'!
var deviceTabletLoaded = false;
var deviceDesktopLoaded = false;
var deviceWideLoaded = false;

function checkDeviceCategory() {
	// Get the CSS device category 'keyword' from CSS body:after generated 'content'
	deviceCategory = window.getComputedStyle(document.body,':after').getPropertyValue('content');
	deviceCategory = deviceCategory.replace('"', '', 'g'); // For Safari and Chrome, strip the quotes, or it won't match in 'indexOf' below
	deviceCategory = deviceCategory.replace('"', '', 'g'); // For Opera strip it again (for some weird reason)

	// Get the array 'key' back from the match above
	var deviceCategoryKey = deviceCategorySequence.indexOf(deviceCategory);

	// Based on 'deviceCategoryKey', load subsequent HTML fragments
	// the higher the key (that is: wider viewport), load the lower key (smaller viewport) stuff to
	switch(deviceCategoryKey) {
		case 0:
			break;
		case 1:
			loadTabletFragments();
			// console.log('case tablet loaded');
			break;
		case 2:
			loadTabletFragments();
			loadDesktopFragments();
			// console.log('case tablet and desktop loaded');
			break;
		case 3:
			loadTabletFragments();
			loadDesktopFragments();
			loadWideFragments();
			// console.log('case tablet, desktop and wide loaded');
			break;
		default:
			// If the browser can't read the CSS generated body:after 'content' keyword
			// load in everything by default, mostly for browsers that don't support CSS3 MediaQueries
			loadTabletFragments();
			loadDesktopFragments();
			loadWideFragments();
			// console.log('switch default');
	}
}

// Load 'tablet' fragments once
function loadTabletFragments() {
	if (!deviceTabletLoaded) {
		$('[data-device-tablet]').each(function(){
			$(this).load($(this).data('device-tablet'));
			deviceTabletLoaded = true;
		});
	}
	// console.log('tablet loaded');
}

// Load 'desktop' fragments once
function loadDesktopFragments() {
	if (!deviceDesktopLoaded) {
		$('[data-device-desktop]').each(function(){
			$(this).load($(this).data('device-desktop'));
			deviceDesktopLoaded = true;
		});
	}
	// console.log('desktop loaded');
}

// Load 'wide' (screen) fragments once
function loadWideFragments() {
	if (!deviceWideLoaded) {
		$('[data-device-wide]').each(function(){
			$(this).load($(this).data('device-wide'));
			deviceWideLoaded = true;
		});
	}
	// console.log('wide loaded');
}