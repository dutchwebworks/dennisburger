/* Modernizr load enquire.js
================================================ */

Modernizr.load([
    {
    	// test if mediaqueries are supported, mostly old Win/IE, and load polyfill
        test: window.matchMedia && Modernizr.mq('only all and (min-width: 1px)'),
        nope: "/js/libs/respond.1.1.0.min.js"
    },
    {
	    complete: function () {
			// Conditionizr
			runConditionizr();
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

/* Conditionizr, like Modernizr: adds HTML-tag classes for platform, browsername, (no-)retina
================================================ */

function runConditionizr() {
	$('head').conditionizr({
		ieLessThan : { active: false, version: '9', scripts: false, styles: false, classes: true, customScript: 'none'},
		chrome     : { scripts: false, styles: false, classes: true, customScript: 'none' },
		safari     : { scripts: false, styles: false, classes: true, customScript: 'none' },
		opera      : { scripts: false, styles: false, classes: true, customScript: 'none' },
		firefox    : { scripts: false, styles: false, classes: true, customScript: 'none' },
		ie10       : { scripts: false, styles: false, classes: true, customScript: 'none' },
		ie9        : { scripts: false, styles: false, classes: true, customScript: 'none' },
		ie8        : { scripts: false, styles: false, classes: true, customScript: 'none' },
		ie7        : { scripts: false, styles: false, classes: true, customScript: 'none' },
		ie6        : { scripts: false, styles: false, classes: true, customScript: 'none' },
		retina     : { scripts: false, styles: false, classes: true, customScript: 'none' },
		mac    : true,
		win    : true,
		x11    : true,
		linux  : true
	});
}