<?php

/**
 * Autoload classes
 */
spl_autoload_extensions('.class.php');
spl_autoload_register();

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

/**
 * Router
 */
App\Controllers\MainController::router();
