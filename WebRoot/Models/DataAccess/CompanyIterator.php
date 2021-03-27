<?php
namespace DataAccess;
use Iterator;
use PDO;
use PDOStatement;

/**
 * Companies iterator.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class CompanyIterator implements Iterator
{
	private $query;
	private $row;
	private $languageCode = 'EN';
	private $languageIndex = 0;

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
		if (isset($this->row))
		{
			$this->query->closeCursor();
			$this->query->execute();
		}

		$this->row = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function next()
	{
		$this->row = $this->query->fetch(PDO::FETCH_ASSOC);
	}

	public function valid()
	{
		return $this->row != false;
	}

	public function current()
	{
		$company = new CompanyData();
		$company->name = $this->row['CompanyName'];

		if (isset($this->row['CompanyLogoURL']))
		{ $company->logo = $this->row['CompanyLogoURL']; }

		if (isset($this->row['CompanyLastUpdate']))
		{ $company->lastUpdate = $this->row['CompanyLastUpdate']; }

		if (isset($this->row['CompanyPostalCode']))
		{ $company->postalCode = $this->row['CompanyPostalCode']; }

		if (isset($this->row['CompanyDescription']))
		{ $company->description = $this->row['CompanyDescription']; }

		if (isset($this->row[$this->languageCode]))
		{ $company->region = $this->row[$this->languageCode]; }

		if (!empty($this->row['TagName1']))
		{ $company->tags[] = explode(DataAccess::VALUES_DELIMITER, $this->row['TagName1'])[$this->languageIndex]; }

		if (!empty($this->row['TagName2']))
		{ $company->tags[] = explode(DataAccess::VALUES_DELIMITER, $this->row['TagName2'])[$this->languageIndex]; }

		if (!empty($this->row['CompanyOtherTags']))
		{
			foreach (explode(DataAccess::VALUES_DELIMITER, $this->row['CompanyOtherTags']) as $tag)
			{ $company->tags[] = $tag; }
		}

		return $company;
	}

	public function key()
	{
		return $this->row['CompanyPermaLink'];
	}
}