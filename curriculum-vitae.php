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
		<section id="cv" class="gridRow">
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
enquire.register("(min-width:" + mqbreakpoint01 + "px)", {
	// When viewport is wider than breakpoint
	// 'setup' is triggert once
    setup : function() {
		$('#cvWebsites li').each(function(){
			var cvImage = $('<img>');
			cvImage.attr({src: $(this).attr('data-src'), alt: $('h3', this).text()});
			$(this).prepend(cvImage);
		});
    },
    // only trigger when breapoints matches
    deferSetup : true
});
</script>

</body>
</html>