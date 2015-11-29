<?php

require_once '../public/php/Log.php';

class Auth {

	public static $password = '$2y$10$SLjwBwdOVvnMgWxvTI4Gb.YVcmDlPTpQystHMO2Kfyi/DS8rgA0Fm';

	public static function attempt ($username, $password){
		$logger = new Log('../public/data/log');

		if (($username === 'guest') && (password_verify($password, self::$password)))
		{
			$_SESSION['LOGGED_IN_USER'] = TRUE;
			$_SESSION['username'] = $username;
			$logger->info("User {$username} logged in.");
			return TRUE;
		} else {
			$logger->info("User {$username} failed to log in.");
			return FALSE;
		}
	}

	public static function check (){
		return ($_SESSION['LOGGED_IN_USER']) ? TRUE : FALSE; //should I have isset in the condition
	}

	public static function user (){
		return ($_SESSION['username']);
	}

	public static function logout(){
		if (isset($_SESSION['LOGGED_IN_USER']))
		{
			unset($_SESSION['LOGGED_IN_USER']);
		}
	}
}