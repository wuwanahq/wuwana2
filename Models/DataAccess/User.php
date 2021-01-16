<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored users.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class User extends DataAccess
{
	const HASH_ALGO = 'fnv164';
	const CODE_MAX_VALUE = 9999;

	static function getTableSchema()
	{
		return 'create table UserAccount (
			Hash char(' . strlen(hash(self::HASH_ALGO, '', false)) . ') primary key,
			Email varchar(250) not null,
			Name varchar(250) not null,
			CompanyID int null,
			AdminLevel tinyint not null,
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
	 * @param string $hash Binary hash
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

		$user = new UserObject();
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
	 * @param string $hash Binary hash
	 * @param string $email Shortened email address
	 * @param int $companyID
	 * @param int $code
	 * @return bool Success or failure
	 */
	public function insertUser($hash, $email, $companyID, $code, $adminLevel)
	{
		$query = $this->pdo->prepare(
			'insert into UserAccount (Hash,Email,Name,CompanyID,AdminLevel,AccessCode,LastLogin) values (?,?,?,?,?,?,0)');

		$debug = $this->pdo->errorInfo();

		$query->bindValue(1, $hash, PDO::PARAM_STR);
		$query->bindValue(2, $email, PDO::PARAM_STR);
		$query->bindValue(3, $email, PDO::PARAM_STR);
		$query->bindValue(4, $companyID, PDO::PARAM_INT);
		$query->bindValue(5, $adminLevel, PDO::PARAM_INT);
		$query->bindValue(6, $code, PDO::PARAM_INT);
		$debug = $query->execute();

		trigger_error('DEBUG - New user inserted? ' . var_export($debug, true));
		return $debug;
	}

	// updateUserCode
	public function updateCode($hash, $code)
	{
		// For whatever reason the code below refuse to work with MariaDB v10.1
		// even when the execute method return true!
		$query = $this->pdo->prepare('update UserAccount set AccessCode=?,LastLogin=? where Hash=?');
		$query->bindValue(1, $code, PDO::PARAM_INT);
		$query->bindValue(2, time(), PDO::PARAM_INT);
		$query->bindValue(3, $hash, PDO::PARAM_STR);
		$debug = $query->execute();

		trigger_error('DEBUG - Code updated? ' . var_export($debug, true));
		trigger_error('DEBUG - Query error info=' . var_export($query->errorInfo(), true));
		trigger_error('DEBUG - PDO error info=' . var_export($this->pdo->errorInfo(), true));
	}

	public function updateAdminLevel($level, $hash)
	{
		$query = $this->pdo->prepare(
			'update UserAccount set AdminLevel=? where Hash=?');

		$query->bindValue(1, $level, PDO::PARAM_INT);
		$query->bindValue(2, $hash, PDO::PARAM_STR);
		$debug = $query->execute();

		trigger_error('DEBUG - User updated? ' . var_export($debug, true));
	}

	// countUser
	public function countAll()
	{
		return $this->pdo->query('select count(*) from UserAccount')->fetchAll(PDO::FETCH_COLUMN, 0)[0];
	}

	public function countAdmin()
	{
		return $this->pdo->query('select count(*) from UserAccount where AdminLevel > 0')
			->fetchAll(PDO::FETCH_COLUMN, 0)[0];
	}
}