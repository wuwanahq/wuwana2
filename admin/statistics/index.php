<?php
/**
 * Controller for the admin page.
 * @link https://wuwana.com/admin
 */

spl_autoload_register(function($className) {
	require '../../Models/' . str_replace('\\', '/', $className) . '.php';
});

$language = WebApp\WebApp::getLanguageCode();
require '../../Templates/text ' . $language . '.php';
//require 'text ' . $language . '.php';
require 'view.php';

if (memory_get_peak_usage() > WebApp\WebApp::MEMORY_LIMIT)
{ trigger_error(memory_get_peak_usage() . ' Bytes of memory used', E_USER_NOTICE); }