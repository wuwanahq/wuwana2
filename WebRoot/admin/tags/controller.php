<?php
/**
 * Controller for the admin page to manage tags.
 * @link https://wuwana.com/admin/tags
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

$baseTags = [];
$combinedTags = [];

if ($user->isAdmin())
{
	$tagStorage = new DataAccess\Tag();

	if (filter_has_var(INPUT_POST, 'TagNames'))
	{
		$tag = new DataAccess\TagData();
		$tag->names = trim(filter_input(INPUT_POST, 'TagNames'));
		$tag->keywords = strtolower(trim(filter_input(INPUT_POST, 'Keywords')));

		$tagStorage->insert(filter_input(INPUT_POST, 'TagID'), $tag);
	}

	$baseTags = $tagStorage->selectBaseTags();
	$combinedTags = $tagStorage->selectCombinations();
}