<?php
namespace DataAccess;
use PDO;

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