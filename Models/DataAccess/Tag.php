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
	public $name;
	public $keywords;
	public $isVisible;

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

	public function store()
	{
		$query = $this->pdo->query('select coalesce(max(ID)+1,' . self::INT_MIN . ') from Tag');
		$query->execute();
		$id = $query->fetchColumn(0);

		$query = $this->pdo->prepare('insert into Tag (ID,Visible,Name,Keywords)
			values ((select coalesce(max(ID)+1,' . self::INT_MIN . ') from Tag),?,?,?)');

		$query->bindValue(1, $this->isVisible ? 1 : 0, PDO::PARAM_INT);
		$query->bindValue(2, $this->name, PDO::PARAM_STR);
		$query->bindValue(3, $this->keywords, PDO::PARAM_STR);
		$query->execute();
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
		$tag = new Tag();
		$tag->name = $this->currentRow['Name'];
		$tag->keywords = $this->currentRow['Keywords'];
		$tag->isVisible = $this->currentRow['Visible'] == 1;
		return $tag;
	}

	public function key()
	{
		return $this->currentRow['ID'];
	}

	public function isVisibleTag()
	{
		return $this->currentRow['Visible'] == 1;
	}
}