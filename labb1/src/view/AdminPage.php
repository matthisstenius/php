<?php
	namespace view;

	class AdminPage {
		private $username;

		public function __construct($username) {
			$this->username = $username;
		}

		/** 
		 * @return Boolean
		 */
		private function getSessionValue() {
			if (isset($_SESSION['welcomeMessage'])) {
				return $_SESSION['welcomeMessage'];
			}
		}

		/**
		 * @return String
		 */
		public function getAdminHTML() {
			return "<!DOCTYPE html>
			<html>
			<head>
				<title></title>
				<meta charset='utf-8'>
			</head>
			<body>
				<h1>$this->username är inloggad</h1>
				<p>". $this->getSessionValue() ."</p>
				<a href='?logout'>Logga ut</a>
			</body>
			</html>";
		}
	}