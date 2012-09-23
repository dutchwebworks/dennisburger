<?php 
include('inc/config.inc.php');
include(DOCUMENT_ROOT . '/inc/default-dtd.inc.php'); 
?>

<head>
<?php include(DOCUMENT_ROOT . '/inc/default-html-head.inc.php'); ?>

<link rel="canonical" href="/">
<meta name="description" content="">

<title>Dennis Burger :: Webdesign</title>

</head>
<body>
<div id="wrapper">
	<?php include(DOCUMENT_ROOT . '/inc/header.inc.php'); ?>

	<div id="main" role="main">
		<section class="photoCarousel" class="gridRow">
			<ul>
				<li><a href="/content/alkmaar-kaasmarkt.jpg"><img src="/content/alkmaar-kaasmarkt.jpg" alt=""></a></li>
				<li><a href="/content/castricum-sunset.jpg"><img src="/content/castricum-sunset.jpg" alt=""></a></li>
				<li><a href="/content/duiven-night.jpg"><img src="/content/duiven-night.jpg" alt=""></a></li>
				<li><a href="/content/madurodam-pano.jpg"><img src="/content/madurodam-pano.jpg" alt=""></a></li>
				<li><a href="/content/ns-traintrack.jpg"><img src="/content/ns-traintrack.jpg" alt=""></a></li>
				<li><a href="/content/streets-madurodam.jpg"><img src="/content/streets-madurodam.jpg" alt=""></a></li>		
			</ul>
		</section>

		<section id="webdesign" class="block gridRow">
			<h2>Webdesign</h2>

			<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>	

			<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>			
		</section>
	</div>

	<?php include(DOCUMENT_ROOT . '/inc/footer.inc.php'); ?>
</div>

<?php include(DOCUMENT_ROOT . '/inc/common-scripts.inc.php'); ?>

<script>
// Photoswipe
$(document).ready(function(){ $(".photoCarousel a").photoSwipe(); });
</script>

</body>
</html>