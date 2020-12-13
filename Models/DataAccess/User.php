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
		return 'create table UserAccount ('
			. 'Hash binary(' . strlen(hash(self::HASH_ALGO, '', true)) . ') primary key,'
			. 'Email varchar(255) not null,'
			. 'Name varchar(255) not null,'
			. 'CompanyID int not null,'
			. 'AccessCode smallint not null,'
			. 'LastLogin int not null)';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'UserAccount', [
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
		trigger_error('DEBUG - Email hash=' . bin2hex($hash));

		$query = $this->pdo->prepare('select * from UserAccount where Hash=?');
		$query->bindValue(1, $hash, PDO::PARAM_LOB);
		$debug = $query->execute();

		trigger_error('DEBUG - Email found? ' . var_export($debug, true));
		trigger_error('DEBUG - Select query info=' . var_export($query->errorInfo(), true));
		trigger_error('DEBUG - Select query PDO info=' . var_export($this->pdo->errorInfo(), true));

		$row = $query->fetchAll(PDO::FETCH_ASSOC);
		trigger_error('DEBUG - Row=' . var_export($row, true));

		if (empty($row))
		{ return null; }

		$row = $row[0];

		$user = new UserObject();
		$user->email = $row['Email'];
		$user->name = $row['Name'];
		$user->company = $row['CompanyID'];
		$user->accessCode = str_pad($row['AccessCode'], 4, '0', STR_PAD_LEFT);
		$user->lastLogin = $row['LastLogin'];
		trigger_error('DEBUG - UserObject=' . var_export($user, true));
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
			'insert into UserAccount (Hash,Email,Name,CompanyID,AccessCode,LastLogin) values (?,?,?,?,?,0)');

		$query->bindValue(1, $hash, PDO::PARAM_LOB);
		$query->bindValue(2, $email, PDO::PARAM_STR);
		$query->bindValue(3, $email, PDO::PARAM_STR);
		$query->bindValue(4, $companyID, PDO::PARAM_INT);
		$query->bindValue(5, $code, PDO::PARAM_INT);
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
		$query->bindValue(3, $hash, PDO::PARAM_LOB);
		$debug = $query->execute();

		trigger_error('DEBUG - Code updated? ' . var_export($debug, true));
		trigger_error('DEBUG - Query error info=' . var_export($query->errorInfo(), true));
		trigger_error('DEBUG - PDO error info=' . var_export($this->pdo->errorInfo(), true));
	}

	public function updateCompany($id, $hash)
	{
		$query = $this->pdo->prepare(
			'update UserAccount set CompanyID=? where Hash=?');

		$query->bindValue(1, $id, PDO::PARAM_INT);
		$query->bindValue(2, $hash, PDO::PARAM_LOB);
		$debug = $query->execute();

		trigger_error('DEBUG - User updated? ' . var_export($debug, true));
	}

	// countUser
	public function countAll()
	{
		return (int)$this->pdo->query('select count(*) from UserAccount')->fetchAll(PDO::FETCH_COLUMN, 0)[0];
	}

	public function countAdmin()
	{
		$query = $this->pdo->query('select count(*) from UserAccount where CompanyID < 0');
		$nb = $query->fetchAll(PDO::FETCH_COLUMN, 0)[0];
		$debug = $query->closeCursor();

		trigger_error('DEBUG - Total admin=' . var_export($nb, true));
		trigger_error('DEBUG - Cursor closed? ' . var_export($debug, true));

		return (int)$nb;
	}
}