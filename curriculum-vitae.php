<?php 
require_once("atlantis_core/base.inc.php");

include('inc/config.inc.php');
include(DOCUMENT_ROOT . '/inc/default-dtd.inc.php'); 
?>
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
				Hieronder staan websites waar ik onder andere aan (mee)gewerkt hebt bij diverse werkgevers.
			</p>
<?php
$sites_list = new mod_sites();
//$sites_list->order_by = "si_title";
$sites_list->sites_list();
?>
		</section>
	</div>

	<?php include(DOCUMENT_ROOT . '/inc/footer.inc.php'); ?>
</div>

<?php include(DOCUMENT_ROOT . '/inc/common-scripts.inc.php'); ?>
</body>
</html>