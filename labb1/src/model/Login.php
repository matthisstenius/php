<?php

namespace model;

class Login {
	private $username;
	private $password;

	/**
	 * @param view\HTMLPage $htmlview
	 */
	public function __construct(\view\HTMLPage $htmlView) {
		if (strlen($htmlView->getUsername()) == 0) {
			throw new \Exception("Användarnamn saknas");
		}

		elseif (strlen($htmlView->getPassword()) == 0) {
			$_SESSION['username'] = $htmlView->getUsername();
			throw new \Exception("Lösenord saknas");
		}

		$this->username = htmlspecialchars($htmlView->getUsername());
		$this->password = htmlspecialchars($htmlView->getPassword());
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}
}