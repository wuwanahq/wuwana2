<?php
/**
 * Controller for the home page.
 * @link https://wuwana.com/
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

if(filter_has_var(INPUT_GET, 'logout'))
{ $user->logout(); }

require 'homepage/text ' . $language->code . '.php';

$search = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING));

if ($search == '')  // or null or false
{
	require 'homepage/view search.php';
	exit;
}

$locations = (new DataAccess\Location())->selectUsefulItemsOnly('ES',$language->code);
$selectedRegions = [];

foreach ($locations as $id => $unused)
{
	if (filter_has_var(INPUT_GET, 'region' . $id))
	{
		$selectedRegions[] = $id;
		$limit = 0;
	}
}

$companies = (new DataAccess\Company())->search(
	$search, $selectedRegions, $language->code, $settings['MaxResultSearch']);

$jsParam = $companies['Counter'] . ',' . json_encode($selectedRegions, JSON_NUMERIC_CHECK);
$pageCount = 1;  // keeps count of how many times a 8-company-result has been returned

require 'homepage/view result.php';