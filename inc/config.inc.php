<?php
define('DOCUMENT_ROOT', getenv('DOCUMENT_ROOT'));
$settings['ga_on_testserver'] = false;

// List of test server hostname (this disables the Google Analytics)
$test_servers[] = 'dennisburger.local.lucius.nl';
$test_servers[] = 'dennisburger.dutchwebworks.nl';

// Check for test server to disable the Google Analytics javascript piece
if(in_array($_SERVER['HTTP_HOST'], $test_servers)) define('ENABLE_GA', false);
?>