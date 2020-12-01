<?php
/**
 * Router for permanent link redirection to profile page.
 * @link https://wuwana.com/company-name...
 * @see /.htaccess Apache "FallbackResource" or Nginx "try_files" directive
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

$company = WebApp\Data::getCompanyInfo(str_replace('/', '', filter_input(INPUT_SERVER, 'REQUEST_URI')));

if ($company == null)
{ return false; }

require 'company/index.php';