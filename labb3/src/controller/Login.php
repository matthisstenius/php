<?php

namespace controller;

require_once("src/model/User.php");
require_once("src/view/AdminPage.php");
require_once("src/model/Login.php");

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
	 * @var view\AdminPage $adminView
	 */
	private $adminView;

	/**
	 * @param view\FormHTML $formView
	 * @param view\Adminpage $adminView
	 * @param model\User $user
	 */
	public function __construct(\view\FormHTML $formView, \view\AdminPage $adminView, \model\User $user) {
		$this->formView = $formView;
		$this->adminView = $adminView;

		$this->user = $user;
	}

	/**
	 * @return String htmlstring
	 */
	public function logIn() {
		$login = new \model\Login($this->formView->getUsername(), $this->formView->getPassword());
		try {
			if ($login->isLoginOk($this->user)) {
				if ($this->formView->getRememberMe()) {
					$this->formView->setRememberCookie();
					$this->adminView->setCookieLoginMessage();
				}

				$this->user->setLogin();
				$this->adminView->setMessage();
				return $this->adminView->getAdminHTML();
			}	
		}
		
		catch (\Exception $e) {
			$this->formView->setSessionMessage();
			$this->formView->setLoginErrorMessage();
			return $this->formView->getFormHtml();
		}
	}

	/**
	 * @return String HTML
	 */
	public function loginWithCookie() {
		try {
	  		$this->formView->getRememberCookie();
	  		
	  		if ($this->formView->getRememberCookie() == $this->user->token) {
	  			$this->user->setLogin();
				$this->adminView->setCookieLoginMessage();
				return $this->adminView->getAdminHTML();
	  		}
	  	}

	  	catch(\Exception $e) {
	  		$this->formView->removeRememberCookie();
		  	return $this->formView->getFormHtml();
	  	}	
	}
}