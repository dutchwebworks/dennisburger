<script src="/js/libs/zepto.1.0.min.js"></script>

<!-- Grab Google CDN's jQuery. fall back to local if necessary -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="/js/libs/jquery.1.8.1.min.js"%3E%3C/script%3E'))</script>
 -->
 
<script src="/js/scripts.js"></script>

<!-- Load iOS orientation bug fix only for iOS devices -->
<script>if(navigator.userAgent.match(/(iPad|iPhone|iPod)/i)) Modernizr.load("/js/libs/ios-orientationchange-fix.min.js");</script>

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