<?php
namespace Scraper;
use Iterator;
use DataAccess;

/**
 * Web Scraper.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Scraper
{
	const NB_INSTAGRAM_PICTURE = \WebApp\Data::NB_INSTAGRAM_PICTURE;

	private $tagKeywords;
	private $company;
	private $user;

	public function __construct(Iterator $tagKeywords, \DataAccess\User $user)
	{
		$this->tagKeywords = $tagKeywords;
		$this->user = $user;
	}

	public function extractData($url)
	{
		$this->company = \WebApp\Data::getCompany();

		if (strpos($url, 'instagram.com') !== false)
		{ $this->scrapeInstagram($url); }

		if (strpos($url, 'facebook.com') !== false)
		{ $this->scrapeFacebook($url); }

		return $this->company;
	}

	private function scanTags($content)
	{
		$tags = [];

		foreach ($this->tagKeywords as $id => $tag)
		{
			$score = preg_match_all('/' . $tag->keywords . '/i', $content);

			if ($score > 0)
			{ $tags[$id] = $tag->isVisible ? $score * 1000 : $score; }
		}

		arsort($tags, SORT_NUMERIC);

		foreach ($tags as $tagName => $unused)
		{ $this->company->tags[] = $tagName; }
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
		$this->company->website = $json->graphql->user->external_url;
		$this->company->region = rand(1, 19);

		if (isset($json->graphql->user->business_email))
		{ $this->company->email = $json->graphql->user->business_email; }

		$this->company->instagram = new DataAccess\SocialMedia();

		if (isset($json->graphql->user->external_url))
		{ $this->company->instagram->link = $json->graphql->user->external_url; }

		$this->company->instagram->url = 'instagram.com/' . $json->graphql->user->username;
		$this->company->instagram->profileName = $json->graphql->user->full_name;
		$this->company->instagram->biography = $json->graphql->user->biography;
		$this->company->instagram->nbPost = $json->graphql->user->edge_owner_to_timeline_media->count;
		$this->company->instagram->nbFollower = $json->graphql->user->edge_followed_by->count;
		$this->company->instagram->nbFollowing = $json->graphql->user->edge_follow->count;

		for ($i=0; $i < self::NB_INSTAGRAM_PICTURE; ++$i)
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