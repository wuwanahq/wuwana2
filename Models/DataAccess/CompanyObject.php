<?php
namespace DataAccess;

/**
 * Data Access Object representing a company.
 * @author Vince <vincent.boursier@gmail.com>
 */
class CompanyObject
{
	public $permalink;
	public $name;
	public $logo = '';
	public $description = '';
	public $website = '';
	public $email = '';
	public $phone = '0000000000';
	public $address = '';
	public $region = 0;
	public $visibleTags = [];
	public $otherTags;
	public $instagram;
	public $facebook;
	public $lastUpdate;
}