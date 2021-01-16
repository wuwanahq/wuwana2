<?php
namespace WebApp;
use DataAccess\User;
use DataAccess\UserObject;

/**
 * User session.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class UserSession
{
	const HASH_ALGO = 'sha256';
	private $user;

	public function __construct(User $dataAccess)
	{
		$this->user = $dataAccess;

		if (filter_has_var(INPUT_POST, 'email') && filter_has_var(INPUT_POST, 'code'))
		{
			$this->login(
				self::hash(strtolower(trim(filter_input(INPUT_POST, 'email')))),
				trim(filter_input(INPUT_POST, 'code'))
			);
		}
		elseif (filter_has_var(INPUT_COOKIE, session_name()))
		{
			$debug = session_start([
				'cookie_lifetime' => Config::SESSION_LIFETIME,
				'gc_maxlifetime' => Config::SESSION_LIFETIME,
				'read_and_close' => true
			]);

			trigger_error('DEBUG - Session already started? ' . var_export($debug, true));
			trigger_error('DEBUG - Session=' . var_export($_SESSION, true));
		}
	}

	private function login($email, $code)
	{
		$user = $this->user->selectEmail($email);

		if ($user instanceof UserObject && $user->accessCode == $code)
		{
			$debug = session_start([
				'cookie_lifetime' => Config::SESSION_LIFETIME,
				'gc_maxlifetime' => Config::SESSION_LIFETIME
			]);

			trigger_error('DEBUG - Session started? ' . var_export($debug, true));

			$_SESSION['Name'] = $user->name;
			$_SESSION['CompanyID'] = $user->company;
			$_SESSION['AdminLevel'] = $user->adminLevel;

			trigger_error('DEBUG - Session=' . var_export($_SESSION, true));

			$debug2 = session_write_close();
			trigger_error('DEBUG - Session written? ' . var_export($debug2, true));
			trigger_error('DEBUG - Session=' . var_export($_SESSION, true));
		}

		trigger_error('DEBUG - Login with email=' . var_export($email, true) . ' and code=' . var_export($code, true));
		trigger_error('DEBUG - User=' . var_export($user, true));
	}

	public function logout()
	{
		$debug = session_start();
		trigger_error('DEBUG - Session destroyed? ' . var_export($debug, true));
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

		trigger_error('DEBUG - 1st email toAddress=' . var_export($toAddress, true));
		trigger_error('DEBUG - 1st email fromAddress=' . var_export($fromAddress, true));
		trigger_error('DEBUG - 1st email subject=' . var_export($subject, true));

		$debug = mail(
			$toAddress,
			$subject,
			'<html><head><title>' . $subject . '</title></head><body>'
			. sprintf($messageBody, $code)
			. '</body></html>',
			'From: ' . $fromAddress
		);

		trigger_error('DEBUG - 1st email sent? ' . var_export($debug, true));
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

		trigger_error('DEBUG - Email hash=' . $email);

		$code = rand(1, User::CODE_MAX_VALUE);
		$adminLevel = $this->user->countAdmin() === 0 ? 1 : 0;

		trigger_error('DEBUG - AdminLevel=' . var_export($adminLevel, true));

		if ($this->user->insertUser($email, $name, 0, $code, $adminLevel))
		{ return $code; }
		elseif ($adminLevel == 1)
		{ $this->user->updateAdminLevel($adminLevel, $email); }

		$this->user->updateCode($email, $code);
		return $code;
	}

	/**
	 * Hash twice an email address.
	 * @param string $email
	 * @return string Hexadecimal hash
	 */
	static function hash($email)
	{
		return hash(User::HASH_ALGO, hash(self::HASH_ALGO, $email, true), false);
	}

	public function isAdmin()
	{
		return isset($_SESSION['AdminLevel']) && $_SESSION['AdminLevel'] > 0;
	}

	public function isLogin()
	{
		return isset($_SESSION['Name']) && isset($_SESSION['CompanyID']);
	}
}