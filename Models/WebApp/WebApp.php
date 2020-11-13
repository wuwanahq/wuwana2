<?php
namespace WebApp;
use PDO;

/**
 * WebApp's common functions.
 * @author Vince <vincent.boursier@gmail.com>
 */
class WebApp
{
	/**
	 * Model factory for the database access.
	 * @todo Data Access Object
	 * @return PDO
	 */
	static function getDatabase()
	{
		$dbSource = Config::DB_SOURCE;

		if (empty($dbSource))
		{ $dbSource = 'sqlite:SQLite.db'; }

		return new PDO($dbSource, Config::DB_USERNAME, Config::DB_PASSWORD, [
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_STRINGIFY_FETCHES => false
		]);
	}

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
}