<?php
/**
 * Controller for the company page.
 * @link https://wuwana.com/company
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

$language = WebApp\WebApp::getLanguageCode();
//require 'text ' . $language . '.php';
require 'view.php';