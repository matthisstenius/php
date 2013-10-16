<?php

namespace login\model;


require_once("UserCredentials.php");
require_once("common/model/PHPFileStorage.php");

class UserList {
	private $adminFile;

	private $users;

	public function  __construct( ) {
		$this->users = array();
		
		$this->loadAdmin();
	}

	public function findUser($fromClient) {
		foreach($this->users as $user) {
			if ($user->isSame($fromClient) ) {
				\Debug::log("found User");
				return  $user;
			}
		}
		throw new \Exception("could not login, no matching user");
	}

	public function userExists($fromClient) {
		foreach ($this->users as $user) {
			if ($user->getUserName() == $fromClient->getUserName()) {
				return true;
			}
		}
	}

	public function update($changedUser) {
		$this->adminFile->writeItem($changedUser->getUserName(), $changedUser->toString());

		\Debug::log("wrote changed user to file", true, $changedUser);
		$this->users[$changedUser->getUserName()->__toString()] = $changedUser;
	}

	private function loadAdmin() {
		
		$this->adminFile = new \common\model\PHPFileStorage("data/admin.php");
		try {
			$adminUserString = $this->adminFile->readAll();

			foreach ($adminUserString as $value) {
				$admin = UserCredentials::fromString($value);
				$this->users[$admin->getUserName()->__toString()] = $admin;
			}
			

		} catch (\Exception $e) {
			\Debug::log("Could not read file, creating new one", true, $e);

			$userName = new UserName("Admin");
			$password = Password::fromCleartext("Password");
			$admin = UserCredentials::create( $userName, $password);
			$this->update($admin);
		}
		
	}
}