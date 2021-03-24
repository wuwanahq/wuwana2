<?php
namespace DataAccess;
use Iterator;
use PDO;
use PDOStatement;

/**
 * Tags iterator.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class TagsIterator implements Iterator
{
	private $query;
	private $row;

	public function __construct(PDOStatement $query)
	{
		$this->query = $query;
	}

	public function rewind()
	{
		if (isset($this->row))
		{
			$this->query->closeCursor();
			$this->query->execute();
		}

		$this->row = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function next()
	{
		$this->row = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function valid()
	{
		return $this->row != false;
	}

	public function current()
	{
		$tag = new TagData();
		$tag->names = $this->row['Names'];
		$tag->keywords = $this->row['Keywords'];
		return $tag;
	}

	public function key()
	{
		return $this->row['ID'];
	}
}