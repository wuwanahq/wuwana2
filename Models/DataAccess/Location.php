<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored locations.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class Location extends DataAccess
{
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

	public function selectUsefulItemsOnly($countryCode)
	{
		return $this->fetchQuery("select * from Location where CountryCode='" . $countryCode[0] . $countryCode[1]
			. "' and ID in (select LocationID from Company)");
	}

	public function selectCountry($code)
	{
		return $this->fetchQuery("select ID,RegionName from Location where CountryCode='" . $code[0] . $code[1] . "'");
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
		{ $locations[(int)$row['ID']] = $row['RegionName']; }

		return $locations;
	}
}