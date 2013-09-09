<?php
	namespace view;

	class AdminPage {
		private $username;

		public function __construct($username) {
			$this->username = $username;
		}

		public function getAdminHTML() {
			return "<!DOCTYPE html>
			<html>
			<head>
				<title></title>
				<meta charset='utf-8'>
			</head>
			<body>
				<h1>$this->username är inloggad<h2>
			</body>
			</html>";
		}
	}