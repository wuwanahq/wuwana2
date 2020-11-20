<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored categories.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Category extends DataAccess
{
	private function createTable()
	{
		$result = $this->pdo->exec(
			'create table Category ('
			. 'ID smallint primary key,'
			. 'English varchar(255) not null,'
			. 'Spanish varchar(255) not null)');

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}

	public function importData($filePath)
	{
		if ($this->pdo->exec('drop table Category') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::insertData($filePath, 'Category', [
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
			$this->createTable();
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