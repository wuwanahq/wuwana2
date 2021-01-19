<?php
namespace WebApp;

/**
 * WebApp's common functions.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class WebApp
{
	/**
	 * Minimum memory usage noticeable in PHP logs.
	 * @var int Bytes
	 */
	const MEMORY_LIMIT = 921600;  // 900 KB

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