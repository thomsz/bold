<?php

namespace App\Models;

class Auth
{
    protected $token;

    protected function try($connection)
    {
        try {
            $POST_data = \App\Controllers\MainController::get_POST_data();
            $this->token = $POST_data->token;
        } catch (\Exception $e) {
            echo $e;
        }

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
