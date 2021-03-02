<?php
/**
 * Front controller (WebApp entry point) for all URL except static resources and AJAX requests.
 * @see http://httpd.apache.org/docs/current/mod/mod_dir.html#fallbackresource Apache FallbackResource (mod_dir)
 * @see http://nginx.org/en/docs/http/ngx_http_core_module.html#try_files Nginx "try_files" directive (core module)
 * @see https://www.php.net/manual/en/features.commandline.webserver.php PHP built-in web server using router script
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

//force redirect to https
if (!WebApp\WebApp::isSecure() && php_sapi_name() != 'cli-server')
{
	header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], TRUE, 301);
	exit;
}

// Global variables available in all views and controllers
$language = WebApp\WebApp::getLanguage();
$user = new WebApp\UserSession(WebApp\Data::getUser());
$url = WebApp\WebApp::getURL();

require 'Templates/text ' . $language->code . '.php';

switch ($url)
{
	case '/':
		require 'homepage/text ' . $language->code . '.php';
		require 'homepage/controller.php';
		require 'homepage/view.php';
		break;

	case '/privacy':
		$page = substr($url, 1);
		require $page . '/text ' . $language->code . '.php';
		require $page . '/view.php';
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

	default:
		if (php_sapi_name() == 'cli-server')
		{
			switch (substr($url, 0, 6))
			{
				case '/stati':  // static resources
				case '/ajax/':  // There is no view with AJAX request
					return false;
			}
		}

		// Controller for the company page
		$company = WebApp\Data::getCompanyInfo(str_replace('/', '', $url), strtoupper($language->code));

		if ($company instanceof DataAccess\CompanyData)
		{
			require 'company/text ' . $language->code . '.php';
			require 'company/view.php';
		}
		else  // No permalink found so display the error page
		{
			require '404/text ' . $language->code . '.php';
			require '404/controller.php';
			require '404/view.php';
		}
}

// Track memory usage
if (memory_get_peak_usage() > WebApp\WebApp::MEMORY_LIMIT)
{ trigger_error(memory_get_peak_usage() . ' Bytes of memory used with the URL ' . $url, E_USER_NOTICE); }