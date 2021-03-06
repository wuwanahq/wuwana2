<?php
namespace WebApp;

/**
 * Tools to simplify the usage of the function crypt.
 * @see https://www.php.net/manual/en/function.crypt.php
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class Crypt
{
	/**
	 * Blowfish salt used by the crypt function.
	 * cost=10 take ~0.06 sec
	 * cost=11 take ~0.2 sec
	 * cost=12 take ~0.3 sec
	 * cost=13 take ~0.5 sec
	 * cost=14 take ~0.9 sec
	 * salt: 21 characters (./0-9A-Za-z)
	 * @var string 29 characters: "$2y$" + cost + "$" + salt + "."
	 */
	const SALT_BLOWFISH = '$2y$12$////////Wuwana///////.';

	/**
	 * Extended DES salt used by the crypt function.
	 * cost="...0" take ~0.1 sec
	 * cost="...1" take ~0.2 sec
	 * cost="...3" take ~0.3 sec
	 * cost="...7" take ~0.5 sec
	 * cost="...9" take ~0.6 sec
	 * salt: 4 characters (./0-9A-Za-z)
	 * @var string 9 characters: "_" + cost + salt
	 */
	const SALT_EXT_DES = '_Wu.3wana';

	/**
	 * One-way hash function used to identify a string with a low probability of collision.
	 * @param string $userString Plain text (don't use binary string!)
	 * @return string Always 31 characters
	 */
	static function hashUniqueID($userString)
	{
		return substr(crypt($userString, self::SALT_BLOWFISH), 29);
	}

	/**
	 * Verifies that a string matches a unique hash.
	 * @param string $userString
	 * @param string $expectedHash
	 * @return bool
	 */
	static function verifyUniqueID($userString, $expectedHash)
	{
		return hash_equals(
			self::SALT_BLOWFISH . $expectedHash,
			crypt($userString, self::SALT_BLOWFISH)
		);
	}

	/**
	 * One-way hash function used to identify a string with a HIGH probability of collision.
	 * @param string $userString Plain text (don't use binary string!)
	 * @return string always 11 characters
	 */
	static function hashID($userString)
	{
		return substr(crypt($userString, self::SALT_EXT_DES), 9);
	}
}