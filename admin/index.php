<?php
/**
 * Controller for the admin page.
 * @link https://wuwana.com/admin
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

//$language = WebApp\WebApp::getLanguageCode();
//require 'text ' . $language . '.php';
require 'view.php';