<?php
namespace DataAccess;

/**
 * Data Access Object representing a company.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class CompanyObject
{
	public $permalink;
	public $name;
	public $logo = '';
	public $description = '';
	public $website = '';
	public $email = '';
	public $phone = '0000000000';
	public $address = '';
	public $region = 0;
	public $visibleTags = [];
	public $otherTags;
	public $instagram;
	public $facebook;
	public $lastUpdate;

	public function getDefaultPermalink()
	{
		$permalink = preg_replace('/[^a-z0-9\-]/', '', str_replace(' ', '-', strtolower($this->name)));

		if (strlen($permalink) < 4 && $this->instagram instanceof SocialMediaObject)
		{ $permalink = $this->instagram->getUsername(); }

		return $permalink;
	}
}