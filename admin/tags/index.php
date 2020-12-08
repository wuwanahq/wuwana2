<?php
/**
 * Controller for the admin page.
 * @link https://wuwana.com/admin/tags
 */

spl_autoload_register(function($className) {
	require '../../Models/' . str_replace('\\', '/', $className) . '.php';
});

if (/* $user->isAdmin() && */ filter_has_var(INPUT_POST, 'TagName'))
{
	$tag = new DataAccess\Tag();
	$tag->name = filter_input(INPUT_POST, 'TagName');
	$tag->keywords = filter_input(INPUT_POST, 'Keywords');
	$tag->isVisible = filter_has_var(INPUT_POST, 'Visible');
}

$tags = WebApp\Data::getTagIterator();

$language = WebApp\WebApp::getLanguageCode();
require '../../Templates/text ' . $language . '.php';
//require 'text ' . $language . '.php';
require 'view.php';