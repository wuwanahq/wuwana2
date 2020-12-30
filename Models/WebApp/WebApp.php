<?php
namespace WebApp;

/**
 * WebApp's common functions.
 * @author Vince <vincent.boursier@gmail.com>
 */
class WebApp
{
	const VERSION = '2.1.0';

	/**
	 * Min memory usage to store it in PHP logs.
	 * @var int Bytes
	 */
	const MEMORY_LIMIT = 1048576;  // 1 MB

	/**
	 * Return the selected language code by sub-domain, domain, user device language or the default language.
	 * @return string 2 characters (ISO 639-1)
	 */
	static function getLanguageCode()
	{
		$hostname = self::getHostname(true);

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

		if (Config::FORCE_HTTPS || filter_input(INPUT_SERVER,'HTTPS') == 'on')
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

		if (Config::FORCE_HTTPS || filter_input(INPUT_SERVER,'HTTPS') == 'on')
		{ return 'https://' . $host; }

		return 'http://' . $host;
	}
}