<?php
/**
 * Controller for the home page.
 * @link https://wuwana.com/
 */

spl_autoload_register(function($className) {
	require 'Model/' . str_replace('\\', '/', $className) . '.php';
});

$db = new DataAccess\DataAccess(WebApp\WebApp::getDatabase());
$categories = $db->getCategories();
$locations = $db->getLocations(true);

$selectedCategories = [];
$selectedRegions = [];

if (count($_GET) > 0)
{
	if (!filter_has_var(INPUT_GET, 'cat'))
	{
		foreach ($categories as $key => $value)
		{
			if (filter_has_var(INPUT_GET, 'cat' . $key))
			{ $selectedCategories[] = $key; }
		}
	}

	if (!filter_has_var(INPUT_GET, 'region'))
	{
		foreach ($locations as $key => $value)
		{
			if (filter_has_var(INPUT_GET, 'region' . $key))
			{ $selectedRegions[] = $key; }
		}
	}
}

$limit = 8;

if (filter_has_var(INPUT_GET, 'show'))
{ $limit = 0; }

$companies = $db->getCompanies($selectedCategories, $selectedRegions, $limit);
shuffle($companies);

$language = WebApp\WebApp::getLanguageCode();
require 'homepage/text ' . $language . '.php';
require 'homepage/view.php';