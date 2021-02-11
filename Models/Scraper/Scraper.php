<?php
namespace Scraper;
use DataAccess\Tag;
use DataAccess\Company;
use DataAccess\CompanyData;
use DataAccess\SocialMedia;
use DataAccess\SocialMediaData;

/**
 * Back-end Scraper.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class Scraper
{
	const NB_INSTAGRAM_PICTURE = 6;

	private $tagger;
	private $companyStorage;
	private $socialMediaStorage;

	/**
	 * Constructor.
	 * @param Tag $tagAccess
	 * @param Company $companyAccess
	 */
	public function __construct(Tag $tagAccess, Company $companyAccess, SocialMedia $socialMediaAccess)
	{
		$this->tagger = new RegexTagger($tagAccess);
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

		if (!empty($company->website))
		{
			$webCrawler = new WebsiteCrawler();
			$webCrawler->crawlWebsite($company->website);

			$company->description = $webCrawler->description;
			$company->phone = empty($webCrawler->mobileNumber) ? $webCrawler->phoneNumber : $webCrawler->mobileNumber;

			if (!empty($webCrawler->emailAddresses[0]))
			{ $company->email = $webCrawler->emailAddresses[0]; }
		}

		if (empty($company->description))
		{ $company->description = str_replace('  ', ' ', $company->instagram->biography); }

		$content = $company->instagram->profileName
			. ';' . $company->instagram->getUsername()
			. ';' . $company->instagram->biography
			. ';' . $company->website
			. ';' . $text;

		$company->otherTags = $this->tagger->getBasicTags($content);
		$company->visibleTags = $this->tagger->getCombinedTags($content, $company->otherTags);

		if (empty($company->visibleTags[0]) && isset($company->otherTags[0]))
		{ $company->visibleTags[0] = array_shift($company->otherTags); }

		while (count($company->visibleTags) > 2)
		{ array_unshift($company->otherTags, array_pop($company->visibleTags)); }

		return $company;
	}

	/**
	 * NEW back-end scraper for Instagram profile.
	 * This version is not going to be blocked by Instagram but needs a user token and a session ID.
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