<script>
	if(Modernizr.mq("(max-width: 321px)")) {
		console.log('true');
	} else {
		console.log('false');
	}
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