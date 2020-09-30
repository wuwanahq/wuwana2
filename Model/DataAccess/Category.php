<?php
namespace DataAccess;
use PDO;
use PDOStatement;

/**
 * Data Access Object for company categories.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Category
{
	const TABLE_NAME = 'Category';
	const COLUMNS = [
		'ID'      => PDO::PARAM_INT,
		'English' => PDO::PARAM_STR,
		'Spanish' => PDO::PARAM_STR,
	];

	public $english;
	public $spanish;

	static function fetchObjects(PDOStatement $stmt)
	{
		$categories = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category = new Category();
			$category->english = $row['English'];
			$category->spanish = $row['Spanish'];

			$categories[(int)$row['ID']] = $category;
		}

		return $categories;
	}
}