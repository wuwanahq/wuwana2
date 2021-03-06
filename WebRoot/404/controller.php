<?php
/**
 * Controller for the 404 error page.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */

http_response_code(404);

if (php_sapi_name() != 'cli-server')
{ trigger_error('URL ' . filter_input(INPUT_SERVER, 'REQUEST_URI') . ' not found', E_USER_NOTICE); }