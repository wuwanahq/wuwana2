<?php
namespace DataAccess;
use PDO;

/**
 * Data Access Layer.
 * @author Vince <vincent.boursier@gmail.com>
 */
class DataAccess
{
	private $pdo;

	public function __construct(PDO $pdoInstance)
	{
		$this->pdo = $pdoInstance;
	}

	private function createDatabase()
	{
		$this->createTableLocation();
		$this->createTableCategory();
		$this->createTableCompany();
	}

	private function createTableLocation()
	{
		$result = $this->pdo->exec(
			'create table ' . Location::TABLE_NAME . ' ('
			. 'ID smallint primary key,'
			. 'CountryCode char(2) not null,'
			. 'Region varchar(255) not null)'
		);

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}

	private function createTableCategory()
	{
		$result = $this->pdo->exec(
			'create table ' . Category::TABLE_NAME . ' ('
			. 'ID smallint primary key,'
			. 'English varchar(255) not null,'
			. 'Spanish varchar(255) not null)'
		);

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}

	private function createTableCompany()
	{
		$result = $this->pdo->exec(
			'create table ' . Company::TABLE_NAME . ' ('
			. 'ID int primary key,'
			. 'Name varchar(255) not null,'
			. 'Logo varchar(255) not null,'
			. 'Description varchar(255) not null,'
			. 'Website varchar(255) not null,'
			. 'PhoneNumber varchar(255) not null,'
			. 'Email varchar(255) not null,'
			. 'LocationID smallint not null,'
			. 'CategoriesID varchar(255) not null)'
		);

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}

	public function recreateTableLocation()
	{
		if ($this->pdo->exec('drop table ' . Location::TABLE_NAME) === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTableLocation();
	}

	public function recreateTableCategory()
	{
		if ($this->pdo->exec('drop table ' . Category::TABLE_NAME) === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTableCategory();
	}

	public function recreateTableCompany()
	{
		if ($this->pdo->exec('drop table ' . Company::TABLE_NAME) === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }

		$this->createTableCompany();
	}

	public function insertData($filePath, $tableName, $columns)
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
				$preparedStatement->bindValue($i+1, $values[$i], $columnType);
				++$i;
			}

			$preparedStatement->execute();
		}
	}

	public function getLocations($usefulItemsOnly = false)
	{
		$sql = 'select * from ' . Location::TABLE_NAME;

		if ($usefulItemsOnly)
		{ $sql .= ' where ID in (select LocationID from Company)'; }

		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			self::createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		return Location::fetchObjects($stmt);
	}

	public function getCategories()
	{
		$sql = 'select * from ' . Category::TABLE_NAME;
		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			self::createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		return Category::fetchObjects($stmt);
	}

	public function getCompanies($categories = [], $regions = [])
	{
		$sql = '';

		if (!empty($categories[0]))
		{
			$filter = [];

			foreach ($categories as $category)
			{ $filter[] = "CategoriesID like '%;$category;%'"; }

			$sql = ' where (' . implode(' or ', $filter) . ')';
		}

		if (!empty($regions[0]))
		{
			if ($sql == '')
			{ $sql = ' where LocationID in (' . implode(',', $regions) . ')'; }
			else
			{ $sql .= ' and LocationID in (' . implode(',', $regions) . ')'; }
		}

		$sql = 'select * from ' . Company::TABLE_NAME . $sql;

		$stmt = $this->pdo->query($sql);

		if ($stmt == false)
		{
			self::createDatabase();
			$stmt = $this->pdo->query($sql);
		}

		return Company::fetchObjects($stmt);
	}
}