<?php
namespace App\Models;

/**
 * User token
 */
class Token extends Database {
	
	private $user_id;

	public function __construct(int $user_id) {

		$this->user_id = $user_id;

	}

	/**
	 * Generate a login token
	 * @return string|false The token on success, otherwise false
	 */
	public function generate() {

		// Generate token
		$token = uniqid();

		// Connect to database
		$connection = self::connect();

		// Insert token to Users DB table
		$query = 'UPDATE users SET token = :token WHERE UID = :user_id';
		$statement = $connection->prepare($query);
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
	public static function verify($token = '') {

		if (empty($token)) {
			echo json_encode(
				['success' => false, 'message' => 'Please provide a token']
			);

			http_response_code(400);
			exit();
		} else {

			// Connect to DB
			$connection = self::connect();

			// Select from table
			$query = 'SELECT UID FROM users WHERE token = :token';
			$statement = $connection->prepare($query);
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