<?php
namespace DataAccess;
use PDO;

/**
 * WebApp settings.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class AppSettings extends DataAccess
{
	static function getTableSchema()
	{
		return 'create table AppSettings (
			Key varchar(126) not null,
			Value varchar(126) not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'AppSettings', [
			'Key'   => PDO::PARAM_STR,
			'Value' => PDO::PARAM_STR,
		]);
	}

	public function selectAll()
	{
		$settings = [];
		$query = $this->tryQuery('select * from AppSettings');

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{ $settings[$row['Key']] = $row['Value']; }

		return $settings;
	}

	public function updateAll($values)
	{
		$query = $this->pdo->prepare('update AppSettings set Value=? where Key=?');

		foreach ($values as $key => $value)
		{
			$query->bindValue(1, $value, PDO::PARAM_STR);
			$query->bindParam(2, $key, PDO::PARAM_STR);
			$query->execute();
		}
	}
}