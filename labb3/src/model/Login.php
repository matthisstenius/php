<?php

namespace model;

class Login {
	/**
	 * @var String
	 */
	private $username;

	/**
	 * @var String
	 */
	private $password;

	/**
	 * @param String $username
	 * @param String $password
	 */
	public function __construct($username, $password) {
		if ($username == "") {
			throw new \Exception("Username can't be empty");
		}

		if ($password == "") {
			throw new \Exception("Password can't be empty");
		}

		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * @param model\User $user
	 * @return boolean
	 * @throws Exception If username and/or password do not match
	 */
	public function isLoginOk(\model\User $user) {
		$usernamesAreEqual = $this->username == $user->getUsername();
		$passwordsAreEqual = $this->password == $user->getPassword();
		
		if($usernamesAreEqual && $passwordsAreEqual) {
			return true;
		}

		else {
			throw new \Exception("Wrong password and/or username");	
		}
	}
}