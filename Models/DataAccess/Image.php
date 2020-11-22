<?php
namespace DataAccess;

/**
 * Data access layer for stored image links.
 * @author Vince <vincent.boursier@gmail.com>
 */
class Image
{
	static function getTableSchema()
	{
		return 'create table Image ('
			. 'SocialMediaID int not null,'
			. 'URL varchar(255) not null)';
	}
}