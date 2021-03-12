<?php
/**
 * Controller for the home page.
 * @link https://wuwana.com/
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

$categories = (new DataAccess\Category())->selectAll();
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

if(filter_has_var(INPUT_GET, 'logout'))
{ $user->logout(); }

//TODO: create CompanyIterator
//fetch all companies
$allCompanies = (new DataAccess\Company())->selectCategoriesRegions($language, [], $selectedRegions, 0);
$allCompaniesCount = count($allCompanies);      //count all companies
$companies = array_splice($allCompanies,0,8);       //obtain an array of values from position 0 - 7
$counter = count($companies);

$pageCount = 1;     //keeps count of how many times a 8-company-result has been returned