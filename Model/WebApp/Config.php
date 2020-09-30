<?php
namespace WebApp;

/**
 * Web App configuration.
 */
class Config {
const

/**
 * WhatsApp link format used. There is 2 "%s" parameters in this string.
 * The 1st parameter is replaced by the phone number.
 * The 2nd parameter is replaced by the company name.
 * @var string WhatsApp Link format
 */
WHATSAPP_URL =
	'https://wa.me/%s?text=Hola %s, os he encontrado a través de wuwana.com y me gustaría saber más sobre vosotros.',

/**
 * Database Source Name (PDO DSN). Use SQLite by default if this value is empty.
 * Examples:
 * MySQL ------> 'mysql:host=localhost;port=3306;dbname=Wuwana'
 * PostgreSQL -> 'pgsql:host=localhost;port=5432;dbname=Wuwana'
 * SQL Server -> 'sqlsrv:Server=localhost,1521;Database=Wuwana'
 * Oracle DB --> 'oci:dbname=//localhost:1521/Wuwana'
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
 * Password to protect the admin-wuwana page.
 * @link http://wuwana.com/admin-wuwana
 * @var string
 */
ADMIN_PASSWORD = '';

}