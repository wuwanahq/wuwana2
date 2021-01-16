<?php
namespace DataAccess;

/**
 * Data Access Object representing a social media related to a company.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class SocialMediaObject
{
	private $url;
	public $profileName;
	public $biography;
	public $link = '';
	public $pictures = [];
	public $counter1 = 0;
	public $counter2 = 0;
	public $counter3 = 0;

	public function __get($name)
	{
		switch ($name)
		{
			case 'url': return $this->url;

			// Instagram
			case 'nbPost': return $this->counter1;
			case 'nbFollower': return $this->counter2;
			case 'nbFollowing': return $this->counter3;

			// Facebook
			case 'nbLike': return $this->counter1;
			case 'nbFollow': return $this->counter2;
			case 'nbCheckin': return $this->counter3;
		}

		trigger_error('Undefined property ' . $name, E_USER_ERROR);
	}

	public function __set($name, $value)
	{
		switch ($name)
		{
			case 'url':
				$this->url = str_replace(['https://www.', 'https://'], '', $value);
				break;

			// Instagram
			case 'nbPost': $this->counter1 = $value; break;
			case 'nbFollower': $this->counter2 = $value; break;
			case 'nbFollowing': $this->counter3 = $value; break;

			// Facebook
			case 'nbLike': $this->counter1 = $value; break;
			case 'nbFollow': $this->counter2 = $value; break;
			case 'nbCheckin': $this->counter3 = $value; break;

			default: trigger_error('Undefined property ' . $name, E_USER_ERROR);
		}
	}

	public function __construct(array $row = null)
	{
		if ($row != null)
		{
			$this->url = 'https://www.' . $row['SocialMediaURL'];
			$this->profileName = $row['SocialMediaProfileName'];
			$this->biography = $row['SocialMediaBiography'];
			$this->link = $row['SocialMediaExternalLink'];
			$this->counter1 = $row['SocialMediaCounter1'];
			$this->counter2 = $row['SocialMediaCounter2'];
			$this->counter3 = $row['SocialMediaCounter3'];
		}
	}

	public function getType()
	{
		return substr($this->url, 12, strpos($this->url, '.', 12) - 12);  // 12 to avoid "https://www."
	}

	public function getUsername()
	{
		return str_replace('https://www.instagram.com/', '', $this->url);
	}

	public function getHtmlBiography()
	{
		return str_replace('  ', '<br>', $this->biography);
	}
}