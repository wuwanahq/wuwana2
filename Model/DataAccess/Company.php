<?php
namespace DataAccess;
use PDO;
use PDOStatement;

/**
 * Data Access Object for Companies.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Company
{
	const NO_LOGO_ICON = '/static/logo-square%u.png';
	const VALUES_DELIMITER = ';';
	const TABLE_NAME = 'Company';
	const COLUMNS = [
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
	];

	public $name;
	public $logo;
	public $description;
	public $website;
	public $phoneNumber;
	public $email;
	public $region;
	public $categories;
	public $socialMedia;

	static function getTableSchema()
	{
		return 'create table ' . self::TABLE_NAME . ' ('
			. 'ID int primary key,'
			. 'Name varchar(255) not null,'
			. 'Logo varchar(255) not null,'
			. 'Description varchar(255) not null,'
			. 'Website varchar(255) not null,'
			. 'PhoneNumber varchar(255) not null,'
			. 'Email varchar(255) not null,'
			. 'LocationID smallint not null,'
			. 'CategoriesID varchar(255) not null,'
			. 'SocialMedia varchar(255) not null)';
	}

	static function fetchObjects(PDOStatement $stmt)
	{
		$companies = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
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
		}

		return $companies;
	}
}