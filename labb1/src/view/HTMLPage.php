<?php
	namespace view;

	class HTMLPage {
		private static $username = "username";
		private static $password = "password";

		public function __construct() {
			if (isset($_SESSION['username'])) {
				session_unset('username');
			}
		}

		/**
		 * @return Boolean
		 */
		private function getSessionUsername() {
			if (isset($_SESSION['username'])) {
				return $_SESSION['username'];
			}
		}

		/**
		 * @param String $title
		 * @param String $body html body
		 * @return String, html string
		 */
		public function getHTML($title, $message) {
			return "<!DOCTYPE html>
			<html lang='sv'>
			<head>
				<title>$title</title>
				<meta charset='utf-8'>
			</head>
			<body>
				<h1>Laboration 1 ms223cn</h1>
				<h2>Ej inloggad</h2>
				<p>$message</p>
				<form action='?login' method='POST'>
					<label for='username'>Username:</label>
					<input id='username' name='" . self::$username . "' type='text' value='" . $this->getSessionUsername() . "'>

					<label for='password'>Password:</label>
					<input id='password' name='" . self::$password ."' type='password'>

					<input type='submit' value='Log in' name='login'>
				</form>" 
				. self::getDateString() . 
			"</body>
			</html>";
		}

		/**
		 * @return [String] Datestring in swedish format
		 */
		private static function getDateString() {

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

			}

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
			}

			return $day . " den " . date("j") . " " . $month . " år " . date("Y") . ". " . " Klockan är " . date("H") . ":" . date("i") . ":" . date("s");
		}

		/**
		 * @return String
		 */
		public function getUsername() {
			if (isset($_POST[self::$username])) {
				return trim($_POST[self::$username]);
			}
		}

		/**
		 * @return String
		 */
		public function getPassword() {
			if (isset($_POST[self::$password])) {
				return trim($_POST[self::$password]);
			}
		}

	}


