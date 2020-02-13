<?php
/**
 * Autoload classes
 */
spl_autoload_extensions('.class.php');
spl_autoload_register();

header('Content-Type: application/json;charset=utf-8');

/**
 * Router
 */
App\Controllers\MainController::router();