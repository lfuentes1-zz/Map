<?php 
require_once '../lib/Input.php';
require_once '../lib/Auth.php';

	function pageController(){
		session_start();
		
		$message = "";
		$username = "";
		$_SESSION['LOGGED_IN_USER'] = FALSE;

		if (isset($_POST['username']) && isset($_POST['password']))
		{ //use the wrapper class for line#13
			$username = Input::escape($_POST['username']);
			$password = Input::escape($_POST['password']);

			if (Auth::attempt($username, $password) || Auth::check())
			{ 
				$username = Input::get($_SESSION['username']);
				header("location: authorized.php");
				die ();
			} else {
				$message = "Input a valid username and password!";
			}
		}

		return array (
			'username' => $username,
			'message'  => $message
			);
	}
	extract(pageController());
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<br>
		<!-- name=name of the form
		method=HTTP method used when sending form-data
		action=specifies where to submit form-data when submitted -->
		<form name="verify" method="POST" action="login.php">
			<p>
				<!-- for=specifies which form element a label is bound to?
				form=specifies form/s label belongs to -->
				<label for="username" form="verify">Username</label>
				<!-- type=specifies the type<input>element to display
				name=specifies the name of the input element -->
				<input type="text" name="username" id="username" value="<?= $username ?>"><br>
			</p>
			<p>
				<label for="password" form="verify">Password</label>
				<input type="password" name="password" id="password"><br>
			</p>
			<!--
			type=specifies the type of button
			name=specifies the name for the button
			value=specifies the initial value for the button -->
			<button type="submit" name="send" id="send" value="submit">Submit</button>
		</form>
		<h2><?= $message ?></h2>
	</body>
</html>