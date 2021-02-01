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
	private $tagStorage;
	private $companyStorage;
	private $socialMediaStorage;
	private $company;

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
	 * Store scraped data.
	 * @param string $website URL
	 * @param string $email
	 * @param string $picture URL
	 * @param string $text Extra text to help the tag detection
	 * @param SocialMediaData $instagram Data from the JavaScript scraper
	 */
	public function storeNewCompany($website, $email, $picture, $text, SocialMediaData $instagram)
	{
		if (empty($instagram->pageURL))
		{ return; }

		$this->company = new CompanyData();
		$this->company->instagram = $instagram;
		$this->mergeCompanyData($website, $email, $picture, $text);

		$this->companyStorage->insert($this->company);
	}

	/**
	 * Update data for an existing company.
	 * @param string $website URL
	 * @param string $email
	 * @param string $picture URL
	 * @param string $text Extra text to help the tag detection
	 * @param SocialMediaData $instagram Data from the JavaScript scraper
	 */
	public function updateExistingCompany($website, $email, $picture, $text, SocialMediaData $instagram)
	{
		$companyID = $this->socialMediaStorage->selectCompanyIDbyPageURL($instagram->pageURL);

		if ($companyID === null)
		{ return; }

		$this->company = new CompanyData();
		$this->company->instagram = $instagram;
		$this->mergeCompanyData($website, $email, $picture, $text);

		$this->companyStorage->update($this->company, $companyID);
	}

	/**
	 * Check all data available and merge everything into company object.
	 * @param string $website URL
	 * @param string $email
	 * @param string $picture URL
	 * @param string $text
	 */
	private function mergeCompanyData($website, $email, $picture, $text)
	{
		$this->company->setName($this->company->instagram->profileName);
		$this->company->region = rand(1, 19);

		if (filter_var($email, FILTER_VALIDATE_EMAIL) === $email)
		{ $this->company->email = $email; }

		if (!empty($picture) && filter_var($picture, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === $picture)
		{ $this->company->logo = $picture; }

		$this->company->setWebsite($website);

		if (empty($this->company->website) && !empty($this->company->instagram->externalLink))
		{ $this->company->setWebsite($this->company->instagram->externalLink); }

		$this->scrapeWebsite($this->company->website);

		if (empty($this->company->description))
		{ $this->company->description = str_replace('  ', ' ', $this->company->instagram->biography); }

		$content = $this->company->instagram->profileName
			. ';' . $this->company->instagram->getUsername()
			. ';' . $this->company->instagram->biography
			. ';' . $this->company->website
			. ';' . $text;

		$this->company->otherTags = $this->getBasicTags($content);
		$this->company->visibleTags = $this->getCombinedTags($content, $this->company->otherTags);

		if (empty($this->company->visibleTags[0]) && isset($this->company->otherTags[0]))
		{ $this->company->visibleTags[0] = array_shift($this->company->otherTags); }

		while (count($this->company->visibleTags) > 2)
		{ array_unshift($this->company->otherTags, array_pop($this->company->visibleTags)); }
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
		$this->company->description =
			$this->getWebsiteDescription(substr($html, 0, $position) . '</head><body></body></html>');

		//TODO: try to detect a phone number and email in the HTML <body>
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
	 * Backend scraper for Instagram (usually blocked after few uses)
	 * @param string $url
	 * @deprecated The code in this method is probably outdated...
	 * @see /static/dhtml/admin.js The JavaScript version of this method
	 */
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

		$this->company->instagram = new SocialMediaData();

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

	/**
	 * Scraper for Facebook.
	 * @deprecated The code in this method is old and need to be tested
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

		$this->scanTags($email . ';' . $this->data->instagram->biography);
	}
}