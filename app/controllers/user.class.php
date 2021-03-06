<?php

namespace App\Controllers;

class User extends MainController
{

	public static function get_info()
	{

		$user = new \App\Models\User();
		$user->get_info();
	}

	public static function signup()
	{

		$POST_data = self::get_POST_data();

		$email = $POST_data->email;
		$password = $POST_data->password;

		try {
			\App\Models\User::create_new($email, $password);
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function signin()
	{

		$POST_data = self::get_POST_data();

		$email = $POST_data->email;
		$password = $POST_data->password;

		\App\Models\User::signin($email, $password);
	}

	public static function verify_token()
	{

		$POST_data = self::get_POST_data();

		\App\Models\Token::verify($POST_data->token);
	}
}
