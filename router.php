<?php
/**
 * Router for permanent link redirection to profile page and controller for the company page.
 * @link https://wuwana.com/company-name...
 * @see http://httpd.apache.org/docs/current/mod/mod_dir.html#fallbackresource Apache FallbackResource directive (mod_dir)
 * @see http://nginx.org/en/docs/http/ngx_http_core_module.html#try_files Nginx "try_files" directive (core module)
 * @see https://www.php.net/manual/en/features.commandline.webserver.php PHP built-in web server using a router script
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

$language = WebApp\WebApp::getLanguageCode();
$company = WebApp\Data::getCompanyInfo(str_replace('/', '', filter_input(INPUT_SERVER, 'REQUEST_URI')), $language);

if ($company instanceof \DataAccess\CompanyObject)
{
	$user = new WebApp\UserSession(WebApp\Data::getUser());

	require 'Templates/text ' . $language . '.php';
	require 'company/text ' . $language . '.php';
	require 'company/view.php';
}
else
{
	if (php_sapi_name() == 'cli-server')
	{ return false; }

	trigger_error('URL ' . filter_input(INPUT_SERVER, 'REQUEST_URI') . ' not found', E_USER_NOTICE);
	http_response_code(404);

	require 'Templates/text ' . $language . '.php';
	require '404/text ' . $language . '.php';
	require '404/view.php';
}

if (memory_get_peak_usage() > WebApp\WebApp::MEMORY_LIMIT)
{ trigger_error(memory_get_peak_usage() . ' Bytes of memory used', E_USER_NOTICE); }