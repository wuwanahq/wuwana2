<?php
namespace DataAccess;

/**
 * Data access layer for stored image links.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Image
{
	private function createTable()
	{
		$result = $this->pdo->exec(
			'create table Image ('
			. 'SocialMediaID int not null,'
			. 'URL varchar(255) not null)');

		if ($result === false)
		{ trigger_error(implode(' ', $this->pdo->errorInfo()), E_USER_ERROR); }
	}
}