<?php
namespace DataAccess;
use PDO;
use PDOStatement;

/**
 * Data access layer for stored companies.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Company extends DataAccess
{
	const VALUES_DELIMITER = ';';

	public $permalink;
	public $name;
	public $logo = '';
	public $description = '';
	public $website = '';
	public $email = '';
	public $phone = '0000000000';
	public $address = '';
	public $region = 0;
	public $tags = [];
	public $instagram;
	public $facebook;
	public $lastUpdate;

	static function getTableSchema()
	{
		return 'create table Company (
			PermaLink varchar(250) primary key,
			ID int not null,
			Name varchar(250) not null,
			LogoURL varchar(255) not null,
			Description varchar(255) not null,
			Website varchar(255) not null,
			Email varchar(255) not null,
			PhonePrefix tinyint not null,
			PhoneNumber int not null,
			Address varchar(255) not null,
			LocationID smallint not null,
			FirstTagID int not null,
			SecondTagID int not null,
			OtherTags varchar(255) not null,
			LastUpdate int not null)';
	}

	public function insertData($companyFilePath, $socialMediaFilePath)
	{
		parent::importData($companyFilePath, 'Company', [
			'PermaLink'   => PDO::PARAM_STR,
			'ID'          => PDO::PARAM_INT,
			'Name'        => PDO::PARAM_STR,
			'LogoURL'     => PDO::PARAM_STR,
			'Description' => PDO::PARAM_STR,
			'Website'     => PDO::PARAM_STR,
			'Email'       => PDO::PARAM_STR,
			'PhonePrefix' => PDO::PARAM_INT,
			'PhoneNumber' => PDO::PARAM_INT,
			'Address'     => PDO::PARAM_STR,
			'LocationID'  => PDO::PARAM_INT,
			'FirstTagID'  => PDO::PARAM_INT,
			'SecondTagID' => PDO::PARAM_INT,
			'OtherTags'   => PDO::PARAM_STR,
			'LastUpdate'  => PDO::PARAM_INT,
		]);

		//TODO: move this part in the SocialMedia DAO
		parent::importData($socialMediaFilePath, 'SocialMedia', [
			'ID'           => PDO::PARAM_INT,
			'URL'          => PDO::PARAM_STR,
			'CompanyID'    => PDO::PARAM_INT,
			'ProfileName'  => PDO::PARAM_STR,
			'Biography'    => PDO::PARAM_STR,
			'ExternalLink' => PDO::PARAM_STR,
			'Counter1'     => PDO::PARAM_INT,
			'Counter2'     => PDO::PARAM_INT,
			'Counter3'     => PDO::PARAM_INT,
		]);
	}

	/**
	 * Get a company by its permanent link.
	 * @param string $permalink
	 * @return \DataAccess\Company
	 */
	public function selectPermalink($permalink)
	{
		$sql = 'select
			Company.Name as CompanyName,
			Company.LogoURL as CompanyLogoURL,
			Company.Description as CompanyDescription,
			Company.Website as CompanyWebsite,
			Company.Email as CompanyEmail,
			Company.Address as CompanyAddress,
			Location.RegionName as LocationRegionName,
			Company.PhonePrefix as CompanyPhonePrefix,
			Company.PhoneNumber as CompanyPhoneNumber,
			T1.Name as TagName1,
			T2.Name as TagName2,
			SocialMedia.URL as SocialMediaURL,
			SocialMedia.ProfileName as SocialMediaProfileName,
			SocialMedia.Biography as SocialMediaBiography,
			SocialMedia.ExternalLink as SocialMediaExternalLink,
			SocialMedia.Counter1 as SocialMediaCounter1,
			SocialMedia.Counter2 as SocialMediaCounter2,
			SocialMedia.Counter3 as SocialMediaCounter3,
			Image.URL as ImageURL
			from Company
			inner join Location on Company.LocationID=Location.ID
			inner join SocialMedia on Company.ID=SocialMedia.CompanyID
			left join Image on SocialMedia.ID=Image.SocialMediaID
			left join Tag as T1 on Company.FirstTagID=T1.ID
			left join Tag as T2 on Company.SecondTagID=T2.ID
			where Company.PermaLink=?';

		$query = $this->pdo->query($sql);

		if ($query == false)
		{
			$this->createDatabase();
			$query = $this->pdo->query($sql);
		}

		$query->bindValue(1, $permalink, PDO::PARAM_STR);
		$query->execute();
		$company = null;

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			if ($company == null)
			{
				$company = new Company();
				$company->name = $row['CompanyName'];
				$company->logo = $row['CompanyLogoURL'];
				$company->description = $row['CompanyDescription'];
				$company->website = $row['CompanyWebsite'];
				$company->email = $row['CompanyEmail'];
				$company->address = $row['CompanyAddress'];
				$company->region = $row['LocationRegionName'];
				$company->tags = [$row['TagName1'], $row['TagName2']];

				if ($row['CompanyPhonePrefix'] != 0 && $row['CompanyPhoneNumber'] != 0)
				{
					$company->phone =
						$row['CompanyPhonePrefix'] . str_pad($row['CompanyPhoneNumber'], 9, '0', STR_PAD_LEFT);
				}
			}

			$socialMedia = new SocialMedia($row);

			switch ($socialMedia->getType())
			{
				case 'instagram':
					if (empty($company->instagram))
					{ $company->instagram = $socialMedia; }
					$company->instagram->pictures[] = $row['ImageURL'];
					break;

				case 'facebook':
					if (empty($company->facebook))
					{ $company->facebook = $socialMedia; }
					$company->facebook->pictures[] = $row['ImageURL'];
					break;
			}
		}

		return $company;
	}

	public function selectAll()
	{
		$query = $this->pdo->query('select
			Company.PermaLink as CompanyPermaLink,
			Company.Name as CompanyName,
			Company.Description as CompanyDescription,
			Company.LastUpdate as CompanyLastUpdate,
			Location.RegionName as LocationRegionName,
			T1.Name as TagName1,
			T2.Name as TagName2
			from Company
			left join Tag as T1 on Company.FirstTagID=T1.ID
			left join Tag as T2 on Company.SecondTagID=T2.ID
			left join Location on Company.LocationID=Location.ID
			order by Company.LastUpdate desc');

		$companies = [];

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$company = new Company();
			$company->permalink = $row['CompanyPermaLink'];
			$company->name = $row['CompanyName'];
			$company->description = $row['CompanyDescription'];
			$company->region = $row['LocationRegionName'];
			$company->tags = [$row['TagName1'], $row['TagName2']];
			$company->lastUpdate = $row['CompanyLastUpdate'];

			$companies[] = $company;
		}

		return $companies;
	}

	public function selectCategoriesRegions($categories = [], $regions = [], $limit = 0)
	{
		$sql = '';

		if (!empty($categories[0]))
		{
			$filter = [];

			foreach ($categories as $category)
			{ $filter[] = "Tags like '%;$category;%'"; }

			$sql = ' where (' . implode(' or ', $filter) . ')';
		}

		if (!empty($regions[0]))
		{
			if ($sql == '')
			{ $sql = ' where Company.LocationID in (' . implode(',', $regions) . ')'; }
			else
			{ $sql .= ' and Company.LocationID in (' . implode(',', $regions) . ')'; }
		}

		$sql = "select
			Company.PermaLink as CompanyPermaLink,
			Company.Name as CompanyName,
			Company.LogoURL as CompanyLogoURL,
			Company.LocationID as CompanyLocationID,
			T1.Name as TagName1,
			T2.Name as TagName2
			from Company
			inner join Tag as T1 on Company.FirstTagID=T1.ID
			left join Tag as T2 on Company.SecondTagID=T2.ID
			$sql order by Company.LastUpdate desc";

		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			$this->createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		return Company::fetchObjects($stmt, $limit);
	}

	static function fetchObjects(PDOStatement $stmt, $limit = 0)
	{
		$companies = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$company = new Company();
			$company->permalink = $row['CompanyPermaLink'];
			$company->name = $row['CompanyName'];
			$company->logo = $row['CompanyLogoURL'];
			//$company->description = $row['Description'];
			//$company->website = $row['Website'];
			//$company->phone = $row['PhonePrefix'] . str_pad($row['PhoneNumber'], 9, '0', STR_PAD_LEFT);
			//$company->email = $row['Email'];
			$company->region = (int)$row['CompanyLocationID'];
			$company->tags = [$row['TagName1'], $row['TagName2']];
			//$company->tags = explode(self::VALUES_DELIMITER, $row['Company.Tags']);

			$companies[$row['CompanyPermaLink']] = $company;

			if (--$limit == 0)
			{ break; }
		}

		return $companies;
	}

	public function insert()
	{
		$query = $this->pdo->query('select coalesce(max(ID)+1,1) from Company');
		$query->execute();
		$companyID = $query->fetchColumn(0);

		$query = $this->pdo->prepare('insert into Company
			(PermaLink,ID,Name,Description,LogoURL,Website,PhonePrefix,PhoneNumber,
				Email,Address,LocationID,FirstTagID,SecondTagID,OtherTags,LastUpdate)
			values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

		$permalink = preg_replace('/[^a-z0-9\-]/', '', str_replace(' ', '-', strtolower($this->name)));
		$query->bindValue(1, $permalink, PDO::PARAM_STR);
		$query->bindValue(2, $companyID, PDO::PARAM_INT);
		$query->bindValue(3, $this->name, PDO::PARAM_STR);
		$query->bindValue(4, $this->description, PDO::PARAM_STR);
		$query->bindValue(5, $this->logo, PDO::PARAM_STR);
		$query->bindValue(6, $this->website, PDO::PARAM_STR);
		$query->bindValue(7, (int)substr($this->phone, 0, -9), PDO::PARAM_INT);
		$query->bindValue(8, (int)substr($this->phone, -9), PDO::PARAM_INT);
		$query->bindValue(9, $this->email, PDO::PARAM_STR);
		$query->bindValue(10, $this->address, PDO::PARAM_STR);
		$query->bindValue(11, $this->region, PDO::PARAM_STR);
		$query->bindValue(12, isset($this->tags[0]) ? $this->tags[0] : 0, PDO::PARAM_INT);
		$query->bindValue(13, isset($this->tags[1]) ? $this->tags[1] : 0, PDO::PARAM_INT);
		$query->bindValue(14, implode(self::VALUES_DELIMITER, array_slice($this->tags, 2)), PDO::PARAM_STR);
		$query->bindValue(15, time(), PDO::PARAM_INT);
		$debug1 = $query->execute();

		$debug5 = $query->errorInfo();
		$debug2 = $this->pdo->errorInfo();

		$query = $this->pdo->query('select coalesce(max(ID)+1,' . self::INT_MIN . ') from SocialMedia');
		$query->execute();
		$socialMediaID = $query->fetchColumn(0);

		$query = $this->pdo->prepare('insert into SocialMedia
			(ID, URL, CompanyID, ProfileName, Biography, ExternalLink, Counter1, Counter2, Counter3)
			values (?,?,?,?,?,?,?,?,?)');

		$query->bindValue(1, $socialMediaID, PDO::PARAM_INT);
		$query->bindValue(2, $this->instagram->url, PDO::PARAM_STR);
		$query->bindValue(3, $companyID, PDO::PARAM_INT);
		$query->bindValue(4, $this->instagram->profileName, PDO::PARAM_STR);
		$query->bindValue(5, $this->instagram->biography, PDO::PARAM_STR);
		$query->bindValue(6, $this->instagram->link, PDO::PARAM_STR);
		$query->bindValue(7, $this->instagram->counter1, PDO::PARAM_INT);
		$query->bindValue(8, $this->instagram->counter2, PDO::PARAM_INT);
		$query->bindValue(9, $this->instagram->counter3, PDO::PARAM_INT);
		$debug3 = $query->execute();

		$debug6 = $query->errorInfo();
		$debug4 = $this->pdo->errorInfo();

		$query = $this->pdo->prepare('insert into Image (SocialMediaID,URL) values (?,?)');
		$query->bindValue(1, $socialMediaID, PDO::PARAM_INT);

		foreach ($this->instagram->pictures as $picture)
		{
			$query->bindValue(2, $picture, PDO::PARAM_STR);
			$query->execute();
		}
	}
}