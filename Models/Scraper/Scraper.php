<?php
namespace Scraper;
use DataAccess\User;
use DataAccess\Tag;
use DataAccess\Company;
use DataAccess\CompanyObject;
use DataAccess\SocialMediaObject;

/**
 * Web Scraper.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class Scraper
{
	private $storedTag;
	private $storedCompany;

	public function __construct(Tag $tag, Company $company)
	{
		$this->storedTag = $tag;
		$this->storedCompany = $company;
	}

	public function storeCompany($website, $email, $picture, $text, SocialMediaObject $instagram)
	{
		if (filter_var($instagram->link, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) == false)
		{ return; }

		$specialCharacters = ["\r\n", "\n\r", "\r", "\n", "\t", "\v", "\f", "\e"];
		$instagram->profileName = str_replace($specialCharacters, '', $instagram->profileName);
		$instagram->biography = str_replace($specialCharacters, '  ', $instagram->biography);

		$company = new CompanyObject();
		$company->name = $instagram->profileName;
		$company->description = str_replace('  ', ' ', $instagram->biography);
		$company->region = rand(1, 19);
		$company->instagram = $instagram;

		if (filter_var($email, FILTER_VALIDATE_EMAIL) === $email)
		{ $company->email = $email; }

		if (!empty($picture) && filter_var($picture, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === $picture)
		{ $company->logo = $picture; }

		if (!empty($website) && filter_var($website, FILTER_VALIDATE_URL) === $website)
		{ $company->website = $website; }
		elseif (!empty($instagram->link))
		{ $company->website = $instagram->link; }

		$content = $instagram->profileName
			. ';' . $instagram->getUsername()
			. ';' . $instagram->biography
			. ';' . $company->website
			. ';' . $text;

		$company->otherTags = $this->getBasicTags($content);
		$company->visibleTags = $this->getCombinedTags($content, $company->otherTags);

		if (empty($company->visibleTags[0]) && isset($company->otherTags[0]))
		{ $company->visibleTags[0] = array_shift($company->otherTags); }

		while (count($company->visibleTags) > 2)
		{ array_unshift($company->otherTags, array_pop($company->visibleTags)); }

		$this->storedCompany->insert($company);
	}

	private function getBasicTags($content)
	{
		$tags = [];

		foreach ($this->storedTag->selectBaseTags() as $id => $tag)
		{
			$score = preg_match_all('/' . $tag->keywords . '/i', $content);

			if ($score > 0)
			{ $tags[$id] = $score; }
		}

		arsort($tags, SORT_NUMERIC);
		return array_keys($tags);
	}

	private function getCombinedTags($content, array $basicTags)
	{
		$basicTags = array_flip($basicTags);

		foreach ($this->storedTag->selectBaseTags() as $id => $tag)
		{
			if (isset($basicTags[$id]))
			{ $basicTags[$id] = $tag->keywords; }
		}

		$tags = [];

		foreach ($this->storedTag->selectCombinations() as $id => $tag)
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

	private function scrapeInstagram($url)
	{
		$json = file_get_contents($url);
		$positionStart = strpos($json, '<script type="text/javascript">window._sharedData =') + 51;
		$positionEnd = strpos($json, ';</script>', $positionStart);
		$json = substr($json, $positionStart, $positionEnd - $positionStart);
		$json = json_decode($json, false)->entry_data->ProfilePage[0];

		$this->company->name = $json->graphql->user->full_name;
		$this->company->description = $json->graphql->user->biography;
		$this->company->logo = $json->graphql->user->profile_pic_url;
		$this->company->region = rand(1, 19);

		if (isset($json->graphql->user->business_email))
		{ $this->company->email = $json->graphql->user->business_email; }

		$this->company->instagram = new SocialMediaObject();

		if (isset($json->graphql->user->external_url))
		{
			$this->company->website = $json->graphql->user->external_url;
			$this->company->instagram->link = $json->graphql->user->external_url;
		}

		$this->company->instagram->url = 'instagram.com/' . $json->graphql->user->username;
		$this->company->instagram->profileName = $json->graphql->user->full_name;
		$this->company->instagram->biography = $json->graphql->user->biography;
		$this->company->instagram->nbPost = $json->graphql->user->edge_owner_to_timeline_media->count;
		$this->company->instagram->nbFollower = $json->graphql->user->edge_followed_by->count;
		$this->company->instagram->nbFollowing = $json->graphql->user->edge_follow->count;

		for ($i=0; $i < \WebApp\Data::NB_INSTAGRAM_PICTURE; ++$i)
		{
			if (empty($json->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->thumbnail_src))
			{ break; }

			$this->company->instagram->pictures[] =
				$json->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->thumbnail_src;
		}

		$this->scanTags(
			$json->graphql->user->username . ';'
			. $json->graphql->user->full_name . ';'
			. $json->graphql->user->biography
		);
	}

	private function scrapeFacebook($url)
	{
		// https://www.facebook.com/bermontcoffee/about
		$html = file_get_contents($url . '/about');

		$positionStart = strpos($html, ' +3');
		$positionEnd = strpos($html, '<', $positionStart);
		$phoneNumber = trim(substr($html, $positionStart, $positionEnd));

		$positionStart = strpos($html, '"mailto:') + 8;
		$positionEnd = strpos($html, '"', $positionStart);
		$email = trim(htmlspecialchars_decode(substr($html, $positionStart, $positionEnd)));

		$this->scanTags($email . ';' . $this->data->instagram->biography);
	}
}