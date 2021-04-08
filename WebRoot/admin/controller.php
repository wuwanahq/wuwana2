<?php
/**
 * Controller for the admin page.
 * @link https://wuwana.com/admin
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

$commit = '';

if($user->isAdmin())
{ $commit = WebApp\WebApp::gitLastCommit(); }

require 'admin/view.php';