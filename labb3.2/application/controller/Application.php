<?php

namespace application\controller;

require_once("application/view/View.php");
require_once("login/controller/LoginController.php");
require_once("register/controller/Register.php");
require_once("register/view/Register.php");
require_once("register/model/Register.php");


class Application {
	private $view;

	private $loginController;
	private $registerController;
	private $registerView;
	private $registerModel;
	
	public function __construct() {
		$this->registerModel = new \register\model\Register();
		$this->loginView = new \login\view\LoginView($this->registerModel);
		$this->registerView = new \register\view\Register();
	
		$this->loginController = new \login\controller\LoginController($this->loginView);
		$this->registerController = new \register\controller\Register($this->registerView, $this->registerModel);
		$this->view = new \application\view\View($this->loginView, $this->registerView);
	}
	
	public function doFrontPage() {
		if ($this->registerView->isRegistering()) {
			if ($this->registerController->registerAccount()) {
				header("Location: ?");
			}

			return $this->view->getRegisterPage();
		}

		else {
			$this->loginController->doToggleLogin();
	
			if ($this->loginController->isLoggedIn()) {
				$this->registerModel->registrationEnd();
				$loggedInUserCredentials = $this->loginController->getLoggedInUser();
				return $this->view->getLoggedInPage($loggedInUserCredentials);	
			} else {
				$this->loginView->registrationOK();
				return $this->view->getLoggedOutPage();
			}	
		}
		
	}
}
