<?php

namespace view;

class FormHTML {
	private static $username = "username";
	private static $password = "password";
	private static $rememberMe = "remember";
	private static $rememberCookie = "view::FormHTML::remember";
	private static $cookieEndtimeFile = "endtime.txt";

	private static $loginButton = "login";

	private static $sessionUsername = "view::HTMLPage::username";
	private static $sessionLogoutMessage = "view::HTMLPage::logoutMessage";

	/**
	 * @var model\User
	 */
	private $user;

	/**
	 * @var String
	 */
	public $errorMessage;

	/**
	 * @param model\User $user
	 */
	public function __construct(\model\User $user) {
		$this->user = $user;
	}

	public function setSessionMessage() {
		if ($this->userLoggesIn()) {
			$_SESSION[self::$sessionUsername] = true;
		}

		else {
			$_SESSION[self::$sessionLogoutMessage] = true;
		}
	}

	public function setLoginErrorMessage() {
		$this->errorMessage = "Användarnamn och/eller lösenord inkorrekt";
	}

	/**
	 * @return Boolean
	 */
	public function userLoggesIn() {
		return isset($_GET[self::$loginButton]);
	}

	/**
	 * @return String htmlstring
	 */
	public function getFormHtml() {
		$html = "<h1>Laboration 1 ms223cn</h1>
				<h2>Ej inloggad</h2>
				<p>Ange användarnamn samt lösenord för att logga in";

				if (isset($_SESSION[self::$sessionLogoutMessage])) {
					if ($_SESSION[self::$sessionLogoutMessage]) {
						$html .= "<p>Du har nu loggat ut</p>";
					}
					unset($_SESSION[self::$sessionLogoutMessage]);
				}
				
				$html .= "<p>$this->errorMessage</p>
				<form action='?" . self::$loginButton . "' method='POST'>
					<label for='" . self::$username . "'>Username:</label>
					<input id='" . self::$username . "' name='" . self::$username . "' 
					type='text' value='";

					if (isset($_SESSION[self::$sessionUsername])) {
						if ($_SESSION[self::$sessionUsername]) {
							try {
								$html .=  $this->getUsername();	
							}

							catch (\Exception $e) {

							}
						}
					}

					$html .= "'>
					<label for='" . self::$password ."'>Password:</label>
					<input id='" . self::$password ."' name='" . self::$password ."' 
					type='password'>
					<label for='remember'>Kom ihåg mig</label>
					<input type='checkbox' id='remember' name='remember'>
					<input type='submit' value='Log in' name='" . self::$loginButton . "'>
				</form>";

		return $html;
	}

	/**
	 * @return Boolean
	 */
	public function usernameHasValue() {
		if (isset($_POST[self::$username]) && strlen($_POST[self::$username]) > 0) {
			return true;
		}

		$this->errorMessage = "Användarnamn sakans";
		return false;
	}

	/**
	 * @return Boolean
	 */
	public function passwordHasValue() {
		if (isset($_POST[self::$password]) && strlen($_POST[self::$password]) > 0) {
			return true;
		}

		$this->errorMessage = "Lösenord saknas";
		return false;
	}

	/**
	 * @return String
	 */
	public function getUsername() {
		if ($this->usernameHasValue()) {
			return $this->sanitize($_POST[self::$username]);
		}
	}

	/**
	 * @return String
	 */
	public function getPassword() {
		if ($this->passwordHasValue()) {
			return $this->sanitize($_POST[self::$password]);
		}
	}

	/**
	 * @param  String $input
	 * @return String Sanitized string
	 */
	private function sanitize($input) {
		return html_entity_decode(trim($input));
	}

	/**
	 * @return boolean
	 */
	public function getRememberMe() {
		return isset($_POST[self::$rememberMe]);
	}

	public function setRememberCookie() {
		$endtime = time() + 60 * 60 * 24 * 25;
		file_put_contents(self::$cookieEndtimeFile, "$endtime");
		setcookie(self::$rememberCookie, $this->user->token, $endtime);
	}

	public function hasRememberCookie() {
		return isset($_COOKIE[self::$rememberCookie]);
	}

	/**
	 * @return String token
	 * @throws Exception If cookie has been tempered with
	 */
	public function getRememberCookie() {
		if ($this->hasRememberCookie()) {
			$fileEndtime = file_get_contents(self::$cookieEndtimeFile);

			if ($_COOKIE[self::$rememberCookie] != $this->user->token || time() > $fileEndtime) {
				$this->errorMessage = "Felaktig information i cookie"; 
				throw new \Exception("Cookie has been tempered with");
			}

			return $_COOKIE[self::$rememberCookie];
		}
	}

	public function removeRememberCookie() {
		setcookie(self::$rememberCookie, "", time() - 3600);
	}
}