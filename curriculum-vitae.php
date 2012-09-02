<?php include('inc/config.inc.php'); ?>
<?php include(DOCUMENT_ROOT . '/inc/default-dtd.inc.php'); ?>
<head>
<?php include(DOCUMENT_ROOT . '/inc/default-html-head.inc.php'); ?>

<link rel="canonical" href="/">
<meta name="description" content="">

<title>Dennis Burger :: Curriculum Vitae</title>

</head>
<body>
<div id="wrapper">
	<?php include(DOCUMENT_ROOT . '/inc/header.inc.php'); ?>

	<div id="main" role="main">
		<section id="cv" class="block gridRow">
			<h1>Curriculum Vitae</h1>

			<p>
				Hieronder staan websites waar ik onder andere aan (mee)gewerkt hebt bij diverse
				werkgevers.
			</p>

			<ul id="cvWebsites">
				<li data-src="/img/cv/baobab-2011.jpg">
					<h3><a href="http://baobab.nl">&rsaquo; Baobab Reizen</a></h3>

					<p>
						Reis website gemaakt door Poort80
					</p>
				</li>
				<li data-src="/img/cv/ben-2011.jpg">
					<h3><a href="http://ben.nl">&rsaquo;Ben</a></h3>

					<p>
						Nieuwe website van Ben. Sinds de eerste release in begin 2011 blijven we updates en uitbredingen maken.
					</p>
				</li>
				<li data-src="/img/cv/das-2011.jpg">
					<h3><a href="http://das.nl">&rsaquo; DAS</a></h3>

					<p>
						Redesign rechts- bijstandsverzekeringen
					</p>
				</li>
				<li data-src="/img/cv/destulp-2011.jpg">
					<h3><a href="http://destulp.nl">&rsaquo; DeStulp</a></h3>

					<p>
						Beloningsmateriaal en stickers voor scholen
					</p>
				</li>
			</ul>

		</section>
	</div>

	<?php include(DOCUMENT_ROOT . '/inc/footer.inc.php'); ?>
</div>

<?php include(DOCUMENT_ROOT . '/inc/common-scripts.inc.php'); ?>

<script>
// Document load
$(document).ready(function() {
	// Check for greater viewport width than CSS3 MediaQuery 1
	if(Modernizr.mq('(min-width: ' + mqbreakpoint01 + 'px)')) {
		// Lazy load images
		var lazy = Utils.q('[data-src]');
		for (var i = 0; i < lazy.length; i++) {
			var source = lazy[i].getAttribute('data-src');
			//create the image
			var img = new Image();
			img.src = source;
			//insert it inside of the link
			lazy[i].insertBefore(img, lazy[i].firstChild);
		};
	}	
});	
</script>

</body>
</html>