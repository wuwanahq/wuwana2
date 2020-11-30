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

	static function getTableSchema()
	{
		return 'create table Tag (
			ID int primary key,
			Names varchar(255) not null,
			Keywords varchar(255) not null)';
	}

	public function importData($filePath)
	{
		if ($this->pdo->exec('drop table Tag') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::insertData($filePath, 'Tag', [
			'ID'       => PDO::PARAM_INT,
			'Names'    => PDO::PARAM_STR,
			'Keywords' => PDO::PARAM_STR,
		]);
	}

	public function current()
	{
		return $this->currentRow['Keywords'];
	}

	public function key()
	{
		return $this->currentRow['Names'];
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