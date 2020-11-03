<?php
/**
 * Router for permanent link redirection to profile page.
 * @link https://wuwana.com/company-name...
 * @see /.htaccess Apache "FallbackResource" or Nginx "try_files" directive
 */

if ($_SERVER["REQUEST_URI"] == '/'
	|| substr($_SERVER["REQUEST_URI"], 0, 2) == '/?'
	|| substr($_SERVER["REQUEST_URI"], 0, 8) == '/static/')
{
	return false;  // Serve the requested resource as-is with the PHP built-in web server
}

require 'company/index.php';