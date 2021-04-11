<?php
namespace WebApp;

/**
 * Web App configuration.
 */
class Config {
const

	/**
	 * PDO driver used to connect the database.
	 * @var string mysql, sqlite, pgsql, sqlsrv, oci (Oracle) or odbc
	 */
	DB_DRIVER = 'sqlite',

	/**
	 * Server hosting the database system.
	 * You can use this parameter to specify a UNIX socket with MySQL.
	 * Example: unix_socket=/var/run/mysqld/mysqld.sock
	 * @var string IP address or machine name
	 */
	DB_HOST = 'localhost',

	/**
	 * Port number to connect to the database system.
	 * @var int Number between 1 and 65535 or 0 to use the default port
	 */
	DB_PORT = 0,

	/**
	 * Name of the database where tables are stored.
	 * @var string Database name (file path with SQLite or source name with ODBC)
	 */
	DB_NAME = 'Wuwana.db',

	/**
	 * User name and password to access the database (ignored by SQLite)
	 * @var string
	 */
	DB_USERNAME = 'root',
	DB_PASSWORD = '';

}