<?php
/**
 * Controller for the company page.
 * @link https://wuwana.com/company
 */

spl_autoload_register(function($className) {
	require 'Model/' . str_replace('\\', '/', $className) . '.php';
});

if ($_SERVER["REQUEST_URI"] == '/'
	|| substr($_SERVER["REQUEST_URI"], 0, 2) == '/?'
	|| substr($_SERVER["REQUEST_URI"], 0, 7) == '/static')
{
	return false;
}

require 'company/view.php';