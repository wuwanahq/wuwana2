<?php
namespace Scraper;
use DataAccess\Tag;
use DataAccess\Company;
use DataAccess\CompanyData;
use DataAccess\SocialMedia;
use DataAccess\SocialMediaData;
use DOMDocument;

/**
 * Back-end Scraper.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class Scraper
{
	const NB_INSTAGRAM_PICTURE = 6;

	private $tagStorage;
	private $companyStorage;
	private $socialMediaStorage;

	/**
	 * Constructor.
	 * @param Tag $tagAccess
	 * @param Company $companyAccess
	 */
	public function __construct(Tag $tagAccess, Company $companyAccess, SocialMedia $socialMediaAccess)
	{
		$this->tagStorage = $tagAccess;
		$this->companyStorage = $companyAccess;
		$this->socialMediaStorage = $socialMediaAccess;
	}

	/**
	 * Store a new company or update an existing company if the Instagram profile already exists.
	 * @param string $website URL
	 * @param string $email
	 * @param string $picture URL
	 * @param string $text Extra text to help the tag detection
	 * @param SocialMediaData $instagram Data from the JavaScript scraper
	 */
	public function createOrUpdateCompany($website, $email, $picture, $text, SocialMediaData $instagram)
	{
		if (empty($instagram->pageURL) || $this->updateCompany($website, $email, $picture, $text, $instagram))
		{ return; }

		$this->companyStorage->insert($this->mergeCompanyData($website, $email, $picture, $text, $instagram));
	}

	/**
	 * Update data for an existing company.
	 * @param string $website URL
	 * @param string $email
	 * @param string $picture URL
	 * @param string $text Extra text to help the tag detection
	 * @param SocialMediaData $instagram Data from the JavaScript scraper
	 * @return bool Success or not
	 */
	public function updateCompany($website, $email, $picture, $text, SocialMediaData $instagram)
	{
		$companyID = $this->socialMediaStorage->selectCompanyIDbyPageURL($instagram->pageURL);

		if ($companyID === null)
		{ return false; }

		$this->companyStorage->update(
			$this->mergeCompanyData($website, $email, $picture, $text, $instagram),
			$companyID);

		return true;
	}

	/**
	 * Check all data sources available and merge everything into a CompanyData object.
	 * @param string $website URL
	 * @param string $email
	 * @param string $picture URL
	 * @param string $text
	 * @param SocialMediaData $instagram
	 * @return CompanyData
	 */
	private function mergeCompanyData($website, $email, $picture, $text, SocialMediaData $instagram)
	{
		$company = new CompanyData();
		$company->instagram = $instagram;

		$company->setName($company->instagram->profileName);
		$company->region = rand(1, 19);

		if (filter_var($email, FILTER_VALIDATE_EMAIL) === $email)
		{ $company->email = $email; }

		if (!empty($picture) && filter_var($picture, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === $picture)
		{ $company->logo = $picture; }

		$company->setWebsite($website);

		if (empty($company->website) && !empty($company->instagram->externalLink))
		{ $company->setWebsite($company->instagram->externalLink); }

		$data = $this->scrapeWebsite($company->website);
		$company->description = $data['Description'];

		if (empty($company->description))
		{ $company->description = str_replace('  ', ' ', $company->instagram->biography); }

		$content = $company->instagram->profileName
			. ';' . $company->instagram->getUsername()
			. ';' . $company->instagram->biography
			. ';' . $company->website
			. ';' . $text;

		$company->otherTags = $this->getBasicTags($content);
		$company->visibleTags = $this->getCombinedTags($content, $company->otherTags);

		if (empty($company->visibleTags[0]) && isset($company->otherTags[0]))
		{ $company->visibleTags[0] = array_shift($company->otherTags); }

		while (count($company->visibleTags) > 2)
		{ array_unshift($company->otherTags, array_pop($company->visibleTags)); }

		return $company;
	}

	/**
	 * Detect basic tags.
	 * @todo Move this method into a dedicated class (RegexTagger)
	 * @param string $content
	 * @return array
	 */
	private function getBasicTags($content)
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
	 * @todo Move this method into a dedicated class (RegexTagger)
	 * @param string $content
	 * @param array $basicTags
	 * @return array
	 */
	private function getCombinedTags($content, array $basicTags)
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

	/**
	 * Get the website description.
	 * Limitations: Shopify sites -> Shopify prevents scraping
	 * @param string $url Website URL
	 */
	private function scrapeWebsite($url)
	{
		$html = file_get_contents($url);  // Download the HTML page
		$position = stripos($html, '</head>');

		if ($position == false)  // or 0
		{ return ''; }  // We can not do anything without the <head> part

		// Remove the <body> part to only parse the <head> (optimization)
		$data['Description'] =
			$this->getWebsiteDescription(substr($html, 0, $position) . '</head><body></body></html>');

		//TODO: try to detect a phone number and email in the HTML <body>
		//$data['Phone'] = ...
		//$data['Email'] = ...

		return $data;
	}

	/**
	 * Get the website description.
	 * @param string $html
	 * @return string
	 */
	private function getWebsiteDescription($html)
	{
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$metaTags = [];

		foreach ($dom->getElementsByTagName('meta') as $meta)
		{
			if ($meta->hasAttribute('property'))
			{ $metaTags[strtolower($meta->getAttribute('property'))] = trim($meta->getAttribute('content')); }
			elseif ($meta->hasAttribute('name'))
			{ $metaTags[strtolower($meta->getAttribute('name'))] = trim($meta->getAttribute('content')); }
		}

		foreach (['description', 'og:description', 'twitter:description'] as $attribute)
		{
			if (!empty($metaTags[$attribute]))
			{ return $metaTags[$attribute]; }
		}

		// If there were no description available maybe we can use the page title...
		$title = $dom->getElementsByTagName('title')->item(0);

		if ($title != null && !empty($title->nodeValue))
		{ return trim($title->nodeValue); }

		if (!empty($metaTags['og:title']))
		{ return $metaTags['og:title']; }

		if (!empty($metaTags['twitter:title']))
		{ return $metaTags['twitter:title']; }

		return '';
	}

	/**
	 * NEW back-end scraper for Instagram profile.
	 * This version is not going to be blocked by Instagram but need a user token and a session ID.
	 * @todo Test it!
	 * @param string $url https://www.instagram.com/profilename
	 * @param string $token Instagram user token
	 * @param string $sessionID Instagram session ID
	 * @return array ("ProfilePicURL", "Instagram", "ExtraInfo", "Email")
	 */
	private function scrapeInstagram($url, $token, $sessionID)
	{
		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, 'https://www.' . $url . '/?__a=1');
		curl_setopt($cURL, CURLOPT_COOKIE, "csrftoken=$token; sessionid=$sessionID");
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		$user = json_decode(curl_exec($cURL), false);
		curl_close($cURL);

		if (!isset($user->graphql->user))
		{ return []; }

		$user = $user->graphql->user;
		$data = [
			'ProfilePicURL' => $user->profile_pic_url,
			'Instagram' => new SocialMediaData(),
			'ExtraInfo' => $user->biography
		];

		if (isset($user->business_email) && filter_var($user->business_email, FILTER_VALIDATE_EMAIL))
		{ $data['Email'] = $user->business_email; }

		if (isset($user->external_url) && filter_var($user->external_url, FILTER_VALIDATE_URL))
		{ $data['Instagram']->link = $user->external_url; }

		$data['Instagram']->setPageURL($url);
		$data['Instagram']->setProfileName($user->full_name);
		$data['Instagram']->setBiography($user->biography);
		$data['Instagram']->nbPost = (int)$user->edge_owner_to_timeline_media->count;
		$data['Instagram']->nbFollower = (int)$user->edge_followed_by->count;
		$data['Instagram']->nbFollowing = (int)$user->edge_follow->count;

		for ($i=0; $i < self::NB_INSTAGRAM_PICTURE; ++$i)
		{
			if (empty($user->edge_owner_to_timeline_media->edges[$i]->node->thumbnail_src))
			{ break; }

			$data['Instagram']->pictures[] = $user->edge_owner_to_timeline_media->edges[$i]->node->thumbnail_src;

			for ($j=0; $j < 9; ++$j)
			{
				if (empty($user->edge_owner_to_timeline_media->edges[$i]->node->edge_media_to_caption->edges[$j]))
				{ break; }

				$data['ExtraInfo'] += ';' .
					$user->edge_owner_to_timeline_media->edges[$i]->node->edge_media_to_caption->edges[$j]->node->text;
			}
		}

		return $data;
	}

	/**
	 * Scraper for Facebook.
	 * @deprecated The code in this method is outdated so it probably doesn't work!
	 * @todo Update Facebook scraper
	 * @param string $url
	 */
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

		//$this->scanTags($email . ';' . $this->data->instagram->biography);
	}
}