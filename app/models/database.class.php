<?php
namespace App\Models;

/**
 * 
 */
class Database {

	private static $hostname = 'localhost';
	private static $dbname	 = 'mvc';
	private static $username = 'root';
	private static $password = 'root';

	public static function connect() {
		try {
			$connection = new \PDO('mysql:host='.self::$hostname.';dbname='.self::$dbname, self::$username, self::$password);
		} catch (Exception $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$statement = $connection->query('SELECT * FROM Persons');

		print_r($statement->fetch());
	}

}