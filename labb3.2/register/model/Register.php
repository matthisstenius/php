<?php

namespace register\model;

class Register {
	/**
	 * @var login\model
	 */
	private $userList;

	private static $registrationSession = "register::model::Register";

	public function __construct() {
		$this->userList = new \login\model\UserList();
	}

	/**
	 * @param  login\model\UserCredentials $userCredentials
	 * @return void
	 */
	public function save($userCredentials) {
		$fileStorage = new \common\model\PHPFileStorage("data/admin.php");

		if ($this->userList->userExists($userCredentials)) {
			throw new \Exception("User allready exists", 1);
		}

		$fileStorage->writeItem($userCredentials->getUserName(), $userCredentials->toString());

		$_SESSION[self::$registrationSession] = $userCredentials->getUserName();
	}

	/**
	 * @return void
	 */
	public function registrationOK() {
		if (isset($_SESSION[self::$registrationSession])) {
			return $_SESSION[self::$registrationSession];
		}
	}

	/**
	 * @return void
	 */
	public function registrationEnd() {
		unset($_SESSION[self::$registrationSession]);
	}
}