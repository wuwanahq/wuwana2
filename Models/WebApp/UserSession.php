<?php
namespace WebApp;
use DataAccess\DataAccess;
use DataAccess\User;

/**
 * User session.
 * @author Vince <vincent.boursier@gmail.com>
 */
class UserSession
{
	const HASH_ALGO = 'sha256';
	private $dao;

	public function __construct(DataAccess $dao)
	{
		$this->dao = $dao;
		$login = filter_input(INPUT_GET, 'login');

		if (strlen($login) == 20)
		{
			$this->login(
				hex2bin(substr($login, 0, 16)),
				substr($login, 16)
			);
		}
		elseif (filter_has_var(INPUT_POST, 'email') && filter_has_var(INPUT_POST, 'code'))
		{
			$this->login(
				self::hash(strtolower(trim(filter_input(INPUT_POST, 'email')))),
				filter_input(INPUT_POST, 'code')
			);
		}
		elseif (filter_has_var(INPUT_COOKIE, session_name()))
		{
			session_start([
				'cookie_lifetime' => Config::SESSION_LIFETIME,
				'gc_maxlifetime' => Config::SESSION_LIFETIME,
				'read_and_close' => true
			]);
		}
	}

	private function login($email, $code)
	{
		$user = $this->dao->getUser($email);

		if ($user instanceof User && $user->accessCode === $code)
		{
			session_start([
				'cookie_lifetime' => Config::SESSION_LIFETIME,
				'gc_maxlifetime' => Config::SESSION_LIFETIME
			]);

			$_SESSION['Name'] = $user->name;
			$_SESSION['CompanyID'] = $user->company;

			session_write_close();
		}
	}

	public function logout()
	{
		session_start();
		$_SESSION = [];

		if (ini_get('session.use_cookies'))
		{
			$params = session_get_cookie_params();
			setcookie(
				session_name(), '', time() - 42000,
				$params['path'], $params['domain'],
				$params['secure'], $params['httponly']
			);
		}

		session_destroy();
	}

	public function sendEmail($email)
	{
		$email = strtolower(trim($email));
		$hash = self::hash($email);
		$code = $this->generateCode($email);

		mail(
			$email,
			'Your access code is ' . $code,
			'To login you just need to copy the code "' . $code . '" on Wuwana.com',
			['From' => 'Login Wuwana.com <login@wuwana.com>']
		);

		mail(
			$email,
			'Login link',
			'https://wuwana.com?login=' . bin2hex($hash) . $code,
			['From' => 'Login Wuwana.com <login@wuwana.com>']
		);
	}

	/**
	 * Create a new user.
	 * @param string $email
	 * @return int Randomly generated code else 0
	 */
	private function generateCode($email)
	{
		$hash = self::hash($email);
		$code = rand(1, 9999);

		$name = $email[0] . '…' . substr($email, strpos($email, '@'));
		$companyID = $this->dao->countUser() === 0 ? -1 : 0;

		if ($this->dao->insertUser($hash, $name, $companyID, $code))
		{ return $code; }

		$this->dao->updateUserCode($hash, $code);
		return $code;
	}

	/**
	 * Hash twice an email address.
	 * @param string $email
	 * @return string Binary hash
	 */
	static function hash($email)
	{
		return hash(User::HASH_ALGO, hash(self::HASH_ALGO, $email, true), true);
	}

	public function isAdmin()
	{
		return isset($_SESSION['CompanyID']) && $_SESSION['CompanyID'] < 0;
	}

	public function isLogin()
	{
		return isset($_SESSION['Name']) && isset($_SESSION['CompanyID']);
	}
}