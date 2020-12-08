<?php
namespace DataAccess;

/**
 * Key-Value storage.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Dictionary
{
	static function getTableSchema()
	{
		return 'create table Dictionary (Key tinyint primary key, Value varchar(255) not null)';
	}
}