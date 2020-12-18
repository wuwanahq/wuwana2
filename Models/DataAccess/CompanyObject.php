<?php
namespace DataAccess;

/**
 * Data Access Object representing a company.
 * @author Vince <vincent.boursier@gmail.com>
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