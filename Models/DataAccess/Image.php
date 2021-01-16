<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored image links.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class Image extends DataAccess
{
	static function getTableSchema()
	{
		return 'create table Image (
			CompanyID int not null,
			SocialMediaID tinyint not null,
			URL varchar(500) not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'Image', [
			'CompanyID'     => PDO::PARAM_INT,
			'SocialMediaID' => PDO::PARAM_INT,
			'URL'           => PDO::PARAM_STR,
		]);
	}

	public function exportData()
	{
		parent::exportTable('Image');
	}

	public function insert(array $imageLinks, $companyID, $socialMediaID)
	{
		$query = $this->pdo->prepare('insert into Image (CompanyID,SocialMediaID,URL) values (?,?,?)');
		$query->bindParam(1, $companyID, PDO::PARAM_INT);
		$query->bindParam(2, $socialMediaID, PDO::PARAM_INT);

		foreach ($imageLinks as $picture)
		{
			$query->bindParam(3, $picture, PDO::PARAM_STR);
			$query->execute();
		}
	}
}