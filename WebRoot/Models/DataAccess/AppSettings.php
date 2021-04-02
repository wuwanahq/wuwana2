<?php
namespace DataAccess;
use PDO;

/**
 * WebApp settings (Key–Value store).
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class AppSettings extends DataAccess
{
	/**
	 * @inheritDoc
	 */
	static function getTableSchema()
	{
		// I used "K" for Key and "V" for Value because these words are reserved in some DB
		return 'create table AppSettings (
			K varchar(126) not null,
			V varchar(126) not null)';
	}

	/**
	 * @inheritDoc
	 */
	public function insertData($filePath)
	{
		parent::importData($filePath, 'AppSettings', [
			'K' => PDO::PARAM_STR,
			'V' => PDO::PARAM_STR,
		]);
	}

	/**
	 * Get all settings.
	 * @return array
	 */
	public function selectAll()
	{
		$settings = [];
		$query = $this->tryQuery('select * from AppSettings');

		while ($row = $query->fetch(PDO::FETCH_NUM))
		{ $settings[$row[0]] = $row[1]; }

		return $settings;
	}

	/**
	 * Update multiple settings.
	 * @param array $values
	 */
	public function updateAll($values)
	{
		$query = $this->pdo->prepare('update AppSettings set V=? where K=?');

		foreach ($values as $key => $value)
		{
			$query->bindValue(1, $value, PDO::PARAM_STR);
			$query->bindParam(2, $key, PDO::PARAM_STR);
			$query->execute();
		}
	}
}