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

// Global variables available in all views and controllers
$settings = (new DataAccess\AppSettings())->selectAll();
$language = WebApp\WebApp::getLanguage();
$user = new WebApp\UserSession(new DataAccess\User(), $settings['SessionLifetime']);
$url = WebApp\WebApp::getURL();

if ($settings['ForceHTTPS'] == 'yes' && !WebApp\WebApp::isSecure() && php_sapi_name() != 'cli-server')
{
	header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], TRUE, 301);
	exit;
}

require 'Templates/text ' . $language->code . '.php';

switch ($url)
{
	case '/':                require 'homepage/controller.php'; break;
	case '/privacy':         require 'privacy/controller.php'; break;
	case '/admin':           require 'admin/controller.php'; break;
	case '/admin/stat':      require 'admin/statistics/controller.php'; break;
	case '/admin/settings':  require 'admin/settings/controller.php'; break;
	case '/admin/companies': require 'admin/companies/controller.php'; break;
	case '/admin/database':  require 'admin/database/controller.php'; break;
	case '/admin/tags':      require 'admin/tags/controller.php'; break;
	case '/admin/users':     require 'admin/users/controller.php'; break;
	case '/sitemap.xml':     require 'sitemap.php'; break;

	default:

		if (php_sapi_name() == 'cli-server')  // PHP built-in web server only
		{
			switch (substr($url, 0, 6))
			{
				case '/stati':  // Static resource
				case '/ajax/':  // AJAX request
					return false;
			}
		}

		// Controller for the company page
		$company = WebApp\WebApp::getCompanyInfo(str_replace('/', '', $url), $language->code);

		if ($company instanceof DataAccess\CompanyData)
		{
			require 'company/text ' . $language->code . '.php';
			require 'company/view.php';
		}
		else  // No permalink found so display the error page
		{
			require '404/controller.php';
		}
}

// Track memory usage
if (memory_get_peak_usage() > WebApp\WebApp::MEMORY_LIMIT)
{ trigger_error(memory_get_peak_usage() . ' Bytes of memory used with the URL ' . $url, E_USER_NOTICE); }