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
	const NO_LOGO_ICON = '/static/logo_circular.png';
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
	];

	public $name;
	public $logo;
	public $description;
	public $website;
	public $phoneNumber;
	public $email;
	public $region;
	public $categories;

	static function fetchObjects(PDOStatement $stmt)
	{
		$companies = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$company = new Company();
			$company->name = $row['Name'];
			$company->logo = empty($row['Logo']) ? self::NO_LOGO_ICON : $row['Logo'];
			$company->description = $row['Description'];
			$company->website = $row['Website'];
			$company->phoneNumber = $row['PhoneNumber'];
			$company->email = $row['Email'];
			$company->region = (int)$row['LocationID'];
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