<?php
/**
 * Controller for the 404 error page.
 */

http_response_code(404);
trigger_error('URL ' . filter_input(INPUT_SERVER, 'REQUEST_URI') . ' not found', E_USER_NOTICE);