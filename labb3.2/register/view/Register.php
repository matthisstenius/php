<?php

namespace register\view;


class Register {
	private static $register = "register";
	private static $save = "save";
	private static $name = "name";
	private static $password = "password";
	private static $passwordAgain = "passwordAgain";

	/**
	 * Message
	 * @var string
	 */
	private $messages;

	public function __construct() {
		$this->userList = new \login\model\UserList();
		$this->messages = "";
	}

	/**
	 * @return string HTML
	 */
	public function getRegisterForm() {
		$user = $this->getSanitizedName();

		$html = $this->getBackButton();

		$html .= $this->getHeader();
		$html .= "<p>Registrera ny användare skriv in användarnamn och lösenord</p>
				 <p>" . $this->messages . "</p>	
				<form action='?" . self::$register . "&" . self::$save ."' method='POST'>
					<label for='" . self::$name . "'>Namn:</label>
					<input type='text' id='" . self::$name . "' name='" . self::$name . "' value='$user'>
					<label for='" . self::$password . "'>Lösenord:</label>
					<input type='password' id='" . self::$password . "' name='" . self::$password . "'>
					<label for='" . self::$passwordAgain . "'>Lösenord igen:</label>
					<input type='password' id='" . self::$passwordAgain . "' name='" . self::$passwordAgain . "'>
					<input type='submit' value='Registrera'>
				</form>";

		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getHeader() {
		return "<h1>Ej inloggad, Registrera ny användare</h1>";
	}

	public function isRegistering() {
		return isset($_GET[self::$register]);
	}

	public function isSaving() {
		return isset($_GET[self::$save]);
	}

	/**
	 * @return string HTML
	 */
	private function getBackButton() {
		return "<a href='?'>Tillbaka</a>";
	}

	/**
	 * @return string
	 */
	public function getName() {
		if (isset($_POST[self::$name]) && strlen($_POST[self::$name])) {
			return $_POST[self::$name];
		}	
	}

	/**
	 * @return string
	 */
	public function getSanitizedName() {
		if (isset($_POST[self::$name])) {
			return \common\Filter::sanitizeString($_POST[self::$name]);
		}
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		if (isset($_POST[self::$password])) {
			return \common\Filter::sanitizeString($_POST[self::$password]);
		}
	}

	/**
	 * @return string
	 */
	public function getPasswordAgain() {
		if (isset($_POST[self::$passwordAgain])) {
			return \common\Filter::sanitizeString($_POST[self::$passwordAgain]);
		}
	}

	/**
	 * @return bool
	 */
	public function passwordsMatch() {
		if ($this->getPassword() == $this->getPasswordAgain()) {
			return true;
		}

		return false;
	}

	/**
	 * @return login\model\UserCredentials
	 */
	public function getUserCredentials() {
		return \login\model\UserCredentials::create(new \login\model\UserName($this->getName()), 
													\login\model\Password::fromCleartext($this->getPassword()));
	}

	/**
	 * @return string HTML
	 */
	public function userExists() {
		$this->messages .= "<p>Användarnamnet redan upptaget</p>";
	}
	/**
	 * @return string HTML
	 */
	public function registrationFailed() {
		if ($this->getName() == "" || strlen($this->getName()) < 3) {
			$this->messages .= "<p>Användarnamn har för få tecken. Minst 3 tecken</p>";
		}

		if (strlen($this->getName()) > 8) {
			$this->messages .= "<p>Användarnamnet har för många tecken. Max 8 tecken</p>";
		}

		if ($this->getPassword() == "" || strlen($this->getPassword()) < 6) {
			$this->messages .= "<p>Lösenordet har för få tecken. Minst 6 tecken.</p>";
		}

		if (!$this->passwordsMatch()) {
			$this->messages .= "<p>Lösenorden matchar inte</p>";
		}

		if (\common\Filter::hasTags($this->getName())) {
			$this->messages .= "Användarnamnet innehåller ogiltiga tecken";
		}
	}
}