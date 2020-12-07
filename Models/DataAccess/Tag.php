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
			Visible tinyint not null,
			Name varchar(255) not null,
			Keywords varchar(255) not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'Tag', [
			'ID'       => PDO::PARAM_INT,
			'Visible'  => PDO::PARAM_INT,
			'Name'     => PDO::PARAM_STR,
			'Keywords' => PDO::PARAM_STR,
		]);
	}

	public function rewind()
	{
		$this->query = $this->pdo->query('select * from Tag');
		$this->currentRow = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function valid()
	{
		return $this->currentRow != false;
	}

	public function next()
	{
		$this->currentRow = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function current()
	{
		return $this->currentRow['Keywords'];
	}

	public function key()
	{
		return $this->currentRow['Name'];
	}

	public function isVisibleTag()
	{
		return $this->currentRow['Visible'] == 1;
	}
}