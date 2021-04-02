<?php
namespace WebApp;
use DataAccess\User;
use DataAccess\UserData;

/**
 * User session.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class UserSession
{
	private $dao;
	private $sessionLifetime;

	public function __construct(User $dataAccessObject, $sessionLifetime)
	{
		$this->dao = $dataAccessObject;
		$this->sessionLifetime = $sessionLifetime;

		if (filter_has_var(INPUT_POST, 'email') && filter_has_var(INPUT_POST, 'code'))
		{
			$this->login(
				Crypt::hashUniqueID(strtolower(trim(filter_input(INPUT_POST, 'email')))),
				trim(filter_input(INPUT_POST, 'code'))
			);
		}
		elseif (filter_has_var(INPUT_COOKIE, session_name()))
		{
			session_start([
				'cookie_lifetime' => $this->sessionLifetime,
				'gc_maxlifetime' => $this->sessionLifetime,
				'read_and_close' => true
			]);
		}
	}

	private function login($email, $code)
	{
		$user = $this->dao->selectEmail($email);

		if ($user instanceof UserData && $user->accessCode == $code)
		{
			session_start([
				'cookie_lifetime' => $this->sessionLifetime,
				'gc_maxlifetime' => $this->sessionLifetime
			]);

			$_SESSION['Name'] = $user->name;
			$_SESSION['CompanyID'] = $user->company;
			$_SESSION['AdminLevel'] = $user->adminLevel;
			session_write_close();

			$this->dao->updateLastLoginDate($email);
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
		$email = Crypt::hashUniqueID($email);

		trigger_error('DEBUG - Email hash=' . $email);

		$code = rand(1, User::CODE_MAX_VALUE);
		$adminLevel = $this->dao->countAdmin() === 0 ? 1 : 0;

		trigger_error('DEBUG - AdminLevel=' . var_export($adminLevel, true));

		if ($this->dao->insertUser($email, $name, 0, $code, $adminLevel))
		{ return $code; }
		elseif ($adminLevel == 1)
		{ $this->dao->updateAdminLevel($adminLevel, $email); }

		$this->dao->updateCode($email, $code);
		return $code;
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