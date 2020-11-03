<?php
namespace DataAccess;
use PDO;
use PDOStatement;

/**
 * Data Access Object for users.
 * @author Vince <vincent.boursier@gmail.com>
 */
class User
{
	const TABLE_NAME = 'User';
	const COLUMNS = [
		'Email'          => PDO::PARAM_STR,
		'CompanyID'      => PDO::PARAM_INT,
		'LastAccessCode' => PDO::PARAM_INT,
		'LastLogin'      => PDO::PARAM_INT,
	];

	public $email;
	public $company;
	public $lastAccessCode;
	public $lastLogin;

	static function getTableSchema()
	{
		return 'create table ' . self::TABLE_NAME . ' ('
			. 'Email varchar(255) primary key,'
			. 'CompanyID int not null,'
			. 'LastAccessCode smallint not null,'
			. 'LastLogin int not null)';
	}

	static function fetchObject(PDOStatement $stmt)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!isset($row[0]))
		{ return null; }

		$user = new User();
		$user->email = $row[0]['Email'];
		$user->company = $row[0]['CompanyID'];
		$user->lastAccessCode = $row[0]['LastAccessCode'];
		$user->lastLogin = $row[0]['LastLogin'];

		return $user;
	}
}