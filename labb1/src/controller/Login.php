<?php

namespace controller;

require_once("src/model/User.php");
require_once("src/view/AdminPage.php");

class Login {
	/**
	 * @var model\Login $login
	 */
	private $login;

	/**
	 * @var model\User $user
	 */
	private $user;

	/**
	 * @var view\HTMLPage $htmlPage
	 */
	private $formView;

	/**
	 * @param view\FormHTML $formView
	 */
	public function __construct(\view\FormHTML $formView) {
		$this->formView = $formView;
		$this->user = new \model\User();
	}

	/**
	 * @return String htmlstring
	 * @throws Exception If username and/or passwoed does not match
	 */
	public function logIn() {
		if ($this->formView->getUsername() != $this->user->getUsername() 
			|| $this->formView->getPassword() != $this->user->getPassword()) {
			
			$this->formView->setMessage();
			throw new \Exception("Fel användarnamn och/eller lösenord");
		}

		else {
			$this->user->setLogin();
			$adminView = new \view\AdminPage($this->user->getUsername());
			$adminView->setMessage();
			return $adminView->getAdminHTML();
		}
	}
}