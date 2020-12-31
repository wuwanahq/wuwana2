<?php
/**
 * Router or front controller (WebApp entry point).
 * @see http://httpd.apache.org/docs/current/mod/mod_dir.html#fallbackresource Apache FallbackResource directive (mod_dir)
 * @see http://nginx.org/en/docs/http/ngx_http_core_module.html#try_files Nginx "try_files" directive (core module)
 * @see https://www.php.net/manual/en/features.commandline.webserver.php PHP built-in web server using a router script
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

// Global variables available in all views and controllers
$language = WebApp\WebApp::getLanguageCode();
$user = new WebApp\UserSession(WebApp\Data::getUser());
$url = WebApp\WebApp::getURL();

require 'Templates/text ' . $language . '.php';

switch ($url)
{
	case '/':
		require 'homepage/text ' . $language . '.php';
		require 'homepage/controller.php';
		require 'homepage/view.php';
		break;

	case '/admin/statistics':
	case '/admin/categories':
	case '/admin/companies':
	case '/admin/database':
	case '/admin/tags':
	case '/admin/users':
		$page = substr($url, 1);
		require $page . '/controller.php';
		require $page . '/view.php';
		break;

	case '/ajax/email':
		require 'ajax/email/text ' . $language . '.php';
		require 'ajax/email/controller.php';
		break;  // There is no view with AJAX request

	default:
		if (php_sapi_name() == 'cli-server' && substr($url, 0, 7) == '/static')
		{ return false; }

		// Controller for the company page
		$company = WebApp\Data::getCompanyInfo(str_replace('/', '', $url), $language);

		if ($company instanceof DataAccess\CompanyObject)
		{
			require 'company/text ' . $language . '.php';
			require 'company/view.php';
		}
		else  // No permalink found so display the error page
		{
			require '404/text ' . $language . '.php';
			require '404/controller.php';
			require '404/view.php';
		}
}

// Track memory usage
if (memory_get_peak_usage() > WebApp\WebApp::MEMORY_LIMIT)
{ trigger_error(memory_get_peak_usage() . ' Bytes of memory used with the URL ' . $url, E_USER_NOTICE); }