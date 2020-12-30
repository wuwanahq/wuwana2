<?php
/**
 * Controller for the admin page to manage tags.
 * @link https://wuwana.com/admin/tags
 */

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