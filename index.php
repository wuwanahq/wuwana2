<?php
/**
 * Controller for the home page.
 * @link http://wuwana.com/
 */

spl_autoload_register(function($className) {
	require 'Model/' . str_replace('\\', '/', $className) . '.php';
});

$db = new DataAccess\DataAccess(WebApp\WebApp::getDatabase());
$categories = $db->getCategories();
$locations = $db->getLocations();
$selectedCategories = [];
$selectedRegions = [];

if (count($_GET) > 0)
{
	$totalCategory = count($categories);
	$totalLocation = count($locations);

	for ($i = 1; $i <= $totalCategory; ++$i)
	{
		if (filter_has_var(INPUT_GET, 'cat' . $i))
		{ $selectedCategories[] = $i; }
	}

	for ($i = 1; $i <= $totalLocation; ++$i)
	{
		if (filter_has_var(INPUT_GET, 'region' . $i))
		{ $selectedRegions[] = $i; }
	}
}

$companies = $db->getCompanies($selectedCategories, $selectedRegions);

require 'homepage/view.php';