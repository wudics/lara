<?php

namespace Core;

use App\Config;
use Medoo\Medoo;

/**
* Base Model
*
* PHP version 5.6
*/
abstract class Model
{
	protected static $medoo;

	/* Get database connection from Medoo with Config params. */
	protected static function getDbHelper()
	{
		if (self::$medoo == null) {
			self::$medoo = new Medoo([
				'database_type' => Config::DB_HELPER_TYPE,
				'database_name' => Config::DB_HELPER_DBNAME,
				'server' => Config::DB_HELPER_HOST,
				'username' => Config::DB_HELPER_USERNAME,
				'password' => Config::DB_HELPER_PASSWD,
				'charset' => Config::DB_HELPER_CHARSET,
				'collation' => Config::DB_HELPER_COLLATION,
				'port' => Config::DB_HELPER_PORT
			]);
		}

		return self::$medoo;
	}
}
