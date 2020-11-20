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

	public $name;
	public $logo;
	public $description;
	public $website;
	public $phoneNumber;
	public $email;
	public $region;
	public $tags;
	public $socialMedias;

	private function createTable()
	{
		$result = $this->pdo->exec(
			'create table Company ('
			. 'ID int primary key,'
			. 'PermaLink varchar(255) not null,'
			. 'Name varchar(255) not null,'
			. 'LogoURL varchar(255) not null,'
			. 'Description varchar(255) not null,'
			. 'Website varchar(255) not null,'
			. 'PhoneNumber int not null,'
			. 'Email varchar(255) not null,'
			. 'LocationID smallint not null,'
			. 'Tags varchar(255) not null,'
			. 'LastUpdate int not null)');

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}

	public function importData($filePath)
	{
		if ($this->pdo->exec('drop table Company') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::insertData($filePath, 'Company', [
			'ID'           => PDO::PARAM_INT,
			'Name'         => PDO::PARAM_STR,
			'Logo'         => PDO::PARAM_STR,
			'Description'  => PDO::PARAM_STR,
			'Website'      => PDO::PARAM_STR,
			'PhoneNumber'  => PDO::PARAM_STR,
			'Email'        => PDO::PARAM_STR,
			'LocationID'   => PDO::PARAM_INT,
			'CategoriesID' => PDO::PARAM_STR,
			'SocialMedia'  => PDO::PARAM_STR,
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
				$company->phoneNumber = $row['Company.PhoneNumber'];
				$company->email = $row['Company.Email'];
				$company->region = (int)$row['Company.LocationID'];
				$company->tags = explode(self::VALUES_DELIMITER, $row['Company.Tags']);
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
			{ $filter[] = "CategoriesID like '%;$category;%'"; }

			$sql = ' where (' . implode(' or ', $filter) . ')';
		}

		if (!empty($regions[0]))
		{
			if ($sql == '')
			{ $sql = ' where LocationID in (' . implode(',', $regions) . ')'; }
			else
			{ $sql .= ' and LocationID in (' . implode(',', $regions) . ')'; }
		}

		$sql = 'select * from ' . Company::TABLE_NAME . $sql;

		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			self::createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		return Company::fetchObjects($stmt, $limit);
	}

	static function fetchObjects(PDOStatement $stmt, $limit = 0)
	{
		$companies = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			if ($limit > 0 && rand(0,1))
			{ continue; }

			$company = new Company();
			$company->name = $row['Name'];
			$company->logo = empty($row['Logo']) ? sprintf(self::NO_LOGO_ICON, rand(1,8)) : $row['Logo'];
			$company->description = $row['Description'];
			$company->website = $row['Website'];
			$company->phoneNumber = $row['PhoneNumber'];
			$company->email = $row['Email'];
			$company->region = (int)$row['LocationID'];
			$company->socialMedia = 'https://' . $row['SocialMedia'];
			$company->categories = [];

			foreach (explode(self::VALUES_DELIMITER, $row['CategoriesID']) as $category)
			{
				if ($category > 0)
				{ $company->categories[] = (int)$category; }
			}

			$companies[(int)$row['ID']] = $company;

			if ($limit == 1)
			{ break; }

			--$limit;
		}

		return $companies;
	}

	//TODO: public function insertCompanyData()
}