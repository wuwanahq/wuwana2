<?php
/**
 * Controller for the 404 error page.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

http_response_code(404);

$companies = [];
$search = str_replace('/', '', $url);

while (strlen($search) > 2 && count($companies) == 0)
{
	foreach ((new DataAccess\Company())->searchColumn('Company.Name', $search) as $permalink => $company)
	{ $companies[$permalink] = $company; }

	$search = substr($search, 0, -1);
}

require '404/text ' . $language->code . '.php';
require '404/view.php';

if (php_sapi_name() != 'cli-server')
{ trigger_error('URL ' . filter_input(INPUT_SERVER, 'REQUEST_URI') . ' not found', E_USER_NOTICE); }