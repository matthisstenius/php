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

	public function setMessage() {
		if ($this->userLoggesIn()) {
			$_SESSION[self::$sessionUsername] = true;
		}

		else {
			$_SESSION[self::$sessionLogoutMessage] = true;
		}
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
				</form>" 
				. self::getLocalDayString() . " den " . date("j") . " " 
				. self::getLocalMonthString() . " år " . date("Y") .". " 
				. " Klockan är " . date("H") . ":" . date("i") . ":" . date("s");

		return $html;
	}

	/**
	 * @return String day in swedish format
	 */
	private static function getLocalDayString() {
		switch (date("N")) {
			case "1":
				$day = "Måndag";
				break;
			case "2":
				$day = "Tisdag";
				break;
			case '3':
				$day = "Onsdag";
				break;
			case '4':
				$day = "Torsdag";
				break;
			case '5':
				$day = "Fredag";
				break;
			case '6':
				$day = "Lördag";
				break;
			case '7':
				$day = "Söndag";
				break;
			default:
				$day = "The day could not be defined";
		}

		return $day;
	}

	/**
	 * @return String month in swedish format
	 */
	private static function getLocalMonthString() {
		switch (date("n")) {
			case '1':
				$month = "Januari";
				break;
			case '2':
				$month = "Februari";
				break;
			case '3':
				$month = "Mars";
				break;
			case '4':
				$month = "April";
				break;
			case '5':
				$month = "Maj";
				break;
			case '6':
				$month = "Juni";
				break;
			case '7':
				$month = "Juli";
				break;
			case '8':
				$month = "Augusti";
				break;
			case '9':
				$month = "September";
				break;
			case '10':
				$month = "Oktober";
				break;
			case '11':
				$month = "November";
				break;
			case '12':
				$month = "December";
				break;
			default:
				$month = "The month could not be defined"; 
		}

		return $month;
	}

	/**
	 * @return String
	 * @throws Exception If username does not exists
	 */
	public function getUsername() {
		if (!isset($_POST[self::$username]) || strlen($_POST[self::$username]) == 0) {
			throw new \Exception("Användarnamn saknas");
		}

		else {
			return $this->sanitize($_POST[self::$username]);
		}
	}

	/**
	 * @return String
	 * @throws Exception If password does not exists
	 */
	public function getPassword() {
		if (!isset($_POST[self::$password]) || strlen($_POST[self::$password]) == 0) {
			throw new \Exception("Lösenord saknas");
		}

		else {
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
		setcookie(self::$rememberCookie, $this->user->token, $endtime, "/", "", false, true);
	}

	/**
	 * @return String token
	 * @throws Exception If cookie has been tempered with
	 */
	public function getRememberCookie() {
		if (isset($_COOKIE[self::$rememberCookie])) {
			$fileEndtime = file_get_contents(self::$cookieEndtimeFile);

			if ($_COOKIE[self::$rememberCookie] != $this->user->token || time() > $fileEndtime) {
				throw new \Exception("Felaktig information i cookie");
			}

			return $_COOKIE[self::$rememberCookie];
		}
	}

	public function removeRememberCookie() {
		setcookie(self::$rememberCookie, "", time() - 3600, "/", "", false, true);
	}
}