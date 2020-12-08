<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored locations.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Location extends DataAccess
{
	public $country;
	public $region;

	static function getTableSchema()
	{
		return 'create table Location (
			ID smallint primary key,
			CountryCode char(2) not null,
			RegionName varchar(255) not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'Location', [
			'ID'          => PDO::PARAM_INT,
			'CountryCode' => PDO::PARAM_STR,
			'RegionName'  => PDO::PARAM_STR,
		]);
	}

	//TODO: public function exportData()

	public function selectUsefulItemsOnly()
	{
		return $this->fetchQuery('select * from Location where ID in (select LocationID from Company)');
	}

	public function selectAll()
	{
		return $this->fetchQuery('select * from Location');
	}

	private function fetchQuery($sql)
	{
		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			$this->createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		$locations = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$location = new self();
			$location->country = $row['CountryCode'];
			$location->region = $row['RegionName'];

			$locations[(int)$row['ID']] = $location;
		}

		return $locations;
	}
}