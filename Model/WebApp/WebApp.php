<?php
namespace WebApp;
use PDO;

/**
 * WebApp's common functions.
 * @author Vince <vincent.boursier@gmail.com>
 */
class WebApp
{
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

	static function getLanguageCode()
	{
		if (substr(filter_input(INPUT_SERVER, 'SERVER_NAME'), -2)  == 'es')
		{ return 'es'; }

		return 'en';
	}
}