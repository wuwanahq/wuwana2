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
	const HASH_ALGO = 'fnv164';
	const TABLE_NAME = 'User';
	const COLUMNS = [
		'Email'      => PDO::PARAM_LOB,
		'Name'       => PDO::PARAM_STR,
		'CompanyID'  => PDO::PARAM_INT,
		'AccessCode' => PDO::PARAM_INT,
		'LastLogin'  => PDO::PARAM_INT,
	];

	public $email;
	public $company;
	public $accessCode;
	public $lastLogin;

	static function getTableSchema()
	{
		return 'create table ' . self::TABLE_NAME . ' ('
			. 'Email char(' . strlen(hash(self::HASH_ALGO, '', true)) . ') primary key,'
			. 'Name varchar(255) not null,'
			. 'CompanyID int not null,'
			. 'AccessCode smallint not null,'
			. 'LastLogin int not null)';
	}

	static function fetchObject(PDOStatement $query)
	{
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if (!isset($row[0]))
		{ return null; }

		$user = new User();
		$user->email = $row[0]['Email'];
		$user->name = $row[0]['Name'];
		$user->company = $row[0]['CompanyID'];
		$user->accessCode = $row[0]['AccessCode'];
		$user->lastLogin = $row[0]['LastLogin'];

		return $user;
	}
}