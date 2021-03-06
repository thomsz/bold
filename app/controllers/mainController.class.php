<?php

namespace App\Controllers;

class MainController
{

	/**
	 * Router
	 */
	public static function router()
	{

		$request = $_SERVER['REQUEST_URI'];

		define('PREFIX', '/api');

		switch ($request) {
			case PREFIX . '/user/new':
				self::signup();
				break;

			case PREFIX . '/user/signin':
				self::signin();
				break;

			case PREFIX . '/user/verify_token':
				self::verify_token();
				break;

			case PREFIX . '/user/info':
				self::info();
				break;

			default:
				break;
		}
	}

	/**
	 * Get POSTed data
	 * @return array
	 */
	public static function get_POST_data()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$inputJSON = file_get_contents('php://input');
			return json_decode($inputJSON);
		}

		http_response_code(405);
		exit();
	}

	/**
	 * User info controller
	 */
	private static function info()
	{
		User::get_info();
	}

	/**
	 * Signup controller
	 */
	private static function signup()
	{
		User::signup();
	}

	/**
	 * Signin controller
	 */
	private static function signin()
	{
		User::signin();
	}

	/**
	 * Verify_token controller
	 */
	private static function verify_token()
	{
		User::verify_token();
	}
}
