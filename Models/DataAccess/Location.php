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

	private function createTable()
	{
		$result = $this->pdo->exec(
			'create table Location ('
			. 'ID smallint primary key,'
			. 'CountryCode char(2) not null,'
			. 'Region varchar(255) not null)');

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}

	public function importData($filePath)
	{
		if ($this->pdo->exec('drop table Location') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::insertData($filePath, 'Location', [
			'ID'          => PDO::PARAM_INT,
			'CountryCode' => PDO::PARAM_STR,
			'Region'      => PDO::PARAM_STR,
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
			$this->createTable();
			$stmt = $this->pdo->query($sql);
		}

		$locations = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$location = new self();
			$location->country = $row['CountryCode'];
			$location->region  = $row['Region'];

			$locations[(int)$row['ID']] = $location;
		}

		return $locations;
	}
}