<?php
namespace App\Controllers;

class MainController {

	/**
	 * Router
	 */
	public static function router() {

		$request = $_SERVER['REQUEST_URI'];

		switch ($request) {
			case '/user/new':
				self::signup();
				break;
			
			case '/user/signin':
				self::signin();
				break;

			case '/user/verify_token':
				self::verify_token();
				break;

			default:
				break;
		}

	}

}