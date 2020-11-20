<?php
namespace DataAccess;
use PDO;
use Iterator;

/**
 * Data Access Iterator for Tags and keywords (regex).
 * @author Vince <vincent.boursier@gmail.com>
 */
class Tag extends DataAccess implements Iterator
{
	private $query;
	private $currentRow;

	private function createTable()
	{
		$result = $this->pdo->exec(
			'create table Tag ('
			. 'Name varchar(128) not null,'
			. 'Keywords varchar(255) not null)');

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}

	public function importData($filePath)
	{
		if ($this->pdo->exec('drop table Tag') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::insertData($filePath, 'Tag', [
			'Name'     => PDO::PARAM_STR,
			'Keywords' => PDO::PARAM_STR,
		]);
	}

	public function current()
	{
		return $this->currentRow['Keywords'];
	}

	public function key()
	{
		return $this->currentRow['Name'];
	}

	public function next()
	{
		$this->currentRow = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function rewind()
	{
		$this->query = $this->pdo->query('select * from Tag');
	}

	public function valid()
	{
		return $this->currentRow != false;
	}
}