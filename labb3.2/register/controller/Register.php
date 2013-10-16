<?php

namespace register\controller;

require_once("register/model/Register.php");

class Register {
	/**
	 * @var \register\view\Register
	 */
	private $registerView;

	public function __construct(\register\view\Register $registerView, \register\Model\Register $registerModel) {
		$this->registerView = $registerView;
		$this->registerModel = $registerModel;
	}

	//@todo login after succsessful registration
	public function registerAccount() {
		if ($this->registerView->isSaving()) {
			if ($this->registerView->passwordsMatch()) {
				try {
					$credentials = $this->registerView->getUserCredentials();
					$this->registerModel->save($credentials);
					return true;
				}

				catch (\Exception $e) {
					var_dump($e->getMessage());
					$this->registerView->registrationFailed();
				}	
			}

			else {
				$this->registerView->registrationFailed();
			}
		}

		return false;
	}
};