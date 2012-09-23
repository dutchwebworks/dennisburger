<?PHP
//error_reporting(E_ALL);
//ini_set('display_errors','On');

// gzip all php output
//ob_start("ob_gzhandler");

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'dennis');
define('DB_PASSWORD', 'bgbcjhd7');
define('DB_NAME', 'dennisburger');

// Database table's
$db_table['sites'] = 					"cv_sites";
$db_table['bedrijven'] =				"cv_bedrijven";

// Settings
// $settings['require_url'] =				$settings['site_root']; 					// $backend wordt gezet door een boolean in pagina zelf
$settings['main_title'] = 				"D. Burger | Curriculum Vitae";
$settings['site_version'] = 			"0.1";
$settings['includes'] = 				"includes/"; 								// User include files
$settings['atlantis_core'] =			"atlantis_core/";							// core directory
$settings['core'] =						"Core/";									// core directory
$settings['module_dir'] = 				$settings['atlantis_core']."modules/";
$settings['module_template_dir'] = 		$settings['module_dir']."templates/";
$settings['atlantis_uploads'] = 		"atlantis_uploads/uploads/";
$settings['gallery_upload_large'] = 	"atlantis_uploads/gallery_large/";
$settings['gallery_upload_thumb'] = 	"atlantis_uploads/gallery_thumb/";
// $settings['article_rss_url'] = 			$settings['site_url']."artikelen/rss";
$settings['thumbnail_dir'] = 			"/img/screendumps/";

// Database abstracion class & template class import
require_once($settings['core']."Database.inc.php");
require_once($settings['core']."Template.inc.php");
require_once($settings['core']."Functions.inc.php");
require_once($settings['core']."Classes.inc.php");

// --------- BEGIN FRONT-END MODULE INCLUSION --------- //
require_once($settings['module_dir']."sites.mod.php");			// Sits pagina
// --------- END FRONT-END MODULE INCLUSION --------- //
?>