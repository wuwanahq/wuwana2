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
			// Instagram
			case 'nbPost': return $this->counter1;
			case 'nbFollower': return $this->counter2;
			case 'nbFollowing': return $this->counter3;

			// Facebook
			case 'nbLike': return $this->counter1;
			case 'nbFollow': return $this->counter2;
			case 'nbCheckin': return $this->counter3;
		}

		trigger_error('Undefined property ' . $property, E_USER_ERROR);
	}

	public function __construct(array $row)
	{
		$this->url = 'https://www.' . $row['SocialMediaURL'];
		$this->profileName = $row['SocialMediaProfileName'];
		$this->biography = $row['SocialMediaBiography'];
		$this->link = $row['SocialMediaExternalLink'];
		$this->counter1 = $row['SocialMediaCounter1'];
		$this->counter2 = $row['SocialMediaCounter2'];
		$this->counter3 = $row['SocialMediaCounter3'];
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
		return substr($this->url, 12, strpos($this->url, '.', 12) - 12);  // 12 to avoid "https://www."
	}
}