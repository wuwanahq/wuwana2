<?php
namespace DataAccess;
use PDO;
use PDOStatement;
use Scraper\CompanyData;

/**
 * Data access layer for stored companies.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Company extends DataAccess
{
	const VALUES_DELIMITER = ';';

	public $name;
	public $logo;
	public $description;
	public $website;
	public $email;
	public $phone;
	public $address;
	public $region;
	public $tags;
	public $instagram;
	public $facebook;

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
			inner join Tag as T1 on Company.FirstTagID=T1.ID
			inner join Tag as T2 on Company.SecondTagID=T2.ID
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
			inner join Tag as T2 on Company.SecondTagID=T2.ID
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

	public function insertNew(CompanyData $company)
	{
		$query = $this->pdo->prepare('insert into Company (
			ID,PermaLink,Name,Description,LogoURL,Website,PhonePrefix,PhoneNumber,
				Email,LocationID,FirstTagID,SecondTagID,OtherTags,LastUpdate)
			values (coalesce(max(ID)+1,0),?,?,?,?,?,?,?,?,?,?,?,?,?)');

		$query->bindValue(1, str_replace(' ', '_', $company->name), PDO::PARAM_STR);
		$query->bindValue(2, $company->name, PDO::PARAM_STR);
		$query->bindValue(3, $company->description, PDO::PARAM_STR);
		$query->bindValue(4, $company->logoURL, PDO::PARAM_STR);
		$query->bindValue(5, $company->website, PDO::PARAM_STR);
		$query->bindValue(6, substr($company->phoneNumber, 0, -9), PDO::PARAM_INT);
		$query->bindValue(7, substr($company->phoneNumber, -9), PDO::PARAM_INT);
		$query->bindValue(8, $company->email, PDO::PARAM_STR);
		$query->bindValue(9, $company->region, PDO::PARAM_STR);
		$query->bindValue(10, $company->tags[0], PDO::PARAM_INT);
		$query->bindValue(11, $company->tags[1], PDO::PARAM_INT);
		$query->bindValue(12, $company->tags, PDO::PARAM_STR);
		$query->bindValue(13, time(), PDO::PARAM_INT);
		$query->execute();
	}
}