<?php
namespace DataAccess;
use PDO;

/**
 * Data Access for Tags and keywords (regex).
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class Tag extends DataAccess
{
	static function getLanguageIndex($languageCode)
	{
		if ($languageCode == 'es')
		{ return 1; }

		return 0;
	}

	static function getTableSchema()
	{
		return 'create table Tag (
			ID varchar(250) primary key,
			Names varchar(255) not null,
			Keywords varchar(255) not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'Tag', [
			'ID'       => PDO::PARAM_STR,
			'Names'    => PDO::PARAM_STR,
			'Keywords' => PDO::PARAM_STR,
		]);
	}

	public function exportData()
	{
		parent::exportTable('Tag');
	}

	public function insert($id, TagObject $tag)
	{
		$tagNames = explode(parent::VALUES_DELIMITER, $tag->names);

		foreach ($this->selectBaseTags() as $tagID => $currentTag)
		{
			$currentTagNames = explode(parent::VALUES_DELIMITER, $currentTag->names);

			$query = $this->pdo->prepare("insert into Tag (ID,Names,Keywords) values (?,?,'')");
			$query->bindValue(1, $id . $tagID, PDO::PARAM_STR);
			$query->bindValue(
				2,
				$tagNames[0] . ' ' . $currentTagNames[0] . parent::VALUES_DELIMITER .
					$tagNames[1] . ' ' . $currentTagNames[1],
				PDO::PARAM_STR);

			$query->execute();
		}

		$query = $this->pdo->prepare('insert into Tag (ID,Names,Keywords) values (?,?,?)');
		$query->bindValue(1, $id, PDO::PARAM_STR);
		$query->bindValue(2, $tag->names, PDO::PARAM_STR);
		$query->bindValue(3, $tag->keywords, PDO::PARAM_STR);
		$query->execute();
	}

	public function selectBaseTags()
	{
		return new TagsIterator($this->pdo->query("select * from Tag where Keywords <> ''"));
	}

	public function selectCombinations()
	{
		return new TagsIterator($this->pdo->query("select * from Tag where Keywords = ''"));
	}
}