<?php
namespace DataAccess;

/**
 * Data Access Object representing a user.
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class UserObject
{
	public $email;
	public $name;
	public $company;
	public $adminLevel;
	public $accessCode;
	public $lastLogin;
}