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

$language = WebApp\WebApp::getLanguageCode();
require '../Templates/text es.php';
//require 'text ' . $language . '.php';
require 'view.php';