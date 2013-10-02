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
		$this->formView = new \view\FormHTML($this->user);
		$this->adminPage = new \view\AdminPage($this->user);
	}

	/**
	 * @return String htmlstring
	 */
	public function startApplication() {
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

	 	if ($this->formView->userLoggesIn()) {
	  		try {
	  			$this->formView->getUsername();
	  			$this->formView->getPassword();
		  		$login = new \controller\Login($this->formView, $this->adminPage, $this->user);
		  		return $login->logIn();
			}

			catch (\Exception $e) {
		  		$this->formView->setMessage();
		  		$this->formView->errorMessage = $e->getMessage();
		  	}
	  	}

	 	if (!$this->adminPage->userLoggesOut()) {
			try {
		  		$this->formView->getRememberCookie();
		  		if ($this->formView->getRememberCookie() == $this->user->token) {
		  			$this->user->setLogin();
					$this->adminPage->setCookieLoginMessage("inloggningen lyckades via cookies");
					return $this->adminPage->getAdminHTML();
		  		}
		  	}

		  	catch(\Exception $e) {
		  		$this->formView->removeRememberCookie();
			  	$this->formView->errorMessage = $e->getMessage();
		  	}	
	  	}

		return $this->formView->getFormHtml();
	}
}