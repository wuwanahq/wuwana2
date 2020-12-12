<?php
namespace DataAccess;
use PDO;

/**
 * Data Access for Tags and keywords (regex).
 * @author Vince <vincent.boursier@gmail.com>
 */
class Tag extends DataAccess
{
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

	public function insert(TagObject $tag)
	{
		$query = $this->pdo->prepare('insert into Tag (ID,Visible,Name,Keywords)
			select coalesce(max(ID)+1,' . self::INT_MIN . '),?,?,? from Tag');

		$query->bindValue(1, $tag->isVisible ? 1 : 0, PDO::PARAM_INT);
		$query->bindValue(2, $tag->name, PDO::PARAM_STR);
		$query->bindValue(3, $tag->keywords, PDO::PARAM_STR);
		$query->execute();
	}

	public function selectAll()
	{
		return new TagsIterator($this->pdo->query('select * from Tag'));
	}
}