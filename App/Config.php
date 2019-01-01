<?php

namespace App;

/**
* Application configuration
*
* PHP version 5.6
*/
class Config
{
	/**
	* Database connection params
	*/
	const DB_HELPER_TYPE = 'mysql';
	const DB_HELPER_HOST = 'localhost';
	const DB_HELPER_PORT = '3306';
	const DB_HELPER_USERNAME = 'root';
	const DB_HELPER_PASSWD = '12345678';
	const DB_HELPER_DBNAME = 'lara';
	const DB_HELPER_CHARSET = 'utf8';
	const DB_HELPER_COLLATION = 'utf8_general_ci';
	
	/**
	* Show or hide error messages on screen
	* @var boolean
	*/
	const SHOW_ERRORS = true;

	const LARA_PAY_TOKEN = 'hellopay';
}
