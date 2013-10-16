<?php

namespace register\model;

class Register {

	private $userList;
	private static $registrationSession = "register::model::Register";

	public function __construct() {
		$this->userList = new \login\model\UserList();
	}

	public function save($userCredentials) {
		$fileStorage = new \common\model\PHPFileStorage("data/admin.php");

		if ($this->userList->userExists($userCredentials)) {
			throw new \Exception("User allready exists");
			
		}

		$fileStorage->writeItem($userCredentials->getUserName(), $userCredentials->toString());

		$_SESSION[self::$registrationSession] = $userCredentials->getUserName();
	}

	public function registrationOK() {
		if (isset($_SESSION[self::$registrationSession])) {
			return $_SESSION[self::$registrationSession];
		}
	}

	public function registrationEnd() {
		unset($_SESSION[self::$registrationSession]);
	}
}