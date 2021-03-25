<?php
/**
 * Controller for the home page.
 * @link https://wuwana.com/
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

if(filter_has_var(INPUT_GET, 'logout'))
{ $user->logout(); }

require 'homepage/text ' . $language->code . '.php';

if (!filter_has_var(INPUT_GET, 'search'))
{
	require 'homepage/view search.php';
	exit;
}

$locations = (new DataAccess\Location())->selectUsefulItemsOnly('ES',$language->code);

//commented out this since its not needed
//$limit = filter_has_var(INPUT_GET, 'show') ? 0 : 8;

$selectedRegions = [];

foreach ($locations as $id => $unused)
{
	if (filter_has_var(INPUT_GET, 'region' . $id))
	{
		$selectedRegions[] = $id;
		$limit = 0;
	}
}

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$allCompanies = (new DataAccess\Company())->search($search, $selectedRegions);
$allCompanies->setTagsLanguage($language->code);

$companies = [];
$counter = 0;

// Fetch only the 8 first companies
foreach ($allCompanies as $permalink => $company)
{
	$companies[$permalink] = $company;

	if (++$counter >= 8)
	{ break; }
}

//TODO: search more if $allCompanies->counter = 0

$allCompanies->forward();  // Then just count the rest
$jsParam = $allCompanies->counter . ',' . json_encode($selectedRegions, JSON_NUMERIC_CHECK);

$pageCount = 1;  // keeps count of how many times a 8-company-result has been returned

require 'homepage/view result.php';