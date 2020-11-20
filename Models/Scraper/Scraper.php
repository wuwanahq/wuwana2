<?php
namespace Scraper;
use Iterator;

/**
 * Web Scraper.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Scraper
{
	private $tagKeywords;
	private $data;

	public function __construct(Iterator $tagKeywords)
	{
		$this->tagKeywords = $tagKeywords;
	}

	private function scanTags($content)
	{
		$tags = [];

		foreach ($this->tagKeywords as $tagName => $KeywordRegex)
		{
			$score = preg_match_all($KeywordRegex, $content);

			if ($score > 0)
			{ $tags[$tagName] = $score; }
		}

		return $tags;
	}

	public function extractData($urls)
	{
		$this->data = new CompanyData();

		foreach ($urls as $url)
		{
			$position = strpos($url, 'instagram.com');

			if ($position !== false)
			{ $data->instagram = substr($url, $position); }

			$position = strpos($url, 'facebook.com');

			if ($position !== false)
			{ $data->facebook = substr($url, $position); }

		}

		$this->scanTags();
		return $this->data;
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

	private function scrapeInstagram($url)
	{
		$json = file_get_contents($url);
		$positionStart = strpos($json, '<script type="text/javascript">window._sharedData =') + 51;
		$positionEnd = strpos($json, ';</script>', $positionStart);
		$json = substr($json, $positionStart, $positionEnd);
		$json = json_decode($json, false);

		$this->data->instagram = new SocialMediaData();
		$this->data->instagram->profileName = $json->entry_data->ProfilePage[0]->graphql->user->username;
		$this->data->instagram->fullName = $json->entry_data->ProfilePage[0]->graphql->user->full_name;
		$this->data->instagram->biography = $json->entry_data->ProfilePage[0]->graphql->user->biography;
		$this->data->instagram->logoURL = $json->entry_data->ProfilePage[0]->graphql->user->profile_pic_url;
		$this->data->instagram->email = $json->entry_data->ProfilePage[0]->graphql->user->business_email;

		if (strpos($json->entry_data->ProfilePage[0]->graphql->user->external_url, 'facebook.com')  > 0)
		{ $this->data->facebook = $this->scrapeFacebook($json->entry_data->ProfilePage[0]->graphql->user->external_url); }
		else
		{ $this->data->website = $json->entry_data->ProfilePage[0]->graphql->user->external_url; }

		$this->scanTags($this->data->instagram->fullName . ';' . $this->data->instagram->biography);
	}
}