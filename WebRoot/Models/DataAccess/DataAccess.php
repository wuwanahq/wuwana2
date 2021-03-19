<?php
namespace DataAccess;
use PDO;
use PDOStatement;
use Exception;
use WebApp\WebApp;

/**
 * Abstract interface to the database.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
abstract class DataAccess
{
	const VALUES_DELIMITER = ';';
	const INT_MIN = -2147483648;

	protected $pdo;

	public function __construct()
	{
		$this->pdo = WebApp::getPdoInstance();
		date_default_timezone_set('UTC');
	}

	abstract static function getTableSchema();
	abstract public function insertData($filePath);

	private function createDatabase()
	{
		// Create tables
		$this->pdo->exec(User::getTableSchema());
		$this->pdo->exec(Tag::getTableSchema());
		$this->pdo->exec(SocialMedia::getTableSchema());
		$this->pdo->exec(Image::getTableSchema());
		$this->pdo->exec(Region::getTableSchema());
		$this->pdo->exec(Province::getTableSchema());
		$this->pdo->exec(PostalCode::getTableSchema());
		$this->pdo->exec(Location::getTableSchema());
		$this->pdo->exec(Company::getTableSchema());

		// Default tables data
		(new Location($this->pdo))->insertData(__DIR__ . '/default data/location.tsv');
		(new Tag($this->pdo))->insertData(__DIR__ . '/default data/tag.tsv');
		(new SocialMedia($this->pdo))->insertData( __DIR__ . '/default data/socialmedia.tsv');
		(new User($this->pdo))->insertData(__DIR__ . '/default data/user.tsv');
		(new Region($this->pdo))->insertData(__DIR__ . '/default data/region.tsv');
        (new Province($this->pdo))->insertData(__DIR__ . '/default data/province.tsv');
        (new PostalCode($this->pdo))->insertData(__DIR__ . '/default data/postalcode.tsv');
        (new Company($this->pdo))->insertData(__DIR__ . '/default data/company.tsv');

		// For developer environments create user dev@wuwana.com with the access code "1234" to easily test as Admin
		if (php_sapi_name() == 'cli-server')
		{ (new User())->insertUser(\WebApp\Crypt::hashUniqueID('dev@wuwana.com'), 'd…@wuwana.com', 0, 1234, 1); }
	}

	/**
	 * Prepare or directly execute an SQL statement and initialize database's tables if necessary.
	 * @param string $sql
	 * @param bool $isPreparedStatement
	 * @return PDOStatement
	 * @throws Exception
	 */
	protected function tryQuery($sql, $isPreparedStatement = false)
	{
		$query = $isPreparedStatement ? $this->pdo->prepare($sql) : $this->pdo->query($sql);

		if ($query instanceof PDOStatement)
		{ return $query; }

		$this->createDatabase();
		$query = $isPreparedStatement ? $this->pdo->prepare($sql) : $this->pdo->query($sql);

		if ($query instanceof PDOStatement)
		{ return $query; }

		$info = $this->pdo->errorInfo();
		throw new Exception($info[0] . ' ' . $info[2], $info[1]);
	}

	protected function importData($filePath, $tableName, $columns)
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
				$value = trim($values[$i]);

				if ($columnType != PDO::PARAM_STR && $value == '')
				{ $preparedStatement->bindValue($i+1, null, $columnType); }
				elseif ($columnType == PDO::PARAM_LOB)
				{ $preparedStatement->bindValue($i+1, hex2bin($value), $columnType); }
				else
				{ $preparedStatement->bindValue($i+1, $value, $columnType); }

				++$i;
			}

			$preparedStatement->execute();
		}

		fclose($file);
	}

	protected function exportTable($name)
	{
		$query = $this->pdo->query('select * from ' . $name);
		$line = '';

		foreach ($query->fetch(PDO::FETCH_ASSOC) as $columnName => $columnValue)
		{
			if ($line != '')
			{
				echo "\t";
				$line .= "\t";
			}

			echo $columnName;
			$line .= $columnValue;
		}

		echo "\n", $line, "\n";

		while ($columns = $query->fetch(PDO::FETCH_ASSOC))
		{
			$lineIsEmpty = true;

			foreach ($columns as $column)
			{
				if ($lineIsEmpty)
				{ $lineIsEmpty = false; }
				else
				{ echo "\t"; }

				echo $column;
			}

			echo "\n";
		}
	}
}