<?php
namespace controller;

require_once("src/view/FormHTML.php");
require_once("src/controller/Login.php");
require_once("src/view/AdminPage.php");

class Application {
	/**
	 * @var model\User
	 */
	private $user;

	/**
	 * @var view\AdminPage
	 */
	private $adminPage;

	/**
	 * @var view\FormHTML
	 */
	private $formView;

	public function __construct() {
		$this->user = new \model\User();
		$this->formView = new \view\FormHTML();
		$this->adminPage = new \view\AdminPage();
	}

	/**
	 * @return String htmlstring
	 */
	public function startApplication() {
		if ($this->formView->getRememberCookie() == $this->user->token && !$this->adminPage->userLoggesOut()) {
			$this->user->setLogin();
			$this->adminPage->setCookieLoginMessage();
			return $this->adminPage->getAdminHTML();
		}

		else {
			if ($this->user->isLoggedIn()) {
			  	if($this->adminPage->userLoggesOut()) {
			  		$this->user->unsetLogin();
			  		$this->formView->removeRememberCookie();
			  		$this->formView->setMessage();
			  	}

			  	else {
			  		return $this->adminPage->getAdminHTML();
			  	}
		 	}

			else {
				if ($this->formView->userLoggesIn()) {
			  		try {
			  			$this->formView->getUsername();
			  			$this->formView->getPassword();
				  		$login = new \controller\Login($this->formView);
				  		return $login->logIn();
					}

					catch (\Exception $e) {
				  		$this->formView->setMessage();
				  		$this->formView->errorMessage = $e->getMessage();
				  	}
			  	}
			}
		}

		return $this->formView->getFormHtml();
	}
}