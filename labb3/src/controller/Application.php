<?php
namespace controller;

require_once("src/view/FormHTML.php");
require_once("src/controller/Login.php");
require_once("src/view/AdminPage.php");
require_once("src/view/SessionProtect.php");

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

	/**
	 * @var view\SessionProtect
	 */
	private $sessionProtect;

	/**
	 * @var controller\Login
	 */
	private $login;

	public function __construct() {
		$this->user = new \model\User();

		$this->formView = new \view\FormHTML($this->user);
		$this->adminPage = new \view\AdminPage($this->user);
		$this->sessionProtect = new \view\SessionProtect();

		$this->login = new \controller\Login($this->formView, $this->adminPage, $this->user);
	}

	/**
	 * @return String htmlstring
	 */
	public function startApplication() {
		try {
			$this->sessionProtect->checkSessionTheft();
		}

		catch (\Exception $e) {
			return $this->formView->getFormHtml();
		}

		if ($this->adminPage->userLoggesOut() && $this->user->isLoggedIn()) {
		  	$this->user->unsetLogin();
		  	$this->formView->removeRememberCookie();
		  	$this->formView->setSessionMessage();
	 	}

	 	try {
	 		if ($this->formView->userLoggesIn() && $this->formView->usernameHasValue() 
	 			&& $this->formView->passwordHasValue()) {
		  		return $this->login->logIn();
			}
	  	}

	  	catch (\Exception $e) {

		}

	  	if (!$this->adminPage->userLoggesOut() && $this->formView->hasRememberCookie()) {
	  		return $this->login->loginWithCookie();
	  	}

		return $this->formView->getFormHtml();
	}
}