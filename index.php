<?php
/**
 * Controller for the home page.
 * @link https://wuwana.com/
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

$categories = WebApp\Data::getCategory()->selectAll();
$locations = WebApp\Data::getLocation()->selectUsefulItemsOnly();

$limit = filter_has_var(INPUT_GET, 'show') ? 0 : 8;

$selectedCategories = [];
$selectedRegions = [];

if (filter_has_var(INPUT_GET, 'cat'))
{
	foreach ($categories as $key => $value)
	{
		if (filter_has_var(INPUT_GET, 'cat' . $key))
		{ $selectedCategories[] = $key; }
	}

	$limit = 0;
}

if (filter_has_var(INPUT_GET, 'region'))
{
	foreach ($locations as $key => $value)
	{
		if (filter_has_var(INPUT_GET, 'region' . $key))
		{ $selectedRegions[] = $key; }
	}

	$limit = 0;
}

$user = new WebApp\UserSession(WebApp\Data::getUser());

if(filter_has_var(INPUT_GET, 'logout'))
{ $user->logout(); }

//$companies = WebApp\Data::getCompany()->selectCategoriesRegions($selectedCategories, $selectedRegions, $limit);
$companies = WebApp\Data::getCompany()->selectCategoriesRegions([], $selectedRegions, $limit);

$language = WebApp\WebApp::getLanguageCode();
require 'Templates/text ' . $language . '.php';
require 'homepage/text ' . $language . '.php';
require 'homepage/view.php';