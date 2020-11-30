<?php
namespace WebApp;
use DataAccess;
use PDO;

/**
 * Data Access Object factory.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Data
{
	const DEFAULT_IMAGE = '/static/logo/square%u.svg';
	const NB_IMAGE = 8;

	private static $pdoInstance = null;

	private static function getPdoInstance()
	{
		if (self::$pdoInstance instanceof PDO)
		{ return self::$pdoInstance; }

		$dbSource = Config::DB_SOURCE;

		if (empty($dbSource))
		{ $dbSource = 'sqlite:SQLite.db'; }

		self::$pdoInstance = new PDO(
			$dbSource, Config::DB_USERNAME, Config::DB_PASSWORD, [
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_STRINGIFY_FETCHES => false]);

		return self::$pdoInstance;
	}

	public static function getCategory()
	{
		return new DataAccess\Category(self::getPdoInstance());
	}

	public static function getCompany()
	{
		return new DataAccess\Company(self::getPdoInstance());
	}

	public static function getCompanyInfo($permalink)
	{
		$company = WebApp\Data::getCompany()->selectPermalink($permalink);

		if ($company == null)
		{ return null; }

		if ($company->logo == '')
		{ $company->logo = sprintf(self::DEFAULT_IMAGE, rand(1, self::NB_IMAGE)); }

		foreach ($company->socialMedias as $socialMedia)
		{
			for ($i=0; $i < 6; ++$i)
			{
				if (empty($socialMedia->pictures[$i]))
				{ $socialMedia->pictures[$i] = sprintf(self::DEFAULT_IMAGE, rand(1, self::NB_IMAGE)); }
			}
		}

		return $company;
	}

	public static function getLocation()
	{
		return new DataAccess\Location(self::getPdoInstance());
	}

	public static function getUser()
	{
		return new DataAccess\User(self::getPdoInstance());
	}

	public static function getTagIterator()
	{
		return new DataAccess\Tag(self::getPdoInstance());
	}
}