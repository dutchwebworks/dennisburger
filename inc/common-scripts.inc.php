<script src="/js/zepto.1.0.min.js"></script>
<!-- <script src="/js/jquery.1.8.1.min.js"></script> -->

<script>
// CSS3 MediaQueries breakpoints
var mqbreakpoint01 = 500;

// Functions
var Utils = {
	q : function(q, res) {
		if (document.querySelectorAll) {
			res = document.querySelectorAll(q);
		} else {
			var d = document,
			a = d.styleSheets[0] || d.createStyleSheet();
			a.addRule(q,'f:b');
			for(var l=d.all,b=0,c=[],f=l.length;b<f;b++)
			l[b].currentStyle.f && c.push(l[b]);

			a.removeRule(0);
			res = c;
		}
		return res;
	},
}

// Document load
$(document).ready(function() {
	// When the window resizes
	$(window).resize(function() {
		// Check CSS3 MediaQuery, and remove inline style
		// this re-enables the menu when resizing the webbrowser manually
		if(Modernizr.mq('(min-width: ' + mqbreakpoint01 + 'px)')) {
			$('#navigation').removeAttr('style');
		}
	});

	// show menu on smaller screens
	$('#showMenu').click(function() {
		$('#navigation').toggle();
	});
});	
</script>

<?php if($enable_ga) { ?>

<!-- Google Analytics -->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-32526017-1']);
_gaq.push(['_setDomainName', 'dennisburger.nl']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<?php } ?>