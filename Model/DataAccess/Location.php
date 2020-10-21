<?php
namespace DataAccess;
use PDO;
use PDOStatement;

/**
 * Data Access Object for company locations.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Location
{
	const TABLE_NAME = 'Location';
	const COLUMNS = [
		'ID'          => PDO::PARAM_INT,
		'CountryCode' => PDO::PARAM_STR,
		'Region'      => PDO::PARAM_STR,
	];

	public $country;
	public $region;

	static function getTableSchema()
	{
		return 'create table ' . self::TABLE_NAME . ' ('
			. 'ID smallint primary key,'
			. 'CountryCode char(2) not null,'
			. 'Region varchar(255) not null)';
	}

	static function fetchObjects(PDOStatement $stmt)
	{
		$locations = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$location = new Location();
			$location->country = $row['CountryCode'];
			$location->region  = $row['Region'];

			$locations[(int)$row['ID']] = $location;
		}

		return $locations;
	}
}