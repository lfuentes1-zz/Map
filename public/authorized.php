<?php
require_once '../lib/Auth.php';

	function checkUserStatus()
	{
		if (Auth::check() == FALSE)
		{
			header("location: login.php");
			die();
		}
	}

	function pageController(){
		session_start();
		checkUserStatus();
		$username = Auth::user();

		return array(
			'username' => $username,
		);
	}
	extract(pageController());
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h3>You are authorized to access this page!</h3>
		<h3>You are logged in as <?= $username ?>.</h3>
		<a href="logout.php">Logout</a>
 	</body>

</html>