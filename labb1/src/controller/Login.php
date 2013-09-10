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
		if ($this->loginAtempt->getUsername() != $this->user->getUsername() || $this->loginAtempt->getPassword() != $this->user->getPassword()) {
			$_SESSION['username'] = $this->loginAtempt->getUsername();
			throw new \Exception("Fel användarnamn och/eller lösenord");
		}

		else {
			if (isset($_SESSION['username'])) {
				unset($_SESSION['username']);
			}

			$adminView = new \view\AdminPage($this->user->getUsername());
			$_SESSION['user'] = $this->user->getUsername();
			$_SESSION['welcomeMessage'] = "inloggningen lyckades!";
			echo $adminView->getAdminHTML();
		}

	}
}