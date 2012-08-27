<?php
// PHP ini settings override
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// Define constants
define('DOCUMENT_ROOT', getenv('DOCUMENT_ROOT'));

// List of test server hostname (this disables the Google Analytics)
$live_servers[] = 'dennisburger.nl';
$live_servers[] = 'dennisburger.dutchwebworks.nl';
//$live_servers[] = 'dennisburger.local.lucius.nl';

// Settings
$enable_ga = false; // Init Google Analytics

// Overrides
$settings['enable_ga'] = false; // Override the test servers and force enable the Google Analytics

// Check for test server to disable the Google Analytics javascript piece
if(in_array($_SERVER['HTTP_HOST'], $live_servers) || $settings['enable_ga']) $enable_ga = true;
?>