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

			// Check for device 'category' and add a window.event handler to the same function
			$(window).resize(function() { checkDeviceCategory(); });
			checkDeviceCategory();
	    }
	}
]);

// FUNCTIONS

/*	p80jq_modernizrPNGfallback, Swap inline .svg image with HTML5 data-png-fallback attribute .png fallback in unsupported browsers
============================================================= */

function modernizrPNGfallback(){
	if(!Modernizr.svg) {
	    var images = $('img[data-png-fallback]');
	    images.each(function(i) {
	      $(this).attr('src', $(this).data('png-fallback'));
	    });
	}
}

/* Load additional content using Ajax based on 
// body:after 'device' categor css loading HTML5 data-* attribute
================================================ */

var deviceCategory;
var deviceCategorySequence;

var deviceTabletLoaded = false;
var deviceDesktopLoaded = false;
var deviceWideLoaded = false;

function checkDeviceCategory() {
	deviceCategory = window.getComputedStyle(document.body,':after').getPropertyValue('content');
	deviceCategorySequence = ['"device-smartphone"', '"device-tablet"', '"device-desktop"', '"device-wide"'];
	var deviceKey = deviceCategorySequence.indexOf(deviceCategory);

	// console.log(deviceKey);

	// Based on deviceKey, load subsequent fragments
	switch(deviceKey) {
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
			// console.log('switch default');
	}
}

// Tablet
function loadTabletFragments() {
	// if (!deviceTabletLoaded && deviceCategory.indexOf("device-tablet") !=-1) {
	if (!deviceTabletLoaded) {
		$('[data-device-tablet]').each(function(){
			$(this).load($(this).data('device-tablet'));
			deviceTabletLoaded = true;
		});
	}
	// console.log('tablet loaded');
}

// Desktop
function loadDesktopFragments() {
	// if (!deviceDesktopLoaded && deviceCategory.indexOf("device-desktop") !=-1) {
	if (!deviceDesktopLoaded) {
		$('[data-device-desktop]').each(function(){
			$(this).load($(this).data('device-desktop'));
			deviceDesktopLoaded = true;
		});
	}
	// console.log('desktop loaded');
}

// Wide (screens)
function loadWideFragments() {
	// if (!deviceWideLoaded && deviceCategory.indexOf("device-wide") !=-1) {
	if (!deviceWideLoaded) {
		$('[data-device-wide]').each(function(){
			$(this).load($(this).data('device-wide'));
			deviceWideLoaded = true;
		});
	}
	// console.log('wide loaded');
}