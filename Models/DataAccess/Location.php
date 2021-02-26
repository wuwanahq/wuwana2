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
			CountryCode char(2) not null,
			ProvinceID varchar(6),
			foreign key(ProvinceID) references Province(ProvinceID))';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'Location', [
			'CountryCode' => PDO::PARAM_STR,
			'ProvinceID'  => PDO::PARAM_STR
		]);
	}

	//TODO: public function exportData()

	public function selectUsefulItemsOnly($countryCode,$language)
	{
		return $this->fetchQuery("select distinct Province.ProvinceID,Region.RegionID, Region.EN, Region.ES, 
            Region.FR,Region.ZH,Location.CountryCode FROM Region inner join Province on Region.RegionID=Province.RegionID 
            inner JOIN Location on Location.ProvinceID=Province.ProvinceID where 
            Location.CountryCode='" .$countryCode[0] . $countryCode[1]. "' and Province.ProvinceID
            in (select ProvinceID from Company);",$language);
	}

	public function selectCountry($code)
	{
		return $this->fetchQuery("select CountryCode,ProvinceID from Location where CountryCode='" . $code[0] . $code[1] . "'");
	}

	private function fetchQuery($sql,$language)
	{
		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			$this->createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		$locations = [];

        $provinceNameLanguage = strtoupper($language);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{ $locations[$row['RegionID']] = $row["$provinceNameLanguage"];  }

        return $locations;
	}

}