<?php

namespace App\Models;

class User extends Database
{
	public function __construct()
	{
		// Autheticate the request
		parent::__construct();
	}

	/**
	 * Get user info
	 */
	public function get_info()
	{
		echo json_encode(
			[
				'success' => true,
				'email' => $this->get_email(),
			]
		);
		http_response_code(200);
	}

	/**
	 * Get user email
	 * @return string
	 */
	private function get_email()
	{
		// Run query
		$query = 'SELECT email FROM users WHERE token = :token';
		$statement = self::$connection->prepare($query);
		$response = $statement->execute([':token' => $this->token]);
		$statement = $statement->fetch(\PDO::FETCH_ASSOC);

		if (empty($statement) || !$response) {
			echo json_encode(['success' => false, 'message' => 'not authorized']);
			http_response_code(401);
			exit();
		}

		return $statement['email'];
	}

	/**
	 * Create a new user
	 * @param  string $email    Email
	 * @param  string $password Password
	 * @return bool       		True when user was created, false otherwise
	 */
	public static function create_new($email = '', $password = '')
	{

		// Validate email and password
		if (!self::validate_email_and_password($email, $password)) exit();

		// Hash password
		$password = password_hash($password);

		// Connect to DB
		self::connect();

		// Run query
		$query = 'INSERT INTO users (email, password) VALUES (:email, :password)';
		$statement = self::$connection->prepare($query);
		$response = $statement->execute([':email' => $email, ':password' => $password]);

		// Response
		if ($statement->rowCount() > 0 && $response) {
			echo json_encode(['success' => true, 'message' => 'user created']);
			http_response_code(201);
			return true;
		} else {
			echo json_encode(['success' => false, 'message' => 'user was not created']);
			http_response_code(500);
			return false;
		}
	}

	/**
	 * Get user log in token against email and password
	 * @param  string $email    
	 * @param  string $password 
	 * @return none
	 */
	public static function signin($email = '', $password = '')
	{

		// Validate email and password
		if (!self::validate_email_and_password($email, $password)) exit();

		// Authenticate user
		$user_id = self::authenticate($email, $password);

		// Response
		if ($user_id) {

			// Generate token
			$token = new Token($user_id);
			$token = $token->generate();

			echo json_encode(['success' => true, 'token' => $token]);
			http_response_code(201);
		} else {
			echo json_encode(['success' => false, 'message' => "can't sign in"]);
			http_response_code(400);
		}
	}

	/**
	 * Authenticate user credentials
	 * @param  string $email    
	 * @param  string $password 
	 * @return integer User ID
	 */
	private static function authenticate(string $email = '', string $password = '')
	{
		// Connect to DB
		self::connect();

		// Validate email and password
		if (!self::validate_email_and_password($email, $password)) exit();

		// Hash password
		$password = password_hash($password);

		// Select from table
		$query = 'SELECT UID FROM users WHERE email = :email';
		$statement = self::$connection->prepare($query);
		$response = $statement->execute([':email' => $email]);
		$statement = $statement->fetch(\PDO::FETCH_ASSOC);

		if (empty($statement) || !$response || $statement['password'] != $password) {
			echo json_encode(['success' => false, 'message' => 'not authorized']);
			http_response_code(401);
			exit();
		}

		return $statement['UID'];
	}

	/**
	 * Check if argument(s) is considered empty
	 * @param  any $args
	 * @return bool
	 */
	private static function empty(...$args)
	{

		foreach ($args as $arg) {
			if (empty($arg)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Validate email and password
	 * @param  string $email    
	 * @param  string $password 
	 * @return boolean           
	 */
	private static function validate_email_and_password($email, $password)
	{

		if (empty($email)) {

			echo json_encode(
				[
					'success' => false,
					'message' => "'email' cannot be empty"
				]
			);

			http_response_code(400);

			return false;
		} elseif (!is_string($email)) {

			echo json_encode(
				[
					'success' => false,
					'message' => "'email' must be a string"
				]
			);

			http_response_code(400);

			return false;
		}

		if (empty($password)) {

			echo json_encode(
				[
					'success' => false,
					'message' => "'password' cannot be empty"
				]
			);

			http_response_code(400);

			return false;
		} elseif (!is_string($password)) {

			echo json_encode(
				[
					'success' => false,
					'message' => "'password' must be a string"
				]
			);

			http_response_code(400);

			return false;
		}

		return true;
	}
}
