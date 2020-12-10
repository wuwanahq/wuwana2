<?php
namespace WebApp;
use DataAccess\User;

/**
 * User session.
 * @author Vince <vincent.boursier@gmail.com>
 */
class UserSession
{
	const HASH_ALGO = 'sha256';
	private $user;

	public function __construct(User $dataAccessObject)
	{
		$this->user = $dataAccessObject;

		if (filter_has_var(INPUT_POST, 'email') && filter_has_var(INPUT_POST, 'code'))
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
		$user = $this->user->selectEmail($email);

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

	/**
	 * Send the access code by email.
	 * @param string $address Email address
	 * @param string $subject Title
	 * @param string $message HTML body of the Email
	 */
	public function sendEmail($toAddress, $fromAddress, $subject, $messageBody)
	{
		$toAddress = strtolower(trim($toAddress));
		//$hash = self::hash($address);
		$code = $this->generateCode($toAddress);
		$subject = sprintf($subject, $code);

		mail(
			$toAddress,
			$subject,
			'<html><head><title>' . $subject . '</title></head><body>'
			. sprintf($messageBody, $code)
			. '</body></html>',
			'From: ' . $fromAddress
		);
	}

	/**
	 * Create a new user.
	 * @param string $email
	 * @return int Randomly generated code else 0
	 */
	private function generateCode($email)
	{
		$name = $email[0] . '…' . substr($email, strpos($email, '@'));
		$email = self::hash($email);
		$code = rand(1, User::CODE_MAX_VALUE);
		$companyID = $this->user->countAdmin() === 0 ? -1 : 0;

		if ($this->user->insertUser($email, $name, $companyID, $code))
		{ return $code; }
		elseif ($companyID == -1)
		{ $this->user->updateCompany($companyID, $email); }

		$this->user->updateCode($email, $code);
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