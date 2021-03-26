<?php
/**
 * Handle the XmlHttpRequest for company pagination.
 * @link https://wuwana.com/ajax/pagination.php XMLHttpRequest (JavaScript)
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

const PAGING_SIZE = 8;

$inputs = filter_input_array(INPUT_POST,
[
	'pageCount' => FILTER_VALIDATE_INT,
	'selectedRegions' => FILTER_SANITIZE_STRING,
	'search' => FILTER_SANITIZE_STRING
]);

if ($inputs['pageCount'] > 0 && $inputs['selectedRegions'] != null && $inputs['search'] != null)
{
	$companies = (new DataAccess\Company())->search(
		$inputs['search'],
		json_decode(stripslashes($inputs['selectedRegions'])),
		WebApp\WebApp::getLanguage()->code,
		PAGING_SIZE,
		$inputs['pageCount'] * PAGING_SIZE);

	WebApp\ViewComponent::printCompanyCards($companies, true);
}