<?php
/**
 * Router for permanent link redirection to profile page.
 * And controller for the company page.
 * @link https://wuwana.com/company-name...
 * @see /.htaccess Apache "FallbackResource" or Nginx "try_files" directive
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

$requestURL = str_replace('/', '', filter_input(INPUT_SERVER, 'REQUEST_URI'));

if ($requestURL == '' || $requestURL[0] == '?' || strpos($requestURL, '.') !== false)
{
	if (php_sapi_name() == 'cli-server')
	{ return false; }

	http_response_code(404);
	exit;
}

$company = WebApp\Data::getCompanyInfo($requestURL);

if ($company == null)
{
	if (php_sapi_name() == 'cli-server')
	{ return false; }

	trigger_error('Requested URL ' . filter_input(INPUT_SERVER, 'REQUEST_URI') . ' not found', E_USER_NOTICE);
	http_response_code(404);
	exit;
}

$user = new WebApp\UserSession(WebApp\Data::getUser());

$language = WebApp\WebApp::getLanguageCode();
require 'Templates/text ' . $language . '.php';
require 'company/text ' . $language . '.php';
require 'company/view.php';