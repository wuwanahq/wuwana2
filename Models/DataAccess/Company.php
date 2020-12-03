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
	public $socialMedias;

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

	public function importData($filePath)
	{
		if ($this->pdo->exec('drop table Company') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::insertData($filePath, 'Company', [
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
			'Tags'        => PDO::PARAM_STR,
			'LastUpdate'  => PDO::PARAM_INT,
		]);
	}

	public function selectPermalink($permalink)
	{
		$query = $this->pdo->query(
			'select * from Company
				inner join SocialMedia on Company.ID=SocialMedia.CompanyID
				inner join Image on SocialMedia.ID=Image.SocialMediaID
				where Company.PermaLink=?'
		);

		$query->bindValue(1, $permalink, PDO::PARAM_STR);
		$query->execute();
		$company = null;

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			if ($company == null)
			{
				$company = new Company();
				$company->name = $row['Company.Name'];
				$company->logo = $row['Company.LogoURL'];
				$company->description = $row['Company.Description'];
				$company->website = $row['Company.Website'];
				$company->email = $row['Company.Email'];
				$company->region = (int)$row['Company.LocationID'];
				$company->tags = explode(self::VALUES_DELIMITER, $row['Company.Tags']);
				$company->phone =
					$row['Company.PhonePrefix'] . str_pad($row['Company.PhoneNumber'], 9, '0', STR_PAD_LEFT);

				$company->socialMedias = [];
			}

			if (!isset($company->socialMedias['SocialMedia.ID']))
			{ $company->socialMedias[] = new SocialMedia($row); }

			$company->socialMedias['SocialMedia.ID']->pictures[] = $row['Image.URL'];
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
			{ $sql = ' where LocationID in (' . implode(',', $regions) . ')'; }
			else
			{ $sql .= ' and LocationID in (' . implode(',', $regions) . ')'; }
		}

		$sql = 'select * from Company' . $sql . ' order by LastUpdate desc';

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
			$company->name = $row['Name'];
			$company->logo = $row['LogoURL'];
			//$company->description = $row['Description'];
			//$company->website = $row['Website'];
			//$company->phone = $row['PhonePrefix'] . str_pad($row['PhoneNumber'], 9, '0', STR_PAD_LEFT);
			//$company->email = $row['Email'];
			$company->region = (int)$row['LocationID'];
			$company->tags = explode(self::VALUES_DELIMITER, $row['Company.Tags']);

			$companies[$row['Company.PermaLink']] = $company;

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