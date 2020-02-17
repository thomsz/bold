<?php

namespace App\Models;

/**
 * User token
 */
class Token extends Database
{
	/**
	 * User ID
	 * @var integer
	 */
	private $user_id;

	public function __construct(int $user_id)
	{
		// Connect to DB
		self::connect();

		$this->user_id = $user_id;
	}

	/**
	 * Generate a login token
	 * @return string|false The token on success, otherwise false
	 */
	public function generate()
	{

		// Generate token
		$token = uniqid();

		// Insert token to Users DB table
		$query = 'UPDATE users SET token = :token WHERE UID = :user_id';
		$statement = self::$connection->prepare($query);
		$response = $statement->execute([':token' => $token, ':user_id' => $this->user_id]);

		// Response
		if ($statement->rowCount() > 0 && $response) {
			return $token;
		} else {
			echo json_encode(['success' => false, 'message' => 'failed to generate token']);
			http_response_code(501);
			exit();
		}
	}

	/**
	 * Verify user log in token
	 * @param  string $token
	 */
	public static function verify($token = '')
	{
		// Connect to DB
		self::connect();

		if (empty($token)) {
			echo json_encode(
				['success' => false, 'message' => 'Please provide a token']
			);

			http_response_code(400);
			exit();
		} else {

			// Select from table
			$query = 'SELECT UID FROM users WHERE token = :token';
			$statement = self::$connection->prepare($query);
			$response = $statement->execute([':token' => $token]);
			$statement = $statement->fetch(\PDO::FETCH_ASSOC);

			// Response
			if (empty($statement) || !$response) {
				echo json_encode(['success' => false, 'message' => 'token is not verified']);
				http_response_code(401);
				exit();
			} else {
				echo json_encode(['success' => true, 'user_id' => $statement['UID']]);
				http_response_code(201);
			}
		}
	}
}
