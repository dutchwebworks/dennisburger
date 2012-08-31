<script src="/js/zepto.1.0.min.js"></script>
<!-- <script src="/js/jquery.1.8.1.min.js"></script> -->

<script>
$(document).ready(function() {
	$(window).resize(function() {
		// Check CSS3 MediaQuery, and remove inline style
		// this re-enables the menu when resizing the webbrowser manually
		if(Modernizr.mq('(min-width: 500px)')) {
			$('#navigation').removeAttr('style');
		}
	});

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