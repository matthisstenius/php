<?php
	require_once('src/model/User.php');

	$username = htmlspecialchars($_POST["username"]);
	$password = $_POST["password"];

	$user = new \model\User();
	
	if ($user->getUsername() == $username && $user->getPassword() == $password) {
		header('Location: /php/labb1/admin.php');
		exit;
	}

	else {
		// Sätt session
		header('Location: /php/labb1');
		exit;
	}
	
