<?php

namespace register\controller;

require_once("register/model/Register.php");

class Register {
	/**
	 * @var \register\view\Register
	 */
	private $registerView;

	/**
	 * @var register\model
	 */
	private $registerModel;

	/**
	 * @param register\view\Register  $registerView 
	 * @param register\Model\Register $registerModel
	 */
	public function __construct(\register\view\Register $registerView, \register\Model\Register $registerModel) {
		$this->registerView = $registerView;
		$this->registerModel = $registerModel;
	}

	/**
	 * @return bool
	 */
	public function registerAccount() {
		if ($this->registerView->isSaving()) {
			if ($this->registerView->passwordsMatch()) {
				try {
					$credentials = $this->registerView->getUserCredentials();
					$this->registerModel->save($credentials);
					return true;
				}

				catch (\Exception $e) {
					//@todo this stinks but running out of time...
					if ($e->getCode() == 1) {
						$this->registerView->userExists();
					}

					else {
						$this->registerView->registrationFailed();
					}
				}	
			}

			else {
				$this->registerView->registrationFailed();
			}
		}

		return false;
	}
};