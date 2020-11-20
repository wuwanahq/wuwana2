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

	private function createTable()
	{
		$result = $this->pdo->exec(
			'create table User ('
			. 'Email char(' . strlen(hash(self::HASH_ALGO, '', true)) . ') primary key,'
			. 'Name varchar(255) not null,'
			. 'CompanyID int not null,'
			. 'AccessCode smallint not null,'
			. 'LastLogin int not null)');

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
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
	 * Find a user by email address.
	 * @param string $email Binary hash
	 * @return \DataAccess\User
	 */
	public function selectEmail($email)
	{
		$query = $this->pdo->prepare('select * from User where Email=?');
		$query->bindValue(1, $email, PDO::PARAM_LOB);
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
	 * @param string $email
	 * @param string $name
	 * @param int $companyID
	 * @param int $code
	 * @return bool Success or failure
	 */
	public function insertUser($email, $name, $companyID, $code)
	{
		$query = $this->pdo->prepare(
			'insert into User (Email,Name,CompanyID,AccessCode,LastLogin) values (?,?,?,?,0)');

		$query->bindValue(1, $email, PDO::PARAM_LOB);
		$query->bindValue(2, $name, PDO::PARAM_STR);
		$query->bindValue(3, $companyID, PDO::PARAM_INT);
		$query->bindValue(4, $code, PDO::PARAM_INT);
		return $query->execute();
	}

	// updateUserCode
	public function updateCode($email, $code)
	{
		$query = $this->pdo->prepare(
			'update User set AccessCode=?,LastLogin=? where Email=?');

		$query->bindValue(1, $code, PDO::PARAM_INT);
		$query->bindValue(2, time(), PDO::PARAM_INT);
		$query->bindValue(3, $email, PDO::PARAM_LOB);
		$query->execute();
	}

	// countUser
	public function countAll()
	{
		return (int)$this->pdo->query('select count(*) from User')->fetchColumn(0);
	}
}