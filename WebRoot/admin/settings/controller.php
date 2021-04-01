<?php
/**
 * Controller for the settings page.
 * @link https://wuwana.com/admin/settings
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

$inputs = filter_input_array(INPUT_GET,
	[
		'ForceHTTPS'       => FILTER_SANITIZE_STRING,
		'SessionLifetime'  => FILTER_VALIDATE_INT,
		'MaxResultSearch'  => FILTER_VALIDATE_INT,
		'MaxResultPage404' => FILTER_VALIDATE_INT,
		'DefaultLanguage'  => FILTER_SANITIZE_STRING
	]);

if ($user->isAdmin()
	&& isset($inputs['ForceHTTPS'])
	&& isset($inputs['SessionLifetime'])
	&& isset($inputs['MaxResultSearch'])
	&& isset($inputs['MaxResultPage404'])
	&& isset($inputs['DefaultLanguage']))
{
	if ($inputs['ForceHTTPS'] != 'no' && $inputs['ForceHTTPS'] != 'yes')
	{ unset($inputs['ForceHTTPS']); }

	if ($inputs['SessionLifetime'] < 1)
	{ unset($inputs['SessionLifetime']); }

	if ($inputs['MaxResultSearch'] < 1)
	{ unset($inputs['MaxResultSearch']); }

	if ($inputs['MaxResultPage404'] < 1)
	{ unset($inputs['MaxResultPage404']); }

	if (!isset(WebApp\Language::CODES[$inputs['DefaultLanguage']]))
	{ unset($inputs['DefaultLanguage']); }

	if (count($inputs) > 0)
	{
		$dao = new DataAccess\AppSettings();
		$dao->updateAll($inputs);
		$settings = $dao->selectAll();
	}
}

require 'admin/settings/view.php';