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
		$this->adminPage = new \view\AdminPage();
		$this->formView = new \view\FormHTML();
	}

	/**
	 * @return String htmlstring
	 */
	public function startApplication() {
		if ($this->user->isLoggedIn()) {
		  	if($this->adminPage->userLoggesOut()) {
		  		$this->user->unsetLogin();
		  		$this->formView->setMessage();
		  	}

		  	else {
		  		return $this->adminPage->getAdminHTML();
		  		exit;
		  	}
	 	}

		else {
			if ($this->formView->userLoggesIn()) {
		  		try {
		  			$this->formView->getUsername();
		  			$this->formView->getPassword();
			  		$login = new \controller\Login($this->formView);
			  		return $login->logIn();
			  		exit;
				}

				catch (\Exception $e) {
			  		$this->formView->setMessage();
			  		$this->formView->errorMessage = $e->getMessage();
			  	}
		  	}
		}
		return $this->formView->getFormHtml();
	}
}