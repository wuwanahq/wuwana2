<?php
/**
 * Router for permanent link redirection to profile page and controller for the company page.
 * @link https://wuwana.com/company-name...
 * @see http://httpd.apache.org/docs/current/mod/mod_dir.html#fallbackresource Apache FallbackResource directive (mod_dir)
 * @see http://nginx.org/en/docs/http/ngx_http_core_module.html#try_files Nginx "try_files" directive (core module)
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

$language = WebApp\WebApp::getLanguageCode();
$company = WebApp\Data::getCompanyInfo(str_replace('/', '', filter_input(INPUT_SERVER, 'REQUEST_URI')), $language);

require 'Templates/text ' . $language . '.php';

if ($company == null)
{
	if (php_sapi_name() == 'cli-server')
	{ return false; }

	trigger_error('URL ' . filter_input(INPUT_SERVER, 'REQUEST_URI') . ' not found', E_USER_NOTICE);
	http_response_code(404);
	require '404/text ' . $language . '.php';
	require '404/view.php';
	exit;
}

$user = new WebApp\UserSession(WebApp\Data::getUser());

require 'company/text ' . $language . '.php';
require 'company/view.php';