<?php
namespace WebApp;
use DataAccess;

/**
 * User session.
 * @author Vince <vincent.boursier@gmail.com>
 */
class UserSession
{
	const HASH_ALGO = 'sha256';

	private $dao;
	private $name;
	private $companyID = 0;

	public function __get($property)
	{
		switch ($property)
		{
			case 'name': return $this->name;
			case 'companyID': return $this->companyID;
		}

		trigger_error('Undefined property ' . $property, E_USER_ERROR);
	}

	public function __construct(DataAccess $dao)
	{
		$this->dao = $dao;
		$login = filter_input(INPUT_GET, 'login');

		if (strlen($login) > 16)
		{
			$hash = substr($login, 0, 16);
			$code = substr($login, 16);

			$user = $this->dao->getUser(hex2bin($hash));

			if ($user instanceof DataAccess\User && $user->accessCode === $code)
			{
				session_start([
					'cookie_lifetime' => Config::SESSION_LIFETIME,
					'gc_maxlifetime' => Config::SESSION_LIFETIME
				]);

				$_SESSION['Name'] = $this->name = $user->name;
				$_SESSION['CompanyID'] = $this->companyID = $user->company;

				session_write_close();
			}
		}
		elseif (filter_has_var(INPUT_COOKIE, 'PHPSESSID'))
		{
			session_start([
				'cookie_lifetime' => Config::SESSION_LIFETIME,
				'gc_maxlifetime' => Config::SESSION_LIFETIME,
				'read_and_close' => true
			]);

			if (!empty($_SESSION['Email']) && !empty($_SESSION['CompanyID']))
			{
				$this->name = $_SESSION['Name'];
				$this->companyID = $_SESSION['CompanyID'];
			}
		}
	}

	public function isAdmin()
	{
		return $this->companyID < 0;
	}

	public function login($email)
	{
		$email = strtolower(trim($email));
		$hash = self::hash($email);
		$user = $this->dao->getUser($hash);

		if ($user == null)
		{
			$this->createNewUser($email);
			$user = $this->dao->getUser($hash);
		}

		mail(
			$email,
			'Wuwana login link',
			'https://wuwana.com?login=' . $hash,
			[
				'From' => 'login@wuwana.com',
				'Reply-To' => 'login@wuwana.com',
			]
		);

		//TODO: update last access date time in db
	}

	private function createNewUser($email)
	{
		$name = $email[0] . '…' . substr($email, strpos($email, '@'));
		$hash = self::hash($email);
		$code = rand(1, 9999);

		$this->dao->storeUser($hash, $name, 0, $code);

		return $code;
	}

	/**
	 * Hash twice an email address.
	 * @param string $email
	 * @return string Binary hash
	 */
	static function hash($email)
	{
		return hash(DataAccess\User::HASH_ALGO, hash(self::HASH_ALGO, $email, true), true);
	}
}