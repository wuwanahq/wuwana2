<?php
/**
 * Controller for the company page.
 * @link https://wuwana.com/company
 */

if (empty($company))
{
	spl_autoload_register(function($className) {
		require '../Models/' . str_replace('\\', '/', $className) . '.php';
	});
}

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

// To test
$company = new Scraper\CompanyData();
$company->name = 'Example Coffee Shop';
$company->description = 'This is an example';
$company->email = 'jonathan@wuwana.com';
$company->logoURL = '/static/logo/square1.svg';
$company->permalink = 'company';
$company->phoneNumber = '0123456789';
$company->region = 0;
$company->website = 'https://wuwana.com';
$company->address;
$company->tags = [];
$company->instagram = new DataAccess\SocialMedia([
	'SocialMedia.URL' => 'https://www.instagram.com/levogirar',
	'SocialMedia.ProfileName' => 'ExampleCoffeeShop',
	'SocialMedia.Biography' => 'Bla bla bla...',
	'SocialMedia.Link' => 'https://wuwana.es',
	'SocialMedia.Counter1' => 1,
	'SocialMedia.Counter2' => 2,
	'SocialMedia.Counter3' => 3
]);

$company->instagram->pictures = [
	'/static/logo/square2.svg',
	'/static/logo/square3.svg',
	'/static/logo/square4.svg',
	'/static/logo/square5.svg',
	'/static/logo/square6.svg',
	'/static/logo/square7.svg',
];

$language = WebApp\WebApp::getLanguageCode();
require '../Templates/text es.php';
require 'text ' . $language . '.php';
require 'view.php';