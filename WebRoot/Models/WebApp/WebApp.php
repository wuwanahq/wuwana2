<?php
namespace WebApp;
use PDO;

/**
 * WebApp's common functions.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class WebApp
{
	/**
	 * Minimum memory usage noticeable in PHP logs.
	 * @var int Bytes
	 */
	const MEMORY_LIMIT = 1572864;  // 1.5 MB

	const DEFAULT_IMAGE = '/static/logo/square%u.svg';
	const NB_DEFAULT_IMAGE = 8;
	const NB_INSTAGRAM_PICTURE = 6;

	/**
	 * Return the selected language according to the sub-domain, user device language or the default language.
	 * @return \WebApp\Language
	 */
	static function getLanguage()
	{
		$hostname = self::getHostname(true);

		if (strlen($hostname) > 6 && $hostname[2] == '.')
		{
			$subdomain = $hostname[0] . $hostname[1];

			if (isset(Language::CODES[$subdomain]))
			{ return new Language($subdomain); }
		}

		if (filter_has_var(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE'))
		{
			foreach (explode(',', filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE')) as $language)
			{
				$code = substr($language, 0, 2);

				if (isset(Language::CODES[$code]))
				{ return new Language($code); }
			}
		}

		return new Language('en');
	}

	static function getURL()
	{
		$url = filter_input(INPUT_SERVER, 'REQUEST_URI');
		$position = strpos($url, '?');

		if ($position > 0)
		{ $url = substr($url, 0, $position); }

		if ($url == '/' || substr($url, -1) != '/')
		{ return $url; }

		return substr($url, 0, -1);
	}

	static function getPermalink()
	{
		$host = self::getHostname();
		$requestURL = filter_input(INPUT_SERVER, 'REQUEST_URI');

		if ($requestURL == '/company')
		{ $requestURL = '/...'; }

		return $host . $requestURL;
	}

	static function getHostname($excludeProtocol = false)
	{
		$host = filter_input(INPUT_SERVER, 'HTTP_HOST');

		if (strlen($host) < 5)
		{ return filter_input(INPUT_SERVER, 'SERVER_NAME'); }

		if ($excludeProtocol)
		{ return $host; }

		if (filter_input(INPUT_SERVER,'HTTPS') == 'on')
		{ return 'https://' . $host; }

		return 'http://' . $host;
	}

	static function changeSubdomain($subdomain)
	{
		$host = filter_input(INPUT_SERVER, 'HTTP_HOST');

		if (strlen($host) < 5)
		{ $host = filter_input(INPUT_SERVER, 'SERVER_NAME'); }

		if ($host[2] == '.')  // Example: es.wuwana.com
		{
			$host[0] = $subdomain[0];
			$host[1] = $subdomain[1];
		}
		elseif ($host[3] == '.')  // Example: www.wuwana.com
		{
			$host = $subdomain . substr($host, 3);
		}
		else  // Example: wuwana.com
		{
			$host = $subdomain . '.' . $host;
		}

		$host .= filter_input(INPUT_SERVER, 'REQUEST_URI');

		if (filter_input(INPUT_SERVER,'HTTPS') == 'on')
		{ return 'https://' . $host; }

		return 'http://' . $host;
	}

	static function isSecure()
	{
		return (
			(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443
			|| (
				(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
				|| (!empty($_SERVER['HTTP_X_FORWARDED_SSL'])   && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
			)
		);
	}

	static function getPdoInstance()
	{
		static $pdo = null;

		if ($pdo instanceof PDO)
		{ return $pdo; }

		$dbSource = Config::DB_SOURCE;

		if (empty($dbSource))
		{ $dbSource = 'sqlite:SQLite.db'; }

		$pdo = new PDO(
			$dbSource, Config::DB_USERNAME, Config::DB_PASSWORD, [
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_STRINGIFY_FETCHES => false]);

		return $pdo;
	}

	static function getCompanyInfo($permalink, $tagsLanguage)
	{
		if ($permalink == '' || $permalink[0] == '?' || strpos($permalink, '.') !== false)
		{ return null; }

		$company = (new \DataAccess\Company())->selectPermalink($permalink, $tagsLanguage);

		if ($company == null)
		{ return null; }

		if ($company->logo == '')
		{ $company->logo = sprintf(self::DEFAULT_IMAGE, rand(1, self::NB_DEFAULT_IMAGE)); }

		if (isset($company->instagram))
		{
			for ($i=0; $i < self::NB_INSTAGRAM_PICTURE; ++$i)
			{
				if (empty($company->instagram->pictures[$i]))
				{ $company->instagram->pictures[$i] = sprintf(self::DEFAULT_IMAGE, rand(1, self::NB_DEFAULT_IMAGE)); }
			}
		}

		return $company;
	}
}