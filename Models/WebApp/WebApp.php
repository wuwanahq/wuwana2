<?php
namespace WebApp;
use DataAccess;
use PDO;

/**
 * WebApp's common functions.
 * @author Vince <vincent.boursier@gmail.com>
 */
class WebApp
{
	/**
	 * Return the selected language code by sub-domain, domain, user device language or the default language.
	 * @return string 2 characters (ISO 639-1)
	 */
	static function getLanguageCode()
	{
		$hostname = self::getHostname();

		if (strlen($hostname) > 3)
		{
			$code = substr($hostname, 0, 3);  // Sub-domain

			if ($code[2] == '.')
			{
				$code = $code[0] . $code[1];

				if (isset(Config::LANGUAGES[$code]))
				{ return $code; }
			}

			$code = substr($hostname, -3);  // Domain

			if ($code[0] == '.')
			{
				$code = $code[1] . $code[2];

				if (isset(Config::LANGUAGES[$code]))
				{ return $code; }
			}
		}

		if (filter_has_var(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE'))
		{
			foreach (explode(',', filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE')) as $language)
			{
				$code = substr($language, 0, 2);

				if (isset(Config::LANGUAGES[$code]))
				{ return $code; }
			}
		}

		foreach (Config::LANGUAGES as $code => $language)
		{ return $code; }
	}

	static function getPermalink()
	{
		$host = self::getHostname();
		$requestURL = filter_input(INPUT_SERVER, 'REQUEST_URI');

		if ($requestURL == '/company')
		{ $requestURL = '/...'; }

		return $host . $requestURL;
	}

	static function getHostname()
	{
		$host = filter_input(INPUT_SERVER, 'HTTP_HOST');

		if (strlen($host) < 5)
		{ return filter_input(INPUT_SERVER, 'SERVER_NAME'); }

		return $host;
	}
}