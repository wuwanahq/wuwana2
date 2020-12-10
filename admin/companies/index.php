<?php
/**
 * Controller for the admin page.
 * @link https://wuwana.com/admin/companies
 */

spl_autoload_register(function($className) {
	require '../../Models/' . str_replace('\\', '/', $className) . '.php';
});

$user = new WebApp\UserSession(WebApp\Data::getUser());

if ($user->isAdmin() && filter_has_var(INPUT_POST, 'instagram'))
{
	$scraper = new Scraper\Scraper(WebApp\Data::getTagIterator());
	$company = $scraper->extractData(filter_input(INPUT_POST, 'instagram'));

	if (filter_input(INPUT_POST, 'website') != null)  // or false or empty string
	{ $company->website = filter_input(INPUT_POST, 'website'); }

	if (filter_input(INPUT_POST, 'email') != null)  // or false or empty string
	{ $company->email = filter_input(INPUT_POST, 'email'); }

	WebApp\Data::getCompany()->insert($company);
}

//TODO: create CompaniesIterator
$companies = WebApp\Data::getCompany()->selectAll();

$language = WebApp\WebApp::getLanguageCode();
require '../../Templates/text ' . $language . '.php';
//require 'text ' . $language . '.php';
require 'view.php';