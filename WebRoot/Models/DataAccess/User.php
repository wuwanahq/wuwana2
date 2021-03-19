<?php
namespace DataAccess;
use PDO;
use WebApp\Crypt;

/**
 * Data access layer for stored users.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class User extends DataAccess
{
	const CODE_MAX_VALUE = 9999;

	static function getTableSchema()
	{
		return 'create table UserAccount (
			Hash char(' . strlen(Crypt::hashUniqueID('')) . ') primary key,
			Email varchar(126) not null,
			Name varchar(126) not null,
			CompanyID int null,
			AdminLevel smallint not null,
			AccessCode smallint not null,
			LastLogin int not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'UserAccount', [
			'Hash'       => PDO::PARAM_STR,
			'Email'      => PDO::PARAM_STR,
			'Name'       => PDO::PARAM_STR,
			'CompanyID'  => PDO::PARAM_INT,
			'AdminLevel' => PDO::PARAM_INT,
			'AccessCode' => PDO::PARAM_INT,
			'LastLogin'  => PDO::PARAM_INT,
		]);
	}

	public function exportData()
	{
		parent::exportTable('UserAccount');
	}

	/**
	 * Find a user by its hashed email address.
	 * @param string $hash
	 * @return \DataAccess\User
	 */
	public function selectEmail($hash)
	{
		$query = $this->pdo->prepare('select * from UserAccount where Hash=?');
		$query->bindValue(1, $hash, PDO::PARAM_STR);
		$query->execute();

		$row = $query->fetchAll(PDO::FETCH_ASSOC);

		if (empty($row))
		{ return null; }

		$row = $row[0];

		$user = new UserData();
		$user->email = $row['Email'];
		$user->name = $row['Name'];
		$user->company = $row['CompanyID'];
		$user->adminLevel = $row['AdminLevel'];
		$user->accessCode = str_pad($row['AccessCode'], 4, '0', STR_PAD_LEFT);
		$user->lastLogin = $row['LastLogin'];
		return $user;
	}

	/**
	 * Create a new user.
	 * @param string $hash
	 * @param string $email Shortened email address
	 * @param int $companyID
	 * @param int $code
	 * @return bool Success or failure
	 */
	public function insertUser($hash, $email, $companyID, $code, $adminLevel)
	{
		$query = $this->pdo->prepare(
			'insert into UserAccount (Hash,Email,Name,CompanyID,AdminLevel,AccessCode,LastLogin) values (?,?,?,?,?,?,0)');

		$query->bindValue(1, $hash, PDO::PARAM_STR);
		$query->bindValue(2, $email, PDO::PARAM_STR);
		$query->bindValue(3, $email, PDO::PARAM_STR);
		$query->bindValue(4, $companyID, PDO::PARAM_INT);
		$query->bindValue(5, $adminLevel, PDO::PARAM_INT);
		$query->bindValue(6, $code, PDO::PARAM_INT);
		return $query->execute();
	}

	/**
	 * Update user access code.
	 * @param string $hash
	 * @param int $code
	 * @todo Test on the server with MariaDB v10.1
	 */
	public function updateCode($hash, $code)
	{
		$query = $this->pdo->prepare('update UserAccount set AccessCode=?,LastLogin=? where Hash=?');
		$query->bindValue(1, $code, PDO::PARAM_INT);
		$query->bindValue(2, time(), PDO::PARAM_INT);
		$query->bindValue(3, $hash, PDO::PARAM_STR);
		$query->execute();
	}

	public function updateLastLoginDate($hash)
	{
		$query = $this->pdo->prepare('update UserAccount set LastLogin=? where Hash=?');
		$query->bindValue(1, time(), PDO::PARAM_INT);
		$query->bindValue(2, $hash, PDO::PARAM_STR);
		$query->execute();
	}

	/**
	 * Change user administration level.
	 * @param int $level
	 * @param string $hash
	 */
	public function updateAdminLevel($level, $hash)
	{
		$query = $this->pdo->prepare('update UserAccount set AdminLevel=? where Hash=?');
		$query->bindValue(1, $level, PDO::PARAM_INT);
		$query->bindValue(2, $hash, PDO::PARAM_STR);
		$query->execute();
	}

	/**
	 * Count the total number of registered users.
	 * @return int
	 */
	public function countAll()
	{
		return $this->pdo->query('select count(*) from UserAccount')->fetchAll(PDO::FETCH_COLUMN, 0)[0];
	}

	public function countAdmin()
	{
		return $this->pdo->query('select count(*) from UserAccount where AdminLevel > 0')
			->fetchAll(PDO::FETCH_COLUMN, 0)[0];
	}

	public function deleteAll()
	{
		$this->pdo->exec('delete from UserAccount');
	}
}