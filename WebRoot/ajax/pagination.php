<?php
/**
 * Handle the XmlHttpRequest for company pagination.
 * @link https://wuwana.com/ajax/pagination.php XMLHttpRequest (JavaScript)
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

$language = WebApp\WebApp::getLanguage();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$pageCount = $_POST['pageCount'];
	$selectedRegions = json_decode(stripslashes($_POST['selectedRegions']));

	$locations = (new DataAccess\Location())->selectUsefulItemsOnly('es',$language->code);
	$companies = (new DataAccess\Company())->selectRegions($language, $selectedRegions, 0);
	$companies = array_splice($companies,($pageCount*8),8);
	$counter = count($companies);

	$output = '';

	foreach ($companies as $permalink => $company)
	{
		$output .= '<a class="card" href="/'. $permalink.'">
			<div class="logo-main margin-r16">
				<img src="'. $company->logo.'" alt="logo" onerror="setDefaultImg()">
			</div>
			<div class="company-card-wrapper">
				<div class="company-card-info">
					<h3>'.$company->name.'</h3>
					<ul class="tag-area">
						<li>'.implode('</li><li>', $company->tags).'</li>
					</ul>
					<div class="button-icon-small margin-t-auto">
						<img src="/static/icon/tiny/map.svg" alt="">
						'. $company->region.'
					</div>
				</div>
				<div class="company-card-badge-wrapper"></div>
			</div>
		</a>';

		if (--$counter > 0)
		{ $output .= '<hr>'; }
	}

	echo '<hr>' . $output;
}