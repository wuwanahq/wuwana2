<?php
/**
 * Controller for the company page.
 * @link https://wuwana.com/company
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

// To test
$company = new DataAccess\Company();
$company->permalink = 'example-coffe-shop';
$company->name = 'Example Coffee Shop';
$company->description = 'Description about this company...';
$company->email = 'jonathan@wuwana.com';
$company->logo = '/static/logo/square1.svg';
$company->phone = '34123456789';
$company->region = 'Cataluna';
$company->website = 'https://wuwana.com';
$company->tags = ['TagOne', 'TagTwo'];
$company->address = '...';

$user = new WebApp\UserSession(WebApp\Data::getUser());

if (filter_has_var(INPUT_POST, 'instagram') && filter_has_var(INPUT_POST, 'etc...'))
{
	$scraper = new Scraper\Scraper(WebApp\Data::getTagIterator());
	$data = $scraper->extractData(
		filter_input(INPUT_POST, 'instagram'),
		filter_input(INPUT_POST, 'website'),
		filter_input(INPUT_POST, 'facebook'),
		filter_input(INPUT_POST, 'etc...')
	);

	//TODO: $db->storeTags($data);
}

$root = '../';
$language = WebApp\WebApp::getLanguageCode();
require '../Templates/text ' . $language . '.php';
require 'text ' . $language . '.php';
require 'view.php';