// MediaQuery breakpoints
var mqbreakpoint01 = 500;

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