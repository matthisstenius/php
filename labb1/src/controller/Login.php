<?php

namespace controller;

require_once("src/model/User.php");
require_once("src/view/AdminPage.php");

class Login {
	//@todo change variable name
	private $loginAtempt;
	private $user;

	/**
	 * @param model\Login $loginAtempt
	 * @todo  change param name to correspond to instance var name
	 */
	public function __construct(\model\Login $loginAtempt) {
		$this->loginAtempt = $loginAtempt;
		$this->user = new \model\User();
	}

	/**
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