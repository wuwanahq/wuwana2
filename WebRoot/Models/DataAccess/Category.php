<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored categories.
 * @deprecated To update!
 * @author Vince <vincent.boursier@gmail.com>
 */
class Category extends DataAccess
{
	static function getTableSchema()
	{
		return 'create table Category (
			ID smallint primary key,
			English varchar(255) not null,
			Spanish varchar(255) not null)';
	}

	public function insertData($filePath)
	{
		if ($this->pdo->exec('drop table Category') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::importData($filePath, 'Category', [
			'ID'      => PDO::PARAM_INT,
			'English' => PDO::PARAM_STR,
			'Spanish' => PDO::PARAM_STR,
		]);
	}

	public function selectAll()
	{
		$sql = 'select * from Category';
		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			$this->createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		$categories = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$categories[(int)$row['ID']] = [
				'en' => $row['English'],
				'es' => $row['Spanish'],
			];
		}

		return $categories;
	}
}