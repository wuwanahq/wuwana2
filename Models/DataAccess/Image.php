<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored image links.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Image extends DataAccess
{
	static function getTableSchema()
	{
		return 'create table Image (
			SocialMediaID int not null,
			URL varchar(500) not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'Image', [
			'SocialMediaID' => PDO::PARAM_INT,
			'URL'           => PDO::PARAM_STR,
		]);
	}

	public function insert(array $imageLinks, $socialMediaID)
	{
		$query = $this->pdo->prepare('insert into Image (SocialMediaID,URL) values (?,?)');

		foreach ($imageLinks as $picture)
		{
			$query->bindValue(1, $socialMediaID, PDO::PARAM_INT);
			$query->bindValue(2, $picture, PDO::PARAM_STR);
			$query->execute();
		}
	}
}