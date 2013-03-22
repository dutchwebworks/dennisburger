<?php 
include('inc/config.inc.php');
include(DOCUMENT_ROOT . '/inc/default-dtd.inc.php'); 
?>

<head>
<?php include(DOCUMENT_ROOT . '/inc/default-html-head.inc.php'); ?>

<link rel="canonical" href="/">
<meta name="description" content="">

<title>Dennis Burger :: Website</title>

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

		<section id="welkom" class="block gridRow">
			<h1>Welkom op mijn website</h1>
		
			<div class="gridContainer_12">
				<div class="grid_4">
					<div data-device-tablet="/fragments/tablet.html"></div>
					<p>
						Introductie. Consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>

				<div class="grid_4">
					<div data-device-desktop="/fragments/banner.html"></div>
					<p>
						Introductie. Consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>

				<div class="grid_4">
					<p>
						Introductie. Consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					</p>
				</div>
			</div>
		</section>
	</div>

	<?php include(DOCUMENT_ROOT . '/inc/footer.inc.php'); ?>
</div>

<?php include(DOCUMENT_ROOT . '/inc/common-scripts.inc.php'); ?>

</body>
</html>