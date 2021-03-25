<?php
/**
 * Handle the XmlHttpRequest for company pagination.
 * @link https://wuwana.com/ajax/pagination.php XMLHttpRequest (JavaScript)
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

$inputs = filter_input_array(INPUT_POST,
[
	'pageCount' => FILTER_VALIDATE_INT,
	'selectedRegions' => FILTER_SANITIZE_STRING,
	'search' => FILTER_SANITIZE_STRING
]);

if ($inputs['pageCount'] > 0 && $inputs['selectedRegions'] != null && $inputs['search'] != null)
{
	$selectedRegions = json_decode(stripslashes($inputs['selectedRegions']));

	$allCompanies = (new DataAccess\Company())->search($inputs['search'], $selectedRegions);
	$allCompanies->setTagsLanguage(WebApp\WebApp::getLanguage()->code);
	$allCompanies->forward($inputs['pageCount'] * 8);

	$companies = [];
	$counter = 0;

	// Fetch only the 8 first companies
	foreach ($allCompanies as $permalink => $company)
	{
		$companies[$permalink] = $company;

		if (++$counter >= 8)
		{ break; }
	}

	WebApp\ViewComponent::printCompanyCards($companies, true);
}