<?php
namespace DataAccess;
use PDO;

/**
 * Data access layer for stored users.
 * @author Vince <vincent.boursier@gmail.com>
 */
class User extends DataAccess
{
	const HASH_ALGO = 'fnv164';

	public $email;
	public $name;
	public $company;
	public $accessCode;
	public $lastLogin;

	static function getTableSchema()
	{
		return 'create table User ('
			. 'Hash char(' . strlen(hash(self::HASH_ALGO, '', true)) . ') primary key,'
			. 'Email varchar(255) not null,'
			. 'Name varchar(255) not null,'
			. 'CompanyID int not null,'
			. 'AccessCode smallint not null,'
			. 'LastLogin int not null)';
	}

	public function importData($filePath)
	{
		if ($this->pdo->exec('drop table User') === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTable();

		parent::insertData($filePath, 'User', [
			'Email'      => PDO::PARAM_LOB,
			'Name'       => PDO::PARAM_STR,
			'CompanyID'  => PDO::PARAM_INT,
			'AccessCode' => PDO::PARAM_INT,
			'LastLogin'  => PDO::PARAM_INT,
		]);
	}

	/**
	 * Find a user by its hashed email address.
	 * @param string $hash Binary hash
	 * @return \DataAccess\User
	 */
	public function selectEmail($hash)
	{
		$query = $this->pdo->prepare('select * from User where Hash=?');
		$query->bindValue(1, $hash, PDO::PARAM_LOB);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);

		if (empty($row['Email']))
		{ return null; }

		$user = new User();
		$user->email = $row['Email'];
		$user->name = $row['Name'];
		$user->company = $row['CompanyID'];
		$user->accessCode = $row['AccessCode'];
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
	public function insertUser($hash, $email, $companyID, $code)
	{
		$query = $this->pdo->prepare(
			'insert into User (Hash,Email,Name,CompanyID,AccessCode,LastLogin) values (?,?,?,?,?,0)');

		$query->bindValue(1, $hash, PDO::PARAM_LOB);
		$query->bindValue(2, $email, PDO::PARAM_STR);
		$query->bindValue(3, $email, PDO::PARAM_STR);
		$query->bindValue(4, $companyID, PDO::PARAM_INT);
		$query->bindValue(5, $code, PDO::PARAM_INT);
		return $query->execute();
	}

	// updateUserCode
	public function updateCode($hash, $code)
	{
		$query = $this->pdo->prepare(
			'update User set AccessCode=?,LastLogin=? where Hash=?');

		$query->bindValue(1, $code, PDO::PARAM_INT);
		$query->bindValue(2, time(), PDO::PARAM_INT);
		$query->bindValue(3, $hash, PDO::PARAM_LOB);
		$query->execute();
	}

	// countUser
	public function countAll()
	{
		return (int)$this->pdo->query('select count(*) from User')->fetchColumn(0);
	}
}