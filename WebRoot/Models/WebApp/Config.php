<?php
namespace WebApp;

/**
 * Web App configuration.
 */
class Config {
const

/**
 * Database Source Name (PDO DSN). Use SQLite by default if this value is empty.
 * Examples:
 * MySQL socket -> 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=Wuwana'
 * MySQL TCP/IP -> 'mysql:host=localhost;port=3306;dbname=Wuwana'
 * PostgreSQL ---> 'pgsql:host=localhost;port=5432;dbname=Wuwana'
 * MSSQL Server -> 'sqlsrv:Server=localhost,1521;Database=Wuwana'
 * Oracle DB ----> 'oci:dbname=//localhost:1521/Wuwana'
 * @var string PDO driver-specific connection string
 */
DB_SOURCE = '',

/**
 * User name and password to connect to the database.
 * @var string
 */
DB_USERNAME = 'root',
DB_PASSWORD = '',

/**
 * Redirect HTTP connections to HTTPS or let the user choose its protocol.
 * @var boolean true or false
 */
FORCE_HTTPS = false,

/**
 * Session lifetime.
 * @var int Seconds
 */
SESSION_LIFETIME = 1800;  // 30 minutes

}