<?php
namespace DataAccess;
use Iterator;
use PDO;
use PDOStatement;

/**
 * Tags iterator.
 * @author Vince <vincent.boursier@gmail.com>
 */
class TagsIterator implements Iterator
{
	private $query;
	private $currentRow;

	public function __construct(PDOStatement $query)
	{
		$this->query = $query;
	}

	public function rewind()
	{
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
		$tag = new TagObject();
		$tag->name = $this->currentRow['Name'];
		$tag->keywords = $this->currentRow['Keywords'];
		$tag->isVisible = $this->currentRow['Visible'] == 1;
		return $tag;
	}

	public function key()
	{
		return $this->currentRow['ID'];
	}
}