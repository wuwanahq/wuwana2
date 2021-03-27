<?php
namespace Scraper;
use DataAccess\Tag;

/**
 * Tag engine used to detect keywords in text content.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class RegexTagger
{
	private $tagStorage;

	/**
	 * Constructor.
	 * @param Tag $tagAccess
	 */
	public function __construct(Tag $tagAccess)
	{
		$this->tagStorage = $tagAccess;
	}

	/**
	 * Detect basic tags.
	 * @todo Move this method into a dedicated class (RegexTagger)
	 * @param string $content
	 * @return array
	 */
	public function getBasicTags($content)
	{
		$tags = [];

		foreach ($this->tagStorage->selectBaseTags() as $id => $tag)
		{
			$score = preg_match_all('/' . $tag->keywords . '/i', $content);

			if ($score > 0)
			{ $tags[$id] = $score; }
		}

		arsort($tags, SORT_NUMERIC);
		return array_keys($tags);
	}

	/**
	 * Detect combined tags with keywords pair.
	 * @param string $content
	 * @param array $basicTags
	 * @return array
	 */
	public function getCombinedTags($content, array $basicTags)
	{
		$basicTags = array_flip($basicTags);

		foreach ($this->tagStorage->selectBaseTags() as $id => $tag)
		{
			if (isset($basicTags[$id]))
			{ $basicTags[$id] = $tag->keywords; }
		}

		$tags = [];

		foreach ($this->tagStorage->selectCombinations() as $id => $tag)
		{
			if (isset($basicTags[$id]))
			{ $basicTags[$id] = $tag->keywords; }

			foreach ($basicTags as $id1 => $regex1)
			{
				foreach ($basicTags as $id2 => $regex2)
				{
					if ($id == $id1 . $id2)
					{
						$tags[$id1 . $id2] = 0;
						break 2;
					}
				}
			}
		}

		foreach ($basicTags as $id1 => $regex1)
		{
			foreach ($basicTags as $id2 => $regex2)
			{
				if ($id1 == $id2)
				{ continue; }

				$score = preg_match_all('/(' . $regex1 . ')[a-z ]{0,9}(' . $regex2 . ')/i', $content);

				if ($score == 0)  // or false
				{ continue; }

				if (isset($tags[$id1 . $id2]))
				{ $tags[$id1 . $id2] += $score; }
				elseif (isset($tags[$id2 . $id1]))
				{ $tags[$id2 . $id1] += $score; }
			}
		}

		arsort($tags, SORT_NUMERIC);
		return array_keys($tags);
	}
}