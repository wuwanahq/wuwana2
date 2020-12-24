<?php
/**
 * Controller for the admin page.
 * @link https://wuwana.com/admin/tags
 */

spl_autoload_register(function($className) {
	require '../../Models/' . str_replace('\\', '/', $className) . '.php';
});

$user = new WebApp\UserSession(WebApp\Data::getUser());

if (/* $user->isAdmin() && */ filter_has_var(INPUT_POST, 'TagNames'))
{
	$tag = new DataAccess\TagObject();
	$tag->names = trim(filter_input(INPUT_POST, 'TagNames'));
	$tag->keywords = strtolower(trim(filter_input(INPUT_POST, 'Keywords')));

	WebApp\Data::getTag()->insert(filter_input(INPUT_POST, 'TagID'), $tag);
}

$tags = WebApp\Data::getTag();
$baseTags = $tags->selectBaseTags();
$combinedTags = $tags->selectCombinations();

$language = WebApp\WebApp::getLanguageCode();
require '../../Templates/text ' . $language . '.php';
//require 'text ' . $language . '.php';
require 'view.php';

if (memory_get_peak_usage() > WebApp\WebApp::MEMORY_LIMIT)
{ trigger_error(memory_get_peak_usage() . ' Bytes of memory used', E_USER_NOTICE); }