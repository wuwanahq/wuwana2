<?php
namespace DataAccess;
use Iterator;
use PDO;
use PDOStatement;

/**
 * Companies iterator.
 * @property-read int $counter
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class CompanyIterator implements Iterator
{
	private $query;
	private $row;
	private $languageCode = 'EN';
	private $languageIndex = 0;
	private $counter = 0;

	public function __get($property)
	{
		if ($property == 'counter')
		{ return $this->counter; }

		trigger_error('Undefined property ' . $property, E_USER_ERROR);
	}

	public function __construct(PDOStatement $query)
	{
		$this->query = $query;
	}

	public function setTagsLanguage($language)
	{
		$this->languageCode = strtoupper($language);
		$this->languageIndex = Tag::getLanguageIndex($language);
	}

	public function rewind()
	{
		if (isset($this->row) && $this->row === false)
		{
			$this->query->closeCursor();
			$this->query->execute();
			$this->counter = 0;
		}

		$this->row = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function next()
	{
		$this->row = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function valid()
	{
		if ($this->row == false)
		{ return false; }

		++$this->counter;
		return true;
	}

	public function current()
	{
		$company = new CompanyData();
		$company->permalink = $this->row['CompanyPermaLink'];
		$company->name = $this->row['CompanyName'];
		$company->logo = $this->row['CompanyLogoURL'];
		$company->lastUpdate = $this->row['CompanyLastUpdate'];
		//$company->description = $this->row['Description'];
		//$company->website = $this->row['Website'];
		//$company->phone = $this->row['PhonePrefix'] . str_pad($this->row['PhoneNumber'], 9, '0', STR_PAD_LEFT);
		//$company->email = $this->row['Email'];
		$company->postalCode = $this->row['CompanyPostalCode'];
		$company->region = isset($this->row[$this->languageCode]) ? $this->row[$this->languageCode] : $this->row['EN'];

		if ($this->row['TagName1'] != '')
		{
			$company->tags[] =
				explode(DataAccess::VALUES_DELIMITER, $this->row['TagName1'])[$this->languageIndex];
		}

		if ($this->row['TagName2'] != '')
		{
			$company->tags[] =
				explode(DataAccess::VALUES_DELIMITER, $this->row['TagName2'])[$this->languageIndex];
		}

		return $company;
	}

	public function key()
	{
		return $this->row['CompanyPermaLink'];
	}

	public function forward($offset = -1)
	{
		while ($offset-- != 0)
		{
			$this->row = $this->query->fetch(PDO::FETCH_ASSOC);

			if ($this->row == false)
			{ break; }

			++$this->counter;
		}
	}
}