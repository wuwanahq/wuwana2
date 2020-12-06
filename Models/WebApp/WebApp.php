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
	 * IETF codes (ISO 639).
	 * @return string 2 characters
	 */
	static function getLanguageCode()
	{
		if (substr(filter_input(INPUT_SERVER, 'SERVER_NAME'), -2)  == 'es' || filter_input(INPUT_GET, 'lang') == 'es')
		{ return 'es'; }

		return 'en';
	}

	static function getPermalink()
	{
		$host = filter_input(INPUT_SERVER, 'HTTP_HOST');

		if (strlen($host) < 5)
		{ $host = filter_input(INPUT_SERVER, 'SERVER_NAME'); }

		return $host . filter_input(INPUT_SERVER, 'REQUEST_URI');
	}
}