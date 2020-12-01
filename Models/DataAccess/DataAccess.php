<?php
namespace DataAccess;
use PDO;
use Scraper\CompanyData;

/**
 * Abstract interface to the database.
 * @author Vince <vincent.boursier@gmail.com>
 */
abstract class DataAccess
{
	protected $pdo;

	public function __construct(PDO $pdo = null)
	{
		if ($pdo instanceof PDO)
		{
			$this->pdo = $pdo;
			date_default_timezone_set('UTC');
		}
	}

	abstract static function getTableSchema();

	protected function createDatabase()
	{
		$this->createTable(Category::getTableSchema());

		$this->createTable(User::getTableSchema());
		$this->createTable(Tag::getTableSchema());

		$this->createTable(Location::getTableSchema());
		$this->createTable(Company::getTableSchema());
		$this->createTable(SocialMedia::getTableSchema());
		$this->createTable(Image::getTableSchema());

		//TODO: insert fake companies to test
	}

	private function createTable($sql)
	{
		$tinyint = 'smallint';

		switch ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
		{
			case 'oci': $tinyint = 'number(3)'; break;
			case 'mysql': $tinyint = 'tinyint'; break;
		}

		$this->pdo->exec(str_replace('tinyint', $tinyint, $sql));
	}

	protected function insertData($filePath, $tableName, $columns)
	{
		$preparedStatement = $this->pdo->prepare(
			'insert into ' . $tableName . ' ('
			. implode(',', array_keys($columns)) . ') values (?' . str_repeat(',?', count($columns) -1) . ')'
		);

		$file = fopen($filePath, 'r');
		fgets($file);  // ignore the first line (column header)

		while ($line = fgets($file))
		{
			$values = explode("\t", $line);
			$i = 0;

			foreach ($columns as $columnType)
			{
				$preparedStatement->bindValue($i+1, trim($values[$i]), $columnType);
				++$i;
			}

			$preparedStatement->execute();
		}
	}
}