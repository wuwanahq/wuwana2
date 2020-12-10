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
	const CODE_MAX_VALUE = 9999;

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

	public function insertData($filePath)
	{
		parent::importData($filePath, 'User', [
			'Hash'       => PDO::PARAM_LOB,
			'Email'      => PDO::PARAM_STR,
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

		$user = new UserObject();
		$user->email = $row['Email'];
		$user->name = $row['Name'];
		$user->company = $row['CompanyID'];
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

	public function updateCompany($id, $hash)
	{
		$query = $this->pdo->prepare(
			'update User set CompanyID=? where Hash=?');

		$query->bindValue(1, $id, PDO::PARAM_INT);
		$query->bindValue(2, $hash, PDO::PARAM_LOB);
		$query->execute();
	}

	// countUser
	public function countAll()
	{
		return (int)$this->pdo->query('select count(*) from User')->fetchAll(PDO::FETCH_COLUMN, 0)[0];
	}

	public function countAdmin()
	{
		return (int)$this->pdo->query('select count(*) from User where CompanyID < 0')->fetchAll(PDO::FETCH_COLUMN,0)[0];
	}
}