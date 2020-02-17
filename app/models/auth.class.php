<?php

namespace App\Models;

class Auth
{
    /**
     * Signed in user token
     * @var string
     */
    protected $token;

    /**
     * Try to authenticate token
     * @param  object $connection DB connection
     * @return true               On success
     */
    protected function try($connection)
    {
        try {
            $POST_data = \App\Controllers\MainController::get_POST_data();
            $this->token = $POST_data->token;
        } catch (\Exception $e) {
            echo $e;
        }

        // Run query
        $query = 'SELECT token FROM users WHERE token = :token';
        $statement = $connection->prepare($query);
        $response = $statement->execute([':token' => $this->token]);
        $statement = $statement->fetch(\PDO::FETCH_ASSOC);

        if (empty($statement) || !$response) {
            echo json_encode(['success' => false, 'message' => 'not authorized']);
            http_response_code(401);
            exit();
        }

        return true;
    }
}
