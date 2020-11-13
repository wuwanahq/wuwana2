<?php
/**
 * Async controller for login request by email.
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

if (filter_has_var(INPUT_POST, 'email'))
{
	$db = new DataAccess\DataAccess(WebApp\WebApp::getDatabase());
	$user = new WebApp\UserSession($db);
	$user->sendEmail(filter_input(INPUT_POST, 'email'));
}