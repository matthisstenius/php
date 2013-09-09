<?php

namespace controller;

require_once("src/model/User.php");
require_once("src/view/AdminPage.php");

class Login {
	private $loginAtempt;
	private $user;

	public function __construct(\model\Login $loginAtempt) {
		$this->loginAtempt = $loginAtempt;
		$this->user = new \model\User();
	}

	/**
	 * [isLoggedIn description]
	 * @param  String  $username 
	 * @param  String  $password  
	 */
	public function isLoggedIn() {
		if ($this->loginAtempt->getUsername() != $this->user->getUsername()) {
			if (isset($_SESSION['username'])) {
				session_unset('username');
			}
			throw new \Exception("Fel användarnamn");
		}

		elseif ($this->loginAtempt->getPassword() != $this->user->getPassword()) {
			$_SESSION['username'] = $this->loginAtempt->getUsername();
			throw new \Exception("Fel lösenord");
		}

		else {
			$adminView = new \view\AdminPage($this->user->getUsername());
			echo $adminView->getAdminHTML();
		}

	}
}