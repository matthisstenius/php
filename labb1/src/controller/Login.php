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
	 * @var view\AdminPafe $adminView
	 */
	private $adminView;

	/**
	 * @param view\FormHTML $formView
	 * @param view\Adminpage $adminView
	 * @param model\User $user
	 */
	public function __construct(\view\FormHTML $formView, \view\AdminPage $adminView, \model\User $user) {
		$this->formView = $formView;
		$this->user = $user;
		$this->adminView = $adminView;
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
			if ($this->formView->getRememberMe()) {
				$this->formView->setRememberCookie();
				$this->adminView->setCookieLoginMessage("inloggningen lyckades och vi kommer ihåg dig till nästa gång");
			}

			$this->user->setLogin();
			$this->adminView->setMessage();
			return $this->adminView->getAdminHTML();
		}
	}
}