<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored social media.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class SocialMedia extends DataAccess
{
	static function getTableSchema()
	{
		return 'create table SocialMedia (
			CompanyID int not null,
			ID tinyint not null,
			URL varchar(255) not null,
			ProfileName varchar(255) not null,
			Biography varchar(255) not null,
			ExternalLink varchar(255) not null,
			Counter1 int not null,
			Counter2 int not null,
			Counter3 int not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'SocialMedia', [
			'CompanyID'    => PDO::PARAM_INT,
			'ID'           => PDO::PARAM_INT,
			'URL'          => PDO::PARAM_STR,
			'ProfileName'  => PDO::PARAM_STR,
			'Biography'    => PDO::PARAM_STR,
			'ExternalLink' => PDO::PARAM_STR,
			'Counter1'     => PDO::PARAM_INT,
			'Counter2'     => PDO::PARAM_INT,
			'Counter3'     => PDO::PARAM_INT,
		]);
	}

	public function exportData()
	{
		parent::exportTable('SocialMedia');
	}

	public function insert(SocialMediaObject $socialMedia, $companyID)
	{
		$query = $this->pdo->query('select coalesce(max(ID)+1,0) from SocialMedia where CompanyID=' . $companyID);
		$id = $query->fetchAll(PDO::FETCH_COLUMN, 0)[0];

		$query = $this->pdo->prepare('insert into SocialMedia
			(CompanyID, ID, URL, ProfileName, Biography, ExternalLink, Counter1, Counter2, Counter3)
			values (?,?,?,?,?,?,?,?,?)');

		$query->bindValue(1, $companyID, PDO::PARAM_INT);
		$query->bindValue(2, $id, PDO::PARAM_INT);
		$query->bindValue(3, $socialMedia->url, PDO::PARAM_STR);
		$query->bindValue(4, $socialMedia->profileName, PDO::PARAM_STR);
		$query->bindValue(5, $socialMedia->biography, PDO::PARAM_STR);
		$query->bindValue(6, $socialMedia->link, PDO::PARAM_STR);
		$query->bindValue(7, $socialMedia->counter1, PDO::PARAM_INT);
		$query->bindValue(8, $socialMedia->counter2, PDO::PARAM_INT);
		$query->bindValue(9, $socialMedia->counter3, PDO::PARAM_INT);

		if ($query->execute())
		{
			$image = new Image($this->pdo);
			$image->insert($socialMedia->pictures, $companyID, $id);
		}
	}
}