<?php
namespace DataAccess;

/**
 * Data access layer for stored social media.
 * @author Vince <vincent.boursier@gmail.com>
 */
class SocialMedia
{
	public $url;
	public $profileName;
	public $biography;
	public $link;
	public $pictures;
	private $counter1;
	private $counter2;
	private $counter3;

	public function __get($property)
	{
		switch ($property)
		{
			case 'instagramNbPost': return $this->counter1;
			case 'instagramNbFollower': return $this->counter2;
			case 'instagramNbFollowing': return $this->counter3;
			case 'facecookNbLike': return $this->counter1;
			case 'facebookNbFollow': return $this->counter2;
			case 'facebookNbCheckin': return $this->counter3;
		}

		trigger_error('Undefined property ' . $property, E_USER_ERROR);
	}

	public function __construct(array $row)
	{
		$this->url = 'https://' . $row['SocialMedia.URL'];
		$this->profileName = $row['SocialMedia.ProfileName'];
		$this->biography = $row['SocialMedia.Biography'];
		$this->link = $row['SocialMedia.Link'];
		$this->counter1 = $row['SocialMedia.Counter1'];
		$this->counter2 = $row['SocialMedia.Counter2'];
		$this->counter3 = $row['SocialMedia.Counter3'];
		$this->pictures = [];
	}

	static function getTableSchema()
	{
		return 'create table SocialMedia (
			ID int primary key,
			URL varchar(255) not null,
			CompanyID int not null,
			ProfileName varchar(255) not null,
			Biography varchar(255) not null,
			ExternalLink varchar(255) not null,
			Counter1 int not null,
			Counter2 int not null,
			Counter3 int not null)';
	}

	public function getType()
	{
		return substr($this->url, 0, strpos($this->url, '.'));
	}
}