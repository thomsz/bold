<?php

namespace App\Models;

class Database extends Auth
{
	/**
	 * DB connection details
	 * @var string
	 */
	private static $hostname = 'localhost';
	private static $dbname	 = 'mvc';
	private static $username = 'root';
	private static $password = 'root';

	/**
	 * Connection object
	 * @var PDO object
	 */
	protected static $connection;

	protected function __construct()
	{	
		// Authenticate the request
		$this->try(self::connect());
	}

	/**
	 * Connect to database
	 * @return object PDO
	 */
	public static function connect()
	{
		try {
			$connection = new \PDO('mysql:host=' . self::$hostname . ';dbname=' . self::$dbname, self::$username, self::$password);
		} catch (\Exception $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		return self::$connection = $connection;
	}
}
